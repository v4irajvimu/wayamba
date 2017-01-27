<?php //if($this->user_permissions->is_view('t_guarantor_change')){ ?>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_guarantor_change.js"></script>

<h2 style="text-align: center;">Guarantor Change</h2>
<div class="dframe" id="mframe">
<form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_guarantor_change" >
        <table style="width: 100%" border="0">
            <tr>

                <td width="100">Agreement No</td>
                <td width="100"><input type='text' name='agreement_no' id='agreement_no' class='input_txt'/></td>
                <td></td>
                <td>Date</td>
                <td><input type="text" name="date" id="date" title="<?=date('Y-m-d')?>" class='input_txt' style='width:74px' readonly="readonly"></td>

            </tr>

            <tr>
                <td>Customer</td>
                <td><input type="text" name="customer_id"   id="customer_id" class='input_txt'></td>
                <td><input type="text" name="customer_name" id="customer_name" class='input_txt' style='width:400px'></td>
                <td></td>
                <td><input type="hidden" name="no" id="no" title="<?=$max_no?>"></td>
            </tr>                                              

            <tr>
                <td>Address</td>
                <td colspan="2"><textarea  name="address" id="address" class='input_txt' style='width:554px'  readonly="readonly"></textarea></td>
                
                <td></td>
                <td></td>
            </tr>                      


            <tr>
                <td>New Guarantor 1</td>
                <td><input type="text" name="new_g1" id="new_g1" class='input_txt' class='input_txt'></td>
                <td><input type="text" name="new_gn1" id="new_gn1" class='input_txt' class='input_txt' style='width:400px' readonly="readonly"></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>New Guarantor 2</td>
                <td><input type="text" name="new_g2" id="new_g2" class='input_txt'></td>
                <td><input type="text" name="new_gn2" id="new_gn2" class='input_txt' style='width:400px' readonly="readonly"></td>
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

        </table>

        <table  class="tbl_agr_list">
            <tr>
                <td><b>Date</b></td>
                <td><b>Guarantor 1</b></td>
                <td><b>Guarantor 2</b></td>
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
    
        <input type="hidden" name="g1_h" id="g1_h">
        <input type="hidden" name="g2_h" id="g2_h">

    </form>

    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
       <input type="hidden" name='by' id='by' value='t_guarantor_change' title="t_guarantor_change" class="report">
       <input type="hidden" name='page' value='A4' title="A4" >
       <input type="hidden" name='orientation' value='P' title="P" >
       <input type="hidden" name='type' value='t_voucher' title="t_voucher" >
       <input type="hidden" name='recivied' value='' title=""  id='recivied'>
       <input type="hidden" name='header' value='false' title="false" >
       <input type="hidden" name='qno' value='' title="" id="qno">
    </form>



</div>
<?php //} ?>