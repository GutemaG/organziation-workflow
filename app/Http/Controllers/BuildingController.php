<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Rule;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    public function __construct()
    {
        if($this->middleware(function ($request, $next){
            if(auth()->check())
                return $next($request);
            return response()->redirectTo(route('login'));
        }));
    }

    private function isAuthorized(){
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        else
            return null;
    }

    public function index()
    {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $buildings = Building::orderBy('number', 'asc')->get();
            return response()->json([
                'status' => 200,
                'buildings' => $buildings,
            ]);
        }
    }

    public function store(Request $request)
    {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $fields = $request->only(Fields::building());
            $validator = Validator::make($fields, Rule::building());

            if ($validator->fails()){
                return response()->json([
                   'status' => 400,
                   'error' => $validator->errors(),
                ]);
            }

            else{
                try {
                    DB::beginTransaction();
                    $building = Building::create($validator->validated());
                    DB::commit();
                    return response()->json([
                        'status' => 201,
                        'building' => $building,
                    ]);
                }
                catch (\Exception $e){
                    DB::rollBack();
                    return response()->json([
                        'status' => 400,
                        'error' => [
                            'error' => ['error occur while creating please retry again.']
                        ],
                    ]);
                }

            }
        }
    }

    public function show($id)
    {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $building = Building::find($id);
            if (empty($building))
                return response()->json([
                    'status' => 400,
                    'error' =>[
                        'error' => ['Building doesn\'t exist.']
                    ]
                ]);
            else
                return response()->json([
                    'status' => 200,
                    'building' => $building,
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $building = Building::find($id);
            if(empty($building))
                return response()->json([
                    'status' => 400,
                    'error' =>[
                        'error' => ['Building doesn\'t exist.']
                    ]
                ]);
            else{
                $fields = $this->getUpdateFields($request, $building);
                $validator = Validator::make($fields, Rule::only('building', array_keys($fields)));
                if ($validator->fails()){
                    return response()->json([
                        'status' => 400,
                        'error' => $validator->errors(),
                    ]);
                }

                else {
                    try {
                        DB::beginTransaction();
                        $building->update($validator->validated());
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'building' => Building::find($building->id),
                        ]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 400,
                            'error' => [
                                'error' => ['error occur while creating please retry again.']
                            ],
                        ]);
                    }
                }
            }

        }
    }

    private  function getUpdateFields(Request $request, Building $building){
        $fields = [];
        foreach ($request->only(Fields::building()) as $key => $item){
            if($request->get($key) != $building->getAttributeValue($key))
                $fields[$key] = $item;
        }
        return $fields;
    }

    public function destroy($id)
    {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $building = Building::find($id);
            if (empty($building))
                return response()->json([
                    'status' => 400,
                    'error' =>[
                        'error' => ['Building doesn\'t exist.']
                    ]
                ]);
            else{
                $building->delete();
                return response()->json([
                    'status' => 200,
                ]);
            }
        }
    }
}
