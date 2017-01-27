<?php if($this->user_permissions->is_view('t_hp_rivert_item')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_rivert_item.js"></script>
<div id="fade" class="black_overlay"></div>
<?php 
if($ds['use_serial_no_items'] ){
  $this->load->view('t_serial_out.php'); 
}
?>
<?php $this->load->view('t_payment_option.php'); ?>
<h2 style="text-align: center;">Rivert Item to Customer</h2>
<div class="dframe" id="mframe" style="width:900px;">
<!--   <form method="post" action="<?=base_url()?>index.php/main/save/t_hp_rivert_item" id="form_">
-->    <table style="width: 100%" border="0">

<tr>
  <td style="width: 100px;">Agreement No</td>
  <td>
    <input type="text" class="hid_value" id="agr_no" name="agr_no"title="" />
  </td>
  <td style="width: 50px;">No</td>
  <td>  <input type="text" class="input_active_num" name="id" id="id" style="width:100%" title="<?=$max_no?>"/>
    <input type="hidden" id="hid" name="hid" title="0" />
    <input type="hidden" id="cl" name="cl" title="<?=$cl; ?>" />
    <input type="hidden" id="bc" name="bc" title="<?=$bc; ?>" />
  </td>
</tr>

<tr>
  <td>Customer</td>
  <td><input type="text" class="hid_value" name="customer" id="customer" title="" maxlength="255" />
    <input type="text" id="cus_name" class="hid_value" style="width: 300px;"></td>
    <td style="width: 100px;">Date</td>
    <td style="width: 100px;">
      <?php if($this->user_permissions->is_back_date('t_hp_rivert_item')){ ?>
      <input type="text" style="width:100%; text-align:right;" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
      <?php }else{ ?> 
      <input type="text" style="width:100%; text-align:right;" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
      <?php } ?>   
    </td>
  </tr>
  <tr>
    <td>Address </td>
    <td><input type="text" id="cus_address" name="cus_address" class="hid_value" style="width: 454px;"></td> </td>
    <td style="width: 100px;">Ref. No</td>
    <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%; text-align:right;"/></td>

  </tr>
  <tr>
    <td>No </td>
    <td><input type="text" id="nno" name="nno" class="input_active_num hid_value"> 
      Refer No <input type="text" class="hid_value " id="rf_no" name="rf_no"></td>
    </tr>
    <tr> 
      <td>Date </td>
      <td><input type="text" class="hid_value" name="dt_date" id="dt_date"></td>
    </tr>
    <tr> 
      <td>From Store </td>
      <td><input type="text" class="input_txt store11" name="from_store" id="from_store">
        <input type="text" class="hid_value" id="store_des" style="width: 300px;">
      </td>
    </tr>


    <tr>

      <td style="width: 100px;"></td>
      <td style="width: 100px;"></td>
    </tr>

    <tr>
      <td colspan="4" style="text-align: center;">
        <table style="width: 880px;" id="tgrid">
          <thead>
            <tr>
              <th class="tb_head_th" style="width: 105px;">Item Code</th>
              <th class="tb_head_th" style="width: 250px;">Item Name</th>
              <th class="tb_head_th" style="width: 80px;">Serial No</th>
              <th class="tb_head_th" style="width: 80px;">Price</th>
              <th class="tb_head_th" style="width: 80px;">A/QTY</th>
              <th class="tb_head_th" style="width: 80px;">T/QTY</th>
            </tr>
          </thead>
          <tbody class="tb">
            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
            for($x=0; $x<20; $x++){
              echo "<tr>";
              echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
              <input type='text' class='g_input_txt fo' readonly id='0_".$x."' name='0_".$x."'style='width:100%;'/></td>";
              echo "<td><input type='text' class='g_input_txt g_col_fixed' id='item_name_".$x."' name='item_name_".$x."' readonly='readonly' style='width:100%;'/></td>";
              echo "<td><input type='text' class='g_input_num g_col_fixed' id='serial_no_".$x."' name='serial_no_".$x."' readonly='readonly'style='width:100%;'/></td>";
              echo "<td><input type='text' class='g_input_num g_col_fixed' id='max_".$x."' name='max_".$x."' readonly='readonly'style='width:100%;'/></td>";
              echo "<td><input type='text' class='g_input_num g_col_fixed' id='a_qty_".$x."' name='a_qty_".$x."' readonly='readonly'style='width:100%;'/></td>";
              echo "<td><input type='text' class='g_input_num qty qtycl".$x." ' id='tqty_".$x."' name='tqty_".$x."' style='width:70%;'/>
              <input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
              <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
              <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
              <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
              <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />  
              <input type='hidden' class='g_input_num btt_".$x."' id='bt1_".$x."' name='bt1_".$x."' style='width : 100%;'/></td>";
              

              echo "</tr>";
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <input type='hidden' name='row_count' id='row_count' value="25" title="25"/>  
              <input type='hidden' name='max_row' id='max_row' value="85" title="85"/>  
              <td colspan='2' align="right"> &nbsp; </td>
            </tr>
          </tfoot>
        </table>
        <table border="0" style="width: 100%">
         <tr> 
           <td> Return Person</td>
           <td><input type="text" id="return_person" name="return_person" class="input_txt">
             <input type="text" class ="hid_value "id="retur_persondes" name="retur_persondes" style="width:300px;"> </td>
             <td><b>Total Qty</b></td>
             <td style="width: 110px;"><input type='text' class='hid_value g_input_num' id='tot_qty' readonly="readonly" name='tot_qty' /></td>
           </tr>
           <tr>
             <td> Note</td> 
             <td> <input type="text" name="note" id="note" class="input_txt" style="width:452px;"></td>
             <td><b>Net Amount</b></td>
             <td ><input type='text' class='hid_value g_input_amo' id='net' readonly="readonly" name='net'/></td>
           </tr>
           <tr> 
             <td> Salesman </td>
             <td><input type="text" class="input_txt" id="s_code" name="s_code">
               <input type="text" class="hid_value" id="salesman_name" style="width: 300px;"> </td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>

           </table>
           <div style="text-align: left; padding-top: 7px;">
            <input type="button" id="btnExit" title="Exit" />
            <input type="button" id="btnReset" title="Reset" />
            <input type='hidden' id='seize_no' title='0' name="seize_no" />
            <input type='hidden' id='transtype' title='Rivert to Customer' value='Rivert to Customer' name='transtype' />
            <input type='hidden' id='transCode' value='119' title='119'/>
            <?php if($this->user_permissions->is_delete('t_hp_rivert_item')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
            <?php if($this->user_permissions->is_re_print('t_hp_rivert_item')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
            <input type="button" title="Payments" id='showPayments'/>
            <?php if($this->user_permissions->is_add('t_hp_rivert_item')){ ?><input type="button"  id="btnSave" title='Save <F8>' />
            <input type="button"  id="btnSavee" title='Save <F8>' style='display:none;'/>
            <?php } ?>
          </div>
        </td>
      </tr>
    </table>
    <?php 
    if($this->user_permissions->is_print('t_hp_rivert_item')){ ?>
    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
    <?php } ?> 
  </form>


  <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
   <input type="hidden" name='by' value='t_hp_rivert_item' title="t_hp_rivert_item" class="report">
   <input type="hidden" name='page' value='A4' title="A4" >
   <input type="hidden" name='orientation' value='P' title="P" >
   <input type="hidden" name='type' value='' title="" >
   <input type="hidden" name='header' value='false' title="false" >
   <input type="hidden" name='qno' value='' title="" id="qno" >
   <input type="hidden" name='print_type' value='p' title="p" id="print_type" >
   <input type="hidden" name='rep_sup' value='' title="" id="rep_sup" >
   <input type="hidden" name='rep_ship_bc' value='' title="" id="rep_ship_bc" >
   <input type="hidden" name='rep_date' value='' title="" id="rep_date" >
   <input type="hidden" name='cost_prnt' value='' title="" id="cost_prnt" >
   <input type="hidden" name='rep_deliver_date' value='' title="" id="rep_deliver_date" >
   <input type="hidden" name='org_print' value='' title="" id="org_print">

 </form>

</div>
<?php } ?>