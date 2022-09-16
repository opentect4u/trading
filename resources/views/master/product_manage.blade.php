@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('productAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Product Manage</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product Id</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$data->cat_name}}</td>
                                    <td>{{$data->pdt_name}}</td>
                                    <td><a href="{{route('productEdit',['id'=>\Crypt::encryptString($data->id)])}}" title="Edit"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@if(Session::has('addSuccess'))
<script>
toastr.success('Product added successfully.');
</script>
@endif

@endsection