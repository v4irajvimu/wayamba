<?php if($this->user_permissions->is_view('r_units')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/r_units.js'></script>
<h2>Units</h2>
<table width="100%" border="0">
    <tr>
        <td valign="top" class="content" style="width: 450px;">
            <div class="form" id="form"  style="width: 450px;">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/r_units" >
                <table>
                    <tr>
                        <td>Code</td>
                        <td>
                            <input type="text" class="input_txt" name="code" id="code" maxlength="4" title='<?=$max_no?>'  style="width: 150px; text-transform: uppercase;">
                            <input type="hidden" class="input_txt" name="code_gen" id="code_gen" maxlength="20" style="width: 50px; text-transform: uppercase;">
                            <input type="hidden" id="max_nno" name="max_nno">
                        </td>
                    </tr><tr>
                        <td>Description</td>
                        <td><input type="text" class="input_txt" title='' name="description" id="description"  maxlength="50" style="width: 350px;"/></td>
                    </tr><tr>
                        <td colspan="2" style="text-align: right;">
                            <input type="hidden" id="code_" name="code_" />
                            <input type="button" id="btnExit" title="Exit" />
                            <?php if($this->user_permissions->is_add('r_units')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                            <input type="button" id="btnReset" title='Reset'>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </td>
        <td class="content" valign="top" style="width: 600px;">
            <div class="form" id="form" style="width:600px;" >
            <table>
            <tr>
            <td style="padding-right:64px;"><label>Search</label></td>
            <td><input type="text" class="input_txt" title='' id="srchee" name="srch" style="width:230px; marging-left:20px;"></td>
            </tr>
            </table>
                <div id="grid_body"><?=$table_data;?></div>
            </div>
        </td>
    </tr>
</table>
<?php } ?>
