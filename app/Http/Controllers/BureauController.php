<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bureau;
use Illuminate\Support\Facades\Gate;

class BureauController extends Controller
{
    public function __construct()
    {
//        if($this->middleware(function ($request, $next){
//            if (auth()->check())
//                return $next($request);
//            return redirect()->route('login');
//        }));
    }

    private function isAuthorized(){return false;
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        else
            return null;
    }

    public function index() {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else {
            $bureaus = Bureau::orderBy('name', 'asc')->get();
            return response()->json([
                'status' => 200,
                'bureaus' => $bureaus,
            ]);
        }
    }

    public function show($id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else {
            $bureau = Bureau::find($id);
            if (empty($bureau))
                return response()->json([
                    'status' => 400,
                    'error' =>[
                        'error' => ['Bureau doesn\'t exist.']
                    ]
                ]);
            else
                return response()->json([
                    'status' => 200,
                    'bureau' => $bureau,
                ]);
        }
    }

    public function destroy($id)
    {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $bureau = Bureau::find($id);
            if (empty($bureau))
                return response()->json([
                    'status' => 400,
                    'error' =>[
                        'error' => ['Bureau doesn\'t exist.']
                    ]
                ]);
            else{
                $bureau->delete();
                return response()->json([
                    'status' => 200,
                ]);
            }
        }
    }
}
