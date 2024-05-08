@extends('layouts.mainlayout')

@section('title','Category-add')

@section('content')
    <h2>Add New Category</h2>

    <div class="mt-5 w-50">
        <form action="category-add" method="POST">
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
            <div>
                <label for="name">Name</label>
                <input type="text" autocomplete="off" name="name" id="name" class="form-control mt-3" placeholder="Category Name">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="categories" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>
@endsection