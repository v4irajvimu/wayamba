<?php if($this->user_permissions->is_view('t_cheque_issue_trans')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?=base_url()?>js/t_cheque_issue_trans.js'></script>
<h2>Cheque Withdraw</h2>
<div class="dframe" id="mframe" style="padding-right:25px;">
<table style="width:100%;" id="tbl1" border="0">
    <tr>
       <td>Bank</td>
     	<td style="width:120px;"><select></select></td>
     	<td colspan="2"><input type="text" id="bank" name="bank" title="" style="width:90%;" class="hid_value" readonly="readonly"/></td>
     	
     	<td>No</td>
     	<td>
     		<input type="text" class="input_active_num" name="id" id="id" title="<?//=$max_no?>" />
			<input type="hidden" id="hid" name="hid" title="0" />
		</td>
    </tr>

    <tr>
    	<td>Ref No</td>
     	
     	<td><input type="text" id="ref_no" name="ref_no" title="" class="input_txt" readonly="readonly"/></td>.
     	<td><input type="button" title="Load Pending Cheques" style="width:150px;"/></td>
     	<td width="200"> </td>
     	<td>Date</td>
     	<td>
     		<input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
		</td>

    </tr>

     

    <tr>
    	<td colspan="6">
    			<table style="width:100%;" id="tgrid">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 50px;">Acc No</th>
                                <th class="tb_head_th" >Description</th>
                                <th class="tb_head_th" style="width: 80px;">Cheque No</th>
                                <th class="tb_head_th" style="width: 80px;">Amount</th>
                                <th class="tb_head_th" style="width: 80px;">Bank Date</th>
                                 <th class="tb_head_th" style="width: 80px;">&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                                <input type='text' class='g_input_txt fo' id='0_".$x."' name='0_".$x."' readonly='readonly' style='width : 100%;' /></td>";
                                        echo "<td style='background-color: #f9f9ec;' ><input type='text' class='g_input_txt'  id='n_".$x."' name='n_".$x."' maxlength='150' style='width : 100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_num2 qun' id='1_".$x."' name='1_".$x."' style='width : 100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_amo amo' id='2_".$x."' name='2_".$x."' style='width : 100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_amo dis' id='3_".$x."' name='3_".$x."' style='width : 100%;'/></td>";
                                        echo "<td><input type='checkbox'  id='4_".$x."' name='4_".$x."' style='width : 100%;'/></td>";
                                        
                                       
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                  </table>
    	</td>
    </tr>

    
    <tr>
    	<td colspan="4" rowspan="2"><input type="button" id="btnExit" title="Exit" />
			<input type="button" id="btnReset" title="Reset" />
			<input type="button" id="btnDelete" title="Delete" />
			<input type="button" id="btnPrint" title="Print" />
			
			<input type="button"  id="btnSave1" title='Save <F8>' />
			
		</td>

		
			<td><span>No of Cheques<span></td>
			<td><span><input type="text" class="input_txt" name="no_cheque" id="no_cheque" style="100px;"/></span></td>
    </tr>

    <tr>
    	<td><span>Total Amount<span></td>
		<td><span><input type="text" class="input_txt" name="total_amount" id="total_amount" style="100px;"/></span></td>
    </tr>

</table>



</div>

<?php } ?>