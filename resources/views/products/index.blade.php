@extends('layouts.app')

@section('content')
<script>
	$(document).ready(function(){
		$(document.body).on('hide.bs.modal', function () {
    	$('body').css('padding-right','0');
		});
		$(document.body).on('hidden.bs.modal', function () {
		  $('body').css('padding-right','0');
		});
	});
</script>

<style>
	.panel-heading {
		padding: 15px;
		line-height:30px;
	}
	#addproduct {
		vertical-align: middle;
	}
</style>

<div class="container">
	@include('flash::message')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Inventory
					@if(Auth::user()->admin)
					<a class="btn btn-primary pull-right" href="/products/create">Add New Product</a>
					@endif
				</div>

				<div class="panel-body">
					@if(!$products->isEmpty())

					<p><small style="color: gray;">Arrange the inventory by a column by clicking a header</small></p>
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
								<th><a href={{$productlink}} class="actions">Product Name</a></th>
								<th><a href={{$quantitylink}} class="actions">Quantity</a></th>
								<th><a href={{$priceboughtlink}} class="actions">Cost</a></th>
								<th><a href={{$sellingpricelink}} class="actions">Price</a></th>
								<th><a href={{$supplierlink}} class="actions">Supplier</a></th>
								<th><a href={{$dateboughtlink}} class="actions">Date Bought</a></th>
								<th>Action</th>
								</tr>
							</thead>

							<tbody>
								@foreach($products as $product)
									<tr>
										<td>{{$product->product_name}}</td>
										<td>{{$product->quantity}}</td>
										<td>{{$product->price_bought}}</td>
										<td>{{$product->selling_price}}</td>
										<td>{{$product->supplier}}</td>
										<td>{{$product->date_bought->toFormattedDateString()}}</td>
										<td>
											@if(Auth::user()->admin)
											<a href="/products/{{$product->id}}/edit" class="btn btn-default btn-sm actions">edit</a>
											@endif

											@if(Auth::user()->admin)
											<button type="button" class="btn btn-success btn-sm actions" data-toggle="modal" data-target="#{{$product->id}}" id="addproduct" style="margin-left: 20px;">stock item</button>
											@else
											<button type="button" class="btn btn-success btn-sm actions" data-toggle="modal" data-target="#{{$product->id}}" id="addproduct">stock item</button>
											@endif

											@if(Auth::user()->admin)
											<form action="/products/{{ $product->id }}" method="POST" class="pull-right actions">
												{{ csrf_field() }}

												{{ method_field('DELETE') }}
												<small><button class="btn btn-danger btn-sm actions delbtn">delete</button></small>
											</form>
											@endif
										</td>

									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 col-md-offset-3">
						{{$products->links()}}
					</div>
				</div>

				@foreach($products as $product)
				<div id="{{$product->id}}" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Stock Item</h4>
				      </div>
				      <div class="modal-body" style="padding: 40px;">
								<p><small style="color: gray;">Increase the number of items on an existing product.</small></p>
								<form class="form-horizontal" role="form" method="POST" action="/products/additem">
									{{ csrf_field() }}
									<table class="table">
										<thead>
											<th>Product Name</th>
											<th>Quantity</th>
										</thead>
										<tbody>
											<tr>
												<input type="hidden" name="product_id" class="product_id" id="product_id" value="{{$product->id}}">
												<td>
													{{ $product->product_name }}
												</td>
												<td>
													<input id="quantity" type="number" min="1" max="2147483647" class="form-control quantity" name="quantity" value="1" required>
												</td>
											</tr>
										</tbody>
									</table>
									<input type="submit" class="btn btn-success pull-right">
								</form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>
				@endforeach
				@else
					<div class="panel-body">
						No items yet
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
