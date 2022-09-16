<option value=""> -- Select Product Name -- </option>
@foreach($products as $product)
<option value="{{$product->id}}">{{$product->pdt_name}}</option>
@endforeach