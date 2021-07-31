<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Rule;
use App\Models\Building;

class BuildingController extends Controller
{
    /**
     * Check if user is authenticated if not redirect him/her to login page.
     *
     * BuildingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');    }

    /**
     * check if authenticated user is admin or staff.
     * if not return with unauthorized error message.
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function isAuthorized(){
        if (! Gate::any(['is-admin', 'is-it-team-member']))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        else
            return null;
    }

    /**
     * return a listing of the buildings.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Store a newly created building in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
                            'error' => ['Error occur while creating please retry again.']
                        ],
                    ]);
                }

            }
        }
    }

    /**
     * Display the specified building.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update the specified building in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
                $validator = Validator::make($fields, Rule::only(Building::class, array_keys($fields)));
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

    /**
     * Return only updated fields associated with their values.
     *
     * @param Request $request
     * @param Building $building
     * @return array
     */
    private  function getUpdateFields(Request $request, Building $building){
        $fields = [];
        foreach ($request->only(Fields::building()) as $key => $item){
            if($request->get($key) != $building->getAttributeValue($key))
                $fields[$key] = $item;
        }
        return $fields;
    }

    /**
     * soft delete the specified building from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
