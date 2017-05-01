@extends('layouts.app')

@section('content')
<style>
p {
    text-indent: 50px;
    align: justify;
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
            I'm Michael, the creator of GPOS. First of all, I want to thank you for being one of the testers of this system. It really means a lot. Second, you are now using a beta version of a Generic Point of Sale System or GPOS. GPOS is a system that monitors your business to know if it is going good or bad.
          </p>
          <p>
            You can start by checking your profile. You can edit your profile by clicking the icon on the upperright corner whenever you please. Below your profile is your company details. Note that the information in their is temporary so I suggest that you change it right away according to what your business is all about.
          </p>

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
                <li>Manage Inventory</li>
                <p>
                  This function monitors what's inside in your inventory and your can also add more items in a current product.
                </p>
                <li>Add Product</li>
                <p>
                  Add Product lets you add a new product to your inventory. It can notify you if you are adding an existing product in the inventory.
                </p>
                <li>Employees</li>
                <p>
                  This shows you who your employees are. Note that employees can only access the Place Order function so that information about the business can only be in the owner's side.
                </p>
                <li>Orders Log</li>
                <p>
                  Orders Log displays all orders that have been made in your business. It is automatically organized from the most recent to the oldest order made.
                </p>
                <li>Sales Report</li>
                <p>
                  This is where all the information about your business becomes meaningful because it arranges all the data in days, weeks, months, and years so that you can easily monitor the performance of the business.
                </p>
                <li>Place Order</li>
                <p>
                  Place Order is a function where you can input the orders that customer makes. This will generate a receipt after the order is complete and will be automatically saved in the Order Logs.
                </p>
              </ul>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
