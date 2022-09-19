@extends('admin.common.master')
@section('content')


<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <!-- <a type="button" href="createSubcategory.html" class="btn btn-primary">Create</a> -->
                    <h2>{{auth()->guard('admin')->user()->name}} Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection