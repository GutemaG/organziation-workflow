<?php

namespace App\Http\Requests;

use App\Exceptions\FormRequestException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule as BaseRule;

class OnlineRequestRequest extends FormRequest
{

    private function defaultRules() {
        $id = $this->route()->parameter('online_request');
        return [
            'name' => ['required', 'string', BaseRule::unique('online_requests')->ignore($id)],
            'description' => 'required|string',
            'online_request_procedures' => 'required|array|distinct|min:1',
            'online_request_procedures.*.responsible_bureau_id' => ['required', 'integer', BaseRule::exists('bureaus', 'id')],
            'online_request_procedures.*.description' => 'nullable|string',
            'online_request_procedures.*.responsible_user_id' => 'required|array',
            'online_request_procedures.*.step_number' => 'required|integer',
        ];
    }

    private function getRules() {
        $rules = $this->defaultRules();
        $method = strtoupper($this->method());
        if (in_array($method, ['PUT', 'PATCH'])) {
            $rules['id'] = 'required|integer';
            $rules['online_request_procedures.*.id'] = 'required|integer';
            $rules['online_request_procedures.*.responsible_user_id.*'] = ['required', 'integer', BaseRule::exists('users', 'id')];
            $rules['prerequisite_labels.*.label'] = 'nullable|string';
            $rules['prerequisite_labels.*.id'] = 'exclude_if:prerequisite_labels.*.label,null|required|integer';
        }
        else {
            $rules['online_request_procedures.*.responsible_user_id.*'] = ['required', 'integer', BaseRule::exists('users', 'id')];
            $rules['prerequisite_labels.*'] = 'nullable|string|array|distinct';
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::any(['is-admin', 'is-it-team-member']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRules();
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws UnauthorizedException
     */
    public function failedAuthorization()
    {
        throw new UnauthorizedException();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws FormRequestException
     */
    public function failedValidation(Validator $validator)
    {
        $message['status'] = 422;
        $message ['error'] = $validator->errors()->toArray();
        $message = json_encode($message);
        throw new FormRequestException($message, 200);
    }
}
