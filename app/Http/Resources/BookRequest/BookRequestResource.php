<?php

namespace App\Http\Resources\BookRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookRequestResource extends JsonResource
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
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'request_date' => $this->request_date,
            'status' => $this->status,
            'notes' => $this->notes,
            'priority' => $this->priority,
            'approved_at' => $this->approved_at,
            'approved_by' => $this->approved_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'book' => $this->whenLoaded('book'),
            'user' => $this->whenLoaded('user'),
        ];
    }
}
