<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
		'user_id', 'product_name', 'quantity', 'selling_price', 'discount', 'total_amount'
    ];
    
    public function setProductNameAttribute($value)
    {
		$this->attributes['product_name'] = ucwords($value);
    }
    
    public function setSellingPriceAttribute($value)
    {
		$this->attributes['selling_price'] = (float)(number_format($value, 2, '.', ' '));
    }
    
    public function setDiscountAttribute($value)
    {
		$this->attributes['discount'] = (float)(number_format($value, 2, '.', ' '));
    }
    
    public function setTotalAmountAttribute($value)
    {
		$this->attributes['total_amount'] = (float)(number_format($value, 2, '.', ' '));
    }
}
