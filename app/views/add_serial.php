<script type='text/javascript' src='<?=base_url()?>js/add_serial.js'></script>
<input type="hidden" id="form_id" title="<?=base_url()?>index.php/main/save/"/>
<div id="light_serial" class="white_content3">
  <div style="width:650px;height:30px;background:#69f;padding:5px;">
    <h2>Insert Serials</h2>
  </div>
  <div class="dframe_serial" style="width:645px;margin:0;padding:0;">
    <table style="width:645px;" id="serial_tbl" border="0">
      <tbody id="serial_ttbl">
        <tr>
          <td><input type="text" id="type_0" class="input_txt sr_no" placeholder="Serial No" style="width:150px;" value="1" /></td>
          <td><input type="text" id="type_1" class="input_txt sr_no" placeholder="Serial No" style="width:150px;" value="1" /></td>
          <td><input type="text" id="type_2" class="input_txt sr_no" placeholder="Serial No" style="width:150px;" value="1" /></td>
          <td><input type="text" id="type_3" class="input_txt sr_no" placeholder="Serial No" style="width:150px;" value="1" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td style="float:right;">
            <input type='button' id='sbtn_exit' title="Exit"> 
            <input type='button' id='sbtn_save' title="Save">
          </td>
        </tr>
      </tfoot>
    </table>
    <input type='hidden' id='selected_serials' name='selected_serials'/>
  </div>
</div>