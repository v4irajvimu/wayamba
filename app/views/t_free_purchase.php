<?php if($this->user_permissions->is_view('t_free_purchase')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_free_purchase.js"></script>

<div id="fade" class="black_overlay"></div>
<?php 
    if($ds['use_serial_no_items'] ){
        $this->load->view('t_serial_in.php'); 
    }
?>
 
<div id="fade" class="black_overlay"></div>

<h2 style="text-align: center;">Free Issue Purchase</h2>
<div class="dframe" id="mframe" style="width:1190px;">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_free_purchase" id="form_">
        <input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
         <input type="hidden" name="srls" id="srls"/>
         <input type='hidden' id='transCode' value='3' title='3'/>
         <table style="width: 100%" border="0" cellpadding="0">
            <tr>
                <td width="50">Supplier</td>
                <td width="100"><input type="text" class="input_active" id="supplier_id" name="supplier_id"title="" /></td>
                <td colspan="3"><input type="text" class="hid_value" id="supplier" title="" style="width:347px;"/><input type='button' value="..." title="..." id="supplier_create"/></td>
                <td width="330"></td>    
                <td >No</td>
                <td align="right" >
                    <input type="text" class="input_active_num" name="id" id="id" title="<?php echo $max_no;?>" style="width:150px;"/>
                    <input type="hidden" id="hid" name="hid" title="0" />
                    <input type="hidden" id="base_url" title="<?php echo base_url();?>" value="<?php echo base_url();?>" />
                </td>
            </tr>
            
            <tr>
                <td>Store</td>
                <td><?php echo $stores; ?></td>
                <td colspan="3"><input type="text" class="hid_value" name="store_no" id="store_no" title="" style="width:380px;"/></td>
                
                <td width="330"><input type="checkbox" id="is_dis" name="is_dis" checked="checked"> &nbsp;Percentage Discount
                    <input type="hidden" id="dis_update" name="dis_update" value="1" title="1"></td> 
                <td>Date</td>
                <td align="right">
                    <?php if($this->user_permissions->is_back_date('t_free_purchase')){ ?>
                        <input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>"  style="width:150px; text-align:right;"/>
                    <?php }else{ ?> 
                        <input type="text" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>"  style="width:150px; text-align:right;"/> 
                    <?php } ?>  
                </td>
            </tr>
            
            <tr>
                <td>Type</td>
                <td>

                <?php if($this->utility->get_is_store_in_branch('1')) {
                   echo "<select name='typess' id='typess'>
                            <option value='1'>Main Store</option>
                        </select>";
                }else{
                     echo "<select name='typess' id='typess'>
                            <option value='2'>Direct</option>
                        </select>";
                }
                ?>
                </td>
                <td>&nbsp;</td>
                <td></td>
                <td style="padding-left:123px;">Credit Period<input type="text" style="margin-left:22px;"  class="input_txt" id="credit_period" name="credit_period" title="" /></td>
                <td>
                    <input type='checkbox' id='bal_item' name='bal_item' title="1">
                    Balance Items Purchase
                </td>
                <td style="width: 100px;">Inv Date</td>
                <td align="right">
                    <?php if($this->user_permissions->is_back_date('t_free_purchase')){ ?>
                        <input type="text" class="input_date_down_future" readonly="readonly" name="ddate" id="ddate"  title="<?=date('Y-m-d')?>" style="width:150px; text-align:right;"/>
                    <?php }else{ ?> 
                        <input type="text" class="input_txt" readonly="readonly" name="ddate" id="ddate"  title="<?=date('Y-m-d')?>" style="width:150px; text-align:right;"/>   
                    <?php } ?>  
                </td>
               </tr>
            <tr>
                <td>Inv No</td>
                <td><input type="text" style="" class="input_txt" name="inv_no" id="inv_no" title="1" value='1' /></td>
                
                <td>&nbsp;</td>
                <td></td>
                <td style="padding-left:123px;"></td>
                <td>&nbsp;</td>
                <td>Ref No</td>
                <td align="right"><input type="text" class="input_txt" name="ref_no" id="ref_no" title=""  style="text-align:right;"/></td>     

            </tr>
            
            
            <tr>
                <td>&nbsp;</td>
                <!-- <td><input type="text" class="input_txt" id="pono3" name="pono3" title=" " /></td> -->
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td> 
            </tr>
            
               <tr>
                <td colspan="8" style="text-align: center;">
                    <table style="width: 1000px;" id="tgrid">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 130px;">Code</th>
                                <th class="tb_head_th">Description</th>
                                <th class="tb_head_th" style="width: 70px;">Color</th>
                                <th class="tb_head_th" style="width: 70px;">Model</th>
                                <th class="tb_head_th" style="width: 40px;">Balance Qty</th>
                                <th class="tb_head_th" style="width: 50px;">QTY</th>
                                <th class="tb_head_th" style="width: 70px;">Price</th>
                                <th class="tb_head_th" style="width: 70px;">Max Price</th>
                                <th class="tb_head_th" style="width: 70px;">Min Price</th>
                                <th class="tb_head_th" style="width: 70px;">Discount%</th>
                                <th class="tb_head_th" style="width: 70px;">Discount</th>
                                <th class="tb_head_th" style="width: 40px;">Amount</th>
                                <th class="tb_head_th" style="width: 60px;">L.P Margin</th>
                                <th class="tb_head_th" style="width: 60px;">S.P Margin</th>
                            </tr>
                        </thead><tbody>
                                <input type='hidden' id='transtype' title='PURCHASE' value='PURCHASE' name='transtype' />
                                <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                               
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td style=''><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                              <input type='text' class='g_input_txt fo' id='0_".$x."' name='0_".$x."'style='width : 120px; float:left;' style='width:100%;'  />
                                              <input type='button' class='edit_btn' id='btnedit_".$x."' style='margin:0;padding:5px;float: right; height:6px;width:6px;cursor:pointer; display:none;'></td>
                                              <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
                                              <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
                                              <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
                                              <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' /> 
                                              <input type='hidden' id='fm_".$x."' title='0' name='fm_".$x."'/> 
                                              <input type='hidden' id='po_".$x."' title='0' name='po_".$x."'/> 
                                              ";    
                                        echo "<td style='background-color:#f9f9ec;'><input type='text' class='g_input_txt g_col_fixed'  id='n_".$x."' name='n_".$x."' maxlength='150' style='width : 100%;' readonly='readonly'/>
                                        <input type='button'  class='subs' id='sub_".$x."' style='margin:0;padding:5px;float: right; height:6px;width:6px;cursor:pointer'/></td>";
                                        echo "<td ><input type='hidden' class='g_input_txt g_col_fixed' readonly id='colc_".$x."' name='colc_".$x."' style='width:100%;'/>
                                              <input type='button'  class='colors' id='colb_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
                                              <input type='text' class='g_input_txt g_col_fixed' readonly id='col_".$x."' style='width:74%;float:right;'/></td>";
                                        echo "<td><input type='text' class='g_input_num2 g_col_fixed qun' id='1_".$x."' name='1_".$x."' style='width : 100%;' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_num g_col_fixed balq' id='b1_".$x."' name='b1_".$x."' style='width : 100%;' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td style=''><input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer' style='width:100%;'/>
                                        <input type='text' class='g_input_num qty qun qtt_".$x."' id='2_".$x."' name='2_".$x."' style='width : 40px; float:right;' style='width:100%;' />
                                        <input type='hidden' class='g_input_num foc' id='3_".$x."' name='3_".$x."' style='width : 0px;'/>
                                        </td>";
                                      
                                        echo "<td style=''><input type='text' class='g_input_amo price' id='4_".$x."' name='4_".$x."' style='width : 100%;'/>
                                                           <input type='hidden' id='ccc_".$x."' name='ccc_".$x."'/>
                                              </td>";
                                        echo "<td style=''><input type='text' class='g_input_amo price' id='max_".$x."' name='max_".$x."' style='width : 100%;'/></td>";
                                        echo "<td style=''><input type='text' class='g_input_amo price' id='min_".$x."' name='min_".$x."' style='width : 100%;'/></td>";
                                        echo "<td ><input type='text' class='g_input_num dis_pre'  id='5_".$x."' name='5_".$x."' style='width : 100%;'/></td>";
                                        echo "<td ><input type='text' class='g_input_amo dis' id='6_".$x."' readonly='readonly' name='6_".$x."' style='width : 100%;'/></td>";
                                        echo "<td><input type='text' id='t_".$x."' name='t_".$x."' style='text-align: right;' class='tf g_col_fixed g_input_amo' style='width:100%;'/>
                                             <input type='hidden' id='qtyt_".$x."' title='0' name='qtyt_".$x."'/>   
                                             <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."'/> 
                                             <input type='hidden' id='is_click_".$x."' title='0' name='is_click_".$x."'/>
                                             <input type='hidden' id='freeqty_".$x."' title='0' name='freeqty_".$x."'/>   
                                             </td>";
                                       
                                        echo "<td style=''><input type='text' class='g_col_fixed price' id='lpm_".$x."' style='width : 100%;'/></td>";     
                                        echo "<td style=''><input type='text' class='g_col_fixed price' id='spm_".$x."' style='width : 100%;'/></td>";      
                                    echo "</tr>";
                                }
                            ?>

                            
                        </tbody>
                        </table>
                        <table>
                            <tr>
                                
                                <td>Memo</td>
                                <td>
                                    <input type="text" class="input_txt" name="memo" id="memo" title="" style="width:503px;" maxlength="255" />
                                </td>
                                <td style="text-align: right; font-weight: bold; font-size: 12px;" width="440">Gross Amount</td>
                                <td><input type='text' class='hid_value g_input_amounts' id='gross_amount' name='gross_amount' readonly="readonly" />
                                    <input type='hidden' id='gross_amount222' name='gross_amount222'/>  
                                    <input type='hidden' id='tot_add_cost' name='tot_add_cost' />
                                </td>
                            </tr>
                            <tr>
                                <td>Delivery Officer</td>
                                <td>
                                    <input type="text" class="input_txt" name="del_officer" id="del_officer" title="" style="width:150px;"  />
                                </td>   
                                <td style="text-align: right; font-weight: bold; font-size: 12px;" width="110">Discount Amount</td>
                                <td><input type='text' class='hid_value g_input_amounts' id='dis_amount' name='dis_amount' readonly="readonly" /></td>
                            </tr>
                            <tr>
                                <td>Check By</td>
                                <td><input type="text" class="input_txt" name="checkby" id="checkby" title="" style="width:150px;"  />
                                    <input type="text" class="hid_value" name="checkby_des" id="checkby_des" title="" style="width:350px;"  />
                                </td>
                                <td style="text-align: right; font-weight: bold; font-size: 12px;">Free Total</td>
                                <td><input type='text' class='hid_value g_input_amounts' id='freet' readonly="readonly" name='freet'  /></td>                   
                            </tr>
                            <tr>
                                <td>Vehicle No</td>
                                <td><input type="text" class="input_txt" name="vehicleNo" id="vehicleNo" title="" style="width:150px;"  /></td>
                                <td style="text-align: right; font-weight: bold; font-size: 12px;">Debit Note Amount</td>
                                <td><input type='hidden' class='hid_value g_input_amounts' id='total2' readonly="readonly" name='total'  />
                                    <input type='text' class='hid_value g_input_amounts' id='debeit' readonly="readonly" name='debeit'  />
                                    <input type='hidden' id='total22'  name='total22'  />   
                                </td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: right; font-weight: bold; font-size: 12px;">Net Amount</td>
                                <td><input type='text' class='hid_value g_input_amounts' id='net_amount' readonly="readonly" name='net_amount' /></td>          
                            </tr>
                        </table>
                        </tr>                      
                    </table>

                    <div style="text-align: right; padding-top: 7px;">
                        <input type="button" id="btnExit" title="Exit" />
                        <input type="button" id="btnReset" title="Reset" />
                        <?php if($this->user_permissions->is_delete('t_free_purchase')){ ?><input type="button" id="btnDelete5" title="Cancel" /><?php } ?>
                        <?php if($this->user_permissions->is_re_print('t_free_purchase')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
                        <input type="button"  id="btnSavee" title='Save <F8>' />
                        <?php if($this->user_permissions->is_add('t_free_purchase')){ ?><input type="button"  id="btnSave" title='Save <F8>' /><?php } ?>
                        <?php if($this->user_permissions->is_approve('t_free_purchase')){ ?><input type="button"  id="btnApprove" title='Approve' /><?php } ?>
                        <input type="hidden" name="app_status" id="app_status" value="1"/>
                    </div>


                </td>
            </tr>
        </table>
        <?php 
if($this->user_permissions->is_print('t_free_purchase')){ ?>
    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
    </form>



   <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">                  
                 <input type="hidden" name='by' value='t_grn_sum' title="t_grn_sum" class="report">
                 <input type="hidden" name='page' value='A4' title="A4" >
                 <input type="hidden" name='orientation' value='P' title="P" >
                <input type="hidden" name='type' value='purchase' title="purchase" > 
                  <!-- <input type="hidden" name='type' value='t_grn_sum' title="t_grn_sum" >-->
                 
                 <input type="hidden" name='header' value='false' title="false" >
                 <input type="hidden" name='qno' value='' title="" id="qno" >
                 <input type="hidden" name='rep_sup' value='' title="" id="rep_sup" >
                 <input type="hidden" name='rep_ship_bc' value='' title="" id="rep_ship_bc" >
                 <input type="hidden" name='inv_date' value='' title="" id="inv_date" >
                 <input type="hidden" name='inv_nop' value='' title="" id="inv_nop" >
                 <input type="hidden" name='po_nop' value='' title="" id="po_nop" >
                 <input type="hidden" name='po_dt' value='' title="" id="po_dt" >
                 <input type="hidden" name='note' value='' title="" id="note" >
                 <input type="hidden" name='credit_prd' value='' title="" id="credit_prd" >
                 <input type="hidden" name='rep_deliver_date' value='' title="" id="rep_deliver_date" >
                 <input type="hidden" name='org_print' value='' title="" id="org_print">
        
        </form>
</div>
<?php } ?>