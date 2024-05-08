@extends('layouts.mainlayout')

@section('title','Book List')

@section('content')

<h2>Book List</h2>

<form action="" method="GET">
    <div class="row mt-5">
        <div class="col-12 col-sm-6">
            <select name="category" id="category" class="form-control">
                <option value="">Select Category</option>
                @foreach ($category as $item)
                    <option value="{{$item->id}}" {{ $item->id == $request->category ? 'selected' : '' }}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6">
            <div class="input-group mb-3">
                <input type="text" name="title" id="title" class="form-control" placeholder="Search books title" value="{{ $request->title }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>


<div class="my-4 h-100">
    <div class="row">
            @foreach ($book as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                    <img src="{{$item->cover != "" ? asset ('storage/cover/'.$item->cover) : asset ('images/cover-not-available.jpg')}}" class="card-img-top" draggable="false">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->book_code}}</h5>
                        <p class="card-text">{{$item->title}}</p>
                        <p class="card-text text-end fw-semibold {{$item->status == "in stock" ? 'text-success' : 'text-danger'}}">{{$item->status}}</p>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection