<?php

namespace App\Http\Requests;

class UserAvailabilityRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'available' => 'required|boolean',
            'date' => 'date_format:Y-m-d'
        ];
    }
}
