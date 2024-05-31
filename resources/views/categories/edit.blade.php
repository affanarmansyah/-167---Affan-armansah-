@extends('layouts.mainlayout')

@section('title','Category-edit')

@section('content')
    <h2>Edit Category</h2>

    <div class="mt-5 w-50">
        @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
            @endif

        <form action="/category-edit/{{$category->slug}}" method="POST">
            @csrf
            @method('put')
            <div>
                <label for="name">Name</label>
                <input type="text" autocomplete="off" name="name" id="name" value="{{$category->name}}" class="form-control mt-3" placeholder="Category Name">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="/categories" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>
@endsection