<?php


namespace App\Http\Controllers\Actions;


use App\Exceptions\DatabaseException;
use App\Models\OnlineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OnlineRequestAction
{
    use MyJsonResponse;

    private static array $with = ['onlineRequestProcedures', 'onlineRequestPrerequisiteNotes', 'onlineRequestPrerequisiteInputs'];

    public static function index(): JsonResponse
    {
        $onlineRequests = OnlineRequest::with(self::$with)->orderBy('name', 'asc')->get();
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





    public static function show(OnlineRequest $onlineRequest): JsonResponse
    {
        $onlineRequest->onlineRequestProcedures;
        $onlineRequest->onlineRequestPrerequisiteInputs;
        $onlineRequest->onlineRequestPrerequisiteNotes;
        return self::successResponse(['online_request' => $onlineRequest]);
    }
}
