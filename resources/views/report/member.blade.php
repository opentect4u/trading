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
                        <form action="{{route('memberReport')}}">
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
                                    <label for="">Type</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">-- Select Type --</option>
                                        <!-- <option value="ALL" <?php if($type=='ALL'){echo "selected";}?>>All</option> -->
                                        <option value="A" <?php if($type=='A'){echo "selected";}?>>Open</option>
                                        <option value="C" <?php if($type=='C'){echo "selected";}?>>Close</option>
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
        @if($type!='')
        <div class="card mt-2">
            <div class="card-body">
                <div class="titleSec">
                    <!-- <a type="button" href="{{route('saleAdd')}}" class="btn btn-primary">Create</a> -->
                    <h2> Customers</h2>
                </div>

                <div class="row" id="sectionDiv">
                    <div class="col-sm-12">
                        <table id="" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>@if($type=='C') Close @else Open @endif Date</th>
                                    <th>Customer ID</th>
                                    <th> Name</th>
                                    <th>No of Share</th>
                                    <th>Amount</th>
                                    <!-- <th>Contact</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; $no_of_share=0;$total_amount=0?>
                                @foreach($datas as $data)
                                <?php 
                                    $no_of_share=$no_of_share+$data->mem_share;
                                    $total_amount=$total_amount+$data->deposit_amount;
                                ?>
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        @if($type=='C')
                                        {{ date('d-m-Y',strtotime($data->date_of_closing))}}
                                        @else
                                        {{date('d-m-Y',strtotime($data->mem_date))}}
                                        @endif
                                    </td>
                                    <td>{{$data->customer_id }}</td>
                                    <td>{{$data->mem_name}}</td>
                                    <td>{{$data->mem_share}}</td>
                                    <td>{{$data->deposit_amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th> {{$no_of_share}}</th>
                                    <th>{{number_format((float)$total_amount, 2, '.', '');}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a type="button" href="javascript:void(0);" class="btn btn-primary"
                            onclick="printContent('sectionDiv');">Print</a>
                    </div>
                </div>
            </div>
        </div>
        @else
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


<script>
$(function() {
    $("#from_date").datepicker({
        dateFormat: 'dd-mm-yy',
    });
    $("#to_date").datepicker({
        dateFormat: 'dd-mm-yy',
    });
});

function printContent(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
@endsection