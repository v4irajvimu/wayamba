<?php if($this->user_permissions->is_view('t_hp_seize')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_seize.js"></script>
<div id="fade" class="black_overlay"></div>
<?php 
if($ds['use_serial_no_items'] ){
	$this->load->view('t_serial_out.php'); 
}
?>

<h2 style="text-align: center;">HP Seize</h2>
<div class="dframe" id="mframe" style='width:1200px;'>
	<form method="post" action="<?=base_url()?>index.php/main/save/t_hp_seize" id="form_" enctype="multipart/form-data">
		<table style="width: 100%" border="0">
			<tr>
				<td style="width: 100px;">Agreenment No</td>
				<td>
					<input type="text" class="input_txt hid_value" title="" id="agr_no" name="agr_no" style="width: 170px;"/>
					<input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
				</td>
				<td style="width: 50px;">No</td>
				<td>
					<input type="text" class="input_active_num" name="id" id="id" title="<?php echo $max_no; ?>"/>
					<input type="hidden" id="hid" name="hid" title="0" />
				</td>
			</tr>
			<tr>
				<td>Customer</td>
				<td>
					<input type="text" class="input_txt" title="" id="cus_id" name="cus_id" readonly="readonly" style="width: 170px;"/>
					<input type="text" class="hid_value"  readonly="readonly" id="cus_des"  style="width: 370px;">
					&nbsp;&nbsp;&nbsp;&nbsp; Tel / Fax / Mobile
					<input type="text" class="hid_value" id='tel'>
				</td>
				<td style="width: 100px;">Date</td>
				<td ><input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="width: 100px; text-align:right;"/></td>
			</tr>

			<tr>
				<td style="width: 100px;">Address</td>
				<td>
					<input type="text" class="hid_value" id="cus_add" style="width: 544px;"/>
				</td>
				<td style="width: 100px;">Ref. No</td>
				<td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100px;"/></td>
			</tr>
		</table>



		<table style="width:100%;margin-bottom:1px;margin-top:1px;" border="0">
			<tr>
				<td >
					<div id="tabs4" style="width:905px">
						<ul>
							<li style="width:173px;"><a href="#tabs-1" >Contact Details</a></li>
							<li style="width:173px;"><a href="#tabs-2" >Gurantor 1</a></li>
							<li style="width:173px;"><a href="#tabs-3" >Gurantor 2</a></li>
							<li style="width:173px;"><a href="#tabs-4" >Receipt Details</a></li>
							<li style="width:173px;"><a href="#tabs-5" >Installment</a></li>
						</ul>
						<div id="tabs-1">
							<table border="0">
								<tr> 
									<td>No</td>
									<td><input type="text" class="hid_value g_input_num" id="hp_no" name="hp_no" style="width: 150px;"/></td>
									<td> Loan Amount</td>
									<td><input type="text" class="hid_value g_input_amo " id="loan_amt" name="loan_amt" style="width: 150px;"/></td>
									<td>Period </td>
									<td><input type="text" class="hid_value g_input_num" id="period" name="period" style="width: 150px;"/></td>

								</tr>
								<tr>
									<td>Date </td>
									<td ><input type="text" class="hid_value g_input_num" readonly="readonly" name="hp_date" id="hp_date"  style="width: 150px; text-align:right;"/></td>
									<td> Down Payment </td>
									<td><input type="text" class="hid_value g_input_amo" id="down_payment" name="down_payment" style="width: 150px;"/></td>
									<td>Rate </td>
									<td><input type="text" class="hid_value g_input_amo" id="rate" name="rate" style="width: 150px;"/></td>

								</tr>
								<tr> 
									<td>Ref No</td>
									<td><input type="text" class="hid_value " id="hp_ref_no" name="hp_ref_no" style="width: 150px;"/></td>
									<td>Int. Amount </td>
									<td><input type="text" class="hid_value g_input_amo " id="int_amt" name="int_amt" style="width: 150px;"/></td>
									<td>Doc. Charges </td>
									<td><input type="text" class="hid_value g_input_amo" id="doc_charges" name="doc_charges" style="width: 150px;"/></td>
								</tr>
							</table>
						</div>
						<div id="tabs-2">
							<table border="0">
								<tr> 
									<td>Name</td>
									<td><input type="text" class="hid_value input_txt  " id="g1_name" name="g1_name" style="width: 350px;"/></td>

								</tr>
								<tr>
									<td>Address </td>
									<td ><input type="text" class="hid_value input_txt" readonly="readonly" name="g1_address" id="g1_address"  style="width: 350px; text-align:right;"/></td>

								</tr>
								<tr> 
									<td>Tel/ Mobile No</td>
									<td><input type="text" class="hid_value  input_txt" id="g1_tp_no" name="g1_tp_no" style="width: 350px;"/></td>
								</tr>
							</table>	
						</div>
						<div id="tabs-3">
							<table border="0">
								<tr> 
									<td>Name</td>
									<td><input type="text" class="hid_value input_txt  " id="g2_name" name="g2_name" style="width: 350px;"/></td>

								</tr>
								<tr>
									<td>Address </td>
									<td ><input type="text" class="hid_value input_txt" readonly="readonly" name="g2_address" id="g2_address"  style="width: 350px; text-align:right;"/></td>

								</tr>
								<tr> 
									<td>Tel/ Mobile No</td>
									<td><input type="text" class="hid_value  input_txt" id="g2_tp_no" name="g2_tp_no" style="width: 350px;"/></td>
								</tr>
							</table>	
						</div>
						<div id="tabs-4">
							<table style="width: 100%;" border="0" id="">
								<thead>
									<tr>
										<th class="tb_head_th" style="width: 120px;">Receipt No</th>
										<th class="tb_head_th" style="width: 120px;">Receipt Date</th>
										<th class="tb_head_th"  style="width: 120px;">Receipt Amount</th>
									</tr>
								</thead>
								<tbody id='rcpt_details'></tbody>
							<tfoot>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div id="tabs-5">
						<table style="width: 100%;" border="0" id="">
							<thead>
								<tr>
									<th class="tb_head_th" style="width: 120px;">Installment No</th>
									<th class="tb_head_th" style="width: 120px;">Due Date</th>
									<th class="tb_head_th"  style="width: 120px;">Installment</th>
								</tr>
							</thead>
							<tbody id='ins_details'></tbody>
						<tfoot>
							<tr>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<td>
				<td></td>
				<td style="width: 100px;"></td>
				<td></td>
			</tr>
			<tr>
				<td >Stores
					<input type="text" class="hid_value store11" id="hp_store" name="hp_store" style="width: 100px;"/>
					<input type="text" class="hid_value" id="hp_storedes" style="width: 265px"/>
					Revert Chargers
					<input type="text" class="input_active g_input_amo" id="rt_chargers" name="rt_chargers" style="width: 100px;"/>
					<!-- Total Due Amount
					<input type="text" class="hid_value" id="tot_due" name="tot_due" style="width: 100px;"/> --> </tr>
					<input type='hidden' id='transtype' title='HP SEIZE' value='HP SEIZE' name='transtype' />
					<input type='hidden' id='transCode' title='116' value='116' name='transCode' />

					<input type='hidden' id='cluster' title='<?=$cl?>' name='cluster' />
					<input type='hidden' id='branch' title='<?=$bc?>' name='branch' />
				</tr>
			</table>

			<table style="width:100%;margin-bottom:1px;margin-top:1px;">
				<tr></tr>
			</table>

			<tr>
				<td colspan="4" style="text-align: center;">
					<table style="width: 98%;" id="tgrid">
						<thead>
							<tr>
								<th class="tb_head_th" style="width: 130px;">Item Code</th>
								<th class="tb_head_th">Item Name</th>
								<th class="tb_head_th" style="width: 40px;">Batch</th>
								<th class="tb_head_th" style="width: 80px;">Qty</th>
								<th class="tb_head_th" style="width: 80px;">Price</th>
								<th class="tb_head_th" style="width: 80px;">Amount</th>
								<th class="tb_head_th" style="width: 80px;">Discount</th>
								<th class="tb_head_th" style="width: 80px;">Net Value</th>
								<th class="tb_head_th" style="width: 100px;">Serials</th>
							</tr>
						</thead>
						<tbody>
						<?php for($x=0; $x<25; $x++){
							$y = $x + 1;
							echo "<tr class='cl1'>";
							echo "<td><input type='hidden' id='h_".$x."' title='0' />
										<input type='text' style='width:100%;' class='g_input_txt g_col_fixed' id='itemcode_".$x."'/></td>";
							echo "<td>
								<input type='text' style='width:160px;' class='g_input_txt g_col_fixed' id='itemdes_".$x."'  readonly='readonly' style='width:100%;'/>
								</td>";
							echo "<td><input type='text' style='width:100%;' class='g_input_num g_col_fixed  btt_".$x." ' id='btt_".$x."' /></td>";
							echo "<td><input type='text' style='width:100%;' class='g_input_num g_col_fixed ' id='qty_".$x."' /></td>";

							echo "<td><input type='text' style='width:100%;' class='g_input_amo g_col_fixed' id='price_".$x."' /></td>";
							echo "<td><input type='text' style='width:100%;' class='g_input_amo g_col_fixed' id='amt_".$x."' /></td>";
							echo "<td style='width:40px;'><input type='text' style='width:100%;' class='g_input_amo g_col_fixed' id='discount_".$x."'  readonly='readonly'/></td>";
							echo "<td><input type='text' style='width:100%;' class=' g_input_amo g_col_fixed' id='net_".$x."'  /></td>";
							echo "<td style=''><input type='text' id='serial_".$x."' class='g_input_txt g_col_fixed' style='width:100%;'/>
									<input type='hidden' id='is_free_".$x."' />
							</td>";    
							echo "</tr>";
						}?>
				</tbody>
				<tfoot><tr></tr></tfoot>

			</table>
			<table style="width: 98%;" id="tgrid2">
				<thead>
					<tr>
						<th class="tb_head_th" style="width: 130px;">Item Code</th>
						<th class="tb_head_th">Item Name</th>
						<th class="tb_head_th" style="width: 40px;">Batch</th>
						<th class="tb_head_th" style="width: 80px;">Qty</th>
						<th class="tb_head_th" style="width: 80px;">Price</th>
						<th class="tb_head_th" style="width: 80px;">Amount</th>
						<th class="tb_head_th" style="width: 80px;">Discount</th>
						<th class="tb_head_th" style="width: 80px;">Net Value</th>
						<th class="tb_head_th" style="width: 100px;">Serials</th>
					</tr>
				</thead>
				<tbody>
					<?php for($x=0; $x<25; $x++){
						$y = $x + 1;
					echo "<tr>";
					echo "<td><input type='hidden' name='h1_".$x."' id='h1_".$x."' title='0' />
						<input type='text' style='width:100%;' class='g_input_txt fo g_col_fixed' id='0_".$x."' name='0_".$x."'/></td>";
					echo "<td>
						<input type='text' style='width:160px;' class='g_input_txt g_col_fixed cnt' id='itemdes1_".$x."' style='width:100%;'/>
						</td>";
					echo "<td><input type='text' style='width:100%;' class='g_input_num g_col_fixed' id='btt1_".$x."' name='btt1_".$x."' /></td>";
					echo "<td style='text-align:right;'><input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
							<input type='text' style='width:78%;' class='g_input_num qtycl".$x."'' id='qty1_".$x."' name='qty1_".$x."' /></td>";

					echo "<td><input type='text' style='width:100%;' class='g_input_amo g_col_fixed' id='price1_".$x."' name='price1_".$x."' /></td>";
					echo "<td><input type='text' style='width:100%;' class='g_input_amo g_col_fixed' id='amt1_".$x."' name='amt1_".$x."' /></td>";
					echo "<td style='width:40px;'><input type='text' style='width:100%;' class='g_input_amo' id='discount1_".$x."' name='discount1_".$x."' /></td>";
					echo "<td><input type='text' style='width:100%;' class='g_input_amo g_col_fixed' id='net1_".$x."' name='net1_".$x."' /></td>";
				echo "<td style=''><input type='text' id='serial1_".$x."' name='serial1_".$x."' class='g_input_txt' style='width:100%;'/>
							<input type='hidden' name='all_serial_".$x."' id='all_serial_".$x."' />
							<input type='hidden' id='is_free1_".$x."' name='is_free1_".$x."' />
							<input type='hidden' id='numofserial_".$x."' name='numofserial_".$x."' />
				</td>";    
				echo "</tr>";
			}
			?>
		</tbody><tfoot><tr><td>&nbsp;</td></tr></tfoot>
	</table>
	<div style="margin-top:1px;">
		<table border="0" style="width:100%;">
			<tr>
				<td rowspan="3" colspan="3">
				</td>
				<td rowspan="0" valign="top">
					<table> 
						<tr> 
							<td> 
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table border='0' style="width:100%">
				<tr>

					<td style="width: 100px;">Rivert Person</td>
					<td style="width: 400px;">
						<input type="text" name="rivert_person" id="rivert_person" style="width:120px;" class="input_active" readonly="readonly" title=""/>
						<input type="text" id="rivert_person_des" style="width:265px;" class="hid_value" readonly="readonly" title=""/>

					</td>
					<td style="width: 420px;"> </td>
					<td style="width: 100px;text-align:right;">Total Amount</td>
					<td>
						<input type="text" class="hid_value g_input_amounts" title="" id="tot_amount" name="tot_amount" />
					</td>
				</tr>
				<tr>
					<td>Note </td>
					<td>	<input type="text" class="input_txt" title="" id="note" name="note" style="width:389px;" maxlength="100"/>
					</td>
				</tr>
				<tr>
					<td style="width: 100px;">Stores</td>
					<td style="width: 400px;">
						<input type="text" name="store_code" id="store_code" style="width:120px;" class="input_active" readonly="readonly" title=""/>
						<input type="text" id="store_des" style="width:265px;" class="hid_value" readonly="readonly" title=""/>
					</td>
				</tr>
				<tr>
					<td style="width: 100px;">Collection Officer</td>
					<td style="width: 400px;">
						<input type="text" name="officer" id="officer" style="width:120px;" class="input_active" readonly="readonly" title=""/>
						<input type="text" id="officer_des" style="width:265px;" class="hid_value" readonly="readonly" title=""/>
					</td>
				</tr>
			</table>                
		</div>
		
	<div style="text-align: right; padding-top: 20px;">
		<input type="button" id="btnExit" title="Exit" />
		<input type="button" id="btnReset" title="Reset" />
		<?php if($this->user_permissions->is_re_print('t_hp_seize')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>  
		<?php if($this->user_permissions->is_delete('t_hp_seize')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?>
		<?php if($this->user_permissions->is_add('t_hp_seize')){ ?><input type="button"  id="btnSave" title="Save" /><?php } ?>
	</div>
	
</td>
</tr>
</table>
</form>

<?php 
if($this->user_permissions->is_print('t_hp_seize')){ ?>
<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 

<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

	<input type="hidden" name='by' value='t_hp_seize' title="t_hp_seize" class="report">
	<input type="hidden" name='page' value='A5' title="A5" >
	<input type="hidden" name='orientation' value='L' title="L" >
	<input type="hidden" name='type' value='hp_seize' title="hp_seize" >
	<input type="hidden" name='header' value='false' title="false" >
	<input type="hidden" name='qno' value='' title="" id="qno" >

</form>
</div>

<div id="light33" class="white_content2" style='width:1020px; height: 575px; overflow: hidden;'>
	<div style='margin:-10px 10px 5px 5px;padding:5px 0px;'>
		<h3 id='pop_heading' style='width:100%;font-family:calibri;background:#283d66;color:#fff;text-transform:uppercase;'>Customer History Details</h3>
		<div id='item_det33'></div>
		<hr style="width:100%"/>
	</div>    
	<input type='button' value='close' title='Close' id='popclose33' style="position:relative; bottom:5px;right:5px; float: right;"/>
</div>
<div id="fade33" class="black_overlay"></div>

<?php } ?>