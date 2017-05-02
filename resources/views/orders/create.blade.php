@extends('layouts.app')

@section('content')

<script>
	function totalAmount(){
		var t = 0;
		$('.total_amount').each(function(i,e){
			var amt = $(this).val()-0;
			t += amt;
		});

		$('.total').html(t.toFixed(2));

		$('#cash_out').val((($('#cash_in').val()-0) - t).toFixed(2));
	}

	$(document).ready(function(){
		var selecteditems;
		$("#add").click(function () {
			selecteditems = [];

			var tr = "<tr>";
			tr += "<input type='hidden' name='product_id[]' class='product_id' value=''>";
			tr += "<td class='col-md-3'>";
			tr += "<select class='form-control product_name' id='product_name' name='product_name[]' required>";
			tr += "<option value='select product'>select product</option>";
			tr += "@forelse($products as $product)";
			tr += "<option data-id='{{ $product->id }}' data-price='{{ $product->selling_price }}' data-qty='{{ $product->quantity }}' data-pricebought='{{ $product->price_bought }}'>{{ $product->product_name }}</option>";
			tr += "@empty";
			tr += "<option value='----'>----</option>";
			tr += "@endforelse";
			tr += "</select>";
			tr += "</td>";
			tr += "<td class='col-md-1'>";
			tr += "<input id='quantity' type='number' min='1' max='2147483647' class='form-control quantity' name='quantity[]' required readonly>";
			tr += "</td>";
			tr += "<td class='col-md-2'>";
			tr += "<input id='selling_price' type='text' class='form-control selling_price' name='selling_price[]' required readonly>";
			tr += "</td>";
			tr += "<td class='col-md-2'>";
			tr += "<input id='subtotal' type='number' class='form-control subtotal' name='subtotal[]' required readonly>";
			tr += "</td>";
			tr += "<td class='col-md-1'>";
			tr += "<input id='discount' type='number' min='0' max='100' class='form-control discount' name='discount[]' required readonly>";
			tr += "</td>";
			tr += "<td class='col-md-2'>";
			tr += "<input id='total_amount' type='text' class='form-control total_amount' name='total_amount[]' required readonly>";
			tr += "</td>";
			tr += "<input type='hidden' name='date_sold[]' value='{{ date('Y-m-d H:i:s') }}'>";
			tr += "<input type='hidden' class='price_bought' name='price_bought[]' value=''>";
			tr += "<td class='col-md-1'>";
			tr += "<small><input type='button' class='btn btn-danger delete' value='delete'></small>";
			tr += "</td>";
			tr += "</tr>";
			$('#place_order').append(tr);
			$('#counter').val(($('#counter').val()-0)+1);

			$('.product_name').each(function(i,e){
				var item = $(this).val();
				if(item != "select product" && item != "----"){
					selecteditems.push(item);
					$('#place_order').children().last().find('.product_name option').each(function() {
				    if ( $(this).val() == item ) {
				    	$(this).hide();
				    }
					});
				}
			});
			console.log(selecteditems);

			$('#cash_out').val((($('#cash_in').val()-0) - ($('.total').html()-0)).toFixed(2));
			var emptyProducts = $(".product_name option:selected[value='select product']").length;
			var emptyDash = $(".product_name option:selected[value='----']").length;

			if($('#cash_out').val()-0 < 0 || emptyProducts > 0 || emptyDash > 0){
				$("#submit").attr("disabled", true);
			}else
				$("#submit").removeAttr("disabled");

		});
		$('#place_order').delegate('.delete', 'click', function () {
			if($('#place_order tr').length != 1){
				var deleteditem = $(this).parent().parent().parent().find('.product_name option:selected').val();

				if(deleteditem != "select product" && deleteditem != "----"){
					selecteditems.splice(selecteditems.indexOf(deleteditem), 1);
				}

				$(this).parent().parent().parent().remove();
				$('#counter').val(($('#counter').val()-0)-1);

				$('.product_name').each(function(i,e){
					$('option', this).each(function() {
						$(this).show();
					});
				});

				var temp = selecteditems;
				k = 0;
				$('.product_name').each(function(i,e){
					for(var j=0; j<temp.length; j++){
						if($(this).val() != temp[j]){
							$('option', this).each(function() {
						    if ( $(this).val() == temp[j] ) {
						    	$(this).hide();
						    }
							});
						}
					}
					if($(this).val() != "select product" && $(this).val() != "----"){
						$(this).val(temp[k]).change();
						k++;
					}
				});

				totalAmount();

				$('#cash_out').val((($('#cash_in').val()-0) - ($('.total').html()-0)).toFixed(2));
				var emptyProducts = $(".product_name option:selected[value='select product']").length;
				var emptyDash = $(".product_name option:selected[value='----']").length;

				if($('#cash_out').val()-0 > 0 && emptyProducts == 0 && emptyDash == 0){
					$("#submit").removeAttr("disabled");
				}

			}else{
				alert("You cannot have no items in an order");
			}
		});
		$('#place_order').delegate('.product_name', 'change', function () {
			var tr = $(this).parent().parent();

			if(tr.find('.product_name option:selected').val() == "select product" || tr.find('.product_name option:selected').val() == "----"){
				tr.find('.product_id').attr('value', "");
				tr.find('.price_bought').attr('value', "");
				tr.find('.selling_price').attr('value', "");
				tr.find('.quantity').val("");
				tr.find('.subtotal').val("");
				tr.find('.discount').val("");
				tr.find('.total_amount').val("");
				tr.find('.quantity').attr('readonly', true);
				tr.find('.discount').attr('readonly', true);
			}else{
				selecteditems = [];
				$('.product_name').each(function(i,e){
					var item = $(this).val();

					if(item != "select product" && item != "----"){
						selecteditems.push(item);
					}
				});

				$('.product_name').each(function(i,e){
					$('option', this).each(function() {
						$(this).show();
					});
				});

				tr.find('.product_name option').each(function() {
					if($(this).val() == "select product"){
						$(this).remove();
					}
				});

				var temp = selecteditems;
				$('.product_name').each(function(i,e){
					for(var j=0; j<temp.length; j++){
						if($(this).val() != temp[j]){
							$('option', this).each(function() {
						    if ( $(this).val() == temp[j] ) {
						    	$(this).hide();
						    }
							});
						}
					}
				});

				var dataprice = tr.find('.product_name option:selected').attr('data-price');
				var dataqty = tr.find('.product_name option:selected').attr('data-qty');
				var dataid = tr.find('.product_name option:selected').attr('data-id');
				var datapricebought = tr.find('.product_name option:selected').attr('data-pricebought');

				tr.find('.product_id').attr('value', dataid);
				tr.find('.price_bought').attr('value', datapricebought - 0);
				tr.find('.selling_price').attr('value', dataprice - 0);
				tr.find('.quantity').attr('max', dataqty - 0);
				if(tr.find('.quantity').val() == ""){
					tr.find('.quantity').val(1);
				}else{
					if(tr.find('.quantity').val() > dataqty){
						tr.find('.quantity').val(dataqty);
					}
				}
				if(tr.find('.discount').val() == ""){
					tr.find('.discount').val(0);
				}

				var qty = tr.find('.quantity').val() - 0;
				var discount = tr.find('.discount').val() - 0;
				var price = tr.find('.selling_price').val() - 0;

				var subtotal = qty * price;
				qty * (price - discount/100)
				var total = subtotal - ((qty * price * discount)/100);
				tr.find('.subtotal').val(subtotal);
				tr.find('.total_amount').val(total);

				tr.find('.quantity').attr('readonly', false);
				tr.find('.discount').attr('readonly', false);

				$('#cash_out').val((($('#cash_in').val()-0) - ($('.total').html()-0)).toFixed(2));
				var emptyProducts = $(".product_name option:selected[value='select product']").length;
				var emptyDash = $(".product_name option:selected[value='----']").length;

				if($('#cash_out').val()-0 > 0 && emptyProducts == 0 && emptyDash == 0){
					$("#submit").removeAttr("disabled");
				}
			}
			if(tr.find('.product_name option:selected').val() != "----")
				totalAmount();
		});
		$('#place_order').delegate('.quantity', 'change', function () {
			var tr = $(this).parent().parent();
			var dataprice = tr.find('.product_name option:selected').attr('data-price');
			var dataqty = tr.find('.product_name option:selected').attr('data-qty');

			if((tr.find('.quantity').val() - 0) > dataqty){
				alert("Item lacks supply with the quantity request.");
				tr.find('.quantity').val(dataqty);
			}

			var qty = tr.find('.quantity').val() - 0;
			var discount = tr.find('.discount').val() - 0;
			var price = tr.find('.selling_price').val() - 0;

			var subtotal = qty * price;
			var total = (qty * price) - ((qty * price * discount)/100);
			tr.find('.subtotal').val(subtotal);
			tr.find('.total_amount').val(total);
			totalAmount();
		});
		$('#place_order').delegate('.discount', 'change', function () {
			var tr = $(this).parent().parent();

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
			$('#cash_out').val((($('#cash_in').val()-0) - ($('.total').html()-0)).toFixed(2));
			var emptyProducts = $(".product_name option:selected[value='select product']").length;
			var emptyDash = $(".product_name option:selected[value='----']").length;

			if($('#cash_out').val()-0 < 0){
				$("#submit").attr("disabled", true);
				alert("Cash tendered is less than the total price of the order/s.");
			}else if(emptyProducts > 0 || emptyDash > 0){
				$("#submit").attr("disabled", true);
				alert("Please select a product on each row or delete them.");
			}else
				$("#submit").removeAttr("disabled");

			totalAmount();
		});
		$('#submit').mousedown(function() {
	    var emptyProducts = $(this).parent().find($('select')).filter(function() { return $(this).val() == ""; });
			var emptyCash = $(this).parent().find('input[type="number"]').filter(function() { return $(this).val() == ""; });
			var emptyDash = $(".product_name option:selected[value='----']").length;

	    if (emptyProducts.length || emptyCash.length) {
					$("#submit").removeAttr("data-toggle");
					$("#submit").removeAttr("data-target");
	    }else{
					$('#submit').attr("data-toggle", "modal");
					$('#submit').attr("data-target", "#myModal");
			}
		});
		$(document).keypress(function(event) {
			  if (event.which == '13') {
			  		event.preventDefault();
			  }
		});
	});
</script>

<style>
		th, td {
				padding: 15px;
		}
</style>

<div class="container">
	@include('flash::message')

	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					Place Order
				</div>

				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/orders" target="_blank">
						{{ csrf_field() }}

						<input type="hidden" name="user_id" value="{{ Auth::user()->name }}">

						<table class="table">
							<tr>
								<td>
									<div class="form-group{{ $errors->has('customer_name') ? ' has-error' : '' }}">
										<label for="customer_name" class="col-md-4 control-label">Customer Name</label>

										<div class="col-md-7">
											<input id="customer_name" type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}" autofocus>
											<p><small style="color: gray;"><i>Optional</i></small></p>
										</div>
									</div>
								</td>
								<td>
									<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
										<label for="location" class="col-md-2 control-label">Address</label>

										<div class="col-md-10">
											<input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}">
											<p><small style="color: gray;"><i>Optional</i></small></p>
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
									<th>Sub Total</th>
									<th>Discount (%)</th>
									<th>Total Amount</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody id="place_order">

								<tr>
									<input type="hidden" name="product_id[]" class="product_id" value="">

									<td class="col-md-3">
											<select class="form-control product_name" id="product_name" name="product_name[]" required>
													<option value="select product">select product</option>
													@forelse($products as $product)
													<option data-id="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-qty="{{ $product->quantity }}" data-pricebought="{{ $product->price_bought }}">{{ $product->product_name }}</option>
													@empty
													<option value='----'>----</option>
													@endforelse
											</select>
									</td>

									<td class="col-md-1">
												<input id="quantity" type="number" min="1" max="2147483647" class="form-control quantity" name="quantity[]" required readonly>
									</td>

									<td class="col-md-2">
												<input id="selling_price" type="number" class="form-control selling_price" name="selling_price[]" required readonly>
									</td>

									<td class="col-md-2">
												<input id="subtotal" type="number" class="form-control subtotal" name="subtotal[]" required readonly>
									</td>

									<td class="col-md-1">
												<input id="discount" type="number" min="0" max="100" class="form-control discount" name="discount[]" required readonly>
									</td>

									<td class="col-md-2">
												<input id="total_amount" type="text" class="form-control total_amount" name="total_amount[]" required readonly>
									</td>

									<input type="hidden" name="date_sold[]" value="{{ date('Y-m-d H:i:s') }}">
									<input type="hidden" class="price_bought" name="price_bought[]" value="">

									<td class="col-md-1">
										<small><input type="button" class="btn btn-danger delete" value="delete"></small>
									</td>
								</tr>

							</tbody>

							<tfoot>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="6">Total: <b class="total">0</b></th>
							</tfoot>
						</table>

						<input id="add" type="button" class="btn btn-primary" value="Add Item">

						<hr>

						<div class="form-group{{ $errors->has('cash_in') ? ' has-error' : '' }}">
              <label for="cash_in" class="col-md-4 control-label">Cash</label>

              <div class="col-md-4">
                <input id="cash_in" type="number" min="0" class="form-control" name="cash_in" value="" required autofocus>

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
                <input id="cash_out" type="text" class="form-control" name="cash_out" value="0.00" required autofocus readonly>

                @if ($errors->has('cash_out'))
                  <span class="help-block">
                    <strong>{{ $errors->first('cash_out') }}</strong>
                  </span>
                @endif
              </div>
            </div>

						<input id="submit" type="submit" class="btn btn-success pull-right" value="Done" disabled>
					</form>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Quick Tip
				</div>

				<div class="panel-body">
					<p>When you are <b>Done</b> with your orders, the system will automatically generate a receipt that you can print out. The order will be also saved in the <b>Orders Log</b>.</p>
					<p>Just click <b>Continue</b> on the pop-up window that will appear to create another order.</p>
					<hr>
				</div>
			</div>
		</div>

		<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" autofocus>
		  <div class="modal-dialog">

		    <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title">Place Order</h4>
		      </div>
		      <div class="modal-body">
		        <center>Your customer's order has been saved. Please continue.</center>
		      </div>
		      <div class="modal-footer">
						<a href="/orders/create" id="continue-link">Continue</a>
		      </div>
		    </div>

		  </div>
		</div>

	</div>
</div>

@endsection
