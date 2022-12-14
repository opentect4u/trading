@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Update':'Create'}} Receive</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('receiveUpdate'):route('receiveCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Receive Date</label>
                                    <input type="text" class="form-control" name="received_date" id="received_date"
                                        required value="{{isset($data)?$data->received_date:date('d-m-Y')}}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Receive Type</label>
                                    <select name="received_type" id="received_type" class="form-control" required>
                                        <option value=""> -- Select Receive Type -- </option>
                                        <option value="C">Cash</option>
                                        <option value="B">Bank</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Customer Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                                        <option value=""> -- Select Customer Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->customer_id}}">{{$supplier->mem_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount" required
                                        value="{{isset($data)?$data->amount:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Bank</label>
                                    <input type="text" class="form-control" name="bank" id="bank"
                                        value="{{isset($data)?$data->bank:''}}">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Cheque No.</label>
                                    <input type="text" class="form-control" name="cheque_no" id="cheque_no"
                                        value="{{isset($data)?$data->cheque_no:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Cheque Date</label>
                                    <input type="text" class="form-control" name="cheque_date" id="cheque_date"
                                        value="{{isset($data)?$data->cheque_date:''}}">
                                </div>

                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea name="remark" id="remark" class="form-control" cols="30"
                                        rows="3">{{isset($data)?$data->remark:''}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Receive'}}">
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


@section('script')

@if(Session::has('update'))
<script>
toastr.success('Supplier update successfully.');
</script>
@endif

<script>
$(document).ready(function() {
    $("#product_master_id").on('change', function() {
        var product_master_id = $("#product_master_id").val();
        $.ajax({
            url: "{{route('productRateAjax')}}",
            method: "POST",
            data: {
                product_master_id: product_master_id,
            },
            success: function(data) {
                // alert(data)
                var obj = JSON.parse(data);
                var rate = obj.rate;
                $("#rate").val('');
                $("#rate").val(rate);
                // $("#tr_" + id).remove();
                // toastr.success('Member Delete Successfully.');

            }
        });
    });

    $('#quantity').keyup(function(e) {
        var value = $("#quantity").val();
        var rate = $("#rate").val();
        if (/\D/g.test(value)) {
            // Filter non-digits from input value.
            val1 = value.replace(/\D/g, '');
            $("#quantity").val(val1);
        } else {
            // alert('hii')

            var amount = Number(rate) * Number(value);
            $("#amount").val('');
            $("#amount").val(amount);

        }
    });

    $('#rate').keyup(function(e) {
        var value = $("#rate").val();
        if (/\D/g.test(value)) {
            // Filter non-digits from input value.
            val2 = value.replace(/\D/g, '');
            $("#rate").val(val2);
        }
    });

    $('#amount').keyup(function(e) {
        var value = $("#amount").val();
        if (/\D/g.test(value)) {
            // Filter non-digits from input value.
            val2 = value.replace(/\D/g, '');
            $("#amount").val(val2);
        }
    });

    $("#received_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
});
</script>
@endsection