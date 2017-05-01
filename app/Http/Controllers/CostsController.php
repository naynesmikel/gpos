<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Company;
use App\Cost;
use PDF;
use DB;
use Carbon\Carbon;
use Charts;

class CostsController extends Controller
{
  function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo $output . "\n";
  }

  function getMonthName($month){
    if($month == 1)
        return "Jan";
    else if($month == 2){
        return "Feb";
    }else if($month == 3){
        return "Mar";
    }else if($month == 4){
        return "Apr";
    }else if($month == 5){
        return "May";
    }else if($month == 6){
        return "Jun";
    }else if($month == 7){
        return "Jul";
    }else if($month == 8){
        return "Aug";
    }else if($month == 9){
        return "Sep";
    }else if($month == 10){
        return "Oct";
    }else if($month == 11){
        return "Nov";
    }else if($month == 12){
        return "Dec";
    }
  }

    public function index()
    {
      $orders = Order::orderBy('date_sold', 'ASC')->get();
      $costs = Cost::orderBy('year', 'month', 'ASC')->get();
      $company = Company::all();

      //creates an array for the years
      $years = [];
      foreach ($orders as $order) {
        if (!in_array($order->date_sold->year, $years)) {
          $years[] = $order->date_sold->year;
        }
      }

      //creates a table of sales prior to a date
      $salesperyear = [];
      foreach ($years as $year) {
        $salesperyear[] = DB::table('orders')
          ->select(DB::raw('DATE(date_sold) as date_sold'), DB::raw('SUM(total_amount) as total_amount'))
          ->distinct()
          ->whereYear('date_sold', $year)
          ->groupBy(DB::raw('DATE(orders.date_sold)'))->get();
      }

      //creates a table of unique months and year
      $yearmonth = DB::table('orders')
        ->select(DB::raw("DATE_FORMAT(date_sold, '%Y') as date_year"), DB::raw("DATE_FORMAT(date_sold, '%m') as date_month"))
        ->groupBy(DB::raw("DATE_FORMAT(date_sold, '%Y')"), DB::raw("DATE_FORMAT(date_sold, '%m')"))->get();

      //creates a table of unique months and year separated by year
      $splityearmonth = [];
      foreach ($years as $year) {
        $table = DB::table('orders')
          ->select(DB::raw("DATE_FORMAT(date_sold, '%Y') as date_year"), DB::raw("DATE_FORMAT(date_sold, '%m') as date_month"))
          ->whereYear('date_sold', $year)
          ->groupBy(DB::raw("DATE_FORMAT(date_sold, '%Y')"), DB::raw("DATE_FORMAT(date_sold, '%m')"))->get();
        $splityearmonth[] = json_decode($table, true);
      }

      //creates the label for the charts that show data per month
      $splityearmonthlabels = [];
      foreach($splityearmonth as $table){
        $list = [];
        foreach($table as $tab){
          $list[] = $this->getMonthName($tab['date_month'])." ".$tab['date_year'];
        }
        $splityearmonthlabels[] = $list;
      }

      //creates the fixed costs if cost in a month does not exist
      foreach($yearmonth as $ym){
        $flag = 0;
        foreach($costs as $cost){
          if($ym->date_year == $cost->year){
            if($ym->date_month ==  $cost->month){
              $flag = 1;
              break;
            }
          }
        }
        if(!$flag){
          $cost = new Cost;
          $cost->month = $ym->date_month;
          $cost->year = $ym->date_year;
          $cost->tax = $company{0}->tax;
          $cost->water_bill = $company{0}->water_bill;
          $cost->electric_bill = $company{0}->electric_bill;
          $cost->rent = $company{0}->rent;
          $cost->labor = $company{0}->labor;
          $cost->save();
        }
      }
      $costs = Cost::orderBy('year', 'month', 'ASC')->get();

      //creates an array of dates in a week within an array that is sorted by month and year
      $permonth;
      $id = 0;
      foreach ($yearmonth as $ym) {
        $week1 = [];
        $week2 = [];
        $week3 = [];
        $week4 = [];
        $week5 = [];
        foreach ($orders as $order) {
          if ($order->date_sold->year == $ym->date_year && $order->date_sold->month == $ym->date_month) {
            if ($order->date_sold->weekOfMonth == 1) {
              if ($week1 != []) {
                if (end($week1)->toDateString() != $order->date_sold->toDateString()) {
                  $week1[] = $order->date_sold;
                }
              } else {
                $week1[] = $order->date_sold;
              }
            } elseif ($order->date_sold->weekOfMonth == 2) {
              if ($week2 != []) {
                if (end($week2)->toDateString() != $order->date_sold->toDateString()) {
                  $week2[] = $order->date_sold;
                }
              } else {
                $week2[] = $order->date_sold;
              }
            } elseif ($order->date_sold->weekOfMonth == 3) {
              if ($week3 != []) {
                if (end($week3)->toDateString() != $order->date_sold->toDateString()) {
                  $week3[] = $order->date_sold;
                }
              } else {
                $week3[] = $order->date_sold;
              }
            } elseif ($order->date_sold->weekOfMonth == 4) {
              if ($week4 != []) {
                if (end($week4)->toDateString() != $order->date_sold->toDateString()) {
                  $week4[] = $order->date_sold;
                }
              } else {
                $week4[] = $order->date_sold;
              }
            } elseif ($order->date_sold->weekOfMonth == 5) {
              if ($week5 != []) {
                if (end($week5)->toDateString() != $order->date_sold->toDateString()) {
                  $week5[] = $order->date_sold;
                }
              } else {
                $week5[] = $order->date_sold;
              }
            }
          }
        }
        $permonth[] = [
          $id++ => $week1,
          $id++ => $week2,
          $id++ => $week3,
          $id++ => $week4,
          $id++ => $week5
        ];
      }

      //creates an array of quantity prior to product and date
      $productcountperday = DB::table('orders')
        ->select(DB::raw('DATE(date_sold) as date_sold'), 'product_name', DB::raw('SUM(quantity) as quantity'))
        ->distinct()
        ->groupBy(DB::raw('DATE(orders.date_sold)'), 'product_name')->get();
      $productcountperday = json_decode($productcountperday, true);

      //creates a table that groups the data by date_sold and corresponding product_name and adding their quantity and total_amount
      $groupedtable = DB::table('orders')
        ->select('price_bought', DB::raw('DATE(date_sold) as date_sold'), 'product_name', DB::raw('SUM(quantity) as quantity'), 'selling_price', DB::raw('SUM(subtotal) as subtotal'), 'discount', DB::raw('SUM(total_amount) as total_amount'))
        ->distinct()
        ->groupBy(DB::raw('DATE(orders.date_sold)'), 'product_name', 'selling_price', 'discount', 'price_bought')->get();

      $decodedgroupedtable = json_decode($groupedtable, true);
      $decodedyearmonth = json_decode($yearmonth, true);

      $grossincomeperday = [];
      $grossdaytemp = [];
      $revenueperdayinweek = [];
      $revenueperdayinweektemp = [];
      $grossincomeperdayinweek = [];
      $grossincomeperdayinweektemp = [];
      $perdayinweeklabel = [];
      $perdayinweeklabeltemp = [];
      $perweeklabel = [];
      $revenueperweek = [];
      $grossincomeperweek = [];
      $revenueperweekinyear = [];
      $revtemp = [];
      $grossincomeperweekinyear = [];
      $grosstemp = [];
      $perweeklabelinyear = [];
      $labeltemp = [];
      $revenueperdayinmonth = [];
      $revenueperdayinmonthtemp = [];
      $grossincomeperdayinmonth = [];
      $grossincomeperdayinmonthtemp = [];
      $perdayinmonthlabel = [];
      $perdayinmonthlabeltemp = [];
      $j = 0;
      $curryear = $years[$j];
      $weekyear = $years[$j];
      foreach($permonth as $month){
        $weekcount = 1;

        foreach($month as $week){
          if($week != []){
            $weeklyrevenue = 0;
            $weeklycost = 0;
            $weekyear = $week[0]->year;

            if($weekyear != $curryear){
              $revenueperweekinyear[] = $revtemp;
              $grossincomeperweekinyear[] = $grosstemp;
              $perweeklabelinyear[] = $labeltemp;
              $grossincomeperday[] = $grossdaytemp;
              $revtemp = [];
              $grosstemp = [];
              $labeltemp = [];
              $grossdaytemp = [];
              $curryear = $years[$j+1];
              $j++;
            }

            foreach($week as $day){
              $dailyrevenue = 0;
              $dailycost = 0;
              $dailyinweekrevenue = 0;
              $dailyinweekcost = 0;
              $dailyinmonthrevenue = 0;
              $dailyinmonthcost = 0;
              foreach($decodedgroupedtable as $table){
                if($table['date_sold'] == $day->toDateString()){
                  $weeklyrevenue += $table['total_amount'];
                  $weeklycost += $table['price_bought'] * $table['quantity'];
                  $dailyrevenue += $table['total_amount'];
                  $dailycost += $table['price_bought'] * $table['quantity'];
                  $dailyinweekrevenue += $table['total_amount'];
                  $dailyinweekcost += $table['price_bought'] * $table['quantity'];
                  $dailyinmonthrevenue += $table['total_amount'];
                  $dailyinmonthcost += $table['price_bought'] * $table['quantity'];
                }
              }
              $grossdaytemp[] = $dailyrevenue - $dailycost;
              $revenueperdayinweektemp[] = $dailyinweekrevenue;
              $grossincomeperdayinweektemp[] = $dailyinweekrevenue - $dailyinweekcost;
              $perdayinweeklabeltemp[] = $day->toFormattedDateString();
              $revenueperdayinmonthtemp[] = $dailyinmonthrevenue;
              $grossincomeperdayinmonthtemp[] = $dailyinmonthrevenue -$dailyinmonthcost;
              $perdayinmonthlabeltemp[] = $day->toFormattedDateString();
            }
            $revenueperdayinweek[] = $revenueperdayinweektemp;
            $revenueperdayinweektemp = [];
            $grossincomeperdayinweek[] = $grossincomeperdayinweektemp;
            $grossincomeperdayinweektemp = [];
            $perdayinweeklabel[] = $perdayinweeklabeltemp;
            $perdayinweeklabeltemp = [];
            $revenueperweek[] = $weeklyrevenue;
            $revtemp[] = $weeklyrevenue;
            $grossincomeperweek[] = $weeklyrevenue - $weeklycost;
            $grosstemp[] = $weeklyrevenue - $weeklycost;
            $perweeklabel[] = $this->getMonthName($week[0]->month)." "."Week ".$weekcount;
            $labeltemp[] = $this->getMonthName($week[0]->month)." "."Week ".$weekcount;
          }
          $weekcount++;
        }

        if(end($permonth) == $month){
          $revenueperweekinyear[] = $revtemp;
          $grossincomeperweekinyear[] = $grosstemp;
          $perweeklabelinyear[] = $labeltemp;
          $grossincomeperday[] = $grossdaytemp;
          $revenueperdayinmonth[] = $revenueperdayinmonthtemp;
          $grossincomeperdayinmonth[] = $grossincomeperdayinmonthtemp;
          $perdayinmonthlabel[] = $perdayinmonthlabeltemp;
          break;
        }

        $revenueperdayinmonth[] = $revenueperdayinmonthtemp;
        $revenueperdayinmonthtemp = [];
        $grossincomeperdayinmonth[] = $grossincomeperdayinmonthtemp;
        $grossincomeperdayinmonthtemp = [];
        $perdayinmonthlabel[] = $perdayinmonthlabeltemp;
        $perdayinmonthlabeltemp = [];
      }

      $chartsperdayinweek = [];
      $i = 0;
      foreach($perdayinweeklabel as $label){
        $charts = [];

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Total Revenue Per Day from ".$label[0]." to ".$label[count($label)-1])
          ->labels($label)
          ->values($revenueperdayinweek[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Gross Income Per Day from ".$label[0]." to ".$label[count($label)-1])
          ->labels($label)
          ->values($grossincomeperdayinweek[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $chartsperdayinweek[$label[0]] = $charts;
        $i++;
      }

      $chartperdayinmonth = [];
      $i = 0;
      foreach($perdayinmonthlabel as $label){
        $charts = [];

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Total Revenue Per Day in ".$this->getMonthName($decodedyearmonth[$i]['date_month'])." ".$decodedyearmonth[$i]['date_year'])
          ->labels($label)
          ->values($revenueperdayinmonth[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Gross Income Per Day in ".$this->getMonthName($decodedyearmonth[$i]['date_month'])." ".$decodedyearmonth[$i]['date_year'])
          ->labels($label)
          ->values($grossincomeperdayinmonth[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $key = ltrim($decodedyearmonth[$i]['date_month'], '0').$decodedyearmonth[$i]['date_year'];
        $chartperdayinmonth[$key] = $charts;
        $i++;
      }

      $chartweeklyrevenue = Charts::create('line', 'fusioncharts')
        ->title("Total Revenue Per Week")
        ->labels($perweeklabel)
        ->values($revenueperweek)
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      $chartweeklygrossincome = Charts::create('line', 'fusioncharts')
        ->title("Gross Income Per Week")
        ->labels($perweeklabel)
        ->values($grossincomeperweek)
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      $chartperweek = [];
      $i = 0;
      foreach($years as $year){
        $charts = [];

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Total Revenue Per Week in ".$year)
          ->labels($perweeklabelinyear[$i])
          ->values($revenueperweekinyear[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Gross Income Per Week in ".$year)
          ->labels($perweeklabelinyear[$i])
          ->values($grossincomeperweekinyear[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $chartperweek[$year] = $charts;
        $i++;
      }


      //creates arrays for revenue, gross income, and net income per month in of the whole usage of the system and in per month in each year
      $revenuepermonthyear = [];
      $revenuepermonthyeartemp = [];
      $grossincomepermonthyear = [];
      $grossincomepermonthtemp = [];
      $netincomepermonthyear = [];
      $netincomepermonthyeartemp = [];
      $monthlylabel = [];
      $revenuepermonth = [];
      $grossincomepermonth = [];
      $netincomepermonth = [];
      $monthlyrevenue = 0;
      $monthlycost = 0;
      $j = 0;
      for($i = 0; $i < count($decodedgroupedtable); $i++){
        $currmonth = $decodedyearmonth[$j]['date_month'];
        $curryear = $decodedyearmonth[$j]['date_year'];

        if(substr($decodedgroupedtable[$i]['date_sold'], 5, 2) == $currmonth && substr($decodedgroupedtable[$i]['date_sold'], 0, 4) == $curryear){
          $monthlyrevenue += $decodedgroupedtable[$i]['total_amount'];
          $monthlycost += $decodedgroupedtable[$i]['price_bought'] * $decodedgroupedtable[$i]['quantity'];
        }

        if($i == count($decodedgroupedtable)-1){
          $monthlylabel[] = $this->getMonthName($currmonth)." ".$curryear;
          $revenuepermonth[] = $monthlyrevenue;
          $revenuepermonthyeartemp[] = $monthlyrevenue;
          $grossincomepermonth[] = $monthlyrevenue - $monthlycost;
          $grossincomepermonthtemp[] = $monthlyrevenue - $monthlycost;
          $fixedcost = 0;
          $tax = 0;
          foreach($costs as $cost){
            if($cost->month == $currmonth && $cost->year == $curryear){
              $fixedcost = $cost->water_bill + $cost->electric_bill + $cost->rent + $cost->labor;
              $tax = $cost->tax;
              break;
            }
          }
          $netincome = $monthlyrevenue - $monthlycost - $fixedcost;
          $netincomepermonth[] = $netincome - ($netincome * $tax);
          $netincomepermonthyeartemp[] = $netincome - ($netincome * $tax);
          $grossincomepermonthyear[] = $grossincomepermonthtemp;
          $revenuepermonthyear[] = $revenuepermonthyeartemp;
          $netincomepermonthyear[] = $netincomepermonthyeartemp;
          break;
        }

        if(substr($decodedgroupedtable[$i+1]['date_sold'], 5, 2) != $currmonth || substr($decodedgroupedtable[$i+1]['date_sold'], 0, 4) != $curryear){
          $monthlylabel[] = $this->getMonthName($currmonth)." ".$curryear;
          $revenuepermonth[] = $monthlyrevenue;
          $revenuepermonthyeartemp[] = $monthlyrevenue;
          $grossincomepermonth[] = $monthlyrevenue - $monthlycost;
          $grossincomepermonthtemp[] = $monthlyrevenue - $monthlycost;
          $fixedcost = 0;
          $tax = 0;
          foreach($costs as $cost){
            if($cost->month == $currmonth && $cost->year == $curryear){
              $fixedcost = $cost->water_bill + $cost->electric_bill + $cost->rent + $cost->labor;
              $tax = $cost->tax;
              break;
            }
          }
          $netincome = $monthlyrevenue - $monthlycost - $fixedcost;
          $netincomepermonth[] = $netincome - ($netincome * $tax);
          $netincomepermonthyeartemp[] = $netincome - ($netincome * $tax);
          $monthlyrevenue = 0;
          $monthlycost = 0;
          $j++;
        }

        if($curryear != $decodedyearmonth[$j]['date_year']){
          $grossincomepermonthyear[] = $grossincomepermonthtemp;
          $grossincomepermonthtemp = [];
          $revenuepermonthyear[] = $revenuepermonthyeartemp;
          $revenuepermonthyeartemp = [];
          $netincomepermonthyear[] = $netincomepermonthyeartemp;
          $netincomepermonthyeartemp = [];
        }
      }

      $i = 0;
      $chartspermonth = [];
      foreach($years as $year){
        $charts = [];

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Total Revenue Per Month in ".$year)
          ->labels($splityearmonthlabels[$i])
          ->values($revenuepermonthyear[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Gross Income Per Month in ".$year)
          ->labels($splityearmonthlabels[$i])
          ->values($grossincomepermonthyear[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $charts[] = Charts::create('line', 'fusioncharts')
          ->title("Net Income Per Month in ".$year)
          ->labels($splityearmonthlabels[$i])
          ->values($netincomepermonthyear[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $chartspermonth[$year] = $charts;
        $i++;
      }

      $i = 0;
      $chartgrossincomeperyear = [];
      foreach($years as $year){
        $chart = Charts::create('line', 'fusioncharts')
          ->title("Gross Income Per Month in ".$year)
          ->labels($splityearmonthlabels[$i])
          ->values($grossincomepermonthyear[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);
        $i++;
        $chartgrossincomeperyear[] = $chart;
      }

      $chartmonthlyrevenue = Charts::create('line', 'fusioncharts')
        ->title("Total Revenue Per Month")
        ->labels($monthlylabel)
        ->values($revenuepermonth)
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      $chartmonthlygrossincome = Charts::create('line', 'fusioncharts')
        ->title("Gross Income Per Month")
        ->labels($monthlylabel)
        ->values($grossincomepermonth)
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      $chartmonthlynetincome = Charts::create('line', 'fusioncharts')
        ->title("Net Income Per Month")
        ->labels($monthlylabel)
        ->values($netincomepermonth)
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      //computes the yearly gross income, gross margin, and gross sales
      $productcost = [];
      $revenue = [];
      $yearcost;
      $yeargrossincome;
      $yeargrosssales;
      foreach($years as $year){
        $productcost[] = DB::table('orders')
          ->select('product_name', DB::raw('SUM(quantity) as quantity'), 'price_bought')
          ->distinct()
          ->whereYear('date_sold', $year)
          ->groupBy('product_name', 'price_bought')->get();

        $revenue[] = DB::table('orders')
          ->select(DB::raw('SUM(total_amount) as total_amount'))
          ->distinct()
          ->whereYear('date_sold', $year)->get();

        $yeargrosssales[] = DB::table('orders')
          ->select(DB::raw('SUM(subtotal) as subtotal'))
          ->distinct()
          ->whereYear('date_sold', $year)->get();
      }
      foreach($productcost as $prodcost){
        $cost = 0;
        foreach($prodcost as $pd){
          $cost += $pd->quantity * $pd->price_bought;
        }
        $yearcost[] = $cost;
      }
      $i = 0;
      foreach($revenue as $rev){
        $yeargrossincome[] = $rev[0]->total_amount - $yearcost[$i];
        $i++;
      };

      //return [count($grossincomeperday[1]), count($salesperyear[0]->pluck('date_sold'))];
      //creates charts
      $charts = [];
      $listofdates = [];  //list of unique dates
      $i = 0;
      foreach ($salesperyear as $saleperyr) {
        $chartarray = [];
        $chartarray[] = Charts::create('line', 'fusioncharts')
          ->title("Total Revenue Per Day in ".$years[$i])
          ->labels($saleperyr->pluck('date_sold'))
          ->values($saleperyr->pluck('total_amount'))
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $chartarray[] = Charts::create('line', 'fusioncharts')
          ->title("Gross Income Per Day in ".$years[$i])
          ->labels($saleperyr->pluck('date_sold'))
          ->values($grossincomeperday[$i])
          ->elementLabel("Peso")
          ->dimensions(0, 400);

        $charts[] = $chartarray;
        $i++;
        $listofdates = array_merge($listofdates, json_decode($saleperyr->pluck('date_sold'), true));
      }

      $chartproducts = [];
      for ($i = 0; $i < count($listofdates); $i++) {
        $temp_array = [];
        foreach ($productcountperday as $pcpd) {
          if ($pcpd['date_sold'] == $listofdates[$i]) {
            $temp_array[] = $pcpd;
          }
        }

        $chart = Charts::create('bar', 'fusioncharts')
          ->title("Product Count in ".$listofdates[$i])
          ->labels(array_column($temp_array, 'product_name'))
          ->values(array_column($temp_array, 'quantity'))
          ->elementLabel("Quantity")
          ->dimensions(554, 400);
        $chartproducts[] = $chart;
      }

      $temp = [];
      foreach($yeargrosssales as $yrgs){
        $temp = array_merge($temp, json_decode($yrgs, true));
      }
      $chartgrosssales = Charts::create('line', 'fusioncharts')
        ->title("Total Gross Sales per Year")
        ->labels($years)
        ->values(array_column($temp, 'subtotal'))
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      $chartgrossincomeyear = Charts::create('line', 'fusioncharts')
        ->title("Total Gross Income per Year")
        ->labels($years)
        ->values($yeargrossincome)
        ->elementLabel("Peso")
        ->dimensions(0, 400);

      return view('costs.index', compact(['orders', 'costs', 'charts',
        'chartproducts', 'listofdates', 'years',
        'groupedtable', 'yearmonth', 'permonth',
        'yeargrossincome', 'revenue', 'yeargrosssales',
        'chartgrosssales', 'chartgrossincomeyear', 'chartmonthlyrevenue',
        'chartmonthlygrossincome', 'chartmonthlynetincome', 'chartgrossincomeperyear',
        'chartrevenueperyear', 'chartnetincomeperyear', 'chartspermonth',
        'chartweeklyrevenue', 'chartweeklygrossincome', 'chartperweek',
        'chartsperdayinweek', 'chartperdayinmonth']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $cost = Cost::findOrFail($id);

      return view('costs.edit', compact('cost'));
    }

    public function update(Request $request, $id)
    {
      $cost = Cost::findOrFail($id);

      $cost->update($request->all());

      flash('Edit has been saved in the database!', 'success');

      return redirect('/costs');
    }

    public function destroy($id)
    {
        //
    }
}
