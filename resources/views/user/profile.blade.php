@extends('layouts.app')

@section('content')
<div class="container">
  @include('flash::message')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-body text-center">
          <big><a href="/profile/{{$user->username}}/edit" data-toggle="tooltip" title="Edit Profile" class="actions pull-right"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></big>
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
      </div>
    </div>
  </div>
</div>
@endsection
