<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Book::with('categories')->get();
            $bookList = BookResource::collection($books);

            return response()->json([
                'message' => 'Book List',
                'data' => $bookList
            ]);
        } catch (\Throwable) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
    }

    function generateRandomString($length = 50)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_code' => 'required|unique:books|max:255',
                'title' => 'required|max:255',
                'categories' => 'required', // Pastikan kategori disertakan sebagai array
                'categories.*' => 'exists:categories,id', // Pastikan ID kategori yang diberikan valid
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->all(),
                ], 404);
            }

            if ($request->image) {
                $imagename = $this->generateRandomString();
                $extension = $request->file('image')->extension();
                $image = $imagename . '.' . $extension;

                $request->file('image')->storeAs('cover', $image);
                $request['cover'] = $imagename . '.' . $extension;
            } else {
                $imagename = $request['cover'];
            }

            $book = Book::create($request->all());
            $categories = json_decode($request->categories);
            $book->categories()->sync($categories);
            // Hubungkan buku dengan kategori yang sesuai

            $addBook = new BookResource($book->loadMissing(['categories:id,name']));
            return response()->json([
                'message' => 'Added book successfully',
                'data' => $addBook
            ]);
        } catch (\Throwable) {
            return response()->json([
                'message' => 'failed to add book'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $detailBook = new BookResource($book);
            return response()->json([
                'message' => 'Detail Book',
                'data' => $detailBook
            ]);
        } catch (\Throwable) {
            return response()->json([
                'message' => 'Book with id ' . $id . ' not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        } catch (\Throwable) {
            return response()->json([
                'message' => [
                    'failed to update book',
                    'Book with id ' . $id . ' not found'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            $deleteBook = new BookResource($book);
            return response()->json([
                'message' => 'Deleted book successfully',
                'data' => $deleteBook
            ]);
        } catch (\Throwable) {
            return response()->json([
                'message' => [
                    'failed to delete book',
                    'Book with id ' . $id . ' not found'
                ]
            ], 404);
        }
    }

    public function restore($id)
    {
        try {
            $book = Book::withTrashed()->findOrFail($id);
            $book->restore();

            $restoreBook = new BookResource($book);
            return response()->json([
                'message' => 'Restore book successfully',
                'data' => $restoreBook,
            ]);
        } catch (\Throwable) {
            return response()->json([
                'message' => [
                    'failed to restore book',
                    'Book with id ' . $id . ' not found'
                ]
            ], 404);
        }
    }
}
