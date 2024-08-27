@extends('layout/header')

    @section('content')
<style type="text/css">
.preview  img{

width: 100%;
height: 100%;

}

.preview {
display: inline-block;
width: 100%;
height: 320px;
}
    .modal-full {
    min-width: 80%;
    margin: 0 auto;
    }

    .modal-content {
    min-height: 90vh;
    border: none;
    border-radius: 0;
    }

    .truncate {
    max-width: 150px; /* Adjust max-width as needed */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }

    .ck-editor__editable_inline {
    min-height: 200px;
    }
    .hidediv{
        display: none !important;
    }
</style>

    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Create Assessment</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <a class="btn btn-warning mr-3" href="{{ route('project.create') }}" onclick="saveAsDraft()">Save as Draft</a>

        </div>
    </div>

    <div id="successMessage" class="mt-3" style="display: none;">
        <div class="alert alert-success"></div>
    </div>

    <div class="mt-3">
    <form id="createAssessment" enctype="multipart/form-data">

        @csrf
        <input type="hidden" value="<?php if(isset($_GET['preproductid'])){ echo $_GET['preproductid'];}else{ echo 0;}; ?>" name="projectinclude" id="includeProjectArray">

        <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="card-title mb-3">Assessment Details</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 <?php if(isset($_GET['preproductid'])){ echo 'col-md-4';}else{echo 'col-md-3';}; ?>">
                            <label>Title <span class="text-danger"> *</span></label>
                            <input class="form-control" type="text" name="title" @if (isset($assessment))
                              value="{{$assessment->title}}"
                            @endif>
                            <div class="invalid-feedback" id="title"></div>
                        </div>

                        <div class="col-md-3 form-group mb-3 <?php if(isset($_GET['preproductid'])){ echo 'd-none';}; ?>">
                            <label>Assign Project <span class="text-danger"> *</span></label>
                            <select class="select2 form-control"  value="" name="project_type" id="project_type"  data-placeholder="Assign Project ">
                                <option></option>
                                <option <?php if(isset($_GET['preproductid'])){ echo 'selected';}; ?> value="Yes">Yes</option>
                                <option <?php if(isset($_GET['preproductid'])){ echo 'disabled';}; ?> value="No">No</option>
                            </select>
                            <div class="invalid-feedback" id="ptype"></div>
                        </div>


                        <div class="form-group mb-3 <?php if(isset($_GET['preproductid'])){ echo 'col-md-4';}else{echo 'col-md-3';}; ?>">
                            <label>Administration Schedule <span class="text-danger"> *</span></label>
                            <select class="select2 form-control" id="shedule" value="" name="administration_schedule[]" multiple="multiple" data-placeholder="Administration Schedule">
                                <?php if(isset($assessment->administration_schedule)){
                                       $scheduleUpcoming = explode(',' , $assessment->administration_schedule );
                                            foreach($schedule as $keys =>  $val){
                                                if (in_array($keys, $scheduleUpcoming)) {?>
                                                    <option selected value="<?= $keys; ?>"><?= $val; ?></option>
                                        <?php  }else{?>
                                            <option  value="<?= $keys; ?>"><?= $val; ?></option>

                                <?php } } }else { ?>
                                          <option></option>
                                        @foreach ($schedule as $keys => $value)
                                        <option value="{{$keys}}">{{$value}}</option>
                                        @endforeach
                              <?php  } ?>


                            </select>
                            <div class="invalid-feedback" id="ashedule"></div>
                        </div>

                        <div class="form-group mb-3 <?php if(isset($_GET['preproductid'])){ echo 'col-md-4';}else{echo 'col-md-3';}; ?>">
                            <label>Assessment Type</label>
                                <select class="select2 form-control" id="scoringRequired" value="" name="scoringRequired" data-placeholder="Select scoring required.">

                                    @if(isset($assessment->scoring))
                                    <option value="0" <?php if($assessment->scoring == '0'){ echo "selected";}?>>Survey</option>
                                    <option value="1" <?php if($assessment->scoring == '1'){ echo "selected";}?>>Measure</option>
                                    @else
                                    <option></option>
                                    <option value="0">Survey</option>
                                    <option value="1">Measure</option>
                                    @endif
                                </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description <span class="text-danger"> *</span></label>
                            <textarea id="assessmenteditor" style="width:100%; height:200px;"  name="description">
                            @if (isset($assessment))
                            {!! old('content', $assessment->description) !!}
                            @endif
                            </textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>

                    </div>


                    <div class="row mb-3">
                        <div class="col">
                            <a class="btn btn-warning battery" >Add Assessment Battery</a>
                        </div>
                        <div class="col text-right">
                            <a href="#" class="btn btn-warning" id="selectFromQuestionBank">Select from Item Bank</a>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="all-question">
                                @if (!empty($questions))
                                    @foreach ($questions as $question)
                                            @if ($question->question_type == 'singleType')
                                                <div class="q-html t-html" data-id="0">
                                                <input type="hidden" class="typeCheck"  value="singleType">
                                                <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                                                    <span class="audio-video" data-audio="<?php if($question->question_image){ echo $question->question_image;}?>" data-video="<?php if($question->question_video){ echo $question->question_video;}?>">
                                                    <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                                                    <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                                                    @if ($question->score_type)
                                                    <span class="mr-4 scoringGuideLine" data-type="{{$question->score_type}}" data-score="{{$question->score_option}}" data-content="{{$question->question_guidlines}}" style="display: inline;">+ Add to Scoring Guidelines <b class="text-danger"> *</b> </span>
                                                    @endif
                                                    <span class="d-flex justify-content-end align-items-center mr-4 {{ $question->assessment_only == 1 ? 'd-none' : '' }}"><input type="checkbox"  {{ $question->assessment_only == 1 ? 'checked disabled' : '' }} name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                                                    <span class="d-flex justify-content-end align-items-center"><input type="checkbox" {{ $question->question_require == 'true' ? 'checked' : '' }} name="required" class="mr-2"> Required</span>
                                                </div>
                                                <div class="question-title">
                                                <span class="count_d"><b></b></spna>
                                                    <span class="editable" contenteditable="true" style="outline:none;"> {{$question->question_title}} </span>
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
                                                    @else

                                                        <div class="col-md-4">
                                                            <div class="preview-container"></div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="videoPreview" style="margin-top: 20px;"></div>
                                                        </div>

                                                    @endif
                                                        </div>
                                                </div>
                                                    @endif
                                                </div>

                                                <div class="option_html">
                                                    @if ($question->question_option1 !="")
                                                        <div class="option_tick">
                                                                <span><input type="radio" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option1}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option2 !="")
                                                        <div class="option_tick">
                                                                <span><input type="radio" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option2}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option3 !="")
                                                        <div class="option_tick">
                                                                <span><input type="radio" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option3}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option4 !="")
                                                        <div class="option_tick">
                                                                <span><input type="radio" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option4}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option5 !="")
                                                        <div class="option_tick">
                                                                <span><input type="radio" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option5}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option6 !="")
                                                        <div class="option_tick">
                                                                <span><input type="radio" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option6}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif



                                                </div>
                                                <div class="-xH-441"><button class="-z_-448" aria-label="Add option"><i class="fas fa-plus"></i> Add option</button></div>
                                                </div>
                                            {{-- @endif --}}

                                            @elseif ($question->question_type == 'multiType')
                                                <div class="q-html t-html" data-id="0">
                                                <input type="hidden" class="typeCheck"  value="multiType">
                                                <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                                                    <span class="audio-video" data-audio="<?php if($question->question_image){ echo $question->question_image;}?>" data-video="<?php if($question->question_video){ echo $question->question_video;}?>">
                                                    <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                                                    <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                                                    @if ($question->score_type)
                                                    <span class="mr-4 scoringGuideLine" data-type="{{$question->score_type}}" data-score="{{$question->score_option}}" data-content="{{$question->question_guidlines}}" style="display: inline;">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
                                                    @endif
                                                    <span class="d-flex justify-content-end align-items-center mr-4 {{ $question->assessment_only == 1 ? 'd-none' : '' }}"><input type="checkbox"  {{ $question->assessment_only == 1 ? 'checked disabled' : '' }} name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                                                    <span class="d-flex justify-content-end align-items-center"><input type="checkbox" {{ $question->question_require == 'true' ? 'checked' : '' }} name="required" class="mr-2"> Required</span>
                                                </div>
                                                <div class="question-title">
                                                <span class="count_d"><b></b></spna>
                                                    <span class="editable" contenteditable="true" style="outline:none;"> {{$question->question_title}} </span>
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
                                                @else

                                                    <div class="col-md-4">
                                                        <div class="preview-container"></div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="videoPreview" style="margin-top: 20px;"></div>
                                                    </div>

                                                    @endif
                                                </div>
                                                <div class="option_html">
                                                    @if ($question->question_option1 !="")
                                                        <div class="option_tick">
                                                                <span><input type="checkbox" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option1}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option2 !="")
                                                        <div class="option_tick">
                                                                <span><input type="checkbox" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option2}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option3 !="")
                                                        <div class="option_tick">
                                                                <span><input type="checkbox" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option3}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option4 !="")
                                                        <div class="option_tick">
                                                                <span><input type="checkbox" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option4}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option5 !="")
                                                        <div class="option_tick">
                                                                <span><input type="checkbox" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option5}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                    @if ($question->question_option6 !="")
                                                        <div class="option_tick">
                                                                <span><input type="checkbox" disabled></span>
                                                                <div class="option_title editable" style="outline:none;" contenteditable="true">
                                                                    {{$question->question_option6}}
                                                                </div>
                                                                <span class="delete-o"><i class="fa fa-trash"></i></span>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="-xH-441"><button class="-z_-448" aria-label="Add option"><i class="fas fa-plus"></i> Add option</button></div>
                                                </div>
                                            {{-- @endif --}}
                                            @elseif ($question->question_type == 'textType')
                                                <div class="q-html t-html textType" data-id="0">
                                                    <input type="hidden" class="typeCheck"  value="textType">
                                                    <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                                                        <span class="audio-video" data-audio="<?php if($question->question_image){ echo $question->question_image;}?>" data-video="<?php if($question->question_video){ echo $question->question_video;}?>">
                                                        <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                                                        <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                                                        @if ($question->score_type)
                                                        <span class="mr-4 scoringGuideLine" data-type="{{$question->score_type}}" data-score="{{$question->score_option}}" data-content="{{$question->question_guidlines}}" style="display: inline;">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
                                                        @endif
                                                        <span class="d-flex justify-content-end align-items-center mr-4 {{ $question->assessment_only == 1 ? 'd-none' : '' }}"><input type="checkbox"  {{ $question->assessment_only == 1 ? 'checked disabled' : '' }} name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                                                        <span class="d-flex justify-content-end align-items-center"><input type="checkbox" {{ $question->question_require == 'true' ? 'checked' : '' }} name="required" class="mr-2"> Required</span>
                                                    </div>
                                                    <div class="question-title">
                                                    <span class="count_d"><b></b></spna>
                                                    <span class="editable textq text" contenteditable="true" style="outline:none;"> {{$question->question_title}} </span>
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
                                                    @else

                                                        <div class="col-md-4">
                                                            <div class="preview-container"></div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="videoPreview" style="margin-top: 20px;"></div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="aswer-i">
                                                    <input class="---G-553 anstype" disabled="" readonly="" placeholder="Enter your answer" value="Enter your answer">
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                            @elseif ($question->question_type == 'yesNoType')
                                                <div class="q-html t-html yesNoType" data-id="0">
                                                    <input type="hidden" class="typeCheck"  value="yesNoType">
                                                    <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                                                        <span class="audio-video" data-audio="<?php if($question->question_image){ echo $question->question_image;}?>" data-video="<?php if($question->question_video){ echo $question->question_video;}?>">
                                                        <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                                                        <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                                                        @if ($question->score_type)
                                                        <span class="mr-4 scoringGuideLine" data-type="{{$question->score_type}}" data-score="{{$question->score_option}}" data-content="{{$question->question_guidlines}}" style="display: inline;">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
                                                        @endif
                                                        <span class="d-flex justify-content-end align-items-center mr-4 {{ $question->assessment_only == 1 ? 'd-none' : '' }}"><input type="checkbox"  {{ $question->assessment_only == 1 ? 'checked disabled' : '' }} name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                                                        <span class="d-flex justify-content-end align-items-center"><input type="checkbox" {{ $question->question_require == 'true' ? 'checked' : '' }} name="required" class="mr-2"> Required</span>
                                                    </div>
                                                    <div class="question-title">
                                                    <span class="count_d"><b></b></spna>
                                                    <span class="editable textq text" contenteditable="true" style="outline:none;"> {{$question->question_title}} </span>
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
                                                    @else

                                                        <div class="col-md-4">
                                                            <div class="preview-container"></div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="videoPreview" style="margin-top: 20px;"></div>
                                                        </div>

                                                        @endif
                                                    </div>
                                                    <div class="aswer-i">
                                                    <div class="d-flex align-items-center">
                                                        <div class="yes d-flex align-items-center mr-3">
                                                            <label class="btn {{$question->question_option1 == 1 ? 'btn-warning' : 'label_button';}} " for="yes">   <input type="radio" name="yesno" {{$question->question_option1 == 1 ? 'checked' : 'unCheked';}}  value="1" class="mr-2 anstype d-none"> Yes</label>
                                                        </div>
                                                        <div class="no d-flex align-items-center">
                                                            <label class="btn {{$question->question_option1 == 0 ? 'btn-warning' : 'label_button';}} " for="no">  <input type="radio"  name="yesno"  {{$question->question_option1 == 0 ? 'checked' : 'unCheked';}} value="0" class="mr-2 anstype d-none"> No</label>
                                                        </div>
                                                    </div>
                                            {{-- @endif --}}
                                            @elseif ($question->question_type == 'trueFalseType')
                                                <div class="q-html t-html trueFalseType" data-id="0">
                                                    <input type="hidden" class="typeCheck"  value="trueFalseType">
                                                    <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                                                        <span class="audio-video" data-audio="<?php if($question->question_image){ echo $question->question_image;}?>" data-video="<?php if($question->question_video){ echo $question->question_video;}?>">
                                                        <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                                                        <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                                                        @if ($question->score_type)
                                                        <span class="mr-4 scoringGuideLine" data-type="{{$question->score_type}}" data-score="{{$question->score_option}}" data-content="{{$question->question_guidlines}}" style="display: inline;">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
                                                        @endif
                                                        <span class="d-flex justify-content-end align-items-center mr-4 {{ $question->assessment_only == 1 ? 'd-none' : '' }}"><input type="checkbox"  {{ $question->assessment_only == 1 ? 'checked disabled' : '' }} name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                                                        <span class="d-flex justify-content-end align-items-center"><input type="checkbox" {{ $question->question_require == 'true' ? 'checked' : '' }} name="required" class="mr-2"> Required</span>
                                                    </div>
                                                    <div class="question-title">
                                                    <span class="count_d"><b></b></spna>
                                                    <span class="editable textq text" contenteditable="true" style="outline:none;"> {{$question->question_title}} </span>
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
                                                    @else

                                                        <div class="col-md-4">
                                                            <div class="preview-container"></div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="videoPreview" style="margin-top: 20px;"></div>
                                                        </div>

                                                        @endif
                                                    </div>
                                                </div>

                                                    <div class="aswer-i">
                                                    <div class="d-flex align-items-center">
                                                        <div class="yes d-flex align-items-center mr-3">
                                                        <label class="btn {{$question->question_option1 == 1 ? 'btn-warning' : 'label_button';}} " for="yes">  <input type="radio" name="trueFalse"  value="1"  {{$question->question_option1 == 1 ? 'checked' : 'unCheked';}} class="mr-2 anstype d-none" > True</label>
                                                        </div>
                                                            <div class="no d-flex align-items-center">
                                                    <label class="btn {{$question->question_option1 == 0 ? 'btn-warning' : 'label_button';}} " for="no"> <input type="radio"  name="trueFalse"  {{$question->question_option1 == 0 ? 'checked' : 'unCheked';}} value="0" class="mr-2 anstype d-none">  False</label>
                                                        </div>
                                                    </div>


                                                </div>
                                            @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="btn btn-warning btn-rounded mt-3 add_new" style="display:none;"><i class="fas fa-plus"></i> Add New</div>
                    <div class="q_frame" style="display:none;">
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                           <div class="-ec-234">
                              <button id="single-choice-type"><img src="{{url('dist-assets/images/choice.svg')}}" alt="">Single Choice</button>
                              <button id="multi-select-type"><img src="{{url('dist-assets/images/multiple-chouse.png')}}" alt="">Multiple Choice</button>
                              <button id="text-qes-type"> <img src="{{url('dist-assets/images/text.svg')}}" alt=""> Text</button>
                              <button id="ynq-type"><img src="{{url('dist-assets/images/ph_question.png')}}" alt="">YNQ</button>
                              <button id="tfq-type"><img src="{{url('dist-assets/images/ph_question.png')}}" alt=""> TFQ</button>
                           </div>
                        </div>
                    </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-2 form-group">
                            <button class="btn btn-warning w-100" type="submit" class="from-value">Save</button>
                        </div>
                        <div class="col-md-2">
                            <a href="#" class="btn btn-light backlink" style="width: 100%;">Back</a>
                        </div>
                    </div>


                </div>
            </div>
        </form>
    </div>



<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="cloase-l1">&times;</span>
                </button>
            <div class="modal-body">
               <h3 class="modal-title-cu mb-3"> Select Project To Include</h3>
               <div class="table-container">
               <table class="table ">
                            <thead>
                            <tr style="background-color:#fcfdfd;">
                                <td></td>
                                <th nowrap>PROJECT TITLE</th>
                                {{-- <th nowrap>DESCRIPTION</th> --}}
                                <th nowrap>PROJECT TYPE</th>
                                <th nowrap>CREATED DATE</th>
                                <th nowrap>CREATED BY</th>
                                <th nowrap>STATUS</th>
                            </tr>
                            </thead>
                            <tbody>

                        @if($projects->isNotEmpty())
                                        @foreach($projects as $project)
                                            <tr>
                                                <td><input type="checkbox" class="checkedArray" value="{{ $project->id }}"></td>
                                                <td>{{ $project->project_title }}</td>
                                                {{-- <td class="truncate"> {!! \Illuminate\Support\Str::words(strip_tags($project->project_description), 5, '...') !!}</td> --}}
                                                <td>{{ $project->project_type }}</td>
                                                <td>{{ date('m/d/Y', strtotime($project->created_at)) }}</td>
                                                <td>{{ $project->name }} {{ $project->lname }}</td>
                                                <td>
                                                    @if ($project->status == 1)
                                                        <b class="badge badge-warning">Draft<b>
                                                    @elseif ($project->status == 2)
                                                        <b class="badge badge-success">Active<b>
                                                    @else
                                                        <b class="badge badge-primary">Completed</b>
                                                    @endif
                                                    {{-- @if($project->status == 1)
                                                        <b style="color:#f1b82d;">Draft<b>
                                                    @elseif($project->status == 2)
                                                        <b style="color:green;">Active<b>
                                                    @elseif($project->status == 3)
                                                        <b>Completed</b>
                                                    @endif --}}

                                                </td>
                                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan="6" align="center" >No records are found</td></tr>
                        @endif
                        </tbody>
                        </table>
                        </div>


                        <div class="center-btn mt-3 text-center">
                            <button type="sunmit" class="btn btn-warning" id="includeProject">Include</button>
                            <button type="sunmit" class="btn " data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
            </div>

        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="questionBank" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document" style="min-width:70%;">
        <div class="modal-content" style="border-radius:22px; overflow: hidden;">
            <div class="modal-header" style="background-color: #f1b82d;border-radius: 0px;">
                   <h2 class="modal-title" style="color:#000; font-weight: 600;">Item Bank</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="background-color: black;color: #f1b82d;text-shadow: none;" class="cloase-l1">&times;</span>
                    </button>
            </div>

            <div class="modal-body">
               <div class="row" id="questionBankShow">

               </div>
               <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">

                <div></div>
                <div id="pagination" class="pagination mt-5"></div>

                </div>
            </div>

        </div>
    </div>
</div>




<!-- Confirmation Modal -->
<div class="modal fade" id="scoringguideline" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:22px; overflow: hidden;">
            <div class="modal-header" style="background-color: #f1b82d;border-radius: 0px;">
                   <h2 class="modal-title" style="color:#000; font-weight: 600;">Add Scoring Guidelines</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="background-color: black;color: #f1b82d;text-shadow: none;" class="cloase-l1">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="scoretype d-flex align-items-center justify-content-start mb-3">
                    <label class="mr-3 mb-0">Select Question Type: </label>
                    <span class="d-flex align-items-center justify-content-between mr-2"><input type="radio" value="O" class="mr-1" name="qtype"> Open Ended Question</span>
                    <span class="d-flex align-items-center justify-content-between mr-2"><input type="radio" value="A" class="mr-1" name="qtype"> Affirmations</span>
                    <span class="d-flex align-items-center justify-content-between mr-2"><input type="radio" value="R" class="mr-1" name="qtype"> Reflective Listening</span>
                    <span class="d-flex align-items-center justify-content-between mr-2"><input type="radio" value="S" class="mr-1" name="qtype"> Summaries</span>
                </div>


                <div class="score d-flex align-items-center justify-content-start mb-3">
                    <label class="mr-3 mb-0">Select Score :: </label>
                    <span class="d-flex align-items-center justify-content-between mr-3"><input type="checkbox" value="0" class="mr-1"> 0</span>
                    <span class="d-flex align-items-center justify-content-between mr-3"><input type="checkbox" value="1" class="mr-1"> 1</span>
                    <span class="d-flex align-items-center justify-content-between mr-3"><input type="checkbox" value="2" class="mr-1"> 2</span>
                </div>
                <div class="editor">
                    <textarea id="scoringdes" style="width:100%; height:200px;"  name="scoreguidelinetext"></textarea>
                </div>

                <div class="center-btn mt-3 text-center">
                            <button type="sunmit" class="btn btn-warning" id="saveguide">save</button>
                            <button type="sunmit" class="btn " data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="audioVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:22px; overflow: hidden;">
            <div class="modal-header" style="background-color: #f1b82d;border-radius: 0px;">
                   <h2 class="modal-title" style="color:#000; font-weight: 600;">Add Scoring Guidelines</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="background-color: black;color: #f1b82d;text-shadow: none;" class="cloase-l1">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="audio-video-upload">
                   <div class="audio mb-3">
                      <label>Image Upload</label>
                      <input class="form-control filetypeinput" style="width:300px;" type="file" name="files" accept="image/*">
                   </div>
                   <div class="video">
                   <label>Youtube Video URL:</label>
                   <input type="text" class="form-control">
                    </div>
                </div>

                <div class="center-btn mt-3 text-center">
                    <button type="sunmit" class="btn btn-warning" id="saveAudioVideo">save</button>
                    <button type="sunmit" class="btn " data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">

$(document).ready( function () {
    var $selectedDivAudioVideos;
    count();
 });

 $('#project_type').on('change', function (e) {
    var selectedValue = $(this).val();
    if (selectedValue.includes('Yes')) {
        $('#confirmationModal').modal('show');
    }
});

$('.checkedArray').on('change', function() {
    if ($(this).is(':checked')) {
        $('.checkedArray').not(this).prop('checked', false);
    }
});

$('#includeProject').click( function(){
    let projectIncludev = $(' table tr td .checkedArray:checked').val();
    $('#includeProjectArray').val(projectIncludev);
    $('#confirmationModal').modal('hide');
});







$(document).on('click','.delete', function(e){
    e.stopPropagation();
    $(this).parents('.preview-container').empty();
    $selectedDivAudioVideos.attr('data-audio', '');

});

$(document).on('click','.delete-video', function(e){
    e.stopPropagation();
    $(this).parents('.videoPreview').empty();
    $selectedDivAudioVideos.attr('data-video' , '');
});



ClassicEditor.create(document.querySelector('#assessmenteditor'),{
        toolbar: {
        items: [
            'heading' ,'bold', 'italic', 'link', 'undo', 'redo' // Custom toolbar configuration
        ]

    },
    })
    .then(editor => {
        window.editor = editor;
    })
    .catch(error => {
        console.error(error);
    });

$('#scoringRequired').on('change', function() {
    // Get the selected value
    let assessmentType = $(this).val();
    if(assessmentType == 0){
      $('.scoringGuideLine').hide();
      $('.scoringGuideLine').attr('data-type' ,'');
      $('.scoringGuideLine').attr('data-score' ,'');
      $('.scoringGuideLine').attr('data-content' ,'');
    }else{
      $('.scoringGuideLine').show();
      $('.scoringGuideLine').attr('data-type' ,'');
      $('.scoringGuideLine').attr('data-score' ,'');
      $('.scoringGuideLine').attr('data-content' ,'');
      $('.scoringGuideLine').removeClass('d-none');
    }

});

function saveAsDraft(){
    $("#project_create_type").val(1);
    $("#frm_create_project").submit();
}




document.getElementById('createAssessment').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var validator = true;
        var minimumOption = true;
        var questionTitleRequired  = true;
        var scoringRequiredCheck  = true;
        var question = [];
        let  scoringRequired = $('#scoringRequired').val();


        $('.all-question .t-html').each( function(index ,val){

            let qtype = $(this).find('.typeCheck').val();

             if(qtype == "singleType" || qtype == "multiType"){
                $(this).each( function(i){
                let  optiontype = [];
                var  qTitle = $(this).find('.question-title .editable').text();
                let  addQuestionBank = $(this).find('input[name="addtoquestionbank"]').is(':checked');
                let  required = $(this).find('input[name="required"]').is(':checked');
                let  questionAudio = $(this).find('.audio-video').attr('data-audio');
                let  questionVideo = $(this).find('.audio-video').attr('data-video');
                let  assessmentId = $(this).attr('data-id');
                let  scoreQuestionType = $(this).find('.scoringGuideLine').attr('data-type');
                let  qScore = $(this).find('.scoringGuideLine').attr('data-score');
                let  guideLines = $(this).find('.scoringGuideLine').attr('data-content');



                $(this).find('.option_html .option_title ').each(function(){
                        var option = $(this).text().trim();
                        if(option !=""){
                            optiontype.push(option);
                        }else{
                            validator = false;
                        }

                });
                if(qTitle !="" && optiontype.length == 0){
                    validator = false;
                }

                if(qTitle == ""){
                    questionTitleRequired = false;
                }
                if(optiontype.length == 1){
                    minimumOption = false;
                }


                let json = {
                    id: assessmentId,
                    qtype : qtype,
                    title : qTitle,
                    optiontype : optiontype,
                    addQuestionBank : addQuestionBank,
                    scoreQuestionType: scoreQuestionType,
                    qScore: qScore ,
                    guideLines: guideLines,
                    required:  required,
                    scoringRequired: scoringRequired,
                    questionAudio: questionAudio,
                    questionVideo: questionVideo
                }
                question.push(json);


                if(scoringRequired == 1){
                    if(scoreQuestionType == undefined && qScore ==undefined){
                        $(this).find('.scoringGuideLine b').text('Required');
                        scoringRequiredCheck = false;
                        return false;
                    }
                }
                });

             }else if(qtype == "textType"){

                $(this).each( function(i){
                            let title = $(this).find('.textq').text();
                            let anstype = $(this).find('.anstype').text();
                            let  addQuestionBank = $(this).find('input[name="addtoquestionbank"]').is(':checked');
                            let  required = $(this).find('input[name="required"]').is(':checked');
                            let  scoreQuestionType = $(this).find('.scoringGuideLine').attr('data-type');
                            let  qScore = $(this).find('.scoringGuideLine').attr('data-score');
                            let  guideLines = $(this).find('.scoringGuideLine').attr('data-content');
                            let  questionAudio = $(this).find('.audio-video').attr('data-audio');
                            let  questionVideo = $(this).find('.audio-video').attr('data-video');
                            let  assessmentId = $(this).attr('data-id');


                            if(title == ""){
                                questionTitleRequired = false;
                            }
                            let json = {
                                id: assessmentId,
                                qtype : qtype,
                                title : title ,
                                anstype : anstype ,
                                addQuestionBank : addQuestionBank,
                                scoreQuestionType: scoreQuestionType,
                                qScore: qScore ,
                                guideLines: guideLines,
                                required:  required,
                                questionAudio: questionAudio,
                                questionVideo: questionVideo
                            }
                            question.push(json);
                            if(scoringRequired == 1){
                                if(scoreQuestionType == undefined && qScore ==undefined){
                                    $(this).find('.scoringGuideLine b').text('Required');
                                    scoringRequiredCheck = false;
                                    return false;
                                }
                            }
                });
             }else{
                $(this).each( function(i){
                            let title = $(this).find('.textq').text();
                            let anstype = $(this).find('.anstype:checked').val();
                            let  addQuestionBank = $(this).find('input[name="addtoquestionbank"]').is(':checked');
                            let  required = $(this).find('input[name="required"]').is(':checked');
                            let  scoreQuestionType = $(this).find('.scoringGuideLine').attr('data-type');
                            let  qScore = $(this).find('.scoringGuideLine').attr('data-score');
                            let  guideLines = $(this).find('.scoringGuideLine').attr('data-content');
                            let  questionAudio = $(this).find('.audio-video').attr('data-audio');
                            let  questionVideo = $(this).find('.audio-video').attr('data-video');
                            let  assessmentId = $(this).attr('data-id');
                            if(title == ""){
                                questionTitleRequired = false;
                            }

                            let json = {
                                id: assessmentId,
                                qtype : qtype,
                                title : title ,
                                anstype : anstype ,
                                addQuestionBank : addQuestionBank,
                                scoreQuestionType: scoreQuestionType,
                                qScore: qScore ,
                                guideLines: guideLines,
                                required:  required,
                                questionAudio: questionAudio,
                                questionVideo: questionVideo
                            }
                            question.push(json);
                            if(scoringRequired == 1){
                                if(scoreQuestionType == undefined && qScore ==undefined){
                                    $(this).find('.scoringGuideLine b').text('Required');
                                    scoringRequiredCheck = false;
                                    return false;
                                }
                            }

                });
             }

        });


      if(scoringRequiredCheck == false){
        swal({
                icon: 'error',
                iconColor: '#f1b82d',
                text: 'Score guideline should be required.',
                timer: 3000,
                type: "error",
                showConfirmButton: false,
            });
            return false;
            e.preventDefault();
      }

        if(questionTitleRequired == false){
            swal({
                icon: 'error',
                iconColor: '#f1b82d',
                text: 'The question title should not be empty.',
                timer: 3000,
                type: "error",
                showConfirmButton: false,
            });
            return false;
            e.preventDefault();
        }
        if(minimumOption == false){
            swal({
                icon: 'error',
                iconColor: '#f1b82d',
                text: 'Add at least two options in question..',
                timer: 3000,
                type: "error",
                showConfirmButton: false,
            });
            return false;
            e.preventDefault();
        }

        if(validator == false){
            swal({
                icon: 'error',
                iconColor: '#f1b82d',
                text: 'Option field is required.',
                timer: 3000,
                type: "error",
                showConfirmButton: false,
            });
            return false;
            e.preventDefault();
        }
        if(question.length == 0){
            swal({
                icon: 'error',
                iconColor: '#f1b82d',
                text: 'Question field id required.',
                timer: 3000,
                type: "error",
                showConfirmButton: false,
            });
            return false;
        }




        $.ajax({
            url: "{{ route('assessment.save') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: formData.get('title'),
                scoring : $('#scoringRequired').val(),
                project_type: formData.get('project_type'),
                administration_schedule :  $('#shedule').select2('val'),
                description: formData.get('description'),
                projectinclude: formData.get('projectinclude'),
                questions : question
            },
            success: function (data) {
                $(window).scrollTop(0);
                $('#successMessage').show().find('.alert').text(data.success);
                window.location.href = data.redirect_url;
            },
            error: function (response) {
                var errors = response.responseJSON.errors;
                let res  = response.responseJSON;


                if(res.questiontitle){
                    swal({
                    icon: 'error',
                    iconColor: '#f1b82d',
                    title: res.existing_titles ,
                    text: res.questiontitle,
                    timer: 3000,
                    type: "error",
                    showConfirmButton: false,
                });

                }


                if (errors.title) {
                    $('#title').text(errors.title[0]).show().fadeOut(10000);
                }
                if (errors.project_type) {
                    $('#ptype').text(errors.project_type[0]).show().fadeOut(10000);
                }
                if (errors.administration_schedule) {
                    $('#ashedule').text(errors.administration_schedule[0]).show().fadeOut(10000);
                }
                if (errors.description) {
                    $('#description').text(errors.description[0]).show().fadeOut(10000);
                }
                if (errors.description) {
                    $('#description').text(errors.description[0]).show().fadeOut(10000);
                }




            }
        });



    });

// select from Item Bank

$('#selectFromQuestionBank').click(function(e) {
                e.preventDefault();
                fetchProjects();
            });


            function fetchProjects(page = 1) {
                $.ajax({
                    url: '{{ route("selectquestionbank") }}',
                    method: 'GET',
                    data: {_token: $('meta[name="csrf-token"]').attr('content'),},
                    data: { page: page},
                    beforeSend: function(){
                        $('#questionBankShow').empty();
                    },
                    success: function(response) {
                        setupPagination(response.questionBank);

                        $.each(response.questionBank.data, function(i,val){

                           if(val.question_type == "multiType" || val.question_type == "singleType"){
                            var option1= "", option2 = "", option3= "", option4= "", option5= "", option6= "";
                            if(val.question_option1 !=""){
                                 option1  = ` <div class="option_html">
                                        <div class="option_tick">
                                                <span><input type="radio" disabled></span>
                                                <div class="option_title editable"  style="outline:none;" contenteditable="false">
                                                    ${val.question_option1}
                                                </div>
                                        </div>`;
                            }
                            if(val.question_option2 !=""){
                                 option2  = ` <div class="option_html">
                                        <div class="option_tick">
                                                <span><input type="radio" disabled></span>
                                                <div class="option_title editable"  style="outline:none;" contenteditable="false">
                                                    ${val.question_option2}
                                                </div>
                                        </div>`;
                            }
                            if(val.question_option3 !=""){
                                 option3  = ` <div class="option_html">
                                        <div class="option_tick">
                                                <span><input type="radio" disabled></span>
                                                <div class="option_title editable"  style="outline:none;" contenteditable="false">
                                                    ${val.question_option3}
                                                </div>
                                        </div>`;
                            }
                            if(val.question_option4 !=""){
                                 option4  = ` <div class="option_html">
                                        <div class="option_tick">
                                                <span><input type="radio" disabled></span>
                                                <div class="option_title editable"  style="outline:none;" contenteditable="false">
                                                    ${val.question_option4}
                                                </div>
                                        </div>`;
                            }
                            if(val.question_option5 !=""){
                                 option5  = ` <div class="option_html">
                                        <div class="option_tick">
                                                <span><input type="radio" disabled></span>
                                                <div class="option_title editable"  style="outline:none;" contenteditable="false">
                                                    ${val.question_option5}
                                                </div>
                                        </div>`;
                            }
                            if(val.question_option6 !=""){
                                 option6  = ` <div class="option_html">
                                        <div class="option_tick">
                                                <span><input type="radio" disabled></span>
                                                <div class="option_title editable"  style="outline:none;" contenteditable="false">
                                                    ${val.question_option6}
                                                </div>
                                        </div>`;
                            }




                            let layout =`
                              <div class="col-md-6 mt-3">
                                <div class="q_bank_layout" data-img="${val.question_image}" data-video="${val.question_video}" data-id="${val.id}" data-type="${val.question_type}">
                                    <div class="row">
                                        <div class="col-md-10">
                                        <h4 class="h_title">${val.question_title}</h4>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="add_icon text-right">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                   ${option1}
                                    ${option2}
                                     ${option3}
                                      ${option4}
                                       ${option5}
                                        ${option6}
                                    </div>
                                </div>
                             </div>
                             `;
                             $('#questionBankShow').append(layout);
                           }else{
                             let layout =`
                              <div class="col-md-6 mt-3">
                                <div class="q_bank_layout" data-img="${val.question_image}" data-video="${val.question_video}" data-id="${val.id}" data-type="${val.question_type}">
                                    <div class="row">
                                        <div class="col-md-10">
                                        <h4 class="h_title">${val.question_title}</h4>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="add_icon text-right">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="Q_bank_ans">
                                          ${val.question_option1}
                                          </div>
                                       </div>
                                    </div>
                                </div>
                             </div>
                             `;
                             $('#questionBankShow').append(layout);
                           }
                        })

                        if (response.questionBank.data) {
                            $('#questionBank').modal('show');
                        }

                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

           // Function to set up pagination
           function setupPagination(data) {
                var pagination = $('#pagination');
                pagination.empty();


                var currentPage = data.current_page;
                var lastPage = data.last_page;


                if (data.first_page_url) {
                    pagination.append(' <li class="page-item"><a class="page-link" data-page="' + (currentPage - 1) + '" rel="prev" aria-label="« Previous">‹</a></li>');
                }

                var startPage = Math.max(currentPage - 2, 1);
                var endPage = Math.min(currentPage + 2, lastPage);
                for (var i = startPage; i <= endPage; i++) {
                    var btnClass = (i === currentPage) ? 'active' : '';
                    pagination.append('<li class="page-item ' + btnClass + '"><a class="page-link" data-page="' + i + '">' + i + '</a></li>');

                }

                if (data.next_page_url) {
                    pagination.append('<li class="page-item">' +
                            '<a class="page-link" data-page="'+ (currentPage + 1) +'" rel="next" aria-label="Next »">›</a>'+
                        '</li>'
                   );
                }

            }

            // Event handler for pagination buttons
            $(document).on('click', '#pagination .page-link', function () {
                var page = $(this).data('page');
                fetchProjects(page);
            });


            function extractYouTubeId(url) {
        var regExp = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|user\/\w+\/videos|playlist\?list=|embed\/|v=)?([^"&?\/\s]{11})/;
        var match = url.match(regExp);
        return match ? match[1] : null;
    }

 // select Question html from bank modal
 $(document).on('click','.add_icon i',function(e){
            e.preventDefault();
             let qtype = $(this).parents('.q_bank_layout').attr('data-type');
             let title = $(this).parents('.q_bank_layout').find('.h_title').text();
             let anstype = $(this).parents('.q_bank_layout').find('.Q_bank_ans').text();
             let id = $(this).parents('.q_bank_layout').attr('data-id');
             let img = $(this).parents('.q_bank_layout').attr('data-img');
             let  videoUrl = $(this).parents('.q_bank_layout').attr('data-video');

            var checkedSoringhtml = '';
            var display = '';
            if( $('#scoringRequired').val() == 0 ){
                display= "d-none"
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add Scoring Guideline <b class="text-danger"> *</b></span>
              `;
             }else{
                display= "";
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add Scoring Guideline <b class="text-danger"> *</b></span>
              `;
             }


             var videoId = extractYouTubeId(videoUrl);

            if (videoId) {
                // Construct the embed URL
                var embedUrl = 'https://www.youtube.com/embed/' + videoId;
            }

            var imgVideoUrlLayout = "";
             if(img !="" && videoUrl !=""){
                imgVideoUrlLayout = `
                    <div class="col-md-4">
                        <div class="preview-container">
                        <div class="preview mt-2">
                            <img src="{{url('assets/uploads/question/${img}')}}">
                            <button class="delete btn btn-warning">Remove</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <div class="videoPreview" style="margin-top: 20px;">
                        <iframe width="560" height="315" src="${embedUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                        <button class="delete-video btn btn-warning">Remove</button>
                        </div>
                    </div>

                `;

             }else if(img !=""){
                imgVideoUrlLayout = ` <div class="offset-2 col-8">
                        <div class="preview-container">
                        <div class="preview mt-2">
                            <img src="{{url('assets/uploads/question/${img}')}}">
                            <button class="delete btn btn-warning">Remove</button>
                        </div>
                        </div>
                    </div>`;
             }else if(videoUrl !=""){
                imgVideoUrlLayout = `   <div class="offset-2 col-8">
                        <div class="videoPreview" style="margin-top: 20px;">
                        <iframe width="560" height="315" src="${embedUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                        <button class="delete-video btn btn-warning">Remove</button>
                        </div>
                    </div>`;
             }else{
                imgVideoUrlLayout = `<div class="row">
                    <div class="col-md-4">
                           <div class="preview-container"></div>
                    </div>
                    <div class="col-md-8">
                         <div class="videoPreview" style="margin-top: 20px;"></div>
                    </div>
                </div>`;
             }



             if(qtype == "singleType"){

               var optionText = '';
               $(this).parents('.q_bank_layout').find('.option_html .option_title ').each( function(){
                let text = $(this).text();
                optionText +=  `<div class="option_tick">
                            <span><input type="radio" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                                ${text}
                            </div>
                            <span class="delete-o"><i class="fa fa-trash"></i></span>
                    </div>`;
               });

                var textHtml = `<div class="q-html t-html" data-id="0">
                <input type="hidden" class="typeCheck"  value="singleType">
                <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                    <span class="audio-video" data-audio="${img}" data-video="${videoUrl}">
                    <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                    <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                    ${checkedSoringhtml}
                    <span class=" mr-4 d-none"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                    <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
                </div>
                <div class="question-title">
                <span class="coun"t_d"><b></b></spna>
                    <span class="editable" contenteditable="true" style="outline:none;"> ${title}</span>
                </div>

                <div class="row">
                    ${imgVideoUrlLayout}
                </div>

                <div class="option_html">
                  ${optionText}
                </div>
                <div class="-xH-441"><button class="-z_-448" aria-label="Add option"><i class="fas fa-plus"></i> Add option</button></div>
            </div>`;



             }else if(qtype == "textType"){
                var textHtml = `<div class="q-html t-html textType" data-id="${id}">
                <input type="hidden" class="typeCheck"  value="textType">
                 <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                 <span class="audio-video" data-audio="${img}" data-video="${videoUrl}">
               <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                    <span class=" mr-4 d-none"><input type="checkbox" checked id="myCheckbox" name="addtoquestionbank" class="mr-2"> Add to Item Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>

                <div class="question-title">
                    <span class="count_d"><b></b></spna>
                    <span class="editable textq text" contenteditable="false" style="outline:none;"> ${title} </span>
                    </div>
                      <div class="row">
                    ${imgVideoUrlLayout}
                </div>
                <div class="aswer-i">
                <input class="---G-553 anstype" disabled="" readonly="" placeholder="Enter your answer" value="Enter your answer">
                </div>
                </div>`;


             }else if(qtype == "multiType"){

                var optionText = '';
               $(this).parents('.q_bank_layout').find('.option_html .option_title ').each( function(){
                let text = $(this).text();
                optionText +=  `<div class="option_tick">
                            <span><input type="checkbox" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                                ${text}
                            </div>
                            <span class="delete-o"><i class="fa fa-trash"></i></span>
                    </div>`;
               });

            var textHtml = `<div class="q-html t-html" data-id="0">
                <input type="hidden" class="typeCheck"  value="multiType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video" data-audio="${img}" data-video="${videoUrl}">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                <span class=" mr-4 d-none"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>

                <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable" contenteditable="true" style="outline:none;"> ${title} </span>
                </div>
                  <div class="row">
                    ${imgVideoUrlLayout}
                </div>

                <div class="option_html">
                   ${optionText}
                </div>
                <div class="-xH-441"><button class="multiQty" aria-label="Add option"><i class="fas fa-plus"></i> Add option</button></div>
            </div>`;


            }else if(qtype == "trueFalseType"){
                var textHtml = `<div class="q-html t-html trueFalseType" data-id="0">
             <input type="hidden" class="typeCheck"  value="trueFalseType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video" data-audio="${img}" data-video="${videoUrl}">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                    <span class=" mr-4 d-none"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>
             <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable textq text" contenteditable="true" style="outline:none;"> ${title} </span>
                </div>

                  <div class="row">
                    ${imgVideoUrlLayout}
                </div>
              <div class="aswer-i">
               <div class="d-flex align-items-center">
                   <div class="yes d-flex align-items-center mr-3">
                     <label class="btn btn-default label_button" for="true"> <input type="radio" name="trueFalse"  value="1" class="mr-2 anstype d-none" > True</label>
                    </div>
                     <div class="no d-flex align-items-center">
                  <label class="btn btn-default label_button" for="false">  <input type="radio"  name="trueFalse" value="0" class="mr-2 anstype d-none"> False</label>
                    </div>
              </div>
             </div>`;


             }
             else if(qtype == "yesNoType"){
                var textHtml = `<div class="q-html t-html yesNoType" data-id="0">
             <input type="hidden" class="typeCheck"  value="yesNoType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video" data-audio="${img}" data-video="${videoUrl}">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                    <span class="mr-4 d-none"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Items Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>
             <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable textq text" contenteditable="true" style="outline:none;"> ${title} </span>
                </div>

                  <div class="row">
                    ${imgVideoUrlLayout}
                </div>
              <div class="aswer-i">
               <div class="d-flex align-items-center">
                   <div class="yes d-flex align-items-center mr-3">
                         <label class="btn btn-default label_button" for="yes"> <input type="radio" name="yesno"  value="1" class="mr-2 anstype d-none "> Yes</label>
                    </div>
                     <div class="no d-flex align-items-center">
                          <label class="btn btn-default label_button" for="no"> <input type="radio"  name="yesno" value="0" class="mr-2 anstype d-none" > No</label>
                    </div>
              </div>
             </div>`;
             }
             $('.all-question').append(textHtml);
             swal({
                    title: "<h3>Question is successfully added.</h3>",
                    timer: 2000,
                    type: "success",
                    buttons: false,
                    showCancelButton: false,
                    showConfirmButton: false
                });
                count();

          });

// upload image for file question




   $(document).on('change','.filetypeinput', function(e){
          e.preventDefault();
          let thisRef = $(this);
          let formData = new FormData();
          let image = $(this)[0].files[0];
          formData.append('image', image);
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
            $.ajax({
                url: "{{ route('uploadimage') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $(thisRef).attr('data-img', response.image);
                },
            });


            var files = $(this)[0].files;
            $selectedDivAudioVideos.parents('.q-html').find(".preview-container").empty();
            if(files.length > 0){
                for(var i = 0; i < files.length; i++){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $selectedDivAudioVideos.parents('.q-html').find(".preview-container").append("<div class='preview mt-2'><img src='" + e.target.result + "'><button class='delete btn btn-warning'>Remove</button></div>");
                    };
                    reader.readAsDataURL(files[i]);
                }
            }
   });



      var editorInstance;
        ClassicEditor.create(document.querySelector('#scoringdes'),{
            // Custom configuration options
        toolbar: {
            items: [
                'heading' ,'bold', 'italic', 'link', 'undo', 'redo' // Custom toolbar configuration
            ]

        },
        })

        .then(editor => {
            editorInstance = editor;
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });



     var $selectedDiv;
     $(document).on('click', '.scoringGuideLine', function(e){
        e.preventDefault();
        $selectedDiv = $(this);
        let dataType = $(this).attr('data-type');
        let dataScore = $(this).attr('data-score');
        let dataContent = $(this).attr('data-content');


        if(dataType != null && dataType != undefined && dataType != ""){
            $('.score  input[type="checkbox"]').prop('checked', false);
            $('input[value="' + dataType + '"]').prop('checked', true);
            editorInstance.setData(dataContent);
            let valuesArray = dataScore.split(',');
            valuesArray.forEach(function(value) {
                $('input[value="' + value + '"]').prop('checked', true);
            });

        }else{
            $("#scoringguideline input[type='checkbox']").prop('checked', false);
                $("#scoringguideline input[type='radio']").prop('checked', false);

                if (editorInstance) {
                    editorInstance.setData('');
                }
        }

        $('#scoringguideline').modal('show');
     });

    $(document).on('click', '.audio-video', function(e){
        e.preventDefault();

        $selectedDivAudioVideos = $(this);
        let videoUrl = $(this).attr('data-video');
        let audioUrl = $(this).attr('data-audio');

         if(videoUrl !="" ){
            $(".audio  Input").val('');
            $(".video  Input").val(videoUrl);
         }else{
            $(".audio  Input").val('');
            $(".video  Input").val('');
         }


        $('#audioVideo').modal('show');
     });



     function showPreview(videos) {
            const url = videos;
            const videoId = url.split('v=')[1]; // Simplified extraction

            if (videoId) {
                $selectedDivAudioVideos.parents('.q-html').find('.videoPreview').empty();
                var iframe = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
               iframe += `<button class="delete-video btn btn-warning">Remove</button>`;
                $selectedDivAudioVideos.parents('.q-html').find('.videoPreview').append(iframe);
            }
        }

     $(document).on('click', '#saveAudioVideo', function(e){
        e.preventDefault();
        let audio = $(".audio  input").attr('data-img');
        let videos = $(".video  input").val();
        if(videos !=""){
            $selectedDivAudioVideos.attr('data-video', '');

        }
        $selectedDivAudioVideos.attr('data-video', videos);
        $selectedDivAudioVideos.attr('data-audio', audio);

        $('#audioVideo').modal('hide');
        showPreview(videos);

     });


     $(document).on('click', '#saveguide', function(e){
        e.preventDefault();
        let questionType = $(".scoretype  input[type='radio']:checked").val();
        let score = $(".score input[type='checkbox']:checked").map( function() {
            return  this.value;
        }).get().join(",");

        if (editorInstance) {
           var  editorContent =   editorInstance.getData();
        }


        //var editorContent = window.editor.getData();

        $selectedDiv.attr('data-type', questionType);
        $selectedDiv.attr('data-score', score);
        $selectedDiv.attr('data-content', editorContent);
        $('#scoringguideline').modal('hide');
     });


   function removeDiv(elem){
        $(elem).parents('.t-html').remove();
        count();
    }



    $(document).on('click','#myCheckbox', function(event) {
        event.preventDefault();
    });

</script>
    @endsection




