<script type='text/javascript' src='<?=base_url()?>js/r_sales_return_reason.js'></script>
<h2>Sales Return Reason</h2>

<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 450px;">
            <div class="form" id="form" style="width: 450px;">
                <form id="form_" method="post" action="<?=base_url()?>index.php/main/save/r_sales_return_reason" >
                <table>
                    <tr>
                        <td>Code</td>
                        <td><input type="text" class="input_txt" title='' name="code" id="code"  style="width: 150px; text-transform:uppercase;"maxlength="4"></td>
                    </tr>
					<tr>
                        <td>Description</td>
                        <td><input type="text" class="input_txt" name="description" title='' id="des" style="width: 350px;" maxlength="50"/></td>
                    </tr>
					  
					<tr>
                        <td colspan="2" style="text-align: right;">
                            <input type="hidden" id="code_" name="code_" value=""/>
                            <input type="button" id="btnExit" title='Exit' />
                            
                                <input type="button" id="btnSave" title='Save <F8>' />

                            
                            <input type="button" id="btnReset" title='Reset'>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </td>
        <td valign="top" class="content" style="width: 600px;">
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