<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="image/png" href="<?= base_url(); ?>img/ico.png" rel="icon">
	<title>Inventory System - <?php echo $company; ?></title>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/inputs.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/grid.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery-ui-1.8.4_.custom.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.tablescroll.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.autocomplete.css" />
	<link href="<?= base_url(); ?>css/superfish.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>css/slider.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/menu.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.4.1.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?=base_url()?>js/jstree.min.js"></script>
<script>
  $(document).ready(function(){
	// 6 create an instance when the DOM is ready
	    $('#jstree').jstree();
	    // 7 bind to events triggered on the tree
	    $('#jstree').on("changed.jstree", function (e, data) {
	      console.log(data.selected);
	    });
	    // 8 interact with the tree - either way is OK
	    // $('button').on('click', function () {
	    //   $('#jstree').jstree(true).select_node('child_node_1');
	    //   $('#jstree').jstree('select_node', 'child_node_1');
	    //   $.jstree.reference('#jstree').select_node('child_node_1');
	    // });

  });
    
  
  </script>

	
	<script type="text/javascript" src="<?= base_url(); ?>js/autoNumeric1.6.2.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.tablescroll.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.form.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/main.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/inputs.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/menu.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>js/permition.js"></script>

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
<link rel="stylesheet" href="/resources/demos/style.css">

</head>
<body ondragstart="return false;" ondrop="return false;" >

	<div id="blocker"></div>
	<div style="display: none"><audio id="player" name="player" src="<?=base_url()?>sound/ring.ogg" controls="controls"></audio></div>
	<div id="blanket">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	
	
	<div id="serch_pop" style="width: 800px; ">
		<input type="text" id="pop_search" title="" class="input_acitve" style="width: 100%;" /><br />
		<div id="sr" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;"><button id="pop_close" >Close</button></div>
	</div>

	<div id="blocker"></div>
	<div id="blanket">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop6" style="width: 800px;">
		<input type="text" id="pop_search6" title=""  style="width: 100%;" class="input_acitve"/><br />
		<div id="sr6" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;"><button id="pop_close6" >Close</button></div>
	</div>

	<div id="blocker"></div>
	<div id="blanket">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop7" style="width: 800px;">
		<input type="text" id="pop_search7" title=""  style="width: 100%;" class="input_acitve"/><br />
		<div id="sr7" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;"><button id="pop_close7" >Close</button></div>
	</div>

	
	<div id="blocker"></div>
	<div id="blanket">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop" style="width: 800px;">
		<input type="text" id="pop_search" title=""  style="width: 100%;" class="input_acitve"/><br />
		<div id="sr" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;"><button id="pop_close" >Close</button></div>
	</div>

	<div id="blocker2"></div>
	<div id="blanket2">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop2" style="width: 800px;">
		<input type="text" id="pop_search2" title=""  style="width: 100%;" class="input_acitve"/><br />
		<div id="sr2" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;"><button id="pop_close2" >Close</button></div>
	</div>

	

	<div id="blocker3"></div>
	<div id="blanket3">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop3" style="width: 800px;">
		<div id="sr3" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;"><button id="pop_close3" >Close</button></div>
	</div>

	<div id="blocker4"></div>
	<div id="blanket4">
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop4" style="width: 800px;">
		<input type="text" id="pop_search4" title=""  style="width: 100%;" /><br />
		<div id="sr4" style="height:400px;"></div>
		<div style="text-align: right; padding-top: 7px;">
			<input type='button' value='Approve' title='Approve' id='approve4' style='display:none;'/>
			<button id="pop_close4" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop10" style="width: 800px;">
			<input type="text" id="pop_search10" title=""  style="width: 100%;" class="input_acitve"/><br />
			<div id="sr10" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close10" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop11" style="width: 800px;">
			<input type="text" id="pop_search11" title=""  style="width: 100%;" class="input_acitve"/><br />
			<div id="sr11" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close11" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop12" style="width: 800px;">
			<input type="text" id="pop_search12" title=""  style="width: 100%;" class="input_acitve"/><br />
			<div id="sr12" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close12" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop13" style="width: 800px;">
			<input type="text" id="pop_search13" title=""  style="width: 100%;" class="input_acitve"/><br />
			<div id="sr13" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close13" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop14" style="width: 800px;">
			<input type="text" id="pop_search14" title=""  style="width: 100%;" class="input_acitve"/><br />
			<div id="sr14" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close14" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop15" style="width: 800px;">
			<input type="text" id="pop_search15" title=""  style="width: 100%;" class="input_acitve"/><br />
			<div id="sr15" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close15" >Close</button></div>
		</div>

		<div id="blocker"></div>
		<div id="blanket">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<img src="<?=base_url(); ?>/img/loadingBig.gif" />
		</div>
		<div id="serch_pop_find" style="width: 800px;">
			<input type="text" id="pop_search_find" title=""  style="width: 100%;" class="input_acitve"/><br />
			Price From <input type="text" id="pop_search_find1" title=""  style="width: 20%; border: 1px solid #003399;" class="input_acitve g_input_amo"/>
			Price To <input type="text" id="pop_search_find2" title=""  style="width: 20%; border: 1px solid #003399;" class="input_acitve g_input_amo"/>
			<input type="radio" id="cost_chk" title="" name="find_prc" class="input_acitve"/>Cost
			<input type="radio" id="min_chk" title="" name="find_prc" class="input_acitve"/>Min
			<input type="radio" id="max_chk" title="" name="find_prc" class="input_acitve"/>Max



			<input type="button" id="price_btn" name="price_btn" style="width:158px;" title="Load Items" /><br />
			
			<div id="sr_find" style="height:400px;"></div>
			<div style="text-align: right; padding-top: 7px;"><button id="pop_close_find" >Close</button></div>
		</div>


		<div id="logout">
			<div class="logout">
				<div class="logout_block">
					<div class="logout_block_center"><?= $branch_det . " | "; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						<?php 
						if($this->utility->post_dated_chqs()==1){ ?>
						<img id='pending_chq' style='cursor:pointer;width:30px; height:30px; margin-top:2px; margin-left:-40px; position:absolute;>' src="<?=base_url(); ?>/img/mail_warning.png"/>
						<?php } ?>
						<img src="<?=base_url(); ?>/images/stk_rprt.png" id="st_rprt" style='cursor:pointer;width:30px; height:30px; margin-top:4px; margin-left:-35px;position:absolute;'>
						<?= $user->discription; ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
						<?= anchor("main/logout", "Logout"); ?></div>
					</div>
					<!-- <div id="open_det_box"><img id="slide_arrow" src="<?= base_url(); ?>/images/icon-menu.png"/></div> -->
				</div>
				<div id="open_det_box">
					<?php if($this->utility->is_pending()){ ?>
					<img id="slide_arrow" src="<?=base_url(); ?>/images/icon-menu_p.png"/>
					<?php }else{ ?>
					<img id="slide_arrow" src="<?=base_url(); ?>/images/icon-menu.png"/>
					<?php } ?>	
				</div>
			</div>

			<div id="display_msg">
				<div id="display_inner_msg"></div>
			</div>

			<div id="msg_box">
				<img id="close_msg_box" src="<?= base_url(); ?>/images/close_button.png"/>
				<div id="msg_box_inner">
				</div>
			</div>
			<div id="det_box">
				<img id="close_det_box" src="<?=base_url(); ?>/images/close_button.png"/>
				<?php if($this->user_permissions->is_approve('t_req_approve_sum')){ ?>
				<div id="det_box_inner"><?php if(isset($det_box)){ echo $det_box;} ?></div>
				<?php } ?>
			</div>
			<!-- <div id="det_box"> -->
			<!-- <img id="close_det_box" src="<?= base_url(); ?>/images/close_button.png"/> -->
        <!-- <div id="det_box_inner"><?php
        if (isset($det_box)) {
            echo $det_box;
        }
        ?> -->
        <!-- </div> -->
        <!-- </div> -->

        <div id="det_box2">
        	<img id="close_det_box" src="<?=base_url(); ?>/images/close_button.png"/>
        	<div id="det_box2_inner"><?php if(isset($det_box2)){ echo $det_box2;} ?></div>
        </div>



        <ul class="sf-menu">
        	<li class="current"><a  href="#a"><img src="<?=base_url()?>images/arrow.png"  /></a>
        		<ul style="width:63px;">
        			<?php 		  	

        			if($this->user_permissions->is_view('m_stores')||
        				$this->user_permissions->is_view('r_department')||
        				$this->user_permissions->is_view('r_category')|| 
        				$this->user_permissions->is_view('r_sub_cat')||
        				$this->user_permissions->is_view('r_units')||
        				$this->user_permissions->is_view('r_brand')||
        				$this->user_permissions->is_view('r_color')||
        				$this->user_permissions->is_view('r_subitem')||
        				$this->user_permissions->is_view('m_items')||
        				$this->user_permissions->is_view('r_additional_items')||
        				$this->user_permissions->is_view('m_item_free')||
        				$this->user_permissions->is_view('m_item_rol')||
        				$this->user_permissions->is_view('t_price_change_sum')||
        				$this->user_permissions->is_view('t_price_change_batch_sum')||
        				$this->user_permissions->is_view('return_reason')||
        				$this->user_permissions->is_view('r_area')||
        				$this->user_permissions->is_view('r_town')||
        				$this->user_permissions->is_view('r_root')|| 
        				$this->user_permissions->is_view('r_nationality')||
        				$this->user_permissions->is_view('r_cus_category')||
        				$this->user_permissions->is_view('r_customer_type')||
        				$this->user_permissions->is_view('r_sup_category')||
        				$this->user_permissions->is_view('m_supplier')||
        				$this->user_permissions->is_view('m_account_category')||
        				$this->user_permissions->is_view('m_account_type')||
        				$this->user_permissions->is_view('m_bank')||
        				$this->user_permissions->is_view('m_bank_branch')||
        				$this->user_permissions->is_view('m_default_account')||
        				$this->user_permissions->is_view('m_account')||
        				$this->user_permissions->is_view('r_journal_type'))
        			{
        				?>
        				<li> <a href="#"><img src="<?php echo base_url(); ?>images/master.png" alt="" width="53" height="43"  /></a>
        					<ul>
        						<?php if($this->user_permissions->is_view('m_stores')||
        							$this->user_permissions->is_view('r_department')||
        							$this->user_permissions->is_view('r_category')|| 
        							$this->user_permissions->is_view('r_sub_cat')||
        							$this->user_permissions->is_view('r_units')||
        							$this->user_permissions->is_view('r_brand')||
        							$this->user_permissions->is_view('r_color')||
        							$this->user_permissions->is_view('r_subitem')||
        							$this->user_permissions->is_view('m_items')||
        							$this->user_permissions->is_view('r_additional_items')||
        							$this->user_permissions->is_view('m_item_free')||
        							$this->user_permissions->is_view('m_item_rol')||
        							$this->user_permissions->is_view('t_price_change_sum')||
        							$this->user_permissions->is_view('t_price_change_batch_sum')||
        							$this->user_permissions->is_view('m_free_issue')||
        							$this->user_permissions->is_view('m_free_issue_sales')||
        							$this->user_permissions->is_view('return_reason'))
        						{ 
        							
        							?>
        							<li><a href="#" class="parent"><span>Item</span></a>
        								<ul>
        									<?php if($this->user_permissions->is_view('m_stores')){ ?><li ><a  href="?action=m_stores">Store</a></li><?php } ?>
        									<hr class="hline"/>	
        									<?php if($this->user_permissions->is_view('r_department')){ ?><li ><a  href="?action=r_department">Department</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('r_category')){ ?><li><a  href="?action=r_category">Category</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('r_sub_cat')){ ?><li><a  href="?action=r_sub_cat">Sub Category</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('r_units')){ ?><li><a  href="?action=r_units">Unit</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('r_brand')){ ?><li><a  href="?action=r_brand">Brand</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('r_color')){ ?> <li><a  href="?action=r_color">Color</a></li> <?php } ?>
        									<hr class="hline"/>
        									<!--<?php if($this->user_permissions->is_view('r_subitem')){ if($ds['use_sub_items']){ ?> <li><a  href="?action=r_subitem">Sub Item</a></li><?php }} ?>-->
        									<?php if($this->user_permissions->is_view('m_items')){ ?><li><a  href="?action=m_items">Item Details</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('m_barcode_print')){ ?><li><a  href="?action=m_barcode_print">Barcode Print</a></li><?php } ?>
        									<hr class="hline"/>
        									
        									<?php if($this->user_permissions->is_view('r_additional_items')){ ?><li><a  href="?action=r_additional_items">Additional Item</a></li><?php } ?>
        									<hr class="hline"/>
        									<?php if($this->user_permissions->is_view('m_item_free')){ ?><li><a  href="?action=m_item_free">Item Free Issue(FOC)</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('m_free_issue')){ ?><li><a target="_blank" href="?action=m_free_issue">FOC Bulk Purchase</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('m_free_issue_sales')){ ?><li><a target="_blank" href="?action=m_free_issue_sales">FOC Bulk Sales</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('m_item_rol')){ ?><li><a  href="?action=m_item_rol">Branch wise Re-Order Level</a></li><?php } ?>
        									<hr class="hline"/>
        									<!-- 						<?php if($this->user_permissions->is_view('t_price_change_sum')){ ?><li><a  href="?action=t_price_change_sum">Price Change</a></li><?php } ?>-->							<?php if($this->user_permissions->is_view('t_price_change_batch_sum')){ ?><li><a target="_blank" href="?action=t_price_change_batch_sum">Price Change In Batch</a></li><?php } ?>
        									<?php if($this->user_permissions->is_view('return_reason')){ ?><li><a  href="?action=return_reason">Sales\Purchase Return Reason</a></li><?php } ?>
        								</ul>

        							</li>
        							<?php } ?>
        							<?php
        							if($this->user_permissions->is_view('r_area')||
        								$this->user_permissions->is_view('r_town')||
        								$this->user_permissions->is_view('r_root')|| 
        								$this->user_permissions->is_view('r_nationality')||
        								$this->user_permissions->is_view('r_cus_category')||
        								$this->user_permissions->is_view('r_customer_action')||
        								$this->user_permissions->is_view('m_customer_inquiries')||
        								$this->user_permissions->is_view('r_customer_type'))
        							{ 
        								
        								?>
        								<li><a href="#" class="parent"><span>Customer</span></a>
        									<ul>
        										<?php if($this->user_permissions->is_view('r_area')){ ?><li><a  href="?action=r_area">Area</a></li><?php } ?>
        										<?php if($this->user_permissions->is_view('r_town')){ ?><li><a  href="?action=r_town">Town</a></li><?php } ?>
        										<?php if($this->user_permissions->is_view('r_root')){ ?><li><a  href="?action=r_root">Route</a></li><?php } ?>
        										<?php if($this->user_permissions->is_view('r_nationality')){ ?><li><a  href="?action=r_nationality">Nationality</a></li><?php } ?>
        										<?php if($this->user_permissions->is_view('r_cus_category')){ ?><li><a  href="?action=r_cus_category">Customer Category</a></li><?php } ?>
        										<?php if($this->user_permissions->is_view('r_customer_type')){ ?><li><a  href="?action=r_customer_type">Customer Type</a></li><?php } ?>
        										<hr class="hline"/>
        										<?php if($this->user_permissions->is_view('r_customer_action')){ ?> <li><a href="?action=r_customer_action">Customer Actions</a></li> <?php } ?>
        										<?php if($this->user_permissions->is_view('m_customer_inquiries')){ ?> <li><a href="?action=m_customer_inquiries">Customer Inquiries</a></li> <?php } ?>
        										<?php if($this->user_permissions->is_view('m_customer_status')){ ?><li><a href="?action=m_customer_status">Customer Status</a></li><?php } ?>
        										<?php if($this->user_permissions->is_view('m_customer')){ ?><li><a  href="?action=m_customer">Customer</a></li><?php } ?>
        									</ul>
        								</li>
        								<?php } ?>
        								
        								<?php 
        								if($this->user_permissions->is_view('r_sup_category')||
        									$this->user_permissions->is_view('m_supplier'))
        								{ 
        									
        									?>	
        									<li><a href="#" class="parent"><span>Supplier</span></a>
        										<ul>
        											<?php if($this->user_permissions->is_view('r_sup_category')){ ?><li><a  href="?action=r_sup_category">Supplier Category</a></li><?php } ?>
        											<hr class="hline"/>
        											<?php if($this->user_permissions->is_view('m_supplier')){ ?><li><a  href="?action=m_supplier">Supplier</a></li><?php } ?>
        										</ul>
        									</li>
        									<?php } ?>

        									<?php 
        									if(  $this->user_permissions->is_view('r_credit_card_rate')||
        										$this->user_permissions->is_view('m_account_category')||
        										$this->user_permissions->is_view('m_account_type')||
        										$this->user_permissions->is_view('m_bank')||
        										$this->user_permissions->is_view('m_bank_branch')||
        										$this->user_permissions->is_view('m_default_account')||
        										$this->user_permissions->is_view('m_account')||
        										$this->user_permissions->is_view('r_journal_type'))
        									{ 
        										
        										?>	
        										<li><a href="#" class="parent"><span>Account</span></a>
        											<ul>
        												<?php if($this->user_permissions->is_view('m_account_category')){?><li><a  href="?action=m_account_category">Account Category</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('m_account_type')){ ?><li><a  href="?action=m_account_type">Account Setup</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('m_bank')){ ?><li><a  href="?action=m_bank">Bank</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('m_bank_branch')){ ?><li><a  href="?action=m_bank_branch">Bank Branch</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('m_default_account')){ ?><li><a  href="?action=m_default_account">Default Account</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('r_journal_type')){ ?><li><a  href="?action=r_journal_type">Journal Type</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('r_credit_card_rate')){ ?><li><a  href="?action=r_credit_card_rate">Credit Card Rate Setup</a></li><?php } ?>
        											</ul>
        										</li>
        										<li><a href="#" class="parent"><span>Sales</span></a>
        											<ul>
        												<?php if($this->user_permissions->is_view('r_sales_category')){ ?><li><a  href="?action=r_sales_category">Sales Category</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('r_groups')){ ?><li><a  href="?action=r_groups">Group Sales</a></li><?php } ?> 
        											</ul>
        										</li>

        										<li><a href="#" class="parent"><span>Employee</span></a>
        											<ul>
        												<?php if($this->user_permissions->is_view('m_employee_category')){ ?><li><a  href="?action=m_employee_category">Employee Category</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('m_employee_details')){ ?><li><a  href="?action=m_employee_details">Employee Details</a></li><?php } ?>
        												<?php if($this->user_permissions->is_view('m_employee_activity')){ ?><li><a  href="?action=m_employee_activity">Employee Activity</a></li><?php } ?>
        												
        											</ul>
        										</li> 
        										<li><a href="#" class="parent"><span>Vehicle</span></a>
        											<ul>
        												<?php if($this->user_permissions->is_view('m_vehicle_setup')){ ?><li><a  href="?action=m_vehicle_setup">Vehicle Setup</a></li><?php } ?>
        											</ul>
        										</li>

        										<?php } ?>


        									</ul>
        								</li>
        								<?php } ?>

        								<?php 

        								if($this->user_permissions->is_view('r_groups')||
        									$this->user_permissions->is_view('r_sales_category')||
        									$this->user_permissions->is_view('t_quotation_sum')||
        									$this->user_permissions->is_view('t_cash_sales_sum')||
        									$this->user_permissions->is_view('t_credit_sales_sum')||
        									$this->user_permissions->is_view('t_sales_return_sum')||
        									$this->user_permissions->is_view('t_sales_return_sum_without_invoice')||
        									$this->user_permissions->is_view('t_receipt')||
        									$this->user_permissions->is_view('t_cus_settlement')||
        									$this->user_permissions->is_view('t_req_sum')||
        									$this->user_permissions->is_view('t_req_approve_sum')||
        									$this->user_permissions->is_view('t_po_sum')||
        									$this->user_permissions->is_view('t_grn_sum')||
        									$this->user_permissions->is_view('t_free_purchase')||
        									$this->user_permissions->is_view('t_pur_ret_sum')||
        									$this->user_permissions->is_view('t_voucher')||
        									$this->user_permissions->is_view('t_sup_settlement')||
        									$this->user_permissions->is_view('t_open_stock')||
        									$this->user_permissions->is_view('t_serial_adjustment_sum')||
        									$this->user_permissions->is_view('t_adjustment_sum')||
        									$this->user_permissions->is_view('t_damage_sum')||
        									$this->user_permissions->is_view('t_internal_transfer_order')||
        									$this->user_permissions->is_view('t_internal_transfer')||
        									$this->user_permissions->is_view('t_internal_transfer_receive')||
        									$this->user_permissions->is_view('t_direct_internal_transfer')||
        									$this->user_permissions->is_view('t_direct_internal_transfer_receive')||
        									$this->user_permissions->is_view('t_dispatch_sum')||
        									$this->user_permissions->is_view('t_dispatch_unloading')||
        									$this->user_permissions->is_view('t_dispatch_note')||
        									$this->user_permissions->is_view('t_privilege_card')||
        									$this->user_permissions->is_view('t_privilege_card_update')||
        									$this->user_permissions->is_view('t_privilage_trans')||
        									$this->user_permissions->is_view('t_job')||
        									$this->user_permissions->is_view('t_job_update')||
        									$this->user_permissions->is_view('t_job_reject')||
        									$this->user_permissions->is_view('t_job_receive')||
        									$this->user_permissions->is_view('t_job_issue')||
        									$this->user_permissions->is_view('t_repair_dash_bord')||
        									$this->user_permissions->is_view('t_credit_note')||
        									$this->user_permissions->is_view('t_debit_note')||
        									$this->user_permissions->is_view('r_credit_card_rate')||
        									$this->user_permissions->is_view('t_advance_payment')||
        									$this->user_permissions->is_view('t_receipt_general')||
        									$this->user_permissions->is_view('t_gift_voucher')||
        									$this->user_permissions->is_view('t_opening_balance')||
        									$this->user_permissions->is_view('t_journal_sum')||
        									$this->user_permissions->is_view('t_payable_invoice')||
        									$this->user_permissions->is_view('t_receivable_invoice')||
        									$this->user_permissions->is_view('t_pettycash')||
        									$this->user_permissions->is_view('t_account_receipt')||
        									$this->user_permissions->is_view('t_bank_entry')||
        									$this->user_permissions->is_view('t_credit_card_reconcil')||
        									$this->user_permissions->is_view('t_bankrec')||
        									$this->user_permissions->is_view('t_cheque_deposit')||
        									$this->user_permissions->is_view('t_cheques')||
        									$this->user_permissions->is_view('t_cheque_issue_trans')||
        									$this->user_permissions->is_view('t_receipt_temp')||
        									$this->user_permissions->is_view('m_employee')||
        									$this->user_permissions->is_view('r_designation')||
        									$this->user_permissions->is_view('m_authorization')||
        									$this->user_permissions->is_view('t_day_process')||
        									$this->user_permissions->is_view('t_authorization_update'))
{
	?>
	
	<li>
		<a href="#"><img src="<?php echo base_url(); ?>images/transaction.png" alt="" width="53" height="43" /></a>
		<ul>
			<?php 

			if($this->user_permissions->is_view('r_groups')||
				$this->user_permissions->is_view('r_group_sales_budget')||
				$this->user_permissions->is_view('r_sales_category')||
				$this->user_permissions->is_view('t_quotation_sum')||
				$this->user_permissions->is_view('t_cash_sales_sum')||
				$this->user_permissions->is_view('t_credit_sales_sum')||
				$this->user_permissions->is_view('t_sales_return_sum')||
				$this->user_permissions->is_view('t_sales_return_sum_without_invoice')||
				$this->user_permissions->is_view('t_receipt')||
				$this->user_permissions->is_view('t_gift_voucher')||
				$this->user_permissions->is_view('t_advance_payment')||
				$this->user_permissions->is_view('t_cus_settlement'))
			{ 
				?>
				<li><a href="#" class="parent"><span>Sales</span></a>
					<ul>
						<!-- <?php if($this->user_permissions->is_view('r_group_sales_budget')){ ?><li><a  href="?action=r_group_sales_budget">Group Sales Budget</a></li><?php } ?> -->
						<hr class="hline"/>
						<?php if($this->user_permissions->is_view('t_quotation_sum')){ ?><li><a  href="?action=t_quotation_sum">Quotation</a></li><?php } ?>
						<hr class="hline"/>
						<?php if($this->user_permissions->is_view('t_sales_order')){ ?><li><a  href="?action=t_sales_order">Sales Order</a></li><?php } ?>
						<?php if($this->user_permissions->is_view('t_sales_order_sales_sum')){ ?><li><a  href="?action=t_sales_order_sales_sum">Sales Order Sales</a></li><?php } ?>
                            <!-- <?php if($this->user_permissions->is_view('t_delivery_note')){ ?><li><a  href="?action=t_delivery_note">Delivary Note</a></li><?php } ?> 
                            <?php if($this->user_permissions->is_view('t_cash_and_card_sales_sum')){ ?><li><a  href="?action=t_cash_and_card_sales_sum">Card & Cash Sales</a></li><?php } ?> -->

                            <?php if($this->user_permissions->is_view('t_cash_sales_sum')){ ?><li><a  href="?action=t_cash_sales_sum">Cash Sales</a></li><?php } ?>
                            <?php if($this->user_permissions->is_view('t_credit_sales_sum')){ ?><li><a  href="?action=t_credit_sales_sum">Credit Sales</a></li><?php } ?>

                            <!-- <li><a  href="?action=t_special_sales_sum">Special Approve (Sales)</a></li> -->

                            <?php if($this->user_permissions->is_view('t_sales_return_sum')){ ?><li><a  href="?action=t_sales_return_sum">Sales Return With Invoice</a></li><?php } ?>
                            <?php if($this->user_permissions->is_view('t_sales_return_sum_without_invoice')){ ?><li><a  href="?action=t_sales_return_sum_without_invoice">Sales Return Without Invoice</a></li><?php } ?>
                            
                            <hr class="hline"/>

                            
                            <?php if($this->user_permissions->is_view('t_receipt')){ ?><li><a  href="?action=t_receipt">Reciept</a></li><?php } ?>
                            <?php if($this->user_permissions->is_view('t_cus_settlement')){ ?><li><a  href="?action=t_cus_settlement">Customer Settlement</a></li><?php } ?>
                            <?php if($this->user_permissions->is_view('t_advance_payment')){ ?><li><a  href="?action=t_advance_payment">Advance Payment</a></li><?php } ?>
                            <?php if($this->user_permissions->is_view('t_advance_refund')){ ?> <li><a  href="?action=t_advance_refund">Advance Refund</a></li> <?php } ?>
                            <?php if($this->user_permissions->is_view('t_delevery_note')){ ?> <li><a  href="?action=t_delevery_note">Delivery Note</a></li> <?php } ?>
                            <!--<?php if($this->user_permissions->is_view('t_gift_voucher')){ ?><li><a  href="?action=t_gift_voucher">Gift Voucher</a></li><?php } ?> -->                        </ul>
                        </li>
                        <?php } ?>

                        <?php 
                        if($this->user_permissions->is_view('t_req_sum')||
                        	$this->user_permissions->is_view('t_req_approve_sum')||
                        	$this->user_permissions->is_view('t_po_sum')||
                        	$this->user_permissions->is_view('t_grn_sum')||
                        	$this->user_permissions->is_view('t_free_purchase')||
                        	$this->user_permissions->is_view('t_pur_ret_sum')||
                        	$this->user_permissions->is_view('t_voucher')||
                        	$this->user_permissions->is_view('t_sup_settlement'))
                        { 
                        	?>
                        	<li><a href="#" class="parent"><span>Purchase</span></a>
                        		<ul>
                        	<!-- <?php if($this->user_permissions->is_view('t_req_sum')){ ?><li><a  href="?action=t_req_sum">Purchase Requisition</a></li><?php } ?>
                        	<?php if($this->user_permissions->is_view('t_req_approve_sum')){ ?><li><a  href="?action=t_req_approve_sum">Purchase Requisition Approve</a></li><?php } ?>-->
                        	<?php if($this->user_permissions->is_view('t_po_sum')){ ?><li><a  href="?action=t_po_sum">Purchase Order</a></li><?php } ?>
                        	<hr class="hline"/>
                        	<?php if($this->user_permissions->is_view('t_grn_sum')){ ?><li><a  href="?action=t_grn_sum">Purchase</a></li><?php } ?>
                        	<?php if($this->user_permissions->is_view('t_free_purchase')){ ?><li><a  href="?action=t_free_purchase">Free Purchase</a></li><?php } ?>
                        	<?php if($this->user_permissions->is_view('t_pur_ret_sum')){ ?><li><a  href="?action=t_pur_ret_sum">Purchase Return</a></li><?php } ?>
                        	<hr class="hline"/>
                        	<?php if($this->user_permissions->is_view('t_voucher')){ ?><li><a  href="?action=t_voucher">Supplier Payment</a></li><?php } ?>
                        	<?php if($this->user_permissions->is_view('t_sup_settlement')){ ?><li><a  href="?action=t_sup_settlement">Supplier Settlement</a></li><?php } ?>
                        </ul>
                    </li>
                    <?php } ?>  

                    <?php 
                    if($this->user_permissions->is_view('t_open_stock')||
                    	$this->user_permissions->is_view('t_serial_adjustment_sum')||
                    	$this->user_permissions->is_view('t_adjustment_sum')||
                    	$this->user_permissions->is_view('t_damage_sum')||
                    	$this->user_permissions->is_view('t_dispatch_sum')||
                    	$this->user_permissions->is_view('t_dispatch_unloading')||
                    	$this->user_permissions->is_view('t_internal_transfer_order')||
                    	$this->user_permissions->is_view('t_internal_transfer')||
                    	$this->user_permissions->is_view('t_direct_internal_transfer')||
                    	$this->user_permissions->is_view('t_direct_internal_transfer_receive')||
                    	$this->user_permissions->is_view('t_internal_transfer_receive')||
                    	$this->user_permissions->is_view('t_dispatch_note'))
                    { 
                    	?>  
                    	<li><a href="#" class="parent"><span>Stock</span></a>
                    		<ul>
                    			<?php if($this->user_permissions->is_view('t_open_stock')){ ?><li><a  href="?action=t_open_stock">Opening Stock</a></li><?php } ?>
                    			<hr class="hline"/>
                    			<!-- <?php if($this->user_permissions->is_view('t_internal_transfer_order')){ ?><li><a  href="?action=t_internal_transfer_order">Internal Transfer Order</a></li><?php } ?>
                    			<?php if($this->user_permissions->is_view('t_internal_transfer')){ ?><li><a  href="?action=t_internal_transfer">Internal Transfer</a></li><?php } ?>
                    			<?php if($this->user_permissions->is_view('t_internal_transfer_receive')){ ?><li><a  href="?action=t_internal_transfer_receive">Internal Transfer Receive</a></li><?php } ?>
                    		-->

                    		<?php if($this->user_permissions->is_view('t_direct_internal_transfer')){ ?><li><a  href="?action=t_direct_internal_transfer">Direct Internal Transfer</a></li><?php } ?>
                    		<?php if($this->user_permissions->is_view('t_direct_internal_transfer_receive')){ ?><li><a  href="?action=t_direct_internal_transfer_receive">Direct Transfer Receive</a></li><?php } ?>
                    		

                    		<?php if($this->user_permissions->is_view('t_internal_transfer_return')){ ?><li><a  href="?action=t_internal_transfer_return">Internal Transfer Return</a></li><?php } ?>
                    		<hr class="hline"/>
                    		<?php if($this->user_permissions->is_view('t_serial_adjustment_sum')){ ?><li><a  href="?action=t_serial_adjustment_sum">Serial Number Adjustment</a></li><?php } ?>
                    		<?php if($this->user_permissions->is_view('t_adjustment_sum')){ ?><li><a  href="?action=t_adjustment_sum">Stock Adjustment</a></li><?php } ?>
                    		<?php if($this->user_permissions->is_view('t_damage_sum')){ ?><li><a  href="?action=t_damage_sum">Item Damage</a></li><?php } ?>
                    		<hr class="hline"/>
                    		<?php if($this->user_permissions->is_view('t_dispatch_sum')){ ?><li><a  href="?action=t_dispatch_sum">Dispatch(Loading)</a></li><?php } ?>
                    		<?php if($this->user_permissions->is_view('t_dispatch_unloading')){ ?><li><a  href="?action=t_dispatch_unloading">Dispatch(Unloading)</a></li><?php } ?>
                    		<hr class="hline"/>
                    		<?php if($this->user_permissions->is_view('t_dispatch_note')){ ?><li><a  href="?action=t_dispatch_note">Dispatch Note</a></li><?php } ?>
                    		
                    	</ul>
                    </li>  
                    <?php } ?> 

                    <?php 
                    if($this->user_permissions->is_view('t_privilege_card')||
                    	$this->user_permissions->is_view('t_privilege_card_update')||
                    	$this->user_permissions->is_view('t_privilage_trans'))
                    { 

                    	?> 
                <!-- <li><a href="#" class="parent"><span>Priviliage Card</span></a>
                        <ul>
                            <?php if($this->user_permissions->is_view('t_privilege_card')){ ?><li><a  href="?action=t_privilege_card">Issue Card</a></li><?php } ?>
                            <?php if($this->user_permissions->is_view('t_privilege_card_update')){ ?><li><a  href="?action=t_privilege_card_update">Deactivate Card</a></li><?php } ?>
                            <hr class="hline"/>
                            <?php if($this->user_permissions->is_view('t_privilage_trans')){ ?><li><a  href="?action=t_privilage_trans">Dash Board</a></li><?php } ?>                 
                        </ul>
                    </li>  -->
                    <?php } ?>  
                    
                    

              <!--   <?php 
                if($this->user_permissions->is_view('m_cluster')||
	        	 	 $this->user_permissions->is_view('m_branch'))
	        	{
                ?>
                 <li><a href="#" class="parent"><span>Company Profile</span></a>
                        <ul>
                        <?php if($this->user_permissions->is_view('m_cluster')){ ?><li><a  href="?action=m_cluster">Cluster</a></li><?php } ?> 
                        <?php if($this->user_permissions->is_view('m_branch')){ ?><li><a  href="?action=m_branch">Branches</a></li><?php } ?> 
                        </ul>
                </li>  
                <?php } ?> -->

                <?php 
                if($this->user_permissions->is_view('t_credit_note')||
                	$this->user_permissions->is_view('t_debit_note')||
                	
                	$this->user_permissions->is_view('t_receipt_general')||
                	
                	$this->user_permissions->is_view('t_opening_balance')||
                	$this->user_permissions->is_view('t_journal_sum')||
                	$this->user_permissions->is_view('t_payable_invoice')||
                	$this->user_permissions->is_view('t_receivable_invoice')||
                	$this->user_permissions->is_view('t_pettycash')||
                	$this->user_permissions->is_view('t_account_receipt'))
                { 
                	?>
                	<li><a href="#" class="parent"><span>Account</span></a>
                		<ul>
                			<?php if($this->user_permissions->is_view('t_credit_note')){ ?><li><a  href="?action=t_credit_note">Credit Note</a></li><?php } ?>
                			<?php if($this->user_permissions->is_view('t_debit_note')){ ?> <li><a  href="?action=t_debit_note">Debit Note</a></li><?php } ?>
                			<hr class="hline"/>
                			

                			<!--  <li><a  href="?action=t_receipt">Reciept</a></li> -->
                			
                			<?php if($this->user_permissions->is_view('t_receipt_general')){ ?><li><a  href="?action=t_receipt_general">General Reciept</a></li><?php } ?>
                			<?php if($this->user_permissions->is_view('t_voucher_general')){ ?><li><a  href="?action=t_voucher_general">General Voucher</a></li><?php } ?>
                			
                			<hr class="hline"/>
                			<?php if($this->user_permissions->is_view('t_opening_balance')){ ?><li><a  href="?action=t_opening_balance">Opening Balance</a></li><?php } ?>
                			<?php if($this->user_permissions->is_view('t_journal_sum')){ ?><li><a  href="?action=t_journal_sum">Journal Entry</a></li><?php } ?>

                			<?php if($this->user_permissions->is_view('t_payable_invoice')){ ?><li><a  href="?action=t_payable_invoice">Payable Invoice</a></li><?php } ?>
                			<?php if($this->user_permissions->is_view('t_receivable_invoice')){ ?><li><a  href="?action=t_receivable_invoice">Receivable Invoice</a></li><?php } ?>

                			<?php if($this->user_permissions->is_view('t_pettycash')){ ?><li><a  href="?action=t_pettycash">Petty Cash</a></li><?php } ?>
                			<?php if($this->user_permissions->is_view('t_account_receipt')){ ?><li><a  href="?action=t_account_receipt">Reciept</a></li><?php } ?>
                			<!-- <li><a  href="?action=t_bank_entry">Bank Entry</a></li> -->
                			<!-- <li><a  href="?action=t_cheque_deposit">Cheque Deposit</a></li> -->
                			
                		</ul>
                	</li>
                	<?php } ?>

                	<?php 
                	if($this->user_permissions->is_view('t_bank_entry')||
                		$this->user_permissions->is_view('t_bankrec')||
                		$this->user_permissions->is_view('t_credit_card_reconcil')||
                		$this->user_permissions->is_view('t_cheque_deposit')||
                		$this->user_permissions->is_view('t_cheques')||
                		$this->user_permissions->is_view('t_cheque_issue_trans')||
                		$this->user_permissions->is_view('t_receipt_temp'))
                	{ 
                		?>
                		<li><a href="#" class="parent"><span>Bank</span></a>
                			<ul>
                				<?php if($this->user_permissions->is_view('t_bank_entry')){ ?><li><a  href="?action=t_bank_entry">Bank Entry</a></li><?php } ?>
                				<?php if($this->user_permissions->is_view('t_credit_card_reconcil')){ ?><li><a  href="?action=t_credit_card_reconcil">Credit Card Reconcillation</a></li><?php } ?>
                				<?php if($this->user_permissions->is_view('t_bankrec')){ ?><li><a  href="?action=t_bankrec">Bank Reconciliation</a></li><?php } ?>
                				<?php if($this->user_permissions->is_view('t_cheque_deposit')){ ?><li><a  href="?action=t_cheque_deposit">Cheque Deposit</a></li><?php } ?>
                				<!--  <li><a  href="?action=t_cheque_trans">Cheque Deposit</a></li> -->
                				<?php if($this->user_permissions->is_view('t_cheques')){ ?><li><a  href="?action=t_cheques">Cheque Receipt Return</a></li><?php } ?>
                				<?php if($this->user_permissions->is_view('t_cheques_rtn_payment')){ ?><li><a  href="?action=t_cheques_rtn_payment">Cheque Payment Return</a></li><?php } ?>
                				<?php if($this->user_permissions->is_view('t_cheque_issue_trans')){ ?><li><a  href="?action=t_cheque_issue_trans">Cheque Withdraw</a></li><?php } ?>
                				<?php if($this->user_permissions->is_view('t_receipt_temp')){ ?><li><a  href="?action=t_receipt_temp">Cheque Acknowledgement</a></li><?php } ?>
                				
                			</ul>
                		</li>
                		<?php } ?>

                		


                		
                		<?php 
                		if($this->user_permissions->is_view('t_day_process'))
                		{ 
                			?>
                			<li><a href="#" class="parent"><span>Day Process</span></a>
                				<ul>
                					<?php if($this->user_permissions->is_view('t_day_process')){ ?><li><a  href="?action=t_day_process">Day Process</a></li><?php } ?> 
                				</ul>
                			</li> 
                			<?php } ?>   

                			<?php 
                			if($this->user_permissions->is_view('t_fund_transfer')||
                				$this->user_permissions->is_view('t_fund_receiver'))
                			{ 
                				?>
                				<li><a href="#" class="parent"><span>Fund Transfer</span></a>
                					<ul>
                						<?php if($this->user_permissions->is_view('t_fund_transfer')){ ?><li><a  href="?action=t_fund_transfer">Fund Transfer</a></li><?php } ?> 
                						<?php if($this->user_permissions->is_view('t_fund_receiver')){ ?><li><a  href="?action=t_fund_receiver">Fund Receiver</a></li><?php } ?> 
                					</ul>
                				</li> 
                				<?php } ?>     
                				
                			</ul>
                		</li>
                		<?php  
                		if ($this->user_permissions->view_module("def_use_hp")||
                			$this->user_permissions->is_view('m_hp_payment_scheme')||
                			$this->user_permissions->is_view('m_hp_sales_category')||
                			$this->user_permissions->is_view('m_guarantor')||
                			$this->user_permissions->is_view('t_hp')||
                			$this->user_permissions->is_view('t_opening_hp')||
                			$this->user_permissions->is_view('t_hp_seize')||
                			$this->user_permissions->is_view('t_hp_instalment_payment')||
                			$this->user_permissions->is_view('t_hp_charges_type')||
                			$this->user_permissions->is_view('t_hp_other_charges')||
                			$this->user_permissions->is_view('t_change_due_day')||
                			$this->user_permissions->is_view('t_guarantor_change')||
                			$this->user_permissions->is_view('t_hp_rebate')||
                			$this->user_permissions->is_view('t_hp_early_settlement')){ 
                				?> 
                				<li><a href="#"><img src="<?= base_url() ?>images/coin-dollar.png"  width="53" height="43" /></a>
                					<ul>
                						<?php if($this->user_permissions->is_view('m_hp_payment_scheme')){ ?><li><a  href="?action=m_hp_payment_scheme">Scheme</a></li><?php } ?> 
                						<?php if($this->user_permissions->is_view('m_hp_sales_category')){ ?><li><a  href="?action=m_hp_sales_category">Category</a></li><?php } ?> 
                						<?php if($this->user_permissions->is_view('m_guarantor')){ ?><li><a  href="?action=m_guarantor">Guarantor</a></li><?php } ?> 
                						
                						<li><a  href="#">Hire Purchase</a>
                							<ul>
                								<?php if($this->user_permissions->is_view('t_hp')){ ?><li><a  href="?action=t_hp">Hire Purchase</a></li><?php } ?> 
                								<?php if($this->user_permissions->is_view('t_opening_hp')){ ?><li><a  href="?action=t_opening_hp">Opening Hire Purchase</a></li><?php } ?>
                								<?php if($this->user_permissions->is_view('t_hp_instalment_payment')){ ?><li><a  href="?action=t_hp_instalment_payment">Installment Payment</a></li><?php } ?> 
                								<?php if($this->user_permissions->is_view('t_hp_early_settlement')){ ?><li><a  href="?action=t_hp_early_settlement">Early Settlement</a></li><?php } ?> 
                								<?php if($this->user_permissions->is_view('t_hp_charges_type')){ ?><li><a  href="?action=t_hp_charges_type">Charges Type</a></li><?php } ?> 
                								<?php if($this->user_permissions->is_view('t_hp_other_charges')){ ?><li><a  href="?action=t_hp_other_charges">Other Charges</a></li><?php } ?> 
                								<?php if($this->user_permissions->is_view('t_hp_return')){ ?><li><a  href="?action=t_hp_return">HP Return</a></li><?php } ?> 
                								<?php if($this->user_permissions->is_view('t_hp_seize')){ ?> <li><a  href="?action=t_hp_seize">HP Seize</a></li> <?php } ?>
                								<?php if($this->user_permissions->is_view('t_hp_seized_main_store')){ ?> <li><a  href="?action=t_hp_seized_main_store">HP Seize Items To Main Store</a></li> <?php } ?>
                								<?php if($this->user_permissions->is_view('t_hp_rivert_item')){ ?> <li><a  href="?action=t_hp_rivert_item">Rivert Item to Customer</a></li> <?php } ?>
                								<li><a  href="?action=t_change_due_day">Change Due Day</a></li>
                								<li><a  href="?action=t_guarantor_change">Guarantor Change</a></li>


                							</ul>
                						</li>

                						<?php if($this->user_permissions->is_view('t_hp_rebate')){ ?><li><a  href="?action=t_hp_rebate">Rebate Approve</a></li><?php } ?> 
                					</ul>
                				</li>
                				<?php } ?>
                				<?php } ?> 

                				<?php 
                				if($this->user_permissions->is_view('r_account_report')||
                					$this->user_permissions->is_view('r_stock_report')||
                					$this->user_permissions->is_view('r_debiter_list')||
                					$this->user_permissions->is_view('r_crediter_list')||
                					$this->user_permissions->is_view('r_transaction_list_purchase')||
                					$this->user_permissions->is_view('r_transaction_list_cash')||
                					$this->user_permissions->is_view('r_transaction_list_credit')||
                					$this->user_permissions->is_view('m_dialy_summery')||
                					$this->user_permissions->is_view('r_transaction_list_voucher'))
                				{ 
                					?> 	
                					<li>
                						<a href="#"><img src="<?php echo base_url(); ?>images/Reports.png" alt="" width="53" height="43" /></a>
                						<ul>
					<!-- <li><a href="#" class="parent"><span>Report</span></a>
						<ul>
							<li><a  href="?action=r_transaction_list">Report</a></li>
						</ul>
					</li> -->
					<?php 
					if($this->user_permissions->is_view('r_account_chart')||
						$this->user_permissions->is_view('r_account_report')||
						$this->user_permissions->is_view('r_account_update')||
						$this->user_permissions->is_view('r_credit_note')||
						$this->user_permissions->is_view('r_debit_note'))
					{ 
						?> 	
						<?php if($this->user_permissions->is_view('r_account_report')){ ?><li><a  href="?action=r_account_report" class="parent"><span>Account</span></a></li><?php } ?>			
						<?php } ?>

						<li><a  class="parent"><span>Bank</span></a>
							<ul>
								<li><a  href="?action=r_bank_entry"><span>Bank Reports</span></a></li>
								<li><a  href="?action=f_post_dated_chq_reg"><span>Post Dated Cheque Registry</span></a></li>
								<li><a  href="?action=f_return_chq_reg"><span>Return Cheque Registry</span></a></li>
							</ul>
						</li>


						<?php 
						if($this->user_permissions->is_view('r_stock_in_hand')||
							$this->user_permissions->is_view('r_batch_in_hand')||
							$this->user_permissions->is_view('r_serial_in_hand')||
							$this->user_permissions->is_view('r_bin_card_stock')||
							$this->user_permissions->is_view('r_item_department')||
							$this->user_permissions->is_view('r_item_category')||
							$this->user_permissions->is_view('r_sub_item_category')||
							$this->user_permissions->is_view('item_lists')||
							$this->user_permissions->is_view('r_stock_detail'))
						{ 
							?> 	
							<?php if($this->user_permissions->is_view('r_stock_report')){ ?><li><a  href="?action=r_stock_report" class="parent"><span>Stock</span></a></li><?php } ?> 
							<?php } ?>	

							<?php 
							if($this->user_permissions->is_view('r_customer_list')||
								$this->user_permissions->is_view('r_customer_area_list')||
								$this->user_permissions->is_view('r_customer_town_list')||
								$this->user_permissions->is_view('r_customer_balances')||
								$this->user_permissions->is_view('r_customer_analysis'))
							{ 
								?> 

								<?php if($this->user_permissions->is_view('r_debiter_list')){ ?><li><a  href="?action=r_debiter_list" class="parent"><span>Debitor</span></a> </li><?php } ?>
								<?php } ?>


								<?php 
								if($this->user_permissions->is_view('r_category_wise_supplier')||
									$this->user_permissions->is_view('r_purchase_bill')||
									$this->user_permissions->is_view('r_supplier_balances')||
									$this->user_permissions->is_view('r_supplier_analysis'))
								{ 
									?> 
									<?php if($this->user_permissions->is_view('r_crediter_list')){ ?><li><a  href="?action=r_crediter_list" class="parent"><span>Creditor</span></a> </li><?php } ?>
									<?php } ?>

									<?php 
									if($this->user_permissions->is_view('r_transaction_list_purchase')||
										$this->user_permissions->is_view('r_transaction_list_cash')||
										$this->user_permissions->is_view('r_transaction_list_credit')||
										$this->user_permissions->is_view('r_group_sale_balance')||
										$this->user_permissions->is_view('r_transaction_list_voucher')||
										$this->user_permissions->is_view('r_sales_order_sales')||		        	 	 
										$this->user_permissions->is_view('r_transaction_list_card_and_cash'))
									{ 
										?> 
										<li><a href="#" class="parent"><span>Transaction</span></a>
											<ul>
												<?php if($this->user_permissions->is_view('r_transaction_list_purchase')){ ?><li><a  href="?action=r_transaction_list_purchase">Purchase</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_transaction_list_cash')){ ?><li><a  href="?action=r_transaction_list_cash">Cash Sales</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_transaction_list_credit')){ ?><li><a  href="?action=r_transaction_list_credit">Credit Sales</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_total_sale')){ ?><li><a  href="?action=r_total_sale">Total Sales</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_internal_transfer')){ ?><li><a  href="?action=r_internal_transfer">Internal Transfer</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_transaction_list_voucher')){ ?><li><a  href="?action=r_transaction_list_voucher"> Voucher  Lists</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_transaction_list_reciept')){ ?><li><a  href="?action=r_transaction_list_reciept">Receipt Lists</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_group_sale_balance')){ ?><li><a  href="?action=r_group_sale_balance">Group Sale Balance</a></li><?php } ?>
												<?php if($this->user_permissions->is_view('r_transaction_list_card_and_cash')){ ?><li><a  href="?action=r_transaction_list_card_and_cash">Card and Cash Sale</a></li><?php } ?>																			<!-- <li><a  href="?action=r_r">R</a></li> -->
												<?php if($this->user_permissions->is_view('r_sales_order_sales')){ ?><li><a  href="?action=r_sales_order_sales">Sales Order Sales</a></li><?php } ?>
											</ul>

											<?php

											if ($this->user_permissions->view_module("def_use_hp")){
												?>
												<?php if($this->user_permissions->is_view('r_transaction_list_hp')){ ?><li><a  href="?action=r_transaction_list_hp">HP</a></li><?php } ?>	
												

											</li>

											
											<?php } ?>
											<?php } ?>

											
											
											<?php

											if ($this->user_permissions->view_module("def_use_seettu")){
												?>	
												<li><a href="#" class="parent"><span>Seettu</span></a>
													<ul>
														<?php if($this->user_permissions->is_view('r_master_seettu')){ ?><li><a  href="?action=r_master_seettu">Master</a></li><?php } ?>
														<?php if($this->user_permissions->is_view('r_transaction_settu')){ ?><li><a target="_blank" href="?action=r_transaction_settu">Transaction</a></li><?php } ?> 
													</ul>
												</li> 

											</li>

											
											<?php } ?>  

											<?php } ?>			
											<?php 
											if($this->user_permissions->is_view('m_dialy_summery'))
											{ 
												?>
												<li><a href="#" class="parent"><span>Summery</span></a>
													<ul>
														<?php if($this->user_permissions->is_view('m_dialy_summery')){ ?><li><a target="_blank" href="?action=m_dialy_summery">Daily Summery</a></li><?php } ?> 
													</ul>
												</li> 

												<?php } ?> 

											</ul>
										</li>
										<?php

										if ($this->user_permissions->view_module("def_use_service")){
											?>

											<li ><a href="#"><img src="<?=base_url()?>images/service.png"  width="53" height="43" /></a>
												<ul>
													<?php
													if($this->user_permissions->is_view('t_job')||
														$this->user_permissions->is_view('t_job_update')||	
														$this->user_permissions->is_view('t_job_reject')||
														$this->user_permissions->is_view('t_job_receive')||
														$this->user_permissions->is_view('t_job_issue')||
														$this->user_permissions->is_view('t_job_issue'))
													{
														?>
														
														<?php if($this->user_permissions->is_view('t_job')){ ?><li><a  href="?action=t_job">Service Job</a></li><?php } ?> 
														<?php if($this->user_permissions->is_view('t_job_update')){ ?><li><a  href="?action=t_job_update">Send to Supplier</a></li><?php } ?> 
														<?php if($this->user_permissions->is_view('t_job_reject')){ ?><li><a  href="?action=t_job_reject">Reject Job</a></li><?php } ?> 
														<?php if($this->user_permissions->is_view('t_sup_job_ref_no')){ ?><li><a  href="?action=t_sup_job_ref_no">Supplier Job Ref.No</a></li><?php } ?> 
														<?php if($this->user_permissions->is_view('t_job_receive')){ ?><li><a  href="?action=t_job_receive">Receive From Supplier</a></li><?php } ?> 
														<?php if($this->user_permissions->is_view('t_job_issue')){ ?><li><a  href="?action=t_job_issue">Issue to Customer</a></li><?php } ?> 
														<hr class="hline"/>
														<?php if($this->user_permissions->is_view('t_repair_dash_bord')){ ?><li><a  href="?action=t_repair_dash_bord">Dash Bord</a></li><?php } ?> 
														
													</li>
													<?php

												} ?>
											</ul>
										</li> 
										<?php
									}
									?>
									<?php 
									if($this->user_permissions->is_view('s_company')||
										$this->user_permissions->is_view('m_cluster')||	
										$this->user_permissions->is_view('m_branch')||
										$this->user_permissions->is_view('s_users')||
										$this->user_permissions->is_view('s_module')||
										$this->user_permissions->is_view('s_role')||
										$this->user_permissions->is_view('s_add_role')||
										$this->user_permissions->is_view('backup'))
									{ 
										?>

										<li><a href="#"><img src="<?=base_url()?>images/system.png"  width="53" height="43" /></a>
											<ul>


												<?php 
												if($this->user_permissions->is_view('s_company')||
													$this->user_permissions->is_view('m_cluster')||	
													$this->user_permissions->is_view('m_branch'))
												{ 
													?> 
													<li><a  href="#">Company</a>
														<ul>
															<?php if($this->user_permissions->is_view('s_company')){ ?><li><a  href="?action=s_company">Company Profile</a></li><?php } ?> 
															<?php if($this->user_permissions->is_view('m_cluster')){ ?><li><a  href="?action=m_cluster">Cluster</a></li><?php } ?>
															<?php if($this->user_permissions->is_view('m_branch')){ ?><li><a  href="?action=m_branch">Branches</a></li><?php } ?>
															<?php if($this->user_permissions->is_view('r_branch_c_acc')){ ?><li><a  href="?action=r_branch_c_acc">Branch Current Account Setup</a></li><?php } ?>
														</ul>
													</li>

													<?php } ?>
													
													<?php if($this->user_permissions->is_view('s_users')){ ?><li><a  href="user_permission?action=s_users">Users</a></li><?php } ?>
													<?php //if($this->user_permissions->is_view('s_module')){ ?> <!-- <li><a  href="user_permission?action=s_module">Module</a></li> --> <?php //} ?>
													<?php //if($this->user_permissions->is_view('s_role')){ ?> <!-- <li><a  href="user_permission?action=s_role">User Role</a></li> --> <?php //} ?>
													<?php //if($this->user_permissions->is_view('s_add_role')){ ?> <!-- <li><a  href="user_permission?action=s_add_role">Add Role</a></li> --> <?php //} ?> 
													<?php if($this->user_permissions->is_view('Backup')){ ?><li><a  href="index.php/main/backup" >Backup</a></li><?php } ?> 
													<?php if($this->user_permissions->is_view('Backup')){ 
														
                        /*$md = md5(date('Y-m-d')); 
                        // echo '<li><a href="../kgc_hp/app/backup/view.php?f=" target="_blank">Backup</a></li>';
                        $this->load->model($this->uri->segment(3));*/
                    } ?> 
                </ul>
            </li>
            <?php } ?>


            <?php
            if($this->user_permissions->is_view('f_find_item_all')||
            	$this->user_permissions->is_view('f_find_item')||
            	$this->user_permissions->is_view('f_find_transaction_log_det')||
            	$this->user_permissions->is_view('f_find_serial')||
            	$this->user_permissions->is_view('f_find_customer')||
            	$this->user_permissions->is_view('m_settu_item_category')||
            	$this->user_permissions->is_view('m_settu_item_setup')||
            	$this->user_permissions->is_view('t_settu_invoice')||
            	$this->user_permissions->is_view('r_payment_option'))
            { 
            	?>
            	<li><a href="#"><img src="<?=base_url()?>images/search.png"  width="43" height="43" /></a>
            		<ul>
            			<?php if($this->user_permissions->is_view('f_find_item_all')){ ?><li><a  href="?action=f_find_item_all">Find Item - All</a></li><?php } ?> 
            			<?php if($this->user_permissions->is_view('f_find_item')){ ?><li><a  href="?action=f_find_item">Find Master File Details </a></li><?php } ?> 
            			<?php if($ds['use_serial_no_items'] ){ ?>
            			<?php if($this->user_permissions->is_view('f_find_serial')){ ?><li><a  href="?action=f_find_serial">Find Serial</a></li><?php } ?>
            			<?php } ?>
            			<?php if($this->user_permissions->is_view('f_find_customer')){ ?><li><a  href="?action=f_find_customer">Find Customer Balance</a></li><?php } ?>
            			<?php if($this->user_permissions->is_view('f_find_transaction_log_det')){ ?><li><a  href="?action=f_find_transaction_log_det">Find Transaction Log Detail</a></li><?php } ?>
            			
            		</ul>
            	</li>

            	<?php

            	if ($this->user_permissions->view_module("def_use_seettu")){
            		?>    
            		<li><a href="#"><img src="<?php echo base_url(); ?>images/settu.png" alt="" width="53" height="43" /></a>
            			<ul>
                 <!-- <li><a href="#" class="parent"><span>Report</span></a>
                            <ul>
                                    <li><a  href="?action=r_transaction_list">Report</a></li>
                            </ul>
                        </li> -->
                        <?php if($this->user_permissions->is_view('seettu_return_reason')){ ?><li><a  href="?action=seettu_return_reason" class="parent"><span>Settu Return Reason</span></a></li>	<?php } ?> 
                        <?php if($this->user_permissions->is_view('m_settu_book_edition')){ ?><li><a  href="?action=m_settu_book_edition" class="parent"><span>Settu Book Edition</span></a></li>	<?php } ?> 
                        <?php if($this->user_permissions->is_view('m_settu_item_category')){ ?><li><a  href="?action=m_settu_item_category" class="parent"><span>Settu Category</span></a></li>	<?php } ?> 		
                        <!-- </li> -->
                        <?php if($this->user_permissions->is_view('m_settu_item_setup')){ ?><li><a  href="?action=m_settu_item_setup" class="parent"><span>Seettu Item Setup</span></a></li> <?php } ?> 
                        <?php if($this->user_permissions->is_view('t_settu')){ ?><li><a  href="?action=t_settu" class="parent"><span>Seettu</span></a></li> <?php } ?> 
                        <?php if($this->user_permissions->is_view('t_settu_item_req')){ ?><li><a  href="?action=t_settu_item_req" class="parent"><span>Seettu Item Request</span></a></li> <?php } ?> 
                        <?php if($this->user_permissions->is_view('t_settu_loading')){ ?><li><a  href="?action=t_settu_loading" class="parent"><span>Seettu Loading</span></a></li> <?php } ?> 
                        <?php if($this->user_permissions->is_view('t_settu_sales')){ ?><li><a  href="?action=t_settu_sales" class="parent"><span>Seettu Sales</span></a></li> <?php } ?> 
                        <?php if($this->user_permissions->is_view('t_settu_unloading')){ ?><li><a  href="?action=t_settu_unloading" class="parent"><span>Seettu Unloading</span></a></li> <?php } ?> 
                        <?php if($this->user_permissions->is_view('t_settu_invoice')){ ?><li><a  href="?action=t_settu_invoice" class="parent"><span>Seettu Invoice </span></a></li> <?php } ?> 
				<!-- <li>
                        <a href="#" class="parent"><span>Transaction</span></a>
                        <ul>
                            <li><a  href="?action=r_transaction_list_purchase">Purchase</a></li>
                            <li><a  href="?action=r_transaction_list_cash">Cash Sales</a></li>
                            <li><a  href="?action=r_transaction_list_credit">Credit Sales</a></li>
                            <li><a  href="?action=r_transaction_list_voucher">Receipt & Voucher  Lists</a></li>
                        </ul>
                    </li>-->
                </ul>
            </li>
            <?php } ?>

            <?php } ?>

            <?php
            if(($this->user_permissions->is_view('default_settings')||
            	$this->user_permissions->is_view('t_day_process')||
            	$this->user_permissions->is_view('r_payment_option'))&&
            	($this->utility->is_developer()))
            { 
            	?>
            	<li><a href="#"><img src="<?=base_url()?>images/settings.png"  width="43" height="43" /></a>
            		<ul>
            			<?php if($this->user_permissions->is_view('default_settings')){ ?><li><a  href="?action=default_settings">Default Settings</a></li><?php } ?> 
            			<?php if($this->user_permissions->is_view('r_payment_option')){ ?><li><a  href="?action=r_payment_option">Payment Option Setup</a></li><?php } ?> 
            			<?php if($this->user_permissions->is_view('t_hp_option')){ ?><li><a  href="?action=t_hp_option">Default HP Option</a></li><?php } ?> 
            			
            			
            		</ul>
            	</li>
            	<?php } ?>

            	<?php
            	if($this->user_permissions->is_view('chq_print_scheme')||
            		$this->user_permissions->is_view('chq_print')||
            		$this->user_permissions->is_view('chq_pending_list')||
            		$this->user_permissions->is_view('chq_account_setup'))
            	{            
            		?>
            		<?php
            		if ($this->user_permissions->view_module("def_use_cheque")){
            			?>
            			<li><a href="#"><img src="<?=base_url()?>images/chq.png"  width="48" height="48" /></a>
            				<ul>
            					<?php if($this->user_permissions->is_view('chq_print_scheme')){ ?><li><a  href="?action=chq_print_scheme">Cheque Priniting Scheme</a></li><?php } ?>
            					<?php if($this->user_permissions->is_view('chq_account_setup')){ ?><li><a  href="?action=chq_account_setup">Account Setup</a></li><?php } ?>    
            					<?php if($this->user_permissions->is_view('chq_pending_list')){ ?><li><a  href="?action=chq_pending_list">Cheque Print Pending List</a></li><?php } ?> 
            					<?php if($this->user_permissions->is_view('chq_print')){ ?><li><a  href="?action=chq_print">Cheque Writing</a></li><?php } ?>            	
            					
            				</ul>
            			</li>
            			
            		</li>
            		<?php } ?>
            		<?php
            	}
            	?>
            </ul>
        </li>
    </ul>
    <div id="pay_form" style="display: none;">
    	<fieldset style='background-color: #f9f9f9; padding: 7px;'>
    		<legend>Payment Method</legend>
    		<table>
    			<tr>
    				<td ><span id="amount_lable">Pay Amount  </span></td>
    				<td ><input type="text" name="cash" id="cash" title="Amount" class="input_amount" readonly='readonly'/></td>
    				
    				<td > Advance  </td>
    				<td ><input type="text" name="advance" id="advance" title="0" class="input_amount" readonly='readonly' /></td>
		    <!--</tr>
		    <tr>-->
		    	<td ><span id="cash_lable">Cash </td>
		    	<td > <input type="text" name="amt" id="amt" title="0" class="input_amount" readonly='readonly'/>
		    	</td>
		    	
		    	<td ><span id="pay_credit_label">Credit</span></td>
		    	<td ><input type="text" name="credit" id="credit" title="0" class="input_amount" readonly='readonly' /></td>
		    	
		    	<td >Cheque </td>
		    	<td ><input type="text" name="cheque" id="cheque" title="0" class="input_amount" readonly='readonly'/></td>
			<!--<td>Extra Cash  </td>
			<td><select name="ec" id="ec" disabled="disabled">
					<option id='1'>Settlement</option>
					<option id='2'>Account</option>
				</select></td>-->

			</tr>
		</table>
		
		
		
		
                <!--Advance : <input type="text" name="cheque" id="cheque" title="Cheque Payment" class="input_amount" readonly='readonly' />
		
                Cheque : <input type="text" name="advance" id="advance" title="Advance Payment" class="input_amount" />-->
                
                
                
            </fieldset>
            
            <span id="ch_grd">
            	<fieldset class="hid_chq">
            		<legend>Cheque Details</legend>
            		<table style="width: 100%;" id="tgrid2">
            			<thead>
            				<tr>
            					<th class="tb_head_th">Bank</th>
            					<th class="tb_head_th">Bank Branch</th>
            					<th class="tb_head_th" style="width: 80px;">Cheque No</th>
            					<th class="tb_head_th" style="width: 80px;">Account No</th>
            					<th class="tb_head_th" style="width: 80px;">R. Date</th>
            					<th class="tb_head_th" style="width: 80px;">Amount</th>
            				</tr>
            			</thead><tbody>
            			<?php
                            //if will change this counter value of 10. then have to change edit model save function.
            			for($x=0; $x<10; $x++){
            				echo "<tr>";
            				echo "<td><input type='hidden' name='qbh_".$x."' id='qbh_".$x."' title='0' />
            				<input type='text' class='g_input_txt bank' id='q0_".$x."' name='q0_".$x."' readonly='readonly' style='width : 100%;' /></td>";
            				echo "<td><input type='hidden' name='qbbh_".$x."' id='qbbh_".$x."' title='0' />
            				<input type='text' class='g_input_txt branch'  id='qn_".$x."' name='qn_".$x."' style='width : 100%;' /></td>";
            				echo "<td><input type='text' class='g_input_txt cheque_no' id='q1_".$x."' name='q1_".$x."' style='width : 100%;'  /></td>";
            				echo "<td><input type='text' class='g_input_txt account_no' id='q2_".$x."' name='q2_".$x."' style='width : 100%;'  /></td>";
            				echo "<td><input type='text' class='input_date_down_future' style='border : none; background-color : transparent;' readonly='readonly' id='q4_".$x."' name='q4_".$x."' title='' /></td>";
            				echo "<td><input type='text' class='g_input_amo ttt' id='q3_".$x."' name='q3_".$x."' style='width : 100%;'  /></td>";
            				echo "</tr>";
            			}
            			?>
            		</tbody>
            	</table>
            </fieldset>
            
        </span>
        
        <span id="ch_grd">
        	<fieldset class="hid_chq_issue">
        		<legend>Cheque Details(Issue)</legend>
        		<table style="width: 100%;" id="tgrid2">
        			<thead>
        				<tr>
        					
        					<th class="tb_head_th">Bank</th>
        					<th class="tb_head_th" style="width: 80px;">Cheque No</th>
        					<th class="tb_head_th" style="width: 80px;">Account No</th>
        					<th class="tb_head_th" style="width: 80px;">R. Date</th>
        					<th class="tb_head_th" style="width: 80px;">Amount</th>
        				</tr>
        			</thead><tbody>
        			<?php
                            //if will change this counter value of 10. then have to change edit model save function.
        			for($x=0; $x<10; $x++){
        				echo "<tr>";
        				echo "<td><input type='hidden' name='qbbh1_".$x."' id='qbbh1_".$x."' title='0' />
        				<input type='text' class='g_input_txt branch1'  id='qn1_".$x."' name='qn1_".$x."' style='width : 100%;' /></td>";
        				echo "<td><input type='text' class='g_input_txt cheque_no' id='q11_".$x."' name='q11_".$x."' style='width : 100%;'  /></td>";
        				echo "<td><input type='text' class='g_input_txt account_no' id='q21_".$x."' name='q21_".$x."' style='width : 100%;'  /></td>";
        				echo "<td><input type='text' class='input_date_down_future' style='border : none; background-color : transparent;' readonly='readonly' id='q41_".$x."' name='q41_".$x."' title='' /></td>";
        				echo "<td><input type='text' class='g_input_amo ttt' id='q31_".$x."' name='q31_".$x."' style='width : 100%;'  /></td>";
        				echo "</tr>";
        			}
        			?>
        		</tbody>
        	</table>
        </fieldset>
        
    </span>
    
    <fieldset class="hide_field">
    	<legend>Advance Details</legend>
    	<table style="width: 100%;" id="tgridnew">
    		<thead>
    			<tr>
                            <!--<th class="tb_head_th">Bank</th>
                            <th class="tb_head_th">Bank Branch</th>-->
                            <th class="tb_head_th" style="width: 80px;">Receipt No</th>
                            <th class="tb_head_th" style="width: 80px;">Total</th>
                            <th class="tb_head_th" style="width: 80px;">Balance</th>
                            <th class="tb_head_th" style="width: 80px;">Settle</th>
                        </tr>
                    </thead><tbody>
                    <?php
                            //if will change this counter value of 10. then have to change edit model save function.
                    for($x=0; $x<10; $x++){
                    	echo "<tr>";
//                                    echo "<td><input type='hidden' name='qbh_".$x."' id='qbh_".$x."' title='0' />
//                                                <input type='text' class='g_input_txt bank' id='q0_".$x."' name='q0_".$x."' readonly='readonly' style='width : 100%;' /></td>";
//                                    echo "<td><input type='hidden' name='qbbh_".$x."' id='qbbh_".$x."' title='0' />
//						<input type='text' class='g_input_txt branch'  id='qn_".$x."' name='qn_".$x."' style='width : 100%;' /></td>";
                    	echo "<td><input type='text' class='g_input_txt cheque_no' id='p1_".$x."' name='p1_".$x."' style='width : 100%;' readonly='readonly'  /></td>";
                    	echo "<td><input type='text' class='g_input_txt account_no' id='p2_".$x."' name='p2_".$x."' style='width : 100%;' readonly='readonly'  /></td>";
                    	echo "<td><input type='text' class='g_input_amo k' id='p3_".$x."' name='p3_".$x."' style='width : 100%;' readonly='readonly'  /></td>";
                    	echo "<td><input type='text' class='g_input_amo ppp' id='p4_".$x."' name='p4_".$x."' style='width : 100%;'  /></td>";
                    	echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </fieldset>
        
        <div style="text-align: right; padding-top: 7px;">
        	<input type="button" title="Close" id="btnClosePay" />
        	<input type="button" title='Save <F8>' id="btnSavePay" />
        </div>
    </div>
    <div id="copyright" style="display: none;">Copyright &copy; 2012 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
    <input type="hidden" id="cid" title="0" />