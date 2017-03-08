  <!-- Dashboard Module CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/dashboard_module.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/items_dashboard.css" />

  
  <script src="<?= base_url(); ?>js/items_dashboard.js"></script>
  <script>
  	$( function() {
  		$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  		load_items();
  	} );
  	
  	$(document).on("click","#item_img", function(){
  		$('#item_img_modal').modal('show');
  	});
  	// item_img_modal
  	$(document).on("click","#item_img_modal", function(){
  		$('#item_img_modal').modal('hide');
  	});


  	// Items Selection Modal
  	$(document).on("click","#itemname", function(){
  		load_items();
  		$('#item_modal').modal('show');
  		
  	});
  	$(document).on("keyup","#item_search", function(){
  		load_items();
  	});

  	$(document).on("click",".item_row", function(){
    	var obj = $(this);
        $("#itemname").val(obj.attr('data-description'));
        $("#itemcode").val(obj.attr('data-code'));
		$('#item_modal').modal('hide');
    });
  	

  </script>


  <style>

</style>


<div class="text-center" id="loading" style="display:none; width:100%; height: 100%; z-index:10000; position: absolute; background-color: rgba(83,77,77,0.655);">
	<img src="<?=base_url(); ?>images/spin.gif" alt="" style="width:150px; height: 150px;margin-top:15%;" >
</div>

<!-- Modals item Image -->
<div class="modal fade" id="item_img_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style=";">
	<div class="text-center">
		<div class="row" style="margin-top: 10%;">
			<img id="big-img" src="<?=base_url(); ?>images/no_image.jpg" alt="" style="width:500px; height:350px; " >
		</div>
		
	</div>
</div>

<!-- Items Selection modal -->
<div id="item_modal" class="modal " role="dialog">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Items List</h4>
                      </div>
                      <div class="modal-body">
                        <input  type="text" id="item_search" name="" class="form-control" />
                        <table class="table table-fixed history_tbl">
                          <thead>
                            <tr>
                              <th class="col-sm-3">Code</th>
                              <th class="col-sm-6">Items Name</th>
                              <th class="col-sm-2">Model</th>
                              <th class="col-sm-1"></th>
                            </tr>
                          </thead>
                          <tbody id="items_grid">
                          	
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

<div id="blocker"></div>
<div id="logout">

</div>
</div>


<!-- Date Range -->
<div class="row" style="border-bottom:2px solid Green; padding:10px; background-color:#cccccc;">
	<div class="col-sm-6" id="item_input">
		<div class="row">
			<div class="form-group">
				<div class="col-sm-2 text-right">
					<span class="glyphicon glyphicon-tower" > Item:</span>
				</div>

				<div class="col-sm-10">
					<input type="text" class="form-control input-sm" id="itemname" name="itemname" placeholder="Click Me to Load Items">
					<input type="hidden" class="form-control input-sm" id="itemcode" name="itemcode">
				</div>
			</div>
		</div>

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
				<a id="load_dash" class="btn btn-primary" style="">
					<img src="<?=base_url(); ?>images/gps.gif" alt="" style="width:25px; height: 25px;" > LOAD &nbsp;&nbsp;
				</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-10">
		<div class="data-box" id="item_info">
			<div class="row">
				<!-- top tiles -->
				<div class="row tile_count ">
					<div class="col-md-3 col-sm-3 col-xs-4 tile_stats_count text-center">
						<span class="count_top"><i class="fa fa-bank"></i> Department</span>
						<div id="div_dpt" class="count green"></div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-4 tile_stats_count text-center">
						<span class="count_top"><i class="fa fa-bank"></i> Main Category</span>
						<div id="div_maincat" class="count green"></div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count text-center">
						<span class="count_top"><i class="fa fa-bank"></i> Category</span>
						<div id="div_cat" class="count green"></div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count text-center">
						<span class="count_top"><i class="fa fa-cubes"></i> ROL</span>
						<div id="div_rol" class="count green"></div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count text-center">
						<span class="count_top"><i class="fa fa-cubes"></i> ROQ</span>
						<div id="div_roq" class="count green"></div>
					</div>
				</div>
				<!-- /top tiles -->
			</div>
		</div>
	</div>
	<div class="col-sm-2">
	
		<div id="item_img" class="data-box" style="background:url('<?=base_url(); ?>images/no_image.jpg');">
			
		</div>
	
		
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="data-box">
			<div id="profit-div" class="row text-center">
				<h3><span id="item_title"> </span>|<span id="profit" style="font-style:bolder; color: #1ABB9C"></span></h3>
			</div>
			<div class="row" style="margin: 5px;">
				<table class="table table-striped">
					<tr>
						<th class="text-center col-sm-1"></th>
						<th class="text-center col-sm-2">Purchase</th>
						<th class="text-center col-sm-2">Sales</th>
						<th class="text-center col-sm-2">Perchase Return</th>
						<th class="text-center col-sm-2">Sales Return</th>
						<th class="text-center col-sm-2">Stock</th>
					</tr>
					<tr>
						<th>Value</th>
						<td id="purchase_amount" class="text-center">0.00 LKR</td>
						<td id="sales_amount" class="text-center">0.00 LKR</td>
						<td id="purchase_ret_amount" class="text-center">0.00 LKR</td>
						<td id="sales_ret_amount" class="text-center">0.00 LKR</td>
						<td id="stock_amount" class="text-center">0.00 LKR</td>
					</tr>
					<tr>
						<th>Qty.</th>
						<td id="purchase_qty" class="text-center">0</td>
						<td id="sales_qty" class="text-center">0</td>
						<td id="purchase_ret_qty" class="text-center">0</td>
						<td id="sales_ret_qty" class="text-center">0</td>
						<td id="stock_qty" class="text-center">0</td>
					</tr>
					<tr>
						<th></th>
						<td class="text-center">
							<div class="chart-box" id="purchase"></div>
						</td>
						<td class="text-center">
							<div class="chart-box" id="sales"></div>
						</td>
						<td class="text-center">
							<div class="chart-box" id="purchase_ret"></div>
						</td>
						<td class="text-center">
							<div class="chart-box" id="sales_ret"></div>
						</td>
						<td class="text-center">
							<div class="chart-box-right" id="stock"></div>
						</td>
					</tr>
				</table>
			</div>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-6">
		<div id="tab_left" class="data-box history_tabs">
			<ul  class="nav nav-pills">
				<li class="active">
					<a  href="#last_purchase" data-toggle="tab">Purchase Last 5 Records</a>	
				</li>
				<li>
					<a  href="#last_sales" data-toggle="tab">Sales Last 5 Records</a>
				</li>
			</ul>

			<div class="tab-content clearfix">
				<div class="tab-pane active" id="last_purchase">
					<table class="table table-striped  history_tbl">
						<thead>
							<tr>
								<th class="col-xs-1">#</th>
								<th class="col-xs-1">No.</th>
								<th class="col-xs-2">Batch</th>
								<th class="col-xs-2">Price</th>
								<th class="col-xs-2">Qty.</th>
								<th class="col-xs-2">Discount</th>
								<th class="col-xs-2">Amount</th>
							</tr>
						</thead>
						<tbody id="last_purchase_details"></tbody>
						</table>
					
				</div>
				<div class="tab-pane" id="last_sales">
					<table class="table table-striped history_tbl">
						<thead>
							<tr>
								<th class="col-xs-1">#</th>
								<th class="col-xs-3">Type</th>
								<th class="col-xs-2">Date</th>
								<th class="col-xs-2">Price</th>
								<th class="col-xs-1">Qty.</th>
								<th class="col-xs-1">Disc.</th>
								<th class="col-xs-2">Amount</th>
							</tr>
						</thead>
						<tbody id="last_sales_details"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-md-6">
		<div id="tab_left" class="data-box history_tabs">
			<ul  class="nav nav-pills">
				<li class="active">
					<a  href="#movement" data-toggle="tab">Items Movement Last 5 Records</a>
				</li>
				<li><a href="#stock_det" data-toggle="tab">Store wise Stock Details</a>
				</li>
			</ul>

			<div class="tab-content clearfix">
				<div class="tab-pane active" id="movement">
					<table class="table table-striped history_tbl">
						<thead>
							<tr>
								<th class="col-xs-1">#</th>
								<th class="col-xs-2">Date</th>
								<th class="col-xs-6">Description</th>
								<th class="col-xs-1">No.</th>
								<th class="col-xs-1">IN</th>
								<th class="col-xs-1">OUT</th>
							</tr>
						</thead>
						<tbody id="items_movement_details"></tbody>
					</table>
				</div>
				<div class="tab-pane" id="stock_det">
					<table class="table table-striped history_tbl">
						<thead>
							<tr>
								<th class="col-xs-1">#</th>
								<th class="col-xs-3">Code</th>
								<th class="col-xs-6">Description</th>
								<th class="col-xs-2">Qty.</th>
							</tr>
						</thead>
						<tbody id=stock_details>
							<?php 
							for($i=1; $i<=10 ;$i++){
								?>
								<tr>
									<td class="col-xs-1"><?=$i?></td>
									<td class="col-xs-3">Purchase</td>
									<td class="col-xs-6">Price</td>
									<td class="col-xs-2">Qty.</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>

  <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>


