<?php


namespace App\Http\Controllers\Actions;


use App\Http\Controllers\Actions\Services\SmsNotifier;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\OnlineRequestTracker;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Twilio\Exceptions\ConfigurationException;

class OnlineRequestTrackerAction
{
    public static function appliedRequest(OnlineRequestTracker $onlineRequestTracker): JsonResponse
    {
//        $appliedRequest = OnlineRequestTracker::with(['onlineRequestSteps'])->find($id)->toArray();
//        $length = count($appliedRequest['online_request_steps']);
//        for ($i = 0; $i < $length; $i++) {
//            $bureau = OnlineRequestProcedure::with('bureau')
//                ->find($appliedRequest['online_request_steps'][$i]['online_request_procedure_id'])->bureau;
//            $appliedRequest['online_request_steps'][$i]['bureau'] = $bureau->toArray();
//            $appliedRequest['online_request_steps'][$i]['online_request_procedure'] = null;
//        }
        return response()->json([
            'status' => 200,
            'applied_request' => $onlineRequestTracker,
        ]);
    }

    public static function applyRequest(array $data): JsonResponse
    {
        $onlineRequest = OnlineRequest::find($data['online_request_id']);
        if ($onlineRequest) {
            try {
                DB::beginTransaction();
                $onlineRequestTracker = $onlineRequest->onlineRequestTracker()
                    ->create(['started_at' => now(), 'token' => Str::random(6)]);
                $token = $onlineRequestTracker->token;
                $procedures = $onlineRequest->onlineRequestProcedures;
                self::createOnlineRequestStep($procedures, $onlineRequestTracker);
                self::notifierCustomer($data['phone_number'], $token);
                DB::commit();
                return self::successResponse($token);
            }
            catch (Exception $e) {
                DB::rollBack();
                return self::badResponse($e);
            }
        }
        return self::badResponse(new Exception('Online request is not found.'));
    }

    /**
     * Register each procedure of the online request.
     *
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
     * @param string $token
     * @return JsonResponse
     */
    protected static function successResponse(string $token): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'token' => $token,
        ]);
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

    /**
     * Send the token to the customer via sms.
     *
     * @param $phone_number
     * @param $token
     * @throws ConfigurationException
     */
    protected static function notifierCustomer($phone_number, $token): void
    {
        $smsNotifier = new SmsNotifier($phone_number, $token);
        $smsNotifier->sendSms();
    }
}
