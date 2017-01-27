<?php if($this->user_permissions->is_view('t_settu_invoice')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/t_settu_invoice.js'></script>
<h2>Seettu Invoice</h2>
<table width="100%"> 
    <tr>
        <td>
            <div class="dframe" id="mframe" style="padding-left:25px;padding-right:25px; width:1200px;">
                <form id="form_" method="post" action="<?= base_url() ?>index.php/main/save/t_settu_invoice" >
                    <table border="0" id="r_group_sb" width="100%">
                        <tr>
                            <td width="70px;">Vehicle</td>
                            <td width="80px;"><input type="text" class="input_txt" title='' id="seettu_vehicle" name="seettu_vehicle" style="width:100px;" readonly="readonly" /></td>
                            <td colspan="2" width="100px;"><input type="text" class="hid_value" title='' id="seettu_vehicle_name" name="seettu_vehicle_name" style="width:300;" maxlength="100"/> </td>
                            <td ><input type="button"  id="btnseettu_vehicle" name="btnseettu_vehicle" title="..." style="width:40px; margin-right:30px;"/></td>
                            <td width="70px;">Driver</td>
                            <td width="80px;"><input type="text" class="input_txt" name="driver_id" id="driver_id" title="" style="width:100px;" readonly="readonly"/></td>
                            <td colspan="2"><input type="text" class="hid_value" title='' id="driver_name" name="driver_name" style="width:300;" maxlength="100"/></td>                            
                            <td width="70px;">No</td>
                            <td style="width: 80px;"><input type="text" class="input_active_num" name="id_no" id="id_no" style="width:100px;" title="<?=$max_no?>" /><input type="hidden" id="hid" name="hid" title="0" /></td>
                        </tr>

                        <tr>
                            <td>Salesman</td>
                            <td><input type="text" class="input_txt" name="salesman_id" id="salesman_id" title="" style="width:100px;" readonly="readonly"/></td>
                            <td colspan="2"><input type="text" class="hid_value" title='' id="salesman_name" name="salesman_name" style="width:100%;" maxlength="100"/></td>
                            <td></td>
                            <td>Route</td>
                            <td><input type="text" class="input_txt" name="route_id" id="route_id" title="" style="width:100px;" readonly="readonly"/></td>
                            <td colspan="2"><input type="text" class="hid_value" title='' id="route_name" name="route_name" style="width:100%;" maxlength="100"/></td>
                            <td>Date</td>
                            <td><input type="text" class="input_date_down_future" readonly="readonly" style="width:100px; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" /></td>
                        </tr> 

                        <tr>
                            <td>Seettu No</td>
                            <td><input type="text" class="input_txt" name="seettu_no" id="seettu_no" title="" style="width:100px;" readonly="readonly"/></td>
                            <td style=" text-align:right;">Book No</td>
                            <td><input type="text" class="hid_value" name="book_no" id="book_no" title="" style="width:100%;" /></td>
                            <td></td>
                            <td>Organizer</td>
                            <td><input type="text" class="input_txt" name="organizer" id="organizer" title="" style="width:100px;" /></td>
                            <td colspan="2"><input type="text" class="hid_value" title='' id="organizer_name" name="organizer_name" style="width:100%;" maxlength="100"/></td>
                            <td>Ref. No</td>
                            <td><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width:100px;text-align:right;" /></td>
                        </tr> 

                        <tr>        
                            <td>Item</td>
                            <td><input type="text" class="input_txt" name="seettu_item" id="seettu_item" title="" style="width:100px;" readonly="readonly" />
                                <input type="hidden" class="input_txt" name="no_of_ins" id="no_of_ins" title="" style="width:100px;" readonly="readonly" /></td>
                            <td colspan="2">
                                <input type="text" class="hid_value" title='' id="item_name" name="item_name" style="width:100%;" maxlength="100"/> 
                            </td>
                            <td></td>
                            <td>C. Officer</td>
                            <td><input type="text" class="input_txt" name="c_officer_id" id="c_officer_id" title="" style="width:100px;" /></td>
                            <td colspan="2"><input type="text" class="hid_value" title='' id="c_officer" name="c_officer" style="width:100%;" maxlength="100"/></td>
                            <td>Card No</td>
                            <td><input type="text" class="input_txt" name="card_no" id="card_no" title="" style="width:100%;text-align:right;" /></td>
                        </tr> 
                        <tr>
                            <td>Price</td>
                            <td><input type="text" class="hid_value" name="price" id="price" title="" style="width:100px; text-align:right;" /></td>
                            <td></td>
                            <td style=" width:195px; text-align:right;">Amount&nbsp;<input type="text" class="hid_value" name="amount" id="amount" title="" style="width:100px; text-align:right;" /></td>
                            <td></td>
                            <td>Note</td>
                            <td colspan="3"> <input type="text" class="input_txt" title="" id="note" name="note" style="width:100%;" maxlength="100"/></td>
                            <td>Reciept No</td>
                            <td><input type="text" class="input_txt" name="reciept_no" id="reciept_no" title="" style="width:100px; text-align:right;" /></td>
                        </tr>
                        <tr>
                            <td>Paid</td>
                            <td><input type="text" class="input_txt g_input_amo" name="paid" id="paid" title="" style="width:100px; text-align:right;" /></td>
                            <td  style="text-align:right;"></td>
                            <td style=" width:195px; text-align:right;">Additional&nbsp;<input type="text" class="input_txt g_input_amo" name="additional" id="additional" title="" style="width:100px; text-align:right;" /></td>
                            <td></td>
                            <td></td>
                            <td colspan="3"> </td>
                            <td></td>
                            <td></td>
                        </tr>  

                        <tr>
                            <td colspan="11">&nbsp;</td>
                        </tr>   
                        </form>                    
                        <table>
                            <table style="width:100%" id="tgrid" border="0" class="tbl">
                                <thead>
                                    <tr>
                                        <th class="tb_head_th" style="width: 40px;">Seettu No</th>
                                        <th class="tb_head_th" style='width: 40px;'>Organizer</th>
                                        <th class="tb_head_th" style="width: 40px;">No of Ins</th>
                                        <th class="tb_head_th" style="width: 120px;">Item</th>
                                        <th class="tb_head_th" style="width: 40px;">Price</th>
                                        <th class="tb_head_th" style="width: 40px;">Inst Amount</th>
                                        <th class="tb_head_th" style="width: 40px;">Add Charge</th>
                                        <th class="tb_head_th" style="width: 40px;">Paid</th>
                                        <th class="tb_head_th" style="width: 30px;">Cancel</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_tbdy">
                                
                                </tbody>
                                </table>

                                
                                <table>
                                    <td colspan="7"><br/>
                                        <input type="button" id="btnExit" title="Exit" />
                                        <input type="button" id="btnResett" title="Reset" />
                                        <?php if($this->user_permissions->is_delete('t_settu_invoice')){ ?><input type="button" id="btnCancel" title="Cancel" /><?php } ?> 
                                        <?php if($this->user_permissions->is_delete('t_settu_invoice')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?>
                                        <input type="button" title='Save <F8>' id="btnSave"/>   
                                    </td>
                                    
                                </tr>
                                </table>
                            </table>
                    
            </div>
        </td>
    </tr>
</table>
<?php } ?>