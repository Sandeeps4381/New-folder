@extends('layout/header')

    @section('content')


    <style>
    #emailMessage{
        position: absolute;
    }
    .valid { color: green; }
    .invalid { color: red; }

    .question-title {
            background-color: #fff;
            padding: 10px 9px;
            border-bottom: none !important;
        }

    .q-html, .t-html {
        background-color: #ffffff;
        padding: 10px;
        margin-bottom: 10px;
    }
    .question-title {
        background-color: #fff;
        padding: 10px 9px 10px 0px;
        border-bottom: none !important;
        font-size: 16px;
        color: #000;
        font-weight: 600;
    }
    .modal.right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 320px;
            height: 100%;
            transform: translate3d(100%, 0, 0);
            transition: transform 0.3s ease-out;
            right: 0;
            top: 0;
        }

    .modal.right.show .modal-dialog {
        transform: translate3d(0, 0, 0);
    }
    .email-item{
        display: flex;
        width: 100%;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-content: center;
        align-items: center;
        color: #000;
        font-size: 12px;
        margin-bottom: 5px;
    }

    /* Simple styles for the modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* background-color: rgb(174, 151, 0); */
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 10px;
        border: 1px solid #888;
        width: 40%;
        max-width: 500px; /* Adjust the maximum width as needed */
        position: relative;
        text-align: center; /* Center content inside the modal */
    }
    .close {
        color: #aaa;
        /* float: right; */
        font-size: 28px;
        font-weight: bold;

        position: absolute;
        top: 10px;
        right: 20px;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        /* cursor: pointer; */
    }

    #linkText {
        margin-bottom: 20px;
        word-break: break-all; /* Ensures long URLs break into the next line */
    }
    #copyLinkBtn {
        background-color: #f7c24d; /* Mustard color */
        color: #fff;
        border: none;
        border-radius: 5px; /* Rounded corners */
        padding: 10px 20px; /* Padding around the text */
        cursor: pointer;
        font-size: 16px;
        display: inline-block; /* Adjusts the button size to fit the text */
    }
    #copyLinkBtn:hover {
        background-color: #e1b03d; /* Slightly darker mustard color on hover */
    }

</style>


    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Invite Users</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between align-items-center">
             <span><input id="emailInput" type="text" class="email-input form-control" style="min-width:300px;" placeholder="Enter email addresses">
                <span id="emailMessage"></span>
            </span>
            <span class="mr-3 ml-3"><b>or</b></span>
            <a id="generateLinkBtn" class="btn btn-warning" href="#"> <i class="fa fa-link" aria-hidden="true"></i> Generate Link</a>
        </div>
    </div>

    {{-- Gets the current URL which should be the assessment ID --}}
    @php
        $url = url()->current();
        $parsedUrl = parse_url($url);
        // Extract the base URL (scheme + host + optional port)
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        if (isset($parsedUrl['port'])) {
            $baseUrl .= ':' . $parsedUrl['port'];
        }

        // Extract the path and get the last part
        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $lastPart = basename($path);
    @endphp

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3><b>Assessment Link</b></h3>
            <p id="linkText"> {{ route('invite.inviteuserdirect',['assessmentID'=>$assessment->id,'userID'=>Session::get('user_id')]) }}</p>
            <button id="copyLinkBtn">Copy Link</button>
        </div>
    </div>

    <script>
        // JavaScript for modal and clipboard functionality
        document.getElementById('generateLinkBtn').onclick = function() {
            document.getElementById('myModal').style.display = "block";
        }

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            document.getElementById('myModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = "none";
            }
        }

        document.getElementById('copyLinkBtn').onclick = function() {
            var copyText = document.getElementById("linkText").textContent;
            navigator.clipboard.writeText(copyText).then(function() {
                alert('Link copied to clipboard!');
            }).catch(function(err) {
                alert('Failed to copy the link: ' + err);
            });
        }
    </script>


    <input type="hidden" id="assessmentId" value="{{$assessment->id}}">

    <div class="card text-left  mt-4">
         <div class="card-body p-0">
            <div class="invite-header">
                  <div class="invite-title"><h3>Invitation</h3></div>
            </div>
        </div>
        <div class="card-body p-5">
        <div class="content">
                <div class="invite-users text-center mt-3 mb-3">
                    <img src="{{ url('assets/images/inviteuser.svg')}}" alt="invite user">
                </div>
                <div class="invite-content text-center">
                    <h2><small>You are invited to take this:</small></h2>
                    <h2 class="fw-bold">{{$assessment->title}}</h2>
                    {{-- <h4 class="mb-0">vT_L&D_PM_02_Application Development Assignment_V1.3_v1.0</h4> --}}
                    {{-- <h4>2024/1/13 20:55:12</h4> --}}
                    <textarea id="send_invite" class="form-control pb-5" placeholder="Write your invitation email here" rows="4"></textarea>
                    <input type="submit" value="Send Invite"  id="sendInvite" class="btn btn-warning mt-3">
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card text-left  mt-4">
        <div class="card-body">

          <div class="row">
            <div class="col-md-6">
            <div class="card text-left mt-3">
                <div class="card-body text-center">
                    <img src="{{ url('assets/images/responde.svg')}}" alt="invite user">
                    <h2>Respondents will </h2>
                    <h2>see the form like this.</h2>
              </div>
            </div>

            </div>
            <div class="col-md-6">
                <div class="mt-3">
                        <form method="post" action="">

                                    <div class="b-r-100">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <div class="asses-title">
                                                        <h4 class="m-0">{{$assessment->title}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if (count($project) > 0)
                                                    <img src="{{url(IMG_UPLOAD_PATH.'/'.$project[0]->project_image)}}" class="img-fluid rounded w-100">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row bg-off-white pt-3">
                                                    <div class="col-md-10 offset-md-1 ">
                                                        <p style="font-size: 17px; font-weight: 600;">
                                                        {{ strip_tags($assessment->description) }}
                                                    </p>
                                                    </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="asses-title">

                                                            <h5 class="m-0 d-inline">Project Manager:
                                                            @foreach ($userdata as  $val)
                                                                @if($val->ismanger ==true)
                                                                    {{ ucfirst($val->name)}} {{ ucfirst($val->lname)}}
                                                                @endif
                                                            @endforeach
                                                            </h5>
                                                            <h4 class="mr-2 ml-2 d-inline">|</h4>
                                                            <h5 class="d-inline"> Project Type:
                                                                @if (count($project) > 0)
                                                                {{$project[0]->project_type}}
                                                                @endif
                                                            </h5>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mt-3 mb-3 p-5">
                                                <div class="col-md-12">
                                                    <div class="all-question">
                                                        @if (isset($questions) && $questions !="")
                                                        @php $count = 0; @endphp
                                                            @foreach ( $questions as $question)
                                                                        @php
                                                                        $count++;
                                                                        @endphp
                                                                        @if($question->question_type == "choice")

                                                                            <div class="q-html t-html choice" data-id="">
                                                                            <input type="hidden" class="typeCheck"  value="choice">
                                                                            <div class="question-title">
                                                                            <span class="count_d"><b>{{$count}}.</b></spna>
                                                                            <span class="editable " style="outline:none;"> {{$question->question_title}} </span>
                                                                            @if($question->question_require == 'true')
                                                                            <span class="text-danger"> *</span>
                                                                            @endif
                                                                            </div>
                                                                            @if ($question->question_option1 !="")
                                                                            <div class="option_html">
                                                                                <div class="option_tick">
                                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                                        <div class="option_title editable" style="outline:none;">
                                                                                            {{$question->question_option1}}
                                                                                        </div>

                                                                                </div>
                                                                            </div>
                                                                            @endif


                                                                            @if ($question->question_option2 !="")
                                                                            <div class="option_html">
                                                                                <div class="option_tick">
                                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                                        <div class="option_title editable" style="outline:none;">
                                                                                            {{$question->question_option2}}
                                                                                        </div>

                                                                                </div>
                                                                            </div>
                                                                            @endif


                                                                            @if ($question->question_option3 !="")
                                                                            <div class="option_html">
                                                                                <div class="option_tick">
                                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                                        <div class="option_title editable" style="outline:none;">
                                                                                            {{$question->question_option3}}
                                                                                        </div>

                                                                                </div>
                                                                            </div>
                                                                            @endif

                                                                            @if ($question->question_option4 !="")
                                                                            <div class="option_html">
                                                                                <div class="option_tick">
                                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                                        <div class="option_title editable" style="outline:none;">
                                                                                            {{$question->question_option4}}
                                                                                        </div>

                                                                                </div>
                                                                            </div>
                                                                            @endif

                                                                            @if ($question->question_option5 !="")
                                                                            <div class="option_html">
                                                                                <div class="option_tick">
                                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                                        <div class="option_title editable" style="outline:none;">
                                                                                            {{$question->question_option5}}
                                                                                        </div>

                                                                                </div>
                                                                            </div>
                                                                            @endif

                                                                            @if ($question->question_option6 !="")
                                                                            <div class="option_html">
                                                                                <div class="option_tick">
                                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                                        <div class="option_title editable" style="outline:none;">
                                                                                            {{$question->question_option6}}
                                                                                        </div>

                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                        </div>

                                                                        @elseif($question->question_type == "textType")

                                                                        <div class="t-html textType" data-id="">
                                                                        <input type="hidden" class="typeCheck"  value="textType">

                                                                        <div class="question-title">
                                                                            <span class="count_d"><b>{{$count}}.</b></spna>
                                                                            <span class="editable textq text" style="outline:none;"> {{$question->question_title}} </span>
                                                                            @if($question->question_require == 'true')
                                                                            <span class="text-danger"> *</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="aswer-i">
                                                                        <input class="---G-553 anstype" disabled="" readonly="" placeholder="Enter your answer" value="Enter your answer">
                                                                        </div>
                                                                        </div>

                                                                        @elseif($question->question_type == "rating")

                                                                        <div class="t-html rating" data-id="">
                                                                        <input type="hidden"  class="typeCheck" value="rating">

                                                                        <div class="question-title">
                                                                            <span class="count_d"><b>{{$count}}.</b></spna>
                                                                            <input type="hidden" name="qType" value="textType">
                                                                            <span class="editable ratingTitle " style="outline:none;">{{$question->question_title}} </span>
                                                                            @if($question->question_require == 'true')
                                                                            <span class="text-danger"> *</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="aswer-i" style="display: flex; flex-wrap: nowrap; align-content: center; align-items: center;">

                                                                        <label style="margin:0px 5px 0px 0px;">Enter Star Rating:</label>
                                                                        <input class="form-control ansrate text-center" style="width:50px;" value="{{$question->question_option1}}"  readonly  type="text">
                                                                        </div>
                                                                        </div>

                                                                        @elseif($question->question_type == "dateType")

                                                                        <div class="t-html dateType" data-id="">
                                                                        <input type="hidden"  class="typeCheck" value="dateType">

                                                                        <div class="question-title">
                                                                            <span class="count_d"><b>{{$count}}.</b></spna>
                                                                            <span class="editable date" style="outline:none;"> {{$question->question_title}} </span>
                                                                            @if($question->question_require == 'true')
                                                                            <span class="text-danger"> *</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="aswer-i">
                                                                        <input class="form-control dateInput" style="width:150px;" type="date" value="{{$question->question_option1}}">
                                                                        </div>
                                                                        </div>

                                                                        @elseif($question->question_type == "filetype")

                                                                        <div class="t-html filetype" data-id="">
                                                                        <input type="hidden" class="typeCheck"  value="filetype">

                                                                        <div class="question-title">
                                                                            <span class="count_d"><b>{{$count}}.</b></spna>
                                                                            <span class="editable file" style="outline:none;"> {{$question->question_title}} </span>
                                                                            @if($question->question_require == 'true')
                                                                                <span class="text-danger"> *</span>
                                                                            @endif
                                                                            </div>
                                                                        <div class="aswer-i">
                                                                        <input class="form-control filetypeinput" style="width:300px;" type="file" name="files" disabled>
                                                                        </div>
                                                                        <div class="intraction">

                                                                            <section class="fileUploadTypesList">
                                                                        <span style="margin-right:10px;">  Allowable File Types   File size limit is 16MB </span>
                                                                                <label class="checkboxSetting">
                                                                                    <input class="sm-input" type="checkbox" id="fileTypepdf" data-id="fileTypepdf" value="pdf" checked="" tabindex="1">
                                                                                    <label for="fileTypepdf">PDF</label></label><label class="checkboxSetting">
                                                                                    <input class="sm-input" type="checkbox" id="fileTypedoc" data-id="fileTypedoc" value="doc" checked="" tabindex="1">
                                                                                    <label for="fileTypedoc">DOC, DOCX</label></label><label class="checkboxSetting">
                                                                                    <input class="sm-input" type="checkbox" id="fileTypepng" data-id="fileTypepng" value="png" checked="" tabindex="1">
                                                                                    <label for="fileTypepng">PNG</label></label><label class="checkboxSetting">
                                                                                    <input class="sm-input" type="checkbox" id="fileTypejpg" data-id="fileTypejpg" value="jpg" checked="" tabindex="1">
                                                                                    <label for="fileTypejpg">JPG, JPEG</label></label>
                                                                                    <label class="checkboxSetting"><input class="sm-input" type="checkbox" id="fileTypegif" data-id="fileTypegif" value="gif" checked="" tabindex="1">
                                                                                    <label for="fileTypegif">GIF</label>
                                                                                </label>

                                                                            </section>
                                                                        </div>
                                                                        </div>
                                                                        @endif
                                                            @endforeach

                                                        @endif
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="view_logo">
                                                <img id="view-logo" class="pl-3" src="{{url('assets/images/logo-1.png')}}">
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

<script type="text/javascript">
        $(document).ready(function() {
            $('#emailInput').on('keyup', function() {
                var emails = $(this).val().split(',');
                var emailMessage = $('#emailMessage');

                // Regular expression for basic email validation
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                var allValid = true;
                for (var i = 0; i < emails.length; i++) {
                    var email = emails[i].trim();
                    if (email && !emailPattern.test(email)) {
                        allValid = false;
                        break;
                    }
                }

                if (allValid) {
                    emailMessage.text('All email addresses are valid').removeClass('invalid').addClass('valid');
                } else {
                    emailMessage.text('Email addresses are invalid').removeClass('valid').addClass('invalid');
                }
            });
        });


        $(document).on('click', '#sendInvite', function(e){
            e.preventDefault();
            let submitButton = $(this);
            submitButton.prop('disabled', true);
            let emailArray = $('#emailInput').val();
            if(emailArray ==""){
                swal({
                        text: 'Please enter email id',
                        timer: 2000,
                        type: "error",
                        confirmButtonColor: "#f1b82d",

                    });
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                    url: "{{ route('invite.list') }}",
                    method: "POST",
                    data: {
                        id :  parseInt($('#assessmentId').val()),
                        send_invite: $('#send_invite').val(),
                        email: emailArray
                    },
                    beforeSend: function() {
                        $("div#loading-image").addClass("show");
                    },
                    success:function(data) {
                        $("div#loading-image").removeClass("show");
                        if(data.message){
                             swal({
                                text: data.message,
                                type: "success",
                                confirmButtonColor: "#f1b82d",

                           });
                           submitButton.prop('disabled', false);
                        }
                    }
            });
        });
</script>

    @endsection
