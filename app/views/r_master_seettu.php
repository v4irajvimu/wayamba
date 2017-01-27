<?php if($this->user_permissions->is_view('r_master_seettu')){ ?>
<link rel="stylesheet" href="<?=base_url()?>css/report.css" />
<script type='text/javascript' src='<?=base_url()?>js/r_master_seettu.js'></script>

<h2> Seettu Reports</h2>
<div class="dframe" id="r_view2" style="width: 1000px;">

    <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">

        <fieldset>
        <legend >Category</legend>
            <table border="0" cellpadding="0" cellspacing="0" id="cl_bc" style="font-size: 12px;">
                <tr>
                    <td>Book Edition</td>
                    <td style="padding-right:11px;">
                        <input type="text" class="input_txt" id="book_edition" name="book_edition" style="width:125px;"/></td>
                     <td><input type="text" class="hid_value main_cus" id="book_des" name="book_des" style="width:221px; " maxlength="100"/>
                    </td> 
                    <td style="width: 50px;"></td>
                    <td>
                    </td>                            
                </tr>

                 <tr> 
                    <td style="width:83px;">Category</td>
                    <td style="padding-right:11px;"><input type="text" class="input_txt" title='' id="settu_item_category" name="settu_item_category" style="width:125px;" readonly="readonly" /></td>
                    <td><input type="text" class="hid_value main_cus" title='' id="category_name" name="category_name" style="width:221px;" maxlength="100"/></td>               
                 </tr>
                 
                <tr> <td colspan="4"><hr/><td> </tr>

                <table border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;">
                    <?php if($this->user_permissions->is_view('r_master_seettu')){ ?>
                        <tr>
                            <td>
                                <input type='radio' id="r_seettu_Item_setup" name='by' value='r_seettu_Item_setup' title="r_seettu_Item_setup" class="report" /> Seettu Item Setup
                            </td>               
                        </tr>

                        <tr>
                            <td>
                                <input type='radio' id="r_seettu_category_list" name='by' value='r_seettu_category_list' title="r_seettu_category_list" class="report" /> Seettu Category List
                            </td>               
                        </tr>

                       
                    <?php } ?>
                </table>

                     <input type="hidden" name='page' value='A4' title="A4" >
                     <input type="hidden" name='orientation' value='P' title="P" >
                     <input type="hidden" id='type' name='type' value='' title="" >
        
              <div style="text-align: right; margin-top:10px; padding-top: 7px;">
                    <input type="button" value="Reset" title="Reset" id="btnReset"/>  
                    <input type="button" id="btnExit" title="Exit" />  
                    <input type="button" value="Print" title="Print" id="btnPrint"/>
              </div>  

            </table> 
        </fieldset>
     </form>  
</div> 
       
<?php } ?>