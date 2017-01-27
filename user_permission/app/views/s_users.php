<?php if($this->user_permissions->is_view('s_users')){ ?>
<script type="text/javascript" src="<?=base_url()?>js/s_users.js"></script>
<h2>Users</h2>

<table width="100%">
    <tr>
        <td valign="top" class="content" style="width: 590px;">
            <div class="form" id="form">
                <form action="<?=base_url()?>index.php/main/save/s_users" method="post" name="form_" id="form_">
                    <table>
                        <tr>
                            <td style="width: 130px;">User Code</td>
                            <td>
                                <input type="text" class="input_txt" id="cCode" name="cCode" style="width: 150px;"  />

                            </td>
                        </tr><tr>
                        <td>Description</td>
                        <td><input type="text" class="input_txt" id="discription" name="discription"  style="width: 400px;" maxlength="150"/></td>
                    </tr><tr>
                    <td>Login Name</td>
                    <td><input type="text" class="input_txt" id="loginName" name="loginName"  style="width: 150px;" maxlength="40"/></td>
                </tr><tr>
                <td>Password</td>
                <td><input type="password" class="input_txt" id="userPassword" name="userPassword"  style="width: 150px;"/></td>
            </tr><tr>
            <td>Password Again</td>
            <td><input type="password" class="input_txt" id="r_pass"  style="width: 150px;"/></td>
        </tr><tr>
        <td>Is Admin</td>
        <td><input type="checkbox" title="1" name="isAdmin" id="isAdmin" /></td>
    </tr>
    <?php if($use_pos==1){ ?>
    <tr>
      <td>Use POS</td>
      <td><input type="checkbox" title="1" name="is_use_pos" id="is_use_pos" />
         Account
         <input type="text" class="input_txt" id="acc_code" name="acc_code"  style="width: 150px;"/> 
         <input type="text" class="hid_value" id="account_des"  style="width: 180px;"/></td>

     </tr>
     <?php   } ?>

     <tr>
        <td>Permission Level</td>
        <td>
            <select name="permission" id="permission">
                <option value="0">None</option>
                <option value="1">Level 01</option>
                <option value="2">Level 02</option>
                <option value="3">Level 03</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Cluster</td>
        <td>
            <?=$cluster;?>
        </td>
    </tr>
    <tr>
        <td>Branch</td>
        <td id="branch_list">
            <select id="bc">
                <option value="0">---</option>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right;">
            <input type="hidden" id="code_" name="code_"/>
            <input type="button" id="btnExit" title='Exit' />                    
            <?php if($this->user_permissions->is_add('s_users')){ ?><input type="button" id="btnSave" title='Save' /> <?php } ?>                         
            <input type="button" id="btnReset" title='Reset'>
        </td>
    </tr>
</table>
</form>
</div>
</td>
<td valign="top" class="content">
    <div class="form" id="form">
        <table>
            <tr>
                <td style="padding-right:64px;"><label>Search</label></td>
                <td><input type="text" class="input_txt" title='' id="srchee" name="srch" style="width:453px; marging-left:20px;"></td>
            </tr>
        </table> 
        <div id="grid_body"><?=$table_data;?></div>
    </div>
</td>
</tr>
</table>
<?php } ?>
