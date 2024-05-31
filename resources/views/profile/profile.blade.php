@extends('layouts.mainlayout')

@section('title', 'Profile')

@section('content')

    <h2 class="mt-2">Welcome {{ Auth::user()->username }},</h2>
    <h4>This is your book rental list</h4>


    <div class="mt-5">
        <x-rent-log-table :rentlog='$rentlog' />
    </div>
@endsection
