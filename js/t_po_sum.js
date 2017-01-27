$(document).ready(function(){
  $(".clz").css("display","none");
  $("#load_req_duplecate").css("display","none");
  $("#code").blur(function(){
    check_code();
  });

  $(".clz").click(function(){
    set_cid($(this).attr("id")); 
    $("#pop_search12").val();
    view_colors();
    $("#serch_pop12").center();
    $("#blocker").css("display", "block");
    setTimeout("$('#pop_search12').focus()", 100);
  });

  $("#pop_search12").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) {
      view_colors(); 
    }
  });

  $(document).keypress(function(e){
    if(e.keyCode ==45){
     add_new_row("1,hidden, ,h_,h_,0, ,0,0, | 0,text,g_input_txt fo,0_,0_,0,width:100%;, ,1, | 1,text,g_input_txt g_col_fixed,n_,n_,1,width:100%;, ,1 | 1,text,g_input_num g_col_fixed,1_,1_,1,width:100%;, ,1 |1,text,g_input_num g_col_fixed,2_,2_,1,width:100%;, ,1 | 1,text,g_input_num qty,3_,3_,0,width:100%;, ,1 | 1,text,g_input_amo price g_col_fixed,4_,4_,1,width:100%;, ,1 | 1,text,g_input_amo g_col_fixed amount,5_,5_,1,width:100%;, ,0 | 0,hidden, ,nno_,nno_,0, , ,0 | 0,hidden, ,bc_,bc_,0, , ,0 | 0,hidden, ,cl_,cl_,0, , ,1 ");  
   }
 });


  $.post("index.php/main/load_data/t_po_sum/get_max_no_type", {
    table:'t_po_sum',
    nno:'nno',
    type:$("#type").val(),
    hid:$("#hid").val(),
  }, function(res){
    $("#id").val(res);
    empty_grid();
    empty_all();
  },"text");

  $(document).on('dblclick', '.fo',function(){
    set_cid($(this).attr("id"));  
    if($(this).val()!=""){
      $.post("index.php/main/load_data/utility/get_sub_item_detail4", {
        code:$(this).val(),
        store:$("#stores").val(),
        po:$("#pono").val(),
        qty:$("#2_"+scid).val(),
        date:$("#date").val()
      }, function(res){
        if(res!=0){
          $("#msg_box_inner").html(res);
          $("#msg_box").slideDown();
        }
      },"text");
    } 
  });


  $(document).on('click','#load_qty',function(){
    $.post("index.php/main/load_data/utility/previous_qty", {
      avg_from:$("#avg_from").val(),
      avg_to:$("#avg_to").val(), 
      item:$("#0_"+scid).val(),             
    }, function(res){
      $("#grn_qty").val(res.grn);
      $("#sale_qty").val(res.sales);

    },"json");

  });

  $("f_sup").val("1");
  $("#cost_print").click(function(){
    if($("#cost_print").is(":checked")){
      $("#cost_prnt").val("1");
        //alert($("#cost_prnt").val());
      }else{
        $("#cost_prnt").val("0");
      }

    });
  $("#f_sup").val("1");
  $("#filter_s").click(function(){
    if($("#filter_s").is(':checked')){
      $("#f_sup").val("1");
    }else{
      $("#f_sup").val("0");
    }
  });

  $("#btnEmail").click(function(){
    if($("#hid").val()=="0"){
      set_msg("Please load data before send Email");
      return false;
    }else{
      $("#print_type").val("e");
      $("#print_pdf").submit();
    }      
  });

  $("#load_rol").click(function(){
    load_rol("l");
  });

  $("#load_roq").click(function(){
    load_rol("q");
  });



  $(document).on('focus','.input_date_down_future',function(){
    $(".input_date_down_future").datepicker({
      showButtonPanel: false,
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd',
      beforeShow: function (input, inst) {
        var offset = $(input).offset();
        var height = $(input).height();
        window.setTimeout(function () {
          inst.dpDiv.css({ top: (offset.top + height + 4) + 'px', left: offset.left + 'px' })
        }, 1);
      }        
    });
  });

  $("#tgrid").tableScroll({height:355});

  $("#load_req").click(function(){
    if($("#approve_no").val()!=""){
      load_request_note();
    }else{
      set_msg("Please select approve no");
    }
  });


  $("#btnDelete").click(function(){
    if($("#hid").val()!=0) {
      set_delete($("#hid").val());
    }
  });

  $("#btnPrint").click(function(){
    if($("#hid").val()=="0"){
      set_msg("Please load data before print");
      return false;
    }else{
      $("#print_pdf").submit();
    }
  });

  $("#supplier_id").change(function(){
    empty_grid();
  });

  $("#supplier_id").autocomplete('index.php/main/load_data/m_supplier/auto_com', {
    width: 350,
    multiple: false,
    matchContains: true,
    formatItem: formatItems,
    formatResult: formatItemsResult
  });


  $("#supplier_id").keypress(function(e){
    if(e.keyCode == 13){
      set_cus_values($(this));
    }
  });

  $("#supplier_id").blur(function(){
    set_cus_values($(this));
  });

  $("#approve_no").keypress(function(e){
   if(e.keyCode==112){
     $("#pop_search").val($("#0_"+scid).val());
     load_request();
     $("#serch_pop").center();
     $("#blocker").css("display", "block");
     setTimeout("select_search()", 100);
   } 

   $("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { 
      load_request();
    }
  });
 });

  $(document).on('keypress','.fo',function(e){
    set_cid($(this).attr("id"));
    if($("#f_sup").val()=="1" && $("#supplier_id").val()==""){
      set_msg("Please enter supplier");
    }else{

     if(e.keyCode==112){
       $("#pop_search").val($(".fo").val());
       load_items();
       $("#serch_pop").center();
       $("#blocker").css("display", "block");
       setTimeout("select_search()", 100);
     }
   }

   if(e.keyCode==13){
    $.post("/index.php/main/load_data/t_po_sum/get_item", {
      code:$("#0_"+scid).val()
    }, function(res){
      if(res.a!=2){
        $("#0_"+scid).val(res.a[0].code);

        if(check_item_exist($("#0_"+scid).val())){
          $("#h_"+scid).val(res.a[0].code);
          $("#n_"+scid).val(res.a[0].description);
          $("#0_"+scid).val(res.a[0].code);
          $("#2_"+scid).val(res.a[0].purchase_price);


          $("#1_"+scid).focus();
        }else{
          set_msg("Item "+$("#0_"+scid).val()+" is already added.");
        }

      }
    }, "json");

  }

  if(e.keyCode==46){

    $("#h_"+scid).val("");
    $("#0_"+scid).val("");
    $("#n_"+scid).val("");
    $("#1_"+scid).val(""); 
    $("#2_"+scid).val(""); 
    $("#3_"+scid).val(""); 
    $("#5_"+scid).val(""); 
    $("#5_"+scid).val("");
    $("#6_"+scid).val(""); 
    $("#7_"+scid).val(""); 
    $("#8_"+scid).val(""); 
    $("#9_"+scid).val("");
    $("#colc_"+scid).val(""); 
    $("#col_"+scid).val(""); 
    $("#color_"+scid).css("display","none"); 

    $(".qty").blur();

  }

  $("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { 
      load_items();
    }
  });


});

$("#pop_search").gselect(); 
$(document).on('blur','.qty, .price',function(e){
 set_cid($(this).attr("id"));
 var qty=parseFloat($("#3_"+scid).val());
 var price=parseFloat($("#4_"+scid).val());

 if(isNaN(qty)){ qty=0; }
 if(isNaN(price)){ price=0; }

 var amount=qty*price;
 if(amount==0){amount="";}else{
   $("#5_"+scid).val(m_round(amount));
 }


 var loop=total_amount=0; 
 for(var f=0; f<=$("#row_count").val(); f++){
   var get_amount=parseFloat($("#5_"+loop).val()); 
   if(isNaN(get_amount)){ get_amount=0;}
   total_amount=total_amount+get_amount;
   loop++;
 }
 $("#total2").val(m_round(total_amount));
});


$("#id").keypress(function(e){
  if(e.keyCode == 13){
    $(this).blur();
    load_data($(this).val());
    $(this).attr("readonly","readonly");
    $("#load_req").css("display","none");
    $("#load_req_duplecate").css("display","inline");
  }
});

$("#supplier_id").keypress(function(e){ 
  if(e.keyCode==112){
    $("#pop_search2").val($("#supplier_id").val());
    load_sup();
    $("#serch_pop2").center();
    $("#blocker2").css("display", "block");
    setTimeout("$('#pop_search2').focus()", 100);   
  }
  $("#pop_search2").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
      load_sup();
    }
  });
  if(e.keyCode==46){
   $("#supplier_id").val("");
   $("#supplier").val("");
 }  
}); 
});

function load_rol(type){
  $.post("index.php/main/load_data/t_po_sum/load_rol", {
    type:type
  }, function(r){
    if(r=="2"){
      set_msg("No items in rol quantity");
    }else{
      empty_grid();
      for(var i=0; i<r.length; i++){
        $("#h_"+i).val(r[i].code);
        $("#0_"+i).val(r[i].code);
        $("#n_"+i).val(r[i].description);
        $("#1_"+i).val(r[i].model);
        $("#2_"+i).val(r[i].current_qty);
        $("#4_"+i).val(r[i].purchase_price);
      }
    }
  }, "json");

}


function empty_all(){
  $("#supplier_id").val("");
  $("#supplier").val("");
  $("#approve_no").val("");
  $("#memo").val("");
  $("#ref_no").val("");
}

function set_cus_values(f){
  var v = f.val();
  v = v.split("|");
  if(v.length == 2){
    f.val(v[0]);
    $("#supplier").val(v[1]);
  }
}


function formatItems(row){
  return "<strong> " +row[0] + "</strong> | <strong> " +row[1] + "</strong>";
}

function formatItemsResult(row){
  return row[0]+"|"+row[1];
}


function save(){
  var frm = $('#form_');
  loding();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (pid){
      if(pid == 1){               
        $("#btnSave").attr("disabled",true);
        loding();
        if(confirm("Save Completed, Do You Want A print?")){
          if($("#is_prnt").val()==1){
            $("#qno").val($("#id").val());
            $("#print_pdf").submit();
          }
          reload_form();
        }else{
          location.href="";
        }  
      }else if(pid == 2){
        set_msg("No permission to add data.");
      }else if(pid == 3){
        set_msg("No permission to edit data.");
      }else{
       loding();
       set_msg(pid);
     }

   }
 });
}


function reload_form(){
  setTimeout(function(){
    location.href= '';
  },50); 
}


function load_sup(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_supplier",
    field:"code",
    field2:"name",
    preview2:"Supplier Name",
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html(r);
    settings_sup();      
  }, "text");
}

function settings_sup(){
  $("#item_list .cl").click(function(){        
    $("#supplier_id").val($(this).children().eq(0).html());
    $("#supplier").val($(this).children().eq(1).html());
    $("#pop_close2").click();                
  })    
}


function validate(){
  if($("#id").val()==""){
    set_msg("Please enter id");
    return false
  }else if($("#supplier_id").val()=="" || $("#supplier").val()==""){
    set_msg("Please enter supplier.");
    return false;
  }else{
    return true;
  }
}


function set_delete(id){
  if(confirm("Are you sure to delete transaction no "+id+"?")){
    loding();
    $.post("index.php/main/delete/t_po_sum", {
      id : id,
      type: $("#type").val()
    }, function(res){
      if(res == 1){
        loding();
        delete_msg();
      }else if(res == 2){
        set_msg("No permission to cancel data.");
      }else{
        set_msg(res);
      }

    }, "text");
  }
}

function is_edit($mod){
  $.post("index.php/main/is_edit/user_permissions/is_edit", {
    module : $mod
  }, function(r){
   if(r==1){
    $("#btnSave").removeAttr("disabled", "disabled");
  }else{
    $("#btnSave").attr("disabled", "disabled");
  }
}, "json");
}

function set_edit(code){
  loding();
  $.post("index.php/main/get_data/t_po_sum", {
    code : code
  }, function(res){
    $("#code_").val(res.code);
    $("#code").val(res.code);
    $("#code").attr("readonly", true);
    $("#description").val(res.description);

    if(res.is_vehical == 1){
      $("#is_vehical").attr("checked", "checked");
    }else{
      $("#is_vehical").removeAttr("checked");
    }



       // is_edit('010');
       loding(); input_active();
     }, "json");
}


function select_search(){
  $("#pop_search").focus();

}

function load_items(){

  $.post("index.php/main/load_data/t_po_sum/item_list_all", {
    search : $("#pop_search").val(),
    filter : $("#f_sup").val(),
    stores : false,
    supplier: $("#supplier_id").val()
  }, function(r){
    $("#sr").html(r);
    settings_item();        
  }, "text");
  
}

function settings_item(){
  $("#item_list .cl").click(function(){
    if(check_item_exist($(this).children().eq(0).html())){
      $("#h_"+scid).val($(this).children().eq(0).html());
      $("#0_"+scid).val($(this).children().eq(0).html());
      $("#n_"+scid).val($(this).children().eq(1).html());
      $("#1_"+scid).val($(this).children().eq(2).html());
      $("#4_"+scid).val($(this).children().eq(3).html());   

      is_color_item($(this).children().eq(0).html(),scid);
      $("#3_"+scid).focus();
      $("#pop_close").click();
      if($(this).children().eq(4).html()=="1"){
        $("#pop_search12").val();
        view_colors();
        $("#serch_pop12").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search12').focus()", 100);
      }else{
        set_default_color();   
      }
    }else{
      set_msg($(this).children().eq(1).html()+" is already added.");
      $("#pop_close").click(); 
    }     
  });
}


function settings(){
  $("#item_list .cl").click(function(){
    if($(this).children().eq(0).html() != "&nbsp;"){
      $("#approve_no").val($(this).children().eq(0).html());
      $("#pop_close").click();
    }
  });
}

function check_item_exist(id){
  var v = true;
  $("input[type='hidden']").each(function(){
    if($(this).val() == id){
      v = false;
    }
  });

  return v;
}

function load_request_note(){
  empty_grid();
  $.post("index.php/main/load_data/t_po_sum/load_request_note",{
    nno:$("#approve_no").val(),
    type:$("#type").val()
  },function(r){
    if(r.det!=2){

     for(var i=0; i<r.det.length;i++){
      $("#h_"+i).val(r.det[i].item);
      $("#0_"+i).val(r.det[i].item);
      $("#n_"+i).val(r.det[i].description);
      $("#1_"+i).val(r.det[i].model);
      $("#2_"+i).val(r.det[i].cur_qty);
      $("#3_"+i).val(r.det[i].approve_qty);
      $("#4_"+i).val(r.det[i].purchase_price);
      $("#5_"+i).val(r.det[i].total);
      $("#nno_"+i).val(r.det[i].nno);
      $("#bc_"+i).val(r.det[i].bc);
      $("#cl_"+i).val(r.det[i].cl);                    
    }

    $("#supplier_id").val(r.det[0].supplier);
    $("#supplier").val(r.det[0].name);
    $(".price").blur();
  }else{
    set_msg("No Data");
  }
},"json");
}


function load_data(id){
  empty_grid();
  loding();
  $.post("index.php/main/get_data/t_po_sum/", {
    id: id,
    type:$("#type").val()

  }, function(r){

    if(r=="2"){
      set_msg("No records");
    }else{
      if(r.sum[0].is_cancel=="1"){
        $("#mframe").css("background-image", "url('img/cancel.png')");
        $("#btnSave").attr('disabled','disabled');
        $("#btnDelete").attr('disabled','disabled');

      }
      $("#hid").val(id);   
      $("#id").val(id); 
      $("#qno").val(id); 
      $("#supplier_id").val(r.supplier[0].supp_id);
      $("#supplier").val(r.supplier[0].name);
      $("#rep_sup").val(r.supplier[0].supp_id);
      $("#memo").val(r.sum[0].comment);
      $("#date").val(r.sum[0].ddate); 
      $("#ref_no").val(r.sum[0].ref_no);
      $("#total2").val(r.sum[0].total_amount);
      $("#deliver_date").val(r.sum[0].deliver_date);
      $("#ship_to_bc").val(r.sum[0].ship_to_bc);
      $("#rep_date").val(r.sum[0].ddate);
      $("#rep_deliver_date").val(r.sum[0].deliver_date);
      $("#approve_no").val(r.sum[0].approve_no);
      $("#type").val(r.sum[0].type);


      for(var i=0; i<r.det.length;i++){
        $("#h_"+i).val(r.det[i].item);
        $("#0_"+i).val(r.det[i].item);
        $("#n_"+i).val(r.det[i].description);
        $("#1_"+i).val(r.det[i].model);
        $("#2_"+i).val(r.det[i].current_qty);
        $("#3_"+i).val(r.det[i].qty);
        $("#4_"+i).val(r.det[i].cost);
        $("#5_"+i).val(r.det[i].amount);
        $("#colc_"+i).val(r.det[i].color_code);
        $("#col_"+i).val(r.det[i].color);
        is_color_item(r.det[i].item,i);
      }
    }
    loding();
  }, "json");  
}


function empty_grid(){
  for(var i=0; i<=$("#row_count").val(); i++){
    $("#h_"+i).val(0);
    $("#0_"+i).val("");
    $("#n_"+i).val("");
    $("#t_"+i).html("&nbsp;");
    $("#1_"+i).val("");
    $("#2_"+i).val("");
    $("#3_"+i).val("");
    $("#5_"+i).val("");
    $("#4_"+i).val("");
    $("#6_"+i).val("");
    $("#7_"+i).val("");
    $("#8_"+i).val("");
    $("#9_"+i).val("");
    $("#colc_"+i).val(""); 
    $("#col_"+i).val(""); 
    $("#color_"+i).css("display","none");
  }
}

function load_request(){
  var type=$("#type").val();

  $.post("index.php/main/load_data/t_po_sum/f1_selection_list_po", {
    search : $("#pop_search").val(),
    type: $("#type").val()
  }, function(r){
    $("#sr").html(r);
    settings();   
  }, "text");
}

function view_colors(){
 $.post("index.php/main/load_data/utility/f1_selection_list", {
  data_tbl:"r_color",
  field:"code",
  field2:"description",
  preview2:"Color",
  search : $("#pop_search12").val() 
}, function(r){
  $("#sr12").html(r);
  settings_color();            
}, "text");
}

function settings_color(){
  $("#item_list .cl").click(function(){      
    if(check_item_exist2($(this).children().eq(0).html(),$("#0_"+scid).val())){  
      $("#colc_"+scid).val($(this).children().eq(0).html());
      $("#col_"+scid).val($(this).children().eq(1).html());
      $("#pop_close12").click();   
    }else{
      set_msg($("#0_"+scid).val()+" "+$(this).children().eq(1).html()+" is already added This Item.");
    }
  })    
}

function check_item_exist2(color,item){ 
  var v = true;
  $("input[type='hidden']").each(function(e){
    if($("#0_"+e).val()==item && $("#colc_"+e).val() == color){
      v = false;
    }
  });
  return v;
}


function set_default_color(){
  $.post("index.php/main/load_data/utility/default_color", {
  }, function(r){
    if(r!=""){
      if(check_item_exist2(r,$("#0_"+scid).val())){
        $("#colc_"+scid).val(r);   
      }else{
        set_msg($("#0_"+scid).val()+" is already added This Item.");
        $("#h_"+scid).val(0);
        $("#0_"+scid).val("");
        $("#n_"+scid).val("");
        $("#t_"+scid).html("&nbsp;");
        $("#1_"+scid).val("");
        $("#2_"+scid).val("");
        $("#3_"+scid).val("");
        $("#5_"+scid).val("");
        $("#4_"+scid).val("");
        $("#6_"+scid).val("");
        $("#7_"+scid).val("");
        $("#8_"+scid).val("");
        $("#9_"+scid).val("");
      }
    }else{
      set_msg('Please Set Default Color First');
    }   
  }, "json");
}

function is_color_item(i_code,scid){
  $.post("index.php/main/load_data/utility/is_color_item",{
    code:i_code
  },function(res){
    $("#color_"+scid).css("display","none"); 
    if(res==1){
      $("#color_"+scid).css("display","block");
    }
  },'text');
}