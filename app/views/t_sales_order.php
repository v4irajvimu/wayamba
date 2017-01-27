<?php if($this->user_permissions->is_view('t_sales_order')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_sales_order.js"></script>
<div id="fade" class="black_overlay"></div>
<?php 
    if($ds['use_serial_no_items'] ){
        $this->load->view('t_serial_out.php'); 
    }
?>
<form method="post" action="<?=base_url()?>index.php/main/save/t_sales_order" id="form_">
<h2 style="text-align: center;">Sales Order</h2>
<div class="dframe" id="mframe" style="padding-right:25px;width:1150px;">
        <table style="width: 100%" border="0">
            <tr>
                <td style="width: 100px;">Customer</td>
                <td><input type="text" id="customer" name="customer"class="input_active" title=""/>
                       <input type="text" class="hid_value" id="customer_id" title="" readonly="readonly" style="width: 302px;" />
                        <input type="button" id='btn_cus' title="...">
                        &nbsp; &nbsp; &nbsp; &nbsp;% Discount
                        <input type="checkbox" id="is_dis" name="is_dis" checked="checked">
                        <input type="hidden" id="dis_update" name="dis_update" value="1" title="1">
                    </td>
                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" class="input_active_num" name="id" style="width:100%" id="id" title="<?=$max_no?>" />
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>
            </tr><tr>
                <td>Address</td>
                <td>
                    <input type="text" class="hid_value" name="address" id="address" title="" readonly="readonly" style="width:455px;"/>
                </td>
                <td style="width: 100px;">Date</td>
                <td style="width: 100px;">
                    <?php if($this->user_permissions->is_print('t_sales_order')){ ?>
                        <input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php }else{ ?>   
                        <input type="text" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>Store</td>
                <td>
                    <?php echo $stores; ?>
                    <input type="text"  id="store_id" style="width:303px;" class="hid_value" title="" readonly="readonly"/>
                      <input type="button" id='btn_pop_cus' title="Sales Order History">
                </td></td>
                
                <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%;" maxlength="25"/></td>
                
            </tr>
            
            <tr>
                <td colspan="4" style="text-align: center;">
                
                    <table style="width: 100%;" id="tgrid" >
                        <thead>
                            <tr>
                                 <th class="tb_head_th" style="width: 200px;">Code</th>
                                <th class="tb_head_th" style="width: 280px;">Description</th>
                                <th class="tb_head_th" style="width: 120px;">Model</th>
                                <th class="tb_head_th" style="width: 80px;">Batch</th>
                                <th class="tb_head_th" style="width: 10px;">Cur Stock</th>
                                <th class="tb_head_th" style="width: 10px;">Reserve Qty</th>
                                <th class="tb_head_th" style="width: 100px;">QTY</th>
                                <th class="tb_head_th" style="width: 50px;">FOC</th>
                                <th class="tb_head_th" style="width: 120px;">Price</th>
                                <th class="tb_head_th" style="width: 100px;">Dis %</th>
                                <th class="tb_head_th" style="width: 100px;">Discount</th>
                                <th class="tb_head_th" style="width: 120px;">Amount</th>
                                <th class="tb_head_th" style="width: 40px;">Delivered Qty</th>
                                <!-- <th class="tb_head_th" style="width: 40px;">Advance No</th> 
                                <th class="tb_head_th" style="width: 50px;">Advance Amount</th>-->
                                <!-- <th class="tb_head_th" style="width: 20px;">&nbsp;</th>
                                <th class="tb_head_th" style="width: 20px;">&nbsp;</th> -->
                            </tr>
                        </thead><tbody>
                            <input type='hidden' id='transtype' title='SALES ORDER' value='SALES ORDER' name='transtype' />
                            <input type='hidden' name='all_foc_amount' id='all_foc_amount' value='0' title='0'/>
                            <?php
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                              <input type='text' class='g_input_txt fo FOCAdded items_".$x."' id='0_".$x."' name='0_".$x."' style='width:100%;' />
                                              <input type='hidden' name='bqty_'".$x."' id='bqty_".$x." title='0' style='display:block;visibility:hidden;'/>
                                              </td>
                                                <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
                                                <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
                                                <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
                                                <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />";

                                        echo "<td class='g_col_fixed'><input type='text' class='g_input_txt im' readonly   id='n_".$x."' name='n_".$x."' maxlength='150' style='width:100%;' readonly='readonly'/>
                                              <input type='button'  class='subs' id='sub_".$x."' style='margin:0;padding:5px;float: right; height:6px;width:6px;cursor:pointer'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed model' id='2_".$x."' name='2_".$x."' style='width : 100%;' readonly='readonly'/></td>";


                                        echo "<td class='g_col_fixed'><input type='button'  class='qunsb' id='btnb_".$x."' style='margin:0;padding:5px;float:left;height:6px;width:6px;cursor:pointer'/>
                                                <input type='text' class='g_input_txt g_col_fixed batch btt_".$x."' id='1_".$x."' name='1_".$x."' style='margin:0;padding:0;width :33px; float: right; text-align:right;' readonly='readonly'/></td>";
                                        
                                        echo "<td><input type='text' class='g_col_fixed g_input_num' id='cqty_".$x."' name='cqty_".$x."'/></td>";                                       

                                        echo "<td style='width:80px;'><input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float:left; height:6px;width:6px;cursor:pointer'/>
                                              <input type='text' style='margin:0;padding:0;width :50px;float: right;' class='g_input_num qun qtycl".$x."' id='rcvqty_".$x."' name='rcvqty_".$x."' value='0'/></td>";
                                        echo "<td><input type='hidden' id='cost_".$x."'  name='cost_".$x."' value='0'/> 
                                                <input type='text' class='g_input_num qty'  id='5_".$x."' name='5_".$x."' style='margin:0;padding:0;width :100px;float: right;'/></td>";
                                        
                                        echo "<td><input type='text' class='g_input_num foc'  id='4_".$x."' name='4_".$x."' style='margin:0;padding:0;width :50px;float: right;'/></td>";
                                       
                                        echo "<td><input type='text' class='g_input_amo price' id='3_".$x."' name='3_".$x."' style='width : 100%;'/>
                                                  
                                              </td>";
                                        echo "<td><input type='text' class='g_input_amo dis_pre' id='6_".$x."' name='6_".$x."'  style='width : 100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_amo dis' id='7_".$x."' name='7_".$x."' style='width : 100%;'readonly='readonly'/>
                                                  <input type='hidden' class='tot_discount' id='tot_dis_".$x."'  name='tot_dis_".$x."' value='0'/>  
                                                </td>";
                                        echo "<td>
                                                <input type='text' class='g_input_amo amount g_col_fixed' id='8_".$x."' name='8_".$x."' style='width : 100%;text-align:right;' readonly='readonly'/>
                                                <input type='hidden' id='f_".$x."' name='f_".$x."' style='width : 100%;' class='isFree'/>
                                                <input type='hidden' id='bal_free_".$x."' name='bal_free_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='bal_tot_".$x."' name='bal_tot_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='free_price_".$x."' name='free_price_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='issue_qty_".$x."' name='issue_qty_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='item_min_price_".$x."' name='item_min_price_".$x."'/>
                                                <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' />
                                              </td>";
                                        echo "<td><input type='text' style='width:100%' name='deqty_".$x."' id='deqty_".$x."' class='g_input_num g_col_fixed'/>
                                                    <input type='hidden' style='width:100%' name='adno_".$x."' id='adno_".$x."' class='g_input_txt advnce'/></td>";
                                        echo "<td style='display:none;'><input type='text' style='width:100%' name='adamnt_".$x."' id='adamnt_".$x."' readonly='readonly' class='g_input_amo g_col_fixed'/></td>";

                                        echo "<input type='hidden' id='itm_status_".$x."' title='0' value='0' name='itm_status_".$x."' />

                                        ";   
                                                                            
                                        // echo "<td><input type='button' class='adbtn' style='width:100%' name='adbtn_".$x."' id='adbtn_".$x."' />
                                        //           <input type='hidden' name='alldata_".$x."' id='alldata_".$x."'/>
                                        //           <input type='hidden' name='updtstatus_".$x."' id='updtstatus_".$x."' title='1' value='1'/>
                                        //         </td>";
                                       // echo "<td><button type='button' class='rmvcr' style='width:100% ' name='removecr_".$x."' id='removecr_".$x."'><img src='".base_url()."/images/close_button.png'/></button></td>";
                                        echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
             
                        <table style="width:100%;" border="0">  
                            <tr>
                                <td  style="width:100px;">Memo</td>
                                <td colspan="5" >
                                   <input type="text" class="input_txt" name="memo" id="memo" title="" style="width:400px;"/>
                                </td>
                                
                                
                                <td align="right" style='padding-right:36px;'><b>Total Discount</b>
                                    <input type='text' id='total_discount' readonly="readonly" title="" style='width:75px;' name='total_discount' class="hid_value g_input_amounts" />
                                </td>
                                <td>
                                    <b>Gross</b>
                                    <input type='text' id='total2' readonly="readonly" title="" name='total2' style='width:100px;' class="hid_value g_input_amounts" />
                                </td>
                            </tr>

                            <tr>
                                <input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
                                <input type="hidden" name="type" id="type" title="68" value="68"/>    
                                <input type='hidden' id='transCode' value='68' title='68'/>
                                <input type="hidden" id="s3" name="s3" title="<?=$sale_price['is_sale_3']?>" />
                                <input type="hidden" id="s4" name="s4" title="<?=$sale_price['is_sale_4']?>" />
                                <input type="hidden" id="s3_des" name="s3_des" title="<?=$sale_price['def_sale_3']?>" />
                                <input type="hidden" id="s4_des" name="s4_des" title="<?=$sale_price['def_sale_4']?>" />
                                <td>Sales Rep</td>
                                <td colspan="4">
                                    <input type="text" class="input_txt" name="sales_rep" id="sales_rep" style="width:100px;"/>
                                    <input type="text" class="hid_value" name="sales_rep2" id="sales_rep2" style="width:295px;"/></td>
                                </td>
                            </tr>
                       </table>
                       <table style="width:100%;" border="0">

                       <tr>
                       <td style="width:20%;">
                            <table>
                                <tr>
                                    <td style="width:97px;">Cash</td>
                                    <td><input type="text" name='cash_ad' id='cash_ad' class="g_input_amo input_active_num" style="border:1px solid #003399;padding:3px 0;width:120px;" /></td>
                                </tr>
                                <tr>
                                    <td>Credit Card</td>
                                    <td>
                                        <input type="text" name='card_ad' id='card_ad' class="hid_value input_active_num" style="border:1px solid #003399;padding:3px 0;width:120px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cheque</td>
                                    <td>
                                        <input type="text" name='chq_ad' id='chq_ad' class="hid_value input_active_num" style="border:1px solid #003399;padding:3px 0;width:120px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><input type="text" name='tot_ad' id='tot_ad' class="hid_value g_input_amounts" style="width:120px;"/></td>
                                </tr>
                            </table>
                       </td>
                       <td style="width:50%;">
                           <div id="tab">
                                <ul>
                                    <li><a href="#tab-2" >Credit Card</a></li>
                                    <li><a href="#tab-3" >Cheque</a></li>
                                </ul>

                                <div id="tab-2">
                                    <fieldset>
                                    <div class="tgrid3">
                                        <table style="width:100%; min-height:40px;" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th class="tb_head_th" style="width:80px;">Type</th>
                                                    <th class="tb_head_th" style="width:80px;">Amount</th>
                                                    <th class="tb_head_th" style="width:80px;">Number</th>
                                                    <th class="tb_head_th" style="width:80px;">Bank</th>
                                                    <th class="tb_head_th" style="width:80px;">Bank Name</th>
                                                    <th class="tb_head_th" style="width:80px;">Month</th>
                                                    <th class="tb_head_th" style="width:80px;">Rate%</th>
                                                    <th class="tb_head_th" style="width:80px;">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    for($x=0; $x<5; $x++){
                                                        echo "<tr>";
                                                        echo "<td><input type='text' readonly class='g_input_txt type1' id='type1_".$x."' name='type1_".$x."'  /></td>";
                                                        echo "<td><input type='text' class='g_input_amo cc_amount'  id='amount1_".$x."' name='amount1_".$x."'/></td>";                
                                                        echo "<td><input type='text' style='border: medium none;width: 100%;' maxlength='30' class='' id='no1_".$x."' name='no1_".$x."'/></td>"; 
                                                        echo "<td>
                                                                    <input type='text' readonly class='g_input_txt bank1' id='bank1_".$x."' name='bank1_".$x."'/>
                                                                    <input type='hidden' id='acc1_".$x."' name='acc1_".$x."'/>
                                                                    <input type='hidden' id='merchant1_".$x."' name='merchant1_".$x."'/>
                                                              </td>"; 
                                                        echo "<td><input type='text' class='g_input_txt g_col_fixed bank11' id='1bank1_".$x."' name='1bank1_".$x."'/></td>"; 
                                                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='month1_".$x."' name='month1_".$x."'/></td>"; 
                                                        echo "<td><input type='text' class='g_input_amo g_col_fixed' id='rate1_".$x."' name='rate1_".$x."'/></td>";
                                                        echo "<td><input type='text' class='g_input_amo g_col_fixed' id='amount_rate1_".$x."' name='amount_rate1_".$x."'/></td>";                
                                                        echo "</tr>";
                                                    }
                                                ?>                                          
                                            </tbody>
                                        </table>
                                        </div>
                                    </fieldset>
                                </div>

                                <div id="tab-3">
                                    <fieldset>
                                    <div class="tgrid3">
                                        <table style="width:100%;" cellpadding="0" >
                                            <thead>
                                                <tr>
                                                    <th class="tb_head_th" style="width:80px;">Bank</th>
                                                    <th class="tb_head_th" style="width:80px;">Branch</th>
                                                    <th class="tb_head_th" style="width:80px;">Account No</th>
                                                    <th class="tb_head_th" style="width:80px;">Cheque No</th>
                                                    <th class="tb_head_th" style="width:80px;">Amount</th>
                                                    <th class="tb_head_th" style="width:80px;">CHQ Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    for($x=0; $x<5; $x++){
                                                        echo "<tr>";
                                                        echo "<td><input type='text' class='g_input_txt bank9' readonly id='bank9_".$x."' name='bank9_".$x."' /></td>";
                                                        echo "<td><input type='text' class='g_input_txt g_col_fixed branch9' id='branch9_".$x."' name='branch9_".$x."' /></td>";                
                                                        echo "<td><input type='text' class='g_input_txt' id='acc9_".$x."' name='acc9_".$x."' /></td>";                
                                                        echo "<td><input type='text' class='g_input_txt' id='cheque9_".$x."' name='cheque9_".$x."'/></td>";
                                                        echo "<td><input type='text' class='g_input_amo cr_amount' id='amount9_".$x."' name='amount9_".$x."'/></td>";                
                                                        echo "<td><input type='text' class='input_date_down_future'  style='border:none;height:17px;font-weight:normal;' id='date9_".$x."' name='date9_".$x."'/></td>";                
                                                        echo "</tr>";
                                                    }
                                                ?>                                          
                                            </tbody>
                                        </table>
                                        </div>
                                    </fieldset>
                                </div>
                           </div>
                       </td>
                       <td>
                            <table style="width:100%" id="tgrid2">
                                <thead>
                                    <tr>
                                        <th class="tb_head_th" style="width: 50px;">Type</th>
                                        <th class="tb_head_th">Description</th>
                                        <th class="tb_head_th" style="width: 50px;">Rate%</th>
                                        <th class="tb_head_th" style="width: 50px;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for($x=0; $x<5; $x++){
                                            echo "<tr>";
                                                echo "<td><input type='hidden' name='hh_".$x."' id='hh_".$x."' title='0' />
                                                <input type='hidden' name='hhh_".$x."' id='hhh_".$x."' title='0' />
                                                        <input type='text' class='g_input_txt foo' id='00_".$x."' name='00_".$x."' readonly='readonly' style='width : 100%;' /></td>";
                                                echo "<td><input type='text' class='g_input_txt g_col_fixed'  id='nn_".$x."' name='nn_".$x."' maxlength='150' style='width : 100%;' readonly='readonly'/></td>";
                                                echo "<td><input type='text' class='g_input_amo rate' id='11_".$x."' name='11_".$x."' style='width : 100%; text-align:right; '/></td>";
                                               
                                                echo "<td style=''><input type='text' id='tt_".$x."' name='tt_".$x."' class='g_input_amo aa' style='text-align: right;'/></td>";
                                            echo "</tr>";
                                        }
                                    ?>


                                </tbody>

                            </table> 
                            <table>
                                <tr>
                                    <td height="21">
                                    </td>
                                </tr>
                            </table>
                       </td>
                       </tr>             
                    </table>
                    <table>       
                            <tr style="background-color: transparent;">
                                
                                <td colspan="6" style="padding-left : 10px;">
                                        <input type="button" id="btnExit" title="Exit" />
                                        <input type="button" id="btnReset" title="Reset" />
                                        <input type="button" id="btnDelete" title="Cancel" />
                                        <?php if($this->user_permissions->is_re_print('t_sales_order')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
                                        <input type="button"  id="btnSavee" title='Save <F8>' />
                                        <?php if($this->user_permissions->is_add('t_sales_order')){ ?><input type="button"  id="btnSave" title='Save <F8>' /><?php } ?>
                                        
                                </td>
                                 <td style="width:588px">&nbsp;</td>
                                <td align="right" style="margin-bottom :0px;" ><b> Net Amount</b></td>
                                <td>
                                    <input type="hidden" name="addi_tot" id="addi_tot"/s>
                                    <input type='text' style="margin-left:36px;" id='net_amount' readonly="readonly" title="" name='net_amount' class="hid_value g_input_amounts"/></td>
                            </tr>
                                                
                            
                            <?php 
                            if($this->user_permissions->is_print('t_sales_order')){ ?>
                                <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                            <?php } ?> 
                    </table>
                 
                </td>
            </tr>
        </table>
    


</form>


<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">                  
     <input type="hidden" name='by' value='t_sales_order' title="t_sales_order" class="report">
     <input type="hidden" name='page' value='A4' title="A4" >
     <input type="hidden" name='orientation' value='P' title="P" >
     <input type="hidden" name='type' value='t_sales_order' title="t_sales_order" >
     <input type="hidden" name='header' value='false' title="false" >
     <input type="hidden" name='qno' value='' title="" id="qno" >
</form>

<form id="print_pdf2" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
     <input type="hidden" name='by' value='t_so_advance_payment' title="t_so_advance_payment" class="report">
     <input type="hidden" name='page' value='A4' title="A4" >
     <input type="hidden" name='orientation' value='P' title="P" >
     <input type="hidden" name='type' value='advance_payment' title="advance_payment" >
     <input type="hidden" name='reciviedAmount' value='' title=""  id='reciviedAmount'>
     <input type="hidden" name='header' value='false' title="false" >
     <input type="hidden" name='qno' id="qno2" >
     <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
     <input type="hidden" name="sales_type" id="sales_type" value="" title="" >
     <input type="hidden" name='dt' value='' title="" id="dt" >
     <input type="hidden" name='cus_id' value='' title="" id="cus_id" >
     <input type="hidden" name='salesp_id' value='' title="" id="salesp_id" >
     <input type="hidden" name='org_print' value='' title="" id="org_print">
</form>


<form id="print_pdf3" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
     <input type="hidden" name='by' value='t_so_advance_payment' title="t_so_advance_payment" class="report">
     <input type="hidden" name='page' value='A4' title="A4" >
     <input type="hidden" name='orientation' value='P' title="P" >
     <input type="hidden" name='type' value='advance_payment' title="advance_payment" >
     <input type="hidden" name='reciviedAmount' value='' title=""  id='reciviedAmount3'>
     <input type="hidden" name='header' value='false' title="false" >
     <input type="hidden" name='qno' value='' title="" id="qno3" >
     <input type="hidden" name='dt' value='' title="" id="dt3" >
     <input type="hidden" name='cus_id' value='' title="" id="cus_id3" >

</form>
    
</div>
<?php } ?>