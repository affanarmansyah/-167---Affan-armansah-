@extends('layouts.mainlayout')

@section('title','User')

@section('content')

<h3>User List</h3>

<div class="d-flex justify-content-end mt-5">
    <a href="registered-user"class="btn btn-primary">Approve User</a>
</div>

@if(Session::has('success'))
<p class="alert alert-success mt-5">{{ Session::get('success') }}</p>
@endif

    <div class="my-3">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->phone}}</td>
                        <td>
                            <a href="/detail-user/{{$item->slug}}"><i class="bi bi-info-circle"></i></a>
                            <a href="/destroy-user/{{$item->slug}}" onclick="return confirm('Are you sure want to ban username {{$item->username}} ?')"><i class="bi bi-ban text-danger"></i></a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    
    <h3 class="mt-5">Ban user list</h3>

    <div class="my-3">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tr>
                @if ($deleteUser->isEmpty())
                <td colspan="4">Tidak ada user yang terhapus</td>
            </tr>
                @else
            <tbody>
                @foreach ($deleteUser as $item)
                <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->phone}}</td>
                        <td>
                            <a href="/restore-user/{{$item->slug}}"><i class="bi bi-arrow-clockwise text-danger"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
@endsection