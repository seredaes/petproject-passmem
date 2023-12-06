<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;


class UserListDeleteRequest extends FormRequest
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
            'id' => 'required|max:250|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Поле id - обязательное поле',
            'id.min' => 'Минимальная длина поля id 4 символа',
            'id.max' => 'Максимальная длина поля id 250 символов',
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
