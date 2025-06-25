<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'title_en', 'slug', 'description', 'description_en', 'isbn',
        'publisher', 'publication_date', 'pages', 'language', 'cover_image',
        'quantity', 'available_quantity', 'status', 'is_active', 'category_id', 'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'book_order')->withPivot('quantity')->withTimestamps();
    }
}
