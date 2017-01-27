<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<script type="text/javascript" src="<?=base_url()?>js/t_direct_internal_transfer.js"></script>

<div id="fade" class="black_overlay"></div>
<?php 
    $this->load->view('t_serial_out.php');
    $this->load->view('add_serial.php');
     ?>
<div id="fade" class="black_overlay"></div>

<h2 style="text-align: center;">Direct Internal Transfer</h2>
<div class="dframe" id="mframe" style="padding-right:25px; width: 1280px;">
    <form method="post" action="<?=base_url()?>index.php/main/save/t_direct_internal_transfer" id="form_">
        <input type="hidden" id="cluster"  title="<?=$cluster?>" />
        <input type="hidden" id="branch"  title="<?=$branch?>" />
        <table style="width: 100%" border="0">
            <tr>
                <td style="width: 100px;">From Cluster</td>
                <td style="width: 350px;">
                    <input type='text' name='frm_cluster' id='frm_cluster' class='input_active' title="<?=$cluster?>" readonly style='width:150px;'/>
                    <input type="text"  class="hid_value"  id="from_cluster_name"  title="<?=$cluster_name?>" style="width: 200px;" />
                    <input type="hidden" name="df_is_serial" id="df_is_serial" value="<?php echo $ds['use_serial_no_items'] ?>" title="<?php echo $ds['use_serial_no_items'] ?>"/>
                </td>
                <td style="width: 100px;">To Cluster</td>
                <td style="width: 450px;">
                    <input type='text' name='to_cluster' id='to_cluster' class='input_active' readonly style='width:150px;'/>
                    <input type="text"  class="hid_value"  id="to_cluster_name"  title="" style="width: 200px;" />
                </td>
                <td style="width: 50px;">No</td>
                <td>
                    <input type="text" class="input_active_num" name="id" id="id" style="width:100%" title="<?=$id?>" />
                    <input type="hidden" id="hid" name="hid" title="0" />
                </td>
            </tr>
            <tr>
                <td style="width: 100px;">From Branch</td>
                <td style="width: 350px;">
                    <input type='text' name='frm_branch' id='frm_branch' class='input_active' title="<?=$branch?>" readonly style='width:150px;'/>
                    <input type="text"  class="hid_value"  id="from_branch_name"  title="<?=$branch_name?>" style="width: 200px;" />
                </td>
                <td style="width: 100px;">To Branch</td>
                <td style="width: 450px;">
                    <input type='text' name='to_branch' id='to_branch' class='input_active' readonly style='width:150px;'/>
                    <input type="text"  class="hid_value"  id="to_branch_name"  title="" style="width: 200px;" />
                </td>
                <td style="width: 100px;">Date</td>
                <td style="width: 100px;">
                    <input type="text" class="input_date_down_future" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align:right;width:100%;"/>
                   <!--  <?php if($this->user_permissions->is_back_date('t_direct_internal_transfer')){ ?>
                    <?php } else { ?>
                    <input type="text" class="input_txt" readonly="readonly" name="date" id="date" title="<?=date('Y-m-d')?>" style="text-align:right;width:100%;"/>
                    <?php } ?>    --> 
                </td>
            </tr>

            <tr>
                <td style="width: 100px;">From Stores</td>
                <td style="width: 350px;">
                    <input type='text' name='frm_stores' id='frm_stores' class='input_active store11' readonly style='width:150px;'/>
                    <input type="text"  class="hid_value"  id="from_stores_name"  title="" style="width: 200px;" />
                </td>
                <td style="width: 100px;">Transfer Location</td>
                <td style="width: 450px;">
                    <input type='text' name='to_stores' id='to_stores' class='input_active' readonly style='width:150px;'/>
                    <input type="text"  class="hid_value"  id="to_stores_name"  title="" style="width: 200px;" />
                </td>
                <td style="width: 100px;">Ref. No</td>
                <td style="width: 100px;"><input type="text" class="input_txt" name="ref_no" id="ref_no" title="" style="width: 100%; text-align:right;" maxlength="25"/></td>
            </tr>

            <tr>
                <td>Memo</td>
                <td>
                   <input type="text" class="input_txt" name="memo" id="memo" title="" style="width:353px;"/>
               </td>
               <td colspan="2">
               <input type="button" id="add_serials" title="Add Serial Numbers"/>
               <input type="hidden" id="chk_find" title="1" />
               </td>
           </tr>

           <tr>
            <td colspan="6"> 
                <table style="width:100%;" id="tgrid" cellpadding="0" border="0">
                    <thead>
                        <tr>
                            <th class="tb_head_th" style="width: 120px;">Item Code</th>
                            <th colspan="5" class="tb_head_th">Name</th>
                            <th class="tb_head_th" style="width: 130px;">Model</th>
                            <th class="tb_head_th" style="width: 90px;">Batch No</th>
                            <th class="tb_head_th" style="width: 90px;">Cost Price</th>
                            <th class="tb_head_th" style="width: 90px;">Min Price</th>
                            <th class="tb_head_th" style="width: 90px;">Max Price</th>
                            <th class="tb_head_th" style="width: 70px;">Qty</th>
                            <th class="tb_head_th" style="width: 90px;">Amount</th>

                        </tr>
                    </thead><tbody>
                    <input type='hidden' id='transtype' title='DIRECT TRANSFER' value='DIRECT TRANSFER' name='transtype' />
                    <?php
                                //if will change this counter value of 25. then have to change edit model save function.
                    for($x=0; $x<25; $x++){
                        echo "<tr>";

                        echo "<td><input type='text' class='g_input_txt fo sitem_".$x."' id='0_".$x."' name='0_".$x."' style='background-color: #f9f9ec;width:100%;'/></td>
                        <input type='hidden' id='setserial_".$x."' title='0' name='setserial_".$x."' />
                        <input type='hidden' id='all_serial_".$x."' title='0' name='all_serial_".$x."' />
                        <input type='hidden' id='numofserial_".$x."' title='' name='numofserial_".$x."' />
                        <input type='hidden' id='itemcode_".$x."' title='0' name='itemcode_".$x."' />  ";
                        echo "<td colspan='5'><input type='text' class='g_input_txt ides_".$x." ' id='1_".$x."' name='1_".$x."' style='width : 100%;'/></td>";
                        echo "<td><input type='text' class='g_input_txt imdl_".$x."' id='m_".$x."' name='m_".$x."' style='width : 100%;'/></td>";
                        echo "<td><input type='button'  class='qunsb' id='btnb_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
                        <input type='text' class='g_input_txt txt_align btt_".$x."' id='2_".$x."' name='2_".$x."' style='width :40px; float: right;'/></td>";
                        echo "<td><input type='text' class='g_input_amo g_col_fixed icst_".$x."' id='cost_".$x."' name='cost_".$x."' style='width : 100%;'/></td>";
                        echo "<td><input type='text' class='g_input_amo g_col_fixed imin_".$x."' id='min_".$x."' name='min_".$x."' style='width : 100%;'/></td>";
                        echo "<td><input type='text' class='g_input_amo g_col_fixed imax_".$x."' id='max_".$x."' name='max_".$x."' style='width : 100%;'/></td>";

                        echo "<td><input type='button'  class='quns' id='btn_".$x."' style='margin:0;padding:5px;float: left; height:6px;width:6px;cursor:pointer'/>
                        <input type='text' class='g_input_txt txt_align chk qun qtycl".$x." ky' id='3_".$x."' name='3_".$x."' style='float:right;width:40px;'/>
                        <input type='hidden' id='qtyh_".$x."' name='qtyh_".$x."' /></td>";
                        echo "<td><input type='text' class='g_amount g_input_amo tot_".$x."' id='amount_".$x."' name='amount_".$x."' />
                        <input type='hidden' id='subcode_".$x."' title='0' name='subcode_".$x."' />
                        <input type='hidden' id='isaddse_".$x."' title='0' />
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>

                    <tr>
                      <td>Officer</td>
                      <td colspan="0">
                       <input type="text"  name="officer" id="officer" class="input_active" style="border:1px solid #039; background:#fff;" title="" />
                       <input type="text"  name="officer_id" id="officer_id" class="input_active" title=""  style="border:1px solid #039; background:#fff;width:420px;"/>
                    </td>
                    <td>Net Amount</td>
                    <td style="text-align: right;padding-right: 20px;">
                    <input type="text" name="net_amount" id="net_amount" class="input_active g_input_amo" style="border:1px solid #039; background:#fff; text-align: right;">
                    </td>

               </tr>
               <tr> <td colspan="8" style="height:10px;" ><hr class="hline"/></td></tr>
               <tr style="background-color: transparent;">

                <td colspan="7" style="padding-left : 10px;">
                    <input type="button" id="btnExit" title="Exit" />
                    <input type="button" id="btnReset" title="Reset" />
                    <!--<?php if($this->user_permissions->is_delete('t_direct_internal_transfer')){ ?><input type="button" id="btnDelete" title="Delete" /><?php } ?> -->
                    <?php if($this->user_permissions->is_re_print('t_direct_internal_transfer')){ ?><input type="button" id="btnPrint" title="Print" /><?php } ?>
                    <input type="hidden" name="type" id="type" title="loading" value="loading"  />
                    <?php if($this->user_permissions->is_add('t_direct_internal_transfer')){ ?><input type="button" id="btnSave" title='Save <F8>' /><?php } ?>
                    <!-- <input type="hidden" name='save_chk' value="0" title="0" id="save_chk" >  -->
                    <input type="hidden" name="srls" id="srls"/>
                    <input type='hidden' id='transCode' value='120' title='120'/>
                </td>
                </tr>
            </tfoot>
        </table>

    </td>
    <?php 
    if($this->user_permissions->is_print('t_direct_internal_transfer')){ ?>
    <input type="hidden" name='is_prnt' id='is_prnt' value="1" title="1">
    <?php } ?> 
</tr>
</table>
</form>

<form id="print_pdf" action="<?php echo site_url(); ?>/reports/generate" method="post" target="_blank">
    <input type="hidden" name='by' value='t_direct_internal_transfer' title="t_direct_internal_transfer" class="report">
    <input type="hidden" name='page' value='A4' title="A4" >
    <input type="hidden" name='orientation' value='P' title="P" >
    <input type="hidden" name='type1' value='NOTE' title="NOTE" >
    <input type="hidden" name='pdf_id' value='' title="" id="pdf_id" >
    <input type="hidden" name='qno' value='' title="" id="qno" >
    <input type="hidden" name='dd' title="<?=date('Y-m-d')?>" id="dd" >
    <input type="hidden" name='dt' value='' title="" id="dt" > 
</form>
</div>

