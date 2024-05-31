@extends('layouts.mainlayout')

@section('title', 'Book Rent')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .form-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-title {
            color: #333;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

    <div class="col-12 col-md-8 offset-md-2 col-lg-5 offset-md-3 form-container mb-5">
        <h1 class="form-title">Book Rent Form</h1>

        <div class="mt-5">
            @if (session('message'))
                <div class="alert {{ session('alert-class') }}">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="book-rent" method="post">
            @csrf
            <div class="mb-3">
                <label for="user" class="form-label fw-semibold">User :</label>
                <select name="user_id" id="user" class="form-control input-box">
                    <option value="" disabled selected>Select User</option>
                    @foreach ($user as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="book" class="form-label fw-semibold">Book :</label>
                <select name="book_id" id="book" class="form-control input-box">
                    <option value="" disabled selected>Select Book</option>
                    @foreach ($books as $book)
                        @if ($book->status == 'not available')
                            <option value="{{ $book->id }}" disabled data-price="{{ $book->price }}">
                                {{ $book->book_code }} - {{ $book->title }} - {{ $book->status }}</option>
                        @else
                            <option value="{{ $book->id }}" data-price="{{ $book->price }}">
                                {{ $book->book_code }}
                                - {{ $book->title }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label fw-semibold">Rent Price:</label>
                <input type="text" id="price" class="form-control text-danger text-start" readonly>
            </div>
            <div>
                <button type="submit" class="btn btn-primary w-100 submit-btn">Submit</button>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-5 w-50">
            {{ session('success') }}
        </div>
    @endif

    <h3>Approve rent book</h3>

    <div class="my-4">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Book</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rentalsPendingApproval as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->user->username }}</td>
                        <td>{{ $data->book->title }}</td>
                        <td>
                            <a href="/rent-approve/{{ $data->id }}" class="btn btn-primary">Agree</a>
                            <a href="/rent-unapprove/{{ $data->id }}" class="btn btn-danger">Disagree</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No Request</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.input-box').select2();

            $('#book').change(function() {
                var price = $(this).find('option:selected').data('price');
                $('#price').val(price ? 'Rp.' + price : 'Rp.-');
            });

            // Set default value for price when no book is selected
            $('#book').trigger('change');
        });
    </script>
@endsection
