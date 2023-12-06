<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;


class UserRequest extends FormRequest
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
            'name' => 'bail|required|max:250|min:4',
            'email' => 'bail|required|max:250|min:4|email|unique:users',
            'password' => 'bail|required|max:250|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'bail|required|max:250|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя пользователя обязательное поле',
            'name.min' => 'Минимальная длина имени пользователя 4 символа',
            'name.max' => 'Максималная длина имени пользователя 250 символов',
            'email.required' => 'Email обязательное поле',
            'email.email' => 'Email - неверный формат',
            'email.min' => 'Минимальная длина email 4 символа',
            'email.max' => 'Максимальная длина email 250 символов',
            'email.unique' => 'Данный email уже занят',
            'password.required' => 'Пароль - обязательное поле',
            'password.min' => 'Минимальная длина пароля 8 символов',
            'password.max' => 'Максимальная длина пароля 250 символов',
            'password_confirmation.required' => 'Повторный пароль - обязательное поле',
            'password_confirmation.min' => 'Минимальная длина поля пароль повторение 8 символов',
            'password_confirmation.max' => 'Максимальная длина поля пароль повторение 250 символов',
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
