<?php if($this->user_permissions->is_view('t_hp_charges_type')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_hp_chrages_type.js"></script>
<h2 style="text-align: center;">Charges Type</h2>
<table width="100%" >
    <tr>
        <td valign="top" class="content" style="width: 600px;">
            <div class="dframe" id="mframe" style="width: 600px;">
<form method="post" action="<?=base_url()?>index.php/main/save/t_hp_charges_type" id="form_">
	<table>
            <tr>
                <td style="width: 100px;">Code</td>
                <td>
                	<input type="text" class="input_txt ld" title="" id="code" name="code" style="width: 150px;"/>
                	<input type="hidden" class="input_txt ld" title="" id="hid" name="hid" style="width: 150px;"/>
                </td>
            </tr>
            <tr>
            	<td style="width: 100px;">Description</td>
                <td>
                	<input type="text" class="input_txt ld" title="" id="des" name="des" style="width: 450px;"/>
                </td>
             </tr>
             <tr>
                <td style="width: 100px;">Account</td>
                <td>
                	<input type="text" class="input_txt ld" title="" id="value" name="value" style="width: 150px;"/>
                    <input type="text" class="hid_value"  readonly="readonly" id="value_des"  style="width: 300px;">
                    
                </td>
             </tr>
             <tr>
                <td style="width: 100px;">Amount</td>
                <td>
                	<input type="text" class="input_txt ld" title="" id="amount" name="amount" style="width: 180px;"/>
                </td>
            </tr>
            <tr>
                <td style="text-align:right" colspan="2">
                    <input type="hidden" id="code_" name="code_" title="0" />
                    <input type="button" id="btnExit" title="Exit" />
                     <?php if($this->user_permissions->is_add('t_hp_charges_type')){ ?><input type="button" id="btnSavee" title='Save <F8>' /><?php } ?>
                    <input type="button" id="btnReset" title='Reset'>
                </td>
            </tr>
        </table>
        </form>
    </div>
    </td>
        <td class="content" valign="top" style="width: 600px;"> 
            <div class="form" id="form" style="width: 600px;">
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