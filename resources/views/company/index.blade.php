@extends('layouts.app')

@section('content')
<div class="container">
	@include('flash::message')

	<div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

				<div class="panel-heading">
					Company Details
					@if(Auth::user()->admin)
					<big><a href="/company/1/edit" data-toggle="tooltip" title="Edit Company Details" class="pull-right"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></big>
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

			</div>
		</div>
	</div>
</div>
@endsection