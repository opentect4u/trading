@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        
        <div class="card mt-2">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('accheadAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Account Heads</h2>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Category</th>
                                    <th>Account Head</th>
                                    <th>Cash/Bank</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr id="tr_{{$data->id}}">
                                    <td>{{$i++}}</td>
                                    <td>
                                        @if($data->category =='L')
                                        Liability
                                        @elseif($data->category =='A')
                                        Assets
                                        @elseif($data->category =='R')
                                        Revenue
                                        @elseif($data->category =='E')
                                        Expense
                                        @elseif($data->category =='S')
                                        Sale
                                        @elseif($data->category =='P')
                                        Purchase
                                        @endif
                                    </td>
                                    <td>{{$data->acc_head}}</td>
                                    <td>
                                        @if($data->cash_bank_flag=='C')
                                        Cash
                                        @elseif($data->category =='B')
                                        Bank
                                        @else
                                        Other
                                        @endif
                                    </td>
                                    <td><a href="{{route('accheadEdit',['id'=>\Crypt::encryptString($data->id)])}}"
                                            title="Edit"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a></td>
                                    <!-- <td><a href="javascript:void(0);"
                                            title="Delete" onclick="butDelete({{$data->id}})"><i class="fa fa-trash-o" aria-hidden="true"
                                                style="font-size:18px;color:red;"></i></a></td> -->
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Category</th>
                                    <th>Account Head</th>
                                    <th>Cash/Bank</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
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
toastr.success('Product purchase successfully.');
</script>
@endif
<script>
$(function() {
    $("#from_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
    $("#to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });
});


function butDelete(customer_id) {
    // alert(customer_id)
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
                        url: "{{route('transDeleteAjax')}}",
                        method: "POST",
                        data: {
                            customer_id: customer_id,
                            table_name: "td_purchase",
                        },
                        success: function(data) {
                            // alert(data)
                            var obj = JSON.parse(data);
                            var id = obj.id;
                            $("#tr_" + id).remove();
                            toastr.success('Delete Successfully.');

                        }
                    });

                }
            }
        }
    });


}
</script>
@endsection