<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rental Buku | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }} ">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="main d-flex flex-column justify-content-between">
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Book Rental</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="body-content h-100">
            <div class="row g-0 h-100">
                <div class="sidebar col-lg-2 collapse d-lg-block" id="navbarSupportedContent">
                    @if (Auth::user())
                        @if (Auth::user()->role_id == 1)
                            <a href="/dashboard" class=" {{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a>
                            <a href="/books"
                                class=" {{ Request::is('books', 'book-add', 'book-edit/*') ? 'active' : '' }}">Books</a>
                            <a href="/categories"
                                class="{{ Request::is('categories', 'category-add', 'category-edit/*') ? 'active' : '' }}">Categories</a>
                            <a href="/users"
                                class=" {{ Request::is('users', 'registered-user', 'detail-user/*', 'user-approve/*') ? 'active' : '' }}">Users</a>
                            <a href="/rent-logs" class=" {{ Request::is('rent-logs') ? 'active' : '' }}">Rent Log</a>
                            <a href="/" class=" {{ Request::is('/') ? 'active' : '' }}">Book List</a>
                            <a href="/book-rent" class=" {{ Request::is('book-rent') ? 'active' : '' }}">Book Rent</a>
                            <a href="/book-return" class=" {{ Request::is('book-return') ? 'active' : '' }}">Book
                                Return</a>
                            <a href="/logout" onclick="return confirm('Are you sure want to Logout ?')">Logout</a>
                        @else
                            <a href="/profile" class="{{ Request::is('profile') ? 'active' : '' }}">Profile</a>
                            <a href="/profile-edit" class="{{ Request::is('profile-edit') ? 'active' : '' }}">Edit
                                Profile</a>
                            <a href="/" class=" {{ Request::is('/') ? 'active' : '' }}">Book List</a>
                            <a href="/user-rent" class=" {{ Request::is('user-rent') ? 'active' : '' }}">Book Rent</a>
                            <a href="/user-return-book"
                                class=" {{ Request::is('user-return-book') ? 'active' : '' }}">Book Return</a>

                            <a href="/logout" onclick="return confirm('Are you sure want to Logout ?')">Logout</a>
                        @endif
                    @else
                        <a href="login">Login</a>
                    @endif
                </div>
                <div class="content col-lg-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
