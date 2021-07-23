<?php

namespace App\Http\Controllers;

use App\Models\OnlineRequestProcedure;
use Exception;

class OnlineRequestProcedureController extends Controller
{
    public static function store($data, $onlineRequestId): bool {
        try {
            $data = collect($data['online_request_procedures'])->sortBy('step_number')->toArray();
            foreach ($data as $value) {
                $value['online_request_id'] = $onlineRequestId;
                $procedure = OnlineRequestProcedure::create($value);
                $procedure->users()->attach($value['responsible_user_id']);
            }
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
}
