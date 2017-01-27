<?php if($this->user_permissions->is_view('f_find_serial')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<link href="<?=base_url()?>css/t_forms.css" type="text/css" rel="stylesheet">
<script type='text/javascript' src='<?=base_url()?>js/f_find_serial.js'></script>
<h2>Find Serial</h2>
<div class="dframe" id="mframe">
   <form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
      <table style="width:100%; margin-top:15px;" cellpadding="0" border="0" >
         <tr>
            <td style="width:100px;">Search</td>
            <td><input type="text" id="pop_searchs" name="search" class="input_txt" title="" style="width:350px;" title=""/>
            </td>
         </tr>
         <tr>
            <td colspan="3" height="20">
               <hr class="hline"/>
            </td>
         </tr>
      </table>
      <table style="width:100%;" cellpadding="0" id="grid">
         <thead>
            <tr>
               <th  class="tb_head_th" style="width:120px;">Trans Code</th>
               <th  class="tb_head_th" style="width:80px;">Trans No</th>
               <th  class="tb_head_th" style="">Trans Date</th>
               <th  class="tb_head_th" style="width:120px;">Item Code</th>
               <th  class="tb_head_th" style="width:200px;">Item Description</th>
               <th  class="tb_head_th" style="width:100px;">Serial No</th>
               <th  class="tb_head_th" style="width:80px;">Other No</th>
               <th  class="tb_head_th" style="width:80px;">Other No</th>
            </tr>
         </thead>
         <tbody id="searchType">
            <?php
               for($x=0; $x<25; $x++){
                    echo "<tr>";
                       echo "<td><input type='text' class='g_input_txt' id='0_".$x."' name='0_".$x."' style='border:dotted 1px #ccc;background-color:#f9f9ec;' readonly='readonly'/></td>";
                       echo "<td><input type='text' class='g_input_txt' id='n_".$x."' name='n_".$x."' style='border:dotted 1px #ccc;background:transparent;' readonly='readonly'/></td>";
		               echo "<td><input type='text' class='g_input_txt' id='2_".$x."' name='2_".$x."' style='border:dotted 1px #ccc;background:transparent;' readonly='readonly'/></td>";
		               echo "<td><input type='text' class='g_input_txt' id='3_".$x."' name='3_".$x."' style='border:dotted 1px #ccc;background:transparent;' readonly='readonly'/></td>";
		               echo "<td><input type='text' class='g_input_txt' id='4_".$x."' name='4_".$x."' style='background:transparent;border:dotted 1px #ccc;' readonly='readonly'/></td>";
		               echo "<td><input type='text' class='g_input_txt' id='5_".$x."' name='5_".$x."' style='background:transparent;border:dotted 1px #ccc;' readonly='readonly'/></td>";
		               echo "<td><input type='text' class='g_input_txt' id='6_".$x."' name='6_".$x."' style='border:dotted 1px #ccc;background:transparent;' readonly='readonly'/></td>";
		               echo "<td><input type='text' class='g_input_txt' id='7_".$x."' name='7_".$x."' style='background:transparent;border:dotted 1px #ccc;' readonly='readonly'/></td>";
                   	echo "</tr>";
               }
            ?>
         </tbody>
         <tfoot>
            <tr style="background-color: transparent;">
               <td style="text-align: right; font-weight: bold; font-size: 12px;"></td>
               <td>&nbsp;</td>
            </tr>
         </tfoot>
      </table>
      <table style="width:100%;">
         <input type="hidden" name='by' value='f_find_serial' title="f_find_serial" class="report">
         <input type="hidden" name='page' value='A4' title="A4" >
         <input type="hidden" name='orientation' value='L' title="L" >
         <input type="hidden" name='type' value='f_find_serial' title="f_find_serial" >
         <tr>
            <td align="right"><input type="button" id="btnExit" title="Exit" />
               <?php if($this->user_permissions->is_re_print('f_find_serial')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
               <input type="hidden" name="code_" id="code_"/>   
               <input name="button" type="button" id="btnReset" title='Reset' />
            </td>
         </tr>
      </table>
   </form>
</div>
<?php } ?>