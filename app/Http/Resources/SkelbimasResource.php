<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkelbimasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     */
    public function toArray(Request $request): array
    {
       return [
            'pavadinimas' => $this->pavadinimas,
            'aprasymas'   => $this->aprasymas,
            'kaina'       => (float) $this->kaina,
            'tipas'       => $this->tipas,
            'statusas'    => $this->statusas,
            'kategorija'  => new KategorijaResource($this->whenLoaded('kategorija')),
            'pardavejas'  => new UserResource($this->whenLoaded('user')),
            'nuotraukos'  => SkelbimuNuotraukaResource::collection($this->whenLoaded('nuotraukos')),
            'sukurta'     => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
