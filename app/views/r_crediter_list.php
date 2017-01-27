<?php if($this->user_permissions->is_view('r_crediter_list')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_crediter_list.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>
<h2>Crediter Reports</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
            <div class="form" id="form">
                <form action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
		    <table>
		    <tr><td>Date </td><td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
        To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td></tr>
             <tr>
	
			<tr>
      	<td>Supplier</td>
      	<td>
      		<input type="text" class="input_txt" title="" id="supp" name="supp" />
          	<input type="text" class="hid_value"  readonly="readonly" id="supp_des"  style="width: 250px;">
      	</td>
      </tr>

      <tr>
        <td>Supplier Status</td>
        <td>
          <select name='s_status' id='s_status'>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
            <option value="3">All</option>
          </select>
        </td>
      </tr>

            <tr> <td colspan="3"><hr/><td> </tr>

            <?php if($this->user_permissions->is_view('r_category_wise_supplier')){ ?>
            <tr>
			    <td>
                      <input type='radio' name='by' value='r_category_wise_supplier' title="r_category_wise_supplier" class="report"/>Supplier Details 1
                </td>
			</tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_supplier_2')){ ?>
            <tr>
                <td>
                      <input type='radio' name='by' value='r_supplier_2' title="r_supplier_2" class="report"/>Supplier Details 2
                </td>
            </tr>
            <?php } ?>


            <?php if($this->user_permissions->is_view('r_purchase_bill')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_purchase_bill' title="r_purchase_bill" class="report"/>Supplier Purchase Bill</td>
			</tr>
            <?php } ?>


            <?php if($this->user_permissions->is_view('r_supplier_balances')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_supplier_balances' title="r_supplier_balances" class="report"/>Supplier Balances</td>
			    
			</tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_supplier_analysis')){ ?>
			<tr>
			    <td>
                      <input type='radio' name='by' value='r_supplier_analysis' title="r_supplier_analysis" class="report"/>Supplier Age Analysis</td>
			    
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