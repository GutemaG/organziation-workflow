<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\OnlineRequestRequest;
use App\Models\OnlineRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OnlineRequestController extends Controller
{
    /**
     * check if user is authorized to do the requested action.
     *
     * @return bool
     * @throws UnauthorizedException
     */
    protected function isAuthorized(): bool
    {
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            throw new UnauthorizedException();
        return true;
    }
    /**
     * return a listing of the online request.
     * it contains oll relation ship (prerequisiteLabel, onlineRequestProcedure and users).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $onlineRequests = OnlineRequest::with(['onlineRequestProcedures', 'prerequisiteLabels'])->orderBy('name', 'asc')->get();
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
     * @param OnlineRequestRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(OnlineRequestRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $onlineRequest = auth()->user()->onlineRequests()->create([
                'name' => $data['name'],
                'type' => $data['type'],
                'description' => $data['description'],
            ]);

            if (! OnlineRequestProcedureController::storeOrUpdateData($data, $onlineRequest->id, false))
                throw new DatabaseException('Error occurred during procedure creating. Please retry again.');

            if (! OnlinePrerequisiteController::storeOrUpdateData($data, $onlineRequest->id, false))
                throw new DatabaseException('Error occurred during prerequisite creating. Please retry again.');

            DB::commit();
            return response()->json([
                'status' => 201,
                'online_request' => OnlineRequest::with(['onlineRequestProcedures', 'prerequisiteLabels'])->find($onlineRequest->id),
            ]);

        }
        catch (DatabaseException $exception){
            DB::rollBack();
            return $exception->render($request);
        }
        catch (Exception $e) {
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
     * @param OnlineRequest $onlineRequest
     * @return JsonResponse
     */
    public function show(OnlineRequest $onlineRequest): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'online_request' => $onlineRequest,
        ]);
    }

    public function update(OnlineRequestRequest $request, OnlineRequest $onlineRequest): JsonResponse
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $onlineRequest->update([
                'name' => $data['name'],
                'type' => $data['type'],
                'description' => $data['description'],
            ]);
            if (! OnlineRequestProcedureController::storeOrUpdateData($data, $onlineRequest->id, true))
                throw new DatabaseException('Error occurred during procedure updating. Please retry again.');

            if (! OnlinePrerequisiteController::storeOrUpdateData($data, $onlineRequest->id, true))
                throw new DatabaseException('Error occurred during prerequisite updating. Please retry again.');

            DB::commit();
            return response()->json([
                'status' => 200,
                'online_request' => OnlineRequest::with(['onlineRequestProcedures.users', 'prerequisiteLabels'])->find($onlineRequest->id),
            ]);
        }
        catch (DatabaseException $exception){
            DB::rollBack();
            return $exception->render($request);
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
     * @param OnlineRequest $onlineRequest
     * @return JsonResponse
     * @throws UnauthorizedException
     */
    public function destroy(OnlineRequest $onlineRequest): JsonResponse
    {
        if ($this->isAuthorized()) {
            $onlineRequest->delete();
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
