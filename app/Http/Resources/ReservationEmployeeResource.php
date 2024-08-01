<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationEmployeeResource extends JsonResource
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
            'expiration_date' => $this->expiration_date,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name . ' ' . $this->user->lastname,
                'email' => $this->user->email,
                'role' => $this->user->role
            ],
            'book' => [
                'id' => $this->book->id,
                'isbn' => $this->book->isbn,
                'title' => $this->book->title,
                'author' => $this->book->author->name . ' ' . $this->book->author->lastname,
                'publication_year' => $this->book->publication_year,
                'category' => [
                    'id' => $this->book->category->id,
                    'name' => $this->book->category->name,
                ],
            ]
        ];
    }
}
