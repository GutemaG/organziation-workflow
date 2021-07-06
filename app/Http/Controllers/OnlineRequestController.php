<?php

namespace App\Http\Controllers;

use App\Models\OnlineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OnlineRequestController extends Controller
{
    /**
     * Check if user is authenticated. If not redirect it login page.
     *
     * OnlineRequestController constructor.
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * check if authenticated user is admin or staff.
     * if not return with unauthorized error message.
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function isAuthorized(){return false;
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        else
            return null;
    }

    private function badRequestResponse() {
        return response()->json([
            'status' => 400,
            'error' => [
                'error' => ['Online request doesn\'t exist.']
            ]
        ]);
    }

    /**
     * return a listing of the online request.
     * it contains oll relation ship (prerequisiteLabel, onlineRequestProcedure and users).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

        $onlineRequests = OnlineRequest::orderBy('name', 'asc')->get();
        return response()->json([
            'status' => 200,
            'onlineRequests' => $onlineRequests,
        ]);
    }

    /**
     * Display the specified online request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

        $onlineRequest = OnlineRequest::find($id);
        if (empty($onlineRequest))
            return $this->badRequestResponse();
        else {
            return response()->json([
                'status' => 200,
                'onlineRequest' => $onlineRequest,
            ]);
        }
    }

    /**
     * soft delete the specified online request from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return $result;

        $onlineRequest = OnlineRequest::withOut(['onlineRequestProcedures','prerequisiteLabels',])->find($id);
        if (empty($onlineRequest))
            return $this->badRequestResponse();
        else {
            $onlineRequest->delete();
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
