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
            'code' => $this->book_code,
            'title' => $this->title,
            'cover' => $this->cover,
            'category' => $this->categories->pluck('name'),
            'created_at' => $this->created_at->format('d-m-Y')
        ];
    }
}
