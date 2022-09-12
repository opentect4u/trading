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
                        <form action="{{route('saleReport')}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">From Date</label>
                                    <input type="text" class="form-control" name="from_date" id="from_date" required
                                        value="<?php if($from_date!=''){echo $from_date;}else{ echo date('d-m-Y');} ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">To Date</label>
                                    <input type="text" class="form-control" name="to_date" id="to_date" required
                                        value="<?php if($to_date!=''){echo $to_date;}else{ echo date('d-m-Y');} ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" value="Search">
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
                    <!-- <a type="button" href="{{route('saleAdd')}}" class="btn btn-primary">Create</a> -->
                    <h2> Sale Report</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Sale Date</th>
                                    <th>Supplier Name</th>
                                    <th>Product Name</th>
                                    <th>Sale Type</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$data->sale_date}}</td>
                                    <td>{{$data->sup_name}}</td>
                                    <td>{{$data->pdt_name}}</td>
                                    <td>
                                        @if($data->sale_type=='C')
                                        {{"Credit"}}
                                        @else
                                        {{'Cash'}}
                                        @endif
                                    </td>
                                    <td>{{$data->rate}}</td>
                                    <td>{{$data->quantity}}</td>
                                    <td>{{$data->amount}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Sale Date</th>
                                    <th>Supplier Name</th>
                                    <th>Product Name</th>
                                    <th>Sale Type</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
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
toastr.success('Product sale successfully.');
</script>
@endif
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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