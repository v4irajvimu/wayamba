<?php if($this->user_permissions->is_view('r_debiter_list')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_debiter_list.js'></script>
<script type='text/javascript' src='<?=base_url()?>js/m_client_application.js'></script>
<h2>Debitor Reports</h2>
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
             <input type="hidden" id="d_cl" title='<?php echo $d_cl ?>' name="d_cl"/>
             <input type="hidden" id="d_bc" title='<?php echo $d_bc ?>' name="d_bc"/>

            <tr>
                <td>Supplier Status</td>
                <td>
                  <select name='s_status' id='s_status'>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                    <option value="3">All</option>
                  </select>
                </td>
            </tr>

             <tr>
                <td style="width: 100px;">Type</td>
                <td>
                    <input type="text" class="input_active" id="cus_type" name="cus_type"title="" />
                   
                    <input type="text" class="hid_value" id="type" title="" style="width:300px;" readonly='readonly'/>
                </td>
             </tr>
             <tr>
                <td style="width: 100px;">Customer</td>
                <td>
                    <input type="text" class="input_active" id="cus_id" name="cus_id"title="" />
                   
                    <input type="text" class="hid_value" id="customer" title="" style="width:300px;" readonly='readonly'/>
                </td>
             </tr>
             
             <tr>
                <td style="width: 100px;">Category</td>
                <td>
                    <input type="text" class="input_active" id="cus_category" name="cus_category"title="" />
                   
                    <input type="text" class="hid_value" id="category" title="" style="width:300px;" readonly='readonly'/>
                </td>
             </tr>
             <tr>
                <td style="width: 100px;">Area</td>
                <td>
                    <input type="text" class="input_active" id="area_code" name="area_code"title="" />
                   
                    <input type="text" class="hid_value" id="area" title="" style="width:300px;" readonly='readonly'/>
                </td>
             </tr>
             <tr>
                <td style="width: 100px;">Town</td>
                <td>
                    <input type="text" class="input_active" id="town_id" name="town_id"title="" />
                   
                    <input type="text" class="hid_value" id="town_name" title="" style="width:300px;" readonly='readonly'/>
                </td>
             </tr>
             <tr>
                <td style="width: 100px;">Root</td>
                <td>
                    <input type="text" class="input_active" id="root_id" name="root_id"title="" />
                   
                    <input type="text" class="hid_value" id="root_name" title="" style="width:300px;" readonly='readonly'/>
                </td>
             </tr>

             <tr>
	
            <?php if($this->user_permissions->is_view('r_customer_list')){ ?> 	
            <tr>
			    <td colspan="2">
                      <input type='radio' name='by' value='r_customer_list' title="r_customer_list" class="report"/>Customer List 01</td>
			    
			</tr>
			<?php } ?>

            <?php if($this->user_permissions->is_view('r_customer_list2')){ ?>  
            <tr>
                <td colspan="2">
                      <input type='radio' name='by' value='r_customer_list2' title="r_customer_list2" class="report"/>Customer List 02</td>
                
            </tr>
            <?php } ?>

			<?php if($this->user_permissions->is_view('r_customer_area_list')){ ?> 
			<tr>
			<td colspan="2">
                    	<input type='radio' name='by' value='r_customer_area_list' title="r_customer_area_list" class="report"/>Customer Area List</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_customer_town_list')){ ?> 
			<tr>
			    <td colspan="2">
                    	<input type='radio' name='by' value='r_customer_town_list' title="r_customer_town_list" class="report"/>Customer Town List</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_customer_balances')){ ?> 
			<tr>
			    <td colspan="2">
                    	<input type='radio' name='by' value='r_customer_balances' title="r_customer_balances" class="report"/>Customer Balance</td>
			    
			</tr>
			<?php } ?>

			<?php if($this->user_permissions->is_view('r_customer_analysis')){ ?> 
			<tr>
				<td colspan="2">
                <input type='radio' name='by' value='r_customer_analysis' title="r_customer_analysis" class="report"/>Customer Age Analysis Report</td>
			</tr>
			<?php } ?>
			

			<tr>
			    <td colspan="3" style="text-align: right;">
                <input type="hidden" name="type" id="type"  title=""/>
				<input type="button" title="Exit" id="btnExit" value="Exit">
				
				 <button id="btnPrint">Print PDF</button>
			    </td>
			</tr>
		    </table>

                 <input type="hidden" name='page' value='A4' title="A4" >
                 <input type="hidden" name='orientation' value='P' title="P" >
                 <input type="hidden" name='type' value='19' title="19" >
                 <input type="hidden" name='header' value='false' title="false" >
                 <input type="hidden" name='qno' value='' title="" id="qno" >
                 <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
                 <input type="hidden" name='dt' value='' title="" id="dt" >
                 <input type="hidden" name='cu_id' value='' title="" id="cu_id" >
                 <input type="hidden" name='are_id' value='' title="" id="are_id" >
                </form>
            </div>
       
</table>
<?php } ?>