@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body ">
                <div class="titleSec">
                    <h2> Search</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{route('memberReport')}}">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="">Type</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="ALL" <?php if($type=='ALL'){echo "selected";}?>>All</option>
                                        <option value="A" <?php if($type=='A'){echo "selected";}?>>Open</option>
                                        <option value="C" <?php if($type=='C'){echo "selected";}?>>Close</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 btnSubmitSec">
                                    <input type="submit" class="btn btn-info" id="submit" value="Search">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @if(count($datas)>0)
        <div class="card mt-2">
            <div class="card-body">
                <div class="titleSec">
                    <!-- <a type="button" href="{{route('saleAdd')}}" class="btn btn-primary">Create</a> -->
                    <h2> Members</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>@if($type=='C') Close @else Open @endif Date</th>
                                    <th>Member ID</th>
                                    <th> Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        @if($type=='C')
                                        {{ date('d-m-Y',strtotime($data->date_of_closing))}}
                                        @else
                                        {{date('d-m-Y',strtotime($data->mem_date))}}
                                        @endif
                                    </td>
                                    <td>{{$data->customer_id }}</td>
                                    <td>{{$data->mem_name}}</td>
                                    <td>{{$data->mem_address}}</td>
                                    <td>{{$data->contact_no}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>@if($type=='C') Close @else Open @endif Date</th>
                                    <th>Member ID</th>
                                    <th> Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        @endif
    </div>
</div>
@endsection

@section('script')

@if(Session::has('addSuccess'))
<script>
toastr.success('Product sale successfully.');
</script>
@endif

@endsection