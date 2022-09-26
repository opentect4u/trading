@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('supplierAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Suppliers</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Supplier Id</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr id="tr_{{$data->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$data->sup_name}}</td>
                                    <td>{{$data->contact_no}}</td>
                                    <td><a href="{{route('supplierEdit',['id'=>\Crypt::encryptString($data->id)])}}"
                                            title="Edit"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a></td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="butDelete('{{\Crypt::encryptString($data->id)}}')"
                                            title="Delete"><i class="fa fa-trash-o" aria-hidden="true"
                                                style="font-size:18px;color:red;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>Supplier Id</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
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
toastr.success('Supplier added successfully.');
</script>
@endif


<script>
function butDelete(id) {
    // alert(id)
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

                    $.ajax({
                        url: "{{route('SupplierDeleteAjax')}}",
                        method: "POST",
                        data: {
                            id: id,
                            // customer_id: customer_id,
                        },
                        success: function(data) {
                            // alert(data)
                            var obj = JSON.parse(data);
                            var id = obj.id;
                            $("#tr_" + id).remove();
                            toastr.success('Supplier Delete Successfully.');

                        }
                    });

                }
            }
        }
    });


}
</script>
@endsection