$(document).ready(function(){
	var pur_qty_percentage = 50;
	var sales_qty_percentage = 50;
	var pur_ret_qty_percentage = 50;
	var sales_ret_qty_percentage = 50;
	var stock_qty_percentage = 50;

 	draw_chart(pur_qty_percentage,sales_qty_percentage, pur_ret_qty_percentage,sales_ret_qty_percentage,stock_qty_percentage);

});

$(document).on("click","#load_dash",function(){
	var itemcode = $("#itemcode").val();
	var d_from = $("#d_from").val();
	var d_to = $("#d_to").val();
	load_divs(itemcode,d_from,d_to);
	load_stock_det(itemcode,d_from,d_to);
	load_item_movement(itemcode,d_from,d_to);
	load_last_purchase(itemcode,d_from,d_to);
	load_last_sales(itemcode,d_from,d_to);
	tbl_data(itemcode,d_from,d_to);
});
function draw_chart(pur_qty_percentage,sales_qty_percentage, pur_ret_qty_percentage,sales_ret_qty_percentage,stock_qty_percentage){
		// alert(pur_qty_range);
		// alert(sales_qty_range);
	 		var gaugeOptions = {

  			chart: {
  				type: 'solidgauge'
  			},

  			title: null,

  			pane: {
  				center: ['50%', '85%'],
  				size: '140%',
  				startAngle: -90,
  				endAngle: 90,
  				background: {
  					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
  					innerRadius: '60%',
  					outerRadius: '100%',
  					shape: 'arc'
  				}
  			},

  			tooltip: {
  				enabled: false
  			},

    // the value axis
    yAxis: {
    	stops: [
            [0.1, '#a21abb'], // green
            [0.2, '#bb1a8a'],
            [0.3, '#9dbb1a'],
            [0.4, '#1a88bb'],
            [0.5, '#7f1abb'], // yellow
            [0.6, '#1ABB9C'],
            [0.7, '#1a82bb'],
            [0.8, '#bb7f1a'],
            [0.9, '#bb1a1a'] // red
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickAmount: 2,
            title: {
            	y: -70
            },
            labels: {
            	y: 16
            }
        },

        plotOptions: {
        	solidgauge: {
        		dataLabels: {
        			y: 5,
        			borderWidth: 0,
        			useHTML: true
        		}
        	}
        }
    };

// The Perchase gauge
var chartSpeed = Highcharts.chart('purchase', Highcharts.merge(gaugeOptions, {
	yAxis: {min: 0,max: 100 ,title: {text: ''}},
	credits: {enabled: false},
	exporting: {enabled: false},

	series: [{
		name: 'Speed',
		data: [parseFloat(pur_qty_percentage)],
		dataLabels: {
			format: '<div style="text-align:center"><span style="font-size:15px;color:' +
			((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
			'<span style="font-size:12px;color:silver"></span></div>'
		},
		tooltip: {valueSuffix: ''}
	}]

}));

// The Sales gauge
var chartSpeed = Highcharts.chart('sales', Highcharts.merge(gaugeOptions, {
	yAxis: {min: 0,max: 100,title: {text: ''}},
	credits: {enabled: false},
	exporting: {enabled: false},

	series: [{
		name: 'Speed',
		data: [parseFloat(sales_qty_percentage)],
		dataLabels: {
			format: '<div style="text-align:center"><span style="font-size:15px;color:' +
			((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
			'<span style="font-size:12px;color:silver"></span></div>'
		},
		tooltip: {valueSuffix: ''}
	}]

}));


// The purchase_ret gauge
var chartSpeed = Highcharts.chart('purchase_ret', Highcharts.merge(gaugeOptions, {
	yAxis: {min: 0,max: 100,title: {text: ''}},
	credits: {enabled: false},
	exporting: {enabled: false},

	series: [{
		name: 'Speed',
		data: [parseFloat(pur_ret_qty_percentage)],
		dataLabels: {
			format: '<div style="text-align:center"><span style="font-size:15px;color:' +
			((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
			'<span style="font-size:12px;color:silver"></span></div>'
		},
		tooltip: {valueSuffix: ''}
	}]

}));

// The sales_ret gauge
var chartSpeed = Highcharts.chart('sales_ret', Highcharts.merge(gaugeOptions, {
	yAxis: {min: 0,max: 100,title: {text: ''}},
	credits: {enabled: false},
	exporting: {enabled: false},

	series: [{
		name: 'Speed',
		data: [parseFloat(sales_ret_qty_percentage)],
		dataLabels: {
			format: '<div style="text-align:center"><span style="font-size:15px;color:' +
			((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
			'<span style="font-size:12px;color:silver"></span></div>'
		},
		tooltip: {valueSuffix: ''}
	}]

}));

// The stock gauge
var chartSpeed = Highcharts.chart('stock', Highcharts.merge(gaugeOptions, {
	yAxis: {min: 0,max: 100,title: {text: ''}},
	credits: {enabled: false},
	exporting: {enabled: false},

	series: [{
		name: 'Speed',
		data: [parseFloat(stock_qty_percentage)],
		dataLabels: {
			format: '<div style="text-align:center"><span style="font-size:15px;color:' +
			((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
			'<span style="font-size:12px;color:silver"></span></div>'
		},
		tooltip: {valueSuffix: ''}
	}]

}));
}
function tbl_data(itemcode,d_from,d_to){
	var pur_qty_range = 0;
	var pur_qty_all = 0;
	var pur_qty_percentage = 0;
	var pur_amt_range = 0;
	var pur_amt_all = 0;

	var sales_qty_range = 0;
	var sales_qty_all = 0;
	var pur_ret_qty_percentage = 0;
	var sales_amt_range = 0;
	var sales_amt_all = 0;

	var pur_ret_qty_range= 0;
	var pur_ret_qty_all= 0;
	var pur_ret_amt_range= 0;
	var pur_ret_amt_all= 0;
	var pur_ret_qty_percentage= 0;

	var sales_ret_qty_range= 0;
	var sales_ret_qty_all= 0;
	var sales_ret_amt_range= 0;
	var sales_ret_amt_all= 0;
	var sales_ret_qty_percentage= 0;

	var stock_qty_range= 0;
	var stock_qty_all= 0;
	var stock_amt_range= 0;
	var stock_amt_all= 0;
	var stock_qty_percentage= 0;

	var profit = 0;
	var profit_str = ' Profit Earned: 150,000.00 LKR';

	$.post("index.php/main/load_data/items_dashboard/tbl_data", {
    itemcode :itemcode,
    d_from:d_from,
    d_to:d_to
	}, function(r){
		pur_qty_range = (parseFloat(r.purchase_RANGE)=='0'?0:parseFloat(r.purchase_RANGE[0].qty));
		pur_qty_all = (parseFloat(r.purchase_ALL)=='0'?0:parseFloat(r.purchase_ALL[0].qty));
		pur_amt_range = ((r.purchase_RANGE)=='0'?' 0 LKR':(r.purchase_RANGE[0].amount));
		pur_amt_all = (parseFloat(r.purchase_ALL) =='0'?' 0 LKR':parseFloat(r.purchase_ALL[0].amount));
		pur_qty_percentage = accounting.toFixed(parseFloat((pur_qty_range/pur_qty_all)*100), 2);
		//alert(pur_qty_percentage);

		sales_qty_range = (parseFloat(r.sales_RANGE)=='0'?0:parseFloat(r.sales_RANGE[0].qty));
		sales_qty_all = (parseFloat(r.sales_ALL)=='0'?0:parseFloat(r.sales_ALL[0].qty));
		sales_amt_range = ((r.sales_RANGE)=='0'?' 0 LKR':(r.sales_RANGE[0].amount));
		sales_amt_all = ((r.sales_ALL)=='0'?' 0 LKR':(r.sales_ALL[0].amount));
		sales_qty_percentage = accounting.toFixed(parseFloat((sales_qty_range/sales_qty_all)*100), 2);
		//alert(sales_qty_percentage);


		pur_ret_qty_range = (parseFloat(r.pur_ret_item)=='0'?0:parseFloat(r.pur_ret_item[0].ret_qty));
		pur_ret_qty_all = (parseFloat(r.pur_ret_all)=='0'?0:parseFloat(r.pur_ret_all[0].ret_qty));
		pur_ret_amt_range = ((r.pur_ret_item)=='0'?' 0 LKR':(r.pur_ret_item[0].ret_amount));
		pur_ret_amt_all = (parseFloat(r.pur_ret_all) =='0'?' 0 LKR':parseFloat(r.pur_ret_all[0].ret_amount));
		pur_ret_qty_percentage = accounting.toFixed(parseFloat((pur_ret_qty_range/pur_ret_qty_all)*100), 2);
		//alert(pur_qty_percentage);

		sales_ret_qty_range = (parseFloat(r.sales_ret_item)=='0'?0:parseFloat(r.sales_ret_item[0].ret_qty));
		sales_ret_qty_all = (parseFloat(r.sales_ret_all)=='0'?0:parseFloat(r.sales_ret_all[0].ret_qty));
		sales_ret_amt_range = ((r.sales_ret_item)=='0'?' 0 LKR':(r.sales_ret_item[0].ret_amount));
		sales_ret_amt_all = (parseFloat(r.sales_ret_all) =='0'?' 0 LKR':parseFloat(r.sales_ret_all[0].ret_amount));
		sales_ret_qty_percentage = accounting.toFixed(parseFloat((sales_ret_qty_range/sales_ret_qty_all)*100), 2);
		//alert(pur_qty_percentage);


		stock_qty_range = (parseFloat(r.stock_item)=='0'?0:parseFloat(r.stock_item[0].qty));
		stock_qty_all = (parseFloat(r.stock_all)=='0'?0:parseFloat(r.stock_all[0].qty));
		stock_amt_range = ((r.stock_item)=='0'?' 0 LKR':(r.stock_item[0].amount));
		stock_amt_all = (parseFloat(r.stock_all) =='0'?' 0 LKR':parseFloat(r.stock_all[0].amount));
		stock_qty_percentage = accounting.toFixed(parseFloat((stock_qty_range/stock_qty_all)*100), 2);
		//alert(pur_qty_percentage);

		profit = ((r.profit)=='0'?' 0':(r.profit[0].profit));
		profit_str = ' Profit Earned: '+profit+' LKR';

	    $("#purchase_amount").html(pur_amt_range);
	    $("#purchase_qty").html(pur_qty_range);
	    
	    $("#sales_amount").html(sales_amt_range);
	    $("#sales_qty").html(sales_qty_range);

	    $("#purchase_ret_amount").html(pur_ret_amt_range);
	    $("#purchase_ret_qty").html(pur_ret_qty_range);

	    $("#sales_ret_amount").html(sales_ret_amt_range);
	    $("#sales_ret_qty").html(sales_ret_qty_range);

	    $("#stock_amount").html(stock_amt_range);
	    $("#stock_qty").html(stock_qty_range);

	    $("#profit").html(profit_str);

	    draw_chart(pur_qty_percentage,sales_qty_percentage, pur_ret_qty_percentage,sales_ret_qty_percentage,stock_qty_percentage);
	}, "json");
}

function load_last_sales(itemcode,d_from,d_to){
	$.post("index.php/main/load_data/items_dashboard/load_last_sales", {
    itemcode :itemcode,
    d_from:d_from,
    d_to:d_to
	}, function(r){
	    $("#last_sales_details").html(r);
	}, "text");
}

function load_last_purchase(itemcode,d_from,d_to){
	$.post("index.php/main/load_data/items_dashboard/load_last_purchase", {
    itemcode :itemcode,
    d_from:d_from,
    d_to:d_to
	}, function(r){
	    $("#last_purchase_details").html(r);
	}, "text");
}

function load_item_movement(itemcode,d_from,d_to){
	$.post("index.php/main/load_data/items_dashboard/load_item_movement", {
    itemcode :itemcode,
    d_from:d_from,
    d_to:d_to
}, function(r){
    $("#items_movement_details").html(r);
}, "text");
}

function load_stock_det(itemcode,d_from,d_to){
	$.post("index.php/main/load_data/items_dashboard/load_stock_det", {
    itemcode :itemcode
}, function(r){
    $("#stock_details").html(r);
}, "text");
}

function load_divs(itemcode,d_from,d_to){
	$(".data-box").fadeOut();
	$(".data-box").fadeIn('slow');

	$.post("index.php/main/load_data/items_dashboard/view_item_info", {
    itemcode :itemcode
}, function(r){
    $("#item_title").html(r.description);
    $("#div_dpt").html(r.dpt);
	$("#div_maincat").html(r.maincat);
	$("#div_cat").html(r.subcat);
	$("#div_rol").html(r.rol);
	$("#div_roq").html(r.roq);
	$("#item_img").css('background-image', 'url(' + r.pic_picture + ')');
	$("#big-img").attr('src',r.pic_picture);
}, "json");
}

function load_items(){        
 $.post("index.php/main/load_data/items_dashboard/item_list_all", {
    search : $("#item_search").val()
}, function(r){
    $("#items_grid").html(r);
    settings();
}, "text");
}

function settings(){
    
}