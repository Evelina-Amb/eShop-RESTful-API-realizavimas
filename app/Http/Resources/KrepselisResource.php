<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KrepselisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'kiekis'   => $this->kiekis,
            'preke'    => new SkelbimasResource($this->whenLoaded('skelbimas')),
            'vartotojas' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
