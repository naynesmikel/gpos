<form class="form-horizontal" role="form" method="POST" action="/company/{{ $company{0}->id }}">
	{{ method_field('PUT') }}

	{{ csrf_field() }}

	<div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
    <label for="company_name" class="col-md-4 control-label">Company Name</label>
    <div class="col-md-6">
      <input id="company_name" type="text" class="form-control" name="company_name" value="{{ $company{0}->company_name }}" required autofocus>
      @if ($errors->has('company_name'))
        <span class="help-block">
          <strong>{{ $errors->first('company_name') }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('company_slogan') ? ' has-error' : '' }}">
    <label for="company_slogan" class="col-md-4 control-label">Company Slogan</label>
    <div class="col-md-6">
      <textarea cols="40" rows="5" id="company_slogan" type="text" class="form-control" name="company_slogan" value="{{ $company{0}->company_slogan }}" autofocus>{{ $company{0}->company_slogan }}</textarea>
			<center><small style="color: gray;"><i>Optional</i></small></center>
      @if ($errors->has('company_slogan'))
        <span class="help-block">
          <strong>{{ $errors->first('company_slogan') }}</strong>
        </span>
      @endif
    </div>
  </div>

 <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
    <label for="location" class="col-md-4 control-label">Location</label>
    <div class="col-md-6">
      <textarea cols="40" rows="3" id="location" type="text" class="form-control" name="location" value="{{ $company{0}->location }}" required autofocus>{{ $company{0}->location }}</textarea>

      @if ($errors->has('location'))
        <span class="help-block">
          <strong>{{ $errors->first('location') }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('company_contact_number') ? ' has-error' : '' }}">
      <label for="company_contact_number" class="col-md-4 control-label">Contact Number</label>

      <div class="col-md-6">
          <input id="company_contact_number" type="text" class="form-control" name="company_contact_number" value="{{ $company{0}->company_contact_number }}" required autofocus>

          @if ($errors->has('company_contact_number'))
              <span class="help-block">
                  <strong>{{ $errors->first('company_contact_number') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="form-group{{ $errors->has('company_email') ? ' has-error' : '' }}">
    <label for="company_email" class="col-md-4 control-label">Company Email</label>
    <div class="col-md-6">
      <input id="company_email" type="text" class="form-control" name="company_email" value="{{ $company{0}->company_email }}" required autofocus>
      @if ($errors->has('company_email'))
        <span class="help-block">
          <strong>{{ $errors->first('company_email') }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('water_bill') ? ' has-error' : '' }}">
    <label for="water_bill" class="col-md-4 control-label">Water Bill</label>
    <div class="col-md-6">
      <input id="water_bill" type="number" min="0" max="999999" step="any" class="form-control" name="water_bill" value="{{ $company{0}->water_bill }}" required autofocus>
      @if ($errors->has('water_bill'))
        <span class="help-block">
          <strong>{{ $errors->first('water_bill') }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('electric_bill') ? ' has-error' : '' }}">
    <label for="electric_bill" class="col-md-4 control-label">Electric Bill</label>
    <div class="col-md-6">
      <input id="electric_bill" type="number" min="0" max="999999" step="any" class="form-control" name="electric_bill" value="{{ $company{0}->electric_bill }}" required autofocus>
      @if ($errors->has('electric_bill'))
        <span class="help-block">
            <strong>{{ $errors->first('electric_bill') }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('rent') ? ' has-error' : '' }}">
    <label for="rent" class="col-md-4 control-label">Rent</label>
    <div class="col-md-6">
      <input id="rent" type="number" min="0" max="999999" step="any" class="form-control" name="rent" value="{{ $company{0}->rent }}" required autofocus>
      @if ($errors->has('rent'))
        <span class="help-block">
          <strong>{{ $errors->first('rent') }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="form-group{{ $errors->has('labor') ? ' has-error' : '' }}">
    <label for="labor" class="col-md-4 control-label">Labor</label>
    <div class="col-md-6">
      <input id="labor" type="number" min="0" max="999999" step="any" class="form-control" name="labor" value="{{ $company{0}->labor }}" required autofocus>
      @if ($errors->has('labor'))
        <span class="help-block">
          <strong>{{ $errors->first('labor') }}</strong>
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
