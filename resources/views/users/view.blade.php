@extends('layout/header')
    
    @section('content')
    <?php   
    //exit;
 
    $userRolePermission = Session::get("role_module_permission");

    $rolePermission = array();
    if(array_key_exists(3,$userRolePermission)){
        $rolePermission = $userRolePermission[3];
    }

    ?>
  
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3> <a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>View User</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
        <?php if(isset($userRolePermission[2]['edit_permission']) && $userRolePermission[2]['edit_permission'] == 1) {?>
            <a class="btn btn-warning " href="{{route('user.edit', ['id' => $users['id']])}}">Edit User</a>
            <?php } ?>
        </div>                    
    </div>
    <div class="row mt-3">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body"> 
                    <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">First Name<span class="text-danger"> *</span></label>
                                <input class="form-control" readonly  name="name" type="text"   value="{{$users['name']}}" autocomplete="off">
                            </div> 
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Last Name<span class="text-danger"> *</span></label>
                                <input class="form-control"  readonly name="lname" type="text"   value="{{$users['lname']}}" autocomplete="off">
                            </div>
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Email ID<span class="text-danger"> *</span></label>
                                <input class="form-control" readonly  name="email" type="text"  value="{{$users['email']}}" autocomplete="off">
                            </div>                          
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">Phone Number<span class="text-danger"> *</span></label>
                                <input class="form-control" readonly name="phone" type="text"   value="{{$users['phone']}}" autocomplete="off">
                            </div> 
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">User Type<span class="text-danger"> *</span></label>
                                <input class="form-control" readonly name="roleType" type="text"  value="<?php if($users['user_type'] == 1){ echo 'Admin';}else{echo 'Staff';} ?>" autocomplete="off">
                            </div>  
                    
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Role<span class="text-danger"> *</span></label>
                                <input class="form-control" readonly  name="role" type="text"  value="{{$users['userRoleDetail']['role_title']}}" autocomplete="off">
                            </div>  
                    </div>
                </div>
            </div>
            <!-- end of col-->
        </div>
    @endsection