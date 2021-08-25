<?php


namespace App\Http\Controllers\Actions;


use App\Exceptions\DatabaseException;
use App\Models\OnlineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OnlineRequestAction
{
    use MyJsonResponse;

    private static array $with = ['onlineRequestProcedures.users', 'onlineRequestPrerequisiteNotes', 'onlineRequestPrerequisiteInputs'];

    public static function index(): JsonResponse
    {
        $onlineRequests = OnlineRequest::with(self::$with)->orderBy('name', 'asc')->get()->toArray();
        $onlineRequests = self::formatResponseData($onlineRequests);
        return self::successResponse(['online_requests' => $onlineRequests]);
    }

    public static function store(array $data): JsonResponse
    {
        try {
            DB::beginTransaction();
            $onlineRequest = auth()->user()->onlineRequests()->create([
                'name' => $data['name'],
                'type' => $data['type'],
                'description' => $data['description'],
            ]);
            OnlineRequestProcedureAction::storeData($data, $onlineRequest->id);
            OnlineRequestPrerequisiteNoteAction::storeData($data, $onlineRequest->id);
            OnlineRequestPrerequisiteInputAction::storeData($data, $onlineRequest->id);
            $onlineRequest = OnlineRequest::with(self::$with)->find($onlineRequest->id)->toArray();
            DB::commit();
            return self::successResponse(['online_request' => $onlineRequest], 201);
        }
        catch (DatabaseException $exception){
            DB::rollBack();
            return $exception->render();
        }
        catch (Exception $e) {
            DB::rollBack();
            return self::badResponse(['error' => ['Error occur while creating please retry again.', $e]]);
        }
    }

    public static function update(array $data, OnlineRequest $onlineRequest): JsonResponse
    {
        try {
            DB::beginTransaction();
            $onlineRequest->update([
                'name' => $data['name'],
                'type' => $data['type'],
                'description' => $data['description'],
            ]);
            OnlineRequestProcedureAction::updateData($data, $onlineRequest->id);
            OnlineRequestPrerequisiteInputAction::updateData($data, $onlineRequest->id);
            OnlineRequestPrerequisiteNoteAction::updateData($data, $onlineRequest->id);
//            dd('');
//            if (! OnlinePrerequisiteController::storeOrUpdateData($data, $onlineRequest->id, true))
//                throw new DatabaseException('Error occurred during prerequisite updating. Please retry again.');

            DB::commit();
            return response()->json([
                'status' => 200,
                'online_request' => OnlineRequest::with(self::$with)->find($onlineRequest->id),
            ]);
        }
        catch (DatabaseException $exception){
            DB::rollBack();
            return $exception->render();
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

    public static function show(OnlineRequest $onlineRequest): JsonResponse
    {
        $onlineRequest = OnlineRequest::with(self::$with)->find($onlineRequest->id)->toArray();
        return self::successResponse(['online_request' => $onlineRequest]);
    }

    public static function destroy(OnlineRequest $onlineRequest): JsonResponse
    {
        foreach ($onlineRequest->onlineRequestProcedures as $procedure){
            $procedure->users()->delete();
        }
        $onlineRequest->onlineRequestProcedures()->delete();
        $onlineRequest->onlineRequestPrerequisiteInputs()->delete();
        $onlineRequest->onlineRequestPrerequisiteNotes()->delete();
        $onlineRequest->delete();
        return self::successResponse();
    }

    /**
     * @param array $onlineRequests
     * @return array
     */
    private static function formatResponseData(array $onlineRequests): array
    {
        $requestLength = count($onlineRequests);
        for ($i = 0; $i < $requestLength; $i++) {
            $procedureLength = count($onlineRequests[$i]['online_request_procedures']);
            for ($j = 0; $j < $procedureLength; $j++) {
                $usersId = collect($onlineRequests[$i]['online_request_procedures'][$j]['users'])
                    ->map(function ($value) { return $value['id']; })->toArray();
                $onlineRequests[$i]['online_request_procedures'][$j]['responsible_user_id'] = $usersId;
                unset($onlineRequests[$i]['online_request_procedures'][$j]['users']);
            }
        }
        return $onlineRequests;
    }
}
