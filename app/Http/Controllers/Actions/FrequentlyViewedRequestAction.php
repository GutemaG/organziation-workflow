<?php


namespace App\Http\Controllers\Actions;


use App\Models\Affair;
use App\Models\OnlineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrequentlyViewedRequestAction
{
    use MyJsonResponse;

    /**
     * When client view any online request it will increment the number of view of that online request.
     * But for authenticated user it will not.
     *
     * @param OnlineRequest $onlineRequest
     * @return JsonResponse
     */
    public static function incrementOnlineRequest(OnlineRequest $onlineRequest): JsonResponse
    {
        if (! auth()->check()) {
            $views = $onlineRequest->views + 1;
            $onlineRequest->update(['views' => $views]);
            return self::successResponse();
        }
        else{
            $error = ['error' => ['User must be client.']];
            return self::badResponse($error);
        }
    }

    /**
     * Return most viewed online request with limit provided but, if the limit is not provided or
     * if the provided limit is less than 10 the default limit will be 10.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public static function frequentlyViewedOnlineRequest(Request $request): JsonResponse
    {
        $limit = $request->route('limit', 10);
        $limit = $limit >= 10 ? $limit : 10;
        $onlineRequest = OnlineRequest::orderBy('views', 'asc')
                        ->limit($limit)->get()->toArray();
        return self::successResponse(['online_requests' => $onlineRequest]);
    }

    /**
     * When client view any affair it will increment the number of view of that affair.
     * But for authenticated user it will not.
     *
     * @param Affair $affair
     * @return JsonResponse
     */
    public static function incrementAffair(Affair $affair): JsonResponse
    {
        if (! auth()->check()) {
            $views = $affair->views + 1;
            $affair->update(['views' => $views]);
            return self::successResponse();
        }
        else{
            $error = ['error' => ['User must be client.']];
            return self::badResponse($error);
        }
    }

    /**
     * Return most viewed affair with limit provided but, if the limit is not provided or
     * if the provided limit is less than 10 the default limit will be 10.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public static function frequentlyViewedAffair(Request $request): JsonResponse
    {
        $limit = $request->route('limit', 10);
        $limit = $limit >= 10 ? $limit : 10;
        $affairs = Affair::orderBy('views', 'asc')
            ->limit($limit)->get()->toArray();
        return self::successResponse(['affairs' => $affairs]);
    }
}
