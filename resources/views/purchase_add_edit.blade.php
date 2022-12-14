@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'View':'Create'}} Purchase</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('purchaseUpdate'):route('purchaseCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Purchase Date</label>
                                    <input type="text" class="form-control" name="purchase_date" id="purchase_date"
                                        required
                                        value="{{isset($data)?date('d-m-Y',strtotime($data->purchase_date)):date('d-m-Y')}}">
                                </div>
                                <!-- <div class="col-sm-6">
                                    <label for="">Purchase Type</label>
                                    <select name="purchase_type" id="purchase_type" class="form-control">
                                        <option value=""> -- Select Purchase Type -- </option>
                                        <option value="C"
                                            <?php if(isset($data) && $data->purchase_type=='C'){echo "selected";}?>>
                                            Credit</option>
                                        <option value="S"
                                            <?php if(isset($data) && $data->purchase_type=='S'){echo "selected";}?>>Cash
                                        </option>
                                    </select>
                                </div> -->
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
                                            {{$member->mem_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Product Category</label>
                                    <select name="product_category_id" id="product_category_id" class="form-control"
                                        required>
                                        <option value=""> -- Select Product Category -- </option>
                                        @foreach($ProductCategory as $category)
                                        <option value="{{$category->id}}"
                                            <?php if(isset($data) && $data->product_category_id==$category->id){echo "selected";}?>>
                                            {{$category->cat_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Product Name</label>
                                    <select name="product_master_id" id="product_master_id" class="form-control">
                                        <option value=""> -- Select Product Name -- </option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Rate per unit</label>
                                    <input type="text" class="form-control" name="rate" id="rate" required
                                        value="{{isset($data)?$data->rate:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Quantity</label>
                                    <input type="text" class="form-control" name="quantity" id="quantity" required
                                        value="{{isset($data)?$data->quantity:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Discount (%)</label>
                                    <input type="text" class="form-control" name="discount" id="discount"
                                        value="{{isset($data)?$data->discount:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount" required
                                        value="{{isset($data)?$data->amount:''}}">
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea name="remark" id="remark" class="form-control" cols="30"
                                        rows="3">{{isset($data)?$data->remark:''}}</textarea>


                                </div>
                            </div>

                            @if(!isset($data))
                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Purchase'}}">
                                </div>
                            </div>
                            @endif
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
toastr.success('Purchase deatils update successfully.');
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

    $('#discount').keyup(function(e) {
        var value = $("#rate").val();
        var value11 = $("#discount").val();
        if (/\D/g.test(value11)) {
            // Filter non-digits from input value.
            val2 = value11.replace(/\D/g, '');
            $("#discount").val(val2);
        } else {
            var value1 = $("#quantity").val();
            var amount = Number(value) * Number(value1);

            var value3 = $("#discount").val();
            var discount_amt= (Number(value3) * Number(amount) )/100;
            var final_mat=amount - discount_amt;
            // alert(final_mat);
            $("#amount").val('');
            $("#amount").val(final_mat);
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