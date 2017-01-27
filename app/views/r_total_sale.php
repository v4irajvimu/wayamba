<?php if($this->user_permissions->is_view('r_total_sale')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_total_sale.js'></script>
<h2>Total Sale Reports</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 480px;">
            <div class="form" id="form">
                <form action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
                  <table>
                      <tr><td>Date </td><td ><input type="text" class="input_date_down_future" id="from" name="from" title="<?=date('Y-m-d')?>" style="width: 80px;" />
                        To <input type="text" class="input_date_down_future" id="to" name="to"title="<?=date('Y-m-d')?>" style="width: 80px;"  /></td></tr>
                        
                        <tr>
                            <td>Cluster</td>
                            <td><?php echo $cluster; ?></td>
                        </tr>

                        <input type="hidden" id="d_cl" title='<?php echo $d_cl ?>' name="d_cl"/>
                        <input type="hidden" id="d_bc" title='<?php echo $d_bc ?>' name="d_bc"/>
                        <tr>
                            <td>Branch</td>
                            <td>
                             <select name='branch' id='branch' style='width:179px;'>
                                <option value='0'>---</option>
                            </select>
                        </td>
                    </tr>
                    <tr class='emp'>
                        <td>Employee</td>
                        <td><input type="text" class="input_txt" title="" id="emp" name="emp" style="width: 180px;"/></td>
                        <td><input type="text" class="hid_value"  readonly="readonly" id="emp_des" name="emp_des" style="width: 250px;"></td>
                    </tr>

                    <tr class='itm'>
                        <td>Item</td>
                        <td><input type="text" class="input_txt" title="" id="item" name="item" style="width: 180px;"/></td>
                        <td><input type="text" class="hid_value"  readonly="readonly" id="item_des" name="item_des" style="width: 250px;"></td>
                    </tr>

                    <tr>
                      <td><lable class='cus'>Customer</lable></td>
                      <td><input type="text" class="input_txt cus" title="" id="cus" name="cus" style="width: 180px;"/></td>
                      <td><input type="text" class="hid_value cus"  readonly="readonly" id="cus_des" name="cus_des" style="width: 250px;"></td>
                  </tr>

                  <tr>
                    <?php if($this->user_permissions->is_view('r_total_sale')){ ?>
                    <tr>
                        <td>
                           <input type='radio' name='by' value='r_total_sale' title="r_total_sale" class="report" />Total Sales Report
                       </td>			    
                   </tr>
                   <?php } ?>
                   <?php if($this->user_permissions->is_view('r_total_sale')){ ?>
                   <tr>
                    <td>
                        <input type='radio' name='by' value='r_total_sales_report_02' title="r_total_sales_report_02" class="report" />Total Sales Report 02
                    </td>               
                </tr>
                <?php } ?>
                <?php if($this->user_permissions->is_view('r_total_sale')){ ?>
                <tr>
                    <td>
                        <input type='radio' name='by' value='r_total_sale_emp' title="r_total_sale_emp" class="report" />Employee Total Sales Report
                    </td>               
                </tr>
                <?php } ?>
                <?php if($this->user_permissions->is_view('r_total_sale')){ ?>
                <tr>
                    <td>
                        <input type='radio' name='by' value='r_total_sale_gross_profit' title="r_total_sale_gross_profit" class="report" />Total Sales Gross Profit Report
                    </td>               
                </tr>
                <?php } ?>
                <?php if($this->user_permissions->is_view('r_total_sale')){ ?>
                <tr>
                    <td>
                        <input type='radio' name='by' type='total_sale_summary_qty' value='r_total_sale_summary' title="r_total_sale_summary" class="report" />Total Sales Summary Report
                    </td>               
                </tr>
                <tr>
                    <td>
                        <input type='radio' name='by' type='r_total_sale_catwise' value='r_total_sale_catwise' title="r_total_sale_catwise" class="report" />Total Sales Report Category Wise
                    </td>               
                </tr>
                <?php } ?>
                <tr>


                  
                 <tr>
                     <td colspan="2" style="text-align: right;">
                        <input type="hidden" name="type" id="type"  title=""/>
                        <input type="button" title="Exit" id="btnExit" value="Exit">
                        
                        <button id="btnPrint">Print PDF</button>
                    </td>
                </tr>
            </table>

            <input type="hidden" name='page' value='A4' title="A4" >
            <input type="hidden" name='orientation' value='P' title="P" >
            <!-- <input type="hidden" name='type' value='19' title="19" > -->
            <input type="hidden" name='header' value='false' title="false" >
            <input type="hidden" name='qno' value='' title="" id="qno" >
            <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
            <input type="hidden" name='dt' value='' title="" id="dt" >
        </form>
    </div>
    
</table>
<?php } ?>