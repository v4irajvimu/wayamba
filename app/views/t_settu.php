<?php if($this->user_permissions->is_view('t_settu')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type='text/javascript' src='<?= base_url() ?>js/t_settu.js'></script>
<h2>Seettu</h2>
<table width="100%"> 
  <tr>
    <td>
      <div class="dframe" id="mframe" style="padding-left:25px;padding-right:25px; width:1100px;">
        <form id="form_" method="post" action="<?= base_url() ?>index.php/main/save/t_settu" >
        <table>
            <tr>
                <td>Organizer</td>
                <td style="width:430px;">
                    <input type="text" class="input_txt" title='' id="organizer_id" name="organizer_id" style="width:150px;"/>
                    <input type="text" class="hid_value main_cus" title='' id="organizer_name" name="organizer_name" style="width:275px; padding-right:20px;" maxlength="100"/>
                </td>
                <td style="width:380px;">
                    <input type="button"  id="btnseettu_category" name="btnseettu_category" title="..." style="width:40px; margin-right:30px;"/> 
                </td>
                <td style=""> </td>
                 <td style="width:70px;">Seettu No</td>
                <td>
                    <input type="text" class="input_active_num" name="id" id="id" title="<?php echo $max_no; ?>"/>
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td> 
            </tr>

            <tr>
                <td>Address</td>
                <td colspan="3"><input type="text" class="input_txt" title="" id="address" name="address" style="width:427px;" maxlength="100"/></td>
                <td>Date</td>
                <td>
                    <input type="text" class="input_date_down_future" readonly="readonly" style="width:100px; text-align:right;" name="date" id="date" title="<?=date('Y-m-d')?>" />
                </td>  
            </tr> 
            
            <tr>
                <td width="100px;">Description</td>
                <td colspan="3"><input type="text" class="input_txt" title='' id="discription" name="discription" style=" padding: 3px;width:427px; margin-right: 223px; border: 1px solid #003399;"  /></td>
                <td style="width: 50px;">Ref No</td>
                <td>
                    <input type="text" class="input_active_num" name="ref_no" id="ref_no"/>
                    <!-- <input type="hidden" id="h_ref_id" name="hid" title="0" /> -->
                </td>
            </tr>

            <tr>
                <td>Salesman</td>
                <td colspan="3">
                    <input type="text" class="input_txt" title='' id="sales_rep_id" name="sales_rep_id" style="width:150px;"/>
                    <input type="text" class="hid_value main_cus" title='' id="sales_rep_name" name="sales_rep_name" style="width:275px; padding-right:20px;" maxlength="100"/>
                </td> 
                <td style="width: 50px;">Book No</td>
                <td>
                    <input type="text" class="input_active_num" name="book_no" id="book_no"/>
                </td>                            
            </tr>

            <tr>
                <td>Book Edition</td>
                <td colspan="3">
                    <input type="text" class="input_txt" id="book_edition" name="book_edition" style="width:150px;"/>
                    <input type="text" class="hid_value main_cus" id="book_des" name="book_des" style="width:275px; padding-right:20px;" maxlength="100"/>
                </td> 
                <td style="width: 50px;"></td>
                <td>
                </td>                            
            </tr>
             <tr>
                <td colspan="2"><br/><b>Seettu Item </b></td>
            </tr>
        </table>
            <table style="width:100%" id="tgrid" border="0" class="tbl">
                <thead>
                    <tr>
                        <th class="tb_head_th" style="width: 30px;">S/N</th>
                        <th class="tb_head_th" style='width: 110px;'>Category</th>
                        <th class="tb_head_th" style='width: 110px;'>Item Code</th>
                        <th class="tb_head_th" style="width: 520px;">Description</th>
                        <th class="tb_head_th" style="width: 110px;">Value</th>
                        <th class="tb_head_th" style="width: 80px;">No of Ins</th>
                        <th class="tb_head_th" style="width: 110px;">Installment</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $r=1;
                for ($x = 0; $x < 25; $x++) {

                    echo "<tr>";
                    echo "<td>
                            <input type='hidden' name='h_".$x."' id='h_".$x."' title='0' />
                            <input type='text' title='".$r."' class='g_col_fixed'  id='n_" . $x . "'style='width : 100%;text-align:right;'/></td>";
                    echo "<td><input type='text' class='cat input_txt' id='cat_" . $x . "' name='cat_" . $x . "' style='width : 100%;text-align:left;'/></td>";        
                    echo "<td><input type='text' class='fo input_txt' id='0_" . $x . "' name='0_" . $x . "' style='width : 100%;text-align:left;'/></td>";
                    echo "<td><input type='text' class='input_txt g_col_fixed' id='2_" . $x . "' name='2_" . $x . "' style='width : 100%;'/></td>";
                    echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='3_" . $x . "' name='3_" . $x . "' style='width : 100%;text-align:right;'/></td>";
                    echo "<td><input type='text' class='g_input_amo amount g_col_fixed' id='4_" . $x . "' name='4_" . $x . "' style='width : 100%;text-align:right;'/></td>";
                    echo "<td>
                              <input type='text' class='g_input_amo amount g_col_fixed' id='5_" . $x . "' name='5_" . $x . "' style='width : 100%;text-align:right;' />
                              <input type='hidden'  id='cathid_".$x."' name='cathid_".$x."'/>
                         </td>";                                   
                    
                    echo "</tr>";
                    $r++;
                }
                ?>
                </tbody>
            </table>

            <table>
                <tr>
                  <!-- <td align="right" style="padding-left:778px;"> </td> -->
                  <td>
                   <!--  <input type="button"  id="btnadd_row" name="btnadd_row" title="Add Row" style="width:80px;"/>  -->
                  </td>
                  <td style='width: 110px;'> </td> 
                  <td  style="width: 627px; padding-right:20px; text-align:right;"><b>Total </b></td>
                  <td style="width: 110px;">
                        <input type="text" name="total_value" class="hid_value g_input_amounts g_input_amo" readonly="readonly" style="width:119px;" id="total_value"/>
                  </td>
                  <td style="width: 80px;"></td>
                  <td> <input type="text" name="installment" class="hid_value g_input_amounts g_input_amo" readonly="readonly" style="width:119px;" id="installment"/></td>
                </tr>
            </table>
                                                 
            <table>
                <?php 
                if($this->user_permissions->is_print('t_settu')){ ?>
                    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
                <?php } ?> 
               <tr>
                <td colspan="7"><br/>
                    <input type="button" id="btnExit" title="Exit" />
                    <input type="button" id="btnResett" title="Reset" />
                    <?php if($this->user_permissions->is_delete('t_settu')){ ?><input type="button" id="btnDelete" title="Cancel" /><?php } ?>
                    <?php if($this->user_permissions->is_re_print('t_settu')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>              
                    <?php if($this->user_permissions->is_add('t_settu')){ ?><input type="button" title='Save <F8>' id="btnSave"/><?php } ?>
                </td>   
                </tr>
            </table>                
          </form>

         <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
             <input type="hidden" name='by' value='t_settu' title="t_settu" class="report">
             <input type="hidden" name='page' value='A4' title="A4" >
             <input type="hidden" name='orientation' value='P' title="P" >
             <input type="hidden" name='type' value='' title="" >
             <input type="hidden" name='header' value='false' title="false" >
             <input type="hidden" name='qno' value='' title="" id="qno" >
             <input type="hidden" name='print_type' value='p' title="p" id="print_type" >
             <input type="hidden" name='org_print' value='' title="" id="org_print">
        
         </form>
       </div>
    </td>
  </tr>
</table>
<?php } ?>