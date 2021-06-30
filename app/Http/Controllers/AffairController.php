<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Affair;
use App\Models\User;
use App\Models\Procedure;
use App\Models\PreRequest;
class AffairController extends Controller
{
    //
    public function index(){
        return Affair::first();
    }
    public function store(Request $request){
        return $request;
    }

}
