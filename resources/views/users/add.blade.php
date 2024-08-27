@extends('layout/header')
    
    @section('content')

    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
           <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Add New User</b></h3>
        </div>             
    </div>

    <div class="row mt-3">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
              <form action="{{ route('user.save')}}" method="post">
                @csrf
               
                    <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">First Name<span class="text-danger"> *</span></label>
                                <input class="form-control"  name="name" type="text"   value="{{ old('name') }}" autocomplete="off">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Last Name<span class="text-danger"> *</span></label>
                                <input class="form-control"  name="lname" type="text"   value="{{ old('lname') }}" autocomplete="off">
                                <span class="text-danger">
                                    @error('lname')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                            
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Email ID<span class="text-danger"> *</span></label>
                                <input class="form-control"  name="email" type="text"  value="{{ old('email') }}" autocomplete="off">
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
                                <input class="form-control" name="phone" type="text"   value="{{ old('phone') }}" autocomplete="off">
                                <span class="text-danger">
                                    @error('phone')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                            
                            <div class="col-md-4 form-group ">
                                <label>User Type<span class="text-danger"> *</span></label>
                                <select name="userType" class="js-example-responsive form-control select2 " id="roleType" data-placeholder="Select User Type">
                                    <option></option>   
                                    <option value="0">Staff</option>    
                                    <option value="1">Admin</option> 
                                 </select>
                                 <span class="text-danger">
                                    @error('userType')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>  
                            
                            
                            <div class="col-md-4 form-group ">
                                <label for="firstName">Role<span class="text-danger"> *</span></label>
                                 <select name="role" class="js-example-responsive form-control select2" id="roleData" data-placeholder="Select Role">
                                 <option></option>
                                  @if(!empty($rolesData))
                                  @foreach($rolesData as $role)
                                  <option value="{{$role->id}}">{{$role->role_title}}</option>
                                  @endforeach;
                                  @endif;
                                 </select>
                                 <span class="text-danger">
                                    @error('role')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>  
                    </div>


                    <div class="row">
                        <div class="col-md-4 form-group ">
                                <label for="firstName">Create New Password<span class="text-danger"> *</span></label>
                                <input class="form-control" name="password" type="text"   value="{{ old('password') }}" autocomplete="off">
                                <span class="text-danger">
                                    @error('password')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                   
                        <div class="col-md-4 form-group ">
                                <label for="firstName">Confirm Password<span class="text-danger"> *</span></label>
                                <input class="form-control" name="confrim" type="text"   value="{{ old('confrim') }}" autocomplete="off">
                                <span class="text-danger">
                                    @error('confrim')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div> 
                    </div> 


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
            $('#roleData').val("").trigger('change');
            $('#roleData option').prop('disabled', false);
            $('#roleData option[value="20"]').not(':selected').prop('disabled', true);
        }




    });
});


</script>

    @endsection