<?php //if($this->user_permissions->is_view('r_account_report')){ ?>
<h2 style="text-align: center;">Bank Entry List Report </h2>
<link rel="stylesheet" href="<?=base_url()?>css/report.css" />
<script type="text/javascript" src="<?=base_url()?>js/r_bank_entry.js"></script>

<div class="dframe" id="r_view2" style="width: 1000px;">
    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
   
    <fieldset>
        <legend>Date</legend>
        <table border="0" style="font-size: 12px;">
            <tr>
               
                <td style="width:75px;"><font size="2">From</font></td>
                <td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" /></td>
                <td style="padding-left:80px;"><font size="2">To</font></td>
                <td>&nbsp;&nbsp;<input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td>
            </tr>
        </table>   
    </fieldset> 
    <fieldset id="filter">  
        <legend>Filter By</legend>
        <table border="0" style="font-size: 12px;" >
            <tr id="ddate">
                <td style="width:68px;"></td>
                <td style="text-align:center;width:30px;"><input type="radio" id="transaction_date" name="by"/></td>
                <td >Transaction Date</td>
                <td style="text-align:right;width:60px;"><input type="radio" id="realise_date" name="by"/></td>
                <td>&nbsp;&nbsp;Realise Date</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table border="0" style="font-size: 12px;">
            <tr>
                <td style="width:75px;"> Status</td>
                <td>
                    <select name='status' id='status' >
                        <option value='0'>---</option>
                        <option value='P'>Pending</option>
                        <option value='D'>Deposit</option>
                        <option value='R'>Return</option>
                        <option value='F'>Refund</option>
                    </select>
                </td>
             </tr>

             <tr>
                <td style="width:75px;"><span class='chq_status'>Cheque Book Status</span></td>
                <td>
                    <select name='chq_status' id='chq_status' class='chq_status'>
                        <option value='f'>---</option>
                        <option value='0'>Pending</option>
                        <option value='1'>Issued</option>
                        <option value='2'>Complete</option>
                    </select>
                </td>
             </tr>   

        </table> 
     </fieldset> 
    <fieldset >
        <legend >Category</legend>
        <div id="report_view" style="overflow: auto;">
        <table border="0" cellpadding="0" cellspacing="0" id="cl_bc" style="font-size: 12px;">        
             <tr>
                <td style="width:83px;">Cluster</td>
                <td><?php echo $cluster; ?></td>
            </tr>

            <tr>
                <td>Branch</td>
                <td>
                    <select name='branch' id='branch' >
                        <option value='0'>---</option>
                    </select>
                    <!-- <?php echo $branch; ?> -->
                </td>
             </tr>
         </table>

         <input type="hidden" id="d_cl" title='<?php echo $d_cl ?>' name="d_cl"/>
        <input type="hidden" id="d_bc" title='<?php echo $d_bc ?>' name="d_bc"/>
        
         <table border="0" cellpadding="0" cellspacing="0" id="cl_bc" style="font-size: 12px;">  
                <tr id="account_c">
                    <td style="width:83px;">Account Code</td>
                    <td style="width:450px;"><input type="text" class="input_txt" title="" id="acc_code" name="acc_code" />
                        <input type="text" class="hid_value"  readonly="readonly" id="acc_code_des"  style="width: 250px;">
                    </td>
                </tr>
                <tr> <td colspan="5"><hr/><td> </tr>

        </table>



        </div>
       
        
        <table border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;">

            <tr>
                <td style="width:300px;"><input type="radio" id="bank_entry_list" name="acc"/>Bank Entry List</td><br/>
                <td><input type="radio" id="chq_b_registry" name="acc"/>Cheque Book Registry</td>
            </tr>
            <tr>
            <td><input type="radio" id="pen_credit_crd_det" name="acc"/>Pending Credit Card Details</td>
            </tr>

             <!-- <tr>
            <td><input type="radio" id="cheque_return_list" name="acc"/>Cheque Return List</td>
            </tr> -->
            <?php //if($this->user_permissions->is_view('r_voucher_lists')){ ?>
            <tr>
                <td colspan="2">
                    <input type='radio' name='acc' id='r_cheque_in_hand' title="r_cheque_in_hand" class="report" />Cheque in Hand
                </td>               
            </tr>
            <?php //} ?>

            <?php //if($this->user_permissions->is_view('r_voucher_lists')){ ?>
            <tr>
                <td colspan="2">
                    <input type='radio' name='acc' id='r_issued_pending_cheque' title="r_issued_pending_cheque" class="report" />Issued Cheques 1 </td>               
            </tr>
            <?php //} ?>

            <?php //if($this->user_permissions->is_view('r_voucher_lists')){ ?>
            <tr>
                <td colspan="2">
                    <input type='radio' name='acc' id='r_issued_cheque' title="r_issued_cheque" class="report" />Issued Cheques 2 </td>               
            </tr>
            <?php //} ?>
                
        </table>

        <div style="text-align: right; margin-top:10px; padding-top: 7px;">
        <button id="btnReset">Reset</button>    
        <button id="btnExit">Exit</button>
        <button id="print">Print</button></div>
    </fieldset>
         <input type="hidden" id='by' name='by'  class="report">
         <input type="hidden" name='page' value='A4' title="A4" >
         <input type="hidden" name='orientation' value='P' title="P" >
         <input type="hidden" id='type' name='type' value='' title="" >
         <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
         <input type="hidden" name='row_count' title="row_count" id="row_count">
         <input type="hidden" name='clusters' title="" id="clusters" >
         <input type="hidden" name='branchs' title="" id="branchs">
         <input type="hidden" name='tran_dat' title="" id="tran_dat" >
         <input type="hidden" name='realise_dat' title="" id="realise_dat" >
         <input type="hidden" name='status_h' title="" id="status_h" >
</form>
</div>

<?php //} ?>