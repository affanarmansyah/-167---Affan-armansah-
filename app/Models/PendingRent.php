<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingRent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rent_date',
        'return_date',
        'status',
        'price',
    ];

    // Hubungan dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan dengan model Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
