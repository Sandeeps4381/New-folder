@extends('layout/header')
    
    @section('content')

    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
          <h3><b> <a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> Question Bank</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <a class="btn btn-warning " href="{{ route('user.create') }}">Create Assessment <i class="fas fa-plus-square"></i></a>
        </div>               
    </div>


    @endsection
