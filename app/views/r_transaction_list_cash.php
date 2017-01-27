<?php if($this->user_permissions->is_view('r_transaction_list_cash')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_transaction_list_cash.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>

<h2>Cash Sale Reports</h2>
<table width="1025">
  <tr>
    <td width="1015" valign="top" class="content" style="width: 480px;"><div class="form" id="form">
        <form action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
          <table id="MnTbl">
            <tr>
              <td width="133" >Date </td>
              <td width="451"  ><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
                To
                <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td>
            </tr>
            <tr>
              <td >Category</td>
              <td ><?php echo $sales_category;?></td>
            </tr>
            
            <!--  <tr>
                <td style="width:150px;">Reliance Customer</td>
                
                <td style="width:150px;"><input type="text" name="r_customer" id="r_customer" style="width:150px;" title="" class="input_txt ac_input input_active" autocomplete="off"></td>
                <td ><input type="text" style="width: 250px;" id="r_customer_des" readonly="readonly" class="hid_value"></td>
            </tr> -->
            
            <tr>
              <td >Customer</td>
              <td ><input type="text" name="r_customer" id="r_customer" style="width:150px;" title="" class="input_txt ac_input input_active" autocomplete="off">
                <input type="text" style="width: 250px;" id="r_customer_des" readonly="readonly" class="hid_value"></td>
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
                
                <!-- <?php //echo $branch; ?> --></td>
            <tr>
              <td>Item</td>
              <td><input type="text" class="input_txt" title="" id="item" name="item" />
                <input type="text" class="hid_value"  readonly="readonly" id="item_des"  style="width: 250px;" /></td>
            </tr>
            <tr>
              <td>Supplier</td>
              <td><input type="text" class="input_txt" title="" id="supplier" name="supplier"/>
                <input  class="hid_value" id="supplier_des"  style="width: 250px;"  readonly="readonly" /></td>
            </tr>
            <tr>
              <td>Rep</td>
              <td><input type="text" class="input_txt" title="" id="rep" name="rep"/>
                <input  class="hid_value" id="rep_des"  style="width: 250px;"  readonly="readonly" /></td>
            </tr>
            <tr>
              <td  colspan="2"></td>
            </tr>
            </table><hr />
            
           <table>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_summary' title="r_cash_sales_summary" class="report" />
                Total Cash Sales Summary </td>
            </tr>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_summary_rep' title="r_cash_sales_summary_rep" class="report"  />
                Total Cash Sales Summary Rep Wise</td>
            </tr>
            <?php if($this->user_permissions->is_view('r_cash_sales_details')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_details' title="r_cash_sales_details" class="report" />
                Cash Sales Details </td>
            </tr>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_details_rep' title="r_cash_sales_details_rep" class="report" />
                Cash Sales Details Rep Wise</td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('payment_cash_sales_sum')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='payment_cash_sales_sum' title="payment_cash_sales_sum" class="report" />
                Payment Type Wise Sales Summery </td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('r_cash_sales_ret')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_ret' title="r_cash_sales_ret" class="report" />
                Cash Sales Return Summary </td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('r_cash_sales_ret_detail')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_ret_detail' title="r_cash_sales_ret_detail" class="report" />
                Cash Sales Return Details </td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('r_cash_sales_sum')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_sum' title="r_cash_sales_sum" class="report" />
                Cash Sales Summery </td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('r_credit_card_sales_sum')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_credit_card_sales_sum' title="r_credit_card_sales_sum" class="report" />
                Credit Card Sales Summery </td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('r_reliance_cash_sales_sum')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_reliance_cash_sales_sum' title="r_reliance_cash_sales_sum" class="report" />
                Customer Sales Summery </td>
            </tr>
            <?php } ?>
            <?php if($this->user_permissions->is_view('r_cash_sales_gross_profit')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_cash_sales_gross_profit' title="r_cash_sales_gross_profit" class="report" id="r_cash_sales_gross_profit" />
                <label for="r_cash_sales_gross_profit">Cash Sales - Gross Profit</label></td>
            </tr>
            <?php } ?>
            <tr>
              <td  colspan="2" style="text-align: right;"><input type="hidden" name="type" id="type"  title=""/>
                <input type="button" title="Exit" id="btnExit" value="Exit">
                <button id="btnPrint">Print PDF</button></td>
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
