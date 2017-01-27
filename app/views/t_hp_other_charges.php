<?php if($this->user_permissions->is_view('t_hp_other_charges')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_other_charges.js"></script>

<h2 style="text-align: center;">HP Other Chargers</h2>
<div class="dframe" id="mframe">
<form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_hp_other_charges" >
        <table style="width: 100%" border="0">
            <tr>
              
                <td style="width: 100px;">Agreement No</td>
                <td>
                	<input type="text" class="input_txt" title='' name="agri_no" id="agri_no"  style="width: 150px;">
                </td>
            
                            
                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" style="width:100%" class="input_active_num" name="id" id="id" title="<?=$max_no?>" />
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>

            </tr>
            <tr>
                <td>Customer</td>
                <td>
                    <input type="text" class="hid_value" readonly="readonly" name="customer" id="customer" title="" style="width: 150px;"/>
                    <input type="text" class="hid_value" name="customer_des" readonly="readonly" id="customer_des"  style="width: 300px;">
                </td>
                <td style="width: 100px;">Date</td>
                <td style="width: 100px;">
                    <?php if($this->user_permissions->is_back_date('t_hp_other_charges')){ ?>
                        <input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align:right;"/>
                    <?php } else { ?>
                        <input type="text" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align:right;"/>
                    <?php } ?>    
                </td>
            </tr>

            <tr>
                <td>Invoice No</td>
                <td>
                    <input type="text" class="hid_value" name="inv_no" id="inv_no" title="" style="width: 150px;"/>
                    <span style="margin-left:14%;">
                    Invoice Date
                    <input type="text" class="hid_value" readonly="readonly" name="inv_date" id="inv_date" title="" style="width: 150px;"/>
                    </span>
                </td>
                <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;">
                   <input type="text" class="input_txt" name="ref_no" id="ref_no" style="width:100%;"/>
                </td>
           
            </tr>
           
          <tr>
                <td colspan="4" style="text-align: center;">
                	
                    <table style="width: 875px;" id="tgrid">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 100px;">Type</th>
                                <th class="tb_head_th">Description</th>
                                <th class="tb_head_th" style="width: 350px;">Description</th>
                                <th class="tb_head_th" style="width: 80px;">Amount</th>
                               
                            </tr>
                        </thead><tbody>
                            <?php
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                                <input type='text' class='g_input_txt fo' id='0_".$x."' name='0_".$x."'  /></td>";
                                        echo "<td><input type='text' class='hid_value' readonly='readonly' id='n_".$x."' name='n_".$x."' style='width:100%;'/>
                                                  <input type='hidden' id='acc_".$x."' name='acc_".$x."'/>  
                                              </td>";
                                        echo "<td><input type='text' class='g_input_txt' id='1_".$x."' name='1_".$x."' style='width:100%;'/></td>";
                                        echo "<td><input type='text' style='width:100%' class='g_input_amo price' id='2_".$x."' name='2_".$x."' /></td>";
                                  
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                                               
                    </table>
               
			</td>

            </tr>
            <tr>
                <td>Note</td>
            	<td>
                    <textarea id='note' style="width:400px;" class="input_txt" name='note' rows='1'></textarea>
            		</td>
                    <td colspan="2">
            		<span style="text-align:right;margin-right:10px;"><b>Total Amount</b>

					<input type="text" class="hid_value g_input_amounts" name="net" id="net" style="width:100px;"/>
					                    
					</span>
            	</td>
            </tr>

            <tr>
            	<td colspan="4">
					 		<div style="text-align: left; padding-top: 7px;">
    	                        <input type="button" id="btnExit" title="Exit" />
    	                        <input type="button" id="btnReset" title="Reset" />
    	                        <?php if($this->user_permissions->is_delete('t_hp_other_charges')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?>
    	                        <?php if($this->user_permissions->is_re_print('t_hp_other_charges')){ ?> <input type="button" id="btnPrint" title="Print" /><?php } ?>
    	                        <?php if($this->user_permissions->is_add('t_hp_other_charges')){ ?>
    	                        <input type="button"  id="btnSave" title='Save <F8>' />		
    	                        <?php } ?>
                                
					                        
                    		</div>
                
            	</td>
                <?php 
                    if($this->user_permissions->is_print('t_hp_other_charges')){ ?>
                    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                <?php } ?> 

            </tr>
        </table>
    </form>
    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
       <input type="hidden" name='by' value='t_hp_other_charges' title="t_hp_other_charges" class="report">
       <input type="hidden" name='page' value='A4' title="A4" >
       <input type="hidden" name='orientation' value='P' title="P" >
       <input type="hidden" name='type' value='t_voucher' title="t_voucher" >
       <input type="hidden" name='recivied' value='' title=""  id='recivied'>
       <input type="hidden" name='header' value='false' title="false" >
       <input type="hidden" name='qno' value='' title="" id="qno">
       <input type="hidden" name='voucher_type' value='' title="" id="voucher_type">
       <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
       <input type="hidden" name="sales_type" id="sales_type" value="" title="" >
       <input type="hidden" name='dt' value='' title="" id="dt" >
       <input type="hidden" name='supp_id' value='' title="" id="supp_id" >
       <input type="hidden" name='p_hid_nno' value='' title="" id="p_hid_nno">
       <input type="hidden" name='voucher_no' value='' title="" id="voucher_no">
       <input type="hidden" name='category_id' value='' title="" id="category_id">
       <input type="hidden" name='cat_des' value='' title="" id="cat_des">
       <input type="hidden" name='group_id' value='' title="" id="group_id">
       <input type="hidden" name='group_des' value='' title="" id="group_des">
       <input type="hidden" name='ddate' value='' title="" id="ddate">
       <input type="hidden" name='tot' value='' title="" id="tot">
       <input type="hidden" name='acc_code' value='' title="" id="acc_code">
       <input type="hidden" name='acc_des' value='' title="" id="acc_des">
       <input type="hidden" name='vou_des' value='' title="" id="vou_des">

    </form>
</div>
<?php } ?>