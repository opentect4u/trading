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
                        <form action="{{route('saleManage')}}">
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
                    <a type="button" href="{{route('saleAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Sale</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date</th>
                                    <!-- <th>Type</th> -->
                                    <th>Member / Nominal Name</th>
                                    <th>Product Name</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>View</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr id="tr_{{$data->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$data->sale_date}}</td>
                                    <!-- <td>
                                        @if($data->sale_type =='C')
                                        Credit
                                        @else
                                        Cash
                                        @endif
                                    </td> -->
                                    <td>{{$data->sup_name}}</td>
                                    <td>{{$data->pdt_name}}</td>
                                    <td>{{$data->rate}}</td>
                                    <td>{{$data->quantity}}</td>
                                    <td>{{$data->amount}}</td>
                                    <td><a href="{{route('saleEdit',['id'=>\Crypt::encryptString($data->id)])}}"
                                            title="View"><i class="fa fa-eye" aria-hidden="true"
                                                style="font-size:18px;"></i></a></td>
                                    <td><a href="javascript:void(0);"
                                            title="Delete" onclick="butDelete({{$data->id}})"><i class="fa fa-trash-o" aria-hidden="true"
                                                style="font-size:18px;color:red;"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date</th>
                                    <!-- <th>Type</th> -->
                                    <th>Member / Nominal Name</th>
                                    <th>Product Name</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>View</th>
                                    <th>Delete</th>
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



function butDelete(customer_id) {
    // alert(customer_id)
    $.confirm({
        title: '',
        content: 'Are you sure to continue?',
        buttons: {
            cancel: function() {
                // $.alert('Canceled!');
            },
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function() {

                    $.ajax({
                        url: "{{route('transDeleteAjax')}}",
                        method: "POST",
                        data: {
                            customer_id: customer_id,
                            table_name: "td_sale",
                        },
                        success: function(data) {
                            // alert(data)
                            var obj = JSON.parse(data);
                            var id = obj.id;
                            $("#tr_" + id).remove();
                            toastr.success('Delete Successfully.');

                        }
                    });

                }
            }
        }
    });


}
</script>
@endsection