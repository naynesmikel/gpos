<form class="form-horizontal" role="form" method="POST" action="/profile/{{ $user->username }}">
	{{ method_field('PUT') }}

	{{ csrf_field() }}

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
      <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required autofocus>
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

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<input type="submit" class="btn btn-success pull-right" onclick="notify();">
		</div>
	</div>

</form>
