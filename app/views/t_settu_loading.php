<?php if($this->user_permissions->is_view('t_settu_loading')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/t_settu_loading.js'></script>
<h2>Seettu Loading</h2>

<table width="100%" border="0">
    <tr>
        <td valign="top" class="content" style="width:500px;" >
        <div class="dframe" id="mframe" style="width:78%;">
        <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_settu_loading" >
            <table border="0" width="80%" >
                <tr>
                    <td style="width:80px;">Root</td>
                    <td style="width:80px;">
                        <input type="text" class="input_active" id="root_id" name="root_id" title="" style="width:80px;"/>
                        <input type="hidden" class="input_active" id="seettu_no" name="seettu_no" title="" style="width:80px;"/></td>
                    <td><input type="text" class="hid_value" id="root_name" title=""  readonly='readonly' style="width:250px;"/></td>
                    <td style="width:80px;">Driver</td>
                    <td style="width:80px;"><input type="text" class="input_active" id="driver_id" name="driver_id" title="" style="width:80px;"/></td>
                    <td style="width:80px;"><input type="text" class="hid_value" id="driver_name" title=""  readonly='readonly' style="width:250px;"/></td>
                    <td style="width:80px; text-align:right;">No</td>
                    <td style="width:80px;">
                        <input type="text" class="input_active_num" name="id" id="id" title="<?=$max_no?>"/>
                        <input type="hidden" id="hid" name="hid" title="0" />
                    </td>
                </tr>
                <tr>
                    <td>Store From</td>
                    <td>
                        <input type="text" class="input_active" id="store_from_id" name="store_from_id" title="" style="width:80px;" /></td><td>
                        <input type="text" class="hid_value" id="store_from_name" title=""  readonly='readonly' style="width:250px;"/>
                    </td>
                    <td>Salesman</td>
                    <td><input type="text" class="input_active" id="salesman_id" name="salesman_id" title="" style="width:80px;"/></td>
                    <td><input type="text" class="hid_value" id="salesman_name" title=""  readonly='readonly' style="width:250px;"/></td>
                    <td style="text-align:right;">date</td>
                    <td>
                    <?php if($this->user_permissions->is_back_date('t_settu_loading')){ ?>
                        <input type="text" style="text-align:right;" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php }else{ ?> 
                        <input type="text"  style="text-align:right;" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php } ?>  
                    </td>
                </tr>
                <tr>
                    <td>Store To</td>
                    <td>
                        <input type="text" class="input_active" id="store_to_id" name="store_to_id" title="" style="width:80px;"/></td><td>
                        <input type="text" class="hid_value" id="store_to_name" title=""  readonly='readonly' style="width:250px;"/>
                    </td>
                    <td>Helper</td>
                    <td><input type="text" class="input_active" id="helper_id" name="helper_id" title="" style="width:80px;"/></td>
                    <td><input type="text" class="hid_value" id="helper_name" title=""  readonly='readonly' style="width:250px;"/></td>
                    <td style="text-align:right;">Ref.No</td>
                    <td>
                     <input type="text" class="input_active_num" name="ref_no" id="ref_no"/>
                    </td>
                </tr>
                <tr>
                     <td colspan="8" style="text-align: center;">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="8" style="text-align: center;">
                        <table  id="tgrid1" >
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 40px;padding-left:10px;">OK</th>
                                <th class="tb_head_th" style="width: 150px;padding-left:10px;">Organizer</th>
                                <th class="tb_head_th" style="width: 60px;padding-left:10px;">Settu No</th>
                                <th class="tb_head_th" style="width: 60px;padding-left:10px;">Req No</th>
                                <th class="tb_head_th" style="width: 100px;padding-left:10px;">Req date</th>
                                <th class="tb_head_th" style="width: 60px;padding-left:10px;">Category</th>
                                <th class="tb_head_th" style="width: 100px;padding-left:10px;">Item</th>
                                <th class="tb_head_th" style="width: 150px;padding-left:10px;">Description</th>
                                <th class="tb_head_th" style="width: 200px;padding-left:10px;">Reason</th>
                            </tr>
                        </thead><tbody class="tb">
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td style='text-align:center; padding-left:10px;'>
                                              <input type='checkbox' name='check_".$x."' id='check_".$x."' class='chk' title='1'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='n_".$x."' name='n_".$x."' readonly='readonly' style='width:100%;'/>
                                        <input type='hidden' class='g_input_txt g_col_fixed' id='org_".$x."' name='org_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='1_".$x."' name='1_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='2_".$x."' name='2_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='3_".$x."' name='3_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='4_".$x."' name='4_".$x."' readonly='readonly'style='width:100%;'/>
                                        <input type='hidden' class='g_input_txt g_col_fixed' id='refno_".$x."' name='refno_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt' id='5_".$x."' name='5_".$x."' style='width:83px;'/>
                                        <input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: right; height:6px;width:6px;cursor:pointer width:100%;display:none;' />
                                        <input type='hidden'  class='g_input_num' id='itemdet_".$x."' name='itemdet_".$x."' style='width:100%;' /></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='6_".$x."' name='6_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt fo' id='7_".$x."' name='7_".$x."'style='width:100%;'/>
                                        <input type='hidden' class='g_input_txt g_col_fixed' id='reason_".$x."' name='reason_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table> 
                    </td>
                </tr>
                <tr>
                     <td colspan="8" style="text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td style="width:100px;">&nbsp;</td>
                     <td style="text-align: right;">Total Items</td>
                     <td> <input type="text" class="input_active" id="no_of_items" name="no_of_items" title="" style="width:80px;"/></td>
                     <td style="text-align: right;">Total Settu</td>
                     <td> <input type="text" class="input_active" id="no_of_settu" name="no_of_settu" title="" style="width:80px;"/></td>
                </tr>
                <tr>
                     <td></td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td colspan="2" style="text-align: right;">Selected Items</td>
                     <td ><input type="text" class="input_active" id="select_items" name="select_items" title="" style="width:80px;"/></td>
                     <td style="text-align: right; width:100px;">Selected Settu</td>
                     <td><input type="text" class="input_active" id="select_settu" name="select_settu" title="" style="width:80px;"/></td>
                </tr>
                <tr>
                     <td>Memo</td>
                     <td colspan="7"><input type="text" class="input_active" id="memo" name="memo" title="" style="width:510px;"/></td>
                     </tr>
            </table>
            <div style="text-align: left; padding-top: 7px;">
                        <input type="button" id="btnExit" title="Exit" />
                        <input type="button" id="btnReset" title="Reset" />
                        <?php if($this->user_permissions->is_delete('t_settu_loading')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
                        <?php if($this->user_permissions->is_re_print('t_settu_loading')){ ?><input type="button" id="btnPrint" title="Print" /> <?php } ?>                    
                        <?php if($this->user_permissions->is_add('t_settu_loading')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                    </div>
                </form>
    </div>
    </td>
    </tr>
    <?php 
        if($this->user_permissions->is_print('t_settu_loading')){ ?>
        <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
</table>
        <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
             <input type="hidden" name='by' value='t_settu_loading' title="t_settu_loading" class="report">
             <input type="hidden" name='page' value='A4' title="A4" >
             <input type="hidden" name='orientation' value='P' title="P" >
             <input type="hidden" name='type' value='' title="" >
             <input type="hidden" name='header' value='false' title="false" >
             <input type="hidden" name='qno' value='' title="" id="qno" >
             <input type="hidden" name='print_type' value='p' title="p" id="print_type" >
             <input type="hidden" name='org_print' value='' title="" id="org_print">
        
        </form>

<?php } ?>