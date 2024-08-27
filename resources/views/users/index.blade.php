    @extends('layout/header')
    
    @section('content')

<style>

.role-filter select.form-control , .status-filter select.form-control {
    -webkit-appearance: auto;
}
</style>
<?php
 $userRolePermission = Session::get("role_module_permission");


 $rolePermission = array();
 if(array_key_exists(3,$userRolePermission)){
    $rolePermission = $userRolePermission[3];
 }

//  echo '<pre>';
//  print_r( $userRolePermission);
//  die;

 ?>
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
          <h3><b> <a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>  User Management</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <?php if(!empty($rolePermission)){?>
            <a class="btn btn-warning  mr-3 " href="{{ route('user.list-role') }}">Roles <img src="{{url('assets/images/reset.svg')}}" alt="filter"></a>
            <?php } ?>
            <?php if(isset($userRolePermission[2]['add_permission']) && $userRolePermission[2]['add_permission'] == 1) {?>
                <a class="btn btn-warning " href="{{ route('user.create') }}">Add User <i class="fas fa-plus-square"></i></a>
            <?php } ?>
        </div>               
    </div>


    <div class="d-flex justify-content-between align-items-center pt-3">
        <div class="bd-text">
        <div class="accordion" id="accordionRightIcon">
            <div class="card ul-card__v-space m-0" style="border-radius: 10px;">
                <div class="card-header header-elements-inline" data-toggle="collapse" href="#filters" style="cursor: pointer;" aria-expanded="true">
                   <img src="{{url('assets/images/filter.png')}}" alt="filter">
                </div>
                <div class="collapse p-2 <?php if(isset($_GET['fdate']) || isset($_GET['userrole']) || isset($_GET['userstatus'])){ echo 'show';} ?>" id="filters" style="min-width:600px;">
                <div class="d-flex justify-content-between">
                         <div class="date-filter">
                            <a  style="min-width:150px;" href="#">
                            <input type="text" class="form-control mb-2" style="border: 1px solid #ced4da;  background-color: #f8f9fa;" id="startDate" value="<?php if(isset($_GET['startDate'])){echo $_GET['startDate']; }?>" readonly="" placeholder="From Date"> 
                            <input type="text"  class="form-control" style="border: 1px solid #ced4da;  background-color: #f8f9fa;" id="endDate" value="<?php if(isset($_GET['endDate'])){echo $_GET['endDate']; }?>" readonly="" placeholder="To Date"> 
                            </a>
                         </div>

                            <div class="role-filter">
                                <select id="roleFilter" class="form-control" style="min-width:150px;">
                                <option  value="" disabled selected hidden><b>By Role</b></option>
                                    @if(!empty($rolesData))
                                    @foreach($rolesData as $role)
                                    <option value="{{$role->id}}" <?php if(isset($_GET['userrole']) && $_GET['userrole'] == $role->id){ echo "selected"; }?>>{{$role->role_title}}</option>
                                    @endforeach;
                                    @endif;
                                </select>
                            </div>
                            
                            <div class="status-filter">
                            <select id="statusFilter" class="form-control" style="min-width:150px;">
                                        <option value="" disabled selected hidden><b>Status</b></option>
                                        <option value="active" <?php if(isset($_GET['userstatus']) && $_GET['userstatus'] == 'active'){ echo "selected"; }?>>Active</option>
                                        <option value="inactive"  <?php if(isset($_GET['userstatus']) && $_GET['userstatus'] == 'inactive'){ echo "selected"; }?>>Inactive</option>
                                </select>
                            </div>
                        
                            <div class="reset">
                            <a class="btn btn-raised btn-raised-secondary" style="color: #ef4166 !important;font-weight: 800;" href="{{ route('user.list') }}"> 
                            <img src="{{url('assets/images/ic-replay.png')}}" alt="filter">   
                            Reset</a>
                            </div>
"
                    </div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <form  method="GET" action="">
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
                                <th>ID</th>
                                <th>NAME</th>              
                                <th>EMAIL</th>
                                <th>CREATED ON</th>
                                <th>ROLE</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php
                          
                              ?>
                            @if($users->isNotEmpty())
                            @foreach($users as $user)
                            
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }} {{ $user->lname }}</td>
                                    
                                    <td>{{ $user->email }}</td>
                                    <td>
                                    {{ date('m/d/Y', strtotime($user->created_at)) }}
                                </td>
                                    <td>{{ $user->role_title }}</td>
                                    <td>
                                        <?php if(isset($userRolePermission[2]['view_permission']) && $userRolePermission[2]['view_permission'] == 1){?>
                                            <a class="text-primary mr-2" href="view/{{$user->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip65478"><img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>
                                        <?php } ?>
                                        <?php if(isset($userRolePermission[2]['edit_permission']) && $userRolePermission[2]['edit_permission'] == 1){?>
                                            <a class="text-success mr-2" href="edit/{{$user->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><img src="{{url('dist-assets/images/edit.png')}}" alt="filter"></a>
                                        <?php } ?>
                                        <?php if(isset($userRolePermission[2]['disable']) && $userRolePermission[2]['disable'] == 1){?>
                                            <a class="text-danger confirmation dtRowDelete pointer" style="cursor: pointer !important;"> 
                                            <label class="switch switch-danger">
                                            <input  data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"  {{ ($user->role_status == 'inactive') ? 'uncheked' : 'checked' }}>
                                            <span class="slider round"></span>
                                            </label>
                                            </a>
                                        <?php } ?>
                    
                                    </td>
                                </tr>
                            @endforeach
                             @else
                            <tr><td colspan="6" align="center" >No records are found</td></tr>
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
    
    {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
 
                        
      
                    </div>
                </div>
            </div>
            <!-- end of col-->
        </div>
</div>

<script type="text/javascript">
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 'active' : 'inactive'; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{url('user/status')}}',
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              swal({
                text: data.success,
                timer: 2000,
                type: "success",
                confirmButtonColor: "#f1b82d",

              });
            }
        });
    });

    $(document).on('change', '#statusFilter, #roleFilter, #startDate , #endDate', function(){
        let startDate = ($('#startDate').val() == NaN || $('#startDate').val() == undefined)? '': $('#startDate').val();
        let endDate = ($('#endDate').val() == NaN || $('#endDate').val() == undefined)? '': $('#endDate').val();
        let filterRole = ($('#roleFilter').val()== NaN || $('#roleFilter').val() == undefined)? '': $('#roleFilter').val();
        let filterStatus = ( $('#statusFilter').val() == NaN ||  $('#statusFilter').val() == undefined)?'': $('#statusFilter').val();

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


        window.location.href = "?startDate=" + startDate + "&endDate=" + endDate + "&userrole=" + filterRole + "&userstatus=" + filterStatus;
        
        
    });


  });
</script>        

    @endsection
