@extends('layouts.mainlayout')

@section('title','Book-add')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@section('content')
    <h2>Add New Book</h2>

    <div class="mt-5 w-50">
        <form action="book-add" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
            @endif
            <div class="mb-3">
                <label for="code">Code</label>
                <input type="text" autocomplete="off" name="book_code" id="code" value="{{old('book_code')}}" class="form-control mt-3" placeholder="Book's Code">
            </div>

            <div class="mb-3">
                <label for="title">Title</label>
                <input type="text" autocomplete="off" name="title" id="title" value="{{old('title')}}" class="form-control mt-3" placeholder="Book's Title'">
            </div>

            <div class="mb-2">
                <label for="image" style="margin-bottom: 30px; display: block">Image :</label>
                    <img src="{{asset('images/cover-not-available.jpg')}}" width="125px">
            </div>

            <div class="mb-3">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="categories[]" id="category" class="form-control select-multiple" multiple>
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="books" class="btn btn-primary">Back</a>
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