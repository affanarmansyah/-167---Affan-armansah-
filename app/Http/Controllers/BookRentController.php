<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PendingRent;
use App\Models\RentLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    public function index()
    {
        $rentalsPendingApproval = PendingRent::where('status', 'pending')->get();
        $books = Book::all();
        $user = User::where([
            ['username', '!=', 'admin'],
            ['status', '=', 'active'],
        ])->get();

        return view('books.rent', ['books' => $books, 'user' => $user, 'rentalsPendingApproval' => $rentalsPendingApproval]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $role_id = Auth::user()->username;

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => 'Please select a user.',
            'book_id.required' => 'Please select a book.'
        ]);

        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();

        $book = Book::findOrFail($request->book_id);

        if ($book->status == 'not available') {
            Session::flash('message', 'Cannot rent, the book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }

        $count = RentLogs::where('user_id', $user_id)->where('actual_return_date', null)->where('approval_status', 'approved')->count();
        if ($count >= 3) {
            Session::flash('message', 'Cannot rent, the book has limit');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }

        try {
            DB::beginTransaction();

            if ($role_id === 'admin') {
                // Admin approval
                $rentLog = RentLogs::create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'rent_date' => $request['rent_date'],
                    'return_date' => $request['return_date'],
                    'approval_status' => 'approved',
                ]);

                $book->status = 'not available';
                $book->save();

                Session::flash('message', 'Book rental was successful');
                Session::flash('alert-class', 'alert-success');
            } else {
                // User pending approval
                PendingRent::create([
                    'user_id' => $user_id,
                    'book_id' => $request->book_id,
                    'rent_date' => $request['rent_date'],
                    'return_date' => $request['return_date'],
                    'status' => 'pending'
                ]);

                Session::flash('message', 'Book rental request has been submitted and is pending approval.');
                Session::flash('alert-class', 'alert-success');
            }

            DB::commit();
            return redirect('book-rent');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function approve($id)
    {
        $pendingRental = PendingRent::findOrFail($id);

        // Pastikan price tidak null sebelum menyetujui
        // if ($pendingRental->price === null) {
        //     $pendingRental->price = $pendingRental->book->price;
        // }

        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();

        // Menambahkan data peminjaman ke RentLogs
        $rentLogs = RentLogs::create([
            'user_id' => $pendingRental->user_id,
            'book_id' => $pendingRental->book_id,
            'price' => $pendingRental->price,
            'rent_date' => $request['rent_date'],
            'return_date' => $request['return_date'],
            'approval_status' => 'approved'
        ]);

        $pendingRental->status = 'approved';
        $pendingRental->save();

        // Mengubah status buku menjadi "not available"
        $book = Book::findOrFail($rentLogs->book_id);
        $book->status = 'not available';
        $book->save();

        return redirect('book-rent/')->with(['success' => 'Rent approval successful']);
    }



    public function unapprove($id)
    {
        $pendingRental = PendingRent::findOrFail($id);

        // Menambahkan data peminjaman ke RentLogs dengan rent_date dan return_date null
        RentLogs::create([
            'user_id' => $pendingRental->user_id,
            'book_id' => $pendingRental->book_id,
            'price' => $pendingRental->price,
            'rent_date' => null,
            'return_date' => null,
            'approval_status' => 'rejected'
        ]);

        // Mengubah status pending rental menjadi 'rejected' dan mengatur rent_date serta return_date menjadi null
        $pendingRental->status = 'rejected';
        $pendingRental->rent_date = null;
        $pendingRental->return_date = null;
        $pendingRental->price = null;
        $pendingRental->save();

        // Mengubah status buku menjadi "in stock"
        $book = Book::findOrFail($pendingRental->book_id);
        $book->status = 'in stock';
        $book->save();

        return redirect('book-rent/')->with(['success' => 'Rent rejection successful']);
    }
}
