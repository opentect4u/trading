@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>Update Sub Category</h2>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <form>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option value="" ng-reflect-value="">Select</option>
                                        <option class="ng-star-inserted">Intellectual Property Laws</option>
                                        <option class="ng-star-inserted">Corporate Laws</option>
                                        <option class="ng-star-inserted">Taxation Laws</option>
                                        <option class="ng-star-inserted">A</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="Company Law">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit" value="Update">
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection