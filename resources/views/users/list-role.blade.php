@extends('layout/header')
@section('content')
<?php
 $role_module_permission = Session::get("role_module_permission");
 if(array_key_exists(1,$role_module_permission)){
    $userRolePermission = $role_module_permission[1];
 }
 $rolePermission = array();
 if(array_key_exists(3,$role_module_permission)){
    $rolePermission = $role_module_permission[3];
 }
 //print_r( $role_module_permission)
 ?>
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
            <h3> <a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Roles</b></h3>
            </div>
            <div class="custome-btn d-flex justify-content-between">
                <?php if(isset($rolePermission['add_permission']) && $rolePermission['add_permission'] ==1){?>
                <a class="btn btn-warning " href="{{ route('user.create-role') }}">Add Role <i class="fas fa-plus-square"></i></a>
                <?php } ?>
            </div>
              
    </div> 
    <div class="d-flex justify-content-between pt-3">
        <div class=""></div>
        <div class="custome-btn d-flex justify-content-between">                
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" id="search" placeholder="Search......" name="search" value="{{ request()->search}}">
                    <button type="button" style="border:none;" id="search_roles" class="ul-widget-app__find-font btn-warning">Search</button>
                </div>
                
            </div>
        </div>  
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card text-left">
                    <div id="listRoles"></div>
            </div>
            <!-- end of col-->
        </div>
        </div>
        <!-- <div class="row mt-3">
            <div class="col-md-12">
                <input type = "submit" name="submit" value="Submit" > <input type="button" name="cancel" value = "Cancel" />
            </div>
        </div>
        </form> -->
        


        <script type="text/javascript">




            $('#CheckAll').change(function() {
                if ($(this).is(":checked")) {
                    $('.checkboxes').prop("checked", true);
                } else {
                    $('.checkboxes').prop("checked", false);
                }
            });
      
 
  ajaxListRole('');
  function ajaxListRole(val){ 
    var searchKey = val;  
   
    $.ajax({
            type: "GET", 
          
            url: '{{url('user/ajax-list-role')}}', 
            data: {'searchKey': searchKey},          
            success: function(data){  
                console.log(data);                      
                $("#listRoles").html(data);
                

                $(function() {
                    $('.toggle-class').change(function() {
                        var status = $(this).prop('checked') == true ? '1' : '0'; 
                        var role_id = $(this).data('id'); 
                        
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: '{{url('role/status')}}',
                            data: {'status': status, 'role_id': role_id},
                            success: function(data){               
                            swal({
                                text: data.success,
                                timer: 2000,
                                type: "success",
                                confirmButtonColor: "#f1b82d",

                            });
                            ajaxListRole(searchKey);
                            }
                        });
                    })
                });
            }
        });
  }
  $("#search_roles").on("click", function(d){
    var sVal = $("#search").val();
    //if(sVal !=''){
        ajaxListRole(sVal);
    //}
  });
  $("#search").keypress(function(e)
    {
        // if the key pressed is the enter key
        if (e.which == 13)
        {
            var sVal = $("#search").val();
            ajaxListRole(sVal);
        }
    });

                    $(document).ready(function() {
                        $(document).on('click', '#pagination_links a', function(e) {
                            e.preventDefault();
                           // alert($(this).attr('href'));
                            var url = $(this).attr('href');
                           // fetch_data(url);
                           ajaxListRoleR(url);
                        });
                    });
                    function ajaxListRoleR(url){
                        searchKey ='';
                        $.ajax({
                        type: "GET", 
                    
                        url: url, 
                        data: {'searchKey': searchKey},          
                        success: function(data){                     
                            $("#listRoles").html(data);
                        }
                    });
                }

                


               
        </script>
    @endsection
 