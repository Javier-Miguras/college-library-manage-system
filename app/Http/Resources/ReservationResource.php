<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'created_at' => $this->created_at,
            'expiration_date' => $this->expiration_date,
            'status' => $this->status,
            'book' => [
                'id' => $this->book->id,
                'title' => $this->book->title,
                'author' => $this->book->author->name . ' ' . $this->book->author->lastname,
                'publication_year' => $this->book->publication_year,
                'category' => [
                    'id' => $this->book->category->id,
                    'name' => $this->book->category->name,
                ]
            ]
        ];
    }
}
