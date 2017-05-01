@extends('layouts.app')

@section('content')
<div class="container">
	@include('flash::message')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Total number of employees: {{ $users->total() }}</h3>
				</div>

				@if(!$users->isEmpty())
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Contact Number</th>
								<th>Birthday</th>
								<th>Email Address</th>
								<th>Employed on</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{$user->name}}</td>
									<td>{{$user->contact_number}}</td>
									<td>{{$user->birthday->toFormattedDateString()}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->created_at->toFormattedDateString()}}</td>
									<td>
										<form action="/users/{{ $user->id }}" method="POST" class="pull-right actions">
											{{ csrf_field() }}

											{{ method_field('DELETE') }}
											<small><button class="btn btn-danger btn-sm actions">delete</button></small>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-md-12 col-md-offset-3">
						{{$users->links()}}
					</div>
				</div>
				@else
				<div class="panel-body">
					<div class="panel-body">
						You have no employees.
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
