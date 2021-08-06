<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequest;
use App\Models\OnlineRequestTracker;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OnlineRequestTrackerAction
{
    public static function applyRequest(OnlineRequest $onlineRequest): JsonResponse
    {
        try {
            DB::beginTransaction();
            $onlineRequestTracker = $onlineRequest->onlineRequestTracker()
                ->create(['started_at' => now(), 'token' => Str::random(6)]);
            $procedures = $onlineRequest->onlineRequestProcedures;
            self::createOnlineRequestStep($procedures, $onlineRequestTracker);
            DB::commit();
            return self::successResponse($onlineRequestTracker);
        }
        catch (Exception $e) {
            DB::rollBack();
            return self::badResponse($e);
        }
    }

    /**
     * @param OnlineRequestTracker $onlineRequestTracker
     * @return JsonResponse
     */
    protected static function successResponse(OnlineRequestTracker $onlineRequestTracker): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'token' => $onlineRequestTracker->token,
        ]);
    }

    /**
     * @param $procedures
     * @param OnlineRequestTracker $onlineRequestTracker
     */
    protected static function createOnlineRequestStep($procedures, OnlineRequestTracker $onlineRequestTracker): void
    {
        $oldOnlineRequestStep = null;
        foreach ($procedures as $procedure) {
            $currentOnlineRequest = $onlineRequestTracker->onlineRequestSteps()->create([
                'online_request_procedure_id' => $procedure->id,
                'is_completed' => false,
            ]);
            if ($oldOnlineRequestStep) {
                $oldOnlineRequestStep->update(['next_step' => $currentOnlineRequest->id]);
            }
            $oldOnlineRequestStep = $currentOnlineRequest;
        }
    }

    /**
     * @param Exception $e
     * @return JsonResponse
     */
    protected static function badResponse(Exception $e): JsonResponse
    {
        return response()->json([
            'status' => 400,
            'error' => [
                'error' => ['something went wrong. Please try again.', $e->getMessage()],
            ]
        ]);
    }
}
