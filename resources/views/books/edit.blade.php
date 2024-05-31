@extends('layouts.mainlayout')

@section('title', 'Book-edit')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@section('content')
    <h2>Book Edit</h2>

    <div class="mt-5 w-50">
        <form action="/book-edit/{{ $book->slug }}" method="POST" enctype="multipart/form-data">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf

            <div class="mb-3">
                <label for="code">Code :</label>
                <input type="text" autocomplete="off" name="book_code" id="code" value="{{ $book->book_code }}"
                    class="form-control mt-3">
            </div>

            <div class="mb-3">
                <label for="title">Title :</label>
                <input type="text" autocomplete="off" name="title" id="title" value="{{ $book->title }}"
                    class="form-control mt-3">
            </div>

            <div class="mb-3">
                <label for="description">Description :</label>
                <textarea name="description" id="description" class="form-control mt-3">{{ $book->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price">Price :</label>
                <div class="input-group mt-3">
                    <span class="input-group-text">Rp</span>
                    <input type="number" autocomplete="off" name="price" id="price" value="{{ $book->price }}"
                        class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label for="image" style="display: block">Image :</label>
                @if ($book->cover != '')
                    <img src="{{ asset('storage/cover/' . $book->cover) }}" style="margin-top: 10px; width="125px"">
                @else
                    <img src="{{ asset('images/cover-not-available.jpg') }}" width="125px">
                @endif
                <input type="file" name="image" class="form-control mt-2">
            </div>

            <div class="mb-3">
                <label for="category">Category :</label>
                <select name="categories[]" id="category" class="form-control select-multiple mt-3" multiple>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ $book->categories->contains($item->id) ? 'selected' : '' }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="ListCategory">List Category :</label>
                <ul>
                    @foreach ($book->categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="/books" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });
    </script>
@endsection
