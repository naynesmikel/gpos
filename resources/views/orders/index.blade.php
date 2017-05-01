
@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Orders Log
				</div>

				<div class="panel-body">
					@if(!$orders->isEmpty())
					<p><small style="color: gray;">Arrange the orders log by a column by clicking a header</small></p>
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><a href={{$productlink}} class="actions">Product Name</a></th>
									<th><a href={{$quantitylink}} class="actions">Quantity</a></th>
									<th><a href={{$sellingpricelink}} class="actions">Price</a></th>
									<th><a href={{$subtotallink}} class="actions">Sub Total</a></th>
									<th><a href={{$discountlink}} class="actions">Discount (%)</a></th>
									<th><a href={{$totalamountlink}} class="actions">Total Amount</a></th>
									<th><a href={{$datesoldlink}} class="actions">Sold on</a></th>
									<th><a href={{$soldbylink}} class="actions">Sold by</a></th>
								</tr>
							</thead>
							<tbody>
								@foreach($orders as $order)
									<tr>
										<td>{{$order->product_name}}</td>
										<td>{{$order->quantity}}</td>
										<td>{{$order->selling_price}}</td>
										<td>{{$order->subtotal}}</td>
										<td>{{$order->discount}}</td>
										<td>{{$order->total_amount}}</td>
										<td>{{$order->date_sold}}</td>
										<td>{{$order->name}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 col-md-offset-3">
						{{$orders->links()}}
					</div>
				</div>
				@else
				<div class="panel-body">
					You not made any sales yet.
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
