@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'View':'Create'}} Customer</h2>
                </div>

                

                <div class="row">

                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('usersUpdate'):route('usersCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
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

                                <div class="col-sm-6">
                                    <label for="">User Type *</label>
                                    <select name="user_type" id="user_type" class="form-control" required>
                                        <option value="">-- Select User Type -- </option>
                                        <option value="S"
                                            <?php if(isset($data) && $data->user_type=='S'){echo "selected";}?>>Super
                                            Admin
                                        </option>
                                        <option value="A"
                                            <?php if(isset($data) && $data->user_type=='A'){echo "selected";}?>>Admin
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="">Password</label>
                                    <input type="text" class="form-control" name="password" id="password" value="">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Confirm Password</label>
                                    <input type="text" class="form-control" name="password_confirmation"
                                        id="password_confirmation" value="">
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
toastr.success('Customer Update Successfully.');
</script>
@endif

@if(isset($data))
<script>
var updateval = '{{isset($data)?$data->member_type:'
'}}';
if (updateval == 'M') {
    $("#deposit_amount").attr('required', 'required');
    // deposit_amount
} else {
    $("#deposit_amount").removeAttr('required');
}
</script>
@endif

<script>
$(document).ready(function() {

    // alert('hohofjhbuh')

    $("#member_type").on('change', function() {
        var val = $("#member_type").val();
        // alert(val)
        if (val == 'M') {
            $("#deposit_amount").attr('required', 'required');
            $("#deposit_amount").val(1000);
            // deposit_amount
        } else {
            $("#deposit_amount").removeAttr('required');
            $("#deposit_amount").val('');
        }
    });

    $("#mem_date").datepicker({
        dateFormat: 'dd-mm-yy',
    });

    // deposit_amount
    $("#deposit_amount").on('change', function() {
        var val = $("#deposit_amount").val();

        var number = val / 10;
        // alert(number)
        if (Number.isInteger(number)) {
            // alert(number)
        } else {
            alert('Please enter valid stock amount')
            $("#deposit_amount").val('');
            // $("#deposit_amount").val(amount);
        }

    });

    $('#deposit_amount').keyup(function(e) {
        var value = $("#deposit_amount").val();
        var rate = $("#rate").val();
        if (/\D/g.test(value)) {
            // Filter non-digits from input value.
            val1 = value.replace(/\D/g, '');
            $("#deposit_amount").val(val1);
        }
    });

});
</script>
@endsection