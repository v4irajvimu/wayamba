<?php if($this->user_permissions->is_view('t_hp_receipt')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_receipt.js"></script>


<h2 style="text-align: center;">HP Receipt</h2>
<div class="dframe" id="mframe">
    
    <form method="post" action="<?=base_url()?>index.php/main/save/t_hp_receipt" id="form_">

        <table border=0>
            <tr>
                <td valign=top width="750">
                    <fieldset>
                        <legend>Agreement Details</legend>

                        <table> 
                            <tr>
                                <td>Customer</td>
                                <td><input type="text" name="code" id="code" mod_code="customer"> <input type="text" name="name" id="name"></td>
                            </tr>
                            <tr>
                                <td>Agreement No</td>
                                <td><input type="text" name="agreement_no" id="agreement_no" mod_code="Agreement No"> <input type="text" name="" id=""></td>
                            </tr>
                            <tr>
                                <td valign="top">Item Details</td>
                                <td><textarea name="" id="" style="width:300px"></textarea></td>
                            </tr>
                            <tr>
                                <td>Total Balance</td>
                                <td><input type="text" name="" id=""></td>
                            </tr>
                        </table>

                    </fieldset>

                    <br>                    
                    
                    <table border=0> 
                        <tr>
                            <td>&nbsp;</td>
                            <td>Balance</td>
                            <td>Paid Amount</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Instalment</td>
                            <td><input type="text" name="" id=""></td>
                            <td><input type="text" name="" id=""></td>
                            <td> <a href="#" class="load_popup" data="instalment">View Details</a></td>
                        </tr>
                        <tr>
                            <td>Default Interest</td>
                            <td><input type="text" name="" id=""></td>
                            <td><input type="text" name="" id=""></td>
                            <td> <a href="#" class="load_popup" data="Def_interest">View Details</a></td>                            
                        </tr>
                        <tr>
                            <td>Other Charges</td>
                            <td><input type="text" name="" id=""></td>
                            <td><input type="text" name="" id=""></td>
                            <td> <a href="#" class="load_popup" data="other_charges">View Details</a></td>                            
                        </tr>
                        
                        <tr>                            
                            <td height=15></td>
                            <td colspan="3"></td>
                        </tr>

                        <tr>                            
                            <td>Salesman</td>
                            <td colspan="3"><input type="text" name="" id=""> <input type="text" name="" id=""></td>
                        </tr>

                        <tr>                            
                            <td>Collection Officer</td>
                            <td colspan="3"><input type="text" name="" id=""> <input type="text" name="" id=""></td>
                        </tr>

                        <tr>                            
                            <td height=15></td>
                            <td colspan="3"></td>
                        </tr>

                        <tr>                            
                            <td>&nbsp;</td>
                            <td colspan="3"><input type="button" title="Payment Options" name="" id="" style="width:300px;"></td>
                        </tr>

                    </table>

                    

                </td>
                <td valign="top">
                    <table border=0 width="150" align=right>
                        <tr>
                            <td>Date</td>
                            <td><input type="text" name="date" id="date" size="10"></td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td><input type="text" name="No" id="No" size="10"></td>
                        </tr>
                        <tr>
                            <td>Ref No</td>
                            <td><input type="text" name="refno" id="refno" size="10"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    
        <div style="text-align: left; padding-top: 50px;">
            <input type="button" id="btnExit" title="Exit" />
            <input type="button" id="btnReset" title="Reset" />
            <?php if($this->user_permissions->is_delete('t_hp_receipt')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?>
            <?php if($this->user_permissions->is_re_print('t_hp_receipt')){ ?><input type="button" id="btnPrint" title="Print" />   <?php } ?>        
            <?php if($this->user_permissions->is_add('t_hp_receipt')){ ?><input type="button"  id="btnSave" title="Save" />  <?php } ?>         
        </div>

 <?php 
    if($this->user_permissions->is_print('t_hp_receipt')){ ?>
       <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
                
    </form>


    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

        <input type="hidden" name='by' value='t_po_sum' title="t_po_sum" class="report">
        <input type="hidden" name='page' value='A4' title="A4" >
        <input type="hidden" name='orientation' value='P' title="P" >
        <input type="hidden" name='type' value='purchase_quotation' title="purchase_quotation" >
        <input type="hidden" name='header' value='false' title="false" >
        <input type="hidden" name='qno' value='' title="" id="qno" >
        <input type="hidden" name='rep_sup' value='' title="" id="rep_sup" >
        <input type="hidden" name='rep_ship_bc' value='' title="" id="rep_ship_bc" >
        <input type="hidden" name='rep_date' value='' title="" id="rep_date" >
        <input type="hidden" name='rep_deliver_date' value='' title="" id="rep_deliver_date" >

    </form>

</div>
<?php } ?>