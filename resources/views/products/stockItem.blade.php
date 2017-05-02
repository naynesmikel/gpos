<p><small style="color: gray;">Increase the number of items on an existing product.</small></p>

<form class="form-horizontal" role="form" method="POST" action="/products/additem">
  {{ csrf_field() }}

  <input type="hidden" name="product_id" class="product_id" id="product_id" value="{{$product->id}}">

  <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
    <label for="product_name" class="col-md-4 control-label">Product Name</label>

    <div class="col-md-6">
      <h5> {{ $product->product_name }} </h5>
    </div>
  </div>

  <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
      <label for="quantity" class="col-md-4 control-label">Quantity</label>

      <div class="col-md-6">
        <input id="quantity" type="number" min="1" max="2147483647" class="form-control quantity" name="quantity" value="1" required>
      </div>
  </div>

  <div class="form-group">
    <div class="col-md-6 col-md-offset-4">
      <input type="submit" class="btn btn-success pull-right" onclick="notify();">
    </div>
  </div>
  
</form>
