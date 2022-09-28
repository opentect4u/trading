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
                        <form action="{{route('supplierReport')}}">
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
                                    <label for="">Member/Nominal Name</label>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                        <option value="">-- Select Member/Nominal Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->customer_id}}"
                                            <?php if($customer_id!='' && $supplier->customer_id==$customer_id){echo 'selected';} ?>>
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
        @if($from_date!='' && $to_date!='' && $customer_id!='')
        <div class="card mt-2">
            <div class="card-body" id="sectionDiv">
                <div class="container text-center mb-3">
                    <h3 class="mb-2">Nuudyog Farmers Producer Company Ltd.</h3>
                    <!-- <h4 class="mb-2">Company Registered under the Companies Act, 2013</h4>
                    <h4 class="mb-2">Farmer producer Company under NABARD, Govt. of India</h4>
                    <h5 class="mb-2">Regd. No. - U01110WB2020PTC238766</h5> -->
                    <h4 class="mb-2">Office Address : Plot-2025, Henriya Attaramchak, Heria, Khejuri , Purba Medinipur,
                        West Bengal, India 721430</h4>
                    <!-- <h5 class="mb-2">Mail ID - nuudyogfpc@gmail.com</h5>
                    <h5 class="mb-2">Contact Us : 9734358832</h5> -->
                    <h5 class="mb-2">Member / Nominal Purchase & Sale Report on : {{$from_date}} - {{$to_date}}</h5>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <b>Name : {{$supplier_details[0]['mem_name']}}</b>
                        <!-- <div>Name : </div> -->
                    </div>
                    <div class="col-sm-6 mb-2">
                        <b>Contact No : {{$supplier_details[0]['contact_no']}}</b>
                        <!-- <div>Contact No: </div> -->
                    </div>
                    <div class="col-sm-12 mb-2">
                        <b>Address : {{$supplier_details[0]['mem_address'].$supplier_details[0]['mem_vill']}}</b>
                        <!-- <div>Address :</div> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Type</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <!-- sale Purchase -->
                                    <th>Total Amount</th>
                                    <th>Deposit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; $cal_amt=0;?>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <?php if(isset($data->sale_date)){echo $data->sale_date;}?>
                                        <?php if(isset($data->received_date)){echo $data->received_date;}?>
                                    </td>
                                    <td><?php if(isset($data->pdt_name)){echo $data->pdt_name;}else{echo "-";}?></td>
                                    <td>
                                        <?php if(isset($data->sale_type)){echo "Purchase";}?>
                                        <?php if(isset($data->received_type)){echo "Payment";}?>
                                    </td>
                                    <td>
                                        <?php if(isset($data->rate)){echo $data->rate;}else{echo "-";}?>
                                    </td>
                                    <td>
                                        <?php if(isset($data->quantity)){echo $data->quantity;}else{echo "-";}?>
                                    </td>
                                    <td>
                                        <?php 
                                            if (isset($data->sale_type)) {
                                                $cal_amt=$cal_amt+$data->amount;
                                                echo $data->amount;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if (isset($data->received_type)) {
                                                $cal_amt=$cal_amt-$data->amount;
                                                echo $data->amount;
                                            }
                                        ?>
                                    </td>
                                    <td>{{$cal_amt}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                            <!-- <tfoot>
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
                            </tfoot> -->
                        </table>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a type="button" href="javascript:void(0);" class="btn btn-primary"
                            onclick="printContent('sectionDiv');">Print</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
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