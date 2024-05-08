<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $books = Book::count();
        $categories = Category::count();

        return response()->json([
            'message' => 'The dashboard has been successfully accessed',
            'data' => [
                'Users' => $users,
                'Books' => $books,
                'Categories' => $categories
            ]
        ]);
    }
}
