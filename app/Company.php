<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
		protected $table = 'company';

    protected $fillable = [
			'company_name', 'company_slogan', 'location', 'company_contact_number', 'company_email', 'tax', 'water_bill', 'electric_bill', 'rent', 'labor',
    ];

    public function setCompanySlogan()
    {
			$this->attributes['company_slogan'] = ucfirst($value);
    }

    public function setLocation()
    {
			$this->attributes['location'] = ucwords($value);
    }

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
