<?php if($this->user_permissions->is_view('r_transaction_list_purchase')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_transaction_list_purchase.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>
<h2>Purchase Reports</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
            <div class="form" id="form">
                <form action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
		    <table>
		    <tr><td>Date </td><td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
        To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td></tr>
             <tr>
	

			<!--
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_customer_list' title="r_customer_list" class="report"/>Category wise Customer</td>
			    
			</tr>


			<tr>
			    <td>
                      <input type='radio' name='by' value='r_category_wise_supplier' title="r_category_wise_supplier" class="report"/>Category wise Supplier</td>
			    
			</tr>

			<tr>
			    <td>
                    	<input type='radio' name='by' value='r_customer_area_list' title="r_customer_area_list" class="report"/>Customer Area List</td>
			    
			</tr>

			<tr>
			    <td>
                    	<input type='radio' name='by' value='r_customer_town_list' title="r_customer_town_list" class="report"/>Customer Town List</td>
			    
			</tr>

			<tr>
			    <td>
                      <input type='radio' name='by' value='r_item_category' title="r_item_category" class="report" />Item Category</td>
			    
			</tr>

			<tr>
			    <td>
                      <input type='radio' name='by' value='r_sub_item_category' title="r_sub_item_category" class="report" />Item Sub Category</td>
			    
			</tr>
			
			<tr>
			    <td>
                      <input type='radio' name='by' value='item_list' title="item_list" class="report" />Item List</td>
			    
			</tr>
			-->

			<?php if($this->user_permissions->is_view('r_purchase_summary')){ ?>
			<tr>
			      <td>
                      <input type='radio' name='by' value='r_purchase_summary' title="r_purchase_summary" class="report" />Purchase Summary</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_purchase_details')){ ?>	
			<tr>
				<td>
                      <input type='radio' name='by' value='r_purchase_details' title="r_purchase_details" class="report" />Purchase Details</td>
			    
			</tr>
			<?php } ?>
			
			<?php if($this->user_permissions->is_view('r_purchase_ret')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_purchase_ret' title="r_purchase_ret" class="report" />Purchase Return Summary</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_purchase_ret_detail')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_purchase_ret_detail' title="r_purchase_ret_detail" class="report" />Purchase Return Details</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_purchase_order_summary')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_purchase_order_summary' title="r_purchase_order_summary" class="report" />Purchase Order Summary</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_purchase_order_details')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_purchase_order_details' title="r_purchase_order_details" class="report" />Purchase Order Details</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_po_status')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' id='r_po_status' value='r_po_status' title="r_po_status" class="report" />Purchase Order Status</td>
			    
			</tr>
			<?php } ?>

			<tr>
                        
                <?php if($this->user_permissions->is_view('r_po_qty_received')){ ?>
                    <td>
                      <input type='radio' name='by' value='r_po_qty_received' title="r_po_qty_received" id="r_po_qty_received" class="report"/>Purchase Order Quantity Received
                    </td>
                 <?php } ?>
            </tr>


			<tr>
			    <td colspan="2" style="text-align: right;">
                <input type="hidden" name="type" id="type"  title=""/>
				<input type="button" title="Exit" id="btnExit" value="Exit">
				
				 <button id="btnPrint">Print PDF</button>
			    </td>
			</tr>
		    </table>

                 <input type="hidden" name='page' value='A4' title="A4" >
                 <input type="hidden" name='orientation' value='P' title="P" >
                 <input type="hidden" name='type' value='19' title="19" >
                 <input type="hidden" name='header' value='false' title="false" >
                 <input type="hidden" name='qno' value='' title="" id="qno" >
                 <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
                 <input type="hidden" name='dt' value='' title="" id="dt" >
                </form>
            </div>
       
</table>
<?php } ?>