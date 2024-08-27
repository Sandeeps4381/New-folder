@extends('layout/header')

    @section('content')

<style>

.role-filter select.form-control , .status-filter select.form-control {
    -webkit-appearance: auto;
}
</style>

@php
    $userRolePermission = Session::get("role_module_permission");

    $rolePermission = array();
    if(array_key_exists(4,$userRolePermission)){
        $rolePermission = $userRolePermission[4];
    }
@endphp

    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>View Project</b></h3>
        </div>
        @if(isset($userRolePermission[4]['edit_permission']) && $userRolePermission[4]['edit_permission'] == 1)
            <div class="custome-btn d-flex justify-content-between">
                <a class="btn btn-warning" href="{{route('project.edit',['id' => $projDetails[0]->id])}}">Edit Project  <img  src="{{url('dist-assets/images/editsvg.svg')}}" style="width:13px;"></a>
            </div>
        @endif
    </div>

    <div class="mt-3">
        <form method="post" action="">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="card-title mb-3">Project Details</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12  mb-3">
                           <img src="{{url(IMG_UPLOAD_PATH.'/'.$projDetails[0]->project_image)}}" class="img-fluid rounded w-100">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label >Title</label>
                            <input class="form-control"  readonly type="text" value="{{$projDetails[0]->project_title}}">
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label>Project Type</label>
                            <select class="select2 form-control w-100" disabled>
                            <option>Project Type</option>
                                <option value="Research" <?php if($projDetails[0]->project_type == 'Research'){ echo "selected";}?>>Research</option>
                                <option value="Non-Research" <?php if($projDetails[0]->project_type == 'Non-Research'){ echo "selected";}?>>Non-Research</option>
                            </select>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description</label>
                            <div id="editorview" style="padding-bottom: 100px;"  >

                            {!! old('content', $projDetails[0]->project_description) !!}

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="card-title mb-3">Add Guidelines</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description:</label>
                            <div id="editorguide" style="padding-bottom: 100px;" >

                            {!! old('content', $projDetails[0]->project_guideline) !!}
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-md-2 form-group">
                            <button class="btn btn-warning w-100" type="submit">Create Project</button>
                        </div>
                        <div class="col-md-2">
                            <a href="#" class="btn btn-light" style="width: 100%;">Cancel</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </form>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
                    <table class="table ">
                            <thead>
                            <tr>

                                <th nowrap>ASSESSMENT TITLE</th>
                                <th nowrap>PROJECT NAME</th>
                                {{-- <th>INCLUDE IN PROJECT</th> --}}
                                <th nowrap>ASSESSMENT TYPE</th>
                                {{----<th>ADMINISTRATION SCHEDULE</th> ----}}
                                <th nowrap>TOTAL INVITED</th>
                                <th nowrap>TOTAL SUBMITTED</th>
                                <th nowrap>STATUS</th>
                                <th nowrap>CREATED AT</th>
                                <th nowrap align="center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php

                              ?>
                            @if($assessments->isNotEmpty())
                            @foreach($assessments as $assessment)
                                <tr>
                                    <td>{{ $assessment->title }}</td>
                                    @if ( isset($assessment->project_title) && !is_null($assessment->project_title) )
                                        <td>{{ $assessment->project_title }}</td>
                                    @else
                                        <td>--</td>
                                    @endif
                                    {{-- <td>
                                        @php
                                            echo $assessment->project_type == 'No' ? "No" : "Yes";
                                        @endphp
                                    </td> --}}
                                    <td>
                                    {{-- < ?php

                                    $scheduleUpcoming = explode(',' , $assessment->administration_schedule );
                                    foreach($scheduleUpcoming as $val){
                                        if($val != ""){
                                           $val =  (int) $val;
                                            echo $schedule[$val].',<br>';
                                        }

                                    }

                                   ?>--}}
                                   @php
                                            echo $assessment->scoring == 0 ? "Survey" : "Measure";
                                        @endphp

                                  </td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>
                                        {{-- @if($assessment->assessment_status == 1)
                                         <b style="color:#f1b82d;">Draft<b>
                                        @elseif ($assessment->assessment_status == 3)
                                         <b style="color:green;">Published<b>
                                        @else
                                         Completed
                                        @endif --}}
                                        @if ($assessment->assessment_status == 1)
                                            <b class="badge badge-warning">Draft<b>
                                        @elseif ($assessment->assessment_status == 2)
                                            <b class="badge badge-success">Published<b>
                                        @else
                                            <b class="badge badge-primary">Completed</b>
                                        @endif
                                   </td>
                                    <td>{{ date('m/d/Y', strtotime($assessment->created_at)) }}</td>
                                    <td>

                                        <a class="text-primary mr-2" href="{{route('assessment.view',['id' => $assessment->assessment_id])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip65478"><img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>

                                            @if ($assessment->status == 1)
                                                {{-- <a class="text-success mr-2" href="{{route('assessment.edit',['id' => $assessment->assessment_id])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><img src="{{url('dist-assets/images/edit.png')}}" alt="filter"></a> --}}
                                                <a class="text-danger delete-assessment"  data-id="{{$assessment->assessment_id}}" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unlink"> <i class="fas fa-minus-circle unlink" data-projectid="{{$projDetails[0]->id}}" data-id="{{$assessment->assessment_id}}" style="position:relative; top:4px;font-size:18px;color:red; cursor:pointer;"></i></a>
                                            @endif

                                    </td>
                                </tr>
                            @endforeach
                             @else
                            <tr><td colspan="6" class="text-center">No records are found</td></tr>
                            @endif
                            </tbody>
                        </table>

                        <div class="col-md-12">
                            {!! $assessments->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
            <!-- end of col-->
        </div>

    </div>
    <script src="{{ asset('dist-assets/js/plugins/quill.min.js')}}"></script>
    <script src="{{ asset('dist-assets/js/scripts/quill.script.min.js')}}"></script>

    <script type="text/javascript">

    const options = {
  readOnly: true,
  modules: {
    toolbar: true
  },
  theme: 'snow'
};
const quill = new Quill('#editorview', options);
const quill1 = new Quill('#editorguide', options);




$(document).on('click', '.unlink' , function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    var projectid = $(this).attr('data-projectid');
    $.ajax({
    type: 'POST',
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '{{ route('project.unlink')}}',
    data: {
        id: id,
        projectid: projectid
    },
    dataType: 'json',
    encode: true,
    success: function (data) {
               if(data.message){
                    swal({
                            text: `${data.message}`,
                            timer: 2000,
                            type: "success",
                            confirmButtonColor: "#f1b82d",
                    });
               }
               location.reload();
        },
    error: function (xhr, textStatus, errorThrown) {
        console.error('Error:', errorThrown);
        // Optionally, you can handle error actions here
        }
    });
});

    </script>
    @endsection
