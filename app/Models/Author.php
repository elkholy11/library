<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ar_name', 'bio', 'status'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getNameAttribute($value)
    {
        if (app()->getLocale() == 'ar' && $this->ar_name) {
            return $this->ar_name;
        }
        return $value;
    }
}
