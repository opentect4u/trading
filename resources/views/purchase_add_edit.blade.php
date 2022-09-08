@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Update':'Create'}} Supplier</h2>
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
                                        required value="{{isset($data)?$data->purchase_date:date('d-m-Y')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Purchase Type</label>
                                    <select name="purchase_type" id="purchase_type" class="form-control">
                                        <option value=""> -- Select Purchase Type -- </option>
                                        <option value="C">Credit</option>
                                        <option value="S">Cash</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Supplier Name</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value=""> -- Select Supplier Name -- </option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->sup_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Product Name</label>
                                    <select name="product_master_id" id="product_master_id" class="form-control">
                                        <option value=""> -- Select Product Name -- </option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->pdt_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Rate</label>
                                    <input type="text" class="form-control" name="rate" id="rate" required
                                        value="{{isset($data)?$data->rate:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Quantity</label>
                                    <input type="text" class="form-control" name="quantity" id="quantity" required
                                        value="{{isset($data)?$data->quantity:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount" required
                                        value="{{isset($data)?$data->amount:''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Create'}}">
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
            
            var amount= Number(rate) * Number(value) ;
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
});
</script>
@endsection