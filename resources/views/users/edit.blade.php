@extends('layout/header')
    
    @section('content')

    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
           <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Edit User</b></h3>
        </div>             
    </div>

    <div class="row mt-3">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
                    
       
              <form action="{{ route('user.update', ['id' => $users->id]) }}" method="post">
            
                @csrf
                    <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">First Name<span class="text-danger"> *</span></label>
                                <input class="form-control"  name="name" type="text"   value="{{$users->name}}" autocomplete="off">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Last Name<span class="text-danger"> *</span></label>
                                <input class="form-control"  name="lname" type="text"   value="{{$users->lname}}" autocomplete="off">
                                <span class="text-danger">
                                    @error('lname')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                            
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Email ID<span class="text-danger"> *</span></label>
                                <input class="form-control"  name="email" type="text"  value="{{$users->email}}" autocomplete="off">
                                <span class="text-danger">
                                    @error('email')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>  
                    </div>


                    <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">Phone Number<span class="text-danger"> *</span></label>
                                <input class="form-control" name="phone" type="text"   value="{{$users->phone}}" autocomplete="off">
                                <span class="text-danger">
                                    @error('phone')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                            
                            <!-- <div class="col-md-4 form-group ">
                                <label >Gender<span class="text-danger"> *</span></label>
                                <select name="gender" class="js-example-responsive form-control select2 ">
                                    <option value="Male" < ?php if($users->gender == 'Male'){ echo "selected"; }?>>Male</option>
                                    <option value="Female" < ?php if($users->gender == 'Female'){ echo "selected"; }?>>Female</option>
                                    <option value="Other" < ?php if($users->gender == 'Other'){ echo "selected"; }?>>Other</option>
                                 </select>
                            </div>  -->
                            <div class="col-md-4 form-group ">
                                <label>User Type<span class="text-danger"> *</span></label>
                                <select name="userType" id="roleType" class="js-example-responsive form-control select2 " data-placeholder="Select User Type">
                                    <option></option>   
                                    <option value="0" <?php if($users->user_type == '0'){ echo "selected"; }?>> Staff</option>    
                                    <option value="1" <?php if($users->user_type == '1'){ echo "selected"; }?>>Admin</option> 
                                 </select>
                                 <span class="text-danger">
                                    @error('userType')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>  
                            
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Role<span class="text-danger"> *</span></label>
                               
                                 <select name="role_id" id="roleData" class="js-example-responsive form-control select2 " data-placeholder="Select Role">
                                
                                  @if(!empty($rolesData))
                                  @foreach($rolesData as $role)
                                    <option value="{{$role->id}}" <?php if($users->role_id == $role->id){ echo "selected"; }?>>{{$role->role_title}}</option>
                                  @endforeach;
                                  @endif;
                                 </select>
                            </div>  
                    </div>


                    <!-- <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">Password<span class="text-danger"> *</span></label>
                                <input class="form-control" id="employee-firstName" name="firstName" type="text"   value="{{$users->password}}" autocomplete="off">
                            </div> 
                    </div> -->


                    <div class="row">
                        <div class="col-md-12 form-group text-center mt-4">
                            <button type="submit" class="btn btn-warning"> Save Changes</button>
                        </div>        
                    </div>


                   </form>
                   </div>
                </div>
            </div>
            <!-- end of col-->
        </div>


        <script type="text/javascript">


$(document).ready(function() {
    $('#roleType option').not(':selected').prop('disabled', true);
    $('#roleType').on('change', function() {
        let selectedText = $(this).find('option:selected').text();

        if (selectedText === 'Admin') {
            selectedText = 'Super Admin';
            $('#roleData option').each(function() {
                let optionText = $(this).text().trim();
                if (optionText === selectedText) {
                    $('#roleData').val(20).trigger('change');
                    $('#roleData option').not(':selected').prop('disabled', true);
                    return false;  
                }
            });      
        } else {
           // $('#roleData').val("").trigger('change');
            $('#roleData option').prop('disabled', false);
            $('#roleData option[value="20"]').not(':selected').prop('disabled', true);
        }

    });

    $('#roleType').trigger('change');
});


</script>

    @endsection