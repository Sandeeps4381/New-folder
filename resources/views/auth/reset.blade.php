@extends('layout/layout')
  
@section('content')

<div class="login-form">
    <div class="logo text-center mt-4">
      <img src="{{url('assets/images/reset-password.svg')}}" class="logo img-fluid" style="max-width: 100px;" alt="logo">
    </div>
    <div class="containt text-center mt-2">
        <h4>Reset Password</h4>
        <p>Please enter your new password</p>
    </div>
    <form action="{{ route('users.resetpassword.post') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
    <div class="col-md-12">
            <label>Enter New Password</label>
            <div class="custome-form-control">
                <input type="password" class="form-control" id="password" name="password" >
                <i class="far fa-eye-slash fa-1x toggle-password"></i>
            </div>
            <span class="text-danger">
            @error('password')
                    {{$message}}
                @enderror
            </span>    
        </div>
        <div class="col-md-12 mt-2">
            <label>Confirm Password</label>
            <div class="custome-form-control">
                <input type="password" class="form-control" id="password" name="password_confirmation" >
                <i class="far fa-eye-slash fa-1x toggle-password"></i>
            </div>
            <span class="text-danger">
            @error('password_confirmation')
                    {{$message}}
            @enderror
            </span>
        </div>
        
        <div class="col-12">
            <input type="submit" value="Reset Password" name="submit" id="login">
        </div>
    </form>
    <div class="col-md-12">
    @if (session('error'))
     <div class="alert alert-danger mt-2">
        {{session('error')}}
     </div>
    @endif
  
    </div>
    <div class="col-12">
           <a href="{{ url('/') }}" class="text-center mt-1">Login</a>
        </div>
        
</div>
@endsection