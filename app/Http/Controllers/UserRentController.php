<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class UserRentController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('user-rent', ['books' => $books]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();

        // Validasi apakah buku telah dipilih
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ], [
            'book_id.required' => 'Please select a book max 3.'
        ]);

        $rent_date = Carbon::now()->toDateString();
        $return_date = Carbon::now()->addDay(3)->toDateString();

        $book = Book::findOrFail($request->book_id);
        if ($book->status == 'not available') {
            Session::flash('message', 'Cannot rent, the book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('user-rent');
        }

        $count = RentLogs::where('user_id', $user_id)->where('actual_return_date', null)->count();
        if ($count >= 3) {
            Session::flash('message', 'Cannot rent, the book has limit');
            Session::flash('alert-class', 'alert-danger');
            return redirect('user-rent');
        }

        try {
            DB::beginTransaction();

            // Update status buku menjadi 'not available'
            $book->status = 'not available';
            $book->save();

            // Tambahkan catatan peminjaman baru
            RentLogs::create([
                'user_id' => $user_id,
                'book_id' => $request->book_id,
                'rent_date' => $rent_date,
                'return_date' => $return_date,
            ]);

            DB::commit();

            Session::flash('message', 'Book rental was successful');
            Session::flash('alert-class', 'alert-success');
            return redirect('user-rent');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    public function return()
    {
        // Mendapatkan ID pengguna yang terautentikasi saat ini
        $user_id = Auth::id();

        // Mengambil data buku yang dipinjam oleh pengguna yang sedang login
        $rentlog = RentLogs::where('user_id', $user_id)
            ->where('actual_return_date', '=', null)
            ->with('book') // Mengambil relasi buku
            ->get();


        // Mengembalikan tampilan dengan data buku yang dipinjam
        return view('user-return-book', ['rentlog' => $rentlog]);
    }

    public function returnbook(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'book_id' => 'required|exists:books,id'
        ], [
            'book_id.required' => 'Please select a book.'
        ]);

        $rent = RentLogs::where('user_id', $user_id)->where('book_id', $request->book_id)->where('actual_return_date', '=', null);
        $rentData = $rent->first();
        $countData = $rent->count();

        if ($countData == 1) {
            $rentData->actual_return_date = Carbon::now()->toDateString();
            $rentData->save();

            $books = Book::findOrFail($request->book_id);
            $books->status = 'in stock';
            $books->save();

            Session::flash('message', 'Return Book Successfully');
            Session::flash('alert-class', 'alert-success');
            return redirect('user-return-book');
        } else {
            Session::flash('message', 'Cannot return,the book not yet borrow');
            Session::flash('alert-class', 'alert-danger');
            return redirect('user-return-book');
        }
    }
}
