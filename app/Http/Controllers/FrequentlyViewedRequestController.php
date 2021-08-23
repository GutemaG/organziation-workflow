<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\FrequentlyViewedRequestAction;
use App\Models\Affair;
use App\Models\OnlineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrequentlyViewedRequestController extends Controller
{
    public function incrementOnlineRequest(OnlineRequest $onlineRequest): JsonResponse
    {
        return FrequentlyViewedRequestAction::incrementOnlineRequest($onlineRequest);
    }

    public function frequentlyViewedOnlineRequest(Request $request): JsonResponse
    {
        return FrequentlyViewedRequestAction::frequentlyViewedOnlineRequest($request);
    }

    public function incrementAffair(Affair $affair): JsonResponse
    {
        return FrequentlyViewedRequestAction::incrementAffair($affair);
    }

    public function frequentlyViewedAffair(Request $request): JsonResponse
    {
        return FrequentlyViewedRequestAction::frequentlyViewedAffair($request);
    }
}
