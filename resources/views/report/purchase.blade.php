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
                        <form action="{{route('purchaseReport')}}">
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
                                    <label for="">Supplier Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">-- Select Supplier Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}"
                                            <?php if($supplier_id!='' && $supplier->id==$supplier_id){echo 'selected';} ?>>
                                            {{$supplier->sup_name. " - ".$supplier->contact_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Product Name</label>
                                    <select name="product_master_id" id="product_master_id" class="form-control">
                                        <option value="">-- Select Product Name -- </option>
                                        @foreach($product_master as $productmaster)
                                        <option value="{{$productmaster->id}}"
                                            <?php if($product_master_id!='' && $productmaster->id==$product_master_id){echo 'selected';} ?>>
                                            {{$productmaster->pdt_name}}</option>
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
                    <h2> Purchase Report</h2>
                </div>

                <div class="row" id="sectionDiv">
                    <div class="col-sm-12">
                        <table id="" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Purchase Date</th>
                                    <th>Supplier Name</th>
                                    <th>Product Name</th>
                                    <th>Purchase Type</th>
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
                                    <td>{{$data->purchase_date}}</td>
                                    <td>{{$data->sup_name}}</td>
                                    <td>{{$data->pdt_name}}</td>
                                    <td>
                                        @if($data->purchase_type=='C')
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
                                    <th>Purchase Date</th>
                                    <th>Supplier Name</th>
                                    <th>Product Name</th>
                                    <th>Purchase Type</th>
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