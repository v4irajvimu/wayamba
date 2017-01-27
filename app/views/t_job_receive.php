<?php if($this->user_permissions->is_view('t_job_receive')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_job_receive.js"></script>

<h2 style="text-align: center;">Job Recieve From Supplier</h2>
<div class="dframe" id="mframe" style="width:1200px">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_job_receive" id="form_">
        <table style="width: 100%" border="0">
            <tr>
                <td style="width: 100px;">Supplier</td>
                <td>
                	<input type="text" class="input_txt" id="supplier" name="supplier">
                    <input type="text" class="hid_value" title='' name="sup_name" readonly="readonly" id="sup_name"  style="width: 300px;">
                </td>
                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" class="input_active_num" style="width:100%" name="id" id="id" title='<?=$max_no?>'/>
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>

            </tr><tr>
                <td>Comment</td>
                <td>
                    <input type="text" class="input_txt" name="comment" id="comment" title="" style="width: 455px;"/></td>
                <td style="width: 100px;">Date</td>
                <td style="width: 100px;">
                    <?php if($this->user_permissions->is_back_date('t_job_receive')){ ?>
                        <input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php } else { ?>    
                        <input type="text" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" />
                    <?php } ?>    
                </td>
            </tr>

            <tr>
                <td>Search</td>
                <td><input type="text" class="input_txt" id="search_job" name="search_job" title="" style="width:455px;"></td>
                <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%;"/></td>
           
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td style="width: 100px;">CRN No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="crn" id="crn" title="" style="width: 100%;"/></td>
           
            </tr>

          <tr>
                <td colspan="4" style="text-align: center;">
                	<div>
                    <table style="width: 100%;" id="tgrid">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 10px;"> </th>
                                <th class="tb_head_th" style="width: 50px;">Job No</th>
                                <th class="tb_head_th" style="width: 80px;">Receive Date</th>
                                <th class="tb_head_th">Item</th>
                                <th class="tb_head_th" style="width: 80px;">Send Date</th>
                                <th class="tb_head_th">Fault</th>
                                <th class="tb_head_th" style="width: 80px;">Warranty Start Date</th>
                                <th class="tb_head_th" style="width: 80px;">Warranty Expire Date</th>
                                <th class="tb_head_th" style="width: 80px;">Amount</th>
                               
                            </tr>
                        </thead><tbody>
                            <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                                for($x=0; $x<25; $x++){
                                    echo "<tr>";
                                    echo "<td style='text-align:center;'><input type='checkbox' id='sel_".$x."' name='sel_".$x."' value='1' class='chk'></td>";
                                        echo "<td><input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                                <input type='text' class='g_input_num2 ' id='0_".$x."' name='0_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt'  id='n_".$x."' name='n_".$x."' maxlength='150'readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt' id='1_".$x."' name='1_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_txt ' id='2_".$x."' name='2_".$x."' readonly='readonly' style='width:100%;'/></td>";
                                  		echo "<td><input type='text' class='g_input_txt' id='3_".$x."' name='3_".$x."'readonly='readonly' style='width:100%;'/></td>";
                                        echo "<td><input type='text' class='g_input_amo amo' id='4_".$x."' name='4_".$x."' readonly='readonly' style='width:100%;'/></td>";           
                                        echo "<td><input type='text' class='g_input_amo amo' id='5_".$x."' name='4_".$x."' readonly='readonly' style='width:100%;'/></td>";           
                                        echo "<td><input type='text' class='g_input_amo amo amt' id='6_".$x."' name='5_".$x."' style='width:100%;' readonly='readonly'/></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                                               
                    </table>
                </div>
			</td>

            </tr>
      

            <tr>
            	<td colspan="4">
					 		<div style="text-align: left; padding-top: 7px;">
					                        <input type="button" id="btnExit" title="Exit" />
					                        <input type="button" id="btnReset" title="Reset" />
					                        <?php if($this->user_permissions->is_delete('t_job_receive')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
					                        <?php if($this->user_permissions->is_re_print('t_job_receive')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
					                        <?php if($this->user_permissions->is_add('t_job_receive')){ ?>
					                        <input type="button" id="btnSave" title='Save <F8>' />
					                        	
					                        <?php } ?>

					                        <span style="margin-left:650px;"><b>Total Amount</b></span>
					                        <input type="text" name="amount" class="hid_value g_input_amounts" id="amount"/>
					                        
                    		</div>
                
            	</td>


            </tr>
        </table>
    </form>
    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
        <input type="hidden" name='by' value='t_job_receive' title='t_job_receive' class="report">
        <input type="hidden" name='orientation' value="L" title="L">
        <input type="hidden" name='header' value='false' title='false'>
        <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
        <input type="hidden" name='dt' value='' title="" id="dt" >
        <input type="hidden" name='type' value='service_reject' title="service_reject" >
        <input type="hidden" name='page' value='A5' title="A5" >
        <input type="hidden" name='org_print' value='' title="" id="org_print">
        <input type="hidden" name='qno' value='' title="" id="qno" >
    </form>
</div>
<?php } ?>