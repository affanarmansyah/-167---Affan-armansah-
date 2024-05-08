<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RentLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $user = User::where([
            ['username', '!=', 'admin'],
            ['status', '=', 'active'],
        ])->get();
        return view('book-rent', ['books' => $books, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ], [
            'book_id.required' => 'Please select a book max 3.'
        ]);

        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();

        $books = Book::findOrFail($request->book_id)->only('status');

        if ($books['status'] == 'not available') {
            Session::flash('message', 'Cannot rent,the book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        } else {
            $count = RentLogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count();
            if ($count >= 3) {
                Session::flash('message', 'Cannot rent,the book has limit');
                Session::flash('alert-class', 'alert-danger');
                return redirect('book-rent');
            } else {
                try {
                    //code...
                    DB::beginTransaction();
                    $books = Book::findOrFail($request->book_id);
                    $books->status = 'not available';
                    $books->save();

                    RentLogs::create($request->all());
                    DB::commit();

                    Session::flash('message', 'book rental was successful');
                    Session::flash('alert-class', 'alert-success');
                    return redirect('book-rent');
                } catch (\Throwable $th) {
                    throw $th;
                    DB::rollBack();
                }
            }
        }
    }
}
