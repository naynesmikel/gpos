
@extends('layouts.app')

@section('content')
<script>
    function getMonthName(month){
      if(month == "01")
          return "<option>January</option>";
      else if(month == "02"){
          return "<option>Febuary</option>";
      }else if(month == "03"){
          return "<option>March</option>";
      }else if(month == "04"){
          return "<option>April</option>";
      }else if(month == "05"){
          return "<option>May</option>";
      }else if(month == "06"){
          return "<option>June</option>";
      }else if(month == "07"){
          return "<option>July</option>";
      }else if(month == "08"){
          return "<option>August</option>";
      }else if(month == "09"){
          return "<option>September</option>";
      }else if(month == "10"){
          return "<option>October</option>";
      }else if(month == "11"){
          return "<option>November</option>";
      }else if(month == "12"){
          return "<option>December</option>";
      }
    }
    function getMonthValue(month){
      if(month == "January")
          return "1";
      else if(month == "Febuary"){
          return "2";
      }else if(month == "March"){
          return "3";
      }else if(month == "April"){
          return "4";
      }else if(month == "May"){
          return "5";
      }else if(month == "June"){
          return "6";
      }else if(month == "July"){
          return "7";
      }else if(month == "August"){
          return "8";
      }else if(month == "September"){
          return "9";
      }else if(month == "October"){
          return "10";
      }else if(month == "November"){
          return "11";
      }else if(month == "December"){
          return "12";
      }
    }
    function getFullMonth(mon){
      if(mon == "Jan")
        return "January";
      else if(mon == "Feb")
        return "Febuary";
      else if(mon == "Mar")
        return "March";
      else if(mon == "Apr")
        return "April";
      else if(mon == "May")
        return "May";
      else if(mon == "Jun")
        return "June";
      else if(mon == "Jul")
        return "July";
      else if(mon == "Aug")
        return "August";
      else if(mon == "Sep")
        return "September";
      else if(mon == "Oct")
        return "October";
      else if(mon == "Nov")
        return "November";
      else if(mon == "Dec")
        return "December";
    }
    function getColorThresh(amount){
      if(amount > 0)
        return "green";
      else
        return "red";
    }
    $(document).ready(function(){
        //makes the latest data to be shown as active
        $('.tab-content').children().last().addClass('in active');
        $('.nav-tabs').children().each(function(i,e){
          if($(this).children().attr('href') == '#'.concat($('.tab-content').children().last().attr('id'))){
            $(this).addClass('active');
          }
        });

        //creates the options of available months in the selected year also makes the latest year and month in the data to be shown
        $('#yearoption option:last').prop('selected', true);
        var yearmonth = {!! json_encode($yearmonth->toArray()) !!};
        var year = $('#yearoption').val();
        var selectmonth = "";
        for(var i = 0; i < yearmonth.length; i++){
          if(yearmonth[i].date_year == year){
            selectmonth += getMonthName(yearmonth[i].date_month);
          }
        }
        $('#monthoption').html(selectmonth);
        $('#monthoption').html().trim();
        $('#monthoption option:last').prop('selected', true);

        //saves the current year and month option so it can be used when the select inputs are changed
        $('#yearoption').data('prevyear', $('#yearoption').val());
        $('#monthoption').data('prevmonth', $('#monthoption').val());

        //function for select year when changed
        $('#yearoption').change(function () {
          $('#'+$(this).data('prevyear')+getMonthValue($('#monthoption').data('prevmonth'))).hide();

          var pointer = $('#'+$(this).data('prevyear')+getMonthValue($('#monthoption').data('prevmonth')));
          pointer.find('.nav-tabs').children().each(function(i,e){
            if($(this).children().attr('href') == '#'.concat(pointer.find('.tab-content').find(".in.active").attr('id'))){
              $(this).removeClass("active");
            }
          });
          pointer.find('.tab-content').find(".in.active").removeClass("in active");

          var curr_month = $('#monthoption').data('prevmonth');
          var value = $(this).val();
          var yearmonth = {!! json_encode($yearmonth->toArray()) !!};
          var selectmonth = "";
          for(var i = 0; i < yearmonth.length; i++){
            if(yearmonth[i].date_year == value){
              selectmonth += getMonthName(yearmonth[i].date_month);
            }
          }
          $('#monthoption').html(selectmonth);
          var exists = false;
          $('#monthoption  option').each(function(){
            if (this.value == curr_month) { exists = true; }
          });
          if(exists){ $('#monthoption').val(curr_month).change(); }

          $('#'+$('#yearoption').val()+getMonthValue($('#monthoption').val())).show();
          $(this).data('prevyear', $(this).val());
          $('#monthoption').data('prevmonth', $('#monthoption').val());

          pointer = $('#'+$('#yearoption').val()+getMonthValue($('#monthoption').val()));
          pointer.find('.tab-content').children().last().addClass('in active');
          pointer.find('.nav-tabs').children().each(function(i,e){
            if($(this).children().attr('href') == '#'.concat(pointer.find('.tab-content').children().last().attr('id'))){
              $(this).addClass('active');
            }
          });
        });

        //function for select month when changed
        $('#monthoption').change(function () {
          $('#'+$('#yearoption').data('prevyear')+getMonthValue($(this).data('prevmonth'))).hide();

          var pointer = $('#'+$('#yearoption').data('prevyear')+getMonthValue($(this).data('prevmonth')));
          pointer.find('.nav-tabs').children().each(function(i,e){
            if($(this).children().attr('href') == '#'.concat(pointer.find('.tab-content').find(".in.active").attr('id'))){
              $(this).removeClass("active");
            }
          });
          pointer.find('.tab-content').find(".in.active").removeClass("in active");

          $('#'+$('#yearoption').val()+getMonthValue($('#monthoption').val())).show();
          $(this).data('prevmonth', $(this).val());

          pointer = $('#'+$('#yearoption').val()+getMonthValue($('#monthoption').val()));
          pointer.find('.tab-content').children().last().addClass('in active');
          pointer.find('.nav-tabs').children().each(function(i,e){
            if($(this).children().attr('href') == '#'.concat(pointer.find('.tab-content').children().last().attr('id'))){
              $(this).addClass('active');
            }
          });
        });

        //shows the latest data set and hides the rest
        var week_length = $('.week-navigation').length;
        $('.week-navigation').each(function(i,e){
          var date_class = $(this).find('ul').children().first().children().first().attr("class");
          $(this).attr("id", date_class);
          $(this).hide();
          if(i == week_length-1){
            $(this).show();
          }
        });

        //computes average check, revenue, gross income, and gross margin per day
        var netsales = 0;
        var grosssales = 0;
        $('.parent-table').each(function(i,e){
          var avecheckT = 0;
          var revenue = 0;
          var costofgoods = 0;
          var sales = 0;
          $(this).find('.selling_price').each(function(i,e){
              var amt = $(this).html()-0;
              avecheckT += amt;
          });
          $(this).find('.total_amount').each(function(i,e){
              var amt = $(this).html()-0;
              revenue += amt;
          });
          $(this).find('tr').each(function(i,e){
              var cost = $(this).find('.price_bought').val()-0;
              var qty = $(this).find('.quantity').html()-0;
              if(!isNaN(cost) && !isNaN(qty)){
                costofgoods += cost * qty;
              }
          });
          $(this).find('.subtotal').each(function(i,e){
              var amt = $(this).html()-0;
              sales += amt;
          });
          $(this).find('.avecheck').append("<strong>" + (avecheckT/$(this).find('.selling_price').length).toFixed(2) + "</strong>");
          $(this).find('.totalamt').append("<strong>" + revenue.toFixed(2) + "</strong>");
          $(this).find('.totalamt').css("color", getColorThresh(revenue));
          $(this).find('.gross-income').append("<strong>" + (revenue - costofgoods).toFixed(2) + "</strong>");
          $(this).find('.gross-income').css("color", getColorThresh(revenue - costofgoods));
          $(this).find('.gross-margin').append("<strong>" + (((revenue - costofgoods) / revenue) * 100).toFixed(2) + "%" + "</strong>");
          $(this).find('.gross-margin').css("color", getColorThresh(((revenue - costofgoods) / revenue) * 100));
          netsales += revenue;
          grosssales += sales;
        });

        //computes average check, revenue, gross income, and gross margin per week
        var regex = /[+-]?\d+(\.\d+)?/g;
        $('.tab-pane').each(function(i,e){
          var revenue = 0;
          var grossincome = 0;
          $(this).find('.totalamt').each(function(i,e){
            var amt = $(this).html().match(regex).map(function(v) { return parseFloat(v); });
            revenue += amt[0];
          });
          $(this).find('.gross-income').each(function(i,e){
            var amt = $(this).html().match(regex).map(function(v) { return parseFloat(v); });
            grossincome += amt[0];
          });
          $(this).find('.week-revenue').append("<strong>" + revenue.toFixed(2) + "</strong>");
          $(this).find('.week-revenue').css("color", getColorThresh(revenue));
          $(this).find('.week-grossincome').append("<strong>" + grossincome.toFixed(2) + "</strong>");
          $(this).find('.week-grossincome').css("color", getColorThresh(grossincome));
          $(this).find('.week-grossmargin').append("<strong>" + ((grossincome / revenue) * 100).toFixed(2) + "%" + "</strong>");
          $(this).find('.week-grossmargin').css("color", getColorThresh((grossincome / revenue) * 100));
        });

        //computes average check, revenue, gross income, and gross margin per month
        //also adds the fixed cost in each month
        var cost = {!! json_encode($costs->toArray()) !!};
        var soi = 0;
        $('.week-navigation').each(function(i,e){
          var revenue = 0;
          var grossincome = 0;
          $(this).find('.totalamt').each(function(i,e){
            var amt = $(this).html().match(regex).map(function(v) { return parseFloat(v); });
            revenue += amt[0];
          });
          $(this).find('.gross-income').each(function(i,e){
            var amt = $(this).html().match(regex).map(function(v) { return parseFloat(v); });
            grossincome += amt[0];
          });
          $(this).find('.month-revenue').append("<strong>" + revenue.toFixed(2) + "</strong>");
          $(this).find('.month-revenue').css("color", getColorThresh(revenue));
          $(this).find('.month-grossincome').append("<strong>" + grossincome.toFixed(2) + "</strong>");
          $(this).find('.month-grossincome').css("color", getColorThresh(grossincome));
          $(this).find('.month-grossmargin').append("<strong>" + ((grossincome / revenue) * 100).toFixed(2) + "%" + "</strong>");
          $(this).find('.month-grossmargin').css("color", getColorThresh((grossincome / revenue) * 100));
          for(var i = 0; i < cost.length; i++){
            if($(this).attr('id').length == 6){
              if(cost[i].year == $(this).attr('id').substring(0,4) && cost[i].month == $(this).attr('id').substring(4,6)){
                $(this).find('.editcost').attr('data-target', '#' + cost[i].id);
                //$(this).find('.tax').append(cost[i].tax + "%");
                $(this).find('.water_bill').append(cost[i].water_bill.toFixed(2));
                $(this).find('.electric_bill').append(cost[i].electric_bill.toFixed(2));
                $(this).find('.rent').append(cost[i].rent.toFixed(2));
                $(this).find('.labor').append(cost[i].labor.toFixed(2));
                $(this).find('.fixedcosttotal').append((cost[i].water_bill + cost[i].electric_bill + cost[i].rent + cost[i].labor).toFixed(2));
                var netincome = grossincome - (cost[i].water_bill + cost[i].electric_bill + cost[i].rent + cost[i].labor);
                netincome = netincome - (netincome * (cost[i].tax/100));
                soi += netincome;
                $(this).find('.month-netincome').append("<strong>" + netincome.toFixed(2) + "</strong>");
                $(this).find('.month-netincome').css("color", getColorThresh(netincome));
                break;
              }
            }else{
              if(cost[i].year == $(this).attr('id').substring(0,4) && cost[i].month.substring(1,2) == $(this).attr('id').substring(4,5)){
                $(this).find('.editcost').attr('data-target', '#' + cost[i].id);
                //$(this).find('.tax').append(cost[i].tax + "%");
                $(this).find('.water_bill').append(cost[i].water_bill.toFixed(2));
                $(this).find('.electric_bill').append(cost[i].electric_bill.toFixed(2));
                $(this).find('.rent').append(cost[i].rent.toFixed(2));
                $(this).find('.labor').append(cost[i].labor.toFixed(2));
                $(this).find('.fixedcosttotal').append((cost[i].water_bill + cost[i].electric_bill + cost[i].rent + cost[i].labor).toFixed(2));
                var netincome = grossincome - (cost[i].water_bill + cost[i].electric_bill + cost[i].rent + cost[i].labor);
                netincome = netincome - (netincome * (cost[i].tax/100));
                soi += netincome;
                $(this).find('.month-netincome').append("<strong>" + netincome.toFixed(2) + "</strong>");
                $(this).find('.month-netincome').css("color", getColorThresh(netincome));
                break;
              }
            }
          }
          var mon = $(this).find('.week-date').html().substring(6, 9);
          $(this).find('.monthof').append("Month of " + getFullMonth(mon) + " " + $(this).attr('id').substring(0,4));
        });

        $('#net-sales').append("<strong>" + netsales.toFixed(2) + "</strong>");
        $('#net-sales').css("color", getColorThresh(netsales));
        $('#gross-sales').append("<strong>" + grosssales.toFixed(2) + "</strong>");
        $('#gross-sales').css("color", getColorThresh(grosssales));
        $('#soi').append("<strong>" + soi.toFixed(2) + "</strong>");
        $('#soi').css("color", getColorThresh(soi));

    });
</script>

<div class="container">
  @include('flash::message')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Sales Report
				</div>

        @if(!$orders->isEmpty())
				<div class="panel-body">
          <div class="row">
            <div class="col-md-3">
                Year:
                <select class="form-control" id="yearoption">
                  @foreach($years as $year)
                      <option>{{$year}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-3">
                Month:
                <select class="form-control" id="monthoption" autofocus>
                  <option></option>
                </select>
            </div>
          </div>

          <br>

          @foreach($permonth as $month)
          <div class="week-navigation">

            <div class="wrapper">
              <ul class="nav nav-tabs list" class="myTab">
                  @for($j = array_keys($month)[0]; $j < array_keys($month)[count($month)-1]+1; $j++)
                      @if(!empty($month[$j]))
                        <li>
                          <a data-toggle="tab" href="#{{ $j }}" class="{{ $month[$j][0]->year.$month[$j][0]->month }}">
                            {{ $month[$j][0]->toFormattedDateString() }} to {{ $month[$j][count($month[$j])-1]->toFormattedDateString() }}
                          </a>
                        </li>
                      @endif
                  @endfor
              </ul>
            </div>

            <br>

            <div class="tab-content">
            @for($j = array_keys($month)[0]; $j < array_keys($month)[count($month)-1]+1; $j++)
            @if(!empty($month[$j]))
              <div id="{{ $j }}" class="tab-pane fade">
                @for($i = 0; $i < count($month[$j]); $i++)
                  <div class="row">
                    <div class="col-md-6">
                      <div class="parent-table">
                        <p class="week-date">Date: {{$month[$j][$i]->toFormattedDateString()}}</p>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                                <th>Discount (%)</th>
                                <th>Total Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($groupedtable as $grouptable)
                                @if($grouptable->date_sold == $month[$j][$i]->toDateString())
                                  <tr>
                                    <input type="hidden" class="price_bought" name="price_bought" value="{{ $grouptable->price_bought }}">
                                    <td>{{ $grouptable->product_name }}</td>
                                    <td class="quantity">{{ $grouptable->quantity }}</td>
                                    <td class="selling_price">{{ $grouptable->selling_price }}</td>
                                    <td class="subtotal">{{ $grouptable->subtotal }}</td>
                                    <td>{{$grouptable->discount}}</td>
                                    <td class="total_amount">{{ $grouptable->total_amount }}</td>
                                  </tr>
                                @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <p class="pull-right totalamt" style="margin-right: 5%;">Revenue: </p>
                        <p class="avecheck">Average Check: </p>
                        <p class="gross-income">Gross Income: </p>
                        <p class="gross-margin">Gross Margin: </p>
                        <br>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <center>
                        {!! $chartproducts[array_search($month[$j][$i]->toDateString(), $listofdates)]->render() !!}
                      </center>
                    </div>
                  </div>
                  <br>
                @endfor
                <hr>
                <center><h4>Week of {{ $month[$j][0]->toFormattedDateString() }} to {{ $month[$j][count($month[$j])-1]->toFormattedDateString() }}</h4></center>
                <br>
                <div class="row">
                  <div class="col-md-2">
                    <p class="week-revenue">Revenue: </p>
                    <p class="week-grossincome">Gross Income: </p>
                    <p class="week-grossmargin">Gross Margin: </p>
                  </div>
                  @foreach($chartsperdayinweek[$month[$j][0]->toFormattedDateString()] as $chart)
                  <div class="col-md-5">
                    {!! $chart->render() !!}
                  </div>
                  @endforeach
                </div>
                <br>
                <div class="row">
                  <div class="col-md-5 col-md-offset-2">
                    {!! $chartperweek[$month[$j][0]->year][0]->render() !!}
                  </div>
                  <div class="col-md-5">
                    {!! $chartperweek[$month[$j][0]->year][1]->render() !!}
                  </div>
                </div>
              </div>
            @endif
            @endfor
            </div>
            <hr>
            <center><h4 class="monthof"></h4></center>
            <div class="row">
              <div class="col-md-2">
                <p class="month-revenue">Revenue: </p>
                <p class="month-grossincome">Gross Income: </p>
                <p class="month-grossmargin">Gross Margin: </p>
                <br>
                <p>
                  <b>Fixed Cost</b>
                  <span data-toggle="modal" data-target="" class="editcost">
        						<big><a href="#" data-toggle="tooltip" title="Edit Fixed Cost for this month" class="actions"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></big>
        					</span>
                </p>
                <!--p class="tax"> Tax: </p-->
                <p class="water_bill">Water Bill: </p>
                <p class="electric_bill">Electric Bill: </p>
                <p class="rent">Rent: </p>
                <p class="labor">Labor: </p>
                <p class="fixedcosttotal"><b>Subtotal: </b></p>
                <p class="month-netincome">Net Income: </p>
              </div>

                @foreach($month as $week)
                  @if(!empty($week))
                  <div class="col-md-5">
                    {!! $chartperdayinmonth[$week[0]->month.$week[0]->year][0]->render() !!}
                  </div>
                    @break
                  @endif
                @endforeach
                @foreach($month as $week)
                  @if(!empty($week))
                  <div class="col-md-5">
                    {!! $chartperdayinmonth[$week[0]->month.$week[0]->year][1]->render() !!}
                  </div>
                    @break
                  @endif
                @endforeach

            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                @foreach($month as $week)
                  @if(!empty($week))
                    {!! $chartspermonth[$week[0]->year][0]->render() !!}
                    @break
                  @endif
                @endforeach
              </div>
              <div class="col-md-6">
                @foreach($month as $week)
                  @if(!empty($week))
                    {!! $chartspermonth[$week[0]->year][1]->render() !!}
                    @break
                  @endif
                @endforeach
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                @foreach($month as $week)
                  @if(!empty($week))
                    {!! $chartspermonth[$week[0]->year][2]->render() !!}
                    @break
                  @endif
                @endforeach
              </div>
            </div>

          </div>  <!--end of week-navigation-->
          @endforeach

          <hr>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <th>Year</th>
                    <th>Gross Sales</th>
                    <th>Gross Income</th>
                    <th>Gross Margin</th>
                  </thead>
                  <tbody>
                    @for($i = 0; $i < count($yeargrossincome); $i++)
                    <tr>
                      <td><b>{{ $years[$i] }}</b></td>
                      @if($yeargrosssales[$i][0]->subtotal > 0)
                      <td style="color: green;"><strong>{{ round($yeargrosssales[$i][0]->subtotal, 2) }}</strong></td>
                      @else
                      <td style="color: red;"><strong>{{ round($yeargrosssales[$i][0]->subtotal, 2) }}</strong></td>
                      @endif
                      @if($yeargrossincome[$i] > 0)
                      <td style="color: green;"><strong>{{ round($yeargrossincome[$i], 2) }}</strong></td>
                      @else
                      <td style="color: red;"><strong>{{ round($yeargrossincome[$i], 2) }}</strong></td>
                      @endif
                      @if(($yeargrossincome[$i] / $revenue[$i][0]->total_amount) * 100 > 0)
                      <td style="color: green;"><strong>{{ round((($yeargrossincome[$i] / $revenue[$i][0]->total_amount) * 100), 2) }}%</strong></td>
                      @else
                      <td style="color: red;"><strong>{{ round((($yeargrossincome[$i] / $revenue[$i][0]->total_amount) * 100), 2) }}%</strong></td>
                      @endif
                    </tr>
                    @endfor
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              {!! $chartgrosssales->render() !!}
            </div>
            <div class="col-md-6">
              {!! $chartgrossincomeyear->render() !!}
            </div>
          </div>


          <hr>
          <p>Totality of the Company</p>
          <p id="gross-sales">Gross Sales: </p>
          <p id="net-sales">Net Sales: </p>
          <hr>
          <p id="soi">Sales Operating Income: </p>

				</div>
        @else
          <div class="panel-body">
  					<div class="panel-body">
  						<center><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                <br>
                You have not made any sales yet.
              </center>
  					</div>
          </div>
				@endif

			</div>
		</div>

    @foreach($costs as $cost)
    <div id="{{$cost->id}}" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Fixed Cost</h4>
          </div>

          <div class="modal-body">
            @include('costs/edit')
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    @endforeach

    @if(!$orders->isEmpty())
    <div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Overview
				</div>

				<div class="panel-body">

          @foreach($charts as $chart)
          <div class="row">
            @foreach($chart as $ch)
            <div class="col-md-6">
              {!! $ch->render() !!}
            </div>
            @endforeach
          </div>
          <br>
          @endforeach

          <div class="row">
            <div class="col-md-6">
              {!! $chartweeklyrevenue->render() !!}
            </div>
            <div class="col-md-6">
              {!! $chartweeklygrossincome->render() !!}
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
              {!! $chartmonthlyrevenue->render() !!}
            </div>
            <div class="col-md-6">
              {!! $chartmonthlygrossincome->render() !!}
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              {!! $chartmonthlynetincome->render() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

	</div>
</div>
@endsection
