<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\RentLogs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $categories = Category::count();
        $users = User::count();
        $rentlog = RentLogs::with(['user', 'book'])->where('approval_status', 'approved')->get();
        return view('dashboard', [
            'book_count' => $books,
            'categoy_count' => $categories,
            'user_count' => $users,
            'rentlog' => $rentlog,
        ]);
    }
}
