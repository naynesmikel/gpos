<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    protected $fillable = [
      'barcode', 'product_name', 'quantity', 'date_bought', 'price_bought', 'selling_price', 'supplier',
    ];

    protected $dates = [
      'date_bought',
    ];

    public function setProductNameAttribute($value)
    {
      $this->attributes['product_name'] = ucwords($value);
    }

    public function setPriceBoughtAttribute($value)
    {
      $this->attributes['price_bought'] = (float) number_format($value, 2, '.', '');
    }

    public function setSellingPriceAttribute($value)
    {
      $this->attributes['selling_price'] = (float) number_format($value, 2, '.', '');
    }

    public function setSupplierAttribute($value)
    {
      $this->attributes['supplier'] = ucwords($value);
    }
}
