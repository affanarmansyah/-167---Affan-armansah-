<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();
        $bookQuery = Book::query();

        if ($request->filled('category')) {
            $bookQuery->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('title')) {
            $bookQuery->where('title', 'like', '%' . $request->title . '%');
        }

        $book = $bookQuery->get();

        return view('book-list', ['book' => $book, 'category' => $category, 'request' => $request]);
    }
}
