<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
		    'name', 'price_bought', 'product_name', 'quantity', 'selling_price', 'subtotal', 'discount', 'total_amount', 'date_sold',
    ];

    protected $dates = [
		    'date_sold',
    ];

    public function setNameAttribute($value)
    {
      $this->attributes['name'] = ucwords($value);
    }

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

    public function setSubtotalAttribute($value)
    {
      $this->attributes['subtotal'] = (float) number_format($value, 2, '.', '');
    }

    public function setDiscountAttribute($value)
    {
      $this->attributes['discount'] = (float) number_format($value, 2, '.', '');
    }

    public function setTotalAmountAttribute($value)
    {
      $this->attributes['total_amount'] = (float) number_format($value, 2, '.', '');
    }
}
