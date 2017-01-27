<?php if($this->user_permissions->is_view('r_internal_transfer')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_internal_transfer.js'></script>
<h2>Internel Transfer Reports</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
            <div class="form" id="form">
                <form action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
		    <table>
		    <tr><td>Date </td><td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
            To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td></tr>
            


             <tr>
                <td style="width:83px;">Cluster</td>
                <td><?php echo $cluster; ?></td>
            </tr>

            <tr>
                <td>Branch</td>
                <td>
                    <select name='branch' id='branch' >
                        <option value='0'>---</option>
                    </select>
                    <!-- <?php echo $branch; ?> -->
                </td>
             </tr>
             
             <tr>
	
            <?php if($this->user_permissions->is_view('r_int_tr_sum')){ ?> 	
            <tr>
			    <td colspan="2">
                      <input type='radio' name='by' value='r_internal_transfer_summary' title="r_internal_transfer_summary" class="report"/>Internal Transfer Summary
                </td>
			    
			</tr>
			<?php } ?>

            <?php if($this->user_permissions->is_view('r_int_tr_det')){ ?>  
            <tr>
                <td colspan="2">
                      <input type='radio' name='by' value='r_int_tr_det' title="r_int_tr_det" class="report"/>Internal Transfer Details
                </td>
                
            </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_int_tr_rec_sum')){ ?>  
            <tr>
                <td colspan="2">
                      <input type='radio' name='by' value='r_int_tr_rec_sum' title="r_int_tr_rec_sum" class="report"/>Internal Transfer Receive Summary
                </td>
                
            </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_int_tr_rec_det')){ ?>  
            <tr>
                <td colspan="2">
                      <input type='radio' name='by' value='r_int_tr_rec_det' title="r_int_tr_rec_det" class="report"/>Internal Transfer Receive Details 
                </td>
                
            </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_int_tr_order_sum')){ ?>  
            <tr>
                <td colspan="2">
                      <input type='radio' name='by' value='r_int_tr_order_sum' title="r_int_tr_order_sum" class="report"/>Internal Transfer Order Summary
                </td>
                
            </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_int_tr_order_det')){ ?>  
            <tr>
                <td colspan="2">
                      <input type='radio' name='by' value='r_int_tr_order_det' title="r_int_tr_order_det" class="report"/>Internal Transfer Order Details 
                </td>
                
            </tr>
            <?php } ?>

			<tr>
			    <td colspan="3" style="text-align: right;">
                <input type="hidden" name="type" id="type"  title=""/>
				<input type="button" title="Exit" id="btnExit" value="Exit">
				
				 <button id="btnPrint">Print PDF</button>
			    </td>
			</tr>
            <input type="hidden" id="d_cl" title='<?php echo $d_cl ?>' name="d_cl"/>
            <input type="hidden" id="d_bc" title='<?php echo $d_bc ?>' name="d_bc"/>
		    </table>

                 <input type="hidden" name='page' value='A4' title="A4" >
                 <input type="hidden" name='orientation' value='P' title="P" >
                 <input type="hidden" name='type' value='19' title="19" >
                 <input type="hidden" name='header' value='false' title="false" >
                 <input type="hidden" name='qno' value='' title="" id="qno" >
                 <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
                 <input type="hidden" name='dt' value='' title="" id="dt" >
                 
                </form>
            </div>
       
</table>
<?php } ?>