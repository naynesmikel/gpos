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

<div class="container">
	@include('flash::message')

	<div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

				<div class="panel-heading">
					Company Details
					@if(Auth::user()->admin)
					<span data-toggle="modal" data-target="#editcompany">
						<big><a href="#" data-toggle="tooltip" title="Edit Company Details" class="pull-right"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></big>
					</span>
					@endif
				</div>

				<div class="panel-body">
					<div class="row">
						<label for="company_name" class="col-md-3 control-label">Company Name</label>
						<div class="col-md-9">{{ $company{0}->company_name }}</div>
					</div>

					<div class="row">
						<label for="company_slogan" class="col-md-3 control-label">Company Slogan</label>
						<div class="col-md-9">{{ $company{0}->company_slogan }}</div>
					</div>

					<div class="row">
						<label for="location" class="col-md-3 control-label">Location</label>
						<div class="col-md-9">{{ $company{0}->location }}</div>
					</div>

					<div class="row">
						<label for="company_contact_number" class="col-md-3 control-label">Contact Number</label>
						<div class="col-md-9">{{ $company{0}->company_contact_number }}</div>
					</div>

					<div class="row">
						<label for="company_email" class="col-md-3 control-label">Email Address</label>
						<div class="col-md-9">{{ $company{0}->company_email }}</div>
					</div>

					<hr>

					<p>Monthly Fixed Cost</p>
					<div class="row">
						<label for="tax" class="col-md-3 control-label">Tax</label>
						<div class="col-md-9">{{ $company{0}->tax }}</div>
					</div>

					<div class="row">
						<label for="water_bill" class="col-md-3 control-label">Water Bill</label>
						<div class="col-md-9">{{ $company{0}->water_bill }}</div>
					</div>

					<div class="row">
						<label for="electric_bill" class="col-md-3 control-label">Electric Bill</label>
						<div class="col-md-9">{{ $company{0}->electric_bill }}</div>
					</div>

					<div class="row">
						<label for="rent" class="col-md-3 control-label">Rent</label>
						<div class="col-md-9">{{ $company{0}->rent }}</div>
					</div>

					<div class="row">
						<label for="labor" class="col-md-3 control-label">Labor</label>
						<div class="col-md-9">{{ $company{0}->labor }}</div>
					</div>
				</div>

				<div id="editcompany" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Edit Company</h4>
							</div>

							<div class="modal-body">
								@include('company/edit')
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
