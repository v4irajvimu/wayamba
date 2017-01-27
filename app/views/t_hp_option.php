<script type='text/javascript' src='<?=base_url()?>js/t_hp_option.js'></script>
<h2>HP Default Settings</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 640px;">
            <div class="form" id="form">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/t_hp_option" >
                 <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Agreement No</a></li>
                        <li><a href="#tabs-2">H/Purchase</a></li>
                        <li><a href="#tabs-3">Other Settings</a></li>
                                                 
                    </ul>

                    <div id="tabs-1"> <!-- Tab 1-->
                        <table width="100%" border="0">
                        <tr>
                            <td>
                                <table width="100%" border="0">
                                    <tr>
                                        <td colspan="2">Use Auto No Format <input type='checkbox' name='is_use_auto_no_format' id='is_use_auto_no_format' title='1' /></td>
                                    </tr>
                                    <tr>
                                        <td>Code Place</td>
                                        <td><input type='text' name='code_place' id='code_place' class='input_txt' style="margin-left:5px;"/></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td><input type='text' name='description' id='description' class='input_txt' style="margin-left:5px;"/></td>
                                    </tr>
                                </table>
                            </td>
                            <td rowspan = "2">
                               
                                <fieldset>
                                    <table border="0"  width="100%">
                                        <tr>
                                            <td colspan="2">Order</td>
                                            <td>Sample</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="order_0" name="order_0" class="order_dropdown">
                                                    <option value="">...</option>
                                                    <option value="1" selected="selected">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td><input type='checkbox' name='fn_0' id='fn_0' title='day' /> Day</td>
                                            <td><input type='text' name='sample_0' id='sample_0' class='input_txt'/></td>
                                            <td rowspan="7">

                                                <fieldset>
                                                    <legend>Restart In Each</legend>
                                                    <table border="0">
                                                        <tr>
                                                            <td><input type="radio" id="monthly" name="restart_type" title="monthly"/></td>
                                                            <td>Monthly</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="radio" id="anually" name="restart_type" title="anually"/></td>
                                                            <td>Anually</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="radio" id="daily" name="restart_type" title="daily"/></td>
                                                            <td>Daily</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="radio" id="continus" name="restart_type" title="continus"/></td>
                                                            <td>Continuous</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" title="1" id="restart_branch_code" name="restart_branch_code" /></td>
                                                            <td>Branch Code</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" title="1" id="restart_sales_cat" name="restart_sales_cat" /></td>
                                                            <td>Sales Cat.</td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="order_1" name="order_1" class="order_dropdown">
                                                    <option value="">...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td><input type='checkbox' name='fn_1' id='fn_1' title='month' /> Month</td>
                                            <td><input type='text' name='sample_1' id='sample_1' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="order_2" name="order_2" class="order_dropdown">
                                                    <option value="">...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td><input type='checkbox' name='fn_2' id='fn_2' title='year' /> Year</td>
                                            <td><input type='text' name='sample_2' id='sample_2' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="order_3" name="order_3" class="order_dropdown">
                                                    <option value="">...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td><input type='checkbox' name='fn_3' id='fn_3' title='serial_no' /> Serial No</td>
                                            <td><input type='text' name='sample_3' id='sample_3' class='input_txt'/></td>
                                        </tr>
                                           <tr>
                                           <td>
                                                <select id="order_4" name="order_4" class="order_dropdown">
                                                    <option value="">...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td><input type='checkbox' name='fn_4' id='fn_4' title='branch_code' /> Branch Code</td>
                                            <td><input type='text' name='sample_4' id='sample_4' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="order_5" name="order_5" class="order_dropdown">
                                                    <option value="">...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td><input type='checkbox' name='fn_5' id='fn_5' title='sales_category' /> Sales Category</td>
                                            <td><input type='text' name='sample_5' id='sample_5' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><input type='checkbox' name='fn_6' id='fn_6' title='seperator' /> Separator</td> 
                                            <td><input type='text' name='sample_6' id='sample_6' class='input_txt'/></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                           
                        </tr>
                        <tr>
                            <td style="padding-top:10px;">
                                <fieldset>
                                    <legend>Base Details</legend>
                                    <table width="100%" border = "0">
                                        <tr>
                                            <td>Table Name</td>
                                            <td><input type='text' name='table_name' id='table_name' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td>Serial Field</td>
                                            <td><input type='text' name='serial_field' id='serial_field' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td>Date Field</td>
                                            <td><input type='text' name='date_field' id='date_field' class='input_txt'/></td>
                                        </tr>
                                        <tr>
                                            <td>Agreement No</td>
                                            <td><input type='text' name='agree_field' id='agree_field' class='input_txt' title="<?=$s_number;?>" /></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <div id="tabs-2"> <!-- Tab 2-->
                        <table>
                            <tr>
                                <td>
                                    <fieldset>
                                    <legend>Penalty Calculation</legend>
                                    <table width="100%" border = "0">
                                        <tr>
                                            <td style="width:232;" >Daily</td>
                                            <td><input type='radio' name='panalty_cal' id='panalty_d' title="1" checked="true" /></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly</td>
                                            <td><input type='radio' name='panalty_cal' id='panalty_m' title="2"/></td>
                                        </tr>
                                        <tr>
                                            <td>After Scheduled Period</td>
                                            <td><input type='radio' name='panalty_cal' id='panalty_a' title="3"/></td>
                                        </tr>
                                        <tr>
                                            <td>After Scheduled Period Balance</td>
                                            <td><input type='radio' name='panalty_cal' id='panalty_b' title="4"/></td>
                                        </tr>
                                        <tr>
                                            <td>Penalty Rate</td>
                                            <td><input type='text' name='p_rate' id='p_rate' class='input_txt g_input_num' maxlength="3" /></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <td>
                            </tr>
                            <tr>
                                <td>
                                    <fieldset style="width:400px;">
                                    <legend>Grace Period Calculation</legend>
                                        <table width="98%" border = "0">
                                            <tr>
                                                <td style="width:300px;">Check Grace Period Every Month</td>
                                                <td><input type='radio' name='gr_type' id='em_grace' title="1" value="1" checked="true" /></td>
                                            </tr>
                                            <tr>
                                                <td>Check Grace Period Only First Month</td>
                                                <td><input type='radio' name='gr_type' id='fm_grace' title="2" value="2" /></td>
                                            </tr>
                                            <tr>
                                                <td>Grace Period Days</td>
                                                <td><input type='text' name='gr_day' id='gr_day' class='input_txt g_input_num' maxlength="2" /></td>
                                            </tr>

                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                            </table>
                            <table>
                            <tr>
                                <td>
                                    <fieldset>
                                    <legend>Document Charges</legend>
                                    <table width="100%" border = "0">
                                        <tr>
                                            <td>Document Charges Separate</td>
                                            <td><input type='checkbox' name='doc_separate' id='doc_separate' value="1" /></td>
                                        </tr>
                                        <tr>
                                            <td>Document Charges Acc</td>
                                            <td>
                                                <input type='text' name='doc_acc' id='doc_acc' readonly="readonly" class='hid_value'/>
                                                <input type='text' name='doc_acc_des' id='doc_acc_des' class='hid_value' readonly="readonly" style="width:300px;"/>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    <fieldset>
                                    <legend>HP Receipt Options</legend>
                                    <table width="100%" border = "0">
                                        <tr>
                                            <td style="width:270px;">Show / Hide Memo</td>
                                            <td><input type='checkbox' name='sh_memo' id='sh_memo' title="1" checked="true" /></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                </td>
                            </tr>
                        </table>                
                    </div>
                    <div id="tabs-3"> <!-- Tab 3-->
                                 
                    </div>
                   
                  </div>
                    <input type="button" id="btnExit" title="Exit" />
                    <input name="button" type="button" id="btnReset" title='Reset' />
                    <input type="button" title="Save" id="btnSave"/>
                </form>
            </div>           
        </td>
        
    </tr>
</table>