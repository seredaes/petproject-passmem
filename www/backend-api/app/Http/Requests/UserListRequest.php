<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;


class UserListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:250|min:1',
            'login' => 'required|max:250|min:1',
            'password' => 'required|max:250|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле title - обязательное поле',
            'title.min' => 'Минимальная длина поля title 4 символа',
            'title.max' => 'Максимальная длина поля title 250 символов',
            'login.required' => 'Поле login - обязательное поле',
            'login.min' => 'Минимальная длина поля login 4 символа',
            'login.max' => 'Максимальная длина поля login 250 символов',
            'password.required' => 'Поле password - обязательное поле',
            'password.min' => 'Минимальная длина поля password 4 символа',
            'password.max' => 'Максимальная длина поля password 250 символов'
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            "status" => "error",
            "message" => "Validation errors",
            "data" => $validator->errors()
        ], 422));
    }
}
