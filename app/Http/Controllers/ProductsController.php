<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;
use PDF;
use DB;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    public function index()
    {
      $products = Product::orderBy('product_name', 'ASC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function create()
    {
      return view('products.create');
    }

    public function store(Request $request)
    {
      $product = new Product;
      $barstring = $request->barcode;

      while(DB::table('products')->where('barcode', '=', $barstring)->count() >= 1){
        $barstring = Math.floor(Math.random() * 8999999 + 1000000);
      }

      if(DB::table('products')->where('product_name', $request->product_name)->count() > 0){
        flash(strtoupper($request->product_name) . ' already exists in your database', 'danger');
        return redirect('/products');
      }

      $product->barcode = $barstring;
      $product->product_name = $request->product_name;
      $product->quantity = $request->quantity;
      $product->date_bought = $request->date_bought;
      $product->price_bought = $request->price_bought;
      $product->selling_price = $request->selling_price;
      $product->supplier = $request->supplier;
      $product->save();

      flash(strtoupper($product->product_name) . ' has been saved in the database!', 'success');

      return redirect('/products');
    }

    public function show($id)
    {
  		$product = Product::findOrFail($id);

  		return view('products.show', compact('product'));
    }

    public function edit($id)
    {
	    $product = Product::findOrFail($id);

      return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
      $product = Product::findOrFail($id);

      $product->update($request->all());

      flash('Edit has been saved in the database!', 'success');

      return redirect('/products');
    }

    public function destroy($id)
    {
      $product = Product::findOrFail($id);
      $product_name = $product->product_name;

      $product->delete();

      flash(strtoupper($product_name) . ' has been deleted in the database!', 'success');

      return redirect('/products');
    }

    public function createBarcode()
	  {
  		$products = Product::orderBy('product_name', 'ASC')->get();

  		return view('products.createBarcode', compact('products'));
    }

  	public function generateBarcodePDF(Request $request)
  	{
      $input = Input::all();
      $productNames = [];

  		for($i=0; $i<count($input['generate']); $i++)
      {
  			$productNames[$i] = DB::table('products')->where('barcode', '=', $input['generate'][$i])->pluck('product_name');
  		}

  		$pdf = PDF::loadView('products.generateBarcode', compact(['input', 'productNames']));
  		return $pdf->download(date('Y-m-d H:i:s').'_barcodes.pdf');
  	}

    public function additem(Request $request)
    {
      $input = Input::all();
      $product = Product::findOrFail($input['product_id']);
      $product->quantity = $product->quantity + $input['quantity'];
      $product->save();

      flash("Quantity of ".strtoupper($product->product_name)." has been updated", 'success');

      return redirect('/products');
    }

    public function byproductname()
    {
      $products = Product::orderBy('product_name', 'ASC')->paginate(20);
      $productlink = "/products/byproductnamedesc";
      $quantitylink = "/products/byquantitydesc";
      $priceboughtlink = "/products/bypriceboughtdesc";
      $sellingpricelink = "/products/bysellingpricedesc";
      $supplierlink = "/products/bysupplierdesc";
      $dateboughtlink = "/products/bydateboughtdesc";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function byproductnamedesc()
    {
      $products = Product::orderBy('product_name', 'DESC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function byquantity()
    {
      $products = Product::orderBy('quantity', 'ASC')->paginate(20);
      $productlink = "/products/byproductnamedesc";
      $quantitylink = "/products/byquantitydesc";
      $priceboughtlink = "/products/bypriceboughtdesc";
      $sellingpricelink = "/products/bysellingpricedesc";
      $supplierlink = "/products/bysupplierdesc";
      $dateboughtlink = "/products/bydateboughtdesc";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function byquantitydesc()
    {
      $products = Product::orderBy('quantity', 'DESC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bydatebought()
    {
      $products = Product::orderBy('date_bought', 'ASC')->paginate(20);
      $productlink = "/products/byproductnamedesc";
      $quantitylink = "/products/byquantitydesc";
      $priceboughtlink = "/products/bypriceboughtdesc";
      $sellingpricelink = "/products/bysellingpricedesc";
      $supplierlink = "/products/bysupplierdesc";
      $dateboughtlink = "/products/bydateboughtdesc";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bydateboughtdesc()
    {
      $products = Product::orderBy('date_bought', 'DESC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }


    public function bypricebought()
    {
      $products = Product::orderBy('price_bought', 'ASC')->paginate(20);
      $productlink = "/products/byproductnamedesc";
      $quantitylink = "/products/byquantitydesc";
      $priceboughtlink = "/products/bypriceboughtdesc";
      $sellingpricelink = "/products/bysellingpricedesc";
      $supplierlink = "/products/bysupplierdesc";
      $dateboughtlink = "/products/bydateboughtdesc";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bypriceboughtdesc()
    {
      $products = Product::orderBy('price_bought', 'DESC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bysellingprice()
    {
      $products = Product::orderBy('selling_price', 'ASC')->paginate(20);
      $productlink = "/products/byproductnamedesc";
      $quantitylink = "/products/byquantitydesc";
      $priceboughtlink = "/products/bypriceboughtdesc";
      $sellingpricelink = "/products/bysellingpricedesc";
      $supplierlink = "/products/bysupplierdesc";
      $dateboughtlink = "/products/bydateboughtdesc";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bysellingpricedesc()
    {
      $products = Product::orderBy('selling_price', 'DESC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bysupplier()
    {
      $products = Product::orderBy('supplier', 'ASC')->paginate(20);
      $productlink = "/products/byproductnamedesc";
      $quantitylink = "/products/byquantitydesc";
      $priceboughtlink = "/products/bypriceboughtdesc";
      $sellingpricelink = "/products/bysellingpricedesc";
      $supplierlink = "/products/bysupplierdesc";
      $dateboughtlink = "/products/bydateboughtdesc";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }

    public function bysupplierdesc()
    {
      $products = Product::orderBy('supplier', 'DESC')->paginate(20);
      $productlink = "/products/byproductname";
      $quantitylink = "/products/byquantity";
      $priceboughtlink = "/products/bypricebought";
      $sellingpricelink = "/products/bysellingprice";
      $supplierlink = "/products/bysupplier";
      $dateboughtlink = "/products/bydatebought";
      $productqty = Product::orderBy('product_name', 'ASC')->get();

      return view('products.index', compact(['products', 'productlink', 'quantitylink', 'priceboughtlink', 'sellingpricelink', 'supplierlink', 'dateboughtlink', 'productqty']));
    }
}
