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
                        <form action="{{route('stockReport')}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">From Date</label>
                                    <input type="text" class="form-control" name="from_date" id="from_date" required
                                        value="<?php if($from_date!=''){echo $from_date;}else{ echo date('d-m-Y');} ?>">
                                </div>
                                <!-- <input type="text" name="from_date" id="from_date" value="{{$finalcial_start_date}}" hidden>  -->
                                <div class="col-sm-6">
                                    <label for="">Date</label>
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
        <!-- @if($from_date!='' && $to_date!='') -->
        <div class="card mt-2">
            <div class="card-body">
                <div class="titleSec">


                    <h2> Stock Report</h2>
                </div>

                <div class="row" id="sectionDiv">
                    <div class="col-sm-12">
                        <table id="" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Product Category</th>
                                    <th>Product Name</th>
                                    <th>Opening</th>
                                    <th>Purchase during the period</th>
                                    <th>Sale during the period</th>
                                    <th>Closing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$data->cat_name}}</td>
                                    <td>{{$data->pdt_name}}</td>
                                    <td>{{$data->opening_stock}}</td>
                                    <td>{{$data->during_period_purchase}}</td>
                                    <td>{{$data->during_period_sale}}</td>
                                    <td>{{$data->stock_in_hand}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Product Category</th>
                                    <th>Product Name</th>
                                    <th>Opening Stock</th>
                                    <th>Purchase Stock</th>
                                    <th>Sale Stock</th>
                                    <th> Stock in Hand</th>
                                </tr>
                            </tfoot> -->
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
        <!-- @endif -->
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