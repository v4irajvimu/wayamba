<?php if($this->user_permissions->is_view('r_transaction_settu')){ ?>
<link rel="stylesheet" href="<?=base_url()?>css/report.css" />
<script type='text/javascript' src='<?=base_url()?>js/r_transaction_settu.js'></script>

<h2> Seettu Invoice</h2>

<div class="dframe" id="r_view2" style="width: 1000px;">
    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank"> 
        <fieldset>
            <legend>Date</legend>
            <table>
                <tr>
                    <td><font size="2">From</font></td>
                    <td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px; text-align:right;" /></td>
                    <td style="padding-left:40px;"><font size="2">To</font></td>
                    <td><input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px; text-align:right;"  /></td>
                </tr>
            </table>
        </fieldset>  

        <fieldset>
        <legend>Category</legend>
            <table border="0" cellpadding="0" cellspacing="0" id="cl_bc" style="font-size: 12px;">

                <tr>
                     <td style="width:100px;">Cluster</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="cluster" name="cluster"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="cluster_id"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Branch</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="branch_id" name="branch_id"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="branch"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Customer</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="cus_id" name="cus_id"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="customer"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Salesman</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="salesman_id" name="salesman_id"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="salesman"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Collection Officer</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="c_officer_id" name="c_officer_id"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="c_officer"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Route</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="route_id" name="route_id"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="route"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Vehicle</td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="vehicle_id" name="vehicle_id"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="vehicle"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr>
                     <td>Seettu No </td>
                        <td colspan="3">
                            <input type="text" class="input_active" id="seettu_no" name="seettu_no"  title="" style="width:150px;" maxlength="" />
                            <input type="text" class="hid_value" readonly="readonly" title='' id="seettu"   style="width:400px;" maxlength="255" readonly='readonly'/>
                        </td>
                </tr>
                <tr> <td colspan="4"><hr/><td> </tr>

                <table border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;">
                    <?php if($this->user_permissions->is_view('r_seettu_invoice')){ ?>
                        <tr>
                            <td><input type="radio" id="seettu_inv" name="by"/>Seettu Invoice</td>
                        </tr>

                    <?php } ?>

                    <?php if($this->user_permissions->is_view('r_seettu_summery')){ ?>
                        <tr>
                            <td>
                                <input type='radio' id="r_seettu_summery" name="by" value='r_seettu_summery' title="r_seettu_summery" class="report" /> Seettu  Summery
                            </td>               
                        </tr>
                    <?php } ?>

                    <?php if($this->user_permissions->is_view('r_seettu_details')){ ?>
                        <tr>
                            <td>
                                <input type='radio' id="r_seettu_details" name="by" value='r_seettu_details' title="r_seettu_details" class="report" /> Seettu  Details
                            </td>               
                        </tr>
                    <?php } ?>

                    <?php if($this->user_permissions->is_view('r_seettu_history')){ ?>
                        <tr>
                            <td>
                                <input type='radio' id="r_seettu_history" name="by" value='r_seettu_history' title="r_seettu_history" class="report" /> Seettu  History
                            </td>               
                        </tr>
                    <?php } ?>
                </table>

                   <!--   <input type="hidden" id='by' name='by'  class="report"> -->
                     <input type="hidden" name='page' value='A4' title="A4" >
                     <input type="hidden" name='orientation' value='P' title="P" >
                     <input type="hidden" id='type' name='type' value='' title="" >
                     <input type="hidden" id='vehi' name='vehi' value='' title="" >
        
                  <div style="text-align: right; margin-top:10px; padding-top: 7px;">
                        <input type="button" value="Reset" title="Reset" id="btnReset"/>  
                        <input type="button" id="btnExit" title="Exit" />  
                        <input type="button" value="Print" title="Print" id="btnprint"/>
                  </div>  

                </table> 
            </fieldset>
                </form>   
</div>   

<?php } ?>