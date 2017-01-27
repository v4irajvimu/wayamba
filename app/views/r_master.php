<?php //if($this->user_permissions->is_view('002')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_master.js'></script>
<h2>Seettu Reports</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
            <div class="form" id="form">
                <form action="<?php echo site_url(); ?>/reports/generate" id="print_pdf" method="post" target="_blank">
		    <table>
		    <tr> <td>Category</td>
		    <td><input type="text" class="input_txt" title='' id="settu_item_category" name="settu_item_category" style="width:125px;" readonly="readonly" /></td>
             <td><input type="text" class="hid_value main_cus" title='' id="category_name" name="category_name" style="width:221px;" maxlength="100"/></td>               
		    <!-- <td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
        To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td></tr>
              --><tr>
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
			
				<tr>
				    <td>
	                    <input type='radio' name='by' value='r_seettu_Item_setup' title="r_seettu_Item_setup" class="report" /> Seettu Item Setup
	                </td>			    
				</tr>

				<!-- <tr>
				    <td>
	                    <input type='radio' name='by' value='r_cash_sales_details' title="r_cash_sales_details" class="report" />Cash Sales Details
	                </td>			    
				</tr>
				
				<tr>
				    <td>
	                    <input type='radio' name='by' value='r_cash_sales_ret' title="r_cash_sales_ret" class="report" />Cash Sales Return Summary
	                </td>			    
				</tr>

				<tr>
				    <td>
	                    <input type='radio' name='by' value='r_cash_sales_ret_detail' title="r_cash_sales_ret_detail" class="report" />Cash Sales Return Details
	                </td>			    
				</tr> -->
			<tr>
		




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
