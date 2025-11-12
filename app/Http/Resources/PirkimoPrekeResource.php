<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PirkimoPrekeResource extends JsonResource
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
            'kaina'    => (float) $this->kaina,
            'skelbimas'=> new SkelbimasResource($this->whenLoaded('skelbimas')),
        ];
    }
}
