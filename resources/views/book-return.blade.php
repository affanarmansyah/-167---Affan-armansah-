@extends('layouts.mainlayout')

@section('title', 'Book Return')

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

<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-md-3 form-container">
    <h1 class="form-title">Book Return Form</h1>

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

    <form action="book-return" method="post">

        @csrf
        <div>
            <label for="user" class="form-label fw-semibold">User :</label>
            <select name="user_id" id="user" class="form-control input-box">
                <option value="" disabled selected>Select User</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->username}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 mt-3">
            <label for="book" class="form-label fw-semibold">Book :</label>
            <select name="book_id" id="book" class="form-control input-box">
                <option value="" disabled selected>Select Book</option>
                @foreach ($rentLogs as $log)
                <option value="{{$log->book->id}}">{{$log->user->username}} | {{$log->book->book_code}} | {{$log->book->title}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary w-100 submit-btn">Submit</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.input-box').select2();
    });
</script>
@endsection


{{-- 
@extends('layouts.mainlayout')

@section('title','Book Return')

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

{{-- <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-md-3 form-container">
    <h1 class="form-title">Book Return Form</h1>

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

    <form action="book-return" method="post">
        @csrf
        <div>
            <label for="user" class="form-label fw-semibold">User :</label>
            <select name="user_id" id="user" class="form-control input-box">
                <option value="" disabled selected>Select User</option>
                @foreach ($rentLogs as $item)
                <option value="{{$item->user->id}}">{{$item->user->username}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 mt-3">
            <label for="book" class="form-label fw-semibold">Book :</label>
            <select name="book_id" id="book" class="form-control input-box">
                <option value="" disabled selected>Select Book</option>
                @foreach ($rentLogs as $item)
                <option value="{{$item->book->id}}">{{$item->book->book_code}} {{$item->book->title}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary w-100 submit-btn">Submit</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.input-box').select2();
    });
</script>
@endsection --}} 
