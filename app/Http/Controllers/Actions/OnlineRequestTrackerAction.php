<?php


namespace App\Http\Controllers\Actions;


use App\Events\OnlineRequestEvent;
use App\Http\Controllers\Actions\Services\SmsNotifier;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\OnlineRequestTracker;
use Exception;
use Illuminate\Database\Eloquent\Model;
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
        $onlineRequest = OnlineRequest::with('onlineRequestProcedures')->find($data['online_request_id']);
        if ($onlineRequest) {
            try {
                DB::beginTransaction();
                $onlineRequestTracker = $onlineRequest->onlineRequestTracker()
                    ->create(['token' => Str::random(4)]);
                $token = $onlineRequestTracker->token;
                $procedures = $onlineRequest->onlineRequestProcedures;
                $onlineRequestStep = OnlineRequestStepAction::store($procedures, $onlineRequestTracker);
                self::initiateNotification($data['phone_number'], $token, $onlineRequest, $procedures, $onlineRequestStep);
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
     * @param string $phone_number
     * @param string $token
     * @param Model $onlineRequest
     * @param Collection $procedures
     * @param Model $onlineRequestStep
     * @throws ConfigurationException
     */
    protected static function initiateNotification(string $phone_number, string $token, Model $onlineRequest, Collection $procedures, Model $onlineRequestStep): void
    {
        self::notifierCustomer($phone_number, $token);
        $users = self::getUsers($procedures);
        $users->each(function ($user) use ($onlineRequest, $onlineRequestStep) {
            $onlineRequestStep = $onlineRequestStep->toArray();
            $onlineRequest = $onlineRequest->toArray();
            unset($onlineRequest['online_request_procedures']);
            $onlineRequestStep['request'] = $onlineRequest;
            OnlineRequestEvent::dispatch($user, $onlineRequestStep);
        });
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

    /**
     * @param $procedures
     * @return Collection
     */
    protected static function getUsers($procedures): Collection
    {
        $temp = $procedures->sortBy('step_number')->first();
        return $temp->users;
    }
}
