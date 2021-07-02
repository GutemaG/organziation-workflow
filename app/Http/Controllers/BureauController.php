<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Rule;
use Illuminate\Http\Request;

use App\Models\Bureau;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BureauController extends Controller
{
    /**
     * Check if user is authenticated if not redirect him/her to login page.
     *
     * BureauController constructor.
     */
    public function __construct()
    {
        if($this->middleware(function ($request, $next){
            if (auth()->check())
                return $next($request);
            return redirect()->route('login');
        }));
    }

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
     * return a listing of the bureaus.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Store a newly created bureau in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else{
            $data = $request->only(Fields::bureau());
            $validator = Validator::make($data, Rule::bureau());
            if ($validator->fails())
                return response()->json([
                    'status' => 400,
                    'error' => $validator->errors(),
                ]);
            else {
                try {
                    DB::beginTransaction();
                    $validatedData = $validator->validated();
                    $bureau = auth()->user()->bureaus()->create($validatedData);
                    DB::commit();
                    return response()->json([
                        'status' => 201,
                        'bureau' => $bureau,
                    ]);
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 400,
                        'error' => [
                            'error' => ['Something went wrong during creating bureau; please retry again.',$e->getMessage()],
                        ]
                    ]);
                }
            }
        }
    }

    private function badRequestMessage() {
        return [
            'status' => 400,
            'error' =>[
                'error' => ['Bad request.']
            ]
        ];
    }

    /**
     * Display the specified bureau.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else {
            $bureau = Bureau::find($id);
            if (empty($bureau))
                return response()->json($this->badRequestMessage());
            else
                return response()->json([
                    'status' => 200,
                    'bureau' => $bureau,
                ]);
        }
    }

    /**
     * Update the specified bureau in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $result = $this->isAuthorized();
        if (! empty($result))
            return  $result;
        else {
            $bureau = Bureau::find($id);
            if (empty($bureau))
                return response()->json($this->badRequestMessage());
            else {
               $data = $this->getUpdateData($request, $bureau);
               $validator = Validator::make($data, Rule::only(Bureau::class, array_keys($data)));
               if ($validator->fails())
                   return response()->json([
                       'status' => 400,
                       'error' => $validator->errors(),
                   ]);
               else {
                   try {
                       DB::beginTransaction();
                       $validatedData = $validator->validated();
                       $bureau->update($validatedData);
                       DB::commit();
                       return response()->json([
                           'status' => 200,
                           'bureau' => Bureau::find($bureau->id),
                       ]);
                   } catch (\Exception $e) {
                       DB::rollBack();
                       return response()->json([
                           'status' => 400,
                           'error' => [
                               'error' => ['Something went wrong during updating bureau; please retry again.'],
                           ]
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
     * @param Bureau $bureau
     * @return array
     */
    private  function getUpdateData(Request $request, Bureau $bureau){
        $data = [];
        foreach ($request->only(Fields::bureau()) as $key => $item){
            if($request->get($key) != $bureau->getAttributeValue($key))
                $data[$key] = $item;
        }
        return $data;
    }

    /**
     * soft delete the specified bureau from storage.
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
            $bureau = Bureau::find($id);
            if (empty($bureau))
                return response()->json($this->badRequestMessage());
            else{
                $bureau->delete();
                return response()->json([
                    'status' => 200,
                ]);
            }
        }
    }
}
