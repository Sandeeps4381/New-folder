@extends('layout/header')
@section('content')
<style type="text/css">
    div#loading-image {
        display : none;
    }
    div#loading-image.show {
        display : block;
        position : fixed;
        z-index: 100;
        background-image : url('/dist-assets/images/loadingLogo.gif');
        background-color:#666;
        opacity : 0.4;
        background-repeat : no-repeat;
        background-position : center;
        left : 0;
        bottom : 0;
        right : 0;
        top : 0;
    }
    div.top-product-div img {
        object-fit: contain;
        max-height: 82px;
        max-width: 82px;
        min-height: 82px;
        min-width: 82px;
        border: 1px dotted #333;
    }
    .card-footer .orderTypes {
        display: flex;
        justify-content: space-around;
    }
    .card-footer .orderTypes p {
        margin: 0px;
    }
    .card-footer .orderTypes span {
        font-weight: 700;
    }
    .card-footer .orderTypes .cardOrder,
    .card-footer .orderTypes .cardOrder {
        display: inherit;
    }
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        /* background-color: #2196F3; */
        padding: 5px;
    }
    .grid-item {
        background-color: white;
        border-right: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        padding: 10px;
        font-size: 1rem;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center; /
    }
    .grid-item1 {
        background-color: WHITE;
        border-bottom: 1px solid #ccc;
        padding: 10px;
        font-size: 1rem;
        text-align: center;
    }
    .gap-10 {
    margin-right: 10px; /* Apply a 10px gap between elements */
    }
    .shadowed-div {
        box-shadow: 3px 1px 10px 0px #ccc; /* Adjust the shadow values as desired */
        padding: 4px; /* Add some padding to create space for the shadow effect */
    }
    .content{
        float: left;
        text-align: initial;
        font-size: 1rem;
    }
    .content p{font-size: 13px;}
    .shadowed-div h2{
        font-size: 2rem;
    }
    /**Added styles */
    .filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .filter-section form {
        display: flex;
        gap: 10px;
    }
    .filter-section form select,
    .filter-section form input {
        padding: 5px;
    }

    .container {
        display:flex;
        height: 100%;
        width: 100%;
        /* padding: 10px 0; */
        /* border-radius: 1px; */
        /* background: #fff; */
        row-gap: 30px;
        gap: 50px;
        flex-direction: row;
        align-items: center;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .circular-progress1, .circular-progress2, .circular-progress3 {
        position: relative;
        height: 200px;
        width: 200px;
        /* border-style: solid; */
        border-radius: 50%;
        /* background-color: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg); */
        justify-content: center;

        display: flex;
        flex-direction: column; /* Stacks children vertically */
        align-items: center;    /* Centers children horizontally */
        text-align: center;     /* Centers text horizontally */
    }

    .circular-progress1::before,  .circular-progress2::before,  .circular-progress3::before {
        content: "";
        position: absolute;
        height: 150px;
        width: 150px;
        border-radius: 50%;
        background-color: #fff;
    }

    .progress-value1, .progress-value2, .progress-value3 {
        position: relative;
        font-size: 2rem;
        font-weight: 400;
    }

    .text {
        position: relative;
        font-size: 1rem;
        font-weight: 300;
        color: #606060;
    }

</style>

@php
    $userRolePermission = Session::get("role_module_permission");
@endphp

<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <div class="bd-text">
                <h2> <b>Dashboard</b></h2>
                </div>
                <div class="custome-btn d-flex justify-content-between align-items-center">
                    @if(isset($userRolePermission[4]['add_permission']) && $userRolePermission[4]['add_permission'] == 1)
                    <a class="btn btn-warning mr-2" href="{{ route('project.create') }}">Create Project <i class="fa fa-plus-square"></i></a>
                    @endif
                    @if(isset($userRolePermission[5]['add_permission']) && $userRolePermission[5]['add_permission'] == 1)
                        <a class="btn btn-warning" href="{{route('assessment.list')}}">Create Assessment <i class="fas fa-plus-square"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="column-3 pt-3">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row center-row">
                            <div class="col-8">
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"> Total User</p>
                                    <h2 id="Customers" style="font-weight: 900;">{{ $users->count()}}</h2>
                                </div>
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('dist-assets/images/Total_Users_icon.png') }}" alt="Total Users" style="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row center-row">
                            <div class="col-8">
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"> Total Projects</p>
                                    <h2 id="Customers" style="font-weight: 900;">{{ $projects->count()}}</h2>
                                </div>
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('dist-assets/images/Total_Projects_icon.png') }}" alt="Total Projects" style="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                    <div class="row center-row">
                            <div class="col-8">
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"> Total Assessments</p>
                                    <h2 id="Customers" style="font-weight: 900;">{{ $assessments->count()}}</h2>
                                </div>
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('dist-assets/images/Total_Assessments_icon.png') }}" alt="Total Assessments" style="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row center-row">
                            <div class="col-8">
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"> Pending Reviews</p>
                                    <h2 id="Customers" style="font-weight: 900;">0.00</h2>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <img src="{{ asset('dist-assets/images/Pending_icon.png') }}" alt="Pending Reviews" style="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white text-dark my-4 rounded">

                <div class="card-body">
                    <h2><b>Recent Projects</b></h2>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Manager</th>
                                <th>Assessment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($managers as $project)

                                <tr>
                                    <td>{{ $project['title'] }} </td>
                                    <td>{{ $project['type'] }}</td>
                                    <td>  {{date('m/d/Y',strtotime($project['date']))}}</td>
                                    <td>{{ $project['manager_name']}}</td>
                                    <td>{{ $project['total_assessments'] }} </td>
                                    <td>
                                        <a class="view-btn" href="{{ route('project.view', ['id'=>$project['identity']]) }}">
                                            <img src="{{ asset('dist-assets/images/eye.png') }}" alt="Total Projects" style="">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="shadowed-div">
        <div class="bg-white text-dark p-3 rounded">
            <div class="mb-4 d-flex justify-content-between align-item-center">

                <h3><b>Assessment</b></h3>
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="d-flex justify-content-between align-item-center">
                        <div class="input-group mr-2" style="max-width: 185px;">
                            <input type="text" class="form-control" id="start_date_assess" name="start_date" value="" readonly="" placeholder="Start Date" value="{{ request('start_date') }}">

                            <span class="form-control" style="max-width: 40px;" id="start-calendar-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>

                        </div>
                        <div class="input-group  mr-2" style="max-width: 185px;">
                                 <input type="text" class="form-control" id="end_date_assess" name="end_date" value="" readonly="" placeholder="End Date" value="{{ request('end_date') }}">

                                    <span class="form-control" style="max-width: 40px;" id="end-calendar-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>

                        </div>
                    <select class="select2 form-control" style="max-width: 175px;" id="assessment_name" name="assessment_name">
                        @foreach ($assessments as $id => $name)
                            <option value="{{ $name }}" {{ request('assessment_name') == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-warning ml-2">Filter</button>
                    </div>
                </form>
            </div>

            @if(!empty($rolesData))

                <script>
                    window.count = @json($rolesData->count());
                </script>

                <div class = "container">

                    <div class="circular-progress1">
                        <span class="progress-value1">{{ $rolesData->count() }}</span>
                        <span class="text">Total Invited</span>
                    </div>

                    <div class="circular-progress2">
                        <span class="progress-value2">0</span>
                        <span class="text">Total Completed</span>
                    </div>

                    <div class="circular-progress3">
                        <span class="progress-value3">{{ $rolesData->count() - 0}}</span>
                        <span class="text">Total Pending</span>
                    </div>

                </div>

                <script src="{{ asset('assets/js/script1.js') }}"></script>
                <script src="{{ asset('assets/js/script2.js') }}"></script>
                <script src="{{ asset('assets/js/script3.js') }}"></script>

            @endif;

        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">

    // Get today's date
    var endDate = new Date();

    // Calculate the date 30 days ago
    var startDate = new Date();
    startDate.setDate(startDate.getDate() - 30);

    // Format the dates as yyyy-mm-dd
    var formatDate = function(date) {
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return year + '-' + month + '-' + day;
    };

    // Autofill the date fields
    $('#start_date_assess').val(formatDate(startDate));
    $('#end_date_assess').val(formatDate(endDate));

    // Initialize the DatePicker for the Start Date
    $('#start_date_assess').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        showButtonPanel: true,
        orientation: "bottom",
        startDate: startDate,
        endDate: endDate
    });

    // Initialize the DatePicker for the End Date
    $('#end_date_assess').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        showButtonPanel: true,
        orientation: "bottom",
        startDate: startDate,
        endDate: endDate
    });

    // Show DatePicker when clicking the calendar icon for Start Date
    $('#start-calendar-icon').click(function(){
        $('#start_date_assess').datepicker('show');
    });

    // Show DatePicker when clicking the calendar icon for End Date
    $('#end-calendar-icon').click(function(){
        $('#end_date_assess').datepicker('show');
    });
</script>
@endsection
