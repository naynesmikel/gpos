@extends('layouts.app')

@section('content')

<script>
	function totalAmount(){
		var t = 0;
		$('.total_amount').each(function(i,e){
			var amt = $(this).val()-0;
			t += amt;
		});
		$('.total').html(t);
		
		$('#cash_out').val(($('#cash_in').val()-0) - ($('.total').html()-0));
	}
	$(document).ready(function(){
		$("#add").click(function () {
			var product = $(".product_name option:selected").text();
			var tr = '<tr><input type="hidden" class="product_id" value=""><td class="col-md-4"><div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}"><div class="col-md-12"><select class="form-control product_name" id="product_name" name="product_name" required><option></option>@forelse($products as $product)<option data-id="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-qty="{{ $product->quantity }}">{{ $product->product_name }}</option>@empty<option>----</option>@endforelse</select>@if ($errors->has('product_name'))<span class="help-block"><strong>{{ $errors->first('product_name') }}</strong></span>@endif</div></div></td><td class="col-md-2"><div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}"><div class="col-md-10"><input id="quantity" type="number" min="0" class="form-control quantity" name="quantity" value="{{ old('quantity') }}" required readonly >@if ($errors->has('quantity'))<span class="help-block"><strong>{{ $errors->first('quantity') }}</strong></span>@endif</div></div></td><td class="col-md-2"><div class="form-group{{ $errors->has('selling_price') ? ' has-error' : '' }}"><div class="col-md-10"><input id="selling_price" type="text" class="form-control selling_price" name="selling_price" value="{{ old('selling_price') }}" required readonly>@if ($errors->has('selling_price'))<span class="help-block"><strong>{{ $errors->first('selling_price') }}</strong></span>@endif</div></div></td><td class="col-md-2"><div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}"><div class="col-md-10"><input id="discount" type="number" min="0" class="form-control discount" name="discount" value="{{ old('discount') }}" required readonly>@if ($errors->has('discount'))<span class="help-block"><strong>{{ $errors->first('discount') }}</strong></span>@endif</div></div></td><td class="col-md-2"><div class="form-group{{ $errors->has('total_amount') ? ' has-error' : '' }}"><div class="col-md-10"><input id="total_amount" type="text" class="form-control total_amount" name="total_amount" value="{{ old('total_amount') }}" required readonly>@if ($errors->has('total_amount'))<span class="help-block"><strong>{{ $errors->first('total_amount') }}</strong></span>@endif</div></div></td><td><input type="button" class="btn btn-danger delete" value="delete"></td></tr>';
			$('#place_order').append(tr);
			$('#counter').val(($('#counter').val()-0)+1);
		});
		$('#place_order').delegate('.delete', 'click', function () {
			if($('#place_order tr').length != 1){
				$(this).parent().parent().remove();
				$('#counter').val(($('#counter').val()-0)-1);
				totalAmount();
			}else
				alert("You cannot have no items in an order");
		});
		$('#place_order').delegate('.product_name', 'change', function () {
			var tr = $(this).parent().parent().parent().parent();
			
			if(tr.find('.product_name option:selected').val() == ""){
				tr.find('.product_id').attr('value', "");
				tr.find('.selling_price').attr('value', 0);
				tr.find('.quantity').val(0);
				tr.find('.discount').val(0);
				tr.find('.total_amount').val(0);
				tr.find('.quantity').attr('readonly', true);
				tr.find('.discount').attr('readonly', true);
			}else{
				var dataprice = tr.find('.product_name option:selected').attr('data-price');
				var dataqty = tr.find('.product_name option:selected').attr('data-qty');
				var dataid = tr.find('.product_name option:selected').attr('data-id');
				
				tr.find('.product_id').attr('value', dataid);
				tr.find('.selling_price').attr('value', dataprice);
				tr.find('.quantity').attr('max', dataqty);
				tr.find('.quantity').val(1);
				tr.find('.discount').val(0);
				
				var qty = tr.find('.quantity').val() - 0;
				var discount = tr.find('.discount').val() - 0;
				var price = tr.find('.selling_price').val() - 0;
			
				var total = (qty * price) - ((qty * price * discount)/100);
				tr.find('.total_amount').val(total);
				
				tr.find('.quantity').attr('readonly', false);
				tr.find('.discount').attr('readonly', false);
			}
			totalAmount();
		});
		$('#place_order').delegate('.quantity', 'change', function () {
			var tr = $(this).parent().parent().parent().parent();
			var dataprice = tr.find('.product_name option:selected').attr('data-price');
			var dataqty = tr.find('.product_name option:selected').attr('data-qty');
			
			if((tr.find('.quantity').val() - 0) > dataqty){
				alert("Item lacks supply with the quantity request.");
				tr.find('.quantity').val(dataqty);
			}
			
			var qty = tr.find('.quantity').val() - 0;
			var discount = tr.find('.discount').val() - 0;
			var price = tr.find('.selling_price').val() - 0;
		
			var total = (qty * price) - ((qty * price * discount)/100);
			tr.find('.total_amount').val(total);
			totalAmount();
		});
		$('#place_order').delegate('.discount', 'change', function () {
			var tr = $(this).parent().parent().parent().parent();
			
			if(tr.find('.discount').val() == "")
				tr.find('.discount').val(0);
				
			var qty = tr.find('.quantity').val() - 0;
			var discount = tr.find('.discount').val() - 0;
			var price = tr.find('.selling_price').val() - 0;
		
			var total = (qty * price) - ((qty * price * discount)/100);
			tr.find('.total_amount').val(total);
			totalAmount();
		});
		$('#cash_in').change(function() {
			$('#cash_out').val(($('#cash_in').val()-0) - ($('.total').html()-0));
			console.log($('#cash_in').val());
		});
	});
</script>

<div class="container">
	@include('flash::message')
	
	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					Place Order
				</div>
				
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/orders">
						{{ csrf_field() }}
						
						<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
						<input type="hidden" id="counter" value="1">
						
						<table class="table">
							<tr>
								<td>
									<div class="form-group{{ $errors->has('customer_name') ? ' has-error' : '' }}">
										<label for="customer_name" class="col-md-2 control-label">Name</label>

										<div class="col-md-10">
											<input id="customer_name" type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}" autofocus>
										</div>
									</div>
								</td>
								<td>
									<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
										<label for="location" class="col-md-2 control-label">Address</label>

										<div class="col-md-10">
											<input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}">
										</div>
									</div>
								</td>
							</tr>
                        </table>
						
						<table class="table">
							<thead>
								<tr>
									<th>Product Name</th>
									<th>Quantity</th>
									<th>Selling Price</th>
									<th>Discount (%)</th>
									<th>Total Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							
							<tbody id="place_order">
								
								<tr>
									<input type="hidden" class="product_id" value="">
									<td class="col-md-4">
										<div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
											<div class="col-md-12">
												<select class="form-control product_name" id="product_name" name="product_name" required>
														<option></option>
													@forelse($products as $product)
														<option data-id="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-qty="{{ $product->quantity }}">{{ $product->product_name }}</option>
													@empty
														<option>----</option>
													@endforelse
												</select>

												@if ($errors->has('product_name'))
													<span class="help-block">
														<strong>{{ $errors->first('product_name') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</td>
									
									<td class="col-md-2">
										<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
											<div class="col-md-10">
												
												<input id="quantity" type="number" min="0" class="form-control quantity" name="quantity" value="{{ old('quantity') }}" required readonly>

												@if ($errors->has('quantity'))
													<span class="help-block">
														<strong>{{ $errors->first('quantity') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</td>
									
									<td class="col-md-2">
										<div class="form-group{{ $errors->has('selling_price') ? ' has-error' : '' }}">
											<div class="col-md-10">
												<input id="selling_price" type="text" class="form-control selling_price" name="selling_price" value="{{ old('selling_price') }}" required readonly>

												@if ($errors->has('selling_price'))
													<span class="help-block">
														<strong>{{ $errors->first('selling_price') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</td>
									
									<td class="col-md-2">
										<div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
											<div class="col-md-10">
												<input id="discount" type="number" min="0" class="form-control discount" name="discount" value="{{ old('discount') }}" required readonly>

												@if ($errors->has('discount'))
													<span class="help-block">
														<strong>{{ $errors->first('discount') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</td>
									
									<td class="col-md-2">
										<div class="form-group{{ $errors->has('total_amount') ? ' has-error' : '' }}">
											<div class="col-md-10">
												<input id="total_amount" type="text" class="form-control total_amount" name="total_amount" value="{{ old('total_amount') }}" required readonly>

												@if ($errors->has('total_amount'))
													<span class="help-block">
														<strong>{{ $errors->first('total_amount') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</td>
									
									<td>
										<input type="button" class="btn btn-danger delete" value="delete">
									</td>
								</tr>
								
							</tbody>
							
							<tfoot>
								<th colspan="6">Total: <b class="total">0</b></th>
							</tfoot>
						</table>
						
						<input id="add" type="button" class="btn btn-primary" value="Add Item">
						
						<hr>
						
						<div class="form-group{{ $errors->has('cash_in') ? ' has-error' : '' }}">
                            <label for="cash_in" class="col-md-4 control-label">Cash</label>

                            <div class="col-md-4">
                                <input id="cash_in" type="number" min="0" class="form-control" name="cash_in" value="0" required autofocus>

                                @if ($errors->has('cash_in'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cash_in') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('cash_out') ? ' has-error' : '' }}">
                            <label for="cash_out" class="col-md-4 control-label">Change</label>

                            <div class="col-md-4">
                                <input id="cash_out" type="text" class="form-control" name="cash_out" value="0" required autofocus readonly>

                                @if ($errors->has('cash_out'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cash_out') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
						<input type="submit" class="btn btn-success pull-right" value="Done">
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Generate Receipt
				</div>
				
				<div class="panel-body">
					If you choose to generate a receipt, the placed order will automatically be saved in the database.
					<hr>
					<input id="generate_receipt" type="button" class="btn btn-primary" value="Print Receipt">
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
