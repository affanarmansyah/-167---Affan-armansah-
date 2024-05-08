@extends('layouts.mainlayout')

@section('title','Edit Profile')

@section('content')

<h2 class="ms-3 mt-2">Edit Profile</h2>

<div class="container mt-5">
    <div class="row">
      <div class="col-md-3" style="width: 40%">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="profile-edit">
              @method('put')
              @csrf
              
              <div class="mt-3">
                @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
  
              <div class="">
                <label for="name" class="form-label">Username :</label>
                <input type="text" class="form-control" id="username" name="username" value="{{$auth->username}}">
              </div>
              <div class="">
                <label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" id="password" name="password" >
              </div>
              <div class="">
                <label for="phone" class="form-label">Phone :</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{$auth->phone}}">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">address :</label>
                <textarea name="address" id="address" class="form-control" rows="5">{{ $auth->address }}</textarea>
            </div>          
              <div class="">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
