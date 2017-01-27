<?php //if($this->user_permissions->is_view('002')){ ?>
<link rel="stylesheet" href="<?=base_url()?>css/report.css" />
<script type='text/javascript' src='<?=base_url()?>js/r_transaction_list_hp.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>
<h2>Hire Purchase Reports</h2> 
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
           <div class="dframe" id="r_view2" style="width: 1000px;">
            <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
                <fieldset>
                   <legend>Date</legend>
                   <table border="0">
                      <tr>
                         <td><font size="2">From</font></td>
                         <td style="padding-left:65px;"><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 100px;" /></td>
                         <td style="padding-left:30px;"><font size="2">To</font></td>
                         <td><input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 100px;"  /></td>
                     </tr>
                 </table>
             </fieldset>    
             <fieldset >
               <div id="report_view" style="overflow: auto;">
                <table border="0" cellpadding="0" cellspacing="0" id="cl_bc" style="font-size: 12px;">   
                   <tr>
                    <td style="width: 100px;">Customer</td>
                    <td>
                        <input type="text" class="input_active" id="cus_id" name="cus_id"title="" /></td><td>
                        <input type="text" class="hid_value" id="customer" name="customer" title="" style="width:300px;" readonly='readonly'/>
                    </td>
                    <td></td>  
                </tr>
                <tr>
                    <td style="width: 100px;">Area</td>
                    <td>
                        <input type="text" class="input_active" id="area_code" name="area_code"title="" /></td>
                        <td><input type="text" class="hid_value" id="area" name="area" title="" style="width:300px;" readonly='readonly'/>
                        </td>
                        <td></td>  
                    </tr>
                    <tr>
                        <td style="width: 100px;">Route</td>
                        <td>
                            <input type="text" class="input_active" id="route_id" name="route_id"title="" /></td>
                            <td><input type="text" class="hid_value" id="route_des" name="route_des" title="" style="width:300px;" readonly='readonly'/>
                            </td>
                            <td></td>  
                        </tr>
                        <tr>
                            <td style="width: 100px;">Agreement No</td>
                            <td>
                                <input type="text" class="input_active" id="agreemnt_no" name="agreemnt_no"title="" /></td><td>
                            </td>
                            <td></td>  
                        </tr>
             <!-- <tr>
                <td style="width: 100px;">Group Sales</td>
                <td>
                    <input type="text" class="input_active" id="group_sales_no" name="group_sales_no"title="" /></td><td>
                    <input type="text" class="hid_value" id="group_sale" title="" style="width:300px;" readonly='readonly'/>
                </td>
                <td></td>  
            </tr> -->
            <tr>
                <td style="width: 100px;">Guarantor</td>
                <td>
                    <input type="text" class="input_active" id="guarantor_id" name="guarantor_id"title="" /></td><td>
                    <input type="text" class="hid_value" id="guarantor" name="guarantor" title="" style="width:300px;" readonly='readonly'/>
                </td>
                <td></td>  
            </tr>
            <tr>
                <td style="width: 100px;">Salesman</td>
                <td>
                    <input type="text" class="input_active" id="salesman_id" name="salesman_id"title="" /></td><td>
                    <input type="text" class="hid_value" id="salesman"  name="salesman"title="" style="width:300px;" readonly='readonly'/>
                </td>
                <td></td>  
            </tr>
            <tr>
                <td style="width: 100px;">Collection-Officer</td>
                <td>
                    <input type="text" class="input_active" id="col_officer_id" name="col_officer_id"title="" /></td><td>
                    <input type="text" class="hid_value" id="col_officer" name="col_officer" title="" style="width:300px;" readonly='readonly'/>
                </td>
                <td></td>  
            </tr>
            <tr>
                <td style="width: 100px;">No of Installment</td>
                <td>
                    <input type="text" class="input_active" id="no_ins" name="no_ins"title="" style="width:100px;" />
                </td>
                <td></td>
                <td></td>  
            </tr>
            <tr> <td colspan="3"><hr/><td> </tr>
            <tr>
                <tr>
                   <?php if($this->user_permissions->is_view('r_hp_sales_summary')){ ?>
                   <td colspan="2"><input type='radio' name='by' value='r_hp_sales_summary' title="r_hp_sales_summary" class="report" /> Sales Summary All</td>	
                   <?php } ?>
                   <?php if($this->user_permissions->is_view('r_arrears_list')){ ?>
                   <td><input type='radio' name='by' value='r_arrears_list' title="r_arrears_list" class="report" /> Arrears List</td> 
                   <?php } ?>
                   <?php if($this->user_permissions->is_view('r_receipt_list_c')){ ?>
                   <td><input type='radio' name='by' value='r_receipt_list_c' title="r_receipt_list_c" class="report" /> Receipt List (Collection)</td> 
                   <?php } ?>
               </tr>				
               <tr>
                <?php if($this->user_permissions->is_view('r_hp_sales_details')){ ?>
                <td colspan="2"><input type='radio' name='by' value='r_hp_sales_details' title="r_hp_sales_details" class="report" /> Sales Details</td>
                <?php } ?>
                <?php if($this->user_permissions->is_view('r_default_interrest_sum')){ ?>
                <td><input type='radio' name='by' value='r_default_interrest_sum' title="r_default_interrest_sum" class="report"/> Default Interrest Summary</td> 
                <?php } ?>
	                <!--<?php if($this->user_permissions->is_view('r_receipt_list_c_o_w')){ ?>
	                 <td><input type='radio' name='by' value='r_receipt_list_c_o_w' title="r_receipt_list_c_o_w" class="report" /> Receipt List (Collection Officer Wise)</td> 
                    <?php } ?>-->
                    <?php if($this->user_permissions->is_view('r_downpayment_rec_list')){ ?>
                    <td><input type='radio' name='by' value='r_downpayment_rec_list' title="r_downpayment_rec_list" class="report" /> Downpayment Receipt List</td> 
                    <?php } ?>
                </tr>				
                <tr>
                    <?php if($this->user_permissions->is_view('r_hp_closed_accounts')){ ?>
                    <td colspan="2"><input type='radio' name='by' value='r_hp_closed_accounts' title="r_hp_closed_accounts" class="report" /> Closed Accounts</td>  
                    <?php } ?>
                    <?php if($this->user_permissions->is_view('r_arrears_letter_1')){ ?>
                    <td><input type='radio' name='by' value='r_arrears_letter_1' title="r_arrears_letter_1" class="report" /> Arrears Letter 1</td> 
                    <?php } ?>
                    <?php if($this->user_permissions->is_view('r_given_installment_arr')){ ?>
                    <td><input type='radio' name='by' value='r_given_installment_arr' title="r_given_installment_arr" class="report" /> Given Installment Arrears Report</td>                   
                    <?php } ?>
                    
                </tr>
                <tr>
                    <?php if($this->user_permissions->is_view('r_hp_other_charges_sum')){ ?>
                    <td colspan="2"><input type='radio' name='by' value='r_hp_other_charges_sum' title="r_hp_other_charges_sum" class="report" /> Other charges summary</td>
                    <?php } ?>
                    <?php if($this->user_permissions->is_view('r_arrears_letter_2')){ ?>
                    <td><input type='radio' name='by' value='r_arrears_letter_2' title="r_arrears_letter_2" class="report" /> Arrears Letter 2</td> 	                
                    <?php } ?>
                    <?php if($this->user_permissions->is_view('r_arrears_letter_2')){ ?>
                    <td><input type='radio' name='by' value='r_dd_installment_details' title="r_dd_installment_details" class="report" /> Daily Due Installment Details</td>                   
                    <?php } ?>

                    
                </tr>
                <tr>
                  
                  <!-- VIMUKTHI MODIFIED -->
                    <?php if($this->user_permissions->is_view('r_hp_return_summary')){ ?>
                    <td ><input type='radio' name='by' value='r_hp_return_summary' title="r_hp_return_summary" class="report" /> Return Summary</td>    
                    <?php } ?>
                </tr>
                <tr>
                    <?php if($this->user_permissions->is_view('r_hp_other_charges_details')){ ?>
                    <td colspan="2"><input type='radio' name='by' value='r_hp_other_charges_details' title="r_hp_other_charges_details" class="report" /> Other Charges Details</td>
                    <?php } ?>
                    <?php if($this->user_permissions->is_view('r_hp_due_summary')){ ?>
                    <td><input type='radio' name='by' value='r_hp_due_summary' title="r_hp_due_summary" class="report" /> Due Summary</td>
                    <?php } ?>
                    <td></td>    			    
                </tr>
                <tr>
                    <?php if($this->user_permissions->is_view('r_hp_total_outstanding')){ ?>
                    <td colspan="2"><input type='radio' name='by' value='r_hp_total_outstanding' title="r_hp_total_outstanding" class="report" /> Total Outstandings</td>
                    <?php } ?>
                    <?php if($this->user_permissions->is_view('r_hp_total_outstanding')){ ?>
                    <td colspan="2"><input type='radio' name='by' value='r_hp_total_outstanding_rep' title="r_hp_total_outstanding_rep" class="report" /> Total Outstanding Rep Wise</td>
                    <?php } ?>
                    


                    <td></td>    			    
                </tr> 
                <tr>
                    <?php if($this->user_permissions->is_view('r_hp_sales_summary_sm_wise')){ ?>
                    <td colspan="2"><input type='radio' name='by' value='r_hp_sales_summary_sm_wise' title="r_hp_sales_summary_sm_wise" class="report" /> Sales Summary Salesman Wise</td>
                    <?php } ?>
                    <td></td> 
                    <td></td>   			    
                </tr>   
                <tr>
                    <?php if($this->user_permissions->is_view('r_hp_sales_summary_new_acc')){ ?>
                    <td colspan="2"><span style="display:none" class="op_hp"><input type='radio' name='by' value='r_hp_sales_summary_new_acc' title="r_hp_sales_summary_new_acc" class="report_op_hp" /> Sales Summary - New Account</span></td>    
                    <?php } ?>
                    <td></td> 
                    <td></td>                   
                </tr> 
                <tr>
                    <?php if($this->user_permissions->is_view('r_opening_hp_sales_summary')){ ?>
                    <td colspan="2"><span style="display:none;" class="op_hp"><input type='radio' name='by' value='r_opening_hp_sales_summary' title="r_opening_hp_sales_summary" class="report_op_hp" /> Opening HP Sales Summary</span></td>    
                    <?php } ?>
                    <td></td> 
                    <td></td>                   
                </tr>   
            </table>

            <div style="text-align: right; margin-top:10px; padding-top: 7px;">
             <button id="btnReset">Reset</button>
             <input type="hidden" name="type" id="type"  title=""/>
             <input type="button" title="Exit" id="btnExit" value="Exit">
             <button id="btnprint">Print PDF</button></div>
             
             
             
         </fieldset>
         <input type="hidden" name='page' value='A4' title="A4" >
         <input type="hidden" name='orientation' value='P' title="P" >
         <input type="hidden" name='type' value='19' title="19" >
         <input type="hidden" name='header' value='false' title="false" >
         <input type="hidden" name='qno' value='' title="" id="qno" >
         <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
         <input type="hidden" name='dt' value='' title="" id="dt" >
     </div>
 </form>
</div>

</table>
