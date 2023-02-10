<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $accessToken = $this->createToken('authToken')->plainTextToken;
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];

        return [
            'data' => $data,
            'access_token' => $accessToken
        ];
    }
}
