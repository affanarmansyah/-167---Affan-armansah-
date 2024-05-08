@extends('layouts.mainlayout')

@section('title','Dashboard')

@section('content')
    
<h2>Welcome, {{Auth::user()->username}}</h2>

<div class="row mt-5">
    <div class="col-lg-4">
        <div class="card-data books">
            <div class="row">
                <div class="col-6"><i class="bi bi-journal-bookmark"></i></div>
                <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                    <div class="card-desc">Books</div>
                    <div class="card-count">{{$book_count}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-data category">
            <div class="row">
                <div class="col-6"><i class="bi bi-list-task"></i></div>
                <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                    <div class="card-desc">Categories</div>
                    <div class="card-count">{{$categoy_count}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-data user">
            <div class="row">
                <div class="col-6"><i class="bi bi-people"></i></div>
                <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                    <div class="card-desc">Users</div>
                    <div class="card-count">{{$user_count}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h2>Rent Log</h2>
    
    <x-rent-log-table :rentlog='$rentlog'/>
</div>
@endsection