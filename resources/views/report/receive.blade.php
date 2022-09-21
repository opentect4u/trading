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
                        <form action="{{route('receiveReport')}}">
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
                                <div class="col-sm-6">
                                    <label for="">Customer Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">-- Select Customer Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->customer_id}}"
                                            <?php if($supplier_id!='' && $supplier->customer_id==$supplier_id){echo 'selected';} ?>>
                                            {{$supplier->mem_name. " - ".$supplier->contact_no}}</option>
                                        @endforeach
                                    </select>
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
                    <a type="button" href="javascript:void(0);" class="btn btn-primary"
                        onclick="printContent('sectionDiv');">Print</a>
                    <!-- <a type="button" href="{{route('saleAdd')}}" class="btn btn-primary">Create</a> -->
                    <h2> Receive Report</h2>
                </div>

                <div class="row" id="sectionDiv">
                    <div class="col-sm-12">
                        <table id="" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Received Date</th>
                                    <th>Customer Name</th>
                                    <th>Received Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; $total_amount=0;?>
                                @foreach($datas as $data)
                                <?php $total_amount=$total_amount + $data->amount; ?>
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$data->received_date}}</td>
                                    <td>{{$data->sup_name}}</td>
                                    <td>
                                        @if($data->received_type=='C')
                                        {{"Cash"}}
                                        @else
                                        {{'Bank'}}
                                        @endif
                                    </td>
                                    <td>{{$data->amount}}</td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total : </td>
                                    <td>{{$total_amount}}</td>
                                </tr>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Received Date</th>
                                    <th>Supplier Name</th>
                                    <th>Received Type</th>
                                    <th>Amount</th>
                                </tr>
                            </tfoot> -->
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
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
    $("#to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
});
</script>
<script>
function printContent(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
@endsection