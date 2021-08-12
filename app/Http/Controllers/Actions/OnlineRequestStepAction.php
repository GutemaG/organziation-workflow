<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequestStep;
use App\Models\OnlineRequestTracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class OnlineRequestStepAction
{
    private static function checkAuthorization(): bool
    {
        return Gate::check('is-staff');
    }

    private static function unauthorizedResponse(): JsonResponse
    {
        return response()->json([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }

    public static function index(): JsonResponse
    {
        if (! self::checkAuthorization())
            return self::unauthorizedResponse();
        $onlineRequestSteps = OnlineRequestStep::where('user_id', auth()->user()->id)
                            ->with('onlineRequestTracker.onlineRequest')->get()->toArray();
        $length = count($onlineRequestSteps);
        for ($i = 0; $i < $length; $i++) {
            $onlineRequestSteps[$i]['online_request'] = $onlineRequestSteps[$i]['online_request_tracker']['online_request'];
            unset($onlineRequestSteps[$i]['online_request_tracker']);
        }

        return response()->json([
            'status' => 200,
            'online_request_steps' => $onlineRequestSteps,
        ]);
    }

    /**
     * Register each procedure of the online request.
     *
     * @param $procedures
     * @param OnlineRequestTracker $onlineRequestTracker
     * @return Model
     */
    public static function store($procedures, OnlineRequestTracker $onlineRequestTracker): Model
    {
        $firstOnlineRequestStep = null;
        $oldOnlineRequestStep = null;
        foreach ($procedures as $procedure) {
            $currentOnlineRequest = $onlineRequestTracker->onlineRequestSteps()
                ->create(['online_request_procedure_id' => $procedure->id, 'is_completed' => false,]);
            $oldOnlineRequestStep ? $oldOnlineRequestStep->update(['next_step' => $currentOnlineRequest->id]) : null;
            if (!$firstOnlineRequestStep)
                $firstOnlineRequestStep = $currentOnlineRequest;
            $oldOnlineRequestStep = $currentOnlineRequest;
        }
        //        $temp = $firstOnlineRequestStep->onlineRequestTracker->toArray();
//        $firstOnlineRequestStep = $firstOnlineRequestStep->toArray();
//        unset($firstOnlineRequestStep['online_request_tracker']['online_request']['online_request_procedures']);
//        unset($firstOnlineRequestStep['online_request_tracker']['online_request']['prerequisite_labels']);
//        unset($firstOnlineRequestStep['online_request_tracker']);
//        $firstOnlineRequestStep['online_request'] = $firstOnlineRequestStep['online_request_tracker']['online_request'];
//        $firstOnlineRequestStep->pull('onlineRequestSteps');
//        dump($firstOnlineRequestStep);
//        OnlineRequestEvent::dispatch($firstOnlineRequestStep);
        return $firstOnlineRequestStep;
    }

    public static function assignResponsibleUser(OnlineRequestStep $onlineRequestStep): void
    {
        $onlineRequestStep->update(['user_id' => auth()->user()->id]);
    }
}
