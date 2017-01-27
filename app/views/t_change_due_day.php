<?php //if($this->user_permissions->is_view('t_change_due_day')){ ?>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_change_due_day.js"></script>

<h2 style="text-align: center;">Change Due Day</h2>
<div class="dframe" id="mframe">
<form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_change_due_day" >
        <table style="width: 100%" border="0" class="tbl_agr_list">
            <tr>

                <td>Agreement No</td>
                <td><input type='text' name='agreement_no' id='agreement_no' class='input_txt'/></td>
                <td></td>
                <td>Date</td>
                <td><input type="text" name="date" id="date" title="<?=date('Y-m-d')?>"></td>

            </tr>

            <tr>

                <td>Customer</td>
                <td><input type="text" name="customer_id" id="customer_id"></td>
                <td><input type="text" name="customer_name" id="customer_name"></td>
                <td>No</td>
                <td><input type="text" name="no" id="no" title="<?=$max_no?>"></td>

            </tr>

            <tr>

                <td>Loan Date</td>
                <td><input type="text" name="loan_date" id="loan_date"></td>
                <td></td>
                <td>Last Changed Date</td>
                <td><input type="text" name="last_loan_c_date" id="last_loan_c_date"></td>

            </tr>

            <tr>

                <td>No of Inst</td>
                <td><input type="text" name="no_of_installments" id="no_of_installments"></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>

            <tr>

                <td>New Due Day</td>
                <td><input type="text" name="new_due_day" id="new_due_day" size="2" maxlength="2"></td>
                <td><input type="button" title="Preview" name="set_preview" id="set_preview"></td>
                <td></td>
                <td></td>

            </tr>

            <tr>
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>

                <td><b>Ins No</b></td>
                <td><b>Due Date</b></td>
                <td><b>New Due Date</b></td>
                <td></td>
                <td></td>

            </tr>


            <tfoot></tfoot>            
        </table>


        <table>
            <tr>
                <td colspan="5">
                    <div style="text-align: left; padding-top: 7px;">
                        <input type="button" id="btnExit" title="Exit" />
                        <input type="button" id="btn_Reset" title="Reset" />                        
                        <input type="button" id="btnPrint" title="Print" />                        
                        <input type="button"  id="btn_Save" title='Save <F8>'/>                              
                    </div>                
                </td>
                <?php if($this->user_permissions->is_print('t_hp_other_charges')){ ?>
                    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                <?php } ?> 

            </tr>
        </table>
    

    </form>

    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
       <input type="hidden" name='by' id='by' value='t_change_due_day' title="t_change_due_day" class="report">
       <input type="hidden" name='page' value='A4' title="A4" >
       <input type="hidden" name='orientation' value='P' title="P" >
       <input type="hidden" name='type' value='t_voucher' title="t_voucher" >
       <input type="hidden" name='recivied' value='' title=""  id='recivied'>
       <input type="hidden" name='header' value='false' title="false" >
       <input type="hidden" name='qno' value='' title="" id="qno">
    </form>



</div>
<?php //} ?>