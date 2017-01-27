<?php if($this->user_permissions->is_view('r_sales_order_sales')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_sales_order_sales.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>

<h2>Sales Order Sales Reports</h2>
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
              <td  colspan="2"></td>
            </tr>
            </table><hr />
            
           <table>

            <?php if($this->user_permissions->is_view('r_sales_order_sales_gross_profit')){ ?>
            <tr>
              <td  colspan="2"><input type='radio' name='by' value='r_sales_order_sales_gross_profit' title="r_sales_order_sales_gross_profit" class="report" id="r_sales_order_sales_gross_profit" />
                <label for="r_sales_order_sales_gross_profit">Sales Order Sales - Gross Profit</label></td>
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
