@extends('layout/header')

<?php if(isset($_GET['preproductid'])){
   $productId = $_GET['preproductid'];
}
 $userRolePermission = Session::get("role_module_permission");

 $rolePermission = array();
 if(array_key_exists(3,$userRolePermission)){
    $rolePermission = $userRolePermission[3];
 }
?>

    @section('content')
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Assessment</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
        <!--<a class="btn btn-outline-primary  mr-2" href="{{ route('assessment.questionbank') }}">Question Bank <i class="fa fa-file-text-o"></i></a>
           <a class="btn btn-outline-primary  mr-2" href="{{ route('assessment.template') }}">Templates <i class="fa fa-file-text-o"></i></a> -->
           @if(isset($userRolePermission[5]['add_permission']) && $userRolePermission[5]['add_permission'] == 1)
            <a class="btn btn-warning" href="javascript:void(0)" type="button" data-toggle="modal" data-target="#exampleModal">Create Assessment <i class="fas fa-plus-square"></i></a>
           @endif
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center pt-3">
        <div class="bd-text">
        <div class="accordion" id="accordionRightIcon">
            <div class="card ul-card__v-space m-0" style="border-radius: 10px;">
                <div class="card-header header-elements-inline" data-toggle="collapse" href="#filters" style="cursor: pointer;" aria-expanded="true">
                   <img src="{{ url('assets/images/filter.png')}}" alt="filter">
                </div>
                <div class="collapse p-2 <?php if(isset($_GET['sdate']) || isset($_GET['endDate']) || isset($_GET['status'])){ echo 'show';} ?> " id="filters" style="min-width:600px;">
                <div class="d-flex justify-content-between">
                         <div class="date-filter">
                         <a  style="min-width:150px;" href="#">
                          <input type="text" class="form-control mb-2" style="border: 1px solid #ced4da;  background-color: #f8f9fa;" id="startDate" value="<?php if(isset($_GET['sdate'])){echo $_GET['sdate']; }?>" readonly="" placeholder="From Date">
                          <input type="text"  class="form-control" style="border: 1px solid #ced4da;  background-color: #f8f9fa;" id="endDate" value="<?php if(isset($_GET['endDate'])){echo $_GET['endDate']; }?>" readonly="" placeholder="To Date">
                         </a>
                         </div>

                            <div class="project_filter">
                                <select value="" id="productFilter" style="width: 180px;">
                                    @if ( isset($projectDetail['project_title']) )
                                        <option value="{{$projectDetail['id']}}" selected>{{$projectDetail['project_title']}}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="status-filter">
                                <select id="typeFilter" value="" class="form-control" style="min-width:150px;">
                                    <option value="" disabled="" selected="" hidden="">Type</option>
                                    <option value="measure" @if ( isset($typeFilter) && $typeFilter=='measure' ) {{__('selected')}} @endif>Measure</option>
                                    <option value="survey" @if ( isset($typeFilter) && $typeFilter=='survey' ) {{__('selected')}} @endif>Survey</option>
                                </select>
                            </div>

                            <div class="status-filter">
                                <select id="statusFilter" value="" class="form-control" style="min-width:150px;">
                                    <option value="" disabled="" selected="" hidden="">Status</option>
                                    <option value="1" @if ( isset($filterStatus) && $filterStatus==1 ) {{__('selected')}} @endif>Draft</option>
                                    <option value="2" @if ( isset($filterStatus) && $filterStatus==2 ) {{__('selected')}} @endif>Published</option>
                                    <option value="3" @if ( isset($filterStatus) && $filterStatus==3 ) {{__('selected')}} @endif>Completed</option>
                                </select>
                            </div>

                            <div class="reset">
                            <a class="btn btn-raised btn-raised-secondary" style="color: #ef4166 !important;font-weight: 800;" href="{{ route('assessment.list') }}">
                            <img src="{{url('assets/images/ic-replay.png')}}" alt="filter">
                            Reset</a>
                            </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <form method="GET" action="">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="search" placeholder="Search......" name="search" value="{{ request()->search }}">
                <button type="submit" style="border:none;" class="ul-widget-app__find-font btn-warning">Search</button>
              </div>
            </form>
        </div>
    </div>



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
                                <th nowrap>INVITED</th>
                                <th nowrap>SUBMITTED</th>
                                <th nowrap>STATUS</th>
                                <th nowrap>CREATED AT</th>
                                <th nowrap align="center" width='130px'>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php

                              ?>
                            @if($assessments->isNotEmpty())
                            @foreach($assessments as $assessment)
                                <tr>
                                    <td>{{ $assessment->title }}</td>
                                    @if ( isset($assessment->assessmentProjectId->projectDetails->project_title) && !is_null($assessment->assessmentProjectId->projectDetails->project_title) )
                                        <td>{{ $assessment->assessmentProjectId->projectDetails->project_title }}</td>
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
                                            echo $assessment->scoring == 1 ? "Measure" : "Survey";
                                        @endphp

                                  </td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>
                                        @if ($assessment->status == 1)
                                            <b class="badge badge-warning">Draft<b>
                                        @elseif ($assessment->status == 2)
                                            <b class="badge badge-success">Published<b>
                                        @else
                                            <b class="badge badge-primary">Completed</b>
                                        @endif
                                    </td>
                                    <td>{{ date('m/d/Y', strtotime($assessment->created_at)) }}</td>
                                    <td>
                                        @if ( $actionMode == 'clone' )

                                            @if(isset($_GET['preproductid']))
                                                <a class="text-danger clone-assessment" href="{{ route('assessmentclone',['id'=>$assessment->id,'preproductid' => $productId ] ) }}" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Clone Assessment"> <img src="{{url('dist-assets/images/plus.svg')}}" alt="filter"></a>
                                            @else
                                                <a class="text-danger clone-assessment" href="{{ route('assessmentclone',['id'=>$assessment->id ] ) }}" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Clone Assessment"> <img src="{{url('dist-assets/images/plus.svg')}}" alt="filter"></a>
                                            @endif


                                        @else
                                        @if(isset($userRolePermission[5]['view_permission']) && $userRolePermission[5]['view_permission'] == 1)
                                        <a class="text-primary mr-2" href="view/{{$assessment->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip65478"><img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>
                                        @endif
                                            @if ($assessment->status == 1)
                                            @if(isset($userRolePermission[5]['edit_permission']) && $userRolePermission[5]['edit_permission'] == 1)
                                                <a class="text-success mr-2" href="edit/{{$assessment->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><img src="{{url('dist-assets/images/edit.png')}}" alt="filter"></a>
                                            @endif
                                            @if(isset($userRolePermission[5]['disable']) && $userRolePermission[5]['disable'] == 1)
                                                <a class="text-danger delete-assessment"  data-id="{{$assessment->id}}" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"> <img src="{{url('dist-assets/images/delete.png')}}" alt="filter"></a>
                                            @endif
                                            @endif
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



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                 <h2 class="text-center mb-3" style="font-weight: 700; color:#000;">New Assessment</h2>
                     <div class="assessment_create_box d-flex justify-content-between align-items-center">
                        <a href="{{ route('assessment.create') }}" class="assessment_b">
                            <div >
                                <img src="{{url('dist-assets/images/assessment_c1.svg')}}" alt="" class="mb-3">
                                <div class="assessment_title"><h3>Start From Scratch</h3></div>
                                <div class="assessment_content">
                                    <p>Create a new template and provide the required inputs to be reflected in the newly created project.</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('assessmentclonelist') }}" class="assessment_b">
                            <div >
                            <img src="{{url('dist-assets/images/assessment_c.svg')}}" alt="" class="mb-3">
                            <div class="assessment_title"><h3>Clone Assessment</h3></div>
                                <div class="assessment_content">
                                    <p>Copy any preexisting assessments and edit/modify the copied assessment file for creating the new assessment by cloning method.</p>
                                </div>
                            </div>
                        </a>
                     </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
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
    </div>


    <script type="text/javascript">

    $(document).on('click', '.delete-assessment', function(e) {
    let thisRef =  $(this);
    e.preventDefault();
    var assessmentId = $(this).data('id');
    swal({
      text: "Are you sure you want to delete this assessment?",
      icon: "warning",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#f1b82d',
      confirmButtonText: 'Yes, I am sure!',
      cancelButtonText: "No, cancel it!"
      }).then(function(isConfirm) {
      if (isConfirm.value) {
        $.ajax({
            url: '{{url('assessment/delete')}}/' +assessmentId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                thisRef.closest('tr').remove();
                swal({
                    text: response.message,
                    timer: 2000,
                    type: "success",
                    confirmButtonColor: "#f1b82d",

                });
                window.location.reload();
             },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
      }
    })


});

// Filters

$(document).on("change", "#startDate, #endDate , #typeFilter, #statusFilter, #productFilter", function(e){
    e.preventDefault();
    let projectVal = $("#productFilter").val() || '';
    let startDate = $('#startDate').val() || '';
    let endDate = $('#endDate').val();
    let typeFilter = ($('#typeFilter').val() == null) ? '': $('#typeFilter').val() ;
    let status = ($('#statusFilter').val() == null) ? '': $('#statusFilter').val() ;
    if (new Date(startDate) > new Date(endDate)) {
        swal({
            text: "Start Date Must Be Less Than End Date.",
            type: "warning",
            showCancelButton: false,
        });
        $('#endDate').datepicker('setDate', new Date());
    }
    if( startDate != "" &&  endDate == ""){
        return false;
    }

    var filterStr = '';
    if(startDate !="" && endDate !=""){
        filterStr += "sdate=" + startDate + "&endDate=" + endDate+"&";
    }
    if( typeFilter !='' ){
        filterStr += "typeFilter="+typeFilter+"&";
    }
    filterStr += "projectId=" + projectVal + "&status=" + status
    window.location.href = "?"+ filterStr
});
</script>
@endsection

