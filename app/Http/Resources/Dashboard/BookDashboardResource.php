<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BookDashboardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author ? [
                'id' => $this->author->id,
                'name' => app()->getLocale() === 'ar' ? $this->author->ar_name : $this->author->name,
            ] : null,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => app()->getLocale() === 'ar' ? $this->category->ar_name : $this->category->name,
            ] : null,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
} 