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



    Highcharts.chart('right_chart', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Recovery'
      },
      subtitle: {
        text: 'From <strong>2016-12-01</strong> To <strong>2017-01-20</strong>'
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
          text: 'Rainfall (mm)'
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
        name: 'Collected',
        data: [49.9, 71.5, 106.4]

      }, {
        name: 'Arrears',
        data: [83.6, 78.8, 98.5]

      }, {
        name: 'Total',
        data: [48.9, 38.8, 39.3]

      }]
    });
  });
  function pie_chart(cash, credit,hp){
    //alert(cash);
    Highcharts.chart('container', {
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
        text: 'From <strong>2016-12-01</strong> to <strong>2017-01-20</strong>'
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
      }]
    });
  }
  function get_dashbord_date(){
    $.post("index.php/main/load_data/dashbord/get_all_sales", {
      from:$("#d_from").val(),
      to:$("#d_to").val()
      // from:'2016-11-11',
      // to:'2016-11-11'
    }, function(r){
      var cash = 0;
      var credit = 0;
      var hp = 0;
      if(r !== 0){
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
            $(".count").fadeOut('slow');
            $("#div_cash").html(accounting.format(cash, 2));
            $("#div_credit").html(accounting.format(credit, 2));
            $("#div_hp").html(accounting.format(hp, 2));
            var tot = parseFloat(hp)+parseFloat(cash)+parseFloat(credit);
            $("#div_total").html(accounting.format(tot, 2));
            $(".count").fadeIn('slow');
            pie_chart(cash, credit,hp);
      }else{
        alert('dddd');
        $(".count").fadeOut('slow');
        $("#div_cash").html(accounting.format(cash, 2));
        $("#div_credit").html(accounting.format(credit, 2));
        $("#div_hp").html(accounting.format(hp, 2));
        var tot = parseFloat(hp)+parseFloat(cash)+parseFloat(credit);
        $("#div_total").html(accounting.format(tot, 2));
        $(".count").fadeIn('slow');
      }
    },"json");
  }


  </script>
