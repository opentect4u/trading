@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'View':'Create'}} Account Head</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('accheadUpdate'):route('accheadCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Category </label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value=""> -- Select Category -- </option>
                                        <option value="L"
                                            <?php if(isset($data) && $data->category=='L'){echo "selected";}?>>
                                            Liability</option>
                                        <option value="A"
                                            <?php if(isset($data) && $data->category=='A'){echo "selected";}?>>Assets
                                        </option>
                                        <option value="R"
                                            <?php if(isset($data) && $data->category=='R'){echo "selected";}?>>Revenue
                                        </option>
                                        <option value="E"
                                            <?php if(isset($data) && $data->category=='E'){echo "selected";}?>>Expense
                                        </option>
                                        <option value="S"
                                            <?php if(isset($data) && $data->category=='S'){echo "selected";}?>>Sale
                                        </option>
                                        <option value="P"
                                            <?php if(isset($data) && $data->category=='P'){echo "selected";}?>>Purchase
                                        </option>
                                    </select>
                                </div>
                                <!-- <div class="col-sm-6">
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
                                </div> -->

                                <div class="col-sm-6">
                                    <label for="">Account Head</label>
                                    <input type="text" class="form-control" name="acc_head" id="acc_head" required
                                        value="{{isset($data)?$data->acc_head:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Cash/Bank </label>
                                    <select name="cash_bank_flag" id="cash_bank_flag" class="form-control" required>
                                        <option value=""> -- Select Cash/Bank -- </option>
                                        <option value="C"
                                            <?php if(isset($data) && $data->cash_bank_flag=='C'){echo "selected";}?>>
                                            Cash</option>
                                        <option value="B"
                                            <?php if(isset($data) && $data->cash_bank_flag=='B'){echo "selected";}?>>Bank
                                        </option>
                                        <option value="O"
                                            <?php if(isset($data) && $data->cash_bank_flag=='O'){echo "selected";}?>>Other
                                        </option>
                                    </select>
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

    $("#purchase_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });



    $('#memDIV').hide() ;
    $('input[type=radio][name=member_type]').change(function() {
        // alert(this.value);
        // var url = ("{{route('memberManage')}}") + "?member_type=" + this.value;
        // window.location.assign(url);

        if (this.value =='S') {
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
        }
    });

});
</script>
@endsection