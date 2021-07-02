<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Affair;
use App\Models\User;
use App\Models\Procedure;
use App\Models\PreRequest;
use App\Models\Bureau;
class AffairController extends Controller
{
    // TODO: remove id and user_id
    public static $affair = ['id','user_id, name, description'];
    public static $procedure = ['id, affair_id, name, description, step'];
    public static $pre_request = ['id', 'procedure_id', 'affair_id', 'name', 'description'];

    public function index(){
        return Affair::first();
    }

    /** 
     * @param Request accept different json data 
     *  that go to different to Models: Procedure, PreRequest
     *  affair: id, user_id, name, description
     *  procedures: id, affair_id, name, description, step
     *  pre_reqeuest: id, procedure_id, affair_id, name, description
    */
    public function store(Request $request){
        //step 1: classify an incoming data: affair, procedure, pre_request
        $affair = $request->only('affair');

        $pro = $request->only('procedures');

        $pro['affair_id'] = 1; 
        return $request;
        // $procedure = $request->only('procedures');
        //Step 2: validate incoming data and create affair 
        //step 3: after creation of affair append affair_id to procedure data, and validate then create procedure
        //step 4: after creation of procedure
        return $affair;
    }
    public function save_affair($data){
        return $data;
    }

}
