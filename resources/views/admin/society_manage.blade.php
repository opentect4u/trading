@extends('admin.common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('admin.societyAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Society manage</h2>
                </div>
              
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($societies as $data)
                                <tr id="tr_{{$i}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$data->soc_name}}</td>
                                    <td>{{$data->soc_address}}</td>
                                    <td>
                                        <a href="{{route('admin.societyEdit',['id'=>\Crypt::encryptString($data->id)])}}"
                                            title="Edit"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a>
                                    </td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Toastr -->

@if(Session::has('success'))
<script>
toastr.success('Society add Successfully.');
</script>
@endif
<script>



$('#success').click(function(event) {
    toastr.success('You clicked Success toast');
});
$('#info').click(function(event) {
    toastr.info('You clicked Info toast')
});
$('#error').click(function(event) {
    toastr.error('You clicked Error Toast')
});
$('#warning').click(function(event) {
    toastr.warning('You clicked Warning Toast')
});
</script>
@endsection