<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->title,
            'title_en' => $this->title_en,
            'slug' => $this->slug,
            'description' => $this->description,
            'description_en' => $this->description_en,
            'isbn' => $this->isbn,
            'publisher' => $this->publisher,
            'publication_date' => $this->publication_date,
            'pages' => $this->pages,
            'language' => $this->language,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'quantity' => $this->quantity,
            'available_quantity' => $this->available_quantity,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
