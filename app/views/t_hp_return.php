<?php if($this->user_permissions->is_view('t_hp_return')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_return.js"></script>
<div id="fade" class="black_overlay"></div>
<?php 
if($ds['use_serial_no_items'] ){
    $this->load->view('t_serial_out.php'); 
}
?>
<h2 style="text-align: center;">HP Return</h2>
<div class="dframe" id="mframe" style="padding-right:25px;">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_hp_return" id="form_">
    <input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
        <table style="width: 100%" border="0">
            <tr>
                <td style="width:100px;">Agreement No</td>
                <td style="width:150px;"><input type="text" class="input_txt selc_no" title=''  id="agr_no"  name="agr_no" style="width: 100%;"></td>
                <td style="width:100px;">Inv No</td>
                <td style="width:100px;"><input type="text" class="input_txt selc_no" title=''  id="inv_no"  name="inv_no" style="width: 100%;"></td>
                <td style="width:100px;">Ref Bill</td>
                <td style="width:100px;"><input type="text" class="input_txt selc_no" title=''  id="ref_bill"  name="ref_bill" style="width: 100%;"></td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:100px;">No</td>
                <td style="width:120px;"><input type="text" class="input_active_num" name="id" id="id" style="width:100%;" title="<?=$nno;?>" />
                <input type="hidden" id="hid" name="hid" title="0" /></td>
            </tr>
            <tr>
                <td>Customer</td>
                <td><input type="text" class="input_txt" title=''  id="customer_id"  name="customer_id" style="width: 100%;"readonly='readonly'></td>
                <td colspan="4"><input type="text" class="hid_value" title=''  id="customer_des"  name="customer_des" style="width: 100%;"></td>
                <td>&nbsp;</td>
                <td>Date</td>
                <td><?php if($this->user_permissions->is_back_date('t_hp_return')){ ?>
                    <input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align: right;width: 100%;"/>
                    <?php }else{ ?>
                    <input type="text" class="" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align: right;width: 100%;"/>
                    <?php } ?></td>
                </tr>
                <tr>
                    <td>Salesman</td>
                    <td><input type="text" class="input_txt" title=''  id="salesman_id"  name="salesman_id" style="width: 100%;"readonly='readonly'></td>
                    <td colspan="4"><input type="text" class="hid_value" title=''  id="salesman_des"  name="salesman_des" style="width: 100%;"></td>
                    <td>&nbsp;</td>
                    <td>Ref.No</td>
                    <td><input type="text" class="input_txt" title=''  id="ref_no"  name="ref_no" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>Store</td>
                    <td><input type="text" class="input_txt store11" title=''  id="store_id"  name="store_id" style="width: 100%;" ></td>
                    <td colspan="2"><input type="text" class="hid_value" title=''  id="store_des"  name="store_des" style="width: 100%;"></td>
                    <td><input type="button" id="btn_open_customer" title="..." value="..."></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>CRN No</td>
                    <td><input type="text" class="input_active_num" id="crn_no" name="crn_no" title="<?php echo $crn_no; ?>" style="width: 100%;" maxlength="25" /></td>
                </tr>
                <tr>
                    <td colspan="9" style="text-align: center;">
                        <table style="width: 100% ;" id="tgrid2" >
                            <thead>
                                <tr>
                                    <th class="tb_head_th" style="width: 120px;">Item Code</th>
                                    <th class="tb_head_th">Name</th>
                                    <th class="tb_head_th" style="width: 60px;">Model</th>
                                    <th class="tb_head_th" style="width: 60px;">Batch</th>
                                    <th class="tb_head_th" style="width: 70px;">QTY</th>
                                    <th class="tb_head_th" style="width: 70px;">FOC</th>
                                    <th class="tb_head_th" style="width: 70px;">Price</th>
                                    <th class="tb_head_th" style="width: 70px;">Dis%</th>
                                    <th class="tb_head_th" style="width: 70px;">Discount</th>
                                    <th class="tb_head_th" style="width: 70px;">Amount</th>
                                </tr>
                            </thead><tbody>
                            <?php
                            for($x=0; $x<25; $x++){
                               echo "<tr>";
                               echo "<td style=''><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                               <input type='text' class='g_input_txt g_col_fixed' id='0_".$x."' name='0_".$x."' style='width : 100%;' readonly='readonly'/></td>
                               <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
                               <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
                               <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
                               <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />  ";

                               echo "<td  ><input type='text' class='g_input_txt g_col_fixed'  id='n_".$x."' name='n_".$x."' maxlength='150' style='width : 100%;' readonly='readonly'/></td>";
                               echo "<td  ><input type='text' class='g_input_txt g_col_fixed'  id='m_".$x."' name='m_".$x."' style='width : 100%;' readonly='readonly'/></td>";
                               echo "<td><input type='text' readonly='readonly' class='g_input_num2 g_col_fixed qty qun btt_".$x."' id='bt_".$x."' name='bt_".$x."' style='width : 100%;'readonly='readonly'/></td>";
                               echo "<td style=''><input type='button'  class='quns g_col_fixed' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'readonly='readonly'/>
                               <input type='text' class='g_input_num2 qty qun vali qtycl qtycl".$x." g_col_fixed' id='1_".$x."' name='1_".$x."' style='width : 100%;float: right;'readonly='readonly'/></td>";
                               echo "<td style=''><input type='text' class='g_input_amo g_col_fixed' id='foc_".$x."' name='foc_".$x."' style='width : 100%;'readonly='readonly'/></td>";
                               echo "<td style=''><input type='text' class='g_input_amo price vali g_col_fixed' id='2_".$x."' name='2_".$x."' style='width : 100%;'readonly='readonly'/></td>";
                               echo "<td class='g_col_fixed'><input type='text' class='g_input_amo dis_pre' id='3_".$x."' name='3_".$x."' readonly='readonly' style='width : 100%;'/></td>";
                               echo "<td style=''><input type='text' class='g_input_amo dis g_col_fixed' id='4_".$x."' name='4_".$x."' style='width : 100%;'readonly='readonly'/>
                               <input type='hidden' class='g_input_amo dis' id='rmax_".$x."' name='rmax_".$x."'readonly='readonly'/></td>";                                      
                               echo "<td ><input type='text' readonly='readonly' class='g_input_amo amount g_col_fixed' id='5_".$x."' name='5_".$x."' style='width : 100%;'readonly='readonly'/>
                               <input type='hidden' class='g_input_amo dis' id='21h_".$x."' name='21h_".$x."'/>
                               <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' />
                               <input type='hidden' id='is_free_".$x."' title='0' value='0' name='is_free_".$x."' />
                           </td>";
                           echo "</tr>";
                       }
                       ?>
                   </tbody>
               </table>
           </td>
       </tr>
       <tr>
        <td>CRN Amount</td>
        <td><input type="text" class="input_txt g_input_amo" title=''  id="crn_amount"  name="crn_amount" style="width: 100%;text-align: right;"></td>
        <td>Description</td>
        <td colspan="3"><input type="text" class="input_txt" title=''  id="description"  name="description" style="width: 100%;"></td>
        <td>&nbsp;</td>
        <td>Gross</td>
        <td><input type="text" class="hid_value" title=''  id="gross_amount"  name="gross_amount" style="width: 100%;text-align: right;"></td>
    </tr>
    <tr>
        <td>Paid Amount</td>
        <td><input type="text" class="input_txt g_input_amo" title=''  id="paid_amount"  name="paid_amount" style="width: 100%;text-align: right;"></td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Free</td>
        <td><input type="text" class="hid_value" title=''  id="free_amount"  name="free_amount" style="width: 100%;text-align: right;"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Discount</td>
        <td><input type="text" class="hid_value" title=''  id="dis_amount"  name="dis_amount" style="width: 100%;text-align: right;"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td><b>Net Amount</b></td>
        <td><input type="text" class="hid_value" title=''  id="net_amount"  name="net_amount" style="width: 100%;text-align: right;" ></td>
    </tr>
    <tr>
        <td colspan="9">
            <div style="text-align:left; padding-top: 7px;">
                <input type="button" id="btnExit" title="Exit" />
                <input type="button" id="btnReset" title="Reset" />
                <?php if($this->user_permissions->is_delete('t_hp_return')){ ?><input type="button" id="btnDelete5" title="Cancel" /><?php } ?>
                <?php if($this->user_permissions->is_re_print('t_hp_return')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
                <?php if($this->user_permissions->is_add('t_hp_return')){ ?><input type="button"  id="btnSave" title='Save <F8>' /><?php } ?>
                <?php if($this->user_permissions->is_approve('t_hp_return')){ ?><input type="button"  id="btnApprove" title='Approve' /><?php } ?>
                <input type='hidden' id='transCode' value='107' title='107'/>
                <input type='hidden' id='app_status' name='approve' title='1' value='1'/>
            </div>
        </td>
    </tr>
</table>
<?php 
if($this->user_permissions->is_print('t_hp_return')){ ?>
<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
</form>



<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

   <input type="hidden" name='by' value='t_hp_return' title="t_hp_return" class="report">
   <input type="hidden" name='page' value='A4' title="A4" >
   <input type="hidden" name='orientation' value='P' title="P" >
   <input type="hidden" name='type' value='hp_return' title="hp_return" >
   <input type="hidden" name='header' value='false' title="false" >
   <input type="hidden" name='qno' value='' title="" id="qno" >
   <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
   <input type="hidden" name="sales_type" id="sales_type" value="" title="" >
   <input type="hidden" name='dt' value='' title="" id="dt" >
   <input type="hidden" name='cus_id' value='' title="" id="cus_id" >
   <input type="hidden" name='agrmnt_no' value='' title="" id="agrmnt_no" >
   <input type="hidden" name='salesp_id' value='' title="" id="salesp_id" >
   <input type="hidden" name='org_print' value='' title="" id="org_print">

</form>


</div>
<?php } ?>