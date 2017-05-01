@extends('layouts.app')

@section('content')
<script>
	$(document).ready(function(){
		$("#select_all").on('change',function (event) {
			var c = this.checked;
			$(':checkbox').prop('checked',c);
			if($('input[name="generate[]"]:checked').length == 0)
				$(".submit").hide();
			else
				$(".submit").show();
		});
		$(".generate").on('change',function (event)  {
			if($('input[name="generate[]"]:checked').length == 0)
				$(".submit").hide();
			else
				$(".submit").show();
		});
	});
</script>

<style>
	.submit{
		display: none;
		position: fixed;
		right: 0;
		margin-right: -1px;
	}
</style>

<div class="container">

	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<div class="panel panel-default">
					<div class="panel-heading">
						Create Barcodes

					</div>
					@if(!$products->isEmpty())
				<form class="form-horizontal" role="form" method="POST" action="/products/createBarcode" target="_blank">
						{{ csrf_field() }}
						<input type="submit" class="btn btn-success pull-right submit" value="Generate Barcodes.pdf">
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
									<th>Supplier</th>
									<th><input type="checkbox" name="select_all" value="" id="select_all"> Select All</th>
									</tr>
								</thead>

								<tbody>
									@forelse($products as $product)
										<tr>
											<td>{{$product->product_name}}</td>
											<td>{{$product->quantity}}</td>
											<td>{{$product->date_bought->toFormattedDateString()}}</td>
											<td>{{$product->price_bought}}</td>
											<td>{{$product->selling_price}}</td>
											<td>{{$product->supplier}}</td>
											<td>
												<input type="checkbox" name="generate[]" class="generate" value="{{$product->barcode}}">
											</td>
										</tr>
									@empty
										No items yet
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</form>
				@else
				<div class="panel-body">
					<div class="panel-body">
						No items yet
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
