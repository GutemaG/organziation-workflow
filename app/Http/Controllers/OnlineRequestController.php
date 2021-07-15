<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Rule;
use App\Models\OnlineRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class OnlineRequestController extends Controller
{
    /**
     * Check if user is authenticated. If not redirect it login page.
     *
     * OnlineRequestController constructor.
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * check if authenticated user is admin or staff.
     * if not return with unauthorized error message.
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function isAuthorized(){return false;
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        else
            return null;
    }

    private function badRequestResponse() {
        return response()->json([
            'status' => 400,
            'error' => [
                'error' => ['Online request doesn\'t exist.']
            ]
        ]);
    }

    /**
     * return a listing of the online request.
     * it contains oll relation ship (prerequisiteLabel, onlineRequestProcedure and users).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

        $data =  $request->all();
        $validator = Validator::make($data, Rule::onlineRequest());
        if ($validator->fails())
            return response()->json([
                'status' => 400,
                'error' => $validator->errors(),
            ]);

        try {
            $data = $validator->validate();
            DB::beginTransaction();
            $onlineRequest = User::find(1)->onlineRequests()->create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);
            foreach ($data['online_request_procedures'] as $value)
                $procedure = $onlineRequest->onlineRequestProcedures()->create($value);

                foreach ($value['responsible_user_id'] as $item)
                    $procedure->users()->attach($item['user_id']);

            foreach ($data['prerequisite_labels'] as $label)
                $onlineRequest->prerequisiteLabels()->create($label);

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
     * Display the specified online request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

        $onlineRequest = OnlineRequest::find($id);
        if (empty($onlineRequest))
            return $this->badRequestResponse();
        else {
            return response()->json([
                'status' => 200,
                'online_request' => $onlineRequest,
            ]);
        }
    }

    public function update(Request $request, $id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

        $onlineRequest = OnlineRequest::find($id);
        if (empty($onlineRequest))
            return $this->badRequestResponse();


    }

    /**
     * soft delete the specified online request from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

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
