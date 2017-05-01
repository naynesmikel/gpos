<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<style>
			.panel{
			  font-size: 14px;
			  font-family: 'Roboto', sans-serif;
			  font-weight: 400;
			}
			.italic{
			  font-size: 10px;
			  font-family: 'Roboto', sans-serif;
			  font-weight: 400;
			  font-style:italic;

			}
			.qwerty{
			  font-size: 10px;
			  font-family: 'Roboto', sans-serif;
			  font-weight: 400;
			  margin-bottom:10px;
			  font-style:italic;

			}
			.qwerty1{
			  font-size: 10px;
			  font-family: 'Roboto', sans-serif;
			  font-weight: 600;
			  text-align:left;
			   margin-left:1in;
			}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel" style=" text-align:center;margin-top:50px;">
						<div class="panel-body">
								<div class="italic">
									<b>{{ $company{0}->company_name }}</b>
								</div>
								<div class="italic">
									<i>{{ $company{0}->company_slogan }}</i>
								</div>
								<div class="italic">
									{{ $company{0}->location }}
								</div>
								<div class="italic">
									{{ $company{0}->company_contact_number }}
								</div>
								<div class="italic">
									{{ $company{0}->company_email }}
								</div>
								<div class="italic">
									Issued by: {{ $user }}
								</div>
								<div class="italic" style="margin-bottom: 20px;">
									Date: {{ date('Y-m-d H:i:s') }}
								</div>

								<div>
									<table class="table table-bordered" style="text-align:center">
										<thead>
											<tr>
												<th class="text-center">Qty</th>
												<th class="text-center">Item</th>
												<th class="text-center">Total</th>
											</tr>
										</thead>

										<tbody>
											@for ($i = 0; $i < count($input['product_name']); $i++)
												<tr>
													<td> {{ $input['quantity'][$i] }} </td>
													<td> {{ $input['product_name'][$i] }} </td>
													<td> {{ $input['total_amount'][$i] }} </td>
												</tr>
											@endfor
											<tr>
												<td colspan="2"> TOTAL: </td>
												<td> {{ $total }} </td>
											</tr>
											<tr>
												<td colspan="2"> CASH TENDERED: </td>
												<td> {{ $input['cash_in'] }} </td>
											</tr>
											<tr>
												<td colspan="2"> CHANGE: </td>
												<td> {{ $input['cash_out'] }} </td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="qwerty" style="margin-top:20px">
									Thank you, please come again!
								</div>
								<div class="qwerty1">
									Customer Name: {{ $input['customer_name'] }}
								</div>
								<div class="qwerty1">
									Customer Address: {{ $input['location'] }}
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
