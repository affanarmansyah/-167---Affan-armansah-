@extends('layouts.mainlayout')

@section('title', 'User Rent')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Custom CSS for the form */
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

    <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-md-3 form-container mb-5">
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
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="user-rent" method="post">
            @csrf
            <div class="mb-3">
                <label for="book" class="form-label fw-semibold">Book :</label>
                <select name="book_id" id="book" class="form-control input-box">
                    <option value="" disabled selected>Select Book</option>
                    @foreach ($books as $item)
                        @if ($item->status == 'not available')
                            <option value="{{ $item->id }}" disabled data-price="{{ $item->price }}">
                                {{ $item->book_code }} - {{ $item->title }} - {{ $item->status }}</option>
                        @else
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->book_code }}
                                - {{ $item->title }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label fw-semibold">Rent Price:</label>
                <input type="button" id="price" class="form-control text-danger text-start" disabled readonly>
            </div>
            <div>
                <button type="submit" class="btn btn-primary w-100 submit-btn">Submit</button>
            </div>
        </form>
    </div>

    <h3>Request book</h3>

    <div>
        <div class="mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Book</th>
                        <th>Rent Date</th>
                        <th>Return Date</th>
                        <th>Actual Return Date</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tr>
                    @if ($rentalsPendingApproval->isEmpty())
                        <td colspan="7">No Request</td>
                </tr>
            @else
                <tbody>
                    @foreach ($rentalsPendingApproval as $item)
                        <tr
                            class="{{ $item->status == 'pending' ? 'text-bg-info' : ($item->status == 'approved' ? 'text-bg-success' : 'text-bg-danger') }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->book->title }}</td>
                            <td>{{ $item->status == 'pending' || $item->status == 'approved' ? $item->rent_date : '-' . $item->rent_date }}
                            </td>
                            <td>{{ $item->status == 'pending' || $item->status == 'approved' ? $item->return_date : '-' . $item->return_date }}
                            <td>{{ $item->status == 'pending' || $item->status == 'approved' ? $item->actual_return_date : '-' . $item->actual_return_date }}
                            <td>{{ $item->status == 'pending' || $item->status == 'approved' ? 'Rp.' . $item->book->price : 'Rp. -' . $item->price }}
                            </td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach

                    @endif
                </tbody>
            </table>
        </div>
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
