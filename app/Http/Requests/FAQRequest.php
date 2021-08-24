<?php

namespace App\Http\Requests;

use App\Exceptions\FormRequestException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class FAQRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('is-reception');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = strtoupper($this->getMethod());
        $id = $method == 'POST' ? null : $this->route('frequently_asked_question');
        return [
            'question' => $method == 'POST'
                    ? 'required|string|unique:frequently_asked_questions'
                    : ['required', 'string', Rule::unique('frequently_asked_questions')->ignore($id)],
            'answer' => 'required|string',
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
