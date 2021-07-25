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

    public function index()
    {
        /*
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'unauthorized'
            ]);
        }*/
        $affairs = Affair::all();
        return response()->json(
            [
                'status' => 200,
                'affairs' => $affairs
            ]
        );
    }

    /**
     * Store an affair:
     * create a affair then loop over their procedures and create them
     * when create procedures it check if it has a pre request
     * @param $request  Illuminate\Http\Request;
     */
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
            $affair = auth()->user()->affairs()->create([
                'name' => $validated_data['name'],
                'description' => $validated_data['description'],
            ]);

            $procedures = $validated_data['procedures'];
            foreach ($procedures as $pro) {
                $procedure = $affair->procedures()->create([
                    'name' => $pro['name'],
                    'description' => $pro['description'],
                    'step' => $pro['step']
                ]);
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
            'status' => 201,
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
        if ($affair->name === $request_affair['affair']['name']) {
            $validation = $this->validateUpdateData($request_affair['affair'], true);
        } else {
            $validation = $this->validateUpdateData($request_affair['affair'], false);
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
        $affair =  Affair::find($id);
        if (empty($affair)) {
            return response()->json([
                'status' => 400,
                'error' => 'Affair is not found'
            ]);
        }
        return $affair;
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
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        }
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
    public function addProcedure(Request $request)
    {
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        }
        $validatedData = $request->validate([
            'affair_id' => 'required|numeric',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'step' => 'required|numeric'
        ]);
        $procedure = Procedure::create($validatedData);
        if ($procedure) {
            return response()->json([
                'procedure' => Procedure::find($procedure->id)
            ]);
        }
        return $validatedData;
    }
    public function addPreRequest(Request $request)
    {
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        }
        $validatedData = $request->validate([
            'procedure_id' => 'required|numeric',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $pre_request = PreRequest::create($validatedData);
        if ($pre_request) {
            return response()->json([
                'pre_request' => $pre_request
            ]);
        }
        return response()->json([
            'status' => 400,
            'error' => 'something is wrong'
        ]);
    }
    public function deletePreRequest($id, $procedure_id)
    {
        if (!Gate::any(['is-admin', 'is-it-team-member'])) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        }
        $pre_request = PreRequest::where('id', $id)->where('procedure_id', $procedure_id)->first();
        if (empty($pre_request)) {
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
}
