<?php if($this->user_permissions->is_view('m_settu_book_edition')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?=base_url()?>js/m_settu_book_edition.js'></script>
<h2>Settu Book Edition</h2>
<div  style="width:525px;margin-left:50px;">
<table style="width:525px;" id="tbl1">
    <tr>
        <td valign="top" class="content" style="width:50%;">
            <div class="form" id="form">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/m_settu_book_edition" >
                    <table style="width:520px;" id="tbl2">
                        <tr>
                            <td>Code</td>
                            <td>
                                <input type="text" class="input_active"  style="width:150px;" name="codes" id="codes"/>     
                                <input type="hidden" id="code_" name="code_" title="0">
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>
                                <input type="text" class="input_active" style="width:400px;" name="des" id="des"/>     
                            </td>
                        </tr>
                        <tr>
                            <td>Note</td>
                            <td>
                                <textarea name="note" class="input_active" id="note" style="width:400px;" cols="47"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Active</td>
                            <td>
                                <input type="checkbox" class="input_active" name="is_active" id="is_active" title="1" value="1" style="width:0px;"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right" colspan="2">
                                <input type="button" id="btnExit" title='Exit' />
                                <input type="button" id="btnReset" title='Reset'>                       
                                <?php if($this->user_permissions->is_add('m_settu_book_edition')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?> 
                            </td>
                        </tr>
                    </table><!--tbl2-->
                    
                </form><!--form_-->
            </div><!--form-->
      </td>
      <td valign="top" class="content" style="width:600px;">
            <div class="form" id="form" style="width:500px;" >
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
    <?php 
if($this->user_permissions->is_print('m_settu_book_edition')){ ?>
    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
<?php } ?> 
</table><!--tbl1-->
</div>

<?php } ?>
