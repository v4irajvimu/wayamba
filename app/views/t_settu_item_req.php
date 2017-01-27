<?php if($this->user_permissions->is_view('t_settu_item_req')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/t_settu_item_req.js'></script>
<h2>Seettu Item Request</h2>

<table width="100%" border="0">
    <tr>
        <td valign="top" class="content" style="width:60%;">
        <div class="dframe" id="mframe" style="width:97%;">
        <form id="form_" method="post" action="<?= base_url() ?>index.php/main/save/t_settu_item_req" >
            <table>
                <tr>
                    <td>
            <table border="0" style="width:100%;">
                <tr>
                    <td style="width: 100px;">Organizer</td>
                    <td>
                        <input type="text" class="input_active" id="organizer_id" name="organizer_id" title="" /></td><td>
                        <input type="text" class="hid_value" id="organizer_name" title="" style="width:300px;" readonly='readonly'/>
                        <input type="hidden" id="root" name="root"/>
                    </td>
                    <td style="width: 150px;"></td> 
                    <td style="width: 150px; text-align:right;">No</td>
                    <td>
                        <input type="text" class="input_active_num" name="id" id="id" style="width:100%" title="<?=$max_no?>"/>
                        <input type="hidden" id="hid" name="hid" title="0" />
                    </td>
                </tr>
                <tr>
                    <td style="width: 100px;">Seettu No</td>
                    <td>
                        <input type="text" class="input_active" id="seettu_id" name="seettu_id"title="" /></td><td>
                    </td>
                    <td style="width: 150px;"></td> 
                    <td style="width: 150px; text-align:right;">date</td>
                    <td>
                    <?php if($this->user_permissions->is_back_date('t_settu_item_req')){ ?>
                        <input type="text" style="width:100%; text-align:right;" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php }else{ ?> 
                        <input type="text" style="width:100%; text-align:right;" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php } ?>  
                    </td>
                </tr>
                <tr>
                    <td style="width: 100px;">Items</td>
                    <td>
                        
                    </td>
                    <td style="width: 150px;"></td>
                    <td style="width: 150px;"></td> 
                    <td style="width: 150px; text-align:right;">Ref.No</td>
                    <td>
                     <input type="text" class="input_active_num" name="ref_no" id="ref_no" style="width:100%"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: center;">
                        <table style="width: 100%;" id="tgrid" >
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 50px;">OK</th>
                                <th class="tb_head_th" style="width: 200px;">Category</th>
                                <th class="tb_head_th" style="width: 200px;">Item</th>
                                <th class="tb_head_th" style="width: 500px;">Description</th>
                            </tr>
                        </thead><tbody class="tb">
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                              <input type='checkbox' class='g_input_txt fo' readonly id='0_".$x."' name='0_".$x."'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='n_".$x."' name='n_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='1_".$x."' name='1_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='2_".$x."' name='2_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </table>
             <?php 
              if($this->user_permissions->is_print('t_settu_item_req')){ ?>
                  <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
              <?php } ?> 
            <div style="text-align: left; padding-top: 7px;">
                        <input type="button" id="btnExit" title="Exit" />
                        <input type="button" id="btnReset" title="Reset" />
                        <?php if($this->user_permissions->is_delete('t_settu_item_req')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
                        <?php if($this->user_permissions->is_re_print('t_settu_item_req')){ ?><input type="button" id="btnPrint" title="Print" /> <?php } ?>                    
                        <?php if($this->user_permissions->is_add('t_settu_item_req')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                    </div>
    </td>
        <td valign="top" class="content" style="width:60%;">
        <fieldset style="height:340">
            <table border="0" style="width:100%;">
            <tr>
                  <td style="height:28px;">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>  
            </tr>
            <tr>
                  <td colspan="2" style="width:150px;">Pending request</td>
                  <td><input type="text" class="input_active_num" id="pending_tot" style="width:100%" /></td>  
            </tr>
            <tr>
                  <td style="height:28px;">&nbsp;</td>
                  <td style="width:80px;">&nbsp;</td>
                  <td>&nbsp;</td>  
            </tr>
            <tr>
                  <td style="height:40px;">&nbsp;</td>
                  <td style="width:80px;">&nbsp;</td>
                  <td>&nbsp;</td>  
            </tr>
            <tr>
                  <td colspan="3" style="height:28px; text-align:center; font-size:20px;">Current Root</td> 
            </tr>
            <tr>
                  <td style="height:28px;">&nbsp;</td>
                  <td style="width:80px;">&nbsp;</td>
                  <td>&nbsp;</td>  
            </tr>
            
            <tr>
                  <td style="height:28px;">Root</td>
                  <td colspan="2"><input type="text" class="input_txt" id="r_name" style="width:100%" /></td>
            </tr>
            
            <tr>
                  <td style="height:28px;">Salesman</td>
                  <td colspan="2"><input type="text" class="input_active_num" name="id" id="id" style="width:100%" /></td> 
            </tr>
           
            <tr>
                  <td colspan="2">Pending request</td>
                  <td><input type="text" class="input_active_num" id="root_pending" style="width:100%" /></td>  
            </tr>
        </table>
        </fieldset>
        </td>
      </tr>
    </table>
    </form>
             <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
             <input type="hidden" name='by' value='t_settu_item_req' title="t_settu_item_req" class="report">
             <input type="hidden" name='page' value='A4' title="A4" >
             <input type="hidden" name='orientation' value='P' title="P" >
             <input type="hidden" name='type' value='' title="" >
             <input type="hidden" name='header' value='false' title="false" >
             <input type="hidden" name='qno' value='' title="" id="qno" >
             <input type="hidden" name='print_type' value='p' title="p" id="print_type" >
             <input type="hidden" name='org_print' value='' title="" id="org_print">
        
         </form>
    </div>
    </td>
    </tr>
</table>

<?php } ?>