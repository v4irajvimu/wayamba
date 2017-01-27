<?php if($this->user_permissions->is_view('t_hp_seized_main_store')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_seized_main_store.js"></script>

<div id="fade" class="black_overlay"></div>

<?php 
if($ds['use_serial_no_items'] ){
	$this->load->view('t_serial_out.php'); 
}
?>

<div id="fade" class="black_overlay"></div>

<h2 style="text-align: center;">Seized Items To Main Stores</h2>
<div class="dframe" id="mframe" style="width:1050px;">
	<form method="post" action="<?=base_url()?>index.php/main/save/t_hp_seized_main_store" id="form_">
		<table style="width: 100%" border="0" cellpadding="0">
			<tr>
				<input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
				<td >Agreement No</td>
				<td width="100"><input type="text" class="input_txt" id="agr_no" title="" name="agr_no"/></td>
				<td colspan="3"></td>
				<td width="50">&nbsp;</td>    
				<td width="50">No</td>
				<td>
					<input type="text" class="input_active_num" style="width:150px;" name="id" id="id" title="<?php echo $nno; ?>" />
					<input type="hidden" id="hid" name="hid" title="0" />
					<input type="hidden" id="total_discount" name="total_discount" title="0" />
					<input type="hidden" id="hp_no" name="hp_no" title="0" />
					<input type="hidden" id="seize_no" name="seize_no" title="0" />

					<input type="hidden" id="cl" name="cl" title="<?=$cl; ?>" />
					<input type="hidden" id="bc" name="bc" title="<?=$bc; ?>" />

					<input type="hidden" id="is_approve" name="is_approve" title="0" />
				</td>
			</tr>
			
			<tr>
				<td>From Store</td>
				<td><input type="text" class="input_txt hid_value store11" id="f_store_code" title="" name="f_store_code"/></td>
				<td><input type="text" class="hid_value" id="f_store_des" title="" style="width:300px;"/></td>
				<td>&nbsp;</td>
				<td></td>
				<td>&nbsp;</td>
				<td>Date</td>
				<td>
					<?php if($this->user_permissions->is_back_date('t_hp_seized_main_store')){ ?>
					<input type="text" class="input_date_down_future" style="width:150px; text-align:right;" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
					<?php }else{ ?> 
					<input type="text" class="input_txt" style="width:150px; text-align:right;" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" /> 
					<?php } ?>      
				</td>	
			</tr>

			<tr>
				<td>To Store</td>
				<td><input type="text" class="input_number" name="to_store" id="to_store" style="width:150px"/></td>
				<td><input type="text" class="hid_value" id="t_store_des" title="" style="width:300px;"/></td>
				<td>&nbsp;</td>
				<td></td>
				<td>&nbsp;</td>
				<td>Ref No</td>
				<td> <input type="text" class="input_txt" id="ref_no" name="ref_no"></td>	
			</tr>
		</table>
		<table>
			<tr>
				<td width=580px;>
					<fieldset>
						<legend>HP Details</legend>
						<table>
							<tr>
								<td>Amount</td>
								<td><input type="text" class="input_active g_input_amo hid_value" id="agr_amount"  name="agr_amount" title="" style="width:100px;"/></td>
								<td>Arrears Amount</td>
								<td><input type="text" class="input_active g_input_amo hid_value" id="ar_amount"  name="ar_amount" title="" style="width:100px;"/></td>
								<td>Paid Amount</td>
								<td><input type="text" class="input_active g_input_amo hid_value" id="paid_amount"  name="paid_amount" title="" style="width:100px;"/></td>
							</tr>

						</table>
					</fieldset>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td colspan="8" style="text-align: center;">
				<table style='width: 875px;' id='tgrid'>
					<thead>
						<tr>
							<th class='tb_head_th' style='width: 30px;'>Seized No</th>
							<th class='tb_head_th' style='width: 70px;'>Item Code</th>
							<th class='tb_head_th' style='width: 180px;'>Item Name</th>
							<th class='tb_head_th' style='width: 60px;'>Qty</th>
							<th class='tb_head_th' style='width: 60px;'>Cost</th>
							<th class='tb_head_th' style='width: 60px;'>Last Price</th>
							<th class='tb_head_th' style='width: 60px;'>Max Price</th>
						</tr>
					</thead>
				<tbody>

				<?php	
				for($x=0; $x<25; $x++){
					echo "<tr class='cl1'>";
					echo "<td><input type='text' style='width:100%;' class='g_input_num g_col_fixed' id='sno_".$x."'  style='width : 100%;'/></td>";
					echo "<td><input type='text' class='g_input_txt g_col_fixed' id='icode_".$x."' style='width : 100%;'/></td>";
					echo "<td><input type='text' class='g_input_txt g_col_fixed' id='iname_".$x."' style='width : 100%;'/></td>";
					echo "<td><input type='text' class='g_input_num g_col_fixed' id='qty_".$x."'  style='width : 100%;'/></td>";
					echo "<td><input type='text' class='g_input_amo g_col_fixed' id='cost_".$x."'  style='width : 100%;'/></td>";
					echo "<td><input type='text' class='g_input_amo g_col_fixed' id='lprice_".$x."' style='width : 100%;'/></td>";
					echo "<td><input type='text' class='g_input_amo g_col_fixed' id='mprice_".$x."' style='width : 100%;'/></td>";
					echo "<td style='display: none;'><input type='hidden' id='btt_".$x."' /></td>";
					echo "</tr>";
				}
				?>
				</tbody>
				</table>

				<table style="width: 875px;" id="tgrid1">
					<thead>
						<tr>
							<th class="tb_head_th" style="width: 70px;">Item Code</th>
							<th class="tb_head_th" style='width: 180px;'>Item Name</th>
							<th class="tb_head_th" style="width: 60px;">Batch</th>
							<th class="tb_head_th" style="width: 60px;">Qty</th>
							<th class="tb_head_th" style="width: 60px;">Cost</th>
							<th class="tb_head_th" style="width: 60px;">Last Price</th>				
							<th class="tb_head_th" style="width: 60px;">Max Price</th>
							<th class="tb_head_th" style="width: 60px;">Amount</th>
						</tr>
					</thead><tbody>
					<?php
					for($x=0; $x<25; $x++){
						echo "<tr class='cl'>";
						echo "<td><input type='text' class='g_input_txt g_col_fixed fo' id='0_".$x."' name='0_".$x."' style='width : 100%;'/></td>";
						echo "<td><input type='text' class='g_input_txt g_col_fixed' id='siname_".$x."' name='siname_".$x."' style='width : 100%;'/></td>";
						echo "<td><input type='text' class='g_input_num btt_".$x."' id='bt1_".$x."' name='bt1_".$x."' style='width : 100%;'/></td>";
						echo "<td>
								<input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
								<input type='text' class='g_input_num qty qtycl".$x." ' id='sqty_".$x."'  name='sqty_".$x."' style='width : 80%;float: right;'/>
						</td>";	
						echo "<td><input type='text' class='g_col_fixed g_input_amo' id='scost_".$x."'  name='scost_".$x."' style='width : 100%;'/></td>";
						echo "<td><input type='text' class='g_col_fixed g_input_amo' id='slprice_".$x."' name='slprice_".$x."' style='width : 100%;'/></td>";
						echo "<td><input type='text' class='g_col_fixed g_input_amo' id='smprice_".$x."' name='smprice_".$x."' style='width : 100%;'/></td>";
						echo "<td>
								<input type='text' class='g_input_amo g_col_fixed' id='samount_".$x."' name='samount_".$x."' style='width : 100%;'/>
								<input type='hidden' name='bt_".$x."' id='bt_".$x."' />
								<input type='hidden' name='maxqty_".$x."' id='maxqty_".$x."' />
								<input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
						        <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
						        <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
						        <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />  
							</td>";
						echo "</tr>";
			}
			?>
		</tbody>
		<tfoot>
			<table border="0" width="100%">
				<tr>			
					<td width="815px;"></td>
					<td style="font-weight: bold; font-size: 12px;">Total Amount
						<input type='text' class='hid_value g_input_amounts' id='gross_amount' name='gross_amount' style="margin-right: 15px; margin-left: 5px;" /></td>
					</tr>
				</table>
			</tfoot>
			<fieldset>
				<legend>Customer Credit Note Details</legend>
				<table border="0">
					<tr>
						<td>Customer </td>
						<td width="750px;"><input type="text" class = "input_txt" name="cus_id" id="cus_id"/>
							<input type="text" id="cus_name" class="hid_value" style="width:300px;"> </td>
							<td>CN No 
								<input type="text" class="input_active_num" title="<?=$crn_no?>" id="cn_no" name="cn_no" style="margin-left:5px;"></td>
							</tr>
							<tr>
								<td>Dr. Account </td>
								<td><input type="text" name="dr_acc" id="dr_acc" class="hid_value input_txt">
									<input type="text" id="acc_des" class="hid_value" style="width:300px;"> </td>
									<td>CRN Amount
										<input type="text" class="g_input_amounts g_input_amo" id="amt" name="amt" style="border: 1px solid #0040ff; width:100px;"> </td>
									</tr>

								</table>

							</fieldset>

						</table border="0">
						<div style="text-align: right; padding-top: 7px;">
							<input type="button" id="btnExit" title="Exit" />
							<input type="button" id="btnReset" title="Reset" />
							<input type="hidden" name="srls" id="srls"/>
							<input type='hidden' id='transCode' value='118' title='118'/>
							<?php if($this->user_permissions->is_re_print('t_hp_seized_main_store')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
							<?php if($this->user_permissions->is_delete('t_hp_seized_main_store')){ ?><input type="button" id="btnDelete5" title="Cancel" /><?php } ?>
							<?php if($this->user_permissions->is_add('t_hp_seized_main_store')){ ?><input type="button"  id="btnSave" title='Save <F8>' /><?php } ?>
							<?php if($this->user_permissions->is_approve('t_hp_seized_main_store')){ ?><input type="button"  id="btnApprove" title='Approve' /><?php } ?>
							<input type='hidden' id='app_status' name='approve' title='1' value='1'/>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="6"><font color="red">** For View Item Details, Double Click Item Code</font></td>
				</tr>
			</table>
			<?php 
			if($this->user_permissions->is_print('t_hp_seized_main_store')){ ?>
			<input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
			<?php } ?>
		</form>




		<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
			<input type="hidden" name='by' value='t_hp_seized_main_store' title="t_hp_seized_main_store" class="report">
			<input type="hidden" name='page' value='A4' title="A4" >
			<input type="hidden" name='orientation' value='P' title="P" >
			<input type="hidden" name='header' value='false' title="false" >
			<input type="hidden" name='qno' value='' title="" id="qno" >
			<input type="hidden" name='dt' value='' title="" id="dt" >
		</form>

	</div>
	<?php } ?>
