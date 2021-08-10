<?php


namespace App\Http\Controllers\Actions;


use App\Models\OnlineRequestStep;
use Illuminate\Http\JsonResponse;

class OnlineRequestStepAction
{
    public static function index(): JsonResponse
    {
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
            'online-request-steps' => $data,
        ]);
    }
}
