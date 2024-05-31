<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
  /* CSS untuk menengahkan vertikal secara manual */
  html, body {
    height: 100%;
  }
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url('storage/cover/library.jpg'); /* Ganti URL gambar sesuai dengan gambar yang Anda inginkan */
    background-size: cover;
    background-position: center;
    backdrop-filter: blur(4px); /* Menambahkan efek blur */
  }
  .card-body {
    padding: 2rem;
    background-color: rgba(207, 152, 88, 0.5); /* Transparansi putih pada card */
  }
</style>
  
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-3" style="width: 30%">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="">
            @csrf

            @if (session('status'))
            <div class="alert alert-success">
              {{ session('message') }}
            </div>
            @endif

        @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif

            <div class="">
              <label for="name" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="{{old('username')}}">
            </div>
            <div class="">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" >
            </div>
            <div class="">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">address</label>
              <textarea name="address" id="address" class="form-control" rows="5">{{ old('address') }}</textarea>
          </div>          
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <div class="text-center mt-1">
                Have account? <a href="login" class="text-decoration-none">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
