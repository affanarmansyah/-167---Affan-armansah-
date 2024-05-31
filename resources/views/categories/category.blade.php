@extends('layouts.mainlayout')

@section('title', 'Category')

@section('content')
    <h2>Category List</h2>

    <div>
        <a href="category-add"class="btn btn-primary mt-5">Add Category</a>
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
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                            <a href="/category-edit/{{ $data->slug }}"><i class="bi bi-pencil text-primary"></i></a>
                            <a href="/category-destroy/{{ $data->slug }}"
                                onclick="return confirm('Are you sure want to delete this category {{ $data->name }}?')"><i
                                    class="bi bi-trash3 text-danger"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 style="margin-top: 100px">List Deleted Category</h2>

    <div class="my-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($deletedCategory->isEmpty())
                    <tr>
                        <td colspan="3">There are no deleted categories</td>
                    </tr>
                @else
                    @foreach ($deletedCategory as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                <a href="/category-restore/{{ $data->slug }}"><i
                                        class="bi bi-arrow-clockwise text-danger"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
