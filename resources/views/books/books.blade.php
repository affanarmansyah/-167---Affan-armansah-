@extends('layouts.mainlayout')

@section('title', 'Book')

@section('content')
    <h2>Book List</h2>

    <div>
        <a href="book-add" class="btn btn-primary mt-5">Add Book</a>
    </div>
    <div class="mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="my-3">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($book->isEmpty())
                    <tr>
                        <td colspan="6">Tidak ada data buku</td>
                    </tr>
                @else
                    @foreach ($book as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->book_code }}</td>
                            <td>{{ $item->title }}</td>
                            <td>

                                @foreach ($item->categories as $category)
                                    <li style="list-style: none;"> - {{ $category->name }}</li>
                                @endforeach

                            </td>
                            <td>
                                @if ($item->cover != '')
                                    <img src="{{ asset('storage/cover/' . $item->cover) }}"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/cover-not-available.jpg') }}"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @endif
                            </td>
                            <td>
                                <a href="/book-edit/{{ $item->slug }}"><i class="bi bi-pencil text-primary"></i></a>
                                <a href="/book-destroy/{{ $item->slug }}"
                                    onclick="return confirm('Are you sure want to delete this book {{ $item->name }}?')"><i
                                        class="bi bi-trash3 text-danger"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <h3 class="mt-5">Deleted Book List</h3>

    <div class="my-3">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($bookDeleted->isEmpty())
                    <tr>
                        <td colspan="6">There are no deleted books</td>
                    </tr>
                @else
                    @foreach ($bookDeleted as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->book_code }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                @foreach ($item->categories as $category)
                                    {{ $category->name }}
                                @endforeach
                            </td>
                            <td>
                                @if ($item->cover != '')
                                    <img src="{{ asset('storage/cover/' . $item->cover) }}"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/cover-not-available.jpg') }}"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @endif
                            </td>
                            <td>
                                <a href="/book-restore/{{ $item->slug }}"><i class="bi bi-arrow-clockwise"
                                        style="color: red"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection
