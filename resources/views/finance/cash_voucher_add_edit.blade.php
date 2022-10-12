@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'View':'Create'}} Cash Voucher</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST"
                            action="{{isset($data)?route('cashvoucherUpdate'):route('cashvoucherCreate')}}">
                            @csrf
                            <input type="text" name="voucher_id" id="voucher_id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data[0]['voucher_id']):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Date</label>
                                    <input type="text" class="form-control" name="voucher_date" id="voucher_date"
                                        required value="{{isset($data)?$data[0]['voucher_date']:date('d-m-Y')}}"
                                        <?php if(isset($data)){echo "readonly";}?>>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Voucher mode : CASH</label>

                                </div>
                                <div class="col-sm-6">
                                    <label for="">Voucher Type </label>
                                    <select name="voucher_type" id="voucher_type" class="form-control" required
                                        <?php if(isset($data)){echo "disabled";}?>>
                                        <option value=""> -- Select -- </option>
                                        <option value="R"
                                            <?php if(isset($data) && $data[0]['voucher_type']=='R'){echo "selected";}?>>
                                            Cash Received</option>
                                        <option value="P"
                                            <?php if(isset($data) && $data[0]['voucher_type']=='P'){echo "selected";}?>>
                                            Cash Payment
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Account Head</label>
                                    <select name="acc_head_id" id="acc_head_id" class="form-control" disabled>
                                        <option value=""> -- Select Account Head -- </option>
                                        @foreach($acc_heads as $acc_head)
                                        <option value="{{$acc_head->id}}"
                                            <?php if(isset($data) && $data[0]['acc_head_id']==$acc_head->id){echo "selected";}?>>
                                            {{$acc_head->acc_head}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Debit / Credit </label>
                                    <select name="dr_cr_flag" id="dr_cr_flag" class="form-control" disabled>
                                        <option value=""> -- Select Debit / Credit -- </option>
                                        <option value="C"
                                            <?php if(isset($data) && $data[0]['dr_cr_flag']=='C'){echo "selected";}?>>
                                            Credit</option>
                                        <option value="D"
                                            <?php if(isset($data) && $data[0]['dr_cr_flag']=='D'){echo "selected";}?>>
                                            Debit
                                        </option>
                                    </select>
                                </div>
                                @if(isset($data))
                                <input type="text" name="dr_cr_flag_1" id="dr_cr_flag_1" value="{{$data[0]['dr_cr_flag']}}" hidden>
                                <input type="text" name="acc_head_id" id="acc_head_id" value="{{$data[0]['acc_head_id']}}" hidden>
                                @endif
                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control" cols="30"
                                        rows="3">{{isset($data)?$data[0]['remarks']:''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <table id="table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Account Head</th>
                                            <th>Account Code</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            <th></th>
                                            @if(!isset($data))
                                            <th><button type="button" class="btn btn-success" id="dynamic_add"><i
                                                        class="fa fa-plus"></i></button></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($data))
                                        @foreach($data as $key =>$datas)
                                        @if($key!= 0)
                                        <input type="text" id="edit_dr_cr_flag_{{$key}}" name="edit_dr_cr_flag[]"
                                            value="{{$datas->dr_cr_flag}}" hidden>
                                        <tr id="row_{{$key}}">
                                            <td>
                                                <select class="form-control" id="cash_acc_head_id_{{$key}}"
                                                    name="cash_acc_head_id[]" required disabled>
                                                    <option value="">Select Sector</option>
                                                    @foreach($acc_heads as $acc_head)
                                                    <option value="{{$acc_head->id}}"
                                                        <?php if($datas->acc_head_id==$acc_head->id){echo "selected";}?>>
                                                        {{$acc_head->acc_head}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="acc_code[]"
                                                    id="acc_code_{{$key}}" value="{{$datas->acc_head_id}}" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="category[]"
                                                    id="category_{{$key}}" value="<?php 
                                                    $category=DB::table('md_acc_head')->where('id',$datas->acc_head_id)->value('category');
                                                    if($category =='L'){
                                                        echo 'Liability';
                                                    }else if($category =='A'){
                                                        echo 'Assets';
                                                    }elseif($category =='R'){
                                                        echo 'Revenue';
                                                    }elseif($category =='E'){
                                                        echo 'Expense';
                                                    }elseif($category =='S'){
                                                        echo 'Sale';
                                                    }elseif($category =='P'){
                                                        echo 'Purchase';
                                                    }
                                                    ?>" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="amount[]"
                                                    id="amount_{{$key}}" value="{{$datas->amount}}" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control drCrValue" name="dr_cr[]"
                                                    id="dr_cr_{{$key}}" value="<?php 
                                                    if($datas->dr_cr_flag=='D'){
                                                        echo "Debit";
                                                    }else{
                                                        echo "Credit";
                                                    }
                                                    ?>" readonly />
                                            </td>
                                            <!-- <td><button type="button" id="remove_{{$key}}" class="btn btn-danger"
                                                    onclick="_delete(1)"><i class="fa fa-remove"></i></button></td> -->
                                        </tr>
                                        <script>
                                            var kayy='<?php echo $key;?>';
                                        $('#amount_'+kayy).keyup('change', function() {
                                            var value = $('#amount_'+kayy).val();
                                            if (/\D/g.test(value)) {
                                                // Filter non-digits from input value.
                                                val1 = value.replace(/\D/g, '');
                                                $("#amount_1").val(val1);
                                            } else {
                                                var x = $('#table tbody > tr').length;
                                                // alert(x)
                                                var totamount = 0
                                                for (let index = 1; index <= x; index++) {
                                                    // alert(index)
                                                    var amount = $('#amount_' + index).val();
                                                    if (amount != '') {
                                                        totamount = Number(totamount) + Number(amount);
                                                    }
                                                }
                                                // totalAmt
                                                $('#totalAmt').empty();
                                                $('#totalAmt').append(totamount);
                                            }
                                        });
                                        </script>
                                        @endif
                                        @endforeach
                                        @else
                                        <tr id="row_1">
                                            <td>
                                                <select class="form-control" id="cash_acc_head_id_1"
                                                    name="cash_acc_head_id[]" required>
                                                    <option value="">Select Sector</option>
                                                    @foreach($acc_heads as $acc_head)
                                                    <option value="{{$acc_head->id}}">{{$acc_head->acc_head}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="acc_code[]"
                                                    id="acc_code_1" value="" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="category[]"
                                                    id="category_1" value="" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="amount[]" id="amount_1"
                                                    value="" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control drCrValue" name="dr_cr[]"
                                                    id="dr_cr_1" value="" readonly />
                                            </td>
                                            <td><button type="button" id="remove_1" class="btn btn-danger"
                                                    onclick="_delete(1)"><i class="fa fa-remove"></i></button></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-right">Total :</th>
                                            <th colspan="3" class="text-left" id="totalAmt">
                                                {{isset($data)?$data[0]['amount']:''}}</th>
                                        </tr>
                                    </tfoot>
                                </table>

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
toastr.success('Cash voucher update successfully.');
</script>
@endif

<script>
$(document).ready(function() {
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

    $('#voucher_type').on('change', function() {
        var val = $('#voucher_type').val();
        if (val == 'R') {
            var val1 = 'D';
            var val2 = 'Credit';
            $('#dr_cr_flag').val(val1);
            $('.drCrValue').val(val2);

        } else if (val == 'P') {
            var val1 = 'C';
            var val2 = 'Debit';
            $('#dr_cr_flag').val(val1);
            $('.drCrValue').val(val2);
        } else {
            $('#dr_cr_flag').val('');
            $('.drCrValue').val('');
        }
    });

    $('#cash_acc_head_id_1').on('change', function() {
        var id = $('#cash_acc_head_id_1').val();
        var x = 1;
        AccHeadDetails(id, x);
    });

    $('#amount_1').keyup('change', function() {
        var value = $('#amount_1').val();
        if (/\D/g.test(value)) {
            // Filter non-digits from input value.
            val1 = value.replace(/\D/g, '');
            $("#amount_1").val(val1);
        } else {
            var x = $('#table tbody > tr').length;
            // alert(x)
            var totamount = 0
            for (let index = 1; index <= x; index++) {
                // alert(index)
                var amount = $('#amount_' + index).val();
                if (amount != '') {
                    totamount = Number(totamount) + Number(amount);
                }
            }
            // totalAmt
            $('#totalAmt').empty();
            $('#totalAmt').append(totamount);
        }
    });

});
</script>

<script>
var count = 20;
var x = $('#table tbody > tr').length;
$('#dynamic_add').click(function() {
    // var total = parseInt($('#tot_memb').val());
    if (x < count) {
        if ($('#cash_acc_head_id_' + x).val() != '' && $('#amount_' + x).val() != '') {
            x++;
            $('#table').append('<tr id="row_' + x + '">' +
                '<td><select class="form-control" id="cash_acc_head_id_' + x +
                '" name="cash_acc_head_id[]" required><option value="">Select Sector</option>' +
                '<?php
                if ($acc_heads) {
                    foreach ($acc_heads as $acc_head) {
                        echo '<option value="' . $acc_head->id . '">' . $acc_head->acc_head . '</option>';
                    }
                }
                ?>' +
                '</select></td>' +
                '<td><input type="text" class="form-control" name="acc_code[]" id="acc_code_' + x +
                '" value="" readonly/></td>' +
                '<td><input type="text" class="form-control" name="category[]" id="category_' + x +
                '" value="" readonly/></td>' +
                '<td><input type="text" class="form-control" name="amount[]" id="amount_' + x +
                '" value="" /></td>' +
                '<td><input type="text" class="form-control drCrValue" name="dr_cr[]" id="dr_cr_' + x +
                '" value="" readonly/></td>' +
                '<td><button type="button" id="remove_' + x + '" class="btn btn-danger" onclick="_delete(' +
                x +
                ')"><i class="fa fa-remove"></i></button></td>' +
                '</tr>');
            // var y = x-1;

            // $('#tot_shg').val(y);
            // $('#tot_memb').val(total);

            var dr_cr_1 = $('#dr_cr_1').val();
            if (dr_cr_1 != '') {
                $('#dr_cr_' + x).val(dr_cr_1);
            }
            $('#cash_acc_head_id_' + x).on('change', function() {
                var id = $('#cash_acc_head_id_' + x).val();
                AccHeadDetails(id, x);
            });
            $('#amount_' + x).keyup('change', function() {
                var value = $('#amount_' + x).val();
                if (/\D/g.test(value)) {
                    // Filter non-digits from input value.
                    val1 = value.replace(/\D/g, '');
                    $("#amount_" + x).val(val1);
                } else {
                    AmtCalculation();
                }
            });
        } else {
            alert('Please Fill All Details');
            return false;
        }
    }
});

function _delete(id) {
    var r = confirm("Do you want to delete this?");
    if (r == true) {
        $('#row_' + id).remove();
        x--;
        AmtCalculation();
    } else {
        return false;
    }
}

function AccHeadDetails(id, tableid) {
    // alert(tableid)

    $.ajax({
        url: "{{route('AccHeadDetailsAjax')}}",
        method: "POST",
        data: {
            id: id,
        },
        success: function(data) {
            // alert(data)
            var obj = JSON.parse(data);
            var acc_code = obj.acc_code;
            var catepory = obj.catepory;
            $("#acc_code_" + tableid).val(acc_code);
            $("#category_" + tableid).val(catepory);
        }
    });
}

function AmtCalculation() {
    var xx = $('#table tbody > tr').length;
    // alert(x)
    var totamount = 0
    for (let index = 1; index <= xx; index++) {
        // alert(index)
        var amount = $('#amount_' + index).val();
        if (amount != '') {
            totamount = Number(totamount) + Number(amount);
        }
    }
    // totalAmt
    $('#totalAmt').empty();
    $('#totalAmt').append(totamount);
}
</script>
@endsection