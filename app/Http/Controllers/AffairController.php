<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affair;
use App\Models\User;
use App\Models\Procedure;
use App\Models\PreRequest;
use App\Models\Bureau;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AffairController extends Controller
{
    // TODO: remove id and user_id
    public static $affair = ['id', 'user_id, name, description'];
    public static $procedure = ['id, affair_id, name, description, step'];
    public static $pre_request = ['id', 'procedure_id', 'affair_id', 'name', 'description'];


    public function index()
    {
        return Affair::first();
    }

    /** 
     * @param Request accept different json data 
     *  that go to different to Models: Procedure, PreRequest
     *  affair: id, user_id, name, description
     *  procedures: id, affair_id, name, description, step
     *  pre-request: id, procedure_id, affair_id, name, description
     */
    public function store(Request $request)
    {
        if (Gate::any(['it-team-member', 'admin'])) {
            return response()->json(
                [
                    'status' => 401,
                    'error' => 'unauthorized'
                ]
            );
        }
        $request_affair = $request->only('affair');
        $validation = $this->validateData($request_affair['affair']);

        if ($validation->fails()) {
            return $validation->errors();
        }
        $validated_data = $validation->validated();
        try {
            DB::beginTransaction();
            //Todo: first find authenticated user
            /**
           $user = auth()->user();
            $affair = $user->affairs()->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'user_id' => 2
            ]);
             */
            $affair = Affair::create([
                'name' => $validated_data['name'],
                'description' => $validated_data['description'],
                'user_id' => 2
            ]);
            $procedures = $validated_data['procedures'];

            foreach ($procedures as $pro) {
                $procedure = $affair->procedures()->create([
                    'name' => $pro['name'],
                    'description' => $pro['description'],
                    'step' => $pro['step']
                ]);
                $pre_requests = $pro['pre_request'];
                if(!empty($pro['pre_request'])){
                    foreach ($pre_requests as $pre_request) {
                        $procedure->preRequests()->create([
                            'name' => $pre_request['name'],
                            'description' => $pre_request['name'],
                            'affair_id' => $pre_request['affair_id']
                        ]);
                    }
                }
                
            
                // return $pre_requests;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            return response()->json([
                'status' => 400,
                'error' => [
                    'error' => ["Something went wrong during updating password."]
                ],
            ]);
        }
        return [
            'status' => 200,
            'affair' => Affair::find($affair->id)
        ];
    }
    public function update(Request $request, $id){

        if(Gate::any(['is-it-team-member','is-admin'])){
            return response()->json([
                'status'=>401,
                'error' => 'unauthorized'
            ]);
        }
        $affair = Affair::find($id);
        if(empty($affair)){
            return response()->json(['status'=>400, 'error'=>'Affair does not exist']);
        }

        $request_affair = $request->only('affair');
        $validation = $this->validateData($request_affair['affair']);

        if ($validation->fails()) {
            return $validation->errors();
        }
        $validated_data = $validation->validated();

        try {
            DB::beginTransaction();
            //Todo: first find authenticated user
            /**
           $user = auth()->user();
            $affair = $user->affairs()->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'user_id' => 2
            ]);
             */
            $affair->update([
                'name' => $validated_data['name'],
                'description' => $validated_data['description'],
                'user_id' => 2
            ]);
            $procedures = $validated_data['procedures'];
            foreach ($procedures as $pro) {
                $procedure = $affair->procedures()->update([
                    'name' => $pro['name'],
                    'description' => $pro['description'],
                    'step' => $pro['step']
                ]);
                $pre_requests = $pro['pre_request'];
                foreach ($pre_requests as $pre_request) {
                    $procedure->preRequests()->update([
                        'name' => $pre_request['name'],
                        'description' => $pre_request['name'],
                        'affair_id' => $pre_request['affair_id']
                    ]);
                    // return $pre_request;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            return response()->json([
                'status' => 400,
                'error' => [
                    'error' => ["Something went wrong during updating password."]
                ],
            ]);
        }
        return $affair;
    }
    
    public function validateData($data)
    {
        $rule = [
            'name' => 'required|unique:affairs|string',
            'description' => 'nullable|string',
            'procedures.*.name' => 'required|string',
            'procedures.*.description' => 'nullable|string',
            'procedures.*.step' => 'required|integer',
            'procedures.*.pre_request.*.name' => "nullable|string|required_if:pre_request.affair_id,'!null'",
            'procedures.*.pre_request.*.description' => "nullable|string|",
            'procedures.*.pre_request.*.affair_id' => "nullable|integer|required_if: procedures.*.pre_request.*.name, ''",
        ];
        return Validator::make($data, $rule);
    }

    public static function testing()
    {
        $aff = [
            "affair" => [
                "name" => "original ",
                "description" => "update take original file for ASTU ",
                "procedures" => [
                    [
                        "name" => "update Go to Registrar",
                        "description" => "up Go to this bureau",
                        "step" => 1,
                        "pre_request" => [
                            [
                                "name" => "nothing is here",
                                "description" => "what the fuck",
                                "affair_id" => null
                            ],
                            [
                                "name" => "nothing bla bla",
                                "description" => "blalala",
                                "affair_id" => null
                            ]
                        ]
                    ],
                    [
                        "name" => "up go to bureau number 8",
                        "description" => "up They will handle your request",
                        "step" => 2,
                        "pre_request" => [
                            [
                                "name" => "kj",
                                "description" => "up Photo that display on your original file",
                                "affair_id" => null
                            ],
                            [
                                "name" => "nothing also",
                                "description" => "",
                                "affair_id" => 2
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $aff;
    }

    public function destroy($id){
        return Affair::find(58);
        if(!Gate::allows(['is-admin','is-it-team-member'])){
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        }
        $affair = Affair::find($id);
    //    Todo: Delete the rrelation ships 
        if(empty($affair)){
            return response()->json([
                'status' => 400,
                'error' => 'Affair does not exist'
            ]);
        }
        $affair->delete();
        return response()->json(['status'=>200]);
    }
}
