<?php if($this->user_permissions->is_view('t_hp')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp.js"></script>
<div id="fade" class="black_overlay"></div>
<?php 
if($ds['use_serial_no_items'] ){
	$this->load->view('t_serial_out.php'); 
}
?>
<style>
	.ui-tabs .ui-tabs-nav li a {
		padding: 0.1em 1em;
	}
	.ui-tabs .ui-tabs-panel {
		padding: 0.2em 0.4em;
	}
</style>
<h2 style="text-align: center;">Hire Purchase</h2>
<div class="dframe" id="mframe"  style='width:1200px;'>
	<form method="post" action="<?=base_url()?>index.php/main/save/t_hp" id="form_">
		<table style="width: 100%" border="0">
			<tr>
				<td style="width: 100px;">Scheme</td>
				<td>
					<input type="text" class="input_txt ld" title="" id="scheme" name="scheme" style="width: 150px;"/>
					<input type="text" class="hid_value"  readonly="readonly" id="scheme_des"  style="width: 280px;">
					<!-- <input type="hidden" class="hid_value" id="dep_codegen"> -->
				</td>
				<input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
				<td style="width: 50px;">No</td>
				<td>
					<input type="text" class="input_active_num" name="id" id="id" title="<?php echo $max_no; ?>"/>
					<input type="hidden" id="hid" name="hid" title="0" />
				</td>

			</tr><tr>
			<td>Category</td>
			<td>
				<input type="text" class="input_txt ld" title="" id="category" name="category" style="width: 150px;"/>
				<input type="text" class="hid_value"  readonly="readonly" id="category_des"  style="width: 280px;">
			</td>
			<td style="width: 100px;">Date</td>
			<td ><input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="width: 100px; text-align:right;"/></td>
		</tr>

		<tr>
			<td style="width: 100px;">Agreement No</td>
			<td>
				<?php if($use_auto_agr=="1"){ ?>
				<input type="text" class="input_txt" id="agreement_no" name="agreement_no" title="" readonly style="width: 150px;"/>
				<?php }else{ ?>
				<input type="text" class="input_txt" id="agreement_no" name="agreement_no" title="" style="width: 150px;"/>
				<?php }?>
				<input type="hidden" class="hid_value" id="agr_serial_no" name="agr_serial_no" title="" style="width: 180px;"/>
				<span style="margin-left:131px;">CRN No
					<input type="text" class="input_active_num" name="crn_no" id="crn_no" title="<?=$crn_no?>" style="width:100px;"/>
					<input type="hidden" class="input_active_num" name="crn_no_hid" id="crn_no_hid" value='' style="width:150px;"/>
				</span>
			</td>
			<td style="width: 100px;">Ref. No</td>
			<td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100px;"/></td>
		</tr>

		<tr>
			<td style="width: 100px;">Customer</td>
			<td>
				<input type="text" id="customer" class="input_active bar" title="" name="customer" style="width: 150px;"/>
				<input type="text" class="hid_value" id="customer_id"  title="" readonly="readonly" style="width:280px;" />
				<input type="button" id="btn_open_customer" title="..." value="...">
			</td>
			<td style="width: 100px;">Sub No</td>
			<td style="width: 100px;">
				<input type="text" class="input_active_num" readonly="readonly" name="sub_no" id="sub_no" title="0" style="width:100px;"/>
			</td> 
		</tr>
		<table style="width:100%;margin-bottom:1px;margin-top:1px;">
			<tr>
				<td colspan="2">
					<div id="tabs4" style="width:540px">
						<ul>
							<li><a href="#tabs-1" >Stores</a></li>
							<li class="grct"><a href="#tabs-2" >Genaral</a></li>
							<?php if($use_settu=="1"){?>
							<li><a href="#tabs-3" >Settu</a></li>
							<?php }?>
						</ul>
						<div id="tabs-1">
							<?php echo $stores; ?>
							<input type="text"  id="store_id" style="width:250px;" class="hid_value" title="" readonly="readonly"/>
						</div>
						<div id="tabs-2">
							<table>
								<tr>
									<td><span class="ct">Category</span></td>
									<td><span class="ct">
										<?php echo $sales_category;?></span>
										<input type="hidden" id="sales_category1" name="sales_category1" title="0" /> 
									</td>
										<!-- <td>Group</td>
										<td>
											<?php echo $groups;?>
										</td> -->
										<?php if($s_type==1){ ?>
										<td><span class="gr">Group</span></td>
										<input type='hidden' id='load_type' name='load_type'  title="1" value="1">
										<?php }else{ ?>
										<td>Dealer</td>
										<input type='hidden' id='load_type' name='load_type'  title="2" value="2">
										<?php } ?> 
										<td>
											<span class="gr"><input type="text" id='dealer_id' name='dealer_id' class='input_active'/></span>
										</td>
									</tr>

								</table>
							</div>
							<?php if($use_settu=="1"){?>
							<div id="tabs-3">
								<?php }else{ ?>
								<div id="tabs-3" style="display:none;">
									<?php } ?>
									<table>
										<tr>
											<td>Book Edition</td>
											<td>
												<input type="text" class="input_txt" id="book_no" name="book_no" style="width:125px;" readonly="readonly" />
											</td>
											<td> 
												<input type="text" class="hid_value" id="book_des" name="book_des" style="width:200px;"/>
											</td>
										</tr>
										<tr>
											<td>Item Category</td>
											<td>
												<input type="text" class="input_txt" id="s_cat" name="s_cat" style="width:125px;" readonly="readonly" />
											</td>
											<td> 
												<input type="text" class="hid_value" id="s_cat_des" name="s_cat_des" style="width:200px;"/>
												<input type="hidden" id="s_cat_hid" name="s_cat_hid"/>
											</td>
										</tr>
										<tr>
											<td>Settu Item</td>
											<td>
												<input type="text" class="input_txt" id="settu_item" name="settu_item" style="width:125px;" readonly="readonly" />
											</td>
											<td> 
												<input type="text" class="hid_value" id="settu_item_des" name="settu_item_des" style="width:200px;"/>
											</td>
										</tr>
									</table>
								</div>


							</div>

						</td>
						<td colspan="2">
							<div id="tabs" style="width:600px">
								<ul>
									<li><a href="#tabs-1" >Guarantor 1</a></li>
									<li><a href="#tabs-2" >Guarantor 2</a></li>

								</ul>
								<div id="tabs-1">
									<input type="text" class="input_txt ld" title="" id="guarantor_1" name="guarantor_1" />
									<input type="text" class="hid_value" placeholder='Guarantor 1' readonly="readonly" id="guarantor_1_des"  style="width: 250px;">    
								</div>
								<div id="tabs-2">
									<input type="text" class="input_txt ld" title="" id="guarantor_2" name="guarantor_2"/>
									<input type="text" class="hid_value" placeholder='Guarantor 2' readonly="readonly" id="guarantor_2_des"  style="width: 250px;">
									<input type='hidden' id='transCode' value='6' title='6'/>
								</div>
							</div>
						</td>
					</tr>
				</table>

				<table style="width:100%;margin-bottom:1px;margin-top:1px;">
					<tr>

					</tr>
				</table>

				<tr>
					<td colspan="4" style="text-align: center;">
						<table style="width: 98%;" id="tgrid">
							<thead>
								<tr>

									<th class="tb_head_th" style="width: 120px;">Item Code</th>
									<th class="tb_head_th">Item Name</th>
									<th class="tb_head_th"  style="width: 80px;">Modle</th>
									<th class="tb_head_th"  style="width: 60px;">Batch</th>
									<th class="tb_head_th"  style="width: 80px;">Qty</th>
									<th class="tb_head_th"  style="width: 80px;">D.Qty</th>
									<th class="tb_head_th"  style="width: 40px;">FOC</th>
									<th class="tb_head_th"  style="width: 80px;">Price</th>
									<th class="tb_head_th"  style="width: 60px;">Discount (Value)</th>
									<th class="tb_head_th"  style="width: 60px;">Discount (%)</th>
									<th class="tb_head_th" style="width: 80px;">Amount</th>
									<th class="tb_head_th" style="width: 40px;">Warrenty</th>
									<th class="tb_head_th" style="width: 100px;">Serials</th>
									<th class="tb_head_th" style="width: 20px;">Is Free</th>
									<input type='hidden' id='transtype' title='HP SALES' value='HP SALES' name='transtype' />
								</tr>
							</thead><tbody>
							<?php
								//if will change this counter value of 25. then have to change edit model save function.
							for($x=0; $x<25; $x++){
								$y = $x + 1;
								echo "<tr>";


								echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
								<input type='text'     style='width:100%;' class='g_input_txt fo item_code' id='0_".$x."' name='0_".$x."'/></td>";
								echo "<td class='g_col_fixed'>
								<input type='button'  class='subs' id='sub_".$x."' style='margin:0;padding:5px;float: right; height:6px;width:6px;cursor:pointer'/>
								<input type='text' style='width:100%;' class='g_input_txt g_col_fixed' id='n_".$x."' readonly='readonly' style='width:100%;'/>
								<input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
								<input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
								<input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
								<input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />

							</td>";
							echo "<td><input type='text' style='width:100%;' class='g_input_txt g_col_fixed' id='1_".$x."' name='1_".$x."' readonly='readonly'/></td>";
							echo "<td class='g_col_fixed'>
							<input type='button'  class='qunsb' id='btnb_".$x."' style='margin:0;padding:5px;float:left;height:6px;width:6px;cursor:pointer'/>
							<input type='text' style='width:100%;float:right;' class='g_input_num g_col_fixed btt_".$x."' id='6_".$x."' name='6_".$x."' readonly='readonly'/></td>";
							echo "<td>
							<input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float:left; height:6px;width:6px;cursor:pointer'/>
							<input type='text' style='width:44px;float:right;' class='g_input_num qty qtycl".$x."' id='7_".$x."' name='7_".$x."' />
						</td>";
						echo "<td><input type='text' class='g_input_num qty' id='55_".$x."' name='55_".$x."' style='width : 100%;'/></td>";
						echo "<td><input type='text' style='width:100%;' class='g_input_num foc' id='8_".$x."' name='8_".$x."'/></td>";
						echo "<td><input type='text' style='width:100%;' class='g_input_amo price' id='2_".$x."' name='2_".$x."' /></td>";
						echo "<td><input type='text' style='width:100%;' class='g_input_amo dis' id='3_".$x."' name='3_".$x."' /></td>";
						echo "<td><input type='text' style='width:100%;' class='g_input_num g_col_fixed' id='9_".$x."' name='9_".$x."' readonly='readonly'/></td>";
						echo "<td style='width:40px;'><input type='text' style='width:100%;' class='g_input_amo  amount  g_col_fixed' id='4_".$x."' name='4_".$x."' readonly='readonly'/></td>";
						echo "<td>
						<input type='text' style='width:100%;' class='g_input_txt' id='5_".$x."' name='5_".$x."' />
						<input type='hidden' id='f_".$x."' name='f_".$x."' style='width : 100%;'/>
						<input type='hidden' id='bal_free_".$x."' name='bal_free_".$x."' style='width : 100%;'/>
						<input type='hidden' id='bal_tot_".$x."' name='bal_tot_".$x."' style='width : 100%;'/>
						<input type='hidden' id='free_price_".$x."' name='free_price_".$x."' style='width : 100%;'/>
						<input type='hidden' id='issue_qty_".$x."' name='issue_qty_".$x."' style='width : 100%;'/>
						<input type='hidden' id='item_min_price_".$x."' name='item_min_price_".$x."'/>
						<input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' />
						<input type='hidden' id='itm_status_".$x."' title='0' value='0' name='itm_status_".$x."' />
					</td>";
					echo "<td style=''><input type='text' id='serial_".$x."' name='serial_".$x."' class='g_input_txt' style='width:100%;'/></td>"; 
					echo "<td style=''><input type='checkbox' id='free_".$x."' class='freitm' name='free_".$x."' style='width:100%;'/></td>";      
					echo "</tr>";
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</tfoot>
		</table>

		<div style="margin-top:1px;">
			<table border="0" style="width:100%;">
				<tr>
					<td rowspan="3" colspan="3">
						<table style="width:100%;" id="tgrid2" >
							<thead>
								<tr>
									<th class="tb_head_th" style="width: 50px;">Type</th>
									<th class="tb_head_th">Description</th>
									<th class="tb_head_th" style="width: 50px;">Rate%</th>
									<th class="tb_head_th" style="width: 50px;">Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($x=0; $x<15; $x++){
									echo "<tr>";
									echo "<td><input type='hidden' name='hh_".$x."' id='hh_".$x."' title='0' />
									<input type='hidden' name='hhh_".$x."' id='hhh_".$x."' title='0' />
									<input type='text' class='g_input_txt foo' id='00_".$x."' name='00_".$x."' readonly='readonly' style='width : 100%;' /></td>";
									echo "<td><input type='text' class='g_input_txt g_col_fixed'  id='nn_".$x."' name='nn_".$x."' maxlength='150' style='width : 100%;' readonly='readonly'/></td>";
									echo "<td><input type='text' class='g_input_amo rate' id='11_".$x."' name='11_".$x."' style='width : 100%; text-align:right; '/></td>";

									echo "<td style=''><input type='text' id='tt_".$x."' name='tt_".$x."' class='g_input_amo aa' style='text-align: right;'/></td>";
									echo "</tr>";
								}
								?>

							</tbody>
							<tfoot>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tfoot>

						</table>

						<input type='hidden' name='foc_amount' id="foc_amount" />
						<input type='hidden' name='add_or_subs' id="add_or_subs" />
						<input type='hidden' name='additional_amount' id="additional_amount" />
						<input type='hidden' name='save_status' id="save_status"/>
						<input type='hidden' name='total_discount' id="total_discount" />
						<input type="hidden" name="total_amount" id="total_amount"/>
						<input type='hidden' name='total_interest_amount' id='total_interest_amount' value='0'/>
						<input type="hidden" id="s3" name="s3" title="<?=$sale_price['is_sale_3']?>" />
						<input type="hidden" id="s4" name="s4" title="<?=$sale_price['is_sale_4']?>" />
						<input type="hidden" id="s5" name="s5" title="<?=$sale_price['is_sale_5']?>" />
						<input type="hidden" id="s6" name="s6" title="<?=$sale_price['is_sale_6']?>" />
						<input type="hidden" id="s3_des" name="s3_des" title="<?=$sale_price['def_sale_3']?>" />
						<input type="hidden" id="s4_des" name="s4_des" title="<?=$sale_price['def_sale_4']?>" />
						<input type="hidden" id="s5_des" name="s5_des" title="<?=$sale_price['def_sale_5']?>" />
						<input type="hidden" id="s6_des" name="s6_des" title="<?=$sale_price['def_sale_6']?>" />
					</td>
					<td rowspan="0" valign="top">
						<table>

							<tr>
								<td>Total Amount</td>
								<td>
									<input type="text" id="total_amt" name="total_amt" class="hid_value g_input_amounts"  style="margin-left:25px;" readonly='readonly'/>
									<input type="hidden" id="total_amt2" name="total_amt2" />
								</td>  
							</tr>
							<tr>
								<td>Free Total</td>
								<td><input type="text" id="tot_free" name="tot_free" class="hid_value g_input_amounts"  style="margin-left:25px;" readonly='readonly'/></td>
								<input type="hidden" name="free_tot2" class="hid_value g_input_amounts g_input_amo" readonly="readonly" style="width:120px;" id="free_tot2"/>

							</tr>
							<tr>
								<td>Discount</td>
								<td><input type="text" id="tot_dis" name="tot_dis" class="hid_value g_input_amounts"  style="margin-left:25px;" readonly='readonly'/></td>
							</tr>
							<tr>
								<td>Net Amount</td>
								<td><input type="text" id="net_amt" name="net_amt" class="hid_value g_input_amounts"  style="margin-left:25px;" readonly='readonly'/></td>

							</tr>

						</table>
					</td>

				</tr>


			</table>
			<table>
				<tr>
					<td>Memo</td>
					<td style="width:310px;">
						<input type="text" class="input_txt" title="" id="memo" name="memo" style="width:100%" maxlength="100"/>
					</td>
					<td>Salesman</td>
					<td>
						<input type="text" name="sales_rep" id="sales_rep" style="width:120px;" class="input_active" title=""/>
						<input type="text" id="sales_rep2" style="width:265px;" class="hid_value" readonly="readonly" title=""/>
						<input type="button" id="sales_rep_create" title="..." value="...">
					</td>
				</tr>
						   <!--  <tr>
								<td>Salesman</td>
								<td>
									<input type="text" name="sales_rep" id="sales_rep" style="width:120px;" class="input_active" title=""/>
									<input type="text" id="sales_rep2" style="width:265px;" class="hid_value" readonly="readonly" title=""/>
									<input type="button" id="sales_rep_create" title="..." value="...">
								</td>
							</tr> -->
						</table>                
					</div>
					<div id="tabs3" style="margin-top:20px;">

						<ul>
							<li><a href="#tabs-2">Installment Details</a></li>
							<li><a href="#tabs-1">Installment Schedule</a></li>
							<li><a href="#tabs-4">Period by date</a></li>
						</ul>
						<div id="tabs-2">
							<table width="100%" border="0">
								<tr>
									<td style="width:130px;">Document Charges</td>
									<td style="width:180px;"><input type="text" class="g_input_amo input_active" id="document_charges" name="document_charges" title=""/><input type="hidden" class="g_input_amo input_active" id="sep_bal" name="sep_bal" title="" value=""/></td>
									<td style="width:90px;">No Of Ins.</td>
									<td><input type="text" class="g_input_num input_active" id="num_of_installment" name="num_of_installment" title=""/></td>
									<td>Total Interest</td>
									<td><input type="text" class="hid_value g_input_amo" style="width:150px;border:1px solid black;font-weight: bold;" id="total_interest" name="total_interest" title="" readonly='readonly'/></td>
								</tr>
								<tr>
									<td>Down Payment</td>
									<td><input type="text" class="g_input_amo input_active" id="down_payment" name="down_payment" /></td>
									<td>Rate per month</td>
									<td><input type="text" class="g_input_amo input_active" id="interest_rate" name="interest_rate" /></td>
									<td>Installment</td>
									<td><input type="text" class="hid_value g_input_amo" style="width:150px;border:1px solid black;font-weight: bold;" id="installment" name="installment" title="" readonly='readonly'/></td>
								</tr>
								<tr>
									<td>Balance</td>
									<td>
										<input type="text" class="hid_value g_input_amo" style="width:150px;border:1px solid black;font-weight: bold;" id="balance" name="balance" readonly='readonly'/>
										<input type="hidden" id="min_limit" name="min_limit"/> 
										<input type="hidden" id="max_limit" name="max_limit"/>   
										<input type="hidden" id="dwn_type" name="dwn_type"/>  
										<input type="hidden" id="dwn_py" name="dwn_py"/>                                     
									</td>
									<td>Due Date</td>
									<td>
									<input type="text" class="input_date_down_future" readonly="readonly" name="dueDate" id="dueDate" title="<?=date('Y-m-d')?>" style="width: 100px; text-align:right;"/>
									</td>
									<td><input type="button" clicked="no" id="installment_calc" title="Calculate" value="Calculate"></td>
								</tr>
							</table>
						</div>
						
						<div id="tabs-1">
							<table style="width:100%;" cellpadding="0" border='0' id="installment_det" >

							</table>
						</div>
						<div id="tabs-4">
							<table style="width:100%;" cellpadding="0" border='0' >
								<tr>
									<td>Period by date</td>
									<td><input type="text" class="g_input_num input_active" id="period" name="period" /></td>
								</tr>
							</table>
						</div>
					</div>
					<div style="text-align: left; padding-top: 20px;">
						<input type="button" id="btnshedule" title="...." />
						<input type="button" id="btnExit" title="Exit" />
						<input type="button" id="btnReset" title="Reset" />
						<?php if($this->user_permissions->is_delete('t_hp')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?>
						<?php if($this->user_permissions->is_re_print('t_hp')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>  
						<input type="button" id="btn_agrr" name="btn_agrr" title="Print Agreement"/>                      
						<?php if($this->user_permissions->is_add('t_hp')){ ?><input type="button"  id="btnSave" title="Save" /><?php } ?>
					</div>
				</td>
			</tr>
		</table>
	</form>

	<?php 
	if($this->user_permissions->is_print('t_hp')){ ?>
	<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
	<?php } ?> 
	<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

		<input type="hidden" name='by' value='t_hp' title="t_hp" class="report">
		<input type="hidden" name='page' value='A5' title="A5" >
		<input type="hidden" name='orientation' value='L' title="L" >
		<input type="hidden" name='type' value='hp_sales' title="hp_sales" >
		<input type="hidden" name='header' value='false' title="false" >
		<input type="hidden" name='qno' value='' title="" id="qno" >
		<input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
		<input type="hidden" name="sales_type" id="sales_type" value="" title="" >
		<input type="hidden" name='dt' value='' title="" id="dt" >
		<input type="hidden" name='cus_id' value='' title="" id="cus_id" >
		<input type="hidden" name='salesp_id' value='' title="" id="salesp_id" > 
		<input type="hidden" name='agr_no' value='' title="" id="agr_no" >
	</form>
	<form id="print_agreement" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

		<input type="hidden" name='by' value='t_hp_aggreement' title="t_hp_aggreement" class="report">
		<input type="hidden" name='page' value='A5' title="A5" >
		<input type="hidden" name='orientation' value='L' title="L" >
		<input type="hidden" name='type' value='hp_sales' title="hp_sales" >
		<input type="hidden" name='header' value='false' title="false" >
		<input type="hidden" name='qno1' value='' title="" id="qno1" > 
		<input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
		<input type="hidden" name="sales_type" id="sales_type" value="" title="" >
		<input type="hidden" name='dt' value='' title="" id="dt" >
		<input type="hidden" name='cus_id' value='' title="" id="cus_id" >
		<input type="hidden" name='salesp_id' value='' title="" id="salesp_id" > 
		<input type="hidden" name='aggr_no' value='' title="" id="aggr_no" >
	</form>
</div>
<?php } ?>