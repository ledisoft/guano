<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'name' => $this->getFullName(),
            'email' => $this->email,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getPermissionsNames(),
        ];
    }
}
