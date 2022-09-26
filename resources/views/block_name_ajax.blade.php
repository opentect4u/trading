<option value="">-- Select Block -- </option>
@foreach($blocks as $block)
<option value="{{$block->sl_no}}" <?php if($block_id!='' && $block_id==$block->sl_no){echo "selected";}?>>
    {{$block->block_name}}</option>
@endforeach