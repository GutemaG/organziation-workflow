<?php

namespace App\Http\Requests;

use App\Exceptions\FormRequestException;
use App\Models\OnlineRequest;
use App\Utilities\InputFieldType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OnlineRequestTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = array();
        if (! empty($this->input('online_request_id'))) {
            $onlineRequest = OnlineRequest::with(['onlineRequestPrerequisiteInputs'])->find($this->input('online_request_id'));
            foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input) {
                $rule["prerequisites.$input->name"] = $this->getRule($input->type);
            }
        }
        $rule['online_request_id'] = ['required', 'integer', Rule::exists('online_requests', 'id')];
        $rule['phone_number'] = 'required|string';
        $rule['full_name'] = 'required|string';
        $rule['prerequisites'] = 'nullable|array|distinct';
        return $rule;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws FormRequestException
     */
    public function failedValidation(Validator $validator): void
    {
        $error = $validator->errors()->toArray();
        $this->throwException($error);
    }

    /**
     * Throw FormRequestException by passing message that would be rendered.
     *
     * @param array $error
     * @throws FormRequestException
     */
    protected function throwException(array $error): void
    {
        $message['status'] = 422;
        $message ['error'] = $error;
        $message = json_encode($message);
        throw new FormRequestException($message, 200);
    }

    protected function getRule(string $type): string
    {
        switch ($type) {
            case InputFieldType::getEmail():
                return 'required|string|email';
                break;
            case InputFieldType::getText():
                return 'required|string';
                break;
            case InputFieldType::getNumber():
                return 'required|integer';
                break;
            case InputFieldType::getFile():
            default:
                return '';
                break;
        }
    }
}
