@extends('layout/header')
@section('content')
<div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Edit Role</b></h3>
        </div>
        <div>

        </div>            
    </div>
    <form name ="frm_create_role" id = "frm_create_role" method="POST" action="{{ route('user.save-editrole') }}">
    @csrf
   
    <div class="row mt-3">
        <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
            <label>Role Title </label> 
            <input type="text" name = 'role_title' id='role_title' class="form-control"  value ="{{$role_title}}" />
            <input type="hidden" name = 'role_id' id='role_id' class="form-control"  value ="{{$role_id}}" />
            </div>
            <div>
                <input type="checkbox" name = "checkAll" id="CheckAll" value ='all' <?php if($rolesData[0]->checked_all == 1){ echo "checked";}?> /> Has All Permissions
            </div>
        </div>
        </div>
    </div>
    <div class="row mt-3">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
                        <p><b>Admin Modules List</b></p>
                    <table class="table ">
                            <thead>
                            <tr>
                                <th>MODULE NAME</th>
                                <th>VIEW</th>
                                <th>ADD</th>
                                <th>EDIT</th>
                                <th>DISABLE - DELETE</th>                                 
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($moduleList as $moduleData)
                                <tr>
                                    <td>{{$moduleData->module_name}}
                                        <input type="hidden" name="module_id[]" id="module_id" value ="{{$moduleData->id}}"/>
                                    </td>
                                    <td><input type="checkbox" name="view_permission[{{$moduleData->id}}]" class='checkboxes' value='1_{{$moduleData->id}}' <?php if(in_array($moduleData->id,$viewModulePer)){ echo "checked";}?> /> </td>
                                    <td><input type="checkbox" name="add_permission[{{$moduleData->id}}]" class='checkboxes' value='1_{{$moduleData->id}}' <?php if(in_array($moduleData->id,$addModulePer)){ echo "checked";}?> /></td>
                                    <td><input type="checkbox" name="edit_permission[{{$moduleData->id}}]" class='checkboxes' value='1_{{$moduleData->id}}' <?php if(in_array($moduleData->id,$editModulePer)){ echo "checked";}?> /></td>
                                    <td><input type="checkbox" name="disable_permission[{{$moduleData->id}}]" class='checkboxes' value='1_{{$moduleData->id}}' <?php if(in_array($moduleData->id,$disableModulePer)){ echo "checked";}?> /></td>
                                   
                                </tr>
                            @endforeach
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
                        
                        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <input type = "submit" name="submit" value="Submit" class="btn btn-warning mr-4" > 
                <input type="button" name="cancel" onClick="javascript:history.back()" class="btn btn-cancel" value = "Cancel" />
            </div>
        </div>
                    </div>
                </div>
            </div>
            <!-- end of col-->
        </div>
        
        </form>
        <script type="text/javascript">
      /*  $('#CheckAll').change(function() {
  if ($(this).is(":checked")) {
    $('.checkboxes').prop("checked", true);
  } else {
    $('.checkboxes').prop("checked", false);
  }
});*/

$('#CheckAll').on('change', function(e) {
    var $inputs = $('.checkboxes');
    if(e.originalEvent === undefined) {
        var allChecked = true;
        $inputs.each(function(){
            allChecked = allChecked && this.checked;
        });
        this.checked = allChecked;
    } else {
        $inputs.prop('checked', this.checked);
    }
});

$('.checkboxes').on('change', function(){

    $('#CheckAll').trigger('change');
});
</script>
    @endsection
 