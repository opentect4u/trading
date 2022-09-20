@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Close':'Create'}} Customer</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form id="ClosemyForm" name="ClosemyForm" method="POST"
                            action="{{isset($data)?route('memberCloseConfirm'):route('memberAdd')}}">
                            @csrf
                            <input type="text" name="society_id" id="society_id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->society_id):''}}">

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Customer ID</label>
                                    <input type="text" class="form-control" name="customer_id" id="customer_id" required
                                        value="{{isset($data)?$data->customer_id:''}}" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="mem_name" id="mem_name" required
                                        value="{{isset($data)?$data->mem_name:''}}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Address</label>
                                    <textarea class="form-control" name="mem_address" id="mem_address" cols="30"
                                        rows="2" readonly required>{{isset($data)?$data->mem_address:''}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Contact No</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no" required
                                        value="{{isset($data)?$data->contact_no:''}}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="mem_email" id="mem_email"
                                        value="{{isset($data)?$data->mem_email:''}}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Member Type</label>
                                    <select class="form-control" id="member_type" name="member_type" required disabled>
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
                                        value="{{isset($data)?$data->deposit_amount:''}}" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Aadhar No.</label>
                                    <input type="text" class="form-control" name="aadhar_no" id="aadhar_no"
                                        value="{{isset($data)?$data->aadhar_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">PAN No.</label>
                                    <input type="text" class="form-control" name="pan_no" id="pan_no"
                                        value="{{isset($data)?$data->pan_no:''}}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">VoterId No.</label>
                                    <input type="text" class="form-control" name="voter_id" id="voter_id"
                                        value="{{isset($data)?$data->voter_id:''}}" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" id="bank_name"
                                        value="{{isset($data)?$data->bank_name:''}}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">ACC No.</label>
                                    <input type="text" class="form-control" name="acc_no" id="acc_no"
                                        value="{{isset($data)?$data->acc_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">IFSC</label>
                                    <input type="text" class="form-control" name="ifsc" id="ifsc"
                                        value="{{isset($data)?$data->ifsc:''}}" readonly>
                                </div>



                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea class="form-control" name="remark" id="remark" cols="30" rows="2"
                                        readonly>{{isset($data)?$data->remark:''}}</textarea>
                                </div>

                            </div>
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

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="button" class="btn btn-info" id="butClose" name="butClose"
                                        value="{{isset($data)?'Close':'Create'}}">
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

    // butClose
    $('#butClose').on('click', function() {

        $.confirm({
            title: '',
            content: 'Are you sure to continue?',
            buttons: {
                cancel: function() {
                    // $.alert('Canceled!');
                },
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function() {
                        // event.preventDefault();
                        // this.closest('form').submit();
                        $("#ClosemyForm").submit();

                        // $.alert('Something else?');
                    }
                }
            }
        });

    })



});
</script>
@endsection