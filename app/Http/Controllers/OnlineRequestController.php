<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Actions\OnlineRequestAction;
use App\Http\Requests\OnlineRequestRequest;
use App\Models\OnlineRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OnlineRequestController extends Controller
{
    /**
     * return a listing of the online request.
     * it contains oll relation ship (prerequisiteLabel, onlineRequestProcedure and users).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return OnlineRequestAction::index();
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
        return OnlineRequestAction::store($data);
    }

    /**
     * Display the specified online request.
     *
     * @param OnlineRequest $onlineRequest
     * @return JsonResponse
     */
    public function show(OnlineRequest $onlineRequest): JsonResponse
    {
        return OnlineRequestAction::show($onlineRequest);
    }

    public function update(OnlineRequestRequest $request, OnlineRequest $onlineRequest): JsonResponse
    {
        $data = $request->validated();
        return OnlineRequestAction::update($data, $onlineRequest);
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
        return OnlineRequestAction::destroy($onlineRequest);
    }
}
