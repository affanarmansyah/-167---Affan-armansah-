@extends('layouts.mainlayout')

@section('title', 'Registered-User')

@section('content')

    <h1>Registered User</h1>

    <div class="d-flex justify-content-end mt-5">
        <a href="users"class="btn btn-primary">Approved User</a>
    </div>

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
                @if ($registeredUser->isEmpty())
                    <td colspan="4">There are no inactive users.</td>
            </tr>
        @else
            <tbody>
                @foreach ($registeredUser as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <a href="/detail-user/{{ $item->slug }}" style="text-decoration: none">Approve</a>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
