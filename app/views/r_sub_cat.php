<?php if($this->user_permissions->is_view('r_sub_cat')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_sub_cat.js'></script>
<h2>Sub Category</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width:450px;">
            <div class="form" id="form" style="width:450px;">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/r_sub_cat" >
                <table>
                    <tr>
                        <td style="width:90px;">Main Category</td>
                        <td colspan="2"><input type="text" class="input_txt" title='' name="main_category_id" id="main_category_id" style="width:100px;">
						<input type="text" class="hid_value" title=' ' id="main_category" readonly="readonly" style="width:245px;">
						</td>
						
                    </tr><tr>
                        <td>Code</td>
                        <td colspan="2">
                            <input type="text" class="input_txt" id="code" name="code" maxlength="10" style="width:150px; text-transform: uppercase;">
                            <input type="hidden" class="input_txt" title='' id="code_gen" name="code_gen" maxlength="2" style="width:50px; text-transform: uppercase;">
                            <input type="hidden" id="max_nno" name="max_nno">
                        </td>
                    </tr><tr>
                        <td>Description</td>
                        <td colspan="2"><input type="text" class="input_txt" title='' id="description" name="description"  maxlength="50" style="width:350px;"/></td>
                    </tr><tr>
                        <td colspan="2" style="text-align: right;">
                            <input type="hidden" id="code_" name="code_" value=""/>
							<input type="button" id="btnExit" title="Exit" />
                            <?php if($this->user_permissions->is_add('r_sub_cat')){ ?><input type="button" id="btnSave" title='Save <F8>' /> <?php } ?>
                            <input type="button" id="btnReset" title='Reset'>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </td>
        <td valign="top" class="content" style="width:600px;">
            <div class="form" id="form" style="width:600px;" >
            <table>
            <tr>
            <td style="padding-right:64px;"><label>Search</label></td>
            <td><input type="text" class="input_txt" title='' id="srchee" name="srch" style="width:230px; marging-left:20px;">
            <input type="button" id="sub_cat_list" title="Sub Category List">
        </td>
            </tr>
            <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
                <input type="hidden" name='by' value='r_sub_cat' title="r_sub_cat" class="r_sub_cat">
                <input type="hidden" name='page' value='A4' title="A4" >
                <input type="hidden" name='orientation' value='P' title="P" >
                <input type="hidden" name='header' value='false' title="false" >
            </form>
            </table>
                <div id="grid_body"><?=$table_data;?></div>
            </div>
        </td>
    </tr>
</table>
<?php } ?>