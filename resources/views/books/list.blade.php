@extends('layouts.mainlayout')

@section('title', 'Book List')

@section('content')

    <h2>Book List</h2>

    <form action="" method="GET">
        <div class="row mt-5">
            <div class="col-12 col-sm-6">
                <select name="category" id="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($category as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $request->category ? 'selected' : '' }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6">
                <div class="input-group mb-3">
                    <input type="text" name="title" id="title" class="form-control"
                        placeholder="Search books title" value="{{ $request->title }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </div>
    </form>

    @if ($book->isEmpty())
        <div class="alert alert-warning" role="alert">
            Upss,Book Not found.
        </div>
    @else
        <div class="my-4 h-100">
            <div class="row">
                @foreach ($book as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card h-100">
                            <img src="{{ $item->cover != '' ? asset('storage/cover/' . $item->cover) : asset('images/cover-not-available.jpg') }}"
                                class="card-img-top" style="width: 100%; object-fit: cover; height: 200px;"
                                draggable="false">

                            <div class="card-body">
                                <h5 class="card-title">{{ $item->book_code }}</h5>
                                <p class="card-text">{{ $item->title }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#bookDetailModal{{ $item->id }}">See Detail</a>
                                    <p
                                        class="card-text fw-semibold mb-0 {{ $item->status == 'in stock' ? 'text-success' : 'text-danger' }}">
                                        {{ $item->status }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="bookDetailModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="bookDetailModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookDetailModalLabel{{ $item->id }}">Book Detail</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ $item->cover != '' ? asset('storage/cover/' . $item->cover) : asset('images/cover-not-available.jpg') }}"
                                                class="img-fluid mb-3" alt="Book Cover">
                                        </div>
                                        <div class="col-md-8">
                                            <h6>Code: {{ $item->book_code }}</h6>
                                            <h6>Title: {{ $item->title }}</h6>
                                            <h6>Description:</h6>
                                            <p>{{ $item->description }}</p>
                                            <p class="text-danger">Price: Rp{{ number_format($item->price, 3, '.', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if (auth()->check())
                                        @if ($item->status == 'in stock')
                                            @if (auth()->user()->role_id == 1)
                                                <a href="/book-rent" class="btn btn-primary">Rent Book</a>
                                            @elseif (auth()->user()->role_id == 2)
                                                <a href="/user-rent" class="btn btn-primary">Rent Book</a>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-primary" disabled>Rent Book</button>
                                        @endif
                                    @else
                                        <a href="login" class="btn btn-primary">Login to Rent</a>
                                    @endif
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
