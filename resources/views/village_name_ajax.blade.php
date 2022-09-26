<option value="">-- Select Village -- </option>
@foreach($villages as $village)
<option value="{{$village->sl_no}}" <?php if($vill_id!='' && $vill_id==$village->sl_no){echo "selected";}?>>
    {{$village->vill_name}}</option>
@endforeach