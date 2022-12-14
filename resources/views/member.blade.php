@extends('common.master')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <a type="button" href="{{route('memberAdd')}}" class="btn btn-primary">Create</a>
                    <h2>Members</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <!-- <input class="form-check" type="radio" id="member_type_1" name="member_type" value="A"
                                    <?php if($member_type=='A'){echo "checked";}?>>
                                <label for="html">Open</label>
                                <input class="form-check" type="radio" id="member_type_2" name="member_type" value="C" <?php if($member_type=='C'){echo "checked";}?>>
                                <label for="css">Close</label>
                                <input class="form-check" type="radio" id="member_type_3" name="member_type" value="N" <?php if($member_type=='N'){echo "checked";}?>>
                                <label for="css">Nominal</label> -->


                                <div class="btn-group" >
                                    <label class="btn btn-default">
                                        <input type="radio" id="member_type_1" name="member_type" value="A" <?php if($member_type=='A'){echo "checked";}?>/> Active
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" id="member_type_2" name="member_type" value="C" <?php if($member_type=='C'){echo "checked";}?>/> Close
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" id="member_type_3" name="member_type" value="N" <?php if($member_type=='N'){echo "checked";}?>/> Nominal
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th>Sl No</th> -->
                                    <th>Member ID</th>
                                    <th>Member Date</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Member Type</th>
                                    <!-- <th>Deposit Amount</th> -->
                                    <!-- <th>View</th> -->
                                    <th>Edit</th>
                                    <th>Close</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($datas as $data)
                                <tr id="tr_{{$data->customer_id}}">
                                    <td>{{$data->customer_id}}</td>
                                    <td>{{ date('d-m-Y',strtotime($data->mem_date))}}</td>
                                    <td>{{$data->mem_name}}</td>
                                    <td>{{$data->contact_no}}</td>
                                    <td>
                                        @if($data->member_type=='M')
                                        {{"Member"}}
                                        @else
                                        {{"Nominal"}}
                                        @endif
                                    </td>

                                    <!-- <td>
                                        @if($data->deposit_amount!='')
                                        {{$data->deposit_amount}}
                                        @else
                                        0
                                        @endif
                                    </td> -->
                                    <!-- <td>
                                        <a href="{{route('memberView',['society_id'=>\Crypt::encryptString($data->society_id),'customer_id'=>\Crypt::encryptString($data->customer_id)])}}"
                                            title="View"><i class="fa fa-eye" aria-hidden="true"
                                                style="font-size:18px;"></i></a>
                                    </td> -->
                                    <td>
                                        <a href="{{route('memberEdit',['society_id'=>\Crypt::encryptString($data->society_id),'customer_id'=>\Crypt::encryptString($data->customer_id)])}}"
                                            title="View"><i class="fa fa-edit" aria-hidden="true"
                                                style="font-size:18px;"></i></a>
                                    </td>

                                    <td>
                                        @if($data->member_type=='M')
                                        @if($data->open_close_flag=='C')
                                        -
                                        @else
                                        <a href="{{route('memberClose',['society_id'=>\Crypt::encryptString($data->society_id),'customer_id'=>\Crypt::encryptString($data->customer_id)])}}"
                                            title="Close Member"><i class="fa fa-times-circle-o" aria-hidden="true"
                                                style="font-size:18px;color:red;"></i></a>
                                        @endif
                                        @else
                                        -
                                        @endif
                                    </td>

                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="butDelete('{{\Crypt::encryptString($data->society_id)}}','{{\Crypt::encryptString($data->customer_id)}}')"
                                            title="Delete"><i class="fa fa-trash-o" aria-hidden="true"
                                                style="font-size:18px;color:red;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <!-- <th>Sl No</th> -->
                                    <th>Member ID</th>
                                    <th>Member Date</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Member Type</th>
                                    <!-- <th>Deposit Amount</th> -->
                                    <!-- <th>View</th> -->
                                    <th>Edit</th>
                                    <th>Close</th>
                                    <th>Delete</th>
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
toastr.success('Member Close Successfully.');
</script>
@endif
@if(Session::has('success'))
<script>
toastr.success('Member added Successfully.');
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