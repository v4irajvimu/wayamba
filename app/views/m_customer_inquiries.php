<?php if($this->user_permissions->is_view('m_customer_inquiries')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/m_customer_inquiries.js'></script>
<h2>Customer Inquiries</h2>
<table width="100%"> 
    <tr>
        <td valign="top" class="content" style="width:450px;">
            <div class="form" id="form" style="width:470px;">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/m_customer_inquiries" >
                <table>
						<tr>
							<td style="width: 450px;">Customer</td>
							<td>
                                <input type="text" readonly class="input_txt" title='' id="cus_id" name="cus_id" style="width:100px; ">
                                <input type="text" class="input_txt input_hid" readonly title='' id="cus_name" name="cus_name" style="width:275px; " >
                                <input type='hidden' name='id' id='id'>
                                <input type="hidden" name='hid' id='hid' title="0">
                            </td>
						</tr>
						
						<tr>
							<td>Address</td>
							<td>
                                <input type="text" class="input_txt" title='' id="address" name="address" style="width:379px;"/>
                            </td>
						</tr>

                        <tr>
                            <td>Action</td>
                            <td>
                                <input type="text" readonly class="input_txt" title='' id="act" name="act" style="width:100px; ">
                                <input type="text" class="input_txt input_hid" readonly title='' id="act_des" name="act_des" style="width:275px; " >
                            </td>
                        </tr>

                        <tr>
                            <td>Officer</td>
                            <td>
                                <input type="text" readonly class="input_txt" title='' id="officer" name="officer" style="width:100px; ">
                                <input type="text" class="input_txt input_hid" readonly title='' id="officer_des" name="officer_des" style="width:275px; " >
                            </td>
                        </tr>

                        <tr>
                            <td>Note</td>
                            <td>
                                <textarea class="input_txt" title='' id="note" name="note" style="width:379px;"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Amount</td>
                            <td>
                                <input type="text" class="input_txt g_input_amo" id="amount" name="amount" style="width:100px; ">
                            </td>
                        </tr>

                        <tr>
                            <td >Promiss Date</td>
                            <td>
                                <input type="text" readonly class="input_txt input_date_down_future" id="p_date" name="p_date" style="width:100px;text-align:right; ">
                            </td>
                        </tr>

                        <tr>
                            <td>Salary Date</td>
                            <td>
                                <input type="text" readonly class="input_txt input_date_down_future" id="s_date" name="s_date" style="width:100px;text-align:right; ">
                            </td>
                        </tr>

						<tr>
							<td style="text-align:right" colspan="2">
                                <input type="hidden" id="code_" name="code_" title="0" />
    							<input type="button" id="btnExit" title="Exit" />
                                <input type="button" id="btnReset" title='Reset'>
                                <?php if($this->user_permissions->is_add('m_customer_inquiries')){ ?><input type="button" id="btnDelete" title='Delete' /><?php } ?>
    							<?php if($this->user_permissions->is_add('m_customer_inquiries')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                                
							</td>
                        </tr>
                </table>
                </form>
            </div>
        </td><td class="content" valign="top" style="width:638px;">
            <div class="form" id="form" style="width:638px; padding:8px !important;" >
            <table >
            <div id="grid_body">
                    <!-- <span>Customer History</span> -->
                </div>
            </table>
                
            </div>
        </td>
    </tr>
</table>
<?php } ?>
