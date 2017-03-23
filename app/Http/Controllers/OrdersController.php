<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$products = Product::all();
		
        return view('orders.create')
			->with('products', $products);
    }
    
    /*public function changeValues(Request $request){
		if ( !empty( $request->input( 'selling_price' ) ) ) {

			$selling_price = $request->input( 'selling_price' );
			$selling_price = preg_replace( '/\s+/m', ',', $emails );
			$emails = explode( ',', $emails );

			// THIS IS KEY!
			// Replacing the old input string with
			// with an array of emails.
			$request->merge( array( 'emails' => $emails ) );
		}
	}*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Order::create($request->all());
        
        /*$products = Product::all();
        $orderdetails = OrderDetail::where('order_id', $order->id)->get();
		$orderby = Order::where('id', $order->id)->get();
		return view('orders.index')->with('orders', $orderdetails)->with('products', $products)->with('orderby', $orderby);
		
		for($i = 0; $i < $request->counter; $i++){
			$order = new Order;
			$order->user_id = Auth::user()->id;
			$order->product_name = $request->product_name;
			$order->
		}*/
        
        flash('Your order has been saved in the database!', 'success');
        
        return redirect('/orders/create');
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
        //
    }
}
