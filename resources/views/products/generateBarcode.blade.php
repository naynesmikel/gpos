<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<table>
						<tbody>
							@for ($i = 0; $i < count($input['generate']); $i++)
								@if($i == 0 || $i % 4 == 0)
									<tr>
								@endif

								<td>
									<figure style="margin: 10px; position:relative;">
										<img src="data:image/png;base64, {{DNS1D::getBarcodePNG($input['generate'][$i], 'EAN8')}}" alt="barcode"/>
										<figcaption>{{ $productNames[$i][0] }}</figcaption>
									</figure>
								</td>

								@if(($i + 1) % 4 == 0)
									</tr>
								@endif
							@endfor
						</tbody>
					</table>
				</div>
			</div>
	</div>


		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
