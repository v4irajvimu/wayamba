<?php if($this->user_permissions->is_view('r_category')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_category.js'></script>
<h2>Main Category</h2>
<table width="100%">
<tr>
    <td valign="top" class="content" style="width:460px;" >
        <div class="form" id="form" style="width:450px;" >
            <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/r_category" >
            <table>

               <tr>
                        <td style="width:90px;">Department</td>
                        <td colspan="2"><input type="text" class="input_txt" title='' name="de_code" id="de_code" style="width:100px;">
                        <input type="text" class="hid_value" title=' ' id="department" readonly="readonly" style="width:245px;">
                        <input type="hidden" id="max_nno" name="max_nno">
                        </td>
                        
                    </tr>
                <tr>
                    <td>Code</td>
                    <td>
                        <input type="text" class="input_txt" name="code" id="code"  maxlength="10" style="width:150px; text-transform: uppercase;">
                        <input type="hidden" class="input_txt" title='' name="code_gen" id="code_gen" maxlength="2" style="width:50px; text-transform: uppercase;">
                    </td>
                </tr><tr>
                    <td>Description</td>
                    <td><input type="text" class="input_txt" title='' name="description" id="description"  style="width:350px;" maxlength="50"/></td>
                </tr><tr>
                    <td colspan="2" style="text-align: right;">
                        <input type="hidden" id="code_" name="code_" />
                        <input type="button" id="btnExit" title="Exit" />
                        <?php if($this->user_permissions->is_add('r_category')){ ?><input type="button" id="btnSave1" title='Save <F8>' /> <?php } ?>
                        <input type="button" id="btnReset" title='Reset'>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </td>
    <td class="content" valign="top" style="width:600px;">
        <div class="form" id="form" style="width:600px;">

 			<table>
            <tr>
            <td style="padding-right:64px;"><label>Search</label></td>
            <td><input type="text" class="input_txt" title='' id="srchee" name="srch" style="width:230px; marging-left:20px;">
            <input type="button" id="cat_list" title="Category List">
            </td>
            </tr>
            <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
                <input type="hidden" name='by' value='r_category' title="r_category" class="r_category">
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