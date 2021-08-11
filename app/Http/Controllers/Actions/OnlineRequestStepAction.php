<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequestStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\This;

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

//        dd(OnlineRequestStep::where('user_id', auth()->user()->id)->with('onlineRequestTracker.onlineRequest')->get()->toArray());

        $data = [];
        $onlineRequestSteps = OnlineRequestStep::where('user_id', auth()->user()->id)
            ->without('onlineRequestProcedure')->with('onlineRequestTracker')->get()->toArray();
        foreach ($onlineRequestSteps as $value) {
            $temp = $value['online_request_tracker']['online_request'];
            unset($temp['online_request_procedures']);
            unset($temp['prerequisite_labels']);
            unset($value['online_request_tracker']);
            $value['online_request'] = $temp;
            $data[] = $value;
        }
        return response()->json([
            'status' => 200,
            'online_request_steps' => $data,
        ]);
    }
}
