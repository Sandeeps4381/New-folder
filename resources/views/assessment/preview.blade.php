@extends('layout/header')

    @section('content')
<style>
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
    font-size: 19px;
    color: #000;
    font-weight: 600;
}
</style>


    <div class="d-flex justify-content-between align-items-center pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Preview Assessment</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <?php if($assessment->status != 3) { ?>
                    <a class="btn btn-warning mr-2 publish" href="#">Publish Assessment</a>
                    <a class="btn btn-warning" href="{{ route('assessment.edit', ['id' => $assessment->id]) }}">Edit Assessment</a>
            <?php }else if($assessment->status == 3){ ?>
                <a class="btn btn-warning mr-2" href="{{ route('assessment.inviteuser', ['id' => $assessment->id]) }}">Invite User</a>
            <?php } ?>


        </div>
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

    <div class="mt-3">
        <form method="post" action="">
            <div class="card text-left">
                <div class="card-body p-5">
                    <div class="b-r-100">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="asses-title">
                                        <h1 class="m-0">{{$assessment->title}}</h1>
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
                                            <h4 class="d-inline"> Project Type:
                                                @if (count($project) > 0)
                                                {{$project[0]->project_type}}
                                                @endif
                                            </h4>

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
                                                            <span class="editable " contenteditable="false" style="outline:none;"> {{$question->question_title}} </span>
                                                            @if($question->question_require == 'true')
                                                            <span class="text-danger"> *</span>
                                                            @endif
                                                            </div>
                                                            @if ($question->question_option1 !="")
                                                            <div class="option_html">
                                                                <div class="option_tick">
                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                        <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                            {{$question->question_option1}}
                                                                        </div>

                                                                </div>
                                                            </div>
                                                            @endif


                                                            @if ($question->question_option2 !="")
                                                            <div class="option_html">
                                                                <div class="option_tick">
                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                        <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                            {{$question->question_option2}}
                                                                        </div>

                                                                </div>
                                                            </div>
                                                            @endif


                                                            @if ($question->question_option3 !="")
                                                            <div class="option_html">
                                                                <div class="option_tick">
                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                        <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                            {{$question->question_option3}}
                                                                        </div>

                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if ($question->question_option4 !="")
                                                            <div class="option_html">
                                                                <div class="option_tick">
                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                        <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                            {{$question->question_option4}}
                                                                        </div>

                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if ($question->question_option5 !="")
                                                            <div class="option_html">
                                                                <div class="option_tick">
                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                        <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                            {{$question->question_option5}}
                                                                        </div>

                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if ($question->question_option6 !="")
                                                            <div class="option_html">
                                                                <div class="option_tick">
                                                                        <span><img src="{{url('dist-assets/images/radio.svg')}}" style="width:20px;"></span>
                                                                        <div class="option_title editable" style="outline:none;" contenteditable="false">
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
                                                            <span class="editable textq text" contenteditable="false" style="outline:none;"> {{$question->question_title}} </span>
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
                                                            <span class="editable ratingTitle " contenteditable="false" style="outline:none;">{{$question->question_title}} </span>
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
                                                            <span class="editable date" contenteditable="false" style="outline:none;"> {{$question->question_title}} </span>
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
                                                            <span class="editable file" contenteditable="false" style="outline:none;"> {{$question->question_title}} </span>
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
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
    $('.publish').on('click', function(e){
        e.preventDefault();

        swal({
            text: "Are you sure you want to publish",
            icon: "warning",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#f1b82d',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!"
            }).then(function(isConfirm) {
               if(isConfirm.value){
                    $.ajax({
                    url: "{{ route('assessment.publish', ['id' => $assessment->id]) }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                    if(data.success){
                        swal({
                            text: data.success,
                            timer: 2000,
                            type: "success",
                            confirmButtonColor: "#f1b82d",

                        });
                    }


                }
                });
                setInterval(function () {
                    window.location.reload();
                }, 3000);
            }

            });
    })

    </script>
    @endsection
