 var storse = 0;
 var is_edit=0;
 var sub_items=[];

$(document).ready(function(){
  
  $(".quns").css("display","none");
  $(".subs").css("display","none");
  $(".clz").css("display","none");
  $("#btnPrint").click(function () {
    if ($("#hid").val() == "0") {
        set_msg("Please load data before print");
        return false;
    }else{
        $("#print_pdf").submit();
    }
  });

  $(".clz").click(function(){
    set_cid($(this).attr("id")); 
    $("#pop_search2").val();
    view_colors();
    $("#serch_pop2").center();
    $("#blocker2").css("display", "block");
    setTimeout("$('#pop_search2').focus()", 100);
  });

  $("#pop_search2").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) {
      view_colors(); 
    }
  });

 var is_serial = $("#df_is_serial").val();

  $(".fo").dblclick(function(){
  set_cid($(this).attr("id"));  
  if($(this).val()!=""){
      $.post("index.php/main/load_data/utility/get_sub_item_detail", {
          code:$(this).val(),
          store:$("#stores").val(),
          po:$("#pono").val(),
          qty:$("#1_"+scid).val()
      }, function(res){
          if(res!=0){
              $("#msg_box_inner").html(res);
              $("#msg_box").slideDown();
          }
      },"text");
     } 
  });

	$("#btnReset").click(function(){
   	location.href="?action=t_open_stock";
	});


default_option()

  $("#btnDelete5").click(function(){
    set_delete();
  });

   $(".fo").blur(function(){
     var id=$(this).attr("id").split("_")[1];
     if($(this).val()=="" || $(this).val()=="0"){
     }else if($(this).val()!=$("#itemcode_"+id).val()){
      if($("#df_is_serial").val()=='1'){
        // deleteSerial(id);
      }
     }
   });

    $("#load_rol").click(function(){
        load_rol("l");
    });



    $("#item_list").tableScroll({height:200});
    $("#stores").val(storse);
    set_select('stores', 'sto_des');

     $(".fo").focus(function(){
      if($("#stores").val()==0){
        set_msg("Please select store","error");
      }else{


    $(".fo").keypress(function(e){
        set_cid($(this).attr("id"));
        if(e.keyCode==112){
            load_items();
            $("#pop_search").select();       
            $("#serch_pop").center();
            $("#blocker").css("display", "block");
            setTimeout("select_search()", 100);
        }

        if(e.keyCode==46){
          if($("#df_is_serial").val()=='1'){
            $("#all_serial_"+scid).val("");
          }
            $("#h_"+scid).val("");
            $("#0_"+scid).val("");
            $("#n_"+scid).val("");
            $("#1_"+scid).val(""); 
            $("#2_"+scid).val(""); 
            $("#3_"+scid).val("");
            $("#m_"+scid).val("");
            $("#min_"+scid).val("");
            $("#max_"+scid).val("");
            $("#s3_"+scid).val(""); 
            $("#s4_"+scid).val(""); 
            $("#s5_"+scid).val(""); 
            $("#s6_"+scid).val(""); 
            $("#btn_"+scid).css("display","none");  
            $("#t_"+scid).html(""); 
            $("#subcode_"+scid).html(""); 
            $("#is_click_"+scid).val("");
            $("#sub_"+scid).css("display","none");
            $("#sub_"+scid).removeAttr("data-is_click");
            set_sub_total();
        }


        if(e.keyCode==13){
            $.post("index.php/main/load_data/t_open_stock/get_item", {
                code:$("#0_"+scid).val()
            }, function(res){
                if(res.a!=2){
                    $("#0_"+scid).val(res.a[0].code);

                        if(check_item_exist($("#0_"+scid).val())){

                          if($("#df_is_serial").val()=='1'){
                            check_is_serial_item2(res.a[0].code,scid); 
                          }
                          check_is_sub_item2(res.a[0].code,scid);
               
                          $("#h_"+scid).val(res.a[0].code);
                          $("#n_"+scid).val(res.a[0].description);
                          $("#0_"+scid).val(res.a[0].code);
                          $("#2_"+scid).val(res.a[0].purchase_price);
                          $("#m_"+scid).val(res.a[0].model);
                          $("#min_"+scid).val(res.a[0].min_price);
                          $("#max_"+scid).val(res.a[0].max_price);

                          $("#h_"+scid).attr("title" ,res.a[0].code);
                          $("#n_"+scid).attr("title" ,res.a[0].description);
                          $("#0_"+scid).attr("title" ,res.a[0].code);
                          $("#m_"+scid).attr("title" ,res.a[0].model);
                        
                          $("#1_"+scid).removeAttr("disabled"); 
                          $("#2_"+scid).removeAttr("disabled");
                          $("#3_"+scid).removeAttr("disabled");
                          $("#1_"+scid).focus();
                           
                        }else{
                            set_msg("Item "+$("#0_"+scid).val()+" is already added.");
                        }

                }
            }, "json");
        }
    });
  }
});

    
    load_items();

    $("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items();
        }
    });
    
    $("#tgrid").tableScroll({height:300});

    $("#pop_search").gselect();

   
    $("#id").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            load_data($(this).val());
        }
    });


function default_option(){
   
    $.post("index.php/main/load_data/utility/default_option", {
  }, function(r){
         
          $("#stores").val(r.def_sales_store);
          $("#sto_des").val(r.store);
         
 }, "json");
}



   function load_data(id){
    var g=[];
    empty_grid();
     loding();
    $.post("index.php/main/get_data/t_open_stock/", {
        nno: id
    }, function(r){
            
            if(r=="2"){
               set_msg("No records","error");
            }else{
              
           
              $("#hid").val(r.sum[0].nno);
              $("#qno").val(r.sum[0].nno);
              $("#id").attr("readonly",'readonly');
              $("#stores").val(r.sum[0].store);
              set_select('stores','sto_des');
              $("#ddate").val(r.sum[0].ddate);
              $("#ref_no").val(r.sum[0].ref_no);
              $("#total2").val(r.sum[0].net_amount);


                for(var i=0; i<r.det.length;i++){

                   $("#h_"+i).val(r.det[i].item_code);
                   $("#0_"+i).val(r.det[i].item_code);
                   $("#itemcode_"+i).val(r.det[i].item_code);
                   $("#min_"+i).val(r.det[i].min_price);
                   $("#max_"+i).val(r.det[i].max_price);
                   $("#s3_"+i).val(r.det[i].sale_price_3);
                   $("#s4_"+i).val(r.det[i].sale_price_4);
                   $("#s5_"+i).val(r.det[i].sale_price_5); 
                   $("#s6_"+i).val(r.det[i].sale_price_6); 
                   $("#n_"+i).val(r.det[i].item_desc);
                   $("#1_"+i).val(r.det[i].qty);
                   $("#m_"+i).val(r.det[i].model);
                   $("#col_"+i).val(r.det[i].color_des);
                   $("#colc_"+i).val(r.det[i].color_code);
                   $("#color_"+i).css("display","block");

                   if($("#df_is_serial").val()=='1')
                   {
                    check_is_serial_item2(r.det[i].item_code,i);
                    $("#numofserial_"+i).val(r.det[i].qty);

                    for(var a=0;a<r.serial.length;a++){
                      if(r.det[i].item_code==r.serial[a].item){
                        g.push(r.serial[a].serial_no+"-"+r.serial[a].other_no1+"-"+r.serial[a].other_no2);
                        $("#all_serial_"+i).val(g);
                      }   
                    }
                    g=[];  
                   }
                   
                    $("#2_"+i).val(r.det[i].cost);
                        var x = parseFloat($("#1_"+i).val());
                        var y = parseFloat($("#2_"+i).val());
                        var z;
                        if(! isNaN(x) && ! isNaN(y)){
                            z = x*y;
                            $("#t_"+i).html(m_round(z));
                        }else{
                            $("#t_"+i).html("0.00");
                        }
                  is_sub_item(i);
                  check_is_sub_item2(r.det[i].item_code,i); 
                }

                input_active();
            

                    if(r.sum[0].is_cancel==1){
                      $("#btnSave").attr("disabled", "disabled");
                      $("#btnDelete5").attr("disabled", "disabled");
                      $("#btnPrint").attr("disabled", "disabled");
                      set_msg("Transaction Canceled","error");
                      $("#btnDelete").attr("disabled", "disabled");
                      $("#btnSave").attr("disabled", "disabled");
                      $("#mframe").css("background-image", "url('img/cancel.png')");
                    }
     
              loding();     
          }

    }, "json");
}
    

    
    $("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items();}
    });
    

     $(".amo, .qun, .dis").blur(function(){
        set_cid($(this).attr("id"));    
        set_sub_total();
    });


    
    $("#id").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            load_data($(this).val());
        }
    });
    

    
    $("#stores").change(function(){
        set_select('stores', 'sto_des');
        load_items();
    });


    //serial coding

    $("#btnExit1").click(function(){
        
         document.getElementById('light').style.display='none';
         document.getElementById('fade').style.display='none';
    });    


    $(document).on("click",".subs",function(){
      set_cid($(this).attr("id"));
      check_is_sub_item(scid); 
      $("#is_click_"+scid).val("1");    
   });


  $(document).on("click",".approve",function(){
    var q="";
    $(".approve").each(function(e){
      if($('#app_' +e).is(":checked")){
        q=q+$("#sub_"+e).text()+"-"+$("#subqty_"+e).text()+",";
      }
    });
      $("#subcode_"+scid).val(q);
  });

});


function is_sub_item(x){
  $.post("index.php/main/load_data/utility/is_sub_items_load", {
        code:$("#0_"+x).val(),
       hid:$("#hid").val(),
       type:'2'
      }, function(r){
        if(r!=2){
          sub_items=[];
            var a = "";
          for(var i=0; i<r.sub.length;i++){
            //sub_items.push(r.sub[i].sub_item+"-"+r.sub[i].qty_in);
            a=a+r.sub[i].sub_item+"-"+r.sub[i].qty+",";
          }  
            $("#subcode_"+x).val(a);
        }
      },"json");
}

function select_search3(){
    $("#pop_search3").focus();
}


function check_is_sub_item(scid){        
    var store=$("#stores").val();
    $.post("index.php/main/load_data/utility/is_sub_item",{
        code:$("#0_"+scid).val(),          
    },function(res){        
       if(res==1)
        {
            $("#serch_pop3").center();
            $("#blocker3").css("display", "block");
            setTimeout("select_search3()", 100);
            load_items4($("#0_"+scid).val());
        }
    },'text');    
}


function load_items4(x){
    $.post("index.php/main/load_data/utility/sub_item_window", {
        search : x,
    }, function(r){
        $("#sr3").html(r);
        match_sub_item();
    }, "text");

}

function match_sub_item(){
  if($("#subcode_"+scid).val()!="" && $("#subcode_"+scid).val()!=0){ 
    var hid_subs = $("#subcode_"+scid).val();
    var scode = hid_subs.split(",");
    for(var c =0; c<scode.length; c++){
      var sub_item = scode[c].split("-");
      var item =sub_item[0];
      var qty =sub_item[1];

      $(".approve").each(function(e){
        if($("#sub_"+e).text()==item){
          $("#app_"+e).prop('checked',true);
        }
      });
    } 
  }
}


function check_is_sub_item2(x,scid){
    var store=$("#stores").val();
    $.post("index.php/main/load_data/utility/is_sub_item",{
        code:x          
     },function(res){
        $("#sub_"+scid).css("display","none");    
        if(res==1){
            $("#sub_"+scid).css("display","block");
            $("#sub_"+scid).attr("data-is_click","1");
        }
    },'text');
}


  function set_delete(){
    if($("#df_is_serial").val()=='1'){
      serial_items.sort();
      $("#srls").attr("title",serial_items);
      $("#srls").val(serial_items);   
    }

    var id = $("#hid").val();
    
    if(id != 0){
      if(confirm("Are you sure to delete this open stock ["+$("#id").val()+"]? ")){
        $.post("index.php/main/delete/t_open_stock", {
          trans_no:id,
        },function(r){
            if(r != 1){
              set_msg(r,"error");
            }else{
              delete_msg();
            }
        }, "text");
      }
    }else{
      set_msg("Please load record","error");
    }
  }

function empty_grid(){
    for(var i=0; i<25; i++){
        $("#h_"+i).val(0);
        $("#is_ser_"+i).val(0);
        $("#is_ser_upt_"+i).val(0);
        $("#0_"+i).val("");
        $("#n_"+i).val("");
        $("#t_"+i).html("&nbsp;");
        $("#1_"+i).val("");
        $("#2_"+i).val("");
        $("#3_"+i).val("");
        $("#s3_"+scid).val(""); 
        $("#s4_"+scid).val(""); 
        $("#s5_"+scid).val("");
        $("#s6_"+scid).val(""); 
        $("#subcode_"+i).val("");
        $("#is_click_"+i).val("");
        $("#sub_"+i).removeAttr("data-is_click");
    }
       $(".quns").css("display","none");
       $(".subs").css("display","none");
}

function set_sub_total(){
    var x = parseFloat($("#1_"+scid).val());
    var y = parseFloat($("#2_"+scid).val());
    var z;
    if(! isNaN(x) && ! isNaN(y)){
        z = x*y;
        $("#t_"+scid).html(m_round(z));
    }else{
        $("#t_"+scid).html("0.00");
    }
    
    set_total();
}


function select_search(){
    $("#pop_search").focus();
}


function load_items(){
    $.post("index.php/main/load_data/t_open_stock/item_list_all", {
        search : $("#pop_search").val(),
        stores : $("#stores").val(),
        def_sales3:$("#def_sales3").val(),
        def_sales4:$("#def_sales4").val(),
        def_sales5:$("#def_sales5").val(),
        def_sales6:$("#def_sales6").val(),
    }, function(r){
        $("#sr").html(r);
        settings();
    }, "text");
}

function settings(){
    $("#item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
           /* if(check_item_exist($(this).children().eq(0).html())){*/
              if($("#df_is_serial").val()=='1'){
                check_is_serial_item2($(this).children().eq(0).html(),scid); 
              }
                check_is_sub_item2($(this).children().eq(0).html(),scid);

                $("#h_"+scid).val($(this).children().eq(0).html());
                $("#0_"+scid).val($(this).children().eq(0).html());
                $("#n_"+scid).val($(this).children().eq(1).html());
                $("#m_"+scid).val($(this).children().eq(2).html());
                $("#2_"+scid).val($(this).children().eq(3).html());
                $("#min_"+scid).val($(this).children().eq(4).html());
                $("#max_"+scid).val($(this).children().eq(5).html());
                $("#s3_"+scid).val($(this).children().eq(6).html());
                $("#s4_"+scid).val($(this).children().eq(7).html());
                $("#s5_"+scid).val($(this).children().eq(8).html());
                $("#s6_"+scid).val($(this).children().eq(9).html());

                $("#3_"+scid).val($(this).children().eq(6).html());

                $("#h_"+scid).attr("title" ,$(this).children().eq(0).html());
                $("#0_"+scid).attr("title" ,$(this).children().eq(0).html());
                $("#n_"+scid).attr("title" ,$(this).children().eq(1).html());
                $("#m_"+scid).attr("title" ,$(this).children().eq(2).html());
                
                if($(this).children().eq(6).html() == 1){
                    $("#1_"+scid).autoNumeric({mDec:2});
                }else{
                    $("#1_"+scid).autoNumeric({mDec:0});
                }
                $("#1_"+scid).removeAttr("disabled"); 
                $("#2_"+scid).removeAttr("disabled");
                $("#3_"+scid).removeAttr("disabled");
                $("#1_"+scid).focus();$("#pop_close").click();
                if($(this).children().eq(10).html()=="1"){
                  $("#color_"+scid).css("display","block");
                  $("#pop_search2").val();
                  view_colors();
                  $("#serch_pop2").center();
                  $("#blocker2").css("display", "block");
                  setTimeout("$('#pop_search2').focus()", 100);
                }else{
                  set_default_color();                
                }
            /*}else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added","error");
            }*/
        }else{
            $("#h_"+scid).val("");
            $("#0_"+scid).val("");
            $("#n_"+scid).val("");
            $("#m_"+scid).val("");
            $("#1_"+scid).val(""); 
            $("#2_"+scid).val("");
            $("#min_"+scid).val("");
            $("#max_"+scid).val(""); 
            $("#3_"+scid).val(""); 
            $("#s3_"+scid).val(""); 
            $("#s4_"+scid).val(""); 
            $("#s5_"+scid).val(""); 
            $("#s6_"+scid).val(""); 
            $("#t_"+scid).html("&nbsp;");
            $("#1_"+scid).attr("disabled", "disabled"); 
            $("#2_"+scid).attr("disabled", "disabled");
            $("#3_"+scid).attr("disabled", "disabled");
            set_total();
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


function set_total(){
    var t = tt = 0; 
    $(".tf").each(function(){
        tt = parseFloat($(this).html());
        if(isNaN(tt)){ tt = 0;}
        t += tt;
    });
    
    $("#total2").val(m_round(t));
}

function validate(){
    var v = false;
    var g = true;
    $("input[type='hidden']").each(function(){
        if($(this).val() != "" && $(this).val() != 0){
            v = true;
        }
    });

    for(var i=0; i<25; i++){
      if($("#is_click_"+i).val()!=1 && $("#sub_"+i).data("is_click")==1){
        set_msg("Please check sub items in ("+$("#0_"+i).val()+")" ,"error");
        return false;
        break;
      } 
    }

    if(v == false){
        set_msg("Please use minimum one item","error");
    }else if($("#stores option:selected").val() == 0){
        set_msg("Please select stores","error");
        v = false;
    }else if($("#0_"+scid).val()!="" && $("#1_"+scid).val()==""){
      set_msg("Quantity should be more than 0","error");
    return false;
    }
    return v;

}



function save(){

  if($("#df_is_serial").val()=='1'){
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);
  }
    
    $("#qno").val($("#id").val());
    var frm = $('#form_');
    loding();
    $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data:frm.serialize(),
    success: function (pid){

            if(pid == 1){
              $("#btnSave").attr("disabled",true);
              loding();
              //sucess_msg();
              if(confirm("Save Completed, Do You Want A print?")){ 
                    
                    if($("#is_prnt").val()==1){
                       
                         $("#print_pdf").submit();
                    }
                        location.href="";
                    }else{
                        location.href="";
                    }
            }else if(pid == 2){
                set_msg("No permission to add data.");
            }else if(pid == 3){
                set_msg("No permission to edit data.");
            }else{
              set_msg(pid,"error");
            }
        }
    });
}




function check_is_serial_item(scid){
  if($("#df_is_serial").val()=='1'){

        var item_code=$("#0_"+scid).val();
        if(item_code!=""){
         $.post("index.php/main/load_data/t_open_stock/check_is_serial_item",{
                code:item_code,
             },function(r){
                if(r==1){
                  load_serial_form(scid);
                }
             },"text"); 
       }
    }
    
  }



function view_colors(){
 $.post("index.php/main/load_data/utility/f1_selection_list", {
  data_tbl:"r_color",
  field:"code",
  field2:"description",
  preview2:"Color",
  search : $("#pop_search2").val() 
}, function(r){
  $("#sr2").html(r);
  settings_color();            
}, "text");
}

function settings_color(){
  $("#item_list .cl").click(function(){      
    if(check_item_exist2($(this).children().eq(0).html(),$("#0_"+scid).val())){  
      $("#colc_"+scid).val($(this).children().eq(0).html());
      $("#col_"+scid).val($(this).children().eq(1).html());
      $("#pop_close2").click();   
    }else{
      set_msg($("#0_"+scid).val()+" "+$(this).children().eq(1).html()+" is already added This Item.");

    }

  })    
}


function set_default_color(){
  $.post("index.php/main/load_data/utility/default_color", {
  }, function(r){
    if(r!=""){
      if(check_item_exist2(r,$("#0_"+scid).val())){
       $("#colc_"+scid).val(r);   
     }else{
       set_msg($("#0_"+scid).val()+" is already added This Item.");
       $("#h_"+scid).val("");
       $("#0_"+scid).val("");
       $("#n_"+scid).val("");
       $("#m_"+scid).val("");
       $("#1_"+scid).val(""); 
       $("#2_"+scid).val("");
       $("#min_"+scid).val("");
       $("#max_"+scid).val(""); 
       $("#3_"+scid).val(""); 
       $("#t_"+scid).html("&nbsp;");
       $("#1_"+scid).attr("disabled", "disabled"); 
       $("#2_"+scid).attr("disabled", "disabled");
       $("#3_"+scid).attr("disabled", "disabled");
       $("#btn_"+scid).css("display", "none");
     }
   }else{
    set_msg('Please Set Default Color First');
   // empty_gr_line();
 }   
}, "json");
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
