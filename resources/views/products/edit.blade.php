
<form class="form-horizontal" role="form" method="POST" action="/products/{{ $product->id }}">
	{{ method_field('PUT') }}

	{{ csrf_field() }}

	<div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
    <label for="product_name" class="col-md-4 control-label">Product Name</label>

    <div class="col-md-6">
      <input id="product_name" type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" required autofocus>

      @if ($errors->has('product_name'))
        <span class="help-block">
          <strong>{{ $errors->first('product_name') }}</strong>
        </span>
      @endif
    </div>
	</div>

	<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
    <label for="quantity" class="col-md-4 control-label">Quantity</label>

    <div class="col-md-6">
      <input id="quantity" type="number" min="1" max="2147483647" class="form-control" name="quantity" value="{{ $product->quantity }}" required autofocus>

      @if ($errors->has('quantity'))
        <span class="help-block">
          <strong>{{ $errors->first('quantity') }}</strong>
        </span>
      @endif
    </div>
	</div>

	<div class="form-group{{ $errors->has('date_bought') ? ' has-error' : '' }}">
    <label for="date_bought" class="col-md-4 control-label">Date Bought</label>

    <div class="col-md-6">
      <input id="date_bought" type="date" class="form-control" name="date_bought" value="{{ $product->date_bought->format('Y-m-d') }}" required autofocus>

      @if ($errors->has('date_bought'))
        <span class="help-block">
        	<strong>{{ $errors->first('date_bought') }}</strong>
        </span>
      @endif
    </div>
	</div>

	<div class="form-group{{ $errors->has('price_bought') ? ' has-error' : '' }}">
    <label for="price_bought" class="col-md-4 control-label">Price Bought</label>

    <div class="col-md-6">
      <input id="price_bought" type="number" step="any" min="0" max="2147483647" class="form-control" name="price_bought" value="{{ $product->price_bought }}" required autofocus>

      @if ($errors->has('price_bought'))
        <span class="help-block">
        	<strong>{{ $errors->first('price_bought') }}</strong>
        </span>
      @endif
    </div>
	</div>

	<div class="form-group{{ $errors->has('selling_price') ? ' has-error' : '' }}">
    <label for="selling_price" class="col-md-4 control-label">Selling Price</label>

    <div class="col-md-6">
      <input id="selling_price" type="number" step="any" min="0" max="2147483647" class="form-control" name="selling_price" value="{{ $product->selling_price }}" required autofocus>

      @if ($errors->has('selling_price'))
        <span class="help-block">
          <strong>{{ $errors->first('selling_price') }}</strong>
        </span>
      @endif
    </div>
	</div>

	<div class="form-group{{ $errors->has('supplier') ? ' has-error' : '' }}">
    <label for="supplier" class="col-md-4 control-label">Supplier</label>

    <div class="col-md-6">
      <input id="supplier" type="text" class="form-control" name="supplier" value="{{ $product->supplier }}" required autofocus>

      @if ($errors->has('supplier'))
        <span class="help-block">
          <strong>{{ $errors->first('supplier') }}</strong>
        </span>
      @endif
    </div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<input type="submit" class="btn btn-success pull-right" onclick="notify();">
		</div>
	</div>
	
</form>
