<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_rebate.js"></script>
<h2 style="text-align: center;">Rebate Approve</h2>
<div class="dframe" id="mframe" style="width:950px;">
  <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_hp_rebate" >
   <table style="width: 100%" border="0">
    <tr>
      <td></td>
      <td></td>
      <td style="width: 50px;">No</td>
      <td> 
       <input type="text" class="input_active" id="no" name="no"title="<?php echo $max_no;?>" style="text-align:right;"/>
       <input type="hidden" class="input_active" id="hid" name="hid" title="" value="0" style="text-align:right;"/>
     </td>                      
   </tr>
   <tr>
    <td></td>
    <td></td>
    <td style="width: 50px;">Date</td>
    <td><input type="text"  class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align:right;"/></td>
  </tr>
  <tr>
    <td style="width: 185px;" >Loan No</td>
    <td>
      <input type="text" class="input_active" id="loan_no" name="loan_no"title="" />
      <input type="text" class="hid_value" id="loan" title="" style="width:300px;" readonly='readonly'/>
    </td>
    <td style="width: 50px;">Ref No</td>
    <td>
     <input type="text" class="input_active" id="ref_no" name="ref_no"title="" style="text-align:right;"/>                
   </td>
 </tr>
 <tr>
   <td style="width: 185px;" >&nbsp;</td>
   <td>
   </td>
   <td style="width: 50px;">Bill No</td>
   <td>
    <input type="text" class="input_active" id="bill_no" name="bill_no"title="" style="text-align:right;"/>                
  </td>
</tr>
</table>
<br/>
<table style="width: 100%" border="0">
 <tr>
  <td style="width: 185px;">Installment Details Capital</td>
  <td style="width: 55px; "><input type="text" class="input_active" id="ins_detail_capital" name="ins_detail_capital" tle="" style="text-align:right;"/></td>
  <td style="width: 145px; ">Interest</td>
  <td tyle="width: 200px;"><input type="text" class="input_active" id="interest" name="interest" title="" style="text-align:right;"/></td>
  <td style="width: 95px;">Installment</td>
  <td><input type="text" class="input_active" id="installment" name="installment" title="" style="text-align:right;"/></td>
  <td style="width: 95px;">Advance Amount</td>
  <td><input type="text" class="input_active" id="advance" name="advance" title="" style="text-align:right;"/></td>



</tr>
</table>
<table border="0" >
  <tr>
    <td>
      <fieldset style="background:transparent;">
       <table id="tgrid2" style="width: 100%">
        <thead>
          <tr>
           <th class="tb_head_th" style="width: 100px;">Type</th>
           <th class="tb_head_th" style="width: 100px;">Balance Amount</th>
           <th class="tb_head_th" style="width: 100px;">Rebate Amount</th>
           <th class="tb_head_th" style="width: 100px;">Paid Amount</th>
         </tr>
         <tr>
           <td>Capital</td>
           <td><input type="text" class="hid_value" id="capital" name="capital" title="" style="width:100px; text-align:right;" readonly='readonly'/></td>
           <td><input type="text" class="g_input_amo" id="capital_rebate" name="capital_rebate"title="" style="text-align:right;"/></td>
           <td><input type="text" class="hid_value g_input_amo" id="capital_paid" name="capital_paid"title="" style="text-align:right;" readonly='readonly'/></td>
         </tr>
         <tr>
           <td>Interest</td>
           <td><input type="text" class="hid_value" id="interrest" name="interrest" title="" style="width:100px; text-align:right; " readonly='readonly'/></td>
           <td><input type="text" class="g_input_amo" id="Interest_rebate" name="Interest_rebate" title="" style="text-align:right;"/></td>
           <td><input type="text" class="hid_value g_input_amo" id="interest_paid" name="interest_paid" title="" style="text-align:right;"readonly='readonly'/></td>
         </tr>
         <tr>
           <td>Panalty</td>
           <td><input type="text" class="hid_value" id="panalty" name="panalty" title="" style="width:100px; text-align:right;" readonly='readonly'/></td>
           <td><input type="text" class="g_input_amo" id="panalty_rebate" name="panalty_rebate" title="" style="text-align:right;"/></td>
           <td><input type="text" class="hid_value g_input_amo" id="panalty_paid" name="panalty_paid" title="" style="text-align:right;"readonly='readonly'/></td>
         </tr>
         <tr>
           <td>Other Chargers</td>
           <td><input type="text" class="hid_value" id="other_charges" name="other_charges" title="" style="width:100px; text-align:right;" readonly='readonly'/></td>
           <td><input type="text" class="g_input_amo" id="other_rebate" name="other_rebate" title="" style="text-align:right;"/></td>
           <td><input type="text" class="hid_value g_input_amo" id="other_charges_paid" name="other_charges_paid" title="" style="text-align:right;"readonly='readonly'/></td>
         </tr>
         <tr>
           <td>Advance Amount</td>
           <td><input type="text" class="hid_value" id="advance_amount" name="advance_amount" title="" style="width:100px; text-align:right;" readonly='readonly'/></td>
           <td></td>
           <td><input type="text" class="hid_value g_input_amo" id="advance_paid" name="advance_paid" title="" style="text-align:right;"readonly='readonly'/></td>
         </tr>
         <tr>
           <th>Total</th>
           <td><input type="text" class="hid_value g_input_amo" id="tot" name="tot" title="" style="width:100px; text-align:right;" readonly='readonly'/>
            <input type="hidden" class="hid_value g_input_amo" id="tot_h" title="" style="width:100px; text-align:right;" readonly='readonly'/></td>
            <td><input type="text" class="hid_value g_input_amo" id="tot_reb" name="tot_reb" title="" style="width:100px; text-align:right;" readonly='readonly'/></td>
            <td><input type="text" class="hid_value g_input_amo" id="tot_paid" name="tot_paid" title="" style="text-align:right;"readonly='readonly'/></td>
          </tr> 
        </thead>
      </table>
    </fieldset>
  </td>
</tr>
</table>  
<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
 <!--  <?php 
        if($this->user_permissions->is_print('r_group_sales_budget')){ ?>
            
        <?php } ?> -->
        <div style="text-align: right; padding-top: 7px;">
          <input type="button" id="btnExit" title="Exit" />
          <input type="button" id="btnReset" title="Reset" />
          <input type="button" id="btnCancel" title="Cancel" />
          <input type="button" id="btnPrint" title="Print" />
          <input type="button" id="btnSave" title='Save <F8>' />

        </div>
      </form>
    </div>
    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

     <input type="hidden" name='by' value='t_hp_rebate' title="t_hp_rebate" class="report">
     <input type="hidden" name='page' value='A4' title="A4" >
     <input type="hidden" name='orientation' value='P' title="P">
     <input type="hidden" name='type' value='purchase' title="purchase">
     <input type="hidden" name='header' value='false' title="false">
     <input type="hidden" name='nno' value='' title="" id="nno">
     <input type="hidden" name='org_print' value='' title="" id="org_print">
   </form>

