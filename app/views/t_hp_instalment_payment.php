<?php if($this->user_permissions->is_view('t_hp_instalment_payment')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_instalment_payment.js"></script>
<?php $this->load->view('t_payment_option.php'); ?>
<style type="text/css">
#paymnt_his {
	border-radius: 5px;
	padding: 5px 0px;
	background-color: rgba(7, 100, 107,.5);
}
#paymnt_his button {
	text-align: left;
	width: 270px;
}
#paymnt_his button::after {
	font-family: "MS Sans Serif";
	/*font-weight: bold;*/
	content: ">>";
	display: inline-block;
	text-align: right;
	/*left: -20px;*/
	float: right;
	position: relative;
}
</style>

<h2 style="text-align: center;">Instalment Payment</h2>
<div class="dframe" id="mframe" style="width: 1150px;"> 
  <!--  <form method="post" action="<?=base_url()?>index.php/main/save/t_hp_instalment_payment" id="form_">
  -->
  <table width="100%" border="0">
    <!-- table 1 -->
    <tr><!-- row1 -->
      <td><table>
          <tr>
            <td><fieldset>
                <legend>Agreement and Customer</legend>
                <table border="0"table width="850px;">
                  <tr>
                    <td>Agreement No.</td>
                    <td><input type='text' name='agreement_no' id='agreement_no' class='input_txt'/>
                      Multi Branch
                      <input type="checkbox" name="multi_branch" id="multi_branch" value="1"/></td>
                  </tr>
                  <tr>
                    <td>Customer</td>
                    <td><input id="customer" class="input_active bar" type="text" name="customer" title="">
                      <input id="customer_id" class="hid_value" type="text" style="width:250px;" readonly="readonly" title="">
                      &nbsp;&nbsp;&nbsp;
                      INV. No. &nbsp;&nbsp;&nbsp;
                      <input id="ins_id" name="ins_id" class="hid_value" type="text"style="width:150px;" readonly="readonly" title="">
                      Close Agr No &nbsp;
                      <input type="checkbox" id="closed_agr">
                      </td>
                  </tr>
                  <tr>
                    <td>Description</td>
                    <td><input id="description" class="input_active bar" type="text" name="description" title="" style="width:402px;">
                      &nbsp;&nbsp;&nbsp;Balance &nbsp;&nbsp;&nbsp;&nbsp;
                      <input id="tot_bal" name="tot_bal" class="hid_value" type="text"style="width:150px;" readonly="readonly" title="">
                      <input type="button" id="view_bal" title="Balance Breakup"></td>
                  </tr>
                </table>
              </fieldset></td>
            <td><fieldset>
                <legend>Receipt</legend>
                <table border="0" align="center">
                  <tr>
                    <td style="width: 150px;">No</td>
                    <td><input id="id" class="input_active_num" type="text" title="<?=$max?>" name="id">
                      <input id="hid" type="hidden" title="0" name="hid" value="0"></td>
                  </tr>
                  <tr>
                    <td style="width: 100px;">Date</td>
                    <td style="width: 100px;"><?php if($this->user_permissions->is_back_date('t_hp_instalment_payment')){ ?>
                      <input type="text" class="input_date_down_future " readonly="readonly" style="width:100%; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                      <?php }else{?>
                      <input type="text" class="" readonly="readonly" style="width:100%; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                      <?php }?></td>
                  </tr>
                  <tr>
                    <td style="width: 100px;">Ref. No</td>
                    <td style="width: 100px;"><input id="ref_no" class="input_txt" type="text" style="width: 100px;" title="" name="ref_no"></td>
                  </tr>
                </table>
              </fieldset></td>
          </tr>
        </table></td>
    </tr>
    <!-- row1 -->
    
    <tr><!-- row2 -->
      <td><table border="0">
            <tr>
          
          <td><fieldset style="width:300px;">
              <legend>Payments</legend>
              <table style="width:100%;margin-bottom:20px;margin-top:20px;" border="0">
                  <tr>
                
                <td><table style="padding-left:18px;">
                    <tr>
                      <td> Rebeat Amount</td>
                      <td style="padding-left:18px;"><input id="rebeat_tot" class="hid_value g_input_amo" type="text" style="width: 100px;border: 1px solid #003399;" title="" readonly="readonly" name="rebeat_tot">
                        <input id="rebeat_capital" type="hidden" name="rebeat_capital">
                        <input id="rebeat_interest" type="hidden" name="rebeat_interest">
                        <input id="rebeat_panelty" type="hidden" name="rebeat_panelty">
                        <input id="rebeat_other" type="hidden" name="rebeat_other"></td>
                    </tr>
                    <tr>
                      <td> Paid Amount</td>
                      <td style="padding-left:18px;"><input id="net" class="input_active g_input_amo" type="hidden" style="width: 100px;" title="" name="net">
                        <input id="net2" class="input_active g_input_amo tt" type="text" style="width: 100px;" title="" name="net2"></td>
                    </tr>
                      </tr>
                    
                  </table></td>
                  </tr>
                
              </table>
            </fieldset></td>

            <td><div id="ins" style="width:811px; height:130px; overflow-y:auto;"> </div></td>
          </tr>

          <tr>
            <td style="width:96px;" colspan="2">Collection Officer
              <input type="text" class="input_txt" name="officer" id="officer">
              <input type="text" class="hid_value" style="width:280px;" name="officer_des" id="officer_des"><div style="display:inline-block; float:right;">
              <input type="button" id="view_more" title="More >>>"/>
              <input type="button" id="btnReset" title="Reset"/>
              <?php if($this->user_permissions->is_delete('t_hp_instalment_payment')){ ?>
              <input type="button" id="btnDelete" title="Delete"/>
              <?php } ?>
              <?php if($this->user_permissions->is_re_print('t_hp_instalment_payment')){ ?>
              <input type="button" id="btnPrint" title="Print"/>
              <?php } ?>
              <input type="button" id="showPayments" title="Payment"/>
              <?php if($this->user_permissions->is_add('t_hp_instalment_payment')){ ?>
              <input type="button" id="btnSave" title="Save"/>
              <?php } ?>
              <input type='hidden' name='save_status' id="save_status"/>
              <input type="hidden" name="exceed_amount" id="exceed_amount"/>
              <?php 
                    if($this->user_permissions->is_print('t_hp_instalment_payment')){ ?>
              <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
            </div>
              <?php } ?></td>
          </tr>
        </table>
    <tr>
      <td><div id="paymnt_his" style="display:none;width:100%;" >
          <table style="width:100%; height:170px;">
            <tr>
              <td  style="width:25%;"><fieldset style="width:280px; height:180px;">
                  <legend>More..</legend>
                  <button id="pay_his" title="Payment Histry" onclick="return false;">Payment History</button>
                  <button id="fu_bal_ins" title="Future Balance Instalment" onclick="return false;">Future Balance Installment</button>
                  <button id="oth_chg_dt" title="Other Charges" onclick="return false;">Other Charges</button>
                  <button id="rebeat" title="Rebeat" onclick="return false;">Rebeat</button>
                  <button id="earl_setl" title="Early Setlement" onclick="return false;">Early Settlement</button>
                  <button id="agri_dt" title="Agriment Details" onclick="return false;">Agreement Details</button>
                  <button id="pay_his_rprt" title="Payment Histry Report" onclick="return false;">Payment History Report</button>
                </fieldset></td>
              <td style="width:75%"><fieldset style="width:810px; height:180px; overflow-y:scroll;" >
                  <legend id="tl_Nme"></legend>
                  <table style="width:100%;" border="0">
                    <tbody id="tbl_tbdy">
                    </tbody>
                  </table>
                </fieldset></td>
            </tr>
          </table>
        </div></td>
    </tr>
      </td>
    
      </tr>
    <!-- row2 -->
    
    <tr><!-- row3 -->
      <td></td>
    </tr>
    <!-- row3 -->
  </table>
  <!-- table1 -->
  </form>
  <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
    <input type="hidden" name='by' value='t_hp_instalment_payment' title="t_hp_instalment_payment" class="report">
    <input type="hidden" name='page' value='A4' title="A4" >
    <input type="hidden" name='orientation' value='P' title="P" >
    <input type="hidden" name='type' value='t_hp_installment' title="t_hp_installment" >
    <input type="hidden" name='header' value='false' title="false" >
    <input type="hidden" name='org_print' value='' id="org_print" >
    <input type="hidden" name='qno' value='' title="" id="qno" >
    <input type="hidden" name='tot' value='' title="" id="tot" >
  </form>
  <form id="print_pdf2" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
    <input type="hidden" name='by' value='t_hp_payment' title="t_hp_payment" class="report">
    <input type="hidden" name='page' value='A4' title="A4" >
    <input type="hidden" name='orientation' value='P' title="P" >
    <input type="hidden" name='type' value='t_hp_payment' title="t_hp_payment" >
    <input type="hidden" name='header' value='false' title="false" >
    <input type="hidden" name='org_print' value='' id="org_print" >
    <input type="hidden" name='qno1' value='' title="" id="qno1" >
    <input type="hidden" name='tot' value='' title="" id="tot" >
  </form>
</div>
<?php } ?>
