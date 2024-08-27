@extends('layout/layout')
  
@section('content')



<div class="login-form">
    <div class="logo text-center mt-3">
      <img src="{{url('assets/images/forget-password.svg')}}" class="logo img-fluid" style="max-width: 100px;" alt="logo">
    </div>
    <div class="containt text-center mt-4">
        <h4>Forgot Password ?</h4>
        <p>Please enter your email id to reset your password</p>
    </div>
    <form action="forgetpasswordsend" method="post">
        @csrf
        <div class="col-md-12 ">
            <label>Enter email id:</label>
            <input type="email" class="form-control" name="email">
        </div>
        
        <div class="col-12">
            <input type="submit" value="Submit" name="submit" id="login">
        </div>
    </form>
    <div class="col-12">
           <a href="{{ url('/') }}" class="text-center mt-1">Login</a>
        </div>
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
@endsection