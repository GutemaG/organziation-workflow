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
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'unauthorized'
            ]);
        }
        $affairs = Affair::all();
        return response()->json(
            [
                'status' => 200,
                'affairs' => $affairs
            ]
        );
    }
    public function store(Request $request)
    {
        if (!Gate::any(['it-team-member', 'is-admin'])) {
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

            //    $user = auth()->user();
            $affair = auth()->user()->affairs()->create([
                'name' => $validated_data['name'],
                'description' => $validated_data['description'],
            ]);

            /**
             * $affair = Affair::create([
                'name' => $validated_data['name'],
                'description' => $validated_data['description'],
                'user_id' => 2
            ]);
             */
            $procedures = $validated_data['procedures'];

            foreach ($procedures as $pro) {
                $procedure = $affair->procedures()->create([
                    'name' => $pro['name'],
                    'description' => $pro['description'],
                    'step' => $pro['step']
                ]);
                // return $pro;
                if (array_key_exists('pre_requests', $pro)) {
                    $pre_requests = $pro['pre_requests'];
                    foreach ($pre_requests as $pre_request) {
                        $procedure->preRequests()->create([
                            'name' => $pre_request['name'],
                            'description' => $pre_request['name'],
                            'affair_id' => $pre_request['affair_id']
                        ]);
                    }
                } else {
                    continue;
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
        return [
            'status' => 200,
            'affair' => Affair::find($affair->id)
        ];
    }
    public function update(Request $request, $id)
    {

        if (!Gate::any(['is-it-team-member', 'is-admin'])) {
            return response()->json([
                'status' => 401,
                'error' => 'unauthorized'
            ]);
        }
        $affair = Affair::find($id);
        if (empty($affair)) {
            return response()->json(['status' => 400, 'error' => 'Affair does not exist']);
        }
        $request_affair = $request->only('affair');
        // return $affair->name;
        // return $request_affair['affair']['name'];
        if ($affair->name === $request_affair['affair']['name']) {
            $validation = $this->validateUpdateData($request_affair['affair'], true);
        } else {
            $validation = $this->validateUpdateData($request_affair['affair'], true);
        }
        if ($validation->fails()) {
            return $validation->errors();
        }
        $validated_data = $validation->validated();
        try {
            DB::beginTransaction();
            if (array_key_exists('name', $validated_data)) {
                $affair->update(['name' => $validated_data['name'], 'description' => $validated_data['description']]);
            } else {
                $affair->update(['description' => $validated_data['description']]);
            }
            // return $affair;
            //Todo: first find authenticated user
            /**
           $user = auth()->user();
            $affair = $user->affairs()->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'user_id' => 2
            ]);
             */
            $procedures = $validated_data['procedures'];
            foreach ($procedures as $pro) {
                $procedure = Procedure::where('id', $pro['id'])->where('affair_id', $pro['affair_id'])->first();
                $procedure->update([
                    'name' => $pro['name'],
                    'description' => $pro['description'],
                    'step' => $pro['step']
                ]);
                if (!array_key_exists('pre_requests', $pro)) {
                    continue;
                }
                // return $pro;
                $pre_requests = $pro['pre_requests'];
                foreach ($pre_requests as $pre) {
                    $pre_request = PreRequest::where('id', $pre['id'])->where('procedure_id', $pre['procedure_id'])->first();
                    $pre_request->update([
                        'name' => $pre['name'],
                        'description' => $pre['name'],
                        'affair_id' => $pre['affair_id']
                    ]);
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
        return response()->json([
            'status' => 200,
            'Affair' => Affair::find($affair->id)
        ]);
    }
    public function show($id)
    {
        if (Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'unauthorized'
            ]);
        }
        $affair =  Affair::find($id);
        if (empty($affair)) {
            return response()->json([
                'status' => 400,
                'error' => 'Affair is not found'
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
            'procedures.*.pre_requests.*.name' => "nullable|string|required_if:pre_request.affair_id,'!null'",
            'procedures.*.pre_requests.*.description' => "nullable|string|",
            'procedures.*.pre_requests.*.affair_id' => "nullable|integer|required_if: procedures.*.pre_request.*.name, ''",
        ];
        return Validator::make($data, $rule);
    }
    public function validateUpdateData($data, $is_name_the_same = false)
    {
        $update_rule = [
            'description' => 'nullable|string',
            'procedures.*.name' => 'required|string',
            'procedures.*.description' => 'nullable|string',
            'procedures.*.id' => 'required|integer',
            'procedures.*.affair_id' => 'required|integer',
            'procedures.*.step' => 'required|integer',
            'procedures.*.pre_requests.*.id' => "required|integer",
            'procedures.*.pre_requests.*.name' => "nullable|string|required_if:pre_request.affair_id,'!null'",
            'procedures.*.pre_requests.*.description' => "nullable|string|",
            'procedures.*.pre_requests.*.procedure_id' => "required|integer",
            'procedures.*.pre_requests.*.affair_id' => "nullable|integer|required_if: procedures.*.pre_request.*.name, ''",
        ];
        if ($is_name_the_same) {
            $update_rule['name'] =  'required|string';
        }
        return Validator::make($data, $update_rule);
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

    public function destroy($id)
    {
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        }
        $affair = Affair::find($id);
        //Todo: Delete the relation ships 
        if (empty($affair)) {
            return response()->json([
                'status' => 400,
                'error' => 'Affair does not exist'
            ]);
        }
        $affair->delete();
        return response()->json(['status' => 200]);
    }
    public function deleteProcedure($id, $affair_id)
    {
        $procedure = Procedure::where('id', $id)->where('affair_id', $affair_id)->first();
        // return $procedure;
        if (empty($procedure)) {
            return response()->json([
                'status' => 400,
                'error' => 'Does not exist'
            ]);
        }
        $procedure->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    public function deletePreRequest($id, $procedure_id){
        $pre_request = PreRequest::where('id', $id)->where('procedure_id', $procedure_id)->first();
        if(empty($pre_request)){
            return response()->json([
                'status' => 400,
                'error' => 'Does not exist'
            ]);

        }
        $pre_request->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
