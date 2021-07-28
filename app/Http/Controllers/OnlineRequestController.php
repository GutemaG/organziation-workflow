<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\OnlineRequestRequest;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OnlineRequestController extends Controller
{
    /**
     * Check if user is authenticated. If not redirect it login page.
     * And check if authenticated user is authorized. If not throw UnauthorizedException.
     *
     * OnlineRequestController constructor.
     * @throws UnauthorizedException
     */
    public function __construct()
    {
        $this->middleware('auth');
        if (!Gate::any(['is-admin', 'is-it-team-member']))
            throw new UnauthorizedException();
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
                'description' => $data['description'],
            ]);

            if (!OnlineRequestProcedureController::storeOrUpdateData($data, $onlineRequest->id, false))
                throw new DatabaseException('Error occurred during procedure creating. Please retry again.');

            if (!OnlinePrerequisiteController::storeOrUpdateData($data, $onlineRequest->id, false))
                throw new DatabaseException('Error occurred during prerequisite creating. Please retry again.');

            DB::commit();
            return response()->json([
                'status' => 201,
                'online_request' => OnlineRequest::find($onlineRequest->id),
            ]);
        } catch (DatabaseException $exception) {
            DB::rollBack();
            return $exception->render($request);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'error' => [
                    'error' => ['Error occur while creating please retry again.', $e]
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
                'description' => $data['description'],
            ]);
            if (!OnlineRequestProcedureController::storeOrUpdateData($data, $onlineRequest->id, true))
                throw new DatabaseException('Error occurred during procedure updating. Please retry again.');

            if (!OnlinePrerequisiteController::storeOrUpdateData($data, $onlineRequest->id, true))
                throw new DatabaseException('Error occurred during prerequisite updating. Please retry again.');

            DB::commit();
            return response()->json([
                'status' => 200,
                'online_request' => $onlineRequest->refresh(),
            ]);
        } catch (DatabaseException $exception) {
            DB::rollBack();
            return $exception->render($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'error' => [
                    'error' => ['Error occur while creating please retry again.', $e]
                ]
            ]);
        }
    }

    /**
     * soft delete the specified online request from storage.
     *
     * @param OnlineRequest $onlineRequest
     * @return JsonResponse
     */
    public function destroy(OnlineRequest $onlineRequest): JsonResponse
    {
        $onlineRequest->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
