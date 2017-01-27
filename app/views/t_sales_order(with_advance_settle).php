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
                </td></td>
                <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%;" maxlength="25"/></td>
                
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="width: 100px;">INV No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="inv_no" id="inv_no" title="" style="width: 100%;" maxlength="25"/></td>
            
            </tr>    
            <tr>
                <td colspan="4" style="text-align: center;">
                
                    <table style="width: 100%;" id="tgrid" >
                        <thead>
                            <tr>
                                 <th class="tb_head_th" style="width: 50px;">Code</th>
                                <th class="tb_head_th" style="width: 50px;">Description</th>
                                <th class="tb_head_th" style="width: 70px;">Model</th>
                                <th class="tb_head_th" style="width: 10px;">Receive</th>
                                <th class="tb_head_th" style="width: 40px;">Batch</th>
                                <th class="tb_head_th" style="width: 40px;">QTY</th>
                                <th class="tb_head_th" style="width: 50px;">Price</th>
                                <th class="tb_head_th" style="width: 30px;">Dis %</th>
                                <th class="tb_head_th" style="width: 50px;">Discount</th>
                                <th class="tb_head_th" style="width: 50px;">Amount</th>
                                <th class="tb_head_th" style="width: 40px;">Delivered Qty</th>
                                <!-- <th class="tb_head_th" style="width: 40px;">Advance No</th> -->
                                <th class="tb_head_th" style="width: 50px;">Advance Amount</th>
                                <th class="tb_head_th" style="width: 20px;">&nbsp;</th>
                                <th class="tb_head_th" style="width: 20px;">&nbsp;</th>
                            </tr>
                        </thead><tbody>
                            <input type='hidden' id='transtype' title='SALES ORDER' value='SALES ORDER' name='transtype' />
                        <input type='hidden' name='all_foc_amount' id='all_foc_amount' value='0' title='0'/>
                            <?php
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                              <input type='text' class='g_input_txt fo items_".$x."' id='0_".$x."' name='0_".$x."' style='width:100%;' />
                                              <input type='hidden' name='bqty_'".$x."' id='bqty_".$x." title='0' style='display:block;visibility:hidden;'/>
                                              </td>
                                                <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
                                                <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
                                                <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
                                                <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />";

                                        echo "<td style='width:100px;' class='g_col_fixed'><input type='text' class='g_input_txt' readonly   id='n_".$x."' name='n_".$x."' maxlength='150' style='width : 122px;' readonly='readonly'/>
                                              <input type='button'  class='subs' id='sub_".$x."' style='margin:0;padding:5px;float: right; height:6px;width:6px;cursor:pointer'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed model' id='2_".$x."' name='2_".$x."' style='width : 100%;' readonly='readonly'/></td>";

                                        echo "<td><input type='checkbox' class='g_input_txt' id='rcv_".$x."' name='rcv_".$x."' value='1'/></td>";

                                        echo "<td class='g_col_fixed'><input type='button'  class='qunsb' id='btnb_".$x."' style='margin:0;padding:5px;float:left;height:6px;width:6px;cursor:pointer'/>
                                                <input type='text' class='g_input_txt g_col_fixed batch btt_".$x."' id='1_".$x."' name='1_".$x."' style='margin:0;padding:0;width :33px; float: right; text-align:right;' readonly='readonly'/></td>";
                                        echo "<td><input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float:left; height:6px;width:6px;cursor:pointer'/>
                                                <input type='hidden' id='cost_".$x."'  name='cost_".$x."' value='0'/> 
                                                <input type='text' class='g_input_num qty qun qtycl".$x."' id='5_".$x."' name='5_".$x."' style='margin:0;padding:0;width :30px;float: right;'/></td>";
                                       
                                        echo "<td><input type='text' class='g_input_amo price' id='3_".$x."' name='3_".$x."' style='width : 100%;'/>
                                                  
                                              </td>";
                                        echo "<td class='g_col_fixed'><input type='text' class='g_input_amo dis_pre' id='6_".$x."' name='6_".$x."' readonly='readonly' style='width : 100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_amo dis' id='7_".$x."' name='7_".$x."' style='width : 100%;'/>
                                                  <input type='hidden' class='tot_discount' id='tot_dis_".$x."'  name='tot_dis_".$x."' value='0'/>  
                                                </td>";
                                        echo "<td>
                                                <input type='text' class='g_input_amo amount g_col_fixed' id='8_".$x."' name='8_".$x."' style='width : 100%;text-align:right;' readonly='readonly'/>
                                                <input type='hidden' id='f_".$x."' name='f_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='bal_free_".$x."' name='bal_free_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='bal_tot_".$x."' name='bal_tot_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='free_price_".$x."' name='free_price_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='issue_qty_".$x."' name='issue_qty_".$x."' style='width : 100%;'/>
                                                <input type='hidden' id='item_min_price_".$x."' name='item_min_price_".$x."'/>
                                                <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' />
                                              </td>";
                                        echo "<td><input type='text' style='width:100%' name='deqty_".$x."' id='deqty_".$x."' class='g_input_num g_col_fixed'/>
                                                    <input type='hidden' style='width:100%' name='adno_".$x."' id='adno_".$x."' class='g_input_txt advnce'/></td>";
                                        echo "<td><input type='text' style='width:100%' name='adamnt_".$x."' id='adamnt_".$x."' readonly='readonly' class='g_input_amo g_col_fixed'/></td>";
                                        echo "<td><input type='button' class='adbtn' style='width:100%' name='adbtn_".$x."' id='adbtn_".$x."' />
                                                  <input type='hidden' name='alldata_".$x."' id='alldata_".$x."'/>
                                                  <input type='hidden' name='updtstatus_".$x."' id='updtstatus_".$x."' title='1' value='1'/>
                                                </td>";
                                        echo "<td><button type='button' class='rmvcr' style='width:100% ' name='removecr_".$x."' id='removecr_".$x."'><img src='".base_url()."/images/close_button.png'/></button></td>";
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
                                        
                                        
                                        <td align="right" style="padding-left:235px;"><b>Total Discount</b>
                                            <input type='text' id='total_discount' readonly="readonly" title="" name='total_discount' class="hid_value g_input_amounts" />
                                        </td>
                                        <td>
                                            <b>Gross</b>
                                            <input type='text' id='total2' readonly="readonly" title="" name='total2' class="hid_value g_input_amounts" />
                                        </td>
                                    </tr>
                                    <tr>
                                    <input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
                                    <input type="hidden" name="type" id="type" title="68" value="68"/>    
                                    <input type='hidden' id='transCode' value='68' title='68'/>
                                        <td>Sales Rep</td>
                                        <td colspan="4">
                                            <input type="text" class="input_txt" name="sales_rep" id="sales_rep" style="width:100px;"/>
                                            <input type="text" class="hid_value" name="sales_rep2" id="sales_rep2" style="width:295px;"/></td>
                                        <td colspan="4" style="padding-left:175px;" rowspan="4">
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
                                                        for($x=0; $x<15; $x++){
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="height:40px;"> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="height:40px;"> </td>   
                                    </tr>
                                    <tr>
                                        <td colspan="6"> </td>                                  
                                    </tr>
                                </td>
                            </tr>

                            <tr style="background-color: transparent;">
                                
                                <td colspan="6" style="padding-left : 10px;">
                                		<input type="button" id="btnExit" title="Exit" />
										<input type="button" id="btnReset" title="Reset" />
										<input type="button" id="btnDelete" title="Cancel" />
										<?php if($this->user_permissions->is_re_print('t_sales_order')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
                                        <input type="button"  id="btnSavee" title='Save <F8>' />
										<?php if($this->user_permissions->is_add('t_sales_order')){ ?><input type="button"  id="btnSave" title='Save <F8>' /><?php } ?>
										
                                </td>

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
    
</div>
<?php } ?>