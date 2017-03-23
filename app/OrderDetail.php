<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
		'order_id', 'product_name', 'quantity', 'selling_price', 'discount', 'total_amount'
    ];
    
}
