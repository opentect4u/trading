@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Close':'Create'}} Member</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form id="ClosemyForm" name="ClosemyForm" method="POST"
                            action="{{isset($data)?route('memberCloseConfirm'):route('memberAdd')}}">
                            @csrf
                            <input type="text" name="society_id" id="society_id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->society_id):''}}">

                                <div class="form-group row">
                                @if(isset($data))
                                <div class="col-sm-6">
                                    <label for="">Member ID</label>
                                    <input type="text" class="form-control" name="customer_id" id="customer_id" required
                                        value="{{isset($data)?$data->customer_id:''}}" readonly>
                                </div>
                                <!-- <div class="col-sm-6">
                                    <label for="">Member Type *</label>
                                    <select class="form-control" id="member_type" name="member_type" required
                                        <?php if(isset($data)){echo "disabled";}?>>
                                        <option value=""> -- Select Member Type --</option>
                                        <option value="M"
                                            <?php if(isset($data) && $data->member_type=='M'){echo "selected";}?>>Member
                                        </option>
                                        <option value="N"
                                            <?php if(isset($data) && $data->member_type=='N'){echo "selected";}?>>
                                            Nominal</option>
                                    </select>
                                </div> -->
                                @endif
                                <div class="col-sm-6">
                                    <label for="">Name *</label>
                                    <input type="text" class="form-control" name="mem_name" id="mem_name" required
                                        value="{{isset($data)?$data->mem_name:''}}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Date *</label>
                                    <input type="text" class="form-control" name="mem_date" id="mem_date" required
                                        value="{{isset($data)?$data->mem_date:date('d-m-Y')}}"
                                        <?php if(isset($data)){echo "disabled";}?>>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Gender *</label>
                                    <select name="mem_gender" id="mem_gender" class="form-control" required disabled>
                                        <option value="">-- Select Gender -- </option>
                                        <option value="M"
                                            <?php if(isset($data) && $data->mem_gender=='M'){echo "selected";}?>>Male
                                        </option>
                                        <option value="F"
                                            <?php if(isset($data) && $data->mem_gender=='F'){echo "selected";}?>>Female
                                        </option>
                                        <option value="O"
                                            <?php if(isset($data) && $data->mem_gender=='O'){echo "selected";}?>>Other
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Category *</label>
                                    <select name="mem_cast" id="mem_cast" class="form-control" required disabled>
                                        <option value="">-- Select Category -- </option>
                                        <option value="General"
                                            <?php if(isset($data) && $data->mem_cast=='General'){echo "selected";}?>>
                                            General</option>
                                        <option value="OBC"
                                            <?php if(isset($data) && $data->mem_cast=='OBC'){echo "selected";}?>>OBC
                                        </option>
                                        <option value="SC"
                                            <?php if(isset($data) && $data->mem_cast=='SC'){echo "selected";}?>>SC
                                        </option>
                                        <option value="ST"
                                            <?php if(isset($data) && $data->mem_cast=='ST'){echo "selected";}?>>ST
                                        </option>
                                        <option value="Minority"
                                            <?php if(isset($data) && $data->mem_cast=='Minority'){echo "selected";}?>>
                                            Minority</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Educational Qualification</label>
                                    <!-- <input type="text" class="form-control" name="mem_qualification"
                                        id="mem_qualification" value="{{isset($data)?$data->mem_qualification:''}}"> -->
                                    <select name="mem_qualification" id="mem_qualification" class="form-control"
                                        required disabled>
                                        <option value="">-- Select Qualification -- </option>
                                        <option value="Matric / High School"
                                            <?php if(isset($data) && $data->mem_qualification=='Matric / High School'){echo "selected";}?>>
                                            Matric / High School</option>
                                        <option value="Intermediate / Higher Secondary / 12th Standard"
                                            <?php if(isset($data) && $data->mem_qualification=='Intermediate / Higher Secondary / 12th Standard'){echo "selected";}?>>
                                            Intermediate / Higher Secondary / 12th Standard </option>
                                        <option value="Diploma"
                                            <?php if(isset($data) && $data->mem_qualification=='Diploma'){echo "selected";}?>>
                                            Diploma</option>
                                        <option value="Bachelor's degree"
                                            <?php if(isset($data) && $data->mem_qualification=="Bachelor's degree"){echo "selected";}?>>
                                            Bachelor's degree </option>
                                        <option value="Master's degree"
                                            <?php if(isset($data) && $data->mem_qualification=="Master's degree"){echo "selected";}?>>
                                            Master's degree </option>
                                        <option value="Others"
                                            <?php if(isset($data) && $data->mem_qualification=='Others'){echo "selected";}?>>
                                            Others </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="">Contact No *</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no" required
                                        value="{{isset($data)?$data->contact_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                        <?php if(isset($data)){echo "readonly";}?>>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="mem_email" id="mem_email"
                                        value="{{isset($data)?$data->mem_email:''}}" readonly>
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Address *</label>
                                    <textarea class="form-control" name="mem_address" id="mem_address" cols="30"
                                        rows="2" readonly>{{isset($data)?$data->mem_address:''}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">District *</label>
                                    <select name="district_id" id="district_id" class="form-control" required disabled>
                                        <option value="">-- Select District -- </option>
                                        @foreach($districts as $district)
                                        <option value="{{$district->sl_no}}"
                                            <?php if(isset($data) && $data->district_id==$district->sl_no){echo "selected";}?>>
                                            {{$district->dist_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Block *</label>
                                    <select name="mem_block" id="mem_block" class="form-control" required disabled>
                                        <option value="">-- Select Block -- </option>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Village *</label>
                                    <!-- <input type="text" class="form-control" name="mem_vill" id="mem_vill" required
                                        value="{{isset($data)?$data->mem_vill:''}}"> -->

                                    <select name="mem_vill" id="mem_vill" class="form-control" required disabled>
                                        <option value="">-- Select Village -- </option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">

                                @if(!isset($data))
                                <input type="text" id="member_type" name="member_type" value="M" hidden>
                                <!-- <div class="col-sm-6">
                                    <label for="">Member Type *</label>
                                    <select class="form-control" id="member_type" name="member_type" required
                                        <?php if(isset($data)){echo "disabled";}?>>
                                        <option value=""> -- Select Member Type --</option>
                                        <option value="M"
                                            <?php if(isset($data) && $data->member_type=='M'){echo "selected";}?>>Member
                                        </option>
                                        <option value="N"
                                            <?php if(isset($data) && $data->member_type=='N'){echo "selected";}?>>
                                            Nominal</option>
                                    </select>
                                </div> -->
                                @endif
                                <div class="col-sm-6">
                                    <label for="">Deposit Amount</label>
                                    <?php  $amount=DB::table('md_param')->where('sl_no',3)->value('param_value');?>
                                    <input type="text" class="form-control" name="deposit_amount" id="deposit_amount"
                                        value="{{isset($data)?$data->deposit_amount:$amount}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">

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
                                    <label for="">Ration Card.</label>
                                    <input type="text" class="form-control" name="ration_card" id="ration_card"
                                        value="{{isset($data)?$data->ration_card:''}}" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="">NREGA Card</label>
                                    <input type="text" class="form-control" name="nrega_card" id="nrega_card"
                                        value="{{isset($data)?$data->nrega_card:''}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Classification of Farmer</label>
                                    <select name="classification_of_mem" id="classification_of_mem"
                                        class="form-control" disabled>
                                        <option value="">-- Select Classification of Farmer -- </option>
                                        <option value="T"
                                            <?php if(isset($data) && $data->classification_of_mem=='T'){echo "selected";}?>>
                                            Tenant</option>
                                        <option value="S"
                                            <?php if(isset($data) && $data->classification_of_mem=='S'){echo "selected";}?>>
                                            SMALL FARMER</option>
                                        <option value="M"
                                            <?php if(isset($data) && $data->classification_of_mem=='M'){echo "selected";}?>>
                                            MARGINAL</option>
                                        <option value="O"
                                            <?php if(isset($data) && $data->classification_of_mem=='O'){echo "selected";}?>>
                                            Others</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Total Landholding (Acres)</label>
                                    <input type="text" class="form-control" name="landholding" id="landholding"
                                        value="{{isset($data)?$data->landholding:''}}" readonly>
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
                                    <textarea class="form-control" name="remark" id="remark" cols="30"
                                        rows="2" readonly>{{isset($data)?$data->remark:''}}</textarea>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Closing Amount</label>
                                    <input type="text" class="form-control" name="closing_amount" id="closing_amount"
                                        required value="{{isset($data)?$data->deposit_amount:''}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Deduction Charge</label>
                                    <?php  $de_amount=DB::table('md_param')->where('sl_no',5)->value('param_value');?>
                                    <input type="text" class="form-control" name="deduction_charge"
                                        id="deduction_charge" value="{{isset($data)?$de_amount:0}}">
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

    
    $("#district_id").on('change', function() {
        var district_id = $("#district_id").val();
        var block_id = '';
        BlockNameAJax(district_id, block_id);
    });

    
    $("#mem_block").on('change', function() {
        var district_id = $("#district_id").val();
        var block_id = $("#mem_block").val();
        var vill_id = '';
        VillageNameAJax(district_id, block_id,vill_id);
    });



});


function BlockNameAJax(district_id, block_id) {
    $.ajax({
        url: "{{route('BlockNameAJax')}}",
        method: "POST",
        data: {
            district_id: district_id,
            block_id: block_id,
        },
        success: function(data) {
            // alert(data)
            $("#mem_block").empty();
            $("#mem_block").html(data);

        }
    });
}

function VillageNameAJax(district_id, block_id,vill_id) {
    $.ajax({
        url: "{{route('VillageNameAJax')}}",
        method: "POST",
        data: {
            district_id: district_id,
            block_id: block_id,
            vill_id: vill_id,
        },
        success: function(data) {
            // alert(data)
            $("#mem_vill").empty();
            $("#mem_vill").html(data);

        }
    });
}
</script>

@if(isset($data))
<script>
var updateval = '{{isset($data)?$data->member_type:'
'}}';
var district_id = '{{isset($data)?$data->district_id:'
'}}';
var block_id = '{{isset($data)?$data->mem_block:'
'}}';
var vill_id = '{{isset($data)?$data->mem_vill:'
'}}';
BlockNameAJax(district_id, block_id);
VillageNameAJax(district_id, block_id,vill_id);
if (updateval == 'M') {
    $("#deposit_amount").attr('required', 'required');
    // deposit_amount
} else {
    $("#deposit_amount").removeAttr('required');
}
</script>
@endif
@endsection