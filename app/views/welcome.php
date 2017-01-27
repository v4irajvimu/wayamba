

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link type="image/png" href="<?=base_url(); ?>img/ico.png" rel="icon">
  <title>KGC (pvt) LTD</title>
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/inputs.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/grid.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-1.8.4_.custom.css" />
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery.tablescroll.css" />
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery.autocomplete.css" />
  <link href="<?=base_url(); ?>css/superfish.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url(); ?>css/slider.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/menu.css" />

  <!-- Dashboard Module CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/dashboard_module.css" />

  <script type="text/javascript" src="<?=base_url(); ?>js/jquery.js"></script>


  <script type="text/javascript" src="<?=base_url(); ?>js/slides.min.jquery.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>superfish.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/script.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/jquery.ui.core.min.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/autoNumeric1.6.2.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/jquery.tablescroll.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/jquery.form.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/jquery.autocomplete.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/inputs.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/menu.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/dashbord.js"></script>
  <!-- Hichart CDN  -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-3d.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script type="text/javascript" src="<?=base_url(); ?>js/accounting.js"></script>


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
} );
</script>

  <script type="text/javascript">

  $(document).ready(function(){
    get_dashbord_date();

    $("#load_dash").on("click",function(){
      get_dashbord_date();
    });
  });
  function bar_chart(p_coll,p_arre,p_tot,bf_coll,bf_arre,bf_tot, from, to){


    var tot_coll = p_coll + bf_coll;
    var tot_arre = p_arre + bf_arre;
    var tot_tot = p_tot + bf_tot;



    Highcharts.chart('bar_chart', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Recovery'
      },
      subtitle: {
        text: 'From <strong>'+from+'</strong> To <strong>'+to+'</strong>'
      },
      credits: {
        enabled: false
      },
      xAxis: {
        categories: [
          'Period',
          'B/F',
          'Total'
        ],
        crosshair: true
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Amount (LKR)'
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        '<td style="padding:0"><b>{point.y:.1f} LKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
      },
      plotOptions: {
        column: {
          pointPadding: 0.2,
          borderWidth: 0
        }
      },
      series: [{
        name: 'Total',
        data: [parseFloat(p_tot),parseFloat(bf_tot),parseFloat(tot_tot)]
      }, {
        name: 'Collected',
        data: [parseFloat(p_coll),parseFloat(bf_coll),parseFloat(tot_coll)]
      }, {
        name: 'Balance',
        data: [parseFloat(p_arre),parseFloat(bf_arre),parseFloat(tot_arre)]
      }],
      exporting: { enabled: false }
    });
  }
  function pie_chart(cash, credit,hp, from, to){
    //alert(cash);
    Highcharts.chart('pie_chart', {
      chart: {
        type: 'pie',
        options3d: {
          enabled: true,
          alpha: 45,
          beta: 0
        }
      },
      title: {
        text: 'Total Sales'
      },
      credits: {
        enabled: false
      },
      subtitle: {
        text: 'From <strong>'+from+'</strong> to <strong>'+to+'</strong>'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          depth: 35,
          dataLabels: {
            enabled: false,
            format: '{point.name}'
          }
        }
      },
      series: [{
        type: 'pie',
        name: 'percentage: ',
        data: [
          {
            name: 'Cash Sales',
            y: parseFloat(cash),
            sliced: true,
            selected: true
          },
          ['Credits Sales', parseFloat(credit)],
          ['HP Sales', parseFloat(hp)]
        ]
      }],
      exporting: { enabled: false }
    });
  }
  function data_setting(cash, credit, hp, collection, stock_val, stock_val_lastweek, from, to){
    // Percenteage Calculetion
    var percetage_tot = parseFloat(cash) + parseFloat(credit) + parseFloat(hp);
    if(percetage_tot > 0){
      var percetage_cash = (parseFloat(cash) / percetage_tot) * 100;
      var percetage_credit = (parseFloat(credit) / percetage_tot) * 100;
      var percetage_hp = (parseFloat(hp) / percetage_tot) * 100;
    }
    else{
      var percetage_cash = 0;
      var percetage_credit = 0;
      var percetage_hp = 0;
    }

    // Stock Valuation Comparison
    var st_tot = parseFloat(stock_val) + parseFloat(stock_val_lastweek);
    var st_gap = parseFloat(stock_val) - parseFloat(stock_val_lastweek);
    var st_percentage = 0;
    var st_class = '';
    if(st_gap > 0){
        st_percentage = (st_gap / parseFloat(stock_val_lastweek))*100;
        st_calss = '<i class="green"><i class="fa fa-sort-asc"></i>'+accounting.format(st_percentage, 2)+'% </i> From last Week'
    }else{
        st_percentage = ((-st_gap )/ parseFloat(stock_val_lastweek))*100;
        st_calss = '<i class="red"><i class="fa fa-sort-desc"></i>'+accounting.format(st_percentage, 2)+'% </i> From last Week'
    }

    $(".count").fadeOut('slow');
    $("#div_cash").html(accounting.format(cash, 2)+" LKR");
    $("#percent_cash").html(accounting.format(percetage_cash, 2)+" %");

    $("#div_credit").html(accounting.format(credit, 2)+" LKR");
    $("#percent_credit").html(accounting.format(percetage_credit, 2)+" %");

    $("#div_hp").html(accounting.format(hp, 2)+" LKR");
    $("#percent_hp").html(accounting.format(percetage_hp, 2)+" %");

    var tot = parseFloat(hp)+parseFloat(cash)+parseFloat(credit);

    $("#div_total_collection").html(accounting.format(collection, 2)+" LKR");
    $("#div_stock").html(accounting.format(stock_val, 2)+" LKR");
    $("#div_stock_percentage").html(st_calss);

    $("#div_total").html(accounting.format(tot, 2)+" LKR");
    $(".count").fadeIn('slow');
  }
  function get_dashbord_date(){
    var from=$("#d_from").val();
    var to=$("#d_to").val();
    $.post("index.php/main/load_data/dashbord/get_all_sales", {
      from:$("#d_from").val(),
      to:$("#d_to").val()
      // from:'2016-11-11',
      // to:'2016-11-11'
    }, function(r){
      var cash = 0;
      var credit = 0;
      var hp = 0;
      var collection = 0;

      var p_coll = 0;
      var p_arre = 0;
      var p_tot = 0;
      var bf_coll = 0;
      var bf_arre = 0;
      var bf_tot = 0;

      var total_collection = 0;

      var stock_val = 0;
      var stock_val_lastweek = 0;

      var stock = 0;
      if(r !== 0){
        // Total Sales
        for(var i=0; i<r.sub.length;i++){
          if(r.sub[i].tr_code == 4){
              cash = r.sub[i].final_sum;
          }
          else if (r.sub[i].tr_code == 5) {
              credit = r.sub[i].final_sum;
          }
          else if (r.sub[i].tr_code == 6) {
              hp = r.sub[i].final_sum;
          }
        }

        // HP Collections
        for(var i=0; i<r.coll_period.length;i++){
          var p_coll =  r.coll_period[i].paid;
          var p_arre =  r.coll_period[i].bal;
          var p_tot =  r.coll_period[i].total;
        }
        for(var i=0; i<r.coll_bf.length;i++){
          var bf_coll = r.coll_bf[i].paid;
          var bf_arre = r.coll_bf[i].bal;
          var bf_tot = r.coll_bf[i].total;
        }

        // Total Collection
        for(var i=0; i<r.coll_period.length;i++){
          collection = r.total_collection[i].total_collection;

          //alert(total_collection);
        }

        // Stock Valuation div_stock
        for(var i=0; i<r.stock_val.length;i++){
          stock_val = r.stock_val[i].sv;
          stock_val_lastweek = r.stock_val[i].sv_lastweek;
          //alert(stock_val);
        }

        data_setting(cash, credit, hp, collection, stock_val, stock_val_lastweek, from, to);
        pie_chart(parseFloat(cash), parseFloat(credit),parseFloat(hp), from, to);
        bar_chart(parseFloat(p_coll),parseFloat(p_arre),parseFloat(p_tot),parseFloat(bf_coll),parseFloat(bf_arre),parseFloat(bf_tot), from, to);
      }else{
          data_setting(cash, credit, hp, collection, stock_val, stock_val_lastweek, from, to);
      }
    },"json");
  }


  </script>



</head>
<body ondragstart="return false;" ondrop="return false;">

  <div id="blocker"></div>
  <div id="logout">

  </div>
</div>
<!-- <div class="company_wrapper">
  <div class="company">
    <div id="logo"><img src="<?=base_url(); ?>images/logo.jpg" alt="" ></div>
    <div class="company_name"></div>
  </div>
</div> -->
<!-- Date Range -->
<div class="row" style="border-bottom:2px solid Green; padding:10px; background-color:#cccccc;">
  <div class="col-sm-6 text-center">
    <h4><?php echo $company; ?></h4>
  </div>
  <div class=" col-sm-6" id="dash_load_div">
    <div class="row">
      <div class="col-sm-2">
        <span class="glyphicon glyphicon-calendar" > From:</span>
      </div>
      <div class="col-sm-3">
        <input  id="d_from" name="d_from" value="<?=date('Y-m-d')?>" title="<?=date('Y-m-d')?>" class="form-control datepicker input-sm"   aria-describedby="inputSuccess2Status" type="text">
        <span id="inputSuccess2Status" class="sr-only">(success)</span>
      </div>

      <div class="col-sm-2">
        <span class="glyphicon glyphicon-calendar" > To:</span>
      </div>
      <div class="col-sm-3">
        <input id="d_to" name="d_to" value="<?=date('Y-m-d')?>" title="<?=date('Y-m-d')?>" class="form-control datepicker input-sm"   aria-describedby="inputSuccess2Status" type="text">
        <span id="inputSuccess2Status" class="sr-only">(success)</span>
      </div>
      <div class="col-sm-2 text-center">
        <a id="load_dash" class="">
          <img src="<?=base_url(); ?>images/gps.gif" alt="" >
        </a>
      </div>
    </div>
  </div>
</div>

<!-- /Date Range -->
<!-- top tiles -->
<div class="row tile_count ">
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-eur"></i> CASH SALES</span>
    <div id="div_cash" class="count green" style="display:none;"></div>
    <span class="count_bottom"><i id="percent_cash" class="green"></i> From Total Sale</span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-usd"></i> CREDIT SALES</span>
    <div id="div_credit" class="count green" style="display:none;"></div>
    <span class="count_bottom"><i id="percent_credit" class="green"></i> From Total Sale</span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-gbp"></i> HP SALES</span>
    <div id="div_hp" class="count green" style="display:none;"></div>
    <span class="count_bottom"><i id="percent_hp" class="green"></i> From Total Sale</span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-eur"></i> TOTAL SALES</span>
    <div id="div_total" class="count green"></div>
    <span class="count_bottom">&nbsp;</span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-usd"></i> TOTAL COLLECTION</span>
    <div id="div_total_collection" class="count green"></div>
    <span class="count_bottom">&nbsp;</span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-line-chart"></i> STOCK VALUATION</span>
    <div id="div_stock" class="count green"></div>
    <span class="count_bottom" id="div_stock_percentage"></span>
  </div>
</div>
<!-- /top tiles -->
<div class="row" >
  <div class="chart col-sm-6" style="height: 400px;">
    <div id="pie_chart" class="chart_inner" style="height: 400px; "></div>

  </div>
  <div class="chart col-sm-6"  style="height: 400px;">
    <div id="bar_chart" class="chart_inner" style="height: 400px; "></div>
  </div>
</div>
<!--<div id="posting_label"></div>-->
<div id="copyright" style="display: none;">Copyright &copy; 2012 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
