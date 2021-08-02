<?php

namespace App\Http\Requests;

use App\Exceptions\FormRequestException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class OnlineProcedureRequest extends FormRequest
{
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
    public function rules()
    {
        return [
            'online_request_id' => ['required', 'integer', Rule::exists('online_requests', 'id')],
            'responsible_bureau_id' => ['required', 'integer', Rule::exists('bureaus','id')],
            'description' => 'nullable|string',
            'step_number' => 'required|integer',
            'responsible_user_id' => 'sometimes|array|distinct|min:1',
            'responsible_user_id.*' => ['required', 'integer', Rule::exists('users', 'id')],
        ];
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
        $error = $error = $validator->errors()->toArray();
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
}
