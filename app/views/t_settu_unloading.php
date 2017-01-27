<?php if($this->user_permissions->is_view('t_settu_unloading')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/t_settu_unloading.js'></script>
<h2>Seettu Unloading</h2>

<table width="100%" border="0">
    <tr>
        <td valign="top" class="content" style="width:500px;" >
        <div class="dframe" id="mframe" style="width:73%; padding-left:25px;padding-right:25px;">
        <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_settu_unloading" >
            <table border="0" width="80%" >
                <tr>
                   <td style="width:100px;">Load No</td>
                   <td colspan="2">
                        <input type="text" class="input_active" id="load_id" name="load_id" title="" style="width:100px;"/></td>  
                    <td style="width:400px;">&nbsp;</td>
                    <td style="width:100px; text-align:left; padding-left:12px;">Unload No</td>
                    <td><input type="text" class="input_active_num" name="unlod_id" id="unlod_id" title="<?=$max_no?>"/>
                        <input type="hidden" id="hid" name="hid" title="0" /></td>

                </tr>
                <tr>
                    <td style="width:100px;">Root</td>
                    <td style="width:100px;">
                        <input type="text" class="input_active" id="root_id" name="root_id" title="" style="width:100px;"/></td>
                    <td><input type="text" class="hid_value" id="root_name" title=""  readonly='readonly' style="width:300px;"/></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="text-align:left; padding-left:12px;">Date</td>
                    <td>
                    <?php if($this->user_permissions->is_back_date('t_settu_loading')){ ?>
                        <input type="text" style="text-align:right;" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php }else{ ?> 
                        <input type="text"  style="text-align:right;" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php } ?>  
                    </td>

                   
                    
                </tr>
                <tr>
                    <td>Store From</td>
                    <td>
                        <input type="text" class="input_active" id="store_from_id" name="store_from_id" title="" style="width:100px;" /></td><td>
                        <input type="text" class="hid_value" id="store_from_name" title=""  readonly='readonly' style="width:300px;"/>
                    </td>
                    <td>&nbsp;</td>
                     <td style="text-align:left; padding-left:12px;">Ref.No</td>
                    <td>
                     <input type="text" class="input_active_num" name="ref_no" id="ref_no"/>
                    </td>
                </tr>
                <tr>
                    <td>Store To</td>
                    <td>
                        <input type="text" class="input_active" id="store_to_id" name="store_to_id" title="" style="width:100px;"/></td><td>
                        <input type="text" class="hid_value" id="store_to_name" title=""  readonly='readonly' style="width:300px;"/>
                    </td>
                    <td>&nbsp;</td>
                    <td style="width:100px;text-align:left; padding-left:12px;">No. of Seettu</td>
                    <td style="width:100px;">
                        <input type="text" class="input_active_num" name="settu_id" id="settu_id" title=""/>
                    </td>
                </tr>
                <tr>
                     <td colspan="6" style="text-align: center;">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="6" style="text-align: center;">
                        <table  id="tgrid1" >
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 50px;padding-left:10px;">OK</th>
                                <th class="tb_head_th" style="width: 150px;padding-left:10px;">Organizer</th>
                                <th class="tb_head_th" style="width: 100px;padding-left:10px;">Settu No</th>
                                <th class="tb_head_th" style="width: 100px;padding-left:10px;">Category</th>
                                <th class="tb_head_th" style="width: 100px;padding-left:10px;">Item</th>
                                <th class="tb_head_th" style="width: 250px;padding-left:10px;">Description</th>
                                
                            </tr>
                        </thead><tbody class="tb">
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td style=''>
                                              <input type='checkbox' name='check_".$x."' id='check_".$x."' title='1' style='margin-left:25px; '/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='n_".$x."' name='n_".$x."' readonly='readonly' style='width:100%;'/>
                                        <input type='hidden' class='g_input_txt g_col_fixed' id='org_".$x."' name='org_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='1_".$x."' name='1_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='4_".$x."' name='4_".$x."' readonly='readonly'style='width:100%;'/>
                                        <input type='hidden' class='g_input_txt g_col_fixed' id='refno_".$x."' name='refno_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='5_".$x."' name='5_".$x."' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='6_".$x."' name='6_".$x."' readonly='readonly'style='width:100%;'/></td>";
                                        
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table> 
                    </td>
                </tr>
                <tr>
                     <td colspan="6" style="text-align: center;">&nbsp;</td>
                </tr>
               
                <tr>
                     <td style="width:100px;">Memo</td>
                     <td colspan="5"><input type="text" class="input_active" id="memo" name="memo" title="" style="width:400px;"/></td>
                     </tr>
            </table>
                    <div style="text-align: left; padding-top: 7px;">
                        <input type="button" id="btnExit" title="Exit" />
                        <input type="button" id="btnReset" title="Reset" />
                        <?php if($this->user_permissions->is_delete('t_settu_unloading')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
                        <?php if($this->user_permissions->is_re_print('t_settu_unloading')){ ?><input type="button" id="btnPrint" title="Print" /> <?php } ?>                    
                        <?php if($this->user_permissions->is_add('t_settu_unloading')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                    </div>
    
    </form>
    </div>
    </td>
    </tr>
    <?php 
        if($this->user_permissions->is_print('t_settu_unloading')){ ?>
        <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
</table>
<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
             <input type="hidden" name='by' value='t_settu_unloading' title="t_settu_unloading" class="report">
             <input type="hidden" name='page' value='A4' title="A4" >
             <input type="hidden" name='orientation' value='P' title="P" >
             <input type="hidden" name='type' value='' title="" >
             <input type="hidden" name='header' value='false' title="false" >
             <input type="hidden" name='qno' value='' title="" id="qno" >
             <input type="hidden" name='print_type' value='p' title="p" id="print_type" >
             <input type="hidden" name='org_print' value='' title="" id="org_print">
        
        </form>

<?php } ?>