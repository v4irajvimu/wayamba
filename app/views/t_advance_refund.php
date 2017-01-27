<?php if($this->user_permissions->is_view('t_advance_refund')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_advance_refund.js"></script>


<div id="fade" class="black_overlay"></div>

<h2 style="text-align: center;">Advance Refund</h2>
<div class="dframe" id="mframe" style="padding-right:25px;">
<form method="post" action="<?=base_url()?>index.php/main/save/t_advance_refund" id="form_">

	<table style="width: 100%" border="0">
		<tr>
			<td style="width: 100px;"></td>
			<td style="width: 100px;"></td>
			<td style="width: 500px;" colspan="2"></td>
			<td style="width: 80px;padding-left:25px;">No</td>
			<td>
				<input type="text" class="input_active_num" style="width:100%" name="id" id="id" title="<?=$max_no?>" />
				<input type="hidden" id="hid" name="hid" title="0" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="2"></td>
			<td style="padding-left:25px;">Date</td>
			<td>
				<?php if($this->user_permissions->is_back_date('t_advance_refund')){ ?>
				<input type="text" class="input_date_down_future" style='text-align:right;width: 100%' readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
				<?php } else{ ?>
				<input type="text" class="input_txt" readonly="readonly" style='text-align:right;width: 100%' name="date" id="date" title="<?=date('Y-m-d')?>" />
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>Receipt No</td>
			<td><input type="text" class="input_active_num" name="rec_no" id="rec_no" title="" style="width:100%;"/></td>
			<td colspan="2"><input type="text" class="hid_value" name="rec_no_des" id="rec_no_des" title="" style="width:100%;"/></td>
			<td style="padding-left:25px;">Reference No</td>
			<td><input type="text" class="input_active_num" name="ref_no" id="ref_no" title="" style="width:100%;"/></td>
		</tr>
		<tr>
			<td>Date</td>
			<td><input type="text" class="input_active_num" name="ddate" id="ddate" title="" style="width:100%;"/></td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Customer</td>
			<td><input type="text" class="input_txt" name="cus_id" id="cus_id" title="" style="width:100%;"/></td>
			<td colspan="2"><input type="text" class="hid_value" name="cus_name" id="cus_name" title="" style="width:100%;"/></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" >
				<fieldset>
					<legend>Payments</legend>
					<table border="0" style="width: 300px">
						<tr>
							<td style="width: 80px;">Cash</td>
							<td style="width: 100px;"><input type="text" class="input_active_num" name="cash_amo" id="cash_amo" title="" style="width:100%;" readonly="readonly" /></td>
							<td ></td>
						</tr>
						<tr>
							<td>Credit Card</td>
							<td><input type="text" class="input_active_num" name="credit" id="credit" title="" style="width:100%;" readonly="readonly"/></td>
							<td></td>
						</tr>
						<tr>
							<td>Cheques</td>
							<td><input type="text" class="input_active_num" name="cheque" id="cheque" title="" style="width:100%;" readonly="readonly"/></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>Total</td>
							<td><input type="text" class="hid_value input_active_num" name="total" id="total" title="" style="width:100%;" readonly="readonly"/></td>
							<td></td>
						</tr>
					</table>
				</fieldset>
			</td>
			<td colspan="3" >

				<div id="tab">
					<ul>
						<li><a href="#tab-2" >Credit Card</a></li>
						<li><a href="#tab-3" >Cheque</a></li>
						<li><a href="#tab-4" >Other Advance Payments</a></li>
					</ul>

					<div id="tab-2">
						<fieldset>
							<div class="tgrid3">
								<table style="width:500px; min-height:40px;" cellpadding="0">
									<thead>
										<tr>
											<th class="tb_head_th" style="width:80px;">Type</th>
											<th class="tb_head_th" style="width:80px;">Amount</th>
											<th class="tb_head_th" style="width:80px;">Number</th>
											<th class="tb_head_th" style="width:80px;">Bank</th>
											<th class="tb_head_th" style="width:80px;">Bank Name</th>
											<th class="tb_head_th" style="width:80px;">Month</th>
											<th class="tb_head_th" style="width:80px;">Rate%</th>
											<th class="tb_head_th" style="width:80px;">Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
										for($x=0; $x<5; $x++){
											echo "<tr>";
											echo "<td><input type='text' readonly class='g_input_txt type1' id='type1_".$x."' name='type1_".$x."'  /></td>";
											echo "<td><input type='text' class='g_input_amo cc_amount'  id='amount1_".$x."' name='amount1_".$x."'/></td>";                
											echo "<td><input type='text' style='border: medium none;width: 100%;' maxlength='30' class='' id='no1_".$x."' name='no1_".$x."'/></td>"; 
											echo "<td>
											<input type='text' readonly class='g_input_txt bank1' id='bank1_".$x."' name='bank1_".$x."'/>
											<input type='hidden' id='acc1_".$x."' name='acc1_".$x."'/>
											<input type='hidden' id='merchant1_".$x."' name='merchant1_".$x."'/>
										</td>"; 
										echo "<td><input type='text' class='g_input_txt g_col_fixed bank11' id='1bank1_".$x."' name='1bank1_".$x."'/></td>"; 
										echo "<td><input type='text' class='g_input_num g_col_fixed' id='month1_".$x."' name='month1_".$x."'/></td>"; 
										echo "<td><input type='text' class='g_input_amo g_col_fixed' id='rate1_".$x."' name='rate1_".$x."'/></td>";
										echo "<td><input type='text' class='g_input_amo g_col_fixed' id='amount_rate1_".$x."' name='amount_rate1_".$x."'/></td>";                
										echo "</tr>";
									}
									?>                                          
								</tbody>
							</table>
						</div>
					</fieldset>
				</div>

				<div id="tab-3">
					<fieldset>
						<div class="tgrid3">
							<table style="width:500px;" cellpadding="0" >
								<thead>
									<tr>
										<th class="tb_head_th" style="width:80px;">Bank</th>
										<th class="tb_head_th" style="width:80px;">Branch</th>
										<th class="tb_head_th" style="width:80px;">Account No</th>
										<th class="tb_head_th" style="width:80px;">Cheque No</th>
										<th class="tb_head_th" style="width:80px;">Amount</th>
										<th class="tb_head_th" style="width:80px;">CHQ Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									for($x=0; $x<5; $x++){
										echo "<tr>";
										echo "<td><input type='text' class='g_input_txt bank9' readonly id='bank9_".$x."' name='bank9_".$x."' /></td>";
										echo "<td><input type='text' class='g_input_txt g_col_fixed branch9' id='branch9_".$x."' name='branch9_".$x."' /></td>";                
										echo "<td><input type='text' class='g_input_txt' id='acc9_".$x."' name='acc9_".$x."' /></td>";                
										echo "<td><input type='text' class='g_input_txt' id='cheque9_".$x."' name='cheque9_".$x."'/></td>";
										echo "<td><input type='text' class='g_input_amo cr_amount' id='amount9_".$x."' name='amount9_".$x."'/></td>";                
										echo "<td><input type='text' class='input_date_down_future'  style='border:none;height:17px;font-weight:normal;' id='date9_".$x."' name='date9_".$x."'/></td>";                
										echo "</tr>";
									}
									?>                                          
								</tbody>
							</table>
						</div>
					</fieldset>
				</div>

				<div id="tab-4">
					<fieldset>
						<div class="tgrid3">
							<table style="width:500px;" cellpadding="0" >
								<thead>
									<tr>
										<th class="tb_head_th">Receipt No</th>
										<th class="tb_head_th">Date </th>
										<th class="tb_head_th">Amounts</th>
									</tr>
								</thead><tbody>
								<?php
								for($x=0; $x<10; $x++){
									echo "<tr>";
									echo "<td><input type='text' class='g_input_txt g_col_fixed' readonly    id='n_".$x."' name='n_".$x."' style='width : 100%;' readonly='readonly'/></td>";
									echo "<td><input type='text' class='g_input_txt g_col_fixed' id='1_".$x."' name='1_".$x."' style='width : 100%;' readonly='readonly'/></td>";
									echo "<td><input type='text' class='g_input_num g_col_fixed' id='2_".$x."' name='2_".$x."' style='width : 100%;  readonly='readonly'/></td>";
									echo "</tr>";
								}
								?>
							</tbody>
						</table> 
					</div>
				</fieldset>
			</div>
		</div>
	</td>
</tr>
<tr>
	<td colspan="7">
		<input type="button" id="btnExit" title="Exit" />
		<input type="button" id="btnReset" title="Reset" />
		<?php if($this->user_permissions->is_delete('t_advance_refund')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?> 
		<?php if($this->user_permissions->is_re_print('t_advance_refund')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?> 
		<?php if($this->user_permissions->is_add('t_advance_refund')){ ?>
		<input type="button" id="btnSave" title='Save <F8>' />
		<?php } ?> 
	</td>
</tr>

</table>
<?php 
if($this->user_permissions->is_print('t_advance_refund')){ ?>
<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 


</form>

<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

	<input type="hidden" name='by' value='t_advance_refund' title="t_advance_refund" class="report">
	<input type="hidden" name='page' value='A5' title="A5" >
	<input type="hidden" name='orientation' value='L' title="L" >
	<input type="hidden" name='type' value='advance_payment' title="advance_payment" >
	<input type="hidden" name='reciviedAmount' value='' title=""  id='reciviedAmount'>
	<input type="hidden" name='header' value='false' title="false" >
	<input type="hidden" name='qno' value='' title="" id="qno" >
	<input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
	<input type="hidden" name="sales_type" id="sales_type" value="" title="" >
	<input type="hidden" name='dt' value='' title="" id="dt" >
	<input type="hidden" name='cus_id_print' value='' title="" id="cus_id_print" >
	<input type="hidden" name='salesp_id' value='' title="" id="salesp_id" >
	<input type="hidden" name='org_print' value='' title="" id="org_print">

</form>
</div>
<?php } ?>
