@extends('layout/header')    
    @section('content')

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>{{ __(' My Profile') }}</h3></div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="ul-form__label" for="inputEmail4">Full Name:</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="ul-form__label" for="inputEmail4">Last Name:</label>
                            <input id="email" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname', $user->lname) }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="ul-form__label" for="inputEmail4">Email Address:</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="ul-form__label" for="inputEmail4">Phone:</label>
                            <input id="email" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                            <input type="checkbox" id="change-password" name="change_password">
                            <label for="change-password">{{ __('Change Password') }}</label>
                        </div>

                        <div class="form-group password-fields" style="display: none;">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group password-fields" style="display: none;">
                            <label for="password">{{ __('Confirm Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    <!-- Add other fields as needed -->

                    <button type="submit" class="btn btn-warning mt-3">Save Profile</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.getElementById('change-password').addEventListener('change', function() {
        var passwordFields = document.querySelectorAll('.password-fields');
        if (this.checked) {
            passwordFields.forEach(function(field) {
                field.style.display = 'block';
            });
        } else {
            passwordFields.forEach(function(field) {
                field.style.display = 'none';
            });
        }
    });
</script>
@endsection 