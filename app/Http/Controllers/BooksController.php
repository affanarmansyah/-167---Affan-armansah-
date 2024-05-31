<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\RentLogs;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BooksController extends Controller
{
    public function index()
    {
        Debugbar::info([1]);
        $book = Book::all();
        $bookDeleted = Book::onlyTrashed()->get();
        return view('books.books', ["book" => $book, "bookDeleted" => $bookDeleted]);
    }

    public function add()
    {
        $categories = Category::all();
        return view('books.add', ['categories' => $categories]);
    }

    public function create(request $request)
    {
        $validated = $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'title' => 'required|max:255',
        ]);

        $newname = "";
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newname = $request->title . '-' . now()->timestamp . '.' . $extension;
            $request->file('image')->storeAs('cover', $newname);
        }

        $request['cover'] = $newname;
        $book = Book::create($request->all());
        $book->categories()->sync($request->categories);
        return redirect('books')->with(['success' => 'Add new book successfully']);
    }

    public function edit($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $categories = Category::all();
        return view('books.edit', ['book' => $book, 'categories' => $categories]);
    }

    public function update(request $request, $slug)
    {
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newname = $request->title . '-' . now()->timestamp . '.' . $extension;
            $request->file('image')->storeAs('cover', $newname);
            $request['cover'] = $newname;
        }


        $book = Book::where('slug', $slug)->first();
        $book->slug = null;
        $book->update($request->all());

        if ($request->categories) {
            $book->categories()->sync($request->categories);
        }

        return redirect('books')->with(['success' => 'Updated book successfully']);
    }

    public function destroy($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $book->rentLogs()->delete();
        $book->delete();

        return redirect('books')->with(['success' => 'Deleted book successfully']);
    }

    public function restore($slug)
    {
        $bookRestore = Book::withTrashed()->where('slug', $slug)->first();
        $bookRestore->rentLogs()->restore();
        $bookRestore->restore();

        return redirect('books')->with(['success' => 'Restore book successfully']);
    }

    public function return()
    {
        $users = User::where('username', '!=', 'admin')
            ->where('status', '=', 'active')
            ->get();

        $rentLogs = RentLogs::whereIn('user_id', $users->pluck('id'))
            ->where('approval_status', 'approved')
            ->whereNull('actual_return_date')
            ->with(['user', 'book'])
            ->get();

        return view('books.return', ['users' => $users, 'rentLogs' => $rentLogs]);
    }


    public function returnbook(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id'
        ], [
            'user_id.required' => 'Please select a user.',
            'book_id.required' => 'Please select a book.'
        ]);

        $rent = RentLogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)->where('actual_return_date', '=', null);
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
            return redirect('book-return');
        } else {
            Session::flash('message', 'Cannot return,the book not yet borrow');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-return');
        }
    }

    public function getbook($id)
    {
        $books = RentLogs::where('user_id', $id)
            ->where('approval_status', 'approved')
            ->whereNull('actual_return_date')
            ->with('book')
            ->get()
            ->pluck('book');
        return response()->json($books);
    }
}
