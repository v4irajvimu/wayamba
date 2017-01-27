<?php if($this->user_permissions->is_view('r_account_report')){ ?>
<h2 style="text-align: center;">Account Report </h2>
<link rel="stylesheet" href="<?=base_url()?>css/report.css" />
<script type="text/javascript" src="<?=base_url()?>js/r_account_report.js"></script>

<div class="dframe" id="r_view2" style="width: 1000px;">
    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
   
    <fieldset>
        <legend>Date</legend>
        <table>
            <tr>
                <td><font size="2">From</font></td>
                <td><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" /></td>
                <td style="padding-left:40px;"><font size="2">To</font></td>
                <td><input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td>
            </tr>
        </table>
    </fieldset>    




    <fieldset >
        <legend >Category</legend>
        <div id="report_view" style="overflow: auto;">



        <table border="0" cellpadding="0" cellspacing="0" id="cl_bc" style="font-size: 12px;">        
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
        </table>

        <table border="0" cellpadding="0" cellspacing="0" id="acc_table" style="font-size: 12px;">          
            <?php if(false){ ?> <tr>
                            <td style="width:83px;">Account Type</td>
                            
                            <td><input type="text" class="input_txt" title="" id="acc_type" name="acc_type"/>
                                <input type="text" class="hid_value"  readonly="readonly" id="acc_type_des"  style="width: 250px;">
                            </td>
                            <td><input type="button" title="Add" value="Add" id="add_acc_type"/></td>
                        </tr>
                        <tr>
                            <td style="width:83px;">Account Category</td>
                           
                            <td><input type="text" class="input_txt" title="" id="acc_cat" name="acc_cat" />
                                <input type="text" class="hid_value"  readonly="readonly" id="acc_cat_des"  style="width: 250px;">
                            </td>
                            <td><input type="button" title="Add" value="Add" id="add_acc_cat"/></td>
                        </tr>
                        
                        <tr>
                            <td style="width:83px;">Controll Account</td>
                            
                            <td><input type="text" class="input_txt" title="" id="cntrl_acc" name="cntrl_acc"/>
                                <input type="text" class="hid_value"  readonly="readonly" id="cntrl_acc_des" style="width: 250px;"></td>
                            <td><input type="button" title="Add" value="Add" id="add_cntrl_acc"/></td>                    
                            </tr>

                            
            <?php } ?>
                            <tr id="account_c">
                            <td style="width:83px;">Account Code</td>
                           
                            <td><input type="text" class="input_txt" title="" id="acc_code" name="acc_code" />
                                <input type="text" class="hid_value"  readonly="readonly" id="acc_code_des"  style="width: 250px;">

                            </td>

                            <?php if(false){ ?> <td><input type="button" title="Add" value="Add" id="add_acc_code"/></td>   <?php } ?>
                            

                        </tr>

                        <tr id="trans_type">
                            <td style="width:83px;">Trans Type</td>
                            <td><input type="text" class="input_txt" title="" id="t_type" name="t_type" />
                                <input type="text" class="hid_value"  readonly="readonly" id="t_type_des"  style="width: 250px;">
                            </td>
                            <td style="padding-left:50px; padding-right:15px;">Trans Number Range</td>
                            <td>
                                <input type="text" class="g_input_num input_txt_f" id="t_range_from" name="t_range_from" style="width:35px;"/> To 
                                <input type="text" class="g_input_num input_txt_f" id="t_range_to" name="t_range_to" style="width:35px;"/>
                            </td>

                            <?php if(false){ ?> <td><input type="button" title="Add" value="Add" id="add_t_type"/></td>   <?php } ?>
                        </tr>

                         <tr> <td colspan="3"><hr/><td> </tr>
                      


                    </table>
<?php if(false){ ?> 
                    <table style="width:960px"> <tr><td colspan="5"><hr/></td></tr> </table>
                    <table style="width:960px" id="tgrid" border="0" class="tbl">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 50px;">&nbsp;</th>
                                <th class="tb_head_th" style="width: 100px;">No</th>
                                <th class="tb_head_th" style='width: 150px;'>Account Code</th>
                                <th class="tb_head_th" style="width: 200px;">Account Name</th>
                                <th class="tb_head_th" style="width: 100px;">Type</th>
                                <th class="tb_head_th" >Headings</th>
                            </tr>
                        </thead><tbody id="tbl_body">
                       
                            <?php
                                for($x=0; $x<1; $x++){
                                    echo "<tr>";
                                        echo "<td class='check' style='background:#F9F9EC'><input type='checkbox' class='g_input_txt g_col_fixed Checkbox'  id='n_".$x."' name='n_".$x."' /></td>";
                                        echo "<td style='background:#F9F9EC'><input type='text' class='g_input_txt g_col_fixed' id='1_".$x."' name='1_".$x."' style='width:100%;border:1px dotted #ccc;text-align:right;'/></td>";
                                        echo "<td style='background:#F9F9EC'><input type='text' class='g_input_txt g_col_fixed' id='2_".$x."' name='2_".$x."' style='width:100%;border:1px dotted #ccc;text-align:right;'/></td>";
                                        echo "<td style='background:#F9F9EC'><input type='text' class='g_input_txt g_col_fixed' id='3_".$x."' name='3_".$x."' style='width:100%;border:1px dotted #ccc;text-align:right;'/></td>";
                                        echo "<td style='background:#F9F9EC'><input type='text' class='g_input_txt g_col_fixed' id='4_".$x."' name='4_".$x."' style='width:100%;border:1px dotted #ccc;text-align:right;'/></td>";
                                        echo "<td style='background:#F9F9EC'><input type='text' class='g_input_txt g_col_fixed' id='5_".$x."' name='5_".$x."' style='width:100%;border:1px dotted #ccc;text-align:right;'/></td>";
                                    echo "</tr>";
                                }
                            ?>
                </tbody>
              </table>
      <?php } ?>

        </div>
        <?php if(false){ ?> 
        <input type='button' id="btnCheckAll" title="Check All" value="Check All" />
        <input type='button' id="btnUncheckAll" title="Uncheck All" value="Check All" />      <?php } ?>
        
        <table border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;">
            <?php if($this->user_permissions->is_view('r_account_chart')){ ?>
                <tr>
                    <td><input type="radio" id="chart_acc" name="acc"/>Chart Of Account</td>
                </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_account_report')){ ?>
            <tr>
                <td><input type="radio" id="acc_det" name="acc"/>Account Details</td>
            </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_account_update')){ ?>
            <tr>
                <td><input type="radio" id="acc_update" name="acc"/>Account Update</td>
            </tr>
            <?php } ?>


            <tr>
                <td><hr></td>
            </tr>

            <?php if($this->user_permissions->is_view('r_credit_note')){ ?>
            <tr>
                <td><input type="radio" id="credit_note" name="acc"/>Credit Note</td>
            </tr>
            <?php } ?>

            <?php if($this->user_permissions->is_view('r_debit_note')){ ?>
            <tr>
                <td><input type="radio" id="debit_note" name="acc"/>Debit Note</td>
            </tr>
            <?php } ?>

            <tr>
                <td><hr></td>
            </tr>

            <tr>
                <td><input type="radio" id="trial_balance" name="acc"/>Trial Balance</td>
            </tr>

            <tr>
                <td><input type="radio" id="profit_n_lost" name="acc"/>Profit And Lost</td>
            </tr>

            <tr>
                <td><input type="radio" id="balance_sheet" name="acc"/>Balance Sheet</td>
            </tr>

        </table>

        <div style="text-align: right; margin-top:10px; padding-top: 7px;">
        <button id="btnReset">Reset</button>    
        <button id="btnExit">Exit</button>
        <button id="print">Print</button></div>
    </fieldset>
         <input type="hidden" id='by' name='by'  class="report">
         <input type="hidden" name='page' value='A4' title="A4" >
         <input type="hidden" name='orientation' value='P' title="P" >
         <input type="hidden" id='type' name='type' value='' title="" >
         <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
         <input type="hidden" name='row_count' title="row_count" id="row_count">
         <input type="hidden" name='clusters' title="" id="clusters" >
         <input type="hidden" name='branchs' title="" id="branchs">
</form>
</div>

<?php } ?>