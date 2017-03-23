@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Total number of employees: {{ $users->total() }}</h3>
					<b>In this page, there are {{ $users->count() }} employees.</b>
				</div>
				
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Contact Number</th>
								<th>Birthday</th>
								<th>Email Address</th>
								<th>Employed on</th>
							</tr>
						</thead>
						
						<tbody>
							@forelse($users as $user)
								<tr>
									<td>{{$user->name}}</td>
									<td>{{$user->contact_number}}</td>
									<td>{{$user->birthday}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->created_at}}</td>
								</tr>
							@empty
								No employees yet
							@endforelse
						</tbody>
					</table>
				</div>
				
				<div class="row">
					<div class="col-md-12 col-md-offset-3">
						{{$users->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
