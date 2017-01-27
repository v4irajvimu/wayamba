<?php if($this->user_permissions->is_view('m_settu_item_category')){ ?>
<script type='text/javascript' src='<?= base_url() ?>js/m_settu_item_category.js'></script>
<h2>Settu-Item Category</h2>

<table width="100%"> 
    <tr>
        <td valign="top" class="content" style="width:450px;">
            <div class="form" id="form" style="width:500px;">
                <form id="form_" method="post" action="<?= base_url() ?>index.php/main/save/m_settu_item_category" >
                    <table style="width:100%">
                        <tr>
                            <td>Book Edition</td>
                            <td>
                                <input type="text" class="input_txt " title='' id="book_no" name="book_no" style="width:130px;" >
                                <input type="text" class="hid_value"  id="book_des" style="width:215px;">
                                <input type="hidden" name="ref_code" id="ref_code">
                            </td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td><input type="text" class="input_txt " title='' id="code" name="code" style="width:130px; padding: 3px; text-transform: uppercase; border: 1px solid #003399;" maxlength="10" ></td>
                        </tr>

                        <tr>
                            <td>Name</td>
                            <td><input type="text" class="input_txt" title='' id="name" name="name" style="width:350px;" maxlength="100"/></td>
                        </tr>
                        <tr>
                            <td>Value</td>
                            <td><input type="text" class="g_input_num " title='' id="value" name="value" style=" padding: 3px;width:130px;text-transform: uppercase; border: 1px solid #003399;" maxlength="10"/></td>
                        </tr>
                        <tr>
                            <td>No Of Installment</td>
                            <td><input type="text" class="g_input_num " title='' id="no_of_installment" name="no_of_installment" style="padding: 3px;width:130px;text-transform: uppercase; border: 1px solid #003399;" maxlength="10" /></td>
                        </tr>
                        <tr>
                            <td>Installment Amount</td>
                            <td><input type="text" class="g_input_num " title='' id="installment_amount" name="installment_amount" style="padding: 3px;width:130px;text-transform: uppercase; border: 1px solid #003399;" maxlength="10" /></td>
                        </tr>

                        <tr>

                            <td style="text-align:right" colspan="2">
                                <input type="hidden" id="code_" name="code_" title="0" />
                                <input type="button" id="btnExit" title="Exit" />                                
                                <input type="button" id="btnReset" title='Reset'>
                                <?php if($this->user_permissions->is_delete('m_settu_item_category')){ ?><input type="button" id="btnDelete" title='Delete' /><?php } ?>
                                <?php if($this->user_permissions->is_re_print('m_settu_item_category')){ ?><input type="button" id="btnPrint" title='Print' /><?php } ?>
                                <?php if($this->user_permissions->is_add('m_settu_item_category')){ ?><input type="button" id="btnSave" title='Save' /><?php } ?>
                            </td>
                        </tr>
                    </table>
                    <?php 
                        if($this->user_permissions->is_print('m_settu_item_category')){ ?>
                        <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                    <?php } ?> 
                </form>
            </div>
        </td><td class="content" valign="top" style="width:600px;">
            <div class="form" id="form" style="width:600px;" >
                <table>
                    <tr>
                        <td style="padding-right:64px;"><label>Search</label></td>
                        <td><input type="text" class="input_txt" title='' id="srchee" name="srch" style="width:230px; marging-left:20px;"></td>
                    </tr>
                </table>
                <div id="grid_body"><?= $table_data; ?></div>
            </div>
        </td>
    </tr>
</table>
<?php } ?>