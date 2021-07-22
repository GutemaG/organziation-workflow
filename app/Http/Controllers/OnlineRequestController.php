<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Utilities\Rule;
use App\Http\Requests\OnlineRequestRequest;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\PrerequisiteLabel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class OnlineRequestController extends Controller
{
    /**
     * Check if user is authenticated. If not redirect it login page.
     * And check if authenticated user is authorized. If not throw UnauthorizedException.
     *
     * OnlineRequestController constructor.
     * @throws UnauthorizedException
     */
    public function __construct() {
        $this->middleware('auth');
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            throw new UnauthorizedException();
    }

    private function badRequestResponse() {
        return response()->json([
            'status' => 400,
            'error' => [
                'error' => ['Bad Request.']
            ]
        ]);
    }

    /**
     * return a listing of the online request.
     * it contains oll relation ship (prerequisiteLabel, onlineRequestProcedure and users).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $onlineRequests = OnlineRequest::orderBy('name', 'asc')->get();
        return response()->json([
            'status' => 200,
            'online_requests' => $onlineRequests,
        ]);
    }

    /**
     * Store a newly created online request in storage.
     * Create new online request procedure using the newly created online request.
     * Create new prerequisite label using the newly created online request.
     * Attach each user to the procedure he/she is responsible using the newly created online request procedure.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(OnlineRequestRequest $request): JsonResponse
    {
        $data = $request->validated();
dd($data);
        try {
            DB::beginTransaction();
            $onlineRequest = auth()->user()->onlineRequests()->create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);
            foreach ($data['online_request_procedures'] as $value) {
                $procedure = $onlineRequest->onlineRequestProcedures()->create($value);

                foreach ($value['responsible_user_id'] as $item)
                    $procedure->users()->attach($item);
            }
            foreach ($data['prerequisite_labels'] as $label)
                $onlineRequest->prerequisiteLabels()->create(['label' => $label]);

//            DB::commit();
            return response()->json([
                'status' => 201,
                'online_request' => $onlineRequest,
            ]);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'status' => 400,
               'error' => [
                   'error' => ['Error occur while creating please retry again.',$e]
               ]
            ]);
        }
    }

    /**
     * Display the specified online request.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id) {
        $onlineRequest = OnlineRequest::find($id);
        if (empty($onlineRequest))
            return $this->badRequestResponse();
        else
            return response()->json([
                'status' => 200,
                'online_request' => $onlineRequest,
            ]);
    }

    public function update(OnlineRequestRequest $request, OnlineRequest $onlineRequest) {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $onlineRequest->update([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);
            foreach ($data['online_request_procedures'] as $value) {
                $procedure = OnlineRequestProcedure::find($value['id']);

                foreach ($value['responsible_user_id'] as $item) {
                    $update = true;
                    foreach($procedure->users as $user){
                        if($user->pivot->user_id == $item) {
                            $update = false;
                            break;
                        }
                        continue;
                    }
                    if ($update)
                        $procedure->users()->attach($item);
                }
            }
           if (array_key_exists('prerequisite_labels', $data))
                foreach ($data['prerequisite_labels'] as $label) {
                    $prerequisite = PrerequisiteLabel::find($label['id']);
                    $prerequisite->update($label);
                }
            DB::commit();
            return response()->json([
                'status' => 201,
                'online_request' => OnlineRequest::find($onlineRequest->id),
            ]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'error' => [
                    'error' => ['Error occur while creating please retry again.',$e]
                ]
            ]);
        }

    }

    /**
     * soft delete the specified online request from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id) {
        $onlineRequest = OnlineRequest::withOut(['onlineRequestProcedures','prerequisiteLabels',])->find($id);
        if (empty($onlineRequest))
            return $this->badRequestResponse();
        else {
            $onlineRequest->delete();
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
