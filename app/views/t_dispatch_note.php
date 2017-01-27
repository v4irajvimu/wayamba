<?php if($this->user_permissions->is_view('t_dispatch_note')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_dispatch_note.js"></script>

<div id="fade" class="black_overlay"></div>
 <?php $this->load->view('t_serial_out.php'); ?>
 

<div id="fade" class="black_overlay"></div>

<h2 style="text-align: center;">Dispatch Note</h2>
<div class="dframe" id="mframe" style="padding-right:25px;">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_dispatch_note" id="form_">
        <table style="width: 100%" border="0">
            <tr>
                <td style="width: 100px;">From Store</td>
                <td><span><?=$get_from_store?></span>
                    <input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
                    <input type="text"  class="hid_value"  id="from_store_id"  title="" style="width: 300px;" />
                    </td>
                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" class="input_active_num" name="id" id="id" style="width:100%" title="<?=$id?>" />
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>
            </tr><tr>
                <td style="width: 100px;">To Store</td>
                <td><span><?=$get_to_store?></span>
                    <input type="text" name="to_store_id" class="hid_value" id="to_store_id" title="" style="width: 300px;" />
                    </td>
                <td style="width: 100px;">Date</td>
                <td style="width: 100px;">
                    <?php if($this->user_permissions->is_back_date('t_dispatch_note')){ ?>
                        <input type="text" class="input_date_down_future" readonly="readonly" name="action_date" id="action_date" title="<?=date('Y-m-d')?>" style="text-align:right;"/>
                    <?php } else { ?>
                        <input type="text" class="input_txt" readonly="readonly" name="action_date" id="action_date" title="<?=date('Y-m-d')?>" style="text-align:right;"/>
                    <?php } ?>    
                </td>
            </tr>

            <tr>
                <td style="width: 100px;">Group</td>
                <td><!-- <select></select> -->
                    <input type="text" id="group_id" name="group_id" class="input_txt"/>
                    <input type="text" name="group" class="hid_value" id="group" title="" style="width: 300px;" />
                    </td>
               <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%; text-align:right;" maxlength="25"/></td>
                 </tr>

            <tr>
                <td>Memo</td>
                <td>
                   <input type="text" class="input_txt" name="memo" id="memo" title="" style="width:455px;"/>
                </td>
                <td colspan="2">&nbsp;</td>
            </tr>


            <tr>
                <td colspan="6"> 
                	
                    <table style="width:100%;" id="tgrid" cellpadding="0" border="0">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 120px;">Item Code</th>
                                <th colspan="5" class="tb_head_th">Name</th>
                                <th class="tb_head_th" style="width: 70px;">Batch No</th>
                                <th class="tb_head_th" style="width: 70px;">QTY</th>
                                
                            </tr>
                        </thead><tbody>
                        <input type='hidden' id='transtype' title='DISPATCH NOTE' value='DISPATCH NOTE' name='transtype' />
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        
                                        echo "<td><input type='text' class='g_input_txt fo' id='0_".$x."' name='0_".$x."' style='background-color: #f9f9ec;width:100%;'/></td>
                                        <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
                                        <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
                                        <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
                                        <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />  ";
                                        echo "<td colspan='5'><input type='text' class='g_input_txt' id='1_".$x."' name='1_".$x."' style='width : 100%;'/></td>";
                                        echo "<td><input type='button'  class='qunsb' id='btnb_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
                                        <input type='text' class='g_input_txt txt_align btt_".$x."' id='2_".$x."' name='2_".$x."' style='width :40px; float: right;'/></td>";
                                        echo "<td><input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
                                        <input type='text' class='g_input_txt txt_align chk qun qtycl".$x." ky' id='3_".$x."' name='3_".$x."' style='float:right;width:40px;'/>
                                        <input type='hidden' class='g_input_amo dis' id='qtyh_".$x."' name='qtyh_".$x."' /></td>";
                                        echo "<td><input type='hidden' class='g_amount' id='amount_".$x."' name='amount_".$x."' />
                                        <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' /></td>";
                                    
                                       
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            
                        	<tr>
                        		<td>Officer</td>
                        		<td colspan="7">
                        			<input type="text"  name="officer" id="officer" class="input_active" style="border:1px solid #039; background:#fff;" title="" />
                        			<input type="text"  name="officer_id" id="officer_id" class="input_active" title=""  style="border:1px solid #039; background:#fff;width:420px;"/>
                        		</td>

                        	</tr>
                            <tr> <td colspan="8" style="height:10px;" ><hr class="hline"/></td></tr>
                            <tr style="background-color: transparent;">
                                
                                <td colspan="7" style="padding-left : 10px;">
                         
                                        <input type="button" id="btnExit" title="Exit" />
										<input type="button" id="btnReset" title="Reset" />
										<?php if($this->user_permissions->is_delete('t_dispatch_note')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?>
										<?php if($this->user_permissions->is_re_print('t_dispatch_note')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
                                        <input type="hidden" name="type" id="type" title="loading" value="loading"  />
										<?php if($this->user_permissions->is_add('t_dispatch_note')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                                        <!-- <input type="hidden" name='save_chk' value="0" title="0" id="save_chk" >  -->
										<input type="hidden" name="srls" id="srls"/>
                                        <input type='hidden' id='transCode' value='13' title='13'/>

                                </td>
                              
                                <td>
                                	
                            </tr>
                            
                        </tfoot>
                        
                    </table>
                 
                </td>
                <?php 
                    if($this->user_permissions->is_print('t_dispatch_note')){ ?>
                    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                <?php } ?> 
            </tr>
        </table>
    </form>

    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
                  
                <input type="hidden" name='by' value='t_dispatch_note' title="t_dispatch_note" class="report">
                <input type="hidden" name='page' value='A4' title="A4" >
                <input type="hidden" name='orientation' value='P' title="P" >
                <input type="hidden" name='type1' value='NOTE' title="NOTE" >
                <input type="hidden" name='pdf_id' value='' title="" id="pdf_id" >
                <input type="hidden" name='qno' value='' title="" id="qno" >
                <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
                <input type="hidden" name='dt' value='' title="" id="dt" > 
                <input type="hidden" name='org_print' value='' title="" id="org_print">
        
        </form>
    
</div>
<?php } ?>
