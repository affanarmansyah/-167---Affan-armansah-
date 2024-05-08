@extends('layouts.mainlayout')

@section('title','Rent-log')

@section('content')
    <h1>Rent log</h1>
    
    <x-rent-log-table :rentlog='$rentlog' />
@endsection