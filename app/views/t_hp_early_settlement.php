<?php if($this->user_permissions->is_view('t_hp_early_settlement')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_early_settlement.js"></script>
<?php $this->load->view('t_payment_option.php'); ?>
<h2 style="text-align: center;">Early Settlement</h2>
<div class="dframe" id="mframe" style="width: 1150px;">
<!--  <form method="post" action="<?=base_url()?>index.php/main/save/t_hp_early_settlement" id="form_">
--><table width="100%" border="0"> <!-- table 1 -->
<tr><!-- row1 -->
  <td>
    <table>
      <tr>
        <td>
          <fieldset>
            <legend>Agreement and Customer</legend>
            <table border="0"table width="850px;">
              <tr>
                <td>Customer</td>
                <td> 
                  <input id="customer" class="input_active bar" type="text" name="customer" title="">
                  <input id="customer_id" class="hid_value" type="text" style="width:250px;" readonly="readonly" title="">&nbsp;&nbsp;&nbsp;
                </td>
              </tr> 

              <tr>
                <td>Address</td>
                <td>
                  <input id="cus_address" class="input_active" type="text" name="cus_address" title="" style="width:402px;">
                </td>
              </tr>

              <tr>
                <td>Agreement No.</td>
                <td> 
                  <input type='text' name='agreement_no' id='agreement_no' class='input_txt'/>
                  Inv No <input type='text' name='inv_no' id='inv_no' class='input_active_num'/>
                </td>
                
                
              </tr>
            </table>
          </fieldset>           
        </td>

        <td>
          <fieldset>
            <legend>Receipt</legend>
            <table border="0" align="center">
              <tr>
               <td style="width: 150px;">No</td>
               <td>
                <input id="id" class="input_active_num" type="text" title="<?=$max?>" name="id">
                <input id="hid" type="hidden" title="0" name="hid" value="0">
              </td>
            </tr>

            <tr>
              <td style="width: 100px;">Date</td>
              <td style="width: 100px;">
                <?php if($this->user_permissions->is_back_date('t_hp_early_settlement')){ ?>    
                <input type="text" class="input_date_down_future " readonly="readonly" style="width:100%; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                <?php }else{?>   
                <input type="text" class="" readonly="readonly" style="width:100%; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                <?php }?>
              </td>
            </tr>
            <tr>
              <td style="width: 100px;">Ref. No</td>
              <td style="width: 100px;">
                <input id="ref_no" class="input_txt" type="text" style="width: 100px;" title="" name="ref_no">
                <input type="hidden" class="input_txt" name="reb_no" id="reb_no">
              </td>
            </tr>
          </table> 
        </fieldset>
      </td>
    </tr>
  </table>
</td>
</tr><!-- row1 -->

<tr>
  <td>
    <fieldset style="">
      <legend>Installment Details</legend>
      <table>
        <tr>
          <td>Loan Amount</td>
          <td><input type="text" class="input_active g_input_amo" name="loan_amo" id="loan_amo"></td>

          <td>Down Payment</td>
          <td><input type="text" class="input_active g_input_amo" name="dwn_amo" id="dwn_amo"></td>

          <td>No of Installments</td>
          <td><input type="text" class="input_active g_input_num" name="no_ins" id="no_ins"></td>

          <td>Installment Amount</td>
          <td><input type="text" class="input_active g_input_amo" name="ins_amo" id="ins_amo"></td>

          <td>Interest Amount</td>
          <td><input type="text" class="input_active g_input_amo" name="int_amo" id="int_amo"></td>
        </tr>
      </table>
    </fieldset>
  </td>
</tr>

<tr><!-- row2 -->
  <td>
   <table>
     <tr>
       <td>
        <fieldset style="width:300px;">
          <legend>Payments</legend>
          <table style="width:100%;margin-bottom:20px;margin-top:20px;">
            <tr>
              <td>
                <table style="padding-left:18px;">
                  <tr>
                    <td> Rebeat Amount</td>
                    <td style="padding-left:18px;">
                      <input id="rebeat_tot" class="hid_value g_input_amo" type="text" style="width: 100px;border: 1px solid #003399;" title="" readonly="readonly" name="rebeat_tot">
                      <input id="rebeat_capital" type="hidden" name="rebeat_capital">
                      <input id="rebeat_interest" type="hidden" name="rebeat_interest">
                      <input id="rebeat_panelty" type="hidden" name="rebeat_panelty">
                      <input id="rebeat_other" type="hidden" name="rebeat_other">
                    </td>              
                  </tr>
                  <tr>
                    <td>Advance Amount</td>
                    <td style="padding-left:18px;">
                      <input type="text" class='hid_value g_input_amo' id='advance_amo' name ='advance_amo' style="width: 100px;border: 1px solid #003399;" title="" readonly="readonly">
                    </td>
                  </tr>
                  <tr>
                    <td> Paid Amount</td>
                    <td style="padding-left:18px;">  
                      <input id="net" readonly="readonly" class="hid_value g_input_amo" type="hidden" style="width: 100px;" title="" name="net">
                      <input id="net2" readonly="readonly" class="hid_value g_input_amo tt" type="text" style="width: 100px;border: 1px solid #003399;" title="" name="net2">
                    </td>              
                  </tr>
                </tr>
              </table>
            </td>

          </tr>
          
        </table>
      </fieldset>
    </td>
    <td>
      
    </td>
    <td>
      <div id="ins" style="width:811px;"> 
      </div>
    </td>
  </tr>
</table>
<table border="0">
  <tr>
    <td style="width:96px;">Collection Officer</td>
    <td style="width:440px;">
      <input type="text" class="input_txt" name="officer" id="officer">
      <input type="text" class="hid_value" style="width:280px;" name="officer_des" id="officer_des">
    </td>
    <td colspan='2' style="text-align:right;">
                <!-- <input type="button" id="pay_his" title="Payment Histry"/>
                <input type="button" id="pay_his_rprt" title="Payment Histry Report"/> -->
                <input type="button" id="btnReset" title="Reset"/>
                <?php if($this->user_permissions->is_delete('t_hp_early_settlement')){ ?><input type="button" id="btnDelete" title="Delete"/><?php } ?>
                <?php if($this->user_permissions->is_re_print('t_hp_early_settlement')){ ?><input type="button" id="btnPrint" title="Print"/><?php } ?>
                <input type="button" id="showPayments" title="Payment"/>
                <?php if($this->user_permissions->is_add('t_hp_early_settlement')){ ?><input type="button" id="btnSave" title="Save"/><?php } ?> 
                <input type='hidden' name='save_status' id="save_status"/>
                <input type="hidden" name="exceed_amount" id="exceed_amount"/>
                <?php 
                if($this->user_permissions->is_print('t_hp_early_settlement')){ ?>
                <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                <?php } ?> 
              </td>
            </tr>
            <td colspan="2">
              <fieldset style="width:95%;" id="paymnt_his">
                <legend>Payments History</legend>
                <table style="width:100%;margin-bottom:20px;margin-top:20px;" border="0">
                  <tr>
                    <td>Reciept Date</td>
                    <td>Reciept No</td>
                    <td>Reciept Amount</td>                 
                  </tr>
                  <tbody id="tbl_tbdy">
                    
                  </tbody>
                </table>
              </fieldset>
            </td>

          </table>
        </td>

      </tr><!-- row2 -->

      <tr><!-- row3 -->
        <td>
          
        </td>
      </tr><!-- row3 -->
    </table><!-- table1 -->
  </form>

  <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
   <input type="hidden" name='by' value='t_hp_early_settlement' title="t_hp_early_settlement" class="report">
   <input type="hidden" name='page' value='A4' title="A4" >
   <input type="hidden" name='orientation' value='P' title="P" >
   <input type="hidden" name='type' value='t_hp_early_settlement' title="t_hp_early_settlement" >
   <input type="hidden" name='header' value='false' title="false" >
   <input type="hidden" name='org_print' value='' id="org_print" >
   <input type="hidden" name='qno' value='' title="" id="qno" >
   <input type="hidden" name='tot' value='' title="" id="tot" >
 </form>

</div>
<?php } ?>