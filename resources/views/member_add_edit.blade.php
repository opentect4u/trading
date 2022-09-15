@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'View':'Create'}} Member</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{isset($data)?route('memberUpdate'):route('memberAdd')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                @if(isset($data))
                                <div class="col-sm-6">
                                    <label for="">Customer ID</label>
                                    <input type="text" class="form-control" name="customer_id" id="customer_id" required
                                        value="{{isset($data)?$data->customer_id:''}}">
                                </div>
                                @endif
                                <div class="col-sm-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="mem_name" id="mem_name" required
                                        value="{{isset($data)?$data->mem_name:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Address</label>
                                    <textarea class="form-control" name="mem_address" id="mem_address" cols="30"
                                        rows="2" required>{{isset($data)?$data->mem_address:''}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Contact No</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no" required
                                        value="{{isset($data)?$data->contact_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="mem_email" id="mem_email"
                                        value="{{isset($data)?$data->mem_email:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Member Type</label>
                                    <select class="form-control" id="member_type" name="member_type" required>
                                        <option value=""> -- Select Member Type --</option>
                                        <option value="M"
                                            <?php if(isset($data) && $data->member_type=='M'){echo "selected";}?>>Member
                                        </option>
                                        <option value="N"
                                            <?php if(isset($data) && $data->member_type=='N'){echo "selected";}?>>
                                            Nominal</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Deposit Amount</label>
                                    <input type="text" class="form-control" name="deposit_amount" id="deposit_amount"
                                        value="{{isset($data)?$data->deposit_amount:''}}">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Aadhar No.</label>
                                    <input type="text" class="form-control" name="aadhar_no" id="aadhar_no"
                                        value="{{isset($data)?$data->aadhar_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">PAN No.</label>
                                    <input type="text" class="form-control" name="pan_no" id="pan_no"
                                        value="{{isset($data)?$data->pan_no:''}}">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" id="bank_name"
                                        value="{{isset($data)?$data->bank_name:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">ACC No.</label>
                                    <input type="text" class="form-control" name="acc_no" id="acc_no"
                                        value="{{isset($data)?$data->acc_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">IFSC</label>
                                    <input type="text" class="form-control" name="ifsc" id="ifsc"
                                        value="{{isset($data)?$data->ifsc:''}}">
                                </div>



                                <div class="col-sm-6">
                                    <label for="">Remark</label>
                                    <textarea class="form-control" name="remark" id="remark" cols="30"
                                        rows="2">{{isset($data)?$data->remark:''}}</textarea>
                                </div>

                            </div>
                            @if(isset($data) && $data->open_close_flag=='C')
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Closing Amount</label>
                                    <input type="text" class="form-control" name="closing_amount" id="closing_amount"
                                        required value="{{isset($data)?$data->closing_amount:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Deduction Charge</label>
                                    <input type="text" class="form-control" name="deduction_charge"
                                        id="deduction_charge" value="{{isset($data)?$data->deduction_charge:''}}">
                                </div>

                                <div class="col-sm-12">
                                    <label for="">Close Remarks</label>
                                    <textarea class="form-control" name="close_remarks" id="close_remarks" cols="30"
                                        rows="2">{{isset($data)?$data->close_remarks:''}}</textarea>
                                </div>
                            </div>
                            @endif
                            @if(!isset($data))
                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" name="submit"
                                        value="{{isset($data)?'Update':'Create'}}">
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

<script>
$(document).ready(function() {

    // alert('hohofjhbuh')
    var updateval = '{{isset($data)?$data->member_type:'
    '}}';
    if (updateval == 'M') {
        $("#deposit_amount").attr('required', 'required');
        // deposit_amount
    } else {
        $("#deposit_amount").removeAttr('required');
    }

    $("#member_type").on('change', function() {
        var val = $("#member_type").val();
        if (val == 'M') {
            $("#deposit_amount").attr('required', 'required');
            // deposit_amount
        } else {
            $("#deposit_amount").removeAttr('required');
        }
    });
});
</script>
@endsection