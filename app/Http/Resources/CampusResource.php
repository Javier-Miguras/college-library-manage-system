<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampusResource extends JsonResource
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
            'town' => [
                "id" => $this->town->id,
                "name" => $this->town->name,
            ],
            "city" => [
                "id" => $this->city->id,
                "name" => $this->city->name,
            ]
        ];
    }
}
