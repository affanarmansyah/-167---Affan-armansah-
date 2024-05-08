<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'book_code',
        'title',
        'slug',
        'cover',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The categories that belong to the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }

    /**
     * Get all of the rentLogs for the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentLogs(): HasMany
    {
        return $this->hasMany(RentLogs::class);
    }
}
