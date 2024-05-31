<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentLogs extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable =
    [
        'user_id',
        'book_id',
        'rent_date',
        'return_date',
        'approval_status'
    ];

    /**
     * Get the user that owns the RentLogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the Book that owns the RentLogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
