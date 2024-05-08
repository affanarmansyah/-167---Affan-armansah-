@extends('layouts.mainlayout')

@section('title','Registered-User')

@section('content')

<h1>Detail User</h1>

<div style="display: flex; justify-content: end; margin-top: 5px;">
    @if ($detailUser->status == 'inactive')
        <div style="display: flex; justify-content: flex-end;">
            <a href="/user-approve/{{$detailUser->slug}}" class="btn btn-info">Approve</a>
        </div>
    @endif
    @if ($detailUser->status == 'active')
        <div style="display: flex; justify-content: flex-end;">
            <a href="/user-unapprove/{{$detailUser->slug}}" class="btn btn-info">UnApprove</a>
        </div>
    @endif
    <a href="/registered-user" class="btn btn-info ms-2">Back</a>
</div>

<div class="mt-3">
    @if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
    @endif
</div>
<div class="my-5 w-25">
    <div class="mb-3">
        <label for="" class="form-label">Username :</label>
        <input type="text" class="form-control" value="{{$detailUser->username}}" readonly>
    </div>
    
    <div class="mb-3">
        <label for="" class="form-label">Phone :</label>
        <input type="text" class="form-control" value="{{$detailUser->phone}}" readonly>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Addres :</label>
        <input type="text" class="form-control" value="{{$detailUser->address}}" readonly>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Status :</label>
        <input type="text" class="form-control" value="{{$detailUser->status}}" readonly>
    </div>
</div>

<h2>Rent Log User's</h2>

<div class="mt-5">
    <x-rent-log-table :rentlog='$rentlog'/>
</div>
@endsection