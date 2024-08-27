@extends('layout/header')

    @section('content')
<style>

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
.option_html, .common-bg{
    background-color: #f5f6fa;
    padding: 12px 10px;
    border-radius: 4px;
    box-shadow: inset 1px 1px 8px 3px #00000012;
}
</style>

@php
    $userRolePermission = Session::get("role_module_permission");
@endphp

<?php  //print_r($userdata->toArray()); die; ?>
    <div class="d-flex justify-content-between align-items-center pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>View Assessment</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            {{-- @if ($assessment->status != 3)
            <a class="btn btn-warning" href="{{ route('assessment.edit', ['id' => $assessment->id]) }}">Edit Assessment</a>
            @endif --}}
            @if ($assessment->status < 2)
                @if(isset($userRolePermission[5]['edit_permission']) && $userRolePermission[5]['edit_permission'] == 1)
                    <a class="btn btn-warning mr-2 publish" href="#">Publish Assessment</a>
                    <a class="btn btn-warning" href="{{ route('assessment.edit', ['id' => $assessment->id]) }}">Edit Assessment</a>
                @endif
            @elseif($assessment->status == 2)
                @if(isset($userRolePermission[5]['edit_permission']) && $userRolePermission[5]['edit_permission'] == 1)
                    <a class="btn btn-danger mr-2 completeAssessmentBtn" href="#">Complete Assessment</a>
                @endif
                <a class="btn btn-warning mr-2" href="{{ route('assessment.inviteuser', ['id' => $assessment->id]) }}">Invite User</a>
            @else
                <a href="javascript:;" class="btn btn-primary mr-2 disabled">  Completed Accessment</a>
            @endif
        </div>
    </div>

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
                                        @if ( count($userdata) >=1 )
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
                                        @endif

                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3 mb-3 p-5">
                                <div class="col-md-12">
                                    <div class="all-question">
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
                                                                <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                            @endif
                                                             </div>
                                                        </div>
                                                         @elseif (isset($question->question_image) && !empty($question->question_image))
                                                         <div class="offset-2 col-8">
                                                            <div class="preview-container">
                                                             @if ($question->question_image !="" && isset($question->question_image))
                                                             <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                           @endif
                                                            </div>
                                                       </div>
                                                         @endif
                                                    </div>
                                                    <div class="option_html_view">


                                                        @if ($question->question_option1 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" disabled></span>
                                                                    <div >
                                                                        {{$question->question_option1}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option2 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" disabled></span>
                                                                    <div>
                                                                        {{$question->question_option2}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option3 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" disabled></span>
                                                                    <div>
                                                                        {{$question->question_option3}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option4 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" disabled></span>
                                                                    <div>
                                                                        {{$question->question_option4}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option5 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" disabled></span>
                                                                    <div>
                                                                        {{$question->question_option5}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option6 !="")
                                                            <div class="option_tick_view">
                                                                    <span><input type="radio" disabled></span>
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
                                                                    <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                @endif
                                                                 </div>
                                                            </div>
                                                             @elseif (isset($question->question_image) && !empty($question->question_image))
                                                             <div class="offset-2 col-8">
                                                                <div class="preview-container">
                                                                 @if ($question->question_image !="" && isset($question->question_image))
                                                                 <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                               @endif
                                                                </div>
                                                           </div>
                                                             @endif
                                                        </div>
                                                        @if ($question->question_option1 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" disabled></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option1}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option2 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" disabled></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option2}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option3 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" disabled></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option3}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option4 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" disabled></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option4}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option5 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" disabled></span>
                                                                    <div class="option_title editable" style="outline:none;" contenteditable="false">
                                                                        {{$question->question_option5}}
                                                                    </div>

                                                            </div>
                                                        @endif

                                                        @if ($question->question_option6 !="")
                                                            <div class="option_tick">
                                                                    <span><input type="checkbox" disabled></span>
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
                                                                        <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                    @endif
                                                                     </div>
                                                                </div>
                                                                 @elseif (isset($question->question_image) && !empty($question->question_image))
                                                                 <div class="offset-2 col-8">
                                                                    <div class="preview-container">
                                                                     @if ($question->question_image !="" && isset($question->question_image))
                                                                     <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                   @endif
                                                                    </div>
                                                               </div>
                                                                 @endif
                                                            </div>
                                                        <input class="---G-553 anstype" disabled="" readonly="" placeholder="Enter your answer" value="Enter your answer">
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
                                                                        <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                    @endif
                                                                     </div>
                                                                </div>
                                                                 @elseif (isset($question->question_image) && !empty($question->question_image))
                                                                 <div class="offset-2 col-8">
                                                                    <div class="preview-container">
                                                                     @if ($question->question_image !="" && isset($question->question_image))
                                                                     <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                   @endif
                                                                    </div>
                                                               </div>
                                                                 @endif
                                                            </div>


                                                        <div class="d-flex align-items-center">
                                                            <div class="yes d-flex align-items-center mr-3">
                                                            <a    class="mr-2 btn {{$question->question_option1 == 1 ? 'btn-warning' : 'bordered' }}"> Yes</a>
                                                            </div>
                                                                <div class="no d-flex align-items-center">
                                                            <a    class="mr-2 btn {{$question->question_option1 == 0 ? 'btn-warning' : 'bordered' }}"> No</a>
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
                                                                        <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                    @endif
                                                                     </div>
                                                                </div>
                                                                 @elseif (isset($question->question_image) && !empty($question->question_image))
                                                                 <div class="offset-2 col-8">
                                                                    <div class="preview-container">
                                                                     @if ($question->question_image !="" && isset($question->question_image))
                                                                     <div class="preview mt-2"><img src="{{ url('assets/uploads/question/'.$question->question_image)}}"></div>
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

                                                                   @endif
                                                                    </div>
                                                               </div>
                                                                 @endif
                                                            </div>


                                                        <div class="d-flex align-items-center">
                                                            <div class="yes d-flex align-items-center mr-3">
                                                            <a class="mr-2 btn {{$question->question_option1 == 1 ? 'btn-warning' : 'bordered'}}"> True</a>
                                                            </div>
                                                                <div class="no d-flex align-items-center">
                                                            <a  class="mr-2 btn {{$question->question_option1 == 0 ? 'btn-warning' : 'bordered';}}"> False</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    @endif
                                        @endforeach
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

$(document).ready( function () {
    count();
 });

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


        $('.completeAssessmentBtn').on('click', function(e){
            e.preventDefault();

            swal({
                text: "Are you sure you want to mark this assessment as completed?",
                icon: "warning",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f44336',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!"
                }).then(function(isConfirm) {
                   if(isConfirm.value){
                        $.ajax({
                        url: "{{ route('assessment.complete', ['id' => $assessment->id]) }}",
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
