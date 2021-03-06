@extends('layouts.app')

@section('content')
<style>
p {
  text-indent: 30px;
  text-align: justify;
}

ul {
  list-style-type: none;
  padding-left:0;
}

a {
  color: #009587;
}

.panel-body {
  padding: 30px;
}
</style>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
					<h1> Welcome, {{ $auth->name }}!</h1>
          <p>
            The Generic Point of Sale (GPOS) System is a system that monitors the business' inventory and reports all of its accountables. It can also handle customer's orders in which it can generate a receipt that contains all items purchased.
          </p>
          <p>
            Please start by checking your profile. It can be edited by clicking the icon on the upper right corner. Below the profile button is the company profile button. Note, for first time users, that the information in there is temporary so it is highly recommended to change it according to what your company is all about. Same with editing the user's profile, there is also an edit button on the upper right corner to change your company's information.
          </p>
          <p>
            If you feel you have explored the whole system, please answer the survey below by clicking the icon. This survey will determine how useful the GPOS system is.
          </p>
          <hr>
          <center>
            <a href="https://goo.gl/forms/nt7zxtWNvS4fEijj1" target="_blank"><span  style="font-size: 150px;" class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
            <h6 style="text-align: center;">System Usability Test</h6>
          </center>
          <br>
          <center><small><strong>WARNING!</strong><br>Please make sure that you are using <strong>Google Chrome</strong> as your browser. Some functions may not work in other web browsers.</small></center>

        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          Functionalities of the GPOS
        </div>
        <div class="panel-body">
          <ul>
            @if(Auth::user()->admin)
            <li><strong>Employees</strong></li>
            <p>
              In this page, a table of employees will be shown with all their information that they provided. Also, you can delete accounts of employees here.
            </p>
            @endif
            <li><strong>Inventory</strong></li>
            <p>
              This page helps you monitor and manage your inventory. This is also where you can save all your transactions when you sell products. After saving, a receipt will be genarated and will be automatically download into your device.
            </p>
            <li><strong>Orders Log</strong></li>
            <p>
              Orders Log displays all orders that have been made in your business. It is automatically organized from the most recent to the oldest order made.
            </p>
            @if(Auth::user()->admin)
            <li><strong>Sales Report</strong></li>
            <p>
              This is where all the information about your business becomes meaningful. It arranges all the data in days, weeks, months, and years so that you can easily monitor the performance of the business.
            </p>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
