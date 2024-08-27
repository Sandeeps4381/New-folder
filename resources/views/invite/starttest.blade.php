<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <style type="text/css">
    .option_tick{
        margin-bottom: 0px;
    }
    .option_title {
    padding: 6px 9px;
    border-bottom: none;
    margin-left: 10px;
    margin-right: 5px;
    min-width: 0px;
    display: inline-block;
    width: 100%;
    min-height: 32px;
    background: transparent;
    vertical-align: middle;
    border-radius: 0px;
    font-weight: 600;
}
.aswer-i label{
     min-width: 70px;
}

 .option_tick_view input{
    height: 15px;
    width: 15px;
    margin-right: 14px;
    accent-color: #f1b82d;
}

.question-title {
    background-color: transparent;
    padding: 0px;
    border-bottom: none;
    font-size: 18px;
    font-weight: 600;
}

input[type="checkbox"] {
  cursor: pointer;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: 0;
  background: lightgray;
  height: 16px;
  width: 16px;
  border: 1px solid white;
}

input[type="checkbox"]:checked {
  background: #f1b82d;
}

input[type="checkbox"]:hover {
  filter: brightness(90%);
}

input[type="checkbox"]:disabled {
  background: #e6e6e6;
  opacity: 0.6;
  pointer-events: none;
}

input[type="checkbox"]:after {
  content: '';
  position: relative;
  left: 40%;
  top: 16%;
    width: 25%;
    height: 54%;
  border: solid #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
  display: none;
}

input[type="checkbox"]:checked:after {
  display: block;
}

input[type="checkbox"]:disabled:after {
  border-color: #f1b82d;
}
    .preview {
    display: inline-block;
    width: 100%;
    height: 100%;

    }
    .preview-container{
        height: 340px;
        overflow: hidden;
    }
    .bordered{
            border: 1px solid #383636;
        }

    .option_html_view, .aswer-i{
            margin-top: 10px;
        }


    </style>
</head>
<body>

    <div class="container">
        <div class="mt-3">
            <form action="{{ route('invite.thankyou')}}" method="POST">
                <div class="card text-left">
                    <div class="card-body p-5">
                        <div class="b-r-100">
                            <input type="hidden" value="{{$assessmentData->candidate_id}}" id="candidateId">
                            <input type="hidden" value="{{$assessment->id}}" id="assessmentId">
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="asses-title">
                                            <h1 class="m-0">{{ucwords($assessment->title)}}</h1>
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

                                                <h4 class="m-0 d-inline">Project Manager:
                                                @foreach ($userdata as  $val)
                                                    @if($val->ismanger ==true)
                                                        {{ ucfirst($val->name)}} {{ ucfirst($val->lname)}}
                                                    @endif
                                                @endforeach
                                                </h4>
                                                <h4 class="mr-2 ml-2 d-inline">|</h4>
                                                <h4 class="d-inline"> Assessmnt Type:
                                                    @if ($assessment)
                                                    {{$assessment->scoring == 1 ? "Measure" : "Survey";}}
                                                    @endif
                                                </h4>

                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-3 mb-3 p-5">
                                    <div class="col-md-12">
                                        <div class="all-question">
                                            @if (!empty($questions))
                                            @foreach ($questions as $question)
                                                @if ($question->question_type == 'singleType')
                                                    <div class="q-html t-html" data-id="{{$question->id}}">
                                                    <input type="hidden" class="typeCheck"  value="singleType">

                                                    <div class="question-title">
                                                    <span class="count_d"><b></b></spna>
                                                        <span class="editable" contenteditable="false" style="outline:none;"> {{$question->question_title}}  @if($question->question_require == 'true')
                                                            <span class="text-danger"> *</span>
                                                            @endif</span>
                                                    </div>
                                                    <div class="row">
                                                        @if (isset($question->question_image) && $question->question_image !="" && isset($question->question_video) && $question->question_video !="")
                                                        <div class="col-md-4">
                                                            <div class="preview-container">
                                                                @if ($question->question_image !="" && isset($question->question_image))
                                                                <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="videoPreview" style="margin-top: 20px;">
                                                                @if (isset($question->question_video) && $question->question_video !="")
                                                                @php
                                                                // Extract the YouTube video ID from the URL
                                                                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                $youtube_id = $matches[1];
                                                            @endphp
                                                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                            <button class="delete-video btn btn-warning">Remove</button>
                                                            @endif
                                                            </div>
                                                        </div>
                                                        @elseif (isset($question->question_image) && !empty($question->question_image))
                                                        <div class="offset-2 col-8">
                                                            <div class="preview-container">
                                                            @if ($question->question_image !="" && isset($question->question_image))
                                                            <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                        @elseif (isset($question->question_video) && !empty($question->question_video))
                                                        <div class="offset-2 col-8">
                                                            <div class="videoPreview" style="margin-top: 20px;">
                                                            @if (isset($question->question_video) && $question->question_video !="")
                                                            @php
                                                            // Extract the YouTube video ID from the URL
                                                            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                            $youtube_id = $matches[1];
                                                        @endphp
                                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        <button class="delete-video btn btn-warning">Remove</button>
                                                        @endif
                                                            </div>
                                                    </div>
                                                        @endif
                                                    </div>
                                                    <div class="option_html_view">


                                                        @if ($question->question_option1 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" value="{{$question->question_option1}}" name="{{$question->id}}"></span>
                                                                    <div >
                                                                        {{$question->question_option1}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option2 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" value="{{$question->question_option2}}" name="{{$question->id}}"></span>
                                                                    <div>
                                                                        {{$question->question_option2}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option3 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" value="{{$question->question_option3}}" name="{{$question->id}}"></span>
                                                                    <div>
                                                                        {{$question->question_option3}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option4 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" value="{{$question->question_option4}}" name="{{$question->id}}"></span>
                                                                    <div>
                                                                        {{$question->question_option4}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option5 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" value="{{$question->question_option5}}" name="{{$question->id}}"></span>
                                                                    <div>
                                                                        {{$question->question_option5}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option6 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" value="{{$question->question_option5}}" name="{{$question->id}}"></span>
                                                                    <div>
                                                                        {{$question->question_option6}}
                                                                    </div>

                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @elseif ($question->question_type == 'multiType')
                                                    <div class="q-html t-html" data-id="{{$question->id}}">
                                                    <input type="hidden" class="typeCheck"  value="multiType">
                                                    <div class="question-title">
                                                    <span class="count_d"><b></b></spna>
                                                        <span class="editable" contenteditable="false" style="outline:none;"> {{$question->question_title}}  @if($question->question_require == 'true')
                                                            <span class="text-danger"> *</span>
                                                            @endif</span>
                                                    </div>
                                                    <div class="option_html">

                                                        <div class="row">
                                                            @if (isset($question->question_image) && $question->question_image !="" && isset($question->question_video) && $question->question_video !="")
                                                            <div class="col-md-4">
                                                                <div class="preview-container">
                                                                    @if ($question->question_image !="" && isset($question->question_image))
                                                                    <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="videoPreview" style="margin-top: 20px;">
                                                                    @if (isset($question->question_video) && $question->question_video !="")
                                                                    @php
                                                                    // Extract the YouTube video ID from the URL
                                                                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                    $youtube_id = $matches[1];
                                                                @endphp
                                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                <button class="delete-video btn btn-warning">Remove</button>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            @elseif (isset($question->question_image) && !empty($question->question_image))
                                                            <div class="offset-2 col-8">
                                                                <div class="preview-container">
                                                                @if ($question->question_image !="" && isset($question->question_image))
                                                                <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                            @elseif (isset($question->question_video) && !empty($question->question_video))
                                                            <div class="offset-2 col-8">
                                                                <div class="videoPreview" style="margin-top: 20px;">
                                                                @if (isset($question->question_video) && $question->question_video !="")
                                                                @php
                                                                // Extract the YouTube video ID from the URL
                                                                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                $youtube_id = $matches[1];
                                                            @endphp
                                                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                            <button class="delete-video btn btn-warning">Remove</button>
                                                            @endif
                                                                </div>
                                                        </div>
                                                            @endif
                                                        </div>
                                                        @if ($question->question_option1 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" value="{{$question->question_option1}}"></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option1}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option2 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" value="{{$question->question_option2}}"></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option2}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option3 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" value="{{$question->question_option3}}"></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option3}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option4 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" value="{{$question->question_option4}}"></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option4}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option5 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" value="{{$question->question_option5}}"></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option5}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option6 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" value="{{$question->question_option6}}"></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option6}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                                @elseif ($question->question_type == 'textType')
                                                    <div class="t-html textType" data-id="{{$question->id}}">
                                                        <input type="hidden" class="typeCheck"  value="textType">
                                                        <div class="question-title">
                                                        <span class="count_d"><b></b></spna>
                                                        <span class="editable textq text" contenteditable="false" style="outline:none;"> {{$question->question_title}}  @if($question->question_require == 'true')
                                                            <span class="text-danger"> *</span>
                                                            @endif</span>
                                                        </div>
                                                        <div class="aswer-i common-bg">

                                                            <div class="row">
                                                                @if (isset($question->question_image) && $question->question_image !="" && isset($question->question_video) && $question->question_video !="")
                                                                <div class="col-md-4">
                                                                    <div class="preview-container">
                                                                        @if ($question->question_image !="" && isset($question->question_image))
                                                                        <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="videoPreview" style="margin-top: 20px;">
                                                                        @if (isset($question->question_video) && $question->question_video !="")
                                                                        @php
                                                                        // Extract the YouTube video ID from the URL
                                                                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                        $youtube_id = $matches[1];
                                                                    @endphp
                                                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                    <button class="delete-video btn btn-warning">Remove</button>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                                @elseif (isset($question->question_image) && !empty($question->question_image))
                                                                <div class="offset-2 col-8">
                                                                    <div class="preview-container">
                                                                    @if ($question->question_image !="" && isset($question->question_image))
                                                                    <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                                @elseif (isset($question->question_video) && !empty($question->question_video))
                                                                <div class="offset-2 col-8">
                                                                    <div class="videoPreview" style="margin-top: 20px;">
                                                                    @if (isset($question->question_video) && $question->question_video !="")
                                                                    @php
                                                                    // Extract the YouTube video ID from the URL
                                                                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                    $youtube_id = $matches[1];
                                                                @endphp
                                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                <button class="delete-video btn btn-warning">Remove</button>
                                                                @endif
                                                                    </div>
                                                            </div>
                                                                @endif
                                                            </div>
                                                        <input class="---G-553 anstype" placeholder="Enter your answer">
                                                        </div>
                                                    </div>
                                                @elseif ($question->question_type == 'yesNoType')
                                                <div class="t-html yesNoType" data-id="{{$question->id}}">
                                                        <input type="hidden" class="typeCheck"  value="yesNoType">
                                                        <div class="question-title">
                                                        <span class="count_d"><b></b></spna>
                                                        <span class="editable textq text" contenteditable="false" style="outline:none;"> {{$question->question_title}}  @if($question->question_require == 'true')
                                                            <span class="text-danger"> *</span>
                                                            @endif</span>
                                                        </div>
                                                        <div class="aswer-i common-bg">


                                                            <div class="row">
                                                                @if (isset($question->question_image) && $question->question_image !="" && isset($question->question_video) && $question->question_video !="")
                                                                <div class="col-md-4">
                                                                    <div class="preview-container">
                                                                        @if ($question->question_image !="" && isset($question->question_image))
                                                                        <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="videoPreview" style="margin-top: 20px;">
                                                                        @if (isset($question->question_video) && $question->question_video !="")
                                                                        @php
                                                                        // Extract the YouTube video ID from the URL
                                                                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                        $youtube_id = $matches[1];
                                                                    @endphp
                                                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                    <button class="delete-video btn btn-warning">Remove</button>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                                @elseif (isset($question->question_image) && !empty($question->question_image))
                                                                <div class="offset-2 col-8">
                                                                    <div class="preview-container">
                                                                    @if ($question->question_image !="" && isset($question->question_image))
                                                                    <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                                @elseif (isset($question->question_video) && !empty($question->question_video))
                                                                <div class="offset-2 col-8">
                                                                    <div class="videoPreview" style="margin-top: 20px;">
                                                                    @if (isset($question->question_video) && $question->question_video !="")
                                                                    @php
                                                                    // Extract the YouTube video ID from the URL
                                                                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                    $youtube_id = $matches[1];
                                                                @endphp
                                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                <button class="delete-video btn btn-warning">Remove</button>
                                                                @endif
                                                                    </div>
                                                            </div>
                                                                @endif
                                                            </div>


                                                        <div class="d-flex align-items-center">
                                                            <div class="yes d-flex align-items-center mr-3">
                                                                <label class="btn bordered" for="yes">   <input type="radio" name="yesno"   value="1" class="mr-2 anstype d-none"> Yes</label>
                                                            </div>
                                                                <div class="no d-flex align-items-center">
                                                                <label class="btn bordered" for="no">  <input type="radio"  name="yesno" value="0" class="mr-2 anstype d-none"> No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @elseif ($question->question_type == 'trueFalseType')
                                                    <div class="t-html trueFalseType" data-id="{{$question->id}}">
                                                        <input type="hidden" class="typeCheck"  value="trueFalseType">

                                                        <div class="question-title">
                                                        <span class="count_d"><b></b></spna>
                                                        <span class="editable textq text" contenteditable="false" style="outline:none;"> {{$question->question_title}}  @if($question->question_require == 'true')
                                                            <span class="text-danger"> *</span>
                                                            @endif</span>
                                                        </div>
                                                        <div class="aswer-i common-bg">


                                                            <div class="row">
                                                                @if (isset($question->question_image) && $question->question_image !="" && isset($question->question_video) && $question->question_video !="")
                                                                <div class="col-md-4">
                                                                    <div class="preview-container">
                                                                        @if ($question->question_image !="" && isset($question->question_image))
                                                                        <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="videoPreview" style="margin-top: 20px;">
                                                                        @if (isset($question->question_video) && $question->question_video !="")
                                                                        @php
                                                                        // Extract the YouTube video ID from the URL
                                                                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                        $youtube_id = $matches[1];
                                                                    @endphp
                                                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                    <button class="delete-video btn btn-warning">Remove</button>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                                @elseif (isset($question->question_image) && !empty($question->question_image))
                                                                <div class="offset-2 col-8">
                                                                    <div class="preview-container">
                                                                    @if ($question->question_image !="" && isset($question->question_image))
                                                                    <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"><button class='delete btn btn-warning'>Remove</button></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                                @elseif (isset($question->question_video) && !empty($question->question_video))
                                                                <div class="offset-2 col-8">
                                                                    <div class="videoPreview" style="margin-top: 20px;">
                                                                    @if (isset($question->question_video) && $question->question_video !="")
                                                                    @php
                                                                    // Extract the YouTube video ID from the URL
                                                                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $question->question_video, $matches);
                                                                    $youtube_id = $matches[1];
                                                                @endphp
                                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                <button class="delete-video btn btn-warning">Remove</button>
                                                                @endif
                                                                    </div>
                                                            </div>
                                                                @endif
                                                            </div>


                                                        <div class="d-flex align-items-center">
                                                            <div class="yes d-flex align-items-center mr-3">
                                                                <label class="btn bordered" for="yes">  <input type="radio" name="trueFalse"  value="1" class="mr-2 anstype d-none" > True</label>
                                                            </div>
                                                                <div class="no d-flex align-items-center">
                                                                    <label class="btn bordered" for="no"> <input type="radio"  name="trueFalse" value="0" class="mr-2 anstype d-none">  False</label>
                                                            </div>
                                                        </div>
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
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning" id="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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

    <script type="text/javascript">
    $(document).ready( function () {
            var $selectedDivAudioVideos;
            count();

        function count(){
            $('.count_d').each(function(index) {
                $(this).find('b').text(index + 1 +'.');
            });
        }

        $(document).on('click', '.yesNoType .aswer-i label', function(e){
            e.preventDefault();
            $('.yesNoType .aswer-i label').removeClass('btn-warning');

            let checked =  $(this).find('input[type="radio"]').prop('checked',true);
            if(checked){
                  $(this).addClass('btn-warning');
            }
        });



        $(document).on('click', '.trueFalseType .aswer-i label', function(e){
            e.preventDefault();
            $('.trueFalseType .aswer-i label').removeClass('btn-warning');

            let checked =  $(this).find('input[type="radio"]').prop('checked',true);
            if(checked){
                  $(this).addClass('btn-warning');
            }
        });


       $(document).on('click', '#submit' , function(e){
          e.preventDefault();
          var ansArray = [];
          $('.all-question .t-html').each( function(index ,val){
               let qtype = $(this).find('.typeCheck').val();
               if(qtype == "singleType" || qtype == "multiType"){
                    if(qtype == "singleType"){
                        let question_id =  $(this).attr('data-id');
                        let answer  = "";
                        $(this).find('.option_html_view .option_tick_view').each(function(){
                            let optionChekedVal = $(this).find('input[type="radio"]:checked').val();
                            if(optionChekedVal){
                                answer = optionChekedVal;
                            }
                        });

                        let json = {
                            id : question_id,
                            answer : answer
                        }
                        ansArray.push(json);

                    }else{
                        let question_id =  $(this).attr('data-id');
                        let answer = [];
                        $(this).find('.option_html .option_tick').each(function(){
                            let optionChekedVal = $(this).find('input[type="checkbox"]:checked').val();
                            if(optionChekedVal){
                                answer.push(optionChekedVal);
                            }
                        });

                        let json = {
                            id : question_id,
                            answer : answer.join(",")
                        }
                        ansArray.push(json);
                    }
               }else if(qtype == "yesNoType" || qtype == "trueFalseType"){
                    let question_id =  $(this).attr('data-id');
                    let optionChekedVal = $(this).find('input[type="radio"]:checked').val();
                    let json = {
                            id : question_id,
                            answer : optionChekedVal
                        }
                    ansArray.push(json);

               }else if(qtype = "textType"){
                      let question_id =  $(this).attr('data-id');
                      let anstype = $(this).find('.anstype').val();
                      let json = {
                            id : question_id,
                            answer : anstype
                        }
                      ansArray.push(json);
               }
          });
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            url: "{{ route('assessmentAttempts.create') }}",
            type: "POST",
            data: {
                candidate_id: $('#candidateId').val(),
                assessment_id : $('#assessmentId').val(),
                answerArray : ansArray
            },
            success: function (response) {
                $(window).scrollTop(0);
                if(response.redirect_url){
                    window.location.href = response.redirect_url;
                }

            }
        });


       });


    });
    </script>
</body>
</html>
