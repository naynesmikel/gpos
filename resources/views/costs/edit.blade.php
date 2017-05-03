<form class="form-horizontal" role="form" method="POST" action="/costs/{{ $cost->id }}">
	{{ method_field('PUT') }}

	{{ csrf_field() }}

	<div class="form-group{{ $errors->has('water_bill') ? ' has-error' : '' }}">
    <label for="water_bill" class="col-md-4 control-label">Water Bill</label>
    <div class="col-md-6">
      <input id="water_bill" type="number" min="0" max="999999" step="any" class="form-control" name="water_bill" value="{{ $cost->water_bill }}" required autofocus>
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
      <input id="electric_bill" type="number" min="0" max="999999" step="any" class="form-control" name="electric_bill" value="{{ $cost->electric_bill }}" required autofocus>
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
      <input id="rent" type="number" min="0" max="999999" step="any" class="form-control" name="rent" value="{{ $cost->rent }}" required autofocus>
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
      <input id="labor" type="number" min="0" max="999999" step="any" class="form-control" name="labor" value="{{ $cost->labor }}" required autofocus>
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
