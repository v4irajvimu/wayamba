<?php if($this->user_permissions->is_view('t_delevery_note')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_delevery_note.js"></script>
<h2 style="text-align: center;">Delevery Note</h2>

<div class="dframe" id="mframe" style="width:1100px;padding-right:25px;">
 <form method="post" action="<?=base_url()?>index.php/main/save/t_delevery_note" id="form_">
    <table style="width: 100%" border="0" cellpadding="0">
        <tr>
            <td style="width:100">Customer</td>
            <td style="width:100"><input type="text" class="input_txt" id="customer" title="" name="customer"></td>
            <td colspan="3"><input type="text" class="hid_value" id="customer_id" readonly="readonly" style="width:407px;"/></td>
            <td style="width:100">&nbsp;</td>    
            <td style="width:50">No</td>
            <td>
                <input type="text" class="input_active_num" name="id" id="id" title="<?=$max_no?>"  style="width:100px;"/>
                <input type="hidden" id="hid" name="hid" title="0" />
                <input type='hidden' name='save_status' id="save_status"/>
            </td>
        </tr>

        <tr>
            <td>Address</td>
            <td colspan="4"><input type="text" class="hid_value" name="Address" id="Address" readonly='readonly' style="width:560px;" title=""/></td>
            <td>&nbsp;</td>
            <td>Date</td>
            <td>
                <?php if($this->user_permissions->is_back_date('t_delevery_note')){ ?>
                <input type="text" class="input_date_down_future" readonly="readonly" style="width:100px;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                <?php }else{ ?>
                <input type="text" class="" style="width:100px;" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                <?php } ?>    
            </td>
        </tr>
        <tr>
            <td>Note</td>
            <td colspan="4">
             <input type="text" class="input_txt" id="memo" name="memo" title=""  style="width:560px;"/></td>
             <td>&nbsp;</td>
             <td style="width: 100px;">Ref No</td>
             <td><input type="text" class="input_number" name="ref_no" id="ref_no" title="" style="width:100px;"/></td>
         </tr>

         <tr>
            <td colspan="8" style="text-align: center;">
                <table style="width: 100%;" id="tgrid">
                    <thead>
                        <tr>
                            <th class="tb_head_th" style="width:50px;" >Inv Type</th>
                            <th class="tb_head_th" style="width:50px;" >Inv Date</th>
                            <th class="tb_head_th" style="width:50px;">Inv No</th>
                            <th class="tb_head_th" style="width:80px;">Item Id</th>
                            <th class="tb_head_th" style="width:200px;">Item Name</th>  
                            <th class="tb_head_th" style="width:60px;">Balance</th>             
                            <th class="tb_head_th" style="width:60px;">Qty</th>
                            <th class="tb_head_th" style="width:60px;">Deleverd Qty</th>
                        </tr>
                    </thead><tbody>
                    <?php
                    for($x=0; $x<25; $x++){
                        echo "<tr>";
                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='0_".$x."' name='0_".$x."' style='width : 100%;' readonly/>
                        <input type='hidden' class='g_input_txt g_col_fixed' id='invtype_".$x."' name='invtype_".$x."' style='width : 100%;' readonly/></td>";
                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='n_".$x."' name='n_".$x."' style='width : 100%;' readonly/></td>";
                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='1_".$x."' name='1_".$x."' style='width : 100%;' readonly/></td>";
                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='2_".$x."' name='2_".$x."' style='width : 100%;' readonly/></td>";
                        echo "<td><input type='text' class='g_input_txt g_col_fixed' id='3_".$x."'  style='width : 100%;' readonly/></td>";
                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='4_".$x."' name='4_".$x."' style='width : 100%;' readonly/></td>";
                        echo "<td><input type='text' class='g_input_num qty' id='5_".$x."' name='5_".$x."' style='width : 100%;' /></td>";
                        echo "<td><input type='text' class='g_input_num g_col_fixed' id='6_".$x."' name='6_".$x."' style='width : 100%;' readonly/></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="background:#e6eeff;">
        <td colspan='6' style="text-align: right;"><b>Total&nbsp;&nbsp;</b></td>
        <td style="width: 100px"><input type='text' class="g_input_amounts" readonly="readonly" id='tot_qty' name='tot_qty' style='width : 100%;background:#e6eeff;' /></td>
        <td style="width: 100px"><input type='text' class="g_input_amounts" readonly="readonly" id='tot_del_qty' name='tot_del_qty' style='width : 100%;background:#e6eeff' /></td>
        </tr>
        <tr>
            <td>Vehicle No</td>
            <td><input type="text" class="input_txt" id="vehicle_no" title="" name="vehicle_no"></td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Driver</td>
            <td><input type="text" class="input_txt g_col_fixed" id="driver_id" title="" name="driver_id"></td>
            <td colspan="3"><input type="text" class="hid_value" id="driver" readonly="readonly" style="width:407px;"/></td>
            <td colspan="4">&nbsp;</td>    
            
        </tr>
        <tr>
            <td>Helper</td>
            <td><input type="text" class="input_txt g_col_fixed" id="helper_id" title="" name="helper_id"></td>
            <td colspan="3"><input type="text" class="hid_value" id="helper" readonly="readonly" style="width:407px;"/></td>
            <td colspan="4">&nbsp;</td>    
            
        </tr>
        <tr>
             <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
         <td colspan="9" rowspan="2" style="text-align: right;">
            <input type="button" id="btnExit" title="Exit" />
            <input type="button" id="btnResett" title="Reset" />
            <?php if($this->user_permissions->is_re_print('t_delevery_note')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
            <?php if($this->user_permissions->is_delete('t_delevery_note')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
            <?php if($this->user_permissions->is_add('t_delevery_note')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
        </td>

    </tr>

</table>

<?php 
if($this->user_permissions->is_print('t_delevery_note')){ ?>
<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
</div>    
</form>
<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
 <input type="hidden" name='by' value='t_delevery_note' title="t_delevery_note" class="report">
 <input type="hidden" name='page' value='A4' title="A4" >
 <input type="hidden" name='orientation' value='P' title="P" >
 <input type="hidden" name='type' value='t_delevery_note' title="t_delevery_note" >
 <input type="hidden" name='header' value='false' title="false" >
 <input type="hidden" name='qno' id="qno" >
 <input type="hidden" name='org_print' value='' title="" id="org_print">
</form>

<div id="light" class="white_content">
    <div id='install_payment_det' style='margin:10px'>
    </div>
    <input type='button' value='close' title='close' id='popclose' style="position:absolute;bottom:5px;right:5px;"/>
</div>
<div id="fade" class="black_overlay"></div>


<div id="light3" class="white_content">
    <div id='penalty_payment_det' style='margin:10px'>
    </div>
    <input type='button' value='close' title='close' id='popclose2' style="position:absolute;bottom:5px;right:5px;"/>
</div>

<?php } ?>
