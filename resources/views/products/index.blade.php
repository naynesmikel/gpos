@extends('layouts.app')

@section('content')
<div class="container">
	@include('flash::message')
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<div class="panel panel-default">
				<div class="panel-heading">
					Inventory
				</div>
				
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Date Bought</th>
								<th>Price Bought</th>
								<th>Selling Price</th>
								<th>Date Sold</th>
								<th>Supplier</th>
								<th>Action</th>
								</tr>
							</thead>
							
							<tbody>
								@forelse($products as $product)
									<tr>
										<td>{{$product->product_name}}</td>
										<td>{{$product->quantity}}</td>
										<td>{{$product->date_bought}}</td>
										<td>{{$product->price_bought}}</td>
										<td>{{$product->selling_price}}</td>
										<td>{{$product->date_sold}}</td>
										<td>{{$product->supplier}}</td>
										<td>
											<small><a href="/products/{{$product->id}}/edit" onclick="notify();">edit</a></small>
											<!--small><a href="/products/{{$product->id}}/delete" class="pull-right" style="color: red">delete</a></small-->
											<form action="/products/{{ $product->id }}" method="POST" class="pull-right">
												{{ csrf_field() }}
												
												{{ method_field('DELETE') }}
												<small><button class="btn btn-danger btn-sm">delete</button></small>
											</form>
										</td>
									</tr>
								@empty
									No items yet
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 col-md-offset-3">
						{{$products->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
