<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Assessment</title>
    <link href="{{asset('dist-assets/images/logo-2.png')}}" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />

    <link href="{{asset('dist-assets/css/themes/lite-purple.css')}}" rel="stylesheet" />
    <link href="{{asset('dist-assets/css/plugins/perfect-scrollbar.css')}}" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include DatePicker CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/quill.bubble.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/quill.snow.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist-assets/css/custom.css')}}" />

    <link href="{{asset('dist-assets/css/plugins/metisMenu.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>

</head>
<style>
    .bg-primary{
        background-color: #f1b82d !important;
    }
    .btn-default{
        background-color: #424242;
        color: #fff;
        padding: 6px 22px;
        font-size: 17px;
    }
    .btn-default:hover{
        color: #fff;
    }
    p{
        color: #000;
        font-size: 17px;
    }
    h1,h2,h3,h4,h5,h6,p{
        margin: 0px;
    }

    /* Ensures that the page takes up the full height of the viewport */
    .page {
        display: flex;
        flex-direction: column;
        height: 100vh;
        margin: 0;
    }

    /* The first child should be placed in the top third of the screen */
    .page > .row:first-of-type {
        margin-top: calc(33vh - 2rem); /* Adjust as necessary */
    }

    /* Ensures that the other elements stack below */
    .container {
        margin-top: 2rem; 
        margin-bottom: 2rem; 
    }

    /* Footer styling to ensure it's at the bottom */
    .footer-bottom-2 .container {
        /* margin-top: 5rem;  */
        /* Pushes the footer to the bottom of the page */
        margin-bottom: 10rem; 
        /* Adjust spacing as necessary */
    }

    body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
    }

    .check-button {
        background-color: #4CAF50; 
        border: none;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px; 
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 1rem;
    }

    .check-button:hover {
        background-color: #45a049; /* Darker green on hover */
    }

    .check-mark {
        font-size: 24px; /* Size of the check mark */
    }

    .pl-3 {
        margin-top: 0rem;
    }

    .divider {
        border: none;
        border-top: 1px solid #dcdcdc; /* Faint gray color */
        margin: 20px 0; /* Adjust spacing as needed */
    }
</style>

<body>
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <img id="site-logo" style="max-width: 250px;" class="pl-3" src="{{url('assets/images/logo-1.png')}}">
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="container">
            <div class="row"> --}}
                {{-- <div class="col-md-12"> --}}
                    <div class="text-center">
                        <button class="check-button">
                            <span class="check-mark">&#10003;</span>
                        </button>
                    </div>
                {{-- </div> --}}
            {{-- </div>
        </div> --}}

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h1 id="thank-you-message"><b>Thank You for Completing the Assessment</b></h1>
                    </div>
                </div>
            </div>
        </div>

        <hr class="divider">

        <div class="footer-bottom-2 mt-4 mb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <p>The University of Missouri is a public land-grant research university in Columbia,<br> Missouri. It is Missouri's largest university.</p>
                            <p class="mt-4"><i class="fa fa-map-marker" aria-hidden="true"></i> 125 Jesse Hall , University of Missouri Columbia, MO 65211</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {
            // Replace with the actual endpoint URL
            $.ajax({
                url: '/thankyou', // Adjust URL to match your route
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Update the HTML content with the assessment name
                        $('#thank-you-message').html('<b>Thank you for Completing the ' + response.assessment_name + ' Assessment</b>');
                    } else {
                        // Handle case where assessment name is not found
                        $('#thank-you-message').html('<b>Thank you for Completing the Assessment</b>');
                    }
                },
                error: function() {
                    // Handle error scenario
                    $('#thank-you-message').html('<b>Thank you for Completing the Error Assessment</b>');
                }
            });
        });
    </script> --}}

    <script src="{{ asset('dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/tooltip.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/script_2.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/metisMenu.min.js') }}/"></script>
    <script src="{{ asset('dist-assets/js/scripts/layout-sidebar-vertical.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/echarts.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/form.validation.script.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.12.15/dist/sweetalert2.all.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" rel="stylesheet">
    <script src="/dist-assets/js/scripts/form.validation.script.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

    <script src="{{ asset('dist-assets/js/plugins/quill.min.js')}}"></script>
    <script src="{{ asset('dist-assets/js/scripts/quill.script.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>


</body>
</html>
