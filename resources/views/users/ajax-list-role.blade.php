<?php
    $role_module_permission = Session::get("role_module_permission");
    if(array_key_exists(1,$role_module_permission)){
        $userRolePermission = $role_module_permission[1];
    }
    $rolePermission = array();
    if(array_key_exists(3,$role_module_permission)){
        $rolePermission = $role_module_permission[3];
    }
 ?>
 <style>
    .previous, .next{
        cursor: auto !important;
        background-color: #fff !important;
        border-color: #dee2e6 !important;
        font-size: 12px !important;
        margin: 0px !important;
    }
    .paginate_button {
        padding: 0.5rem 0.75rem !important;
        margin-left: -1px !important;
        line-height: 15px !important;
        color: #000 !important;
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 0px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button:active{
        color: black !important;
        text-decoration: none !important;
        background-color: #eee !important;
        border-color: #dee2e6 !important;
        background: #eee !important;
        box-shadow: none !important;
        border-radius: 0;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:active,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current{
        background: #f1b82d !important;
        color: #fff !important;
    }
</style>
<div class="card-body">
    <table class="table" id="roledatTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>FULL ACCESS</th>
                <th>STATUS</th>
                <th>ACTION</th>                                
            </tr>
        </thead>
        <tbody>
            @if(!empty($role_data_arr))
                @foreach($role_data_arr as $key=>$roleData)                           
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$roleData['role_title']}}</td>
                        <td>
                            @if($roleData['checked_all'] == 1)
                            Yes
                            @else
                            No
                            @endif
                        </td>
                        <td>
                            @if($roleData['status'] == 1)
                            Active
                            @else
                            Inactive
                            @endif
                        </td>
                        <td>
                            @if (isset($rolePermission['view_permission']) && $rolePermission['view_permission'] == 1)
                            <a class="text-primary mr-2" href="view/role/{{$key}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip65478"><img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>
                            @endif
                            
                            @if (isset($roleData['role_type']) && $roleData['role_type'] != 1)
                                @if (isset($rolePermission['edit_permission']) && $rolePermission['edit_permission'] == 1)
                                <a class="text-success mr-2" href="edit-role/{{$key}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><img src="{{url('dist-assets/images/edit.png')}}" alt="filter"></a>
                                @endif
                                
                                @if (isset($rolePermission['disable']) && $rolePermission['disable'] == 1)
                                    <a class="text-danger confirmation dtRowDelete pointer" style="cursor: pointer !important;"> 
                                        <label class="switch switch-danger">
                                            <input  data-id="{{$key}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="1" data-off="0"  <?php if($roleData['status'] == 1) echo 'checked';?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No Records are found</td>
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
                        <div id="pagination_links">
                        
                        </div>
                    </div>
                </div>
                <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
     
<script type="text/javascript">
    $('#roledatTable').DataTable({
     
        paging: true,
        ordering: false,
        searching: false,  
        bInfo: false,
        info: false,
        bFilter: false,
        lengthChange: false,
        pageLength: 7,
        "language": {
                    "paginate": {
                        "previous": '<i class="fas fa-angle-left"></i>',
                        "next": '<i class="fas fa-angle-right"></i>',
                        "first": '<i class="fas fa-angle-double-left"></i>',
                        "last": '<i class="fas fa-angle-double-right"></i>'
                    }
                }
    
       
    });   
</script>                



