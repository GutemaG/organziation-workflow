<?php

namespace App\Http\Requests;

use App\Exceptions\FormRequestException;
use App\Exceptions\UnauthorizedException;
use App\Utilities\InputFieldType;
use App\Utilities\RequestType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class OnlineRequestRequest extends FormRequest
{
    /**
     * OnlineRequest default validation rules for both update and store.
     *
     * @return array
     */
    private function defaultRules(): array
    {
        $id = $this->route()->parameter('online_request');
        $checkInput = !empty($this->input('prerequisites.inputs'));
        return [
            'type' => ['required', 'string', Rule::in(RequestType::all())],
            'name' => ['required', 'string', Rule::unique('online_requests')->ignore($id)],
            'description' => 'required|string',
            'online_request_procedures' => 'required|array|distinct|min:1',
            'online_request_procedures.*.responsible_bureau_id' => ['required', 'integer', Rule::exists('bureaus', 'id')],
            'online_request_procedures.*.description' => 'nullable|string',
            'online_request_procedures.*.responsible_user_id' => 'required|array|distinct|min:1',
            'online_request_procedures.*.step_number' => 'required|integer',
            'prerequisites' => 'sometimes|array|distinct|min:1',
            'prerequisites.notes' => 'sometimes|array|distinct',
            'prerequisites.inputs' => 'sometimes|array|distinct',
            'prerequisites.inputs.*.name' => $checkInput ? 'required|string' : '',
            'prerequisites.inputs.*.input_id' => $checkInput ? 'required|string' : '',
            'prerequisites.inputs.*.type' => $checkInput ? ['required', 'string', Rule::in(InputFieldType::all())] : '',
        ];
    }

    /**
     * Add additional rules to the default rule based on the validation is for store or update.
     *
     * @return array
     */
    private function getRules(): array
    {
        $checkNote = !empty($this->input('prerequisites.notes'));
        $rules = $this->defaultRules();
        $method = strtoupper($this->method());
        if (in_array($method, ['PUT', 'PATCH'])) {
            $rules['prerequisites.notes.*'] = $checkNote ? 'sometimes|array|distinct' : '';
            $rules['prerequisites.notes.*.id'] = $checkNote ? ['sometimes', 'integer', Rule::exists('online_request_prerequisite_notes', 'id')] : '';
            $rules['prerequisites.notes.*.note'] = $checkNote ? 'required|string' : '';
            $rules['online_request_procedures.*.id'] = ['sometimes', 'integer', Rule::exists('online_request_procedures', 'id')];
            $rules['online_request_procedures.*.responsible_user_id.*'] = ['required', 'integer', Rule::exists('users', 'id')];
            $rules['prerequisites.notes.*.id'] = ['sometimes', 'integer', Rule::exists('online_request_prerequisite_notes', 'id')];
            $rules['prerequisites.inputs.*.id'] = ['sometimes', 'integer', Rule::exists('online_request_prerequisite_inputs', 'id')];
        }
        else {
            $rules['prerequisites.notes.*'] = $checkNote ? 'required|string' : '';
            $rules['online_request_procedures.*.responsible_user_id.*'] = ['required', 'integer', Rule::exists('users', 'id')];
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::any(['is-admin', 'is-it-team-member']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRules();
    }

    /**
     * Handle a passed validation attempt.
     * And check if the procedure step number is assigned incrementally.
     * The order won't matter. B/c it will be sorted.
     *
     * @return void
     * @throws FormRequestException
     */
    protected function passedValidation(): void
    {
        $error = $this->validateEachStepNumber();
        if (! empty($error)) {
            $this->throwException($error);
        }
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws UnauthorizedException
     */
    public function failedAuthorization(): void
    {
        throw new UnauthorizedException();
    }

    /**
     * Handle a failed validation attempt.
     * And check if the procedure step number is assigned incrementally.
     * The order won't matter. B/c it will be sorted.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws FormRequestException
     */
    public function failedValidation(Validator $validator): void
    {
        $error = $this->mergeError($validator);
        $this->throwException($error);
    }

    /**
     * Extract the step number of each procedure and associate it with the index of the procedure.
     *
     * @param bool $parentValidationFails
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function getAllStepNumberOfEachProcedure($parentValidationFails=false): Collection
    {
        $procedures = is_array($this->get('online_request_procedures'))
            ? $this->get('online_request_procedures') : [];
        $data = $parentValidationFails ? collect($procedures) :
            collect($this->validator->validated()['online_request_procedures']);

        $data = $data->map(function ($value, $key) {
            if (array_key_exists('step_number', $value))
                return $value['step_number'];
            return null;
        });
        return $data->sort();
    }

    /**
     * Validate if the procedure step number is assigned incrementally and return error if exist.
     * The order won't matter. B/c it will be sorted.
     *
     * @param bool $parentValidationFails
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateEachStepNumber($parentValidationFails=false): array
    {
        $data = $this->getAllStepNumberOfEachProcedure($parentValidationFails);
        $step = 1;
        $error = [];
        foreach ($data as $key => $value) {
            if ($value != $step && $value != null) {
                $error["online_request_procedures.$key.step_number"]
                    =
                    ["step_number should be $step. Or please enter the step number in incremental order."];
            }
            ++$step;
        }
        return $error;
    }

    /**
     * Merge the default error with step number error.
     *
     * @param Validator $validator
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function mergeError(Validator $validator): array
    {
        $errorOfStepNumber = $this->validateEachStepNumber(true);
        $error = $validator->errors()->toArray();

        foreach ($errorOfStepNumber as $key => $value) {
            if (array_key_exists($key, $error))
                $error[$key][] = $errorOfStepNumber[$key][0];
            else
                $error[$key] = $errorOfStepNumber[$key];
        }
        return $error;
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
}
