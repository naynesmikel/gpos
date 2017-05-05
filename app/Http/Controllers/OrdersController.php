<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\Company;
use Auth;
use PDF;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use File;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('date_sold', 'DESC')->paginate(20);
        $productlink = "/orders/byproductname";
        $quantitylink = "/orders/byquantity";
        $sellingpricelink = "/orders/bysellingprice";
        $subtotallink = "/orders/bysubtotal";
        $discountlink = "/orders/bydiscount";
        $totalamountlink = "/orders/bytotalamount";
        $datesoldlink = "/orders/bydatesold";
        $soldbylink = "/orders/bysoldby";

        return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		    $products = Product::all()->sortBy('product_name');

        return view('orders.create')->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();
    		$cust_name = Input::get('customer_name');
    		$company = Company::all();
    		$user = Auth::user()->name;
        $total = 0;

        for($i = 0; $i < count($input['product_name']); $i++){
      			$order = new Order;
      			$order->name = Auth::user()->name;
            $order->price_bought = $input['price_bought'][$i];
      			$order->product_name = $input['product_name'][$i];
      			$order->quantity = $input['quantity'][$i];
      			$order->selling_price = $input['selling_price'][$i];
            $order->subtotal = $input['subtotal'][$i];
      			$order->discount = $input['discount'][$i];
      			$order->total_amount = $input['total_amount'][$i];
      			$order->date_sold = $input['date_sold'][$i];
      			$order->save();
      			$total += $input['total_amount'][$i];

      			$product = Product::findOrFail($input['product_id'][$i]);
      			$product->quantity = $product->quantity - $input['quantity'][$i];
      			$product->save();

      			if($product->quantity == 0){
              flash('Item ' . strtoupper($product->product_name) . ' is now out of stock! Item ' . strtoupper($product->product_name) . ' has been removed from the inventory.', 'warning');
      			  $product->delete();
            }
    		}

        $pdf = PDF::loadView('orders.generateReceipt', compact(['input', 'total', 'user', 'company']));

        return $pdf->download(date('Y-m-d H:i:s').'_'.$cust_name.'.pdf');
    }

    public function byproductname()
    {
      $orders = Order::orderBy('product_name', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function byproductnamedesc()
    {
      $orders = Order::orderBy('product_name', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function byquantity()
    {
      $orders = Order::orderBy('quantity', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function byquantitydesc()
    {
      $orders = Order::orderBy('quantity', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bysellingprice()
    {
      $orders = Order::orderBy('selling_price', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bysellingpricedesc()
    {
      $orders = Order::orderBy('selling_price', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }


    public function bysubtotal()
    {
      $orders = Order::orderBy('subtotal', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bysubtotaldesc()
    {
      $orders = Order::orderBy('subtotal', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bytotalamount()
    {
      $orders = Order::orderBy('total_amount', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bytotalamountdesc()
    {
      $orders = Order::orderBy('total_amount', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bydiscount()
    {
      $orders = Order::orderBy('discount', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bydiscountdesc()
    {
      $orders = Order::orderBy('discount', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bydatesold()
    {
      $orders = Order::orderBy('date_sold', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bydatesolddesc()
    {
      $orders = Order::orderBy('date_sold', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bysoldby()
    {
      $orders = Order::orderBy('name', 'ASC')->paginate(20);
      $productlink = "/orders/byproductnamedesc";
      $quantitylink = "/orders/byquantitydesc";
      $sellingpricelink = "/orders/bysellingpricedesc";
      $subtotallink = "/orders/bysubtotaldesc";
      $discountlink = "/orders/bydiscountdesc";
      $totalamountlink = "/orders/bytotalamountdesc";
      $datesoldlink = "/orders/bydatesolddesc";
      $soldbylink = "/orders/bysoldbydesc";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    public function bysoldbydesc()
    {
      $orders = Order::orderBy('name', 'DESC')->paginate(20);
      $productlink = "/orders/byproductname";
      $quantitylink = "/orders/byquantity";
      $sellingpricelink = "/orders/bysellingprice";
      $subtotallink = "/orders/bysubtotal";
      $discountlink = "/orders/bydiscount";
      $totalamountlink = "/orders/bytotalamount";
      $datesoldlink = "/orders/bydatesold";
      $soldbylink = "/orders/bysoldby";

      return view('orders.index', compact(['orders', 'productlink', 'quantitylink', 'sellingpricelink', 'subtotallink', 'discountlink', 'totalamountlink', 'datesoldlink', 'soldbylink']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $order = Order::findOrFail($id);
      $product_name = $order->product_name;
      $quantity = $order->quantity;
      $date = $order->date_sold;

      $order->delete();

      flash($quantity . ' ' . strtoupper($product_name) . ' that has been sold on ' . $date . ' is now removed from the database!', 'success');

      return redirect('/orders');
    }
}
