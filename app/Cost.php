<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
  protected $fillable = [
      'month', 'year', 'tax', 'water_bill', 'electric_bill', 'rent', 'labor',
  ];

  public function setTax($value)
  {
    $this->attributes['tax'] = (float) number_format($value, 2, '.', '');
  }

  public function setWaterBill($value)
  {
    $this->attributes['water_bill'] = (float) number_format($value, 2, '.', '');
  }

  public function setElectricBill($value)
  {
    $this->attributes['electric_bill'] = (float) number_format($value, 2, '.', '');
  }

  public function setRent($value)
  {
    $this->attributes['rent'] = (float) number_format($value, 2, '.', '');
  }

  public function setLabor($value)
  {
    $this->attributes['labor'] = (float) number_format($value, 2, '.', '');
  }
}
