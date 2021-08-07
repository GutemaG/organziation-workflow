<?php


namespace App\Http\Controllers\Actions;


use App\Http\Controllers\Actions\Services\SmsNotifier;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\OnlineRequestTracker;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Twilio\Exceptions\ConfigurationException;

class OnlineRequestTrackerAction
{
    public static function appliedRequest(OnlineRequestTracker $onlineRequestTracker): JsonResponse
    {
        $data = self::removeUnusedData($onlineRequestTracker->toArray());
        return response()->json([
            'status' => 200,
            'applied_request' => $data,
        ]);
    }

    public static function applyRequest(array $data): JsonResponse
    {
        $onlineRequest = OnlineRequest::find($data['online_request_id']);
        if ($onlineRequest) {
            try {
                DB::beginTransaction();
                $onlineRequestTracker = $onlineRequest->onlineRequestTracker()
                    ->create(['token' => Str::random(6)]);
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

    /**
     * remove unused data such as users, prerequisites and procedures.
     *
     * @param array $onlineRequestTracker
     * @return Collection
     */
    protected static function removeUnusedData(array $onlineRequestTracker): Collection
    {
        $onlineRequestTracker = collect($onlineRequestTracker)->map(function ($value, $key) {
            if ($key == 'online_request') {
                unset($value['online_request_procedures']);
                unset($value['prerequisite_labels']);
            } elseif ($key == 'online_request_steps') {
                $length = count($value);
                for ($i = 0; $i < $length; $i++) {
                    $value[$i]['bureau'] = $value[$i]['online_request_procedure']['bureau'];
                    unset($value[$i]['online_request_procedure']);
                }
            }
            return $value;
        });
        return $onlineRequestTracker;
    }
}
