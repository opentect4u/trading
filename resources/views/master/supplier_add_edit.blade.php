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
                        <form method="POST" action="{{isset($data)?route('supplierUpdate'):route('supplierCreate')}}"
                            autocomplete="off">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="sup_name" id="sup_name" required
                                        value="{{isset($data)?$data->sup_name:''}}">
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Address</label>
                                    <textarea class="form-control" name="sup_address" id="sup_address" cols="30"
                                        rows="2" required>{{isset($data)?$data->sup_address:''}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Contact No</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no" required
                                        value="{{isset($data)?$data->contact_no:''}}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="sup_email" id="sup_email"
                                        value="{{isset($data)?$data->sup_email:''}}">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">Aadhar No.</label>
                                    <input type="text" class="form-control" name="aadhar_no" id="aadhar_no"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                        value="{{isset($data)?$data->aadhar_no:''}}">
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

                                <div class="col-sm-12">
                                    <label for="">Remarks</label>
                                    <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3">{{isset($data)?$data->remarks:''}}</textarea>
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
@endsection