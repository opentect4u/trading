@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('usersAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Users</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>user ID</th>
                                    <th>Name</th>
                                    <th>User Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr id="tr_{{$data->customer_id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$data->email}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>
                                        @if($data->user_type=='S')
                                        {{'Super Admin'}}
                                        @elseif($data->user_type=='A')
                                        {{'Admin'}}
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{route('usersEdit',['id'=>\Crypt::encryptString($data->society_id),'customer_id'=>\Crypt::encryptString($data->customer_id)])}}"
                                            title="View"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>user ID</th>
                                    <th>Name</th>
                                    <th>User Type</th>
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
<!-- Toastr -->

@if(Session::has('close_member'))
<script>
toastr.success('Customer Close Successfully.');
</script>
@endif
@if(Session::has('success'))
<script>
toastr.success('User added Successfully.');
</script>
@endif
<script>
$('input[type=radio][name=member_type]').change(function() {
    // alert(this.value);
    var url = ("{{route('memberManage')}}") + "?member_type=" + this.value;
    window.location.assign(url);
});

function butDelete(society_id, customer_id) {
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
                        url: "{{route('memberDeleteAjax')}}",
                        method: "POST",
                        data: {
                            society_id: society_id,
                            customer_id: customer_id,
                        },
                        success: function(data) {
                            // alert(data)
                            var obj = JSON.parse(data);
                            var id = obj.customer_id;
                            $("#tr_" + id).remove();
                            toastr.success('Member Delete Successfully.');

                        }
                    });

                }
            }
        }
    });


}
// toastr.success('You clicked Success toast');


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