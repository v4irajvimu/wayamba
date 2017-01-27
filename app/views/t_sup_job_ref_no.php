<?php if($this->user_permissions->is_view('t_sup_job_ref_no')){ ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/t_forms.css" />
<style type="text/css">
    #tgrid5 tr:hover{
        background-color: rgba(221,221,221,0.7);
    }

    .tgrid5{
        background-color: rgba(255,221,221,1);
    }

</style>
<script type="text/javascript" src="<?=base_url()?>js/t_sup_job_ref_no.js"></script>

<h2 style="text-align: center;">Supplier Job Referance No</h2>
<div class="dframe" id="mframe" style="width: 1200px;">
    <form method="post" action="" id="form_">
        <table style="width: 100%; -moz-user-select: none;" border="0">
            <tr>
                <td width="8%">Supplier</td>
                <td width="28%">
                    <input type="text" class="input_text" title='' name="sup_id" id="sup_id"  style="width:100px;">
                    <input type="text" class="hid_value" title='' name="sup_nm" id="sup_nm"  style="width:200px;">
                </td>

                <td colspan="2" rowspan="2" width="65%" valign="top">
                    <div>
                        <h3>Supplier Job Referance No : <input style="font-size:18px; font-weight:bold;" type="text" class='input_text' id='SJRNo' />
                        <input type='hidden' value='' id='UpCode' />
                        <input style="" type="button" title="Update" onClick='addSuNo();' />
                        </h3>
                    </div>
                </td>
 

            </tr>
            <tr>
                <td style="width: 10px;">Search Job</td>
                <td>
                    <input type="text" class="input_text" title='' name="serc_id" id="serc_id"  style="width:300px;">
                </td>


      

            </tr><tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>

            </tr>



          <tr>

                <td colspan="3" width="80%" style="text-align: center;">
                    <div style="height:360;overflow:auto;">
                    <table style="width: 100%; cursor:default;" id="tgrid5">
                        <thead>
                            <tr>
                                <th class="tb_head_th" style="width: 4%">Job No</th>
                                <th class="tb_head_th" style="width: 6%;">Inv.Date</th>
                                <th class="tb_head_th" style="width: 10%;">Inv.Type</th>
                                <th class="tb_head_th" style="width: 5%;">Inv.No</th>
                                <th class="tb_head_th" style="width: 15%;">Item Code</th>
                                <th class="tb_head_th" style="width: 15%;">Item</th>
                                <th class="tb_head_th" style="width: 10%;">Customer Code</th>
                                <th class="tb_head_th" style="width: 20%;">Customer</th>
                                <th class="tb_head_th" style="width: 8%;">Amount</th>
                                <th class="tb_head_th" style="width: 12%;">Supplier Job Referance No</th>

                               
                            </tr>
                        </thead><tbody id="GtGrData" style="cursor:pointer;">
                           <?php
                                //if will change this counter value of 25. then have to change edit model save function.
 
                               echo $get_grid_det;

 /*                               for($x=0; $x<25; $x++){
                                    echo "<tr class='gridTr' id='thId_".$x."'/>";
                                        echo "<td style='text-align:center;'><input type='checkbox' id='sel_".$x."' name='sel_".$x."' value='1'></td>";
                                        echo "<td><input type='text' class='g_input_txt fo' id='0_".$x."' name='0_".$x."'  /></td>";
                                        echo "<td><input type='text' class='g_input_txt'  id='n_".$x."' name='n_".$x."' maxlength='150'/></td>";
                                        echo "<td><input type='text' class='g_input_txt ' id='1_".$x."' name='1_".$x."' style='width:100%'/></td>";
                                        echo "<td><input type='text' class='g_input_txt' id='2_".$x."' name='2_".$x."' style='width:100%'/></td>";
                                        echo "<td><input type='text' class='g_input_txt' id='3_".$x."' name='3_".$x."' style='width:100%'/></td>";
                                        echo "<td><input type='text' class='g_input_txt' id='4_".$x."' name='4_".$x."' style='width:100%'/></td>";
                                        echo "<td style='text-align:center;'><input type='checkbox' id='gur_".$x."' name='gur_".$x."'></td>";
                                        echo "<td><input type='text' class='g_input_txt' id='5_".$x."' name='5_".$x."' style='width:100%'/></td>";
                                    echo "</tr>";
                                }*/
                            ?> 
              

                        </tbody>
                                               
                    </table>
                </div>
            </td>
<!--                 <td valign="top">
                    <div style="padding:0px 5px;">
                    <form method="post" action="<?=base_url()?>index.php/main/save/t_sup_job_ref_no" id="SupRefSub" >
                        <fieldset style="height:330px;">
                            <legend><strong>Supplier Job Referance No</strong></legend>
                            <div id="LdData">
                                 <h4 style="color:red;">* Please Double Click Row to Add Suppliers Job Referance Numbers</h4>
                            </div>
                        </fieldset>
                        

                    </form></div>

                </td> -->


            </tr>
      

            <tr>
               

                <td colspan="3">
                <h4 style="color:red;">* Please Double Click Row to Add Suppliers Job Referance Numbers</h4>
                            <div style="text-align: left; padding-top: 7px;">
                                <input type="button" id="btnExit" title="Exit" />
                                <input type="button" id="btnReset" title="Reset" />
                                  
                            </div>
          
                </td>


            </tr>
        </table>
    </form>
</div>
<?php } ?>
