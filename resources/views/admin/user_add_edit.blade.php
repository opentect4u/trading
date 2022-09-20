@extends('admin.common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Update':'Create'}} User</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST"
                            action="{{isset($data)?route('admin.userUpdate'):route('admin.userCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Society *</label>
                                    <select name="society_id" id="society_id" class="form-control" required <?php 
                                            if(isset($data)){echo "disabled";}
                                        ?>>
                                        <option value="">-- Select Society --</option>
                                        @foreach($societies as $society)
                                        <option value="{{$society->id}}" <?php 
                                                if(isset($data) && $data->society_id==$society->id){echo "selected";} 
                                                // if(isset($data)){echo "disabled";}
                                            ?>>
                                            {{$society->soc_name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Name *</label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        value="{{isset($data)?$data->name:''}}">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Email *</label>
                                    <input type="email" class="form-control" name="email" id="email" required
                                        value="{{isset($data)?$data->email:''}}"
                                        <?php if(isset($data)){echo "readonly";}?>>
                                </div>

                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" value=""
                                        required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" value="" required>
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

@if(Session::has('email_error'))
<script>
toastr.error('Email already exists');
</script>
@endif

@if(Session::has('password_error'))
<script>
toastr.error('Password and confrim password does not match!');
</script>
@endif

@if(Session::has('update'))
<script>
toastr.success('User details updated successfully.');
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