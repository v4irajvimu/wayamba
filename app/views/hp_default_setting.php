<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/hp_default_setting.js'></script>




<h2> HP Default Settings</h2>
<div class="dframe" id="mframe" style="padding-right:25px;">
    <form id="form_" method="post" action="<?= base_url() ?>index.php/main/save/hp_default_setting" >
        
        
        <table width="100%" border="0">
            <tr>
                <td>

                        <table width="100%" border="0">
                            <tr>
                                <td colspan="2">Use Auto No Format ><input type='checkbox' name='is_use_auto_no_format' id='is_use_auto_no_format' title='1' /></td>
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
                                    <select id="order_0" name="order_0">
                                        <option value="">...</option>
                                        <option value="1">1</option>
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
                                                <td>Continus</td>
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
                                    <select id="order_1" name="order_1">
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
                                    <select id="order_2" name="order_2">
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
                                    <select id="order_3" name="order_3">
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
                                    <select id="order_4" name="order_4">
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
                                    <select id="order_5" name="order_5">
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
                                <td><input type='checkbox' name='fn_6' id='fn_6' title='seperator' /> Seperator</td> 
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
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
        <input type="button" id="btnExit" title="Exit" />
        <input name="button" type="button" id="btnReset" title='Reset' />
        <input type="button" title="Save" id="btnSave"/>


    </form>
</div>