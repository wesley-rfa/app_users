<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:50',
            'email' => "required|email|unique:users,email,{$this->user},id"
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres',
            'name.max' => 'O nome deve ter no máximo 50 caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'O e-mail informado é inválido',
            'email.unique' => 'O e-mail informado já está cadastrado'
        ];
    }
}
