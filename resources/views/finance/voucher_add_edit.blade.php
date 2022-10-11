@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'View':'Create'}} Voucher</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('voucherUpdate'):route('voucherCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Date</label>
                                    <input type="text" class="form-control" name="voucher_date" id="voucher_date"
                                        required value="{{isset($data)?$data->voucher_date:date('d-m-Y')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Voucher mode </label>
                                    <select name="voucher_mode" id="voucher_mode" class="form-control" required>
                                        <option value=""> -- Select Voucher Mode -- </option>
                                        <option value="C"
                                            <?php if(isset($data) && $data->voucher_mode=='C'){echo "selected";}?>>
                                            Cash</option>
                                        <option value="B"
                                            <?php if(isset($data) && $data->voucher_mode=='B'){echo "selected";}?>>Bank
                                        </option>
                                        <option value="J"
                                            <?php if(isset($data) && $data->voucher_mode=='J'){echo "selected";}?>>Journal
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Account Head</label>
                                    <select name="acc_head_id" id="acc_head_id" class="form-control" required>
                                        <option value=""> -- Select Account Head -- </option>
                                        @foreach($acc_heads as $acc_head)
                                        <option value="{{$acc_head->id}}">{{$acc_head->acc_head}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Debit / Credit </label>
                                    <select name="dr_cr_flag" id="dr_cr_flag" class="form-control" required>
                                        <option value=""> -- Select Debit / Credit -- </option>
                                        <option value="C"
                                            <?php if(isset($data) && $data->dr_cr_flag=='C'){echo "selected";}?>>
                                            Credit</option>
                                        <option value="D"
                                            <?php if(isset($data) && $data->dr_cr_flag=='D'){echo "selected";}?>>Debit
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount" required
                                        value="{{isset($data)?$data->amount:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Ins no</label>
                                    <input type="text" class="form-control" name="ins_no" id="ins_no"
                                        value="{{isset($data)?$data->ins_no:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Ins date</label>
                                    <input type="text" class="form-control" name="ins_date" id="ins_date"
                                        value="{{isset($data)?$data->ins_date:''}}">
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="3">{{isset($data)?$data->remarks:''}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Add'}}">
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
toastr.success('Account head update successfully.');
</script>
@endif
@if(isset($data))
<script>
var product_category_id = '<?php echo $data->product_category_id;?>';
var product_master_id = '<?php echo $data->product_master_id;?>';
$.ajax({
    url: "{{route('productNameAjax')}}",
    method: "POST",
    data: {
        product_category_id: product_category_id,
        product_master_id: product_master_id,
    },
    success: function(data) {
        // alert(data)
        $("#product_master_id").empty();
        $("#product_master_id").html(data);

        // var obj = JSON.parse(data);
        // var rate = obj.rate;
        // $("#rate").val('');
        // $("#rate").val(rate);
        // $("#tr_" + id).remove();
        // toastr.success('Member Delete Successfully.');

    }
});
</script>
@endif
<script>
$(document).ready(function() {

    $("#product_category_id").on('change', function() {
        var product_category_id = $("#product_category_id").val();
        $.ajax({
            url: "{{route('productNameAjax')}}",
            method: "POST",
            data: {
                product_category_id: product_category_id,
                product_master_id: '',
            },
            success: function(data) {
                // alert(data)
                $("#product_master_id").empty();
                $("#product_master_id").html(data);

                // var obj = JSON.parse(data);
                // var rate = obj.rate;
                // $("#rate").val('');
                // $("#rate").val(rate);
                // $("#tr_" + id).remove();
                // toastr.success('Member Delete Successfully.');

            }
        });
    });

    // $("#product_master_id").on('change', function() {
    //     var product_master_id = $("#product_master_id").val();
    //     $.ajax({
    //         url: "{{route('productRateAjax')}}",
    //         method: "POST",
    //         data: {
    //             product_master_id: product_master_id,
    //         },
    //         success: function(data) {
    //             // alert(data)
    //             var obj = JSON.parse(data);
    //             var rate = obj.rate;
    //             $("#rate").val('');
    //             $("#rate").val(rate);
    //             $("#amount").val('');
    //             $("#quantity").val('');
    //             // $("#tr_" + id).remove();
    //             // toastr.success('Member Delete Successfully.');

    //         }
    //     });
    // });

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
        } else {
            var value1 = $("#quantity").val();
            var amount = Number(value) * Number(value1);
            $("#amount").val('');
            $("#amount").val(amount);
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

    $("#voucher_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });

    $("#ins_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
    


    $('#memDIV').hide();
    $('input[type=radio][name=member_type]').change(function() {
        // alert(this.value);
        // var url = ("{{route('memberManage')}}") + "?member_type=" + this.value;
        // window.location.assign(url);

        if (this.value == 'S') {
            $('#customer_id').val('');
            $('#supplier_id').val('');
            $('#customer_id').removeAttr('required');
            $('#supplier_id').attr('required', 'required');
            $('#memDIV').hide();
            $('#supDIV').show();
        } else if (this.value == 'M') {
            $('#customer_id').val('');
            $('#supplier_id').val('');
            $('#supplier_id').removeAttr('required');
            $('#customer_id').attr('required', 'required');
            $('#supDIV').hide();
            $('#memDIV').show();
        }
    });

});
</script>
@endsection