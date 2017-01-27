<?php if($this->user_permissions->is_view('t_receipt_general')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_receipt_general.js"></script>
<?php $this->load->view('t_payment_option.php'); ?> 
<h2 style="text-align: center;">General Reciept</h2>
<div class="dframe" id="mframe">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_receipt_general" id="form_">
        <table style="width: 100%" border="0">
            <tr>

                <td style="width: 100px;">Cash Account</td>
                <td>
                    <input type="text" class="input_txt" title='' name="cash_acc" id="cash_acc"  style="width: 150px;">
                    <input type="text" class="hid_value" title='' name="cash_acc_des" readonly="readonly" id="cash_acc_des"  style="width: 300px;">
                </td>

                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" class="input_active_num" name="id" id="id" title="<?=$max_no?>" />
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>

            </tr>

            <tr>
                <td>Balance</td>
                <td><input type="text" class="hid_value g_input_amo amount" name="balance" id="balance" title="" style="width: 150px;"/></td>
                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" style="width:100%" class="input_active_num" name="id" id="id" title="<?//=$max_no?>" />
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>
            </tr>
            
            <tr>
                <td>Description</td>
                <td>
                    <input type="text" class="input_txt" name="description" id="description" title="" style="width: 455px;"/></td>
                <td style="width: 100px;">Date</td>
                <td style="width: 100px;"><input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" /></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%;"/></td>
           
            </tr>

          <tr>
                <td colspan="4" style="text-align: center;">
                	
                    <table style="width: 875px;" id="tgrid">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 80px;">Account</th>
                                <th class="tb_head_th">Description</th>
                                <th class="tb_head_th" style="width: 80px;">Amount</th>
                                <th class="tb_head_th" style="width: 80px;">Ref No</th>
                               
                            </tr>
                        </thead><tbody>
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                                <input type='text' class='g_input_txt fo' id='0_".$x."' name='0_".$x."'  /></td>";
                                        echo "<td><input type='text' class='g_input_txt'  id='n_".$x."' name='n_".$x."' maxlength='150'/></td>";
                                        echo "<td><input type='text' class='g_input_num2 qun amount' id='1_".$x."' name='1_".$x."' /></td>";
                                        echo "<td><input type='text' class='g_input_amo amo' id='2_".$x."' name='2_".$x."' /></td>";
                                  
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                                               
                    </table>
                
			</td>

            </tr>
            <tr>
            	<td colspan="4">

            		<span><input type="checkbox" name="payment_opt" id="payment_opt"/></span>
            		Payment Option 
            		<input type="text" name="popt" id="popt" class="input_txt" readonly="readonly" style="width:160px;"/>
            		<span style="text-align:left;margin-left:413px;"><b>Total Amount</b>

					<input type="text" class="hid_value g_input_amounts" name="net" id="net" style="width:100px;"/>
					                    
					</span>
            	</td>
            </tr>

            <tr>
            	<td colspan="4">
					 		<div style="text-align: left; padding-top: 7px;">
					                        <input type="button" id="btnExit" title="Exit" />
					                        <input type="button" id="btnReset" title="Reset" />
					                        <input type="button" id="btnDelete" title="Delete" />
					                        <input type="button" id="btnPrint" title="Print" />
					                       
					                        <input type="button"   title="Delivery Note" />
					                        <input type="button" id="showPayments"  title="Payments" />		
					                       
					                        
                    		</div>
                
            	</td>


            </tr>
        </table>
    </form>
</div>
<?php } ?>