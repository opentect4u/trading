@extends('common.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">

                <div class="titleSec">
                    <h2>{{isset($data)?'Update':'Create'}} Product Rate</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST"
                            action="{{isset($data)?route('productrateUpdate'):route('productrateCreate')}}">
                            @csrf
                            <input type="text" name="id" id="id" hidden
                                value="{{isset($data)?\Crypt::encryptString($data->id):''}}">
                            <div class="form-group row">
                            <div class="col-sm-6">
                                    <label for="">Effective Date</label>
                                    <input type="text" class="form-control" name="effective_date" id="effective_date" required
                                        value="{{isset($data)?date('d-m-Y',strtotime($data->effective_date)):date('d-m-Y')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Category</label>
                                    <select class="form-control" id="product_master_id" name="product_master_id"
                                        required>
                                        <option value=""> -- Select Category -- </option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}"
                                            <?php if(isset($data) && $data->product_master_id==$product->id){echo "selected";}?>>
                                            {{$product->pdt_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="rate" id="rate" required
                                        value="{{isset($data)?$data->rate:''}}">
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
toastr.success('Product rate update successfully.');
</script>
@endif
@endsection