<?php

namespace App\Http\Requests;

class LoginRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'email|required',
            'password' => 'required|string'
        ];
    }
}
