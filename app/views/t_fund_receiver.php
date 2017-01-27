<?php if($this->user_permissions->is_view('t_fund_receiver')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_fund_receiver.js"></script>

<h2 style="text-align: center;">Fund Receiver</h2>
<div class="dframe" id="mframe" style="padding-right:25px; width: 900px;">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_fund_receiver" id="form_">
        <div id="tabs" >
         <ul>
            <li><a href="#tabs-1" >Cash</a></li>
            <li><a href="#tabs-2" >Cheque</a></li>
         </ul>
         <div id="tabs-1">
        <table style="width: 100%" border="0">
            <tr>
                <td style="width:150px;">From Branch</td>
                <td style="width:120px;">
                    <input type="text" class="input_active" readonly style="width:100%;" name="fr_branch" id="fr_branch" />
                    <input type="hidden" class="input_active" style="width:100%;" name="fr_cl" id="fr_cl" />
                </td>
                <td style="width:300px;" colspan="3"><input type="text" class="hid_value" readonly="readonly" style="width:100%;" name="fr_branch_des" id="fr_branch_des" /></td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:100px;">No</td>
                <td style="width:100px;">
                    <input type="text" class="input_active g_input_num"  style="width:100%;" name="id" id="id" title="<?=$id?>" />
                    <input type="hidden" name="hid" id="hid" title="0" >
                </td>
            </tr>
            <tr>
                <td style="width:150px;">Fund Transfer No</td>
                <td style="width:120px;"><input type="text" class="input_active hid_value" readonly="readonly" style="width:100%;" name="transfer_no" id="transfer_no" /></td>
                <td style="width:300px;" colspan="3"></td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:100px;">Date</td>
                <td style="width:100px;">
                 <?php if($this->user_permissions->is_back_date('t_fund_receiver')){ ?>    
                    <input type="text" class="input_date_down_future " readonly="readonly" style="width:100px; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                <?php }else{?>   
                    <input type="text" class="" readonly="readonly" style="width:100px; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                <?php }?> 
                </td>
            </tr>
            <tr>
                <td>Cash in Transit Account</td>
                <td><input type="text" class="input_active hid_value" readonly="readonly" style="width:100%;" name="tr_acc" id="tr_acc" title="" /></td>
                <td colspan="3"><input type="text" class="hid_value" readonly="readonly" style="width:100%;" name="tr_acc_des" id="tr_acc_des" title="" /></td>
                <td>&nbsp;</td>
                <td>Ref No</td>
                <td><input type="text" class="input_active" readonly="readonly" style="width:100%;" name="ref_no" id="ref_no" title="" /></td>
            </tr>
            <!-- <tr>
                <td>Cash Book</td>
                <td><input type="text" class="input_active" readonly="readonly" style="width:100%;" name="cash_bk" id="cash_bk" title="" /></td>
                <td colspan="3"><input type="text" class="hid_value" readonly="readonly" style="width:100%;" name="cash_bk_des" id="cash_bk_des" title="" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr> -->
            <tr>
                <td>Cashier</td>
                <td><input type="text" class="input_active hid_value" readonly="readonly" style="width:100%;" name="cashier_code" id="cashier_code" title="" /></td>
                <td colspan="3"><input type="text" class="hid_value" readonly="readonly" style="width:100%;" name="cashier_des" id="cashier_des" title="" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Hand Over To</td>
                <td><input type="text" class="input_active hid_value" readonly="readonly" style="width:100%;" name="hand_ot" id="hand_ot" title="" /></td>
                <td colspan="3"><input type="text" class="hid_value" readonly="readonly" style="width:100%;" name="hand_ot_des" id="hand_ot_des" title="" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Cash Amount</td>
                <td><input type="text" class="input_active g_input_amo hid_value" readonly="readonly" style="width:100%;" name="cash_amount" id="cash_amount" title="" /></td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Received by</td>
                <td><input type="text" class="input_active g_input_txt"  style="width:100%;" name="received_by" id="received_by" title="" /></td>
                <td colspan="3"><input type="text" class="hid_value" readonly="readonly" style="width:100%;" name="received_by_des" id="received_by_des" title="" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Note</td>
                <td colspan="4"><textarea id='note' name='note' cols="2" class="input_active g_input_txt" style="width:100%;" ></textarea></td>
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        </div>
        <div id="tabs-2">
        </div>
        <table style="width:100%;">
            <tr>
                <td style="text-align:right;">
                    <input type="button" id="btnExit" title='Exit' />
                    <input type="button" id="btnReset" title='Reset' />
                    <?php if($this->user_permissions->is_re_print('t_fund_receiver')){ ?><input type="button" id="btnPrint" title='Print'/><?php } ?>
                    <?php if($this->user_permissions->is_delete('t_fund_receiver')){ ?><input type="button" id="btnDelete" title='Cancel'/><?php } ?>
                    <?php if($this->user_permissions->is_add('t_fund_receiver')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                    <?php if($this->user_permissions->is_print('t_fund_receiver')){ ?> <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1"> <?php } ?> 
                    
                </td>
            </tr>
        </table>

    </form>

    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
                  
        <input type="hidden" name='by' value='t_internal_transfer' title="t_internal_transfer" class="report">
        <input type="hidden" name='page' value='A4' title="A4" >
        <input type="hidden" name='orientation' value='P' title="P" >
        <input type="hidden" name='type' value='t_internal_transfer' title="t_internal_transfer" >         
        <input type="hidden" name='pdf_id' value='' title="" id="pdf_id" >
        <input type="hidden" name='qno' value='' title="" id="qno" >
        <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
        <input type="hidden" name='dt' value='' title="" id="dt" > 
        <input type="hidden" name='p_type' value='' title="" id="p_type" > 
        <input type="hidden" name='sub_qno' value='' title="" id="sub_qno" > 
        <input type="hidden" name='org_print' value='' title="" id="org_print">
    </form>

</div>
</div>
<?php } ?>