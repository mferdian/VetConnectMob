<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'no_telp' => $this->no_telp,
            'umur' => $this->umur,
            'alamat' => $this->alamat,
            'profile_photo_url' => $this->profile_photo ? asset('storage/' . $this->profile_photo) : null,
            'is_admin' => $this->is_admin,
        ];
    }
}
