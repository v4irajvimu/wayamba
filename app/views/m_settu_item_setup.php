<?php if($this->user_permissions->is_view('m_settu_item_setup')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/m_settu_item_setup.js'></script>
<h2>Settu-Item Setup</h2>
<table width="100%"> 
    <tr>
        <td>
            <div class="dframe" id="mframe" style="padding-left:25px;padding-right:25px; width:1100px;">
                <form id="form_" method="post" action="<?= base_url() ?>index.php/main/save/m_settu_item_setup" >
                    <table border="0">
                        <tr>
                            <td><span class='non'>Book Edition</span></td>
                            <td ><input type="text" class="input_txt non" id="book_no" name="book_no" style="width:125px;" readonly="readonly" /></td>
                            <td>
                                <input type="text" class="hid_value non" id="book_des" name="book_des" style="width:300px; " maxlength="100"/>
                            </td>
                            <td style="width: 150px;">
                                <input type="button" class="non" id="btn_book" name="btn_book" title="..." style="width:40px; margin-right:30px;"/> 
                            </td>   
                                <td style="width: 500px;" rowspan="2">  <b><div id="price_value"style="border: 1px solid #000000; height:38px; width:150px; text-align:center; display:none; font-size: 200%; "> </div> </b>
                            </td>
                            <td></td>
                            <td style="width: 50px;">Type</td>
                            <td>
                                 <select name="i_type" id="i_type">
                                     <option value="1">Settu Item</option>
                                     <option value="2">Genaral Item</option>
                                 </select>
                            </td>
                        </tr>

                        <tr>
                            <td><span class="non">Category</span></td>
                            <td><input type="text" class="input_txt non" title='' id="settu_item_category" name="settu_item_category" style="width:125px;" readonly="readonly" /></td>
                            <td>
                                <input type="text" class="hid_value main_cus non" title='' id="category_name" name="category_name" style="width:300px;" maxlength="100"/>
                                <input type="hidden"  id="hid_code" name="hid_code"/>
                            </td>
                            <td></td>
                            <td></td>
                            <td style="width: 50px;">No</td>
                            <td>
                                <input type="text" style="width:100%;" class="input_active_num" name="id_no" id="id_no" title="<?php echo $max_no; ?>"/>
                                <input type="hidden" id="hid" name="hid" title="0" />
                            </td>
                            
                        </tr>

                        <tr>
                            <td>Code</td>
                            <td colspan="2"><input type="text" class="input_txt" title="" id="code_id" name="code_id" style="width:125px; text-transform:uppercase;" maxlength="100"/></td>
                            <td colspan="2"> </td>
                            <td></td>
                            <td style="width: 50px;">Date</td>
                            <td>
                               <input type="text" class="input_date_down_future" readonly="readonly" style="width:100%; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="100px;">Description</td>
                            <td colspan="2" ><input type="text" class="input_txt" title='' id="discription" name="discription" style=" padding: 3px;width:430px; border: 1px solid #003399;"  /></td>
                            <td></td>
                            <td></td>
                        </tr>
                      
                        <tr>
                            <td colspan="2"><br/><b>Item Details</b></td>

                        </tr>
                        <table>
                            <table style="width:100%" id="tgrid" border="0" class="tbl">
                                <thead>
                                    <tr>
                                        <th class="tb_head_th" style="width: 45px;">Code</th>
                                        <th class="tb_head_th" style='width: 70px;'>Name</th>
                                        <th class="tb_head_th" style="width: 30px;">Qty</th>
                                        <th class="tb_head_th" style="width: 40px;">Cost</th>
                                        <th class="tb_head_th" style="width: 40px;">Last</th>
                                        <th class="tb_head_th" style="width: 40px;">Max</th>
                                        <th class="tb_head_th" style="width: 50px;">Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <input type='hidden' id='transtype' title='CASH' value='CASH' name='transtype' />
                                <input type='hidden' name='all_foc_amount' id='all_foc_amount' value='0' title='0'/>
                                <?php
                                for ($x = 0; $x < 10; $x++) {

                                    echo "<tr>";
                                    echo "<td>
                                            <input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                            <input type='text' class='fo input_txt' id='0_" . $x . "' name='0_" . $x . "' style='width : 100%;text-align:left;'/></td>";
                                    echo "<td><input type='text' class='g_col_fixed' id='n_" . $x . "' name='n_" . $x . "' style='width : 100%;text-align:left;' readonly='readonly'/></td>";
                                    echo "<td><input type='text' class='input_txt_num qty' id='2_" . $x . "' name='2_" . $x . "' style='width : 100%;text-align:right;'/></td>";
                                    echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='3_" . $x . "' name='3_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";
                                    echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='item_min_price_" . $x . "' name='item_min_price_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";
                                    echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='free_price_" . $x . "' name='free_price_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";                                   
                                    echo "<td><input type='text' class='ig_input_amo amount g_col_fixed' id='5_" . $x . "' name='5_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";
                                    echo " <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' /></td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                                </table>

                                <table>
                                    <tr>
                                      <td align="right" style="padding-left:822px;"> </td> 
                                      <td width="133" align="right"><b>Total Amount</b></td>
                                      <td>
                                            <input type="text" name="item_value" class="hid_value g_input_amounts g_input_amo" readonly="readonly" style="width:133px;" id="item_value"/>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><br/><b>Free-Item Details</b></td> 
                                    </tr>
                                </table>
                                
                                <table style="width:100%" id="tgrid1" border="0" class="tbl">
                                    <thead>
                                        <tr>
                                            <th class="tb_head_th" style="width: 45px;">Code</th>
                                            <th class="tb_head_th" style='width: 70px;'>Name</th>
                                            <th class="tb_head_th" style="width: 30px;">Qty</th>
                                            <th class="tb_head_th" style="width: 40px;">Cost</th>
                                            <th class="tb_head_th" style="width: 40px;">Last</th>
                                            <th class="tb_head_th" style="width: 40px;">Max</th>
                                            <th class="tb_head_th" style="width: 50px;">Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <input type='hidden' id='transtype' title='CASH' value='CASH' name='transtype' />
                                    <input type='hidden' name='all_foc_amount' id='all_foc_amount' value='0' title='0'/>
                                    <?php
                                    for ($x = 0; $x < 5; $x++) {
                                        echo "<tr>";
                                        echo "<td> <input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                                                <input type='text' class=' sub_i input_txt' id='itemCode_" . $x . "' name='itemCode_" . $x . "' style='width : 100%;text-align:left;' /></td>";
                                        echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='item_name_" . $x . "' name='item_name_" . $x . "' style='width : 100%;text-align:left;' readonly='readonly'/></td>";
                                        echo "<td><input type='text' class='g_input_num quality' id='qty_" . $x . "' name='qty_" . $x . "' style='width : 100%;text-align:right;'/></td>";
                                        echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='cost_" . $x . "' name='cost_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";
                                        echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='last_price_" . $x . "' name='last_price_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";
                                        echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='max_price_" . $x . "' name='max_price_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";                                        
                                        echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='amount_" . $x . "' name='amount_" . $x . "' style='width : 100%;text-align:right;' readonly='readonly'/></td>";


                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>

                                </table>

                                <table>
                                  <tr>
                                    <td align="left" width="88"> <b>Value</b> &nbsp; </td>
                                     <td align="left" width="120">           
                                        <input type="text" name="tot_item_value" class="hid_value g_input_amounts g_input_amo" readonly="readonly" style="width:183px;" id="tot_item_value"/>
                                    </td>
                                    <td align="right" width="553"> </td>
                                    <td align="right" width="122"> <b>Free Total </b> &nbsp; </td>
                                    <td align="left"> 
                                        <input type="text" name="free_item_value" class="hid_value g_input_amounts g_input_amo" readonly="readonly" style="width:133px;" id="free_item_value"/>
                                    </td>
                                    </tr>
                                  <tr>
                                     <td width="88"><br/>Note</td>
                                     <td colspan="5"><br/>
                                        <input type="text" class="input_txt" title='' id="note" name="note"  style="width:652px;"/>
                                     </td> 
                                  </tr>
                                   <tr>
        <td colspan="7"><br/>
            <input type="button" id="btnExit" title="Exit" />
            <input type="button" id="btnResett" title="Reset" />
            <?php if($this->user_permissions->is_delete('m_settu_item_setup')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
            <?php //if($this->user_permissions->is_re_print('m_settu_item_setup')){ ?> <!-- <input type="button" id="btnPrint" title="Print" /> --> <?php //} ?>              
            <input type="button" title='Save <F8>' id="btnSave"/>   
        </td>
        
    </tr>
                                </table>
                            </table>

                        </table>
                    </table>
                </form>
            </div>
        </td>
    </tr>
</table>
<?php } ?>