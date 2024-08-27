@extends('layout/header')
    @section('content')

<style>
.role-filter select.form-control , .status-filter select.form-control { -webkit-appearance: auto;
}
</style>

<?php
 $userRolePermission = Session::get("role_module_permission");


 $rolePermission = array();
 if(array_key_exists(3,$userRolePermission)){
    $rolePermission = $userRolePermission[3];
 }



 ?>
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Project Management</b></h3>
        </div>
        @if(isset($userRolePermission[4]['add_permission']) && $userRolePermission[4]['add_permission'] == 1)
            <div class="custome-btn d-flex justify-content-between">
                <a class="btn btn-warning" href="{{ route('project.create') }}">Create Project <i class="fas fa-plus-square"></i></a>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <div class="accordion" id="accordionRightIcon">
            <div class="card ul-card__v-space m-0" style="border-radius: 10px;">
                <div class="card-header header-elements-inline" data-toggle="collapse" href="#filters" style="cursor: pointer;" aria-expanded="true">
                   <img src="{{url('assets/images/filter.png')}}" alt="filter">
                </div>
                <div class="collapse p-2 <?php if(isset($_GET['startDate']) || isset($_GET['userrole']) || isset($_GET['userstatus'])){ echo 'show';} ?>" id="filters" style="min-width:600px;">
                <div class="d-flex justify-content-between">

                        <div class="date-filter">
                            <a  style="min-width:150px;" href="#">
                                <input type="text" class="form-control mb-2" style="border: 1px solid #ced4da;  background-color: #f8f9fa;" id="startDate" value="<?php if(isset($_GET['startDate'])){echo $_GET['startDate']; }?>" readonly="" placeholder="From Date">
                                <input type="text"  class="form-control" style="border: 1px solid #ced4da;  background-color: #f8f9fa;" id="endDate" value="<?php if(isset($_GET['endDate'])){echo $_GET['endDate']; }?>" readonly="" placeholder="To Date">
                            </a>
                         </div>
                         <div class="role-filter">
                            <select id="projectFilter"  class="form-control" style="min-width:150px;" name="pro_id" id="pro_id">
                            <option value="" disabled selected hidden><b>Project</b></option>
                                    @foreach($projectList as $projData)
                                    <option <?php if( isset($_GET['pro_id']) && $_GET['pro_id'] == $projData->id){ echo "selected";}?> value="{{$projData->id}}">{{$projData->project_title}}</option>
                                    @endforeach
                            </select>
                         </div>
                         <div  class="status-filter">
                         <select id="statusFilter" class="form-control" style="min-width:150px;">
                                    <option value="" disabled selected hidden><b>Status</b></option>
                                    <option value="1" <?php if(isset($_GET['prostatus']) && $_GET['prostatus'] == 1){ echo "selected";}?>>Draft</option>
                                    <option value="2" <?php if(isset($_GET['prostatus']) && $_GET['prostatus'] == 2){ echo "selected";}?>>Active</option>
                                    <option value="3" <?php if(isset($_GET['prostatus']) && $_GET['prostatus'] == 3){ echo "selected";}?>>Completed</option>
                            </select>
                         </div>
                         <div class="reset">
                            <a class="btn btn-raised btn-raised-secondary" style="color: #ef4166 !important;font-weight: 800;" href="{{ route('project.list') }}">
                            <img src="{{url('assets/images/ic-replay.png')}}" alt="filter">
                            Reset</a>
                         </div>
                   </div>
                </div>
            </div>
        </div>
        </div>
        <div class="custome-btn d-flex justify-content-between">
        <form  method="GET" action="">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="search_pro" name="search" placeholder="Search......" name="search" value="{{ request()->search }}">
                <button type="button" id="search_project" style="border:none;" class="ul-widget-app__find-font btn-warning">Search</button>
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
                                <th>ID</th>
                                <th>PROJECT TITLE</th>
                                <th>PROJECT TYPE</th>
                                <th>CREATED DATE</th>
                                <th>STATUS</th>
                                <th>CREATED BY</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($projectData->isNotEmpty())
                            @foreach($projectData as $proData)
                                <tr>
                                    <td>{{$proData->id}}</td>
                                    <td>{{$proData->project_title}}</td>
                                    <td>{{$proData->project_type}}</td>
                                    <td>{{date('m/d/Y',strtotime($proData->created_at))}}</td>
                                    <td>
                                        @if ($proData->status == 1)
                                            <b class="badge badge-warning">Draft<b>
                                        @elseif ($proData->status == 2)
                                            <b class="badge badge-success">Active<b>
                                        @else
                                            <b class="badge badge-primary">Completed</b>
                                        @endif
                                        {{-- @if($proData->status == 1)
                                            <b style="color:#f1b82d;">Draft<b>
                                        @elseif($proData->status == 2)
                                            <b style="color:green;">Active<b>
                                        @elseif($proData->status == 3)
                                            <b>Completed</b>
                                        @endif --}}

                                    </td>
                                    <td>{{$proData->name}} {{$proData->lname}}</td>
                                    <td>
                                        @if(isset($userRolePermission[4]['view_permission']) && $userRolePermission[4]['view_permission'] == 1)
                                        <a class="text-primary mr-2" href="{{route('project.view',['id' => $proData->id])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip65478"><img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>
                                        @endif
                                        @if($proData->status == 1)
                                        @if(isset($userRolePermission[4]['edit_permission']) && $userRolePermission[4]['edit_permission'] == 1)
                                        <a class="text-success mr-2" href="{{route('project.edit',['id' => $proData->id])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><img src="{{url('dist-assets/images/edit.png')}}" alt="filter"></a>
                                        @endif
                                        @if(isset($userRolePermission[4]['disable']) && $userRolePermission[4]['disable'] == 1)
                                        <a class="text-danger delete-project"  data-id="{{$proData->id}}" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"> <img src="{{url('dist-assets/images/delete.png')}}" alt="filter"></a>
                                        @endif
                                        @endif
                                        <!-- <a class="text-danger confirmation dtRowDelete pointer" style="cursor: pointer !important;" id="3" data-toggle="tooltip" data-name="disable" data-placement="top" title="" data-original-title="Disable"><i class="actionDelete disable fas fa-minus-square"></i></a> -->
                                        <a class="text-danger user_managemnt_modal"data-id="{{$proData->id}}" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Team Management"> <img src="{{url('dist-assets/images/user_management.svg')}}" alt="filter"></a>

                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    No records are found
                                </td>
                            </tr>
                            @endif
                            </tbody>
                        </table>



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

                            {!! $projectData->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
                <!-- end of col-->
            </div>
        </div>



<!-- User Management Modal -->

<div id="userManagemnt" class="modal fade" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f1b82d;border-radius: 0px;">
                   <h2 class="modal-title" style="color:#000; font-weight: 600;">Manage Project Team</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="background-color: black;color: #f1b82d;text-shadow: none;" class="cloase-l1">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row" id="userManagemntAddSection">
                    <div class="col-md-12">
                            <div class="t-head d-flex align-items-center" style="justify-content: space-evenly;">
                                <div class="search-label">Search User</div>
                                <div class="search-input" style="width:200px;">
                                <select class="form-control" id="usersearch">
                                    <option></option>
                                </select>
                                </div>
                                <div class="search-buttom">
                                    <button type="submit" class="btn btn-warning" id="addUser"> Add <img src="{{url('dist-assets/images/user-m-icon.png')}}" alt="user"></button>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="usermanament-table mt-4" style="height: 300px;overflow-y: scroll;">
                    <table class="table">
                        <thead>
                            <tr style=" background-color: #f7f7f7;">
                                <td align="center">SR.NO.</td>
                                <td align="center">USER</td>
                                <td align="center">ROLES</td>
                                <td align="center">ACTION</td>
                            </tr>
                        </thead>
                        <tbody id="searchResults">
                            <!-- Results will be appended here -->
                        </tbody>
                    </table>


                    <li style="color:#000000;"><b>Yellow Highlighted User(s) is Project Manager</b></li>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
 <script type="text/javascript">
            const currentUserID = {{Session::get('user_id')}}

            $(document).on('click', '.delete-project', function(e) {
            let thisRef =  $(this);
            e.preventDefault();
            var projectId = $(this).data('id');
            swal({
            title: "<h3>Are you sure you want to delete this Project?</h3>",
            text: "Note : Deleting the project will also delete it's linked assessments & the linked user info.",
            icon: "warning",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#f1b82d',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            }).then(function(isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    url: '{{url('project/delete')}}',
                    type: 'POST',
                    data:{'id':projectId},
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
        $(document).on('change', '#statusFilter, #projectFilter, #startDate, #endDate', function(){
            filterSearch();
        });
        $("#search_project").on("click",function(d){
            filterSearch();
        });
        function filterSearch(){
            let startDate = ($('#startDate').val() == NaN || $('#startDate').val() == undefined)? '': $('#startDate').val();
            let endDate = ($('#endDate').val() == NaN || $('#endDate').val() == undefined)? '': $('#endDate').val();
            let filterRole = ($('#projectFilter').val()== NaN || $('#projectFilter').val() == undefined)? '': $('#projectFilter').val();
            let filterStatus = ( $('#statusFilter').val() == NaN ||  $('#statusFilter').val() == undefined)?'': $('#statusFilter').val();
            let searchVal = ( $('#search').val() == NaN ||  $('#search_pro').val() == undefined)?'': $('#search_pro').val();

            if (new Date(startDate) > new Date(endDate)) {
                swal({
                    text: "Start Date Must Be Less Than End Date.",
                    type: "warning",
                    showCancelButton: false,
                });

                $('#endDate').datepicker('setDate', new Date());
                return false;
            }

            if( startDate != "" &&  endDate == ""){
                return false;
            }


            window.location.href ="?startDate=" + startDate + "&endDate=" + endDate + "&pro_id=" + filterRole + "&prostatus=" + filterStatus+"&search="+searchVal;
        }



        $(document).ready( function(){
            var selectedUser = null;

      $('.user_managemnt_modal').on('click',  function(e){
          e.preventDefault();

          let project_id = $(this).attr('data-id');
          $('#userManagemnt').attr('data-projectid', project_id);
          fetchList();
          $('#userManagemnt').modal('show');

      });

    //search users for modals




        $('#userManagemnt').on('shown.bs.modal', function () {
            $('#usersearch').select2({
                    minimumInputLength: 3,
                    ajax: {
                        url: '{{ route('user.search') }}',
                        type: "post",
                        dataType: 'json',
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        delay: 10,
                        data: function(params) {
                        return {
                            searchTerm: params.term
                            }
                        },
                        processResults: function(response) {
                            return {
                                results: $.map(response, function(item) {
                                    return {
                                        text: item.name + ' ' + item.lname + '',
                                        name: item.name,
                                        lname: item.lname,
                                        id: item.id,
                                        role: item.role_title
                                    }
                                })
                            };
                        },
                        cache: true
                },
                });
            });



        // $('#userManagemnt').on('hidden.bs.modal', function () {
        //       $('#usersearch').select2('destroy');
        //  });


        $('#usersearch').on('select2:select', function (e) {
            selectedUser = e.params.data;
        });

            $(document).on('click', '#addUser', function(){

              //  let selectedUser = $('#usersearch').select2('data')[0];
                let project_id = $('#userManagemnt').attr('data-projectid');


                $('#usersearch').val(null).trigger('change');

                        if(selectedUser.id > 0 && selectedUser.name  != undefined){
                        let rowCount = $('#searchResults tr').length ;
                        // Append the selected user to the list
                        $('#searchResults').append(
                        `<tr data-id="${selectedUser.id}">
                            <td align="center">${rowCount + 1}</td>
                            <td align="center">${selectedUser.name} ${selectedUser.lname}</td>
                            <td align="center">${selectedUser.role}</td>
                            <td align="center"> <i class='fas fa-minus-circle mr-2 userRemove' style='font-size:18px;color:red; cursor:pointer;'></i> <img src="{{url('dist-assets/images/user-yellow.png')}}" alt="filter" id="projectTeamAdd" style="cursor:pointer;"></td>
                        </td>
                        `
                        );

                        addUser(project_id, selectedUser.id , ismanage = 0 , selectedUser.role)

                        // Clear the Select2 selection
                        $('#usersearch').val(null).trigger('change');
                    }else{
                        swal({
                                text: `Please select atleast 1 user. `,
                                timer: 2000,
                                type: "error",
                                confirmButtonColor: "#f1b82d",
                            });
                        }



               });


            $(document).on('click', '.userRemove' , function(e){
                e.preventDefault();
                let thisre = $(this);
                $('#usersearch').val(null).trigger('change');

                var formData = {
                    project_id: $('#userManagemnt').attr('data-projectid'),
                    user_id: $(this).parents('tr').attr('data-id'),
                };

                $.ajax({
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('project.teamdelete')}}',
                data: formData,
                dataType: 'json',
                encode: true,
                success: function (data) {

                    let name = thisre.parents('tr').find('td:nth-child(2)').text();



                    if(data.deleted_rows > 0){
                        thisre.parents('tr').remove();

                        swal({
                            text: `${name} user deleted successfully `,
                            timer: 2000,
                            type: "success",
                            confirmButtonColor: "#f1b82d",
                        });


                        $('#searchResults tr').each( function(index ,val){
                        index  = index + 1;
                        $(this).find('td:nth-child(1)').text(index);
                        })
                    }


                    // Optionally, you can handle success actions here
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                    // Optionally, you can handle error actions here
                 }
               });
            });


            $(document).on( 'click','#projectTeamAdd', function (event) {
            event.preventDefault();
            let thisre = $(this);
            var formData = {
                project_id: parseInt( $('#userManagemnt').attr('data-projectid')),
                user_id:  parseInt($(this).parents('tr').attr('data-id')),
                ismanger: 1,
            };

            $.ajax({
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('project.team') }}',
                data: formData,
                dataType: 'json',
                encode: true,
                success: function (data) {
                   // thisre.parents('tr').find('td:nth-child(3)').text('Manager');
                    //thisre.parents('tr').css('background-color', '#f1b01138');
                    fetchList();
                    let name = thisre.parents('tr').find('td:nth-child(2)').text();
                    swal({
                            text: `${name} role is updated as Project Manager`,
                            timer: 2000,
                            type: "success",
                            confirmButtonColor: "#f1b82d",
                        });
                },

            });
        });



     function addUser(projectid, userid , ismanage ,roleTitle ){

        var formData = {
                project_id: projectid,
                user_id:  userid,
                ismanger: ismanage,
            };

            $.ajax({
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('project.create') }}',
                data: formData,
                dataType: 'json',
                encode: true,
                success: function (data) {
                    if(data.message !="" && data.message != undefined){
                          $('#searchResults tr:last-child[data-id="'+data.id+'"]').remove();

                        swal({
                                text: `${data.message}`,
                                timer: 2000,
                                type: "error",
                                confirmButtonColor: "#f1b82d",
                            });

                    }

                },

            });
     }



    function fetchList(){
        $('#searchResults').empty();
            $("#userManagemntAddSection").show();
          $.ajax({
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('project.teamlist') }}',
                data: {
                    project_id: parseInt($('#userManagemnt').attr('data-projectid'))
                },
                dataType: 'json',
                encode: true,
                success: function (data) {

                    let canTeamManage = {{$currentUserType}} == 1 ? true : false;

                    if( canTeamManage == false ){
                        $.each(data.users, function(index,val){
                            canTeamManage = val.ismanger == 1 && val.user_detail.id == currentUserID ? true : canTeamManage;
                        });
                    }

                    if( !canTeamManage ){
                        $("#userManagemntAddSection").hide('fast');
                    }

                    $.each(data.users, function(index,val){

                        index  = index + 1;
                        let style = '';
                        if(val.ismanger == 1){
                            style = 'style="background-color: rgba(241, 176, 17, 0.22);"';
                        }

                        if(val.user_detail != null){
                                var appendHtml = `<tr ${style} data-id="${val.user_detail.id}">`
                                    appendHtml += `<td align="center">${index}</td>`
                                    appendHtml += `<td align="center">${val.user_detail.name} ${val.user_detail.lname}</td>`
                                    appendHtml += `<td align="center">${val.user_detail.user_role_detail.role_title}</td>`
                                    appendHtml += canTeamManage ? `<td align="center"> <i class='fas fa-minus-circle mr-2 userRemove' style='font-size:18px;color:red; cursor:pointer;'></i> <img src="{{url('dist-assets/images/user-yellow.png')}}" alt="filter" id="projectTeamAdd" style="cursor:pointer;"></td>` : `<td></td>`
                                appendHtml += `</td>`;

                                $('#searchResults').append(appendHtml);
                        }

                    });

                },

            });
    }
});

    </script>
@endsection
