<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\OnlineRequestStepAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlineRequestStepController extends Controller
{
    public function index(): JsonResponse
    {
        return OnlineRequestStepAction::index();
    }
}
