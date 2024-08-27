@extends('layout/layout')
  
@section('content')

<div class="login-form">
    <div class="logo text-center">
      <img src="{{url('assets/images/logo.png')}}" class="logo img-fluid" alt="logo">
    </div>
    <div class="containt text-center">
        <p>Login to your MITAS</p>
    </div>
   
    <form action="{{ route('user.validate_login') }}" method="post">
        @csrf
        <div class="col-md-12 ">
            <label>User ID</label>
            <input type="email" class="form-control" @if(isset($_COOKIE['email'])) value="{{$_COOKIE['email']}}" @endif name="email">
            <span class="text-danger">
                @error('email')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="col-md-12 mt-4">
            <label>Password</label>
            <div class="custome-form-control">
                <input type="password" class="form-control" @if(isset($_COOKIE['password'])) value="{{$_COOKIE['password']}}" @endif id="password"  name="password">
                <i class="far fa-eye-slash fa-1x toggle-password"></i>
            </div>
            <span class="text-danger">
                @error('password')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="col-md-12">
            <div class=" d-flex align-items-center justify-content-between mt-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember_me"  id="remember_me" checked="">
                    <label class="form-check-label" for="defaultCheck1">
                        Remember Me
                    </label>
                </div>
                <div class="form-check">
                    <a href="{{ url('forgetpassword') }}"><span>Forgot Password ?</span></a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="Login" name="submit" id="login">
        </div>
    </form>
    <div class="col-md-12">
    @if (session('error'))
     <div class="alert alert-danger mt-2">
        {{session('error')}}
     </div>
    @endif
    @if (session('success'))
     <div class="alert alert-success mt-2">
        {{session('success')}}
     </div>
    @endif
  
    </div>
</div>
@endsection