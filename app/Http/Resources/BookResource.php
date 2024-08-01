<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(Auth::user()->role == 2){
            $stock = new BookStockCollection($this->stock);
        }else{
            $stock = $this->stock;
        }

        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'summary' => $this->summary,
            'publication_year' => $this->publication_year,
            'stock' => $stock
        ];
    }
}
