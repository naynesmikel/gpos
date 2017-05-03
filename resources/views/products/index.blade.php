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
		$('#barcode').val(Math.floor(Math.random() * 8999999 + 1000000));
		$(".delbtn").click(function(){
		  if(confirm("Are you sure you want to delete this?")){
				$(".delbtn").attr("href", "query.php?ACTION=delete&ID='1'");
		  }else{
				return false;
		  }
		});
	});
</script>

<style>
	.panel-heading {
		padding: 15px;
		line-height:30px;
	}
	.btn-primary {
		margin-left: 10px;
	}
	.createorder {
		width: 800px;
	}
</style>

<div class="container">
	@include('flash::message')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Inventory
					<button type="button" class="btn btn-primary btn-sm actions pull-right" data-toggle="modal" data-target="#addproduct">Add Product</button>
					<button type="button" class="btn btn-primary btn-sm actions pull-right" data-toggle="modal" data-target="#createorder">Create Order</button>
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
											<!--a href="/products/{{$product->id}}/edit" class="btn btn-default btn-sm actions">edit</a-->
											<button type="button" class="btn btn-default btn-sm actions" data-toggle="modal" data-target="#edit{{$product->id}}">edit</button>
											@endif

											@if(Auth::user()->admin)
											<button type="button" class="btn btn-success btn-sm actions" data-toggle="modal" data-target="#{{$product->id}}" style="margin-left: 20px;">stock item</button>
											@else
											<button type="button" class="btn btn-success btn-sm actions" data-toggle="modal" data-target="#{{$product->id}}">stock item</button>
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

				      <div class="modal-body">
								@include('products/stockItem')
				      </div>

				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>

				<div id="edit{{$product->id}}" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Edit Product</h4>
							</div>

							<div class="modal-body">
								@include('products/edit')
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
						<center><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							<br>
							You have not bought any items yet.
						</center>
					</div>
				@endif

				<div id="addproduct" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Add Product</h4>
							</div>

							<div class="modal-body">
								@include('products/create')
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>

				<div id="createorder" class="modal fade" role="dialog">
					<div class="modal-dialog createorder">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Create Order</h4>
							</div>

							<div class="modal-body">
								@include('orders/create')
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>

				<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" autofocus>
				  <div class="modal-dialog">

				    <div class="modal-content">
				      <div class="modal-header">
				        <h4 class="modal-title">Create Order</h4>
				      </div>
				      <div class="modal-body">
				        <center>Your customer's order has been saved. Click <i>continue</i> to continue to the <strong>Orders Log</strong>.</center>
				      </div>
				      <div class="modal-footer">
								<a href="/orders" id="continue-link">Continue</a>
				      </div>
				    </div>

				  </div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
