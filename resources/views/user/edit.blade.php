@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					Edit Profile
				</div>

				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/profile/{{ $user->username }}">
						{{ method_field('PUT') }}

						{{ csrf_field() }}

            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
              <label for="username" class="col-md-4 control-label">Username</label>
              <div class="col-md-6">
                <input id="username" type="text" class="form-control" name="username" value="{{ $user->username }}" required autofocus>
                @if ($errors->has('username'))
                  <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                  </span>
                @endif
              </div>
            </div>

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Name</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">Email</label>
              <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" required autofocus>
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                <label for="contact_number" class="col-md-4 control-label">Contact Number</label>

                <div class="col-md-6">
                    <input id="contact_number" type="text" class="form-control" name="contact_number" value="{{ $user->contact_number }}" required autofocus>

                    @if ($errors->has('contact_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contact_number') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
              <label for="birthday" class="col-md-4 control-label">Birthday</label>
              <div class="col-md-6">
                <input id="birthday" type="date" class="form-control" name="birthday" value="{{ $user->birthday->format('Y-m-d') }}" required autofocus>
                @if ($errors->has('birthday'))
                  <span class="help-block">
                    <strong>{{ $errors->first('birthday') }}</strong>
                  </span>
                @endif
              </div>
            </div>

						<input type="submit" class="btn btn-success pull-right" onclick="notify();">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
