<?php if($this->user_permissions->is_view('r_transaction_list_credit')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_transaction_list_credit.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>
<h2>Credit Sale Reports</h2>
<table width="100%">
	<tr>
		<td valign="top" class="content" style="width: 480px;">
			<div class="form" id="form">
				<form id = "print_pdf" class="printExcel" action="<?php echo site_url();?>" method="post" target="_blank">

					<table id="MnTbl">
						<tr>
							<td>Date</td>
							<td colspan="2">
								<input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
								To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  />
							</td>
						</tr>

						<tr>
							<td>Category</td>
							<td>
								<?php echo $sales_category;?>
							</td>
						</tr>


						<tr>

							<tr>
								<td style="width:150px;">Reliance Customer</td>

								<td style="width:150px;"><input type="text" name="r_customer" id="r_customer" style="width:150px;" value="<?php echo $cus_code ?>" title="<?php echo $cus_code ?>" class="input_txt ac_input input_active" autocomplete="off"></td>
								<td ><input type="text" title="<?php echo $cus_name ?>" value="<?php echo $cus_name?>" style="width: 250px;" id="r_customer_des" readonly="readonly" class="hid_value"></td> 
							</tr>


							<tr>
								<td>Cluster</td>
								<td><?php echo $cluster; ?></td>
							</tr>
							<tr>
								<td>Branch</td>
								<td><select name='branch' id='branch' >
									<option value='0'>---</option>
								</select>

								<?php //echo $branch; ?> </td>
								<tr>
									<td>Item</td>
									<td><input type="text" class="input_txt" title="" id="item" name="item" /></td>
									<td><input type="text" class="hid_value"  readonly="readonly" id="item_des"  style="width: 250px;" /></td>
								</tr>
								<tr>
									<td>Supplier</td>
									<td><input type="text" class="input_txt" title="" id="supplier" name="supplier"/></td>
									<td><input  class="hid_value" id="supplier_des"  style="width: 250px;"  readonly="readonly" /></td>
								</tr>
								<tr>
					              <td>Rep</td>
					              <td><input type="text" class="input_txt" title="" id="rep" name="rep"/></td>
					              <td><input  class="hid_value" id="rep_des"  style="width: 250px;"  readonly="readonly" /></td>
					            </tr>
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
	</table><hr />
	<table>
		<?php if($this->user_permissions->is_view('r_credit_sales_summary')){ ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_credit_sales_summary' title="r_credit_sales_summary" class="report" excel="true" />Credit Sales Summary
			</td>
		</tr>
		<tr>
          	<td  colspan="2"><input type='radio' name='by' value='r_credit_sales_summary_rep' title="r_credit_sales_summary_rep" class="report"  />
            Total Credit Sales Summary Rep Wise</td>
        </tr>
        <tr>
          	<td  colspan="2"><input type='radio' name='by' value='r_credit_sales_details_rep' title="r_credit_sales_details_rep" class="report"  />
            Total Credit Sales Details Rep Wise</td>
        </tr>
		<?php } ?>

		<?php if($this->user_permissions->is_view('r_credit_sales_details')){ ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_credit_sales_details' title="r_credit_sales_details" class="report" />Credit Sales Details
			</td>
		</tr>
		<?php } ?>

		<?php if($this->user_permissions->is_view('r_credit_sales_ret')){ ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_credit_sales_ret' title="r_credit_sales_ret" class="report" excel="true" />Credit Sales Return Summary
			</td>
		</tr>
		<?php } ?>

		<?php if($this->user_permissions->is_view('r_credit_sales_ret_detail')){ ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_credit_sales_ret_detail' title="r_credit_sales_ret_detail" class="report" />Credit Sales Return Details
			</td>
		</tr>
		<?php } ?>

		<?php if($this->user_permissions->is_view('r_reliance_sales_sum')){ ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_reliance_sales_sum' title="r_reliance_sales_sum" class="report" />Reliance Sales Summery
			</td>			    
		</tr>
		<?php } ?>

		<?php if($this->user_permissions->is_view('r_credit_sales_gross_profit')){ ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_credit_sales_gross_profit' title="r_credit_sales_gross_profit" id="r_credit_sales_gross_profit" class="report" excel="true" />Credit Sales Gross Profit
			</td>			    
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2">
				<input type='radio' name='by' value='r_credit_sales_outstanding' title="r_credit_sales_outstanding" id="r_credit_sales_outstanding" class="report" />Credit Sales Outstanding
			</td>			    
		</tr>		
		<tr>
			<td colspan="4"> </td>
			<td colspan="4" style="text-align: right;">
				<input type="hidden" name="type" id="type"  title=""/>
				<input type="button" title="Exit" id="btnExit" value="Exit">
				<input type="button" id="btnPrint" title="Print PDF" value="Print PDF">
				<input type="button" id="printExcel" title="Excel" value="printExcel" disabled="true">
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