@extends('layouts.app')

@section('content')
<div class="container">
  @include('flash::message')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-body text-center">
          <span data-toggle="modal" data-target="#editprofile">
						<big><a href="#" data-toggle="tooltip" title="Edit Profile" class="actions pull-right"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></big>
					</span>
          <br>
          <br>
          <center>
            <img src="http://www.freeiconspng.com/uploads/profile-icon-28.png" alt="image profile">
          </center>
          <h3>
            @if($user->admin)
              Owner
            @else
              Employee
            @endif
          </h3>
          <h4>{{ $user->name }}</h4>
          <h4>{{ $user->birthday->age }} years old</h4>
          <h4>{{ $user->email }}</h4>
          <h4>{{ $user->contact_number }}</h4>
          <h4>{{ $user->birthday->toFormattedDateString() }}</h4>
        </div>

        <div id="editprofile" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Edit Profile</h4>
							</div>

							<div class="modal-body">
								@include('user/edit')
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
