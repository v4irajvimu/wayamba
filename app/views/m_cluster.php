<?php if($this->user_permissions->is_view('m_cluster')){ ?>
<script type='text/javascript' src='<?=base_url()?>js/m_cluster.js'></script>
<h2>Cluster</h2>
<table width="100%">
    <tr>
        <td valign="top" class="content" style="width:450px;">
            <div class="form" id="form" style="width:450px;">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/m_cluster" >
                <table>
                    <tr>
                        <td>Code</td>
                        <td><input type="text" class="input_txt" title='' id="code" name="code" maxlength="2" style="align:right;width:150px; text-transform:uppercase"></td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td><input type="text" class="input_txt" title='' id="des" name="description" maxlength="50" style="width:350px;"/></td>
                    </tr>

					<tr>
                        <td colspan="2" style="text-align:right">
                            <input type="hidden" id="code_" name="code_" />
                            <input type="button" id="btnExit" title="Exit" />
                           
                            <?php if($this->user_permissions->is_add('m_cluster')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                            
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
            <td><input type="text" class="input_txt" title='' id="srchee" name="srch" style="width:230px; marging-left:20px;"></td>
            </tr>
            </table>
                <div id="grid_body"><?=$table_data;?></div>
            </div>
        </td>
    </tr>
</table>
<?php } ?>