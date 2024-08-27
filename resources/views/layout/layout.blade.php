<!DOCTYPE html>
 <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>UOM</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
        <script type="text/javascript" src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.js') }}"></script>
        <script>
            $(document).ready(function(){
                $('.toggle-password').click(function(e) {
                    e.preventDefault();
                    $(this).toggleClass("fa-eye");
                    var input = $(this).prev('input');
                    if (input.attr("type") === "password") {
                        input.attr("type", "text");
                        $(this).toggleClass("fa-eye-slash");
                    } else {
                        input.attr("type", "password");
                        $(this).toggleClass("fa-eye-slash");
                    }
                });
            });
        </script>
        
    </head>
    <body>

    <div class="auth_body">
    <div class="d-flex align-items-center justify-content-between  z-index-4 p-relative c-width ">
        <div class="col-md-6 col-bg1">
            <div class="display-table">
                <div class="display-cell text-center">
                  <img src="{{url('assets/images/logo-1.png')}}" class="logo img-fluid" alt="logo">
                </div>
             </div>
        </div>
        <div class="col-md-6 col-bg2">
           @yield('content')
        </div>
    </div>
</div>
    </body>    
</html>