<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BookResource;

class CategoryResource extends JsonResource
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
            'arabic_name' => $this->ar_name,
            'status' => $this->status,
            'books_count' => $this->whenCounted('books'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'books' => BookResource::collection($this->whenLoaded('books')),
        ];
    }
} 