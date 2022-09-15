@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body ">
                <div class="titleSec">
                    <h2> Search</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{route('receiveManage')}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">From Date</label>
                                    <input type="text" class="form-control" name="from_date" id="from_date"
                                        required value="<?php if($from_date!=''){echo $from_date;}else{ echo date('d-m-Y');} ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">To Date</label>
                                    <input type="text" class="form-control" name="to_date" id="to_date"
                                        required value="<?php if($to_date!=''){echo $to_date;}else{ echo date('d-m-Y');} ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit"
                                        value="Search">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('receiveAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Receive Payemnt</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Supplier Name</th>
                                    <th>Amount</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{date('d-m-Y',strtotime($data->received_date))}}</td>
                                    <td>
                                        @if($data->received_type =='C')
                                        Cash
                                        @else
                                        Bank
                                        @endif
                                    </td>
                                    <td>{{$data->sup_name}}</td>
                                    <td>{{$data->amount}}</td>
                                    <!-- <td><a href="{{route('purchaseEdit',['id'=>\Crypt::encryptString($data->id)])}}" title="Edit"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a></td> -->
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Supplier Name</th>
                                    <th>Amount</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@if(Session::has('addSuccess'))
<script>
toastr.success('Payment received successfully.');
</script>
@endif
<script>
$(function() {
    $("#from_date").datepicker({
        dateFormat: 'dd-mm-yy',
    });
    $("#to_date").datepicker({
        dateFormat: 'dd-mm-yy',
    });
});
</script>
@endsection