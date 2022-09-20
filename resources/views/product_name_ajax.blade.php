<option value=""> -- Select Product Name -- </option>
@foreach($products as $product)
<option value="{{$product->id}}"
    <?php if($product_master_id!='' && $product_master_id=$product->id){echo "selected";}?>>{{$product->pdt_name}}
</option>
@endforeach