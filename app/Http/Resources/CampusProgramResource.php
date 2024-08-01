<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampusProgramResource extends JsonResource
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
            'campus' => [
                'id' => $this->campus->id,
                'name' => $this->campus->town->name
            ],
            'academic program' => [
                'id' => $this->program->id,
                'name' => $this->program->name
            ]
        ];
    }
}
