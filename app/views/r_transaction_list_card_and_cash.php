<?php if($this->user_permissions->is_view('r_transaction_list_card_and_cash')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_transaction_list_card_and_cash.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>
<h2>Card and Cash Sales Reports</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
            <div class="form" id="form">
                <form action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
		    
	<table id="MnTbl">
		<tr>
		    <td>Date</td>
		    <td colspan="2">
		    	<input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
        		To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  />
        	</td>
        </tr>

        <!-- <tr>
            	<td>Category</td>
	            <td>
	            	<?php //echo $sales_category;?>
	            </td>
            </tr>


    	<tr> -->

    	  <!-- <tr>
                <td style="width:150px;">Reliance Customer</td>
                
                <td style="width:150px;"><input type="text" name="r_customer" id="r_customer" style="width:150px;" value="<?php echo $cus_code ?>" title="<?php echo $cus_code ?>" class="input_txt ac_input input_active" autocomplete="off"></td>
                <td ><input type="text" title="<?php //echo $cus_name ?>" value="<?php //echo $cus_name?>" style="width: 250px;" id="r_customer_des" readonly="readonly" class="hid_value"></td> 
            </tr> -->


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
			
			</table><hr />
           <table>
			
			
			<?php if($this->user_permissions->is_view('r_card_and_cash_sales_gross_profit')){ ?>
			<tr>
			    <td colspan="2">
                    <input type='radio' name='by' value='r_card_and_cash_sales_gross_profit' title="r_card_and_cash_sales_gross_profit" id="r_card_and_cash_sales_gross_profit" class="report" />Card and Cash Sales Gross Profit
                </td>			    
			</tr>
			<?php } ?>		

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