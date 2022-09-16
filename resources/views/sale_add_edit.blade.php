@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Update':'Create'}} Sale</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('saleUpdate'):route('saleCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Sale Date</label>
                                    <input type="text" class="form-control" name="sale_date" id="sale_date" required
                                        value="{{isset($data)?$data->sale_date:date('d-m-Y')}}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Sale Type</label>
                                    <select name="sale_type" id="sale_type" class="form-control" required>
                                        <option value=""> -- Select Sale Type -- </option>
                                        <option value="C">Credit</option>
                                        <option value="S">Cash</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Member Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                                        <option value=""> -- Select Member Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->customer_id}}">{{$supplier->mem_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Product Category</label>
                                    <select name="product_category_id" id="product_category_id" class="form-control"
                                        required>
                                        <option value=""> -- Select Product Category -- </option>
                                        @foreach($ProductCategory as $category)
                                        <option value="{{$category->id}}">{{$category->cat_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Product Name</label>
                                    <select name="product_master_id" id="product_master_id" class="form-control"
                                        required>
                                        <option value=""> -- Select Product Name -- </option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Rate</label>
                                    <input type="text" class="form-control" name="rate" id="rate" required
                                        value="{{isset($data)?$data->rate:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Quantity </label> <b id="totalStockTag"></b>
                                    <input type="text" id="total_stock" name="total_stock" value="0" hidden>
                                    <input type="text" class="form-control" name="quantity" id="quantity" required
                                        value="{{isset($data)?$data->quantity:''}}">
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

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Sale'}}">
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
toastr.success('Product sale successfully.');
</script>
@endif

@if(Session::has('error'))
<script>
toastr.error('Product sale Failed.');
</script>
@endif

<script>
$(document).ready(function() {
    // product_category_id
    $("#product_category_id").on('change', function() {
        var product_category_id = $("#product_category_id").val();
        $.ajax({
            url: "{{route('productNameAjax')}}",
            method: "POST",
            data: {
                product_category_id: product_category_id,
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
        $.ajax({
            url: "{{route('productStockAjax')}}",
            method: "POST",
            data: {
                product_master_id: product_master_id,
            },
            success: function(data) {
                // alert(data)
                var obj = JSON.parse(data);
                var stock = obj.stock;

                $("#total_stock").val('');
                $("#total_stock").val(stock);
                $("#totalStockTag").empty();
                $("#totalStockTag").append(stock);
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
            var total_stock = $('#total_stock').val();
            if (total_stock < value) {
                alert('You sale maximum ' + total_stock);
                $("#quantity").val(0);
                // return false;
            }
            var value1 = $("#quantity").val();
            var amount = Number(rate) * Number(value1);
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

    $("#sale_date").datepicker({
        dateFormat: 'dd-mm-yy',
    });
});
</script>
@endsection