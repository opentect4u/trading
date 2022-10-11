@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Update':'Create'}} Transaction</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('balanceUpdate'):route('balanceCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Date</label>
                                    <input type="text" class="form-control" name="payment_date" id="payment_date"
                                        required value="{{isset($data)?$data->payment_date:date('d-m-Y')}}">
                                </div>
                                <div class="col-sm-6">
                                    <div class="btn-group">
                                        <label class="btn btn-default">
                                            <input type="radio" id="member_type_1" name="member_type" value="S"
                                                checked />
                                            Supplier
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" id="member_type_2" name="member_type" value="M" />
                                            Member / Nominal
                                        </label>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Transaction Type</label>
                                    <select name="trans_type" id="trans_type" class="form-control" required>
                                        <option value=""> -- Select Transaction Type -- </option>
                                        <option value="P">Payment</option>
                                        <option value="R">Received</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Payment Type</label>
                                    <select name="payment_type" id="payment_type" class="form-control" required>
                                        <option value=""> -- Select Payment Type -- </option>
                                        <option value="C">Cash</option>
                                        <option value="B">Bank</option>
                                    </select>
                                </div>
                                
                                <div class="col-sm-6" id="supDIV">
                                    <label for="">Supplier Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                                        <option value=""> -- Select Supplier Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}"
                                            <?php if(isset($data) && $data->supplier_id==$supplier->id){echo "selected";}?>>
                                            {{$supplier->sup_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6" id="memDIV">
                                    <label for="">Member / Nominal Name</label>
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value=""> -- Select Member / Nominal Name -- </option>
                                        @foreach($members as $member)
                                        <option value="{{$member->customer_id}}"
                                            <?php if(isset($data) && $data->customer_id==$member->customer_id){echo "selected";}?>>
                                            {{$member->mem_name." - ".$member->contact_no}}</option>
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
                                    <textarea name="remarks" id="remarks" class="form-control" cols="30"
                                        rows="3">{{isset($data)?$data->remarks:''}}</textarea>


                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Payment'}}">
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

    $("#payment_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });


    var radioval=$('input[type=radio][name=member_type]').val();
    // alert(radioval);
    if (radioval=='S') {
        $('#trans_type').val('P');
        $('#trans_type').attr('disabled','disabled');
    }

    $('#memDIV').hide() ;
    $('input[type=radio][name=member_type]').change(function() {
        // alert(this.value);
        // var url = ("{{route('memberManage')}}") + "?member_type=" + this.value;
        // window.location.assign(url);

        if (this.value =='S') {
            if (radioval=='S') {
                $('#trans_type').val('P');
                $('#trans_type').attr('disabled','disabled');
            }
            $('#customer_id').val('');
            $('#supplier_id').val('');
            $('#customer_id').removeAttr('required') ;
            $('#supplier_id').attr('required','required') ;
            $('#memDIV').hide();
            $('#supDIV').show();
        }else if(this.value =='M'){
            $('#customer_id').val('');
            $('#supplier_id').val('');
            $('#supplier_id').removeAttr('required') ;
            $('#customer_id').attr('required','required') ;
            $('#supDIV').hide();
            $('#memDIV').show();

            $('#trans_type').val('R');
            $('#trans_type').removeAttr('disabled');
        }
    });
});
</script>
@endsection