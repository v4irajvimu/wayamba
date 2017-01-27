$(document).ready(function(){
  $(".quns").css("display", "none");
  $(".qunsb").css("display","none");
  $(".subs").css("display","none");
  $("#btnSavee").css("display","none");


  $("#pop_search14").keyup(function(e){            
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          pop_data();
      }
  }); 

  $("#btn_pop_cus").click(function(){
      $("#pop_search14").val();
      pop_data();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);
});
    
  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
      $("#qno").val($('#id').val());
    }
  });

  $(".price").keypress(function(e){
    if(e.keyCode == 112){
        set_cid($(this).attr("id"));
        load_price_range($("#0_"+scid).val(),$("#1_"+scid).val());
    }
  });

  $(document).keypress(function(e){
      if(e.keyCode == 113){
        if($("#is_dis").attr("checked")=="checked"){
          $("#is_dis").attr('checked', false);
          $("#dis_update").val("0");
          $(".dis").removeAttr("readonly");
          $(".dis_pre").attr("readonly","readonly");
         }else{
          if($("#is_dis").attr("checked")!="checked"){
            $("#is_dis").attr('checked', true);
            $("#dis_update").val("1");
            $(".dis_pre").removeAttr("readonly");
            $(".dis").attr("readonly","readonly");
          }
         }
      }
    });


$("#is_dis").click(function(){
   if($("#is_dis").attr("checked")=="checked"){
    $("#dis_update").val("1");
    $(".dis_pre").removeAttr("readonly");
    $(".dis").attr("readonly","readonly");
   }else{
    $("#dis_update").val("0");
    $(".dis").removeAttr("readonly");
    $(".dis_pre").attr("readonly","readonly");
   }

});

  $(".qty").blur(function(){
      amount();
      gross_amount();
      discount_amount();
      dis_prec();
      net_amount();
  });

  $("#btn_cus").click(function(){
        window.open("?action=m_customer","_blank");  
    });

  $(".qty").keyup(function(){
    set_cid($(this).attr("id"));
    var del_qty = parseInt($("#deqty_"+scid).val());
    var issue_qty = parseInt($("#5_"+scid).val());
    if(isNaN(del_qty)){
      del_qty =0;
    }
    if(isNaN(issue_qty)){
      issue_qty =0;
    }
    if(del_qty>issue_qty){
      set_msg("Item ("+$("#0_"+scid).val()+") quantity already deliverd.");
      $("#5_"+scid).val("");
    }

  });


  $(".fo").dblclick(function(){
        if($(this).val()!=""){
            $.post("index.php/main/load_data/utility/get_sub_item_detail", {
                code:$(this).val(),
                store:$("#stores").val(),
                qty:$("#5_"+scid).val()
            }, function(res){
                if(res!=0){
                    $("#msg_box_inner").html(res);
                    $("#msg_box").slideDown();
                }
            },"text");
        } 
    });

  $(".im").dblclick(function(){
    set_cid($(this).attr("id"));
    if($("#0_"+scid).val()==""){
      set_msg("Please select item code");
    }else{
      $("#pop_search13").css("display","none");
      load_images();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);
    }
  });

  $("#card_ad").focus(function(){
    $("#tab").tabs("select", "tab-2" );   
  });

  $("#chq_ad").focus(function(){
    $("#tab").tabs("select", "tab-3" );   
  });

  $("form input:text" ).blur(function(){
     cal_totals();
  })

  $("#tab").tabs();
  $("#btnReset").click(function(){
    location.href="?action=t_sales_order";
  });
     
  $(document).on("keyup",".sst",function(){
    var ad=""
    var tot_settle=parseFloat(0);
    $(".sst").each(function(){
      var ddate=$(this).closest("tr").find('td').eq(0).text();
      var ad_no=$(this).closest("tr").find('td').eq(1).text();
      var amount=$(this).closest("tr").find('td').eq(2).text();
      var balance=$(this).closest("tr").find('td').eq(3).text();
      var cr_no=$(this).closest("tr").find('td').eq(5).text();
      var settle=$(this).val();
      if($(this).val()!=""){
        ad+=ddate+"|"+ad_no+"|"+amount+"|"+balance+"|"+settle+"|"+cr_no+",";
        tot_settle+=parseFloat(settle);
      }
      if(parseFloat(balance)<parseFloat(settle)){
        set_msg("Paid mount should be less than balanace amount");
        $(this).val("");
      }
    });

    $("#adamnt_"+scid).val(tot_settle);
    $("#alldata_"+scid).val(ad);


  });

  $("#grid").tableScroll({height:355});
  $("#tgrid").tableScroll({height:155});
  $("#tgrid2").tableScroll({height:150});
  $(".tgrid3").css("overflow","scroll").css("height","120px");
  $("#qno").val($('#id').val());
  $("#cus_id").val($('#customer').val());

  $("#click").click(function(){
    var x=0;
    $(".me").each(function(){
      set_msg(x);
    if($(this).val() != "" && $(this).val() != 0){
      v = true;
    }
      x++;
  });
});

$("#stores").change(function(){
  set_select('stores','store_id');
})

$(".subs").click(function(){
   set_cid($(this).attr("id"));
   check_is_sub_item(scid); 
});


$("#sales_rep").keypress(function(e){
  if(e.keyCode == 112){
      $("#pop_search6").val();
      load_data8();
      $("#serch_pop6").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search6').focus()", 100);
  }

 $("#pop_search6").keyup(function(e){            
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
           load_data8();
      }
  }); 

  if(e.keyCode == 46){
      $("#sales_rep").val("");
      $("#sales_rep2").val("");
  }
});

$(document).on('click','.rmvcr',function(){
 set_cid($(this).attr("id"));
 var delete_qty = parseInt($("#deqty_"+scid).val());
 if(delete_qty>0){
  set_msg("This Record cann't update");
 }else{
  if($("#0_"+scid).val()!=""){
    $("#updtstatus_"+scid).val("1");
    $("#alldata_"+scid).val("");
    $("#adamnt_"+scid).val("");    
    delete_cr_transe_record($("#0_"+scid).val());
  }else{
    set_msg("please enter item code");
  }
 }
});


 $(".type1").keypress(function(e){
         set_cid($(this).attr("id"));
        if(e.keyCode == 112){
            $("#pop_search12").val();
            load_card_type();
            $("#serch_pop12").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search12').focus()", 100);
        }
        $("#pop_search12").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_card_type();
            }
        }); 
        if(e.keyCode == 46){
            $("#type1_"+scid).val("");
        }
    });

  $(document).on('keypress', '.bank9', function(e){
        set_cid($(this).attr("id"));
        if(e.keyCode == 112){
                $("#pop_search11").val();
                load_receive_chk();
                $("#serch_pop11").center();
                $("#blocker").css("display", "block");
                setTimeout("$('#pop_search11').focus()", 100);                
           
        }

       $("#pop_search11").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_receive_chk();
            }
        }); 
        
        if(e.keyCode == 46){
            $("#bank9_"+scid).val("");
            $("#branch9_"+scid).val("");
            $("#acc9_"+scid).val("");
            $("#cheque9_"+scid).val("");
            $("#amount9_"+scid).val(""); 
            $("#date9_"+scid).val("");         
        }
    }); 


    $(document).on('keypress', '.bank1', function(e){
        set_cid($(this).attr("id"));
        if(e.keyCode == 112){
            if($("#amount1_"+scid).val()!=""){
                $("#pop_search15").val();
                load_bank();
                $("#serch_pop15").center();
                $("#blocker").css("display", "block");
                setTimeout("$('#pop_search15').focus()", 100);                
            }else{
                alert("Please type amount");
            }
        }

       $("#pop_search15").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_bank();
            }
        }); 

        if(e.keyCode == 46){
            $("#bank1_"+scid).val("");
            $("#1bank1_"+scid).val("");
            $("#month1_"+scid).val("");
            $("#acc1_"+scid).val("");
            $("#rate1_"+scid).val(""); 
            $("#amount_rate1_"+scid).val("");         
        }
    }); 
    
//-------------------------------------------------------------------------

$(".fo").keypress(function(e){  
  set_cid($(this).attr("id"));
  if(e.keyCode==112){
      $("#pop_search").val($("#0_"+scid).val());
      load_items();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("select_search()", 100);
  }

  $("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_items();
    }
  });
 
  if(e.keyCode==13){
      $.post("index.php/main/load_data/t_cash_sales_sum/get_item", {
          code:$("#0_"+scid).val(),
          group_sale:$("#groups").val(),
          stores:$("#stores").val()
      }, function(res){
          if(res.a!=2){
              $("#0_"+scid).val(res.a[0].code);
                  if(check_item_exist($("#0_"+scid).val())){
                      if($("#df_is_serial").val()=='1')
                      {
                          check_is_serial_item2(res.a[0].code,scid);
                      }
                      check_is_batch_item2(res.a[0].code,scid);
                      check_is_sub_item2(res.a[0].code,scid);
         
                      $("#h_"+scid).val(res.a[0].code);
                      $("#n_"+scid).val(res.a[0].description);
                      $("#0_"+scid).val(res.a[0].code);
                      $("#2_"+scid).val(res.a[0].model);
                      $("#3_"+scid).val(res.a[0].max_price);
                      $("#item_min_price_"+scid).val(res.a[0].min_price);
                      $("#free_price_"+scid).val(res.a[0].max_price);             
                     $("#1_"+scid).focus();
                      $("#pop_close").click();
                      check_is_batch_item(scid);
                    
                  }else{
                      set_msg("Item "+$("#0_"+scid).val()+" is already added.","error");
                  }
          }else{
              set_msg($("#0_"+scid).val()+" Item not available in store","error");
              $("#0_"+scid).val("");
          }
      }, "json");
    }

    if(e.keyCode==46){
        if($("#df_is_serial").val()=='1'){
            $("#all_serial_"+scid).val("");
        }
        /*if($("#deqty_"+scid).val()=="0" || $("#deqty_"+scid).val()==""){
          $("#removecr_"+scid).click();
        }*/
        item_free_delete(scid);
        $("#h_"+scid).val("");
        $("#0_"+scid).val("");
        $("#n_"+scid).val("");
        $("#1_"+scid).val(""); 
        $("#2_"+scid).val(""); 
        $("#3_"+scid).val(""); 
        $("#4_"+scid).val(""); 
        $("#5_"+scid).val("");
        $("#6_"+scid).val(""); 
        $("#7_"+scid).val(""); 
        $("#8_"+scid).val(""); 
        $("#9_"+scid).val("");
        $("#f_"+scid).val("");
        $("#cqty_"+scid).val("");        
        $("#deqty_"+scid).val("");
        $("#adno_"+scid).val("");   
        $("#alldata_"+scid).val("");
        $("#updtstatus_"+scid).val("1");   
        $("#rcv_"+scid).attr("checked",false);
        $("#cost_"+scid).val("");
        $("#bal_free_"+scid).val("");
        $("#bal_tot_"+scid).val("");
        $("#free_price_"+scid).val("");
        $("#issue_qty_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#bqty_"+scid).val("");
        $("#rcvqty_"+scid).val("");
    $("#itm_status_"+scid).val("0");        
        $("#item_min_price_"+scid).val("");
        $("#subcode_"+scid).removeAttr("data-is_click");
        $("#5_"+scid).attr("readonly", false);
        $("#btn_"+scid).css("display","none"); 
        $("#btnb_"+scid).css("display","none");
        $("#sub_"+scid).css("display","none");


   


            $("#n_"+scid).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
            $("#2_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
            $("#1_"+scid).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
            $("#1_"+scid).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
            $("#3_"+scid).closest("td").attr('style', 'width: 58px;');
            $("#6_"+scid).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
            $("#8_"+scid).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');
            $("#0_"+scid).closest("tr").attr('style', 'width:100%; background-color: #ffffff !important;');
           
            $("#cqty_"+scid).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
            $("#cqty_"+scid).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
            $("#deqty_"+scid).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
            $("#deqty_"+scid).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');


        amount();
        gross_amount();
        discount_amount();
        rate_pre();
        net_amount();
   
    }
});


      
  $(".dis, .qun, .dis_pre, .price").blur(function(){
    set_cid($(this).attr("id"));
    dis_prec();
    amount();
    gross_amount();
    net_amount();
    check_min_price(scid);
  });

  $(".rate").blur(function(){
    set_cid($(this).attr("id"));
    net_amount();
  });

  $(".aa").blur(function(){
    set_cid($(this).attr("id"));
    rate_pre();
    net_amount();
  });

  $(".qunsb").click(function(){
    set_cid($(this).attr("id"));
    check_is_batch_item(scid);
  });

  $(".qty").blur(function(){
    is_sub_item(scid);
    if($("#rcv_"+scid).is(":checked")){
      check_batch_qty(scid);
    }
  });


$(".foo").keypress(function(e){ 
  set_cid($(this).attr("id"));
  if(e.keyCode==112){
        $("#serch_pop7").center();
        $("#blocker2").css("display", "block");
        load_items2()
        setTimeout("$('#pop_search7').focus()", 100);
  }
  $("#pop_search7").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_items2();
      }
  });
  if(e.keyCode==46){
    $("#hh_"+scid).val("");
    $("#00_"+scid).val("");
    $("#nn_"+scid).val("");
    $("#11_"+scid).val("");
    $("#tt_"+scid).val("");
    $("#hhh_"+scid).val("");
    rate_pre();
    net_amount();
  }
});


$("#customer").keypress(function(e){ 
    if(e.keyCode==112){
      $("#pop_search2").val($("#customer").val());
      load_customer();
      $("#serch_pop2").center();
      $("#blocker2").css("display", "block");
      setTimeout("$('#pop_search2').focus()", 100);   
    }
    $("#pop_search2").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_customer();
      }
    });
    if(e.keyCode==46){
       $("#customer").val("");
       $("#customer_id").val("");
       $("#address").val("");
    }  
});

  $("#pop_search").gselect();

  $("#customer").autocomplete('index.php/main/load_data/m_customer/auto_com', {
  width: 350,
  multiple: false,
  matchContains: true,
  formatItem: formatItems,
  formatResult: formatItemsResult
  });

  $("#customer").keypress(function(e){
      if(e.keyCode == 13){
          set_cus_values($(this));
      }
  });

  $("#customer").blur(function(){
      set_cus_values($(this));
  });

  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#5_"+get_id).focus();
 });
   

$("#btnDelete").click(function(){
    var id=$("#id").val();
        if(id==""){
            set_msg('Please enter no',"error");
        }else{      
        var id=$("#id").val();
         $.post("index.php/main/load_data/t_sales_order/check_code",{
            id:id,
         },function(r){
            if(r==1){
                set_delete(id);
            }else{
               set_msg("Please enter vaild sales order No","error"); 
            }
         });      
        }
    });


  $("#btnPrint").click(function(){
    $("#print_pdf").submit();
    //get_multi_print();
  });

  default_option();
});

function default_option(){
   
    $.post("index.php/main/load_data/utility/default_option", {
  }, function(r){
          /*if(r.use_sales_category!="0"){
            $(".ct").css("display","none");

           var sale_cat=r.def_sales_category;
            $("#sales_category1").val(sale_cat);
          }
          if(r.use_sales_group!="0"){
           $(".gr").css("display","none");
           $("#dealer_id").val(r.def_sales_group);
          }*/
          if(r.use_salesman!="0"){
            $("#sales_rep").val(r.def_salesman_code);
            $("#sales_rep2").val(r.def_salesman);
          }
          $("#stores").val(r.def_sales_store);
          $("#store_id").val(r.store);
          $("#customer").val(r.def_cash_customer);
          $("#customer_id").val(r.customer);
 }, "json");
}

function load_images(){
     $.post("index.php/main/load_data/t_sales_order/load_item_img", {
        item : $("#0_"+scid).val(),
    }, function(r){
      if(r==2){
        set_msg("Images not available for this item");
        $("#sr13").html("");
        $("#sr13").append("<td width='300px;'style='text-align:center; padding-left:250px;'><img width='150px' border='0' hspace='9' vspace='9' height='150px' src=images/non_img.jpg></td>");       
      }else{
        $("#sr13").html("");
        $("#sr13").append("<tr>");     
          for(var x=0; x<r.length; x++){
              $("#sr13").append("<td><img width='140px' border='0' hspace='5' vspace='9' height='140px' src='" + r[x].picture + "' style=' border-radius: 25px;border: 2px solid #7D7B76;padding: 1px;'/></td>");       
          }
        $("#sr13").append("</tr>");   
      }
    }, "json");
}

function get_multi_print(){
  $.post("index.php/main/load_data/t_sales_order/get_data_print", {
      no:$("#id").val()
    }, function(r){
      if(r.card!=0){
        $("#qno2").val(r.card);
        $("#cus_id").val(r.c_acc);
        $("#dt").val(r.c_ddate);
        $("#reciviedAmount").val(r.c_amount);
        $("#print_pdf2").submit();  
      }

      if(r.chq!=0){
        $("#qno3").val(r.chq);
        $("#cus_id3").val(r.chq_acc);
        $("#dt3").val(r.chq_ddate);
        $("#reciviedAmount3").val(r.chq_amount);
        $("#print_pdf3").submit();  
      }

      $("#print_pdf").submit();
      
      location.href="";
    }, "json");
}
function save_tempory_table(){
   
  $.post("index.php/main/load_data/t_sales_order/save_temp", {
      all_data : $("#alldata_"+scid).val(),
      item : $("#0_"+scid).val(),
      no : $("#id").val(),
  }, function(r){
      if(r!="1"){
        //alert("Opertaion Fail");
      }
  }, "text");
}


function rate_pre(){
    var gross_amount=parseFloat($("#total2").val());
    var rate=parseFloat($("#tt_"+scid).val());
    var rate_amount_pre="";

    if(!isNaN(rate)&& !isNaN(gross_amount)){
    rate_amount_pre=(rate*100)/gross_amount;
    $("#11_"+scid).val(m_round(rate_amount_pre));
    }
}


function check_item_exist2(id){
    var v = true;
    $("input[type='hidden']").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });    
    return v;
}

function load_advance(){
  $.post("index.php/main/load_data/t_sales_order/load_advance", {
      search : $("#pop_search11").val(),
      customer : $("#customer").val(),
  }, function(r){
      $("#sr11").html(r);
      //settings_advance();
  }, "text");
}

function load_saved_advance(item_code,deliverd_qty){
  $.post("index.php/main/load_data/t_sales_order/load_saved_advance", {
      no : $("#id").val(),
      item:item_code,
      deliverd_qty:deliverd_qty
  }, function(r){
      $("#sr11").html(r);
      //settings_advance();
  }, "text");
}


function load_items2(){
     $.post("index.php/main/load_data/r_additional_items/item_list_all", {
        search : $("#pop_search7").val(),
        stores : false
    }, function(r){
        $("#sr7").html(r);
        settings2();
    }, "text");
}



function settings2(){
    $("#item_list2 .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist2($(this).children().eq(0).html())){
                var rate = parseFloat($(this).children().eq(2).html()).toFixed(2);
                $("#hh_"+scid).val($(this).children().eq(3).html());
                $("#00_"+scid).val($(this).children().eq(0).html());
                $("#nn_"+scid).val($(this).children().eq(1).html());
                $("#11_"+scid).val(rate);
                $("#hhh_"+scid).val($(this).children().eq(0).html());
                $("#11_"+scid).focus();
                all_rate_amount();
                net_amount();
                $("#pop_close7").click();  
            }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#hh_"+scid).val("");
            $("#00_"+scid).val("");
            $("#nn_"+scid).val("");
            $("#11_"+scid).val(""); 
            $("#tt_"+scid).val(""); 
            $("#hhh_"+scid).val("");
            all_rate_amount();
            net_amount();
            
            $("#pop_close2").click();
        }
    });

}

function all_rate_amount(){
    var gross_amount=parseFloat($("#total2").val());  
    var additional=loop=0;
    $(".rate").each(function(){
        var rate=parseFloat($("#11_"+loop).val());
        var rate_amount=0;
        if(!isNaN(rate) && !isNaN(rate_amount) ){ 
        rate_amount=(gross_amount*rate)/100;
        $("#tt_"+loop).val(m_round(rate_amount));
        }    
        loop++;
    });
}

function load_data8(){
        $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
            filter_emp_cat:"salesman",
            search : $("#pop_search6").val() 
        }, function(r){
            $("#sr6").html("");
            $("#sr6").html(r);
            settings8();            
        }, "text");
    }



function settings8(){
    $("#item_list .cl").click(function(){        
        $("#sales_rep").val($(this).children().eq(0).html());
        $("#sales_rep2").val($(this).children().eq(1).html());
        $("#pop_close6").click();                
    })    
}

function load_customer(){
    //$.post("index.php/main/load_data/t_sales_order/customer_list", {
        $.post("index.php/main/load_data/utility/f1_selection_list_customer",{
        data_tbl:"m_customer",
        field:"code",
        field2:"name",
        field3:"nic",
        field4:"tp",
        field_address : "field_address",
        preview1:"Customer ID",
        preview2:"Customer Name",
        preview3:"Customer NIC",
        hid_field:"address1",
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings_cus();            
    }, "text");
}

function settings_cus(){
    $("#item_list .cl").click(function(){        
        $("#customer").val($(this).children().eq(0).html());
        $("#customer_id").val($(this).children().eq(1).html());
        $("#address").val($(this).children().eq(3).find('input').val());
        $("#pop_close2").click();                
    })    
}


function set_cus_values(f){
    var v = f.val();
    v = v.split("-");
        
    if(v.length == 2){
    f.val(v[0]);
    $("#customer_id").val(v[1]);
    var cus=$("#customer").val();
    $.post("index.php/main/load_data/m_customer/load",
    {
    code:cus,
    },function(rs){
 
     $("#address").val(rs.data.address1+", "+rs.data.address2+", "+rs.data.address3); 
     input_active();
     },"json");

    }
}

function formatItems(row){
    return "<strong> " +row[0] + "</strong> | <strong> " +row[1] + "</strong>";
}

function formatItemsResult(row){
    return row[0]+"-"+row[1];
}


function save(){
    $("#qno").val($("#id").val());
    var frm = $('#form_');

    loding();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (pid){   
            if(pid == 1){
                $("#btnSave").attr("disabled",true);
                if(confirm("Save Completed, Do You Want A print?")){
                    if($("#is_prnt").val()==1){
                       $("#print_pdf").submit();
                        //get_multi_print();
                    }
                    //reload_form();
                }else{
                    //location.href="";
                }
                $("#btnSave").css("display","none");
                $("#btnSavee").css("display","inline");          
            }else if(pid == 2){
                set_msg("No permission to add data.");
            }else if(pid == 3){
                set_msg("No permission to edit data.");
            }else{
                set_msg(pid,"error");
            }
            loding();
        }
    });
}

function reload_form(){
  setTimeout(function(){
    location.href = '';
  },100); 
}


  

function empty_grid(){
  for(var i=0; i<25; i++){
    // if($("#deqty_"+i).val()=="0" || $("#deqty_"+i).val()==""){
    //   $("#removecr_"+i).click();
    // }
    $("#h_"+i).val("");
    $("#0_"+i).val("");
    $("#n_"+i).val("");
    $("#1_"+i).val(""); 
    $("#2_"+i).val(""); 
    $("#3_"+i).val(""); 
    $("#4_"+i).val(""); 
    $("#5_"+i).val("");
    $("#6_"+i).val(""); 
    $("#7_"+i).val(""); 
    $("#8_"+i).val(""); 
    $("#9_"+i).val("");
    $("#f_"+i).val("");
    $("#deqty_"+i).val("");
    $("#adno_"+i).val("");   
    $("#alldata_"+i).val("");
    $("#updtstatus_"+i).val("1");  
    $("#rcv_"+i).attr("checked",false);
    $("#bal_free_"+i).val("");
    $("#bal_tot_"+i).val("");
    $("#cost_"+i).val("");
    $("#free_price_"+i).val("");
    $("#issue_qty_"+i).val("");
    $("#subcode_"+i).val("");
    $("#bqty"+i).val("");
    $("#subcode_"+i).removeAttr("data-is_click");
    $("#item_min_price_"+i).val("");
    $("#btn_"+i).css("display","none"); 
    $("#btnb_"+i).css("display","none");
    $("#sub_"+i).css("display","none");
  }


  for(var i=0; i<25; i++){
      $("#hh_"+i).val(0);
      $("#hhh_"+i).val(0);
      $("#00_"+i).val("");
      $("#nn_"+i).val("");
      $("#tt_"+i).val("");
      $("#11_"+i).val("");
  }
  $(".quns").css("display","none");
  $(".qunsb").css("display","none");
}



function load_data(id){
empty_grid();
loding();
var g=[];
$.post("index.php/main/get_data/t_sales_order/", {
    no: id
}, function(r){
        if(r=="2"){
           set_msg("No records","error");
        }else{
          $("#hid").val(id);    
          $("#qno").val(id);    
          $("#id").attr("readonly","readonly")            
          $("#customer").val(r.sum[0].cus_id);
          $("#customer_id").val(r.sum[0].cus_name);
          $("#address").val(r.sum[0].address);
          $("#date").val(r.sum[0].date);
          $("#ref_no").val(r.sum[0].ref_no);
          $("#memo").val(r.sum[0].memo);
          $("#total2").val(r.sum[0].gross_amount);
          $("#addi_tot").val(r.sum[0].additional_amount);
          $("#total_discount").val(r.sum[0].discount_amount);
          $("#net_amount").val(r.sum[0].net_amount);
          $("#sales_rep").val(r.sum[0].rep_id);
          $("#sales_rep2").val(r.sum[0].rep_name);     
          $("#stores").val(r.sum[0].store);  
          set_select("stores","store_id");  

          $("#cash_ad").val(r.sum[0].pay_cash);
          $("#card_ad").val(r.sum[0].pay_card);
          $("#chq_ad").val(r.sum[0].pay_cheque);
          $("#tot_ad").val(r.sum[0].pay_tot);
       
          for(var i=0; i<r.det.length;i++){         
            $("#h_"+i).val(r.det[i].item);
            $("#0_"+i).val(r.det[i].item);
             
            $("#itemcode_"+i).val(r.det[i].item);
            if($("#df_is_serial").val()=='1')
            {
                $("#numofserial_"+i).val(r.det[i].reserve_qty);
                check_is_serial_item2(r.det[i].item,i); 
                for(var a=0;a<r.serial.length;a++){
                   if(r.det[i].item==r.serial[a].item){
                        g.push(r.serial[a].serial_no);
                        $("#all_serial_"+i).val(g);
                    }   
                }
                g=[];  
            }
            
            $("#n_"+i).val(r.det[i].description);
            $("#1_"+i).val(r.det[i].batch_no);
            $("#2_"+i).val(r.det[i].model);
            $("#cost_"+i).val(r.det[i].cost);
            $("#5_"+i).val(r.det[i].qty);
            $("#rcvqty_"+i).val(r.det[i].reserve_qty);
            $("#6_"+i).val(r.det[i].discount_p);
            $("#7_"+i).val(r.det[i].discount);                
            $("#8_"+i).val(r.det[i].amount); 
            $("#item_min_price_"+i).val(r.det[i].min_price);                
            $("#free_price_"+i).val(r.det[i].cost);
            $("#3_"+i).val(r.det[i].cost);
            $("#deqty_"+i).val(r.det[i].delivered_qty);
            $("#free_price_"+i).val(r.det[i].cost);
            // alert(r.det[i].is_free);
            $("#f_"+i).val(r.det[i].is_free);

            if(r.det[0].is_reserve==1){
              $("#rcv_"+i).attr("checked",true);
            }
            $("#adamnt_"+i).val(r.det[i].advance_amount);
            if(parseInt(r.det[i].delivered_qty)>0){
              $("#removecr_"+i).attr("disabled",true);
            }
            $("#updtstatus_"+i).val("0");

            if(r.det[i].delivered_qty>=r.det[i].qty){
              $("#5_"+i).attr("readonly","readonly");
              $("#rcvqty_"+i).attr("readonly","readonly");
              $("#btnDelete").attr("disabled", "disabled");
            }

if(r.det[i].is_free=="1")
                {
                 if(r.det[i].foc==""){
                    $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].qty));
                    $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].qty));
                }else{
                    $("#free_price_"+i).val(r.det[i].price);
                    $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
                    $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
                }
                }
                
                if(r.det[i].is_free=='1'){
                    $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
                    $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                    $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                    $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                    $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
                    $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');

                        $("#cqty_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#cqty_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');                       
                        $("#deqty_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#deqty_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');                       
                       
                        $("#deqty_"+i).closest("tr").find('input').attr("readonly","readonly");

                }
                
                
                // if(r.det[i].is_free=='1'){
                //     //$("#3_"+i).val("");
                //     $("#3_"+i).val(r.det[i].price);
                //     fre +=parseFloat(r.det[i].amount);
                // }else{
                //     $("#3_"+i).val(r.det[i].price);
                //     $("#free_price_"+i).val(r.det[i].price);
                // }







            check_is_batch_item2(r.det[i].item,i);
            is_sub_item(i);         
            check_is_batch_item(i); 
            amount();    
          }
        
          if(r.add!=2){
            for(var i=0; i<r.add.length;i++){
              $("#hhh_"+i).val(r.add[i].sales_type);
              $("#00_"+i).val(r.add[i].sales_type);
              $("#nn_"+i).val(r.add[i].description);
              $("#11_"+i).val(r.add[i].rate_p);
              $("#tt_"+i).val(r.add[i].amount);
              get_sales_type(i);
            }
          }

           if(r.opt_credit_card_det!=2){
            for(var i=0; i<r.opt_credit_card_det.length;i++){
              $("#type1_"+i).val(r.opt_credit_card_det[i].card_type);
              $("#no1_"+i).val(r.opt_credit_card_det[i].card_no);
              $("#amount1_"+i).val(r.opt_credit_card_det[i].amount);
              $("#1bank1_"+i).val(r.opt_credit_card_det[i].description);
              $("#bank1_"+i).val(r.opt_credit_card_det[i].bank_id);
              $("#month1_"+i).val(r.opt_credit_card_det[i].month);
              $("#rate1_"+i).val(r.opt_credit_card_det[i].rate);
              $("#amount_rate1_"+i).val(r.opt_credit_card_det[i].int_amount);
              $("#merchant1_"+i).val(r.opt_credit_card_det[i].merchant_id);
              $("#acc1_"+i).val(r.opt_credit_card_det[i].acc_code);
              //cal_amnt($("#amount1_"+i).val(),r.opt_credit_card_det[i].rate,"#amount_rate1_");
            }
          }

           if(r.opt_receive_cheque_det!=2){
            for(var i=0; i<r.opt_receive_cheque_det.length;i++){
              $("#bank9_"+i).val(r.opt_receive_cheque_det[i].bank);
              $("#branch9_"+i).val(r.opt_receive_cheque_det[i].branch);
              $("#acc9_"+i).val(r.opt_receive_cheque_det[i].account_no);
              $("#cheque9_"+i).val(r.opt_receive_cheque_det[i].cheque_no);
              $("#amount9_"+i).val(r.opt_receive_cheque_det[i].amount);
              $("#date9_"+i).val(r.opt_receive_cheque_det[i].cheque_date);
            }
          }


            




          if(r.sum[0].is_cancel==1){
            $("#btnDelete").attr("disabled", "disabled");
            $("#btnSave").attr("disabled", "disabled");
            $("#mframe").css("background-image", "url('img/cancel.png')");
          }

          

        }
      loding();
    }, "json");
}

function validate(){

    var v = 0;
   
   /* for(x=0;x<24;x++){
      if($("#0_"+x).val()!="" && $("#0_"+x).val()!="0"){
        if($("#alldata_"+x).val()!="" || $("#alldata_"+x).val()!="0"){
          if($("#adamnt_"+x).val()=="" || $("#adamnt_"+x).val()=="0.00"){
            v=1;//--advance amount
          }else{
            v=0;
          }
          if(parseFloat($("#adamnt_"+x).val())!=parseFloat($("#8_"+x).val())){
            v=2;//--advance amount not equal to total amount
          }else{
            v=0;
          }
        }
      }
    }*/

    for(var t=0; t<25; t++){
      if(parseInt($("#cqty_"+t).val()) < parseInt($("#rcvqty_"+t).val())){
        set_msg("Item "+$("#0_"+t).val()+" Reserve qty should be less than current qty.");
        return false;
      }
    }

    if($("#id").val() == ""){
        set_msg("Please enter No.","error");
        $("#id").focus();
        return false;
    }else if($("#date").val() == ""){
        set_msg("Please select date","error");
        $("#date").focus();
        return false;
    }else if($("#customer_id").val()=="" || $("#customer_id").val()==$("#customer_id").attr("title")){
        set_msg("Please select a customer.","error");
        $("#customer_id").focus();
        return false;
    }/*else if(parseFloat($("#tot_ad").val()) <=0){
      set_msg("Total payment amount should be greater than 0");
      return false;
    }*/
    /*else if(v == 1){
        set_msg("Advance Amount cann't be empty","error");
    }else if(v == 2){
      set_msg("Advance Amount should be equal to item amount","error");
    }*/else{
        return true;
    }
}


    
function set_delete(id){
    if(confirm("Are you sure cancel sales order no "+id+"?")){
        loding();
        $.post("index.php/main/delete/t_sales_order", {
            id : id,
            store:$("#stores").val()
        }, function(res){
            if(res == 1){
                loding();
                delete_msg();              
            }else{
                set_msg(res);
            }
        }, "text");
    }
}



function select_search(){
    $("#pop_search").focus();
}

function load_items(){        
     $.post("index.php/main/load_data/t_sales_order/item_list_all", {
        search : $("#pop_search").val(),
        stores : $("#stores").val(),
        group_sale:"0"

    }, function(r){
        $("#sr").html("");      
        $("#sr").html(r);
        settings();
        price_type();
    }, "text");
}

function price_type(){
     $.post("index.php/main/load_data/utility/price_type", {
    }, function(r){

      pr_type=r;
    }, "text");
}

function load_items3(x){
    $.post("index.php/main/load_data/t_cash_sales_sum/batch_item", {
        search : x,
        stores : $("#stores").val()
    }, function(r){
        $("#sr3").html(r);
        settings3();
    }, "text");
}


function settings3(){
    $("#batch_item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist3($(this).children().eq(0).html())){
                $("#1_"+scid).val($(this).children().eq(0).html());
                $("#bqty_"+scid).val($(this).children().eq(1).html());
                $("#3_"+scid).val($(this).children().eq(2).html());
                $("#free_price_"+scid).val($(this).children().eq(2).html());
                $("#1_"+scid).attr("readonly","readonly");
                $("#5_"+scid).focus();

                amount();
                gross_amount();
                discount_amount();
                dis_prec();
                all_rate_amount();
                net_amount();
                $("#pop_close3").click();
            }else{
                set_msg ("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#1_"+scid).val("");
            $("#5_"+scid).val("");
            $("#3_"+scid).val("");
                amount();
                gross_amount();
                discount_amount();
                dis_prec();
                all_rate_amount();
                net_amount();
            $("#pop_close3").click();
        }
    });
}


function settings(){
    $("#item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist($(this).children().eq(0).html())){

                if($("#df_is_serial").val()=='1'){
                    check_is_serial_item2($(this).children().eq(0).html(),scid);
                }
                check_is_batch_item2($(this).children().eq(0).html(),scid);
                check_is_sub_item2($(this).children().eq(0).html(),scid);

                $("#h_"+scid).val($(this).children().eq(0).html());
                $("#0_"+scid).val($(this).children().eq(0).html());
                $("#n_"+scid).val($(this).children().eq(1).html());
                $("#2_"+scid).val($(this).children().eq(2).html()); 
                  if(pr_type =="1"){          //  none price
                      $("#3_"+scid).val();    
                  }else if(pr_type =="2"){    //  cost price
                      $("#3_"+scid).val($(this).children().eq(5).html());
                  }else if(pr_type =="3"){    //  min price
                      $("#3_"+scid).val($(this).children().eq(4).html());
                  }else{                      //  max price
                      $("#3_"+scid).val($(this).children().eq(3).html());    
                  }
                $("#free_price_"+scid).val($(this).children().eq(3).html());
                $("#item_min_price_"+scid).val($(this).children().eq(4).html());
                $("#cost_"+scid).val($(this).children().eq(5).html());
                $("#5_"+scid).focus();
                $("#pop_close").click();
                 check_is_batch_item(scid);
            }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#h_"+scid).val("");
            $("#0_"+scid).val("");
            $("#n_"+scid).val("");
            $("#1_"+scid).val(""); 
            $("#2_"+scid).val(""); 
            $("#3_"+scid).val("");
            $("#4_"+scid).val("");  
            $("#5_"+scid).val("");
            $("#6_"+scid).val(""); 
            $("#7_"+scid).val("");
            $("#8_"+scid).val("");  
            $("#9_"+scid).val("");

            amount();
            gross_amount();
            discount_amount();
            dis_prec();
            net_amount();

            $("#pop_close").click();
        }
    });
}

function check_item_exist(id){
    var v = true;
    var cnt=0;
    $("input[type='hidden']").each(function(){
        if($(this).val() == id){
          cnt++;
            v = false;
        }
    });

      $(".isFree").each(function(e){
          var thNo=$(this).attr("id").split('_')[1];
          var ThId="#h_"+thNo;
          var IsFre="#f_"+thNo;
          if ($(IsFre).val()==1) {
              if($(ThId).val() == id){
                if(cnt<2){
                 v = true;
                }
              }
          }
      })

    return v;
}

function select_search3(){
    $("#pop_search3").focus();
}

function check_item_exist3(id){
    var v = true;
    return v;
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

function amount(){
    var all_foc=0;
    var qty=parseFloat($("#5_"+scid).val());
    var price=parseFloat($("#3_"+scid).val());
    var foc=parseFloat($("#4_"+scid).val());
    var amount="";

   if(isNaN(qty)){qty=0;}
   if(isNaN(price)){price=0;}
   if(isNaN(foc)){foc=0;}s

    var total_dis=0;
    var total_foc=m_round(price*foc);
    $("#tot_foc_"+scid).val(m_round(total_foc));
    var discount=parseFloat($("#7_"+scid).val());
    var dis_pre=0;
    if(isNaN(discount)){discount=0;}
    if($("#f_"+scid).val()!="1"){
    if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount) && !isNaN(foc)){
        amount=(qty)*price;
        total_dis=(qty)*discount;
        amount=amount-total_dis;
        /*dis_pre=(discount*100)/price;

        if(isNaN(dis_pre) || !isFinite(dis_pre)){

        $("#6_"+scid).val("");
        }else{
            $("#6_"+scid).val(m_round(dis_pre));
        }*/
        $("#tot_dis_"+scid).val(m_round(total_dis));

        $("#8_"+scid).val(m_round(amount)); 

    }else if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount)){
        amount=(qty*price)-discount;
        if(amount!=0){
           $("#8_"+scid).val(m_round(amount)); 
        }else{
           $("#8_"+scid).val(""); 
        }
   
    }else if(!isNaN(qty)&& !isNaN(price)){
        amount=(qty*price);
        if(amount!=0){
           $("#8_"+scid).val(m_round(amount)); 
        }else{
           $("#8_"+scid).val(""); 
        }
    }
  }
}

function gross_amount(){
    var gross=loop=0;
    var free=parseFloat(0);
    $(".amount").each(function(){
        var gs=parseFloat($("#5_"+loop).val() * $("#3_"+loop).val());
        if(!isNaN(gs)){    
          gross=gross+gs;
        }    
        if($("#f_"+loop).val()==1){
            free+=parseFloat($("#5_"+loop).val() * $("#3_"+loop).val())
        }
        loop++;

    });
    $("#total2").val(m_round(gross));
    $("#free_tot").blur();
}

function net_amount(){
    var gross_amount=parseFloat($("#total2").val());
    var free_amount=parseFloat($("#free_tot").val());
    var free=parseFloat(0);
    var net_amount=additional=loop=0;
    $(".foo").each(function(){
        var add=parseFloat($("#tt_"+loop).val());
        var f= $("#hh_"+loop).val();

        if(!isNaN(add)){
        if(f==1){
            additional=additional+add;
            }else{
            additional=additional-add;    
        }
    }    
        loop++;
    });
    $("#addi_tot").val(additional);
    var discount=0;
    $(".tot_discount").each(function(e){
        if(!isNaN(parseFloat($("#tot_dis_"+e).val()))){
          discount+=parseFloat($("#tot_dis_"+e).val());
        }
    });

    if(!isNaN(additional)&& !isNaN(gross_amount)){
        net_amount=gross_amount+additional-parseFloat($("#total_discount").val());
        $("#net_amount").val(m_round(net_amount));
    }else{
        $("#net_amount").val(net_amount);
    }
    $("#total_discount").val(m_round(discount));  
}

function check_is_batch_item2(x,scid){
    var store=$("#stores").val();
    $.post("index.php/main/load_data/t_cash_sales_sum/is_batch_item",{
        code:x,
        store:store
     },function(res){
       $("#btnb_"+scid).css("display","none"); 
       if(res==1){
       $("#btnb_"+scid).css("display","block");
       }
    },'text');
}

function check_is_sub_item2(x,scid){
    var store=$("#stores").val();
    $.post("index.php/main/load_data/utility/is_sub_item",{
        code:x          
     },function(res){
        $("#sub_"+scid).css("display","none");    
        if(res==1){
            $("#sub_"+scid).css("display","block");
        }
    },'text');
}

function check_is_batch_item(scid){
    var store=$("#stores").val();

    $.post("index.php/main/load_data/t_cash_sales_sum/is_batch_item",{
        code:$("#0_"+scid).val(),
        store:store
     },function(res){
       if(res==1){
        $("#serch_pop3").center();
        $("#blocker3").css("display", "block");
        setTimeout("select_search3()", 100);
        load_items3($("#0_"+scid).val());
        }else if(res=='0'){
            $("#1_"+scid).val("0");
            $("#1_"+scid).attr("readonly","readonly");
        }else{
            $("#1_"+scid).val(res.split("-")[0]);
            $("#bqty_"+scid).val(res.split("-")[1]);
            $("#1_"+scid).attr("readonly","readonly");
        }
        get_cur_stock($("#0_"+scid).val(),$("#1_"+scid).val(),scid);
    },'text');
}

function check_min_price(scid){
    var p = parseFloat($("#3_"+scid).val());
    var discount = parseFloat($("#7_"+scid).val());
    var price = p-discount;
    var min = parseFloat($("#item_min_price_"+scid).val());

    if(price<min){
       set_msg("Price couldn't  Be lower than ("+m_round(min)+")");
       $("#3_"+scid).focus();
    }
}



function discount_amount(){
    var dis=loop=0;
    $(".amount").each(function(){
        var gs=parseFloat($("#7_"+loop).val())*parseInt($("#5_"+loop).val());
        if(!isNaN(gs)){    
            dis=dis+gs;
        }    
        loop++;
    });
    $("#total_discount").val(m_round(dis));
}

function is_sub_item(x){
  sub_items=[];
  
  $("#subcode_"+x).val("");
  $.post("index.php/main/load_data/utility/is_sub_items", {
        code:$("#0_"+x).val(),
        qty:$("#rcvqty_"+x).val(),
        batch:$("#1_"+x).val()
      }, function(r){
        if(r!=2){
          for(var i=0; i<r.sub.length;i++){
            add(x,r.sub[i].sub_item,r.sub[i].qty);
        }  
        $("#subcode_"+x).attr("data-is_click","1");
      }
     },"json");
}

function add(x,items,qty){
  $.post("index.php/main/load_data/utility/is_sub_items_available", {
      code:items,
      qty:qty,
      grid_qty:$("#rcvqty_"+x).val(),
      batch:$("#1_"+x).val(),
      hid:$("#hid").val(),
      trans_type:"4",
      store:$("#stores").val()
    }, function(res){
        if(res!=2){
          sub_items.push(res.sub[0].sub_item+"-"+res.sub[0].qty);
          $("#subcode_"+x).val(sub_items);
        }else{
          set_msg("Not enough quantity in this sub item ("+items+")","error");
          $("#subcode_"+x).val("");
        }
  },"json");
}

function get_sales_type(i){
    $.post("index.php/main/load_data/r_additional_items/get_type",{
         id:$("#00_"+i).val()
        },function(res){      
          $("#hh_"+i).val(res);
     },"text");
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
            load_items4($("#0_"+scid).val(),$("#1_"+scid).val());
        }
    },'text');
}

function load_items4(x,batch){
    $.post("index.php/main/load_data/utility/sub_item", {
        search : x,
        batch :batch
    }, function(r){
        $("#sr3").html(r);
    }, "text");
}

function check_batch_qty(scid){
    $.post("index.php/main/load_data/t_cash_sales_sum/get_batch_qty",{
        store:$("#stores").val(),
        batch_no:$("#1_"+scid).val(),
        code:$("#0_"+scid).val(),
        hid:$("#hid").val()
    },function(res){
        if(parseFloat(res)<0){
            res=0;
        }
        if(parseFloat(res) < parseFloat($("#rcvqty_"+scid).val())){
          $("#rcvqty_"+scid).val("");
          set_msg("Maximum availabe quantity in this batch ("+parseFloat(res)+") ","error");
        }
    },"text");
}

function delete_cr_transe_record(item){
  $.post("index.php/main/load_data/t_sales_order/delete_trance_recode", {
        item : item,
        no : $("#id").val()
    }, function(r){
        if(r==1){
          alert("Record Deleted Successfully");
        }
    }, "json");
}

function load_card_type(){
    $.post("index.php/main/load_data/t_sales_order/f1_card_type", {
        data_tbl:"m_credit_card_type",
        field:"card_type",
        field2:"card_type",
        preview2:"",
        search : $("#pop_search12").val() 
    }, function(r){
        $("#sr12").html(r);
        settings_card_type();        
    }, "text");
}

function settings_card_type(){ 
 $("#item_list .cl").click(function(){  
    $("#type1_"+scid).val($(this).children().eq(0).html());
    $("#pop_close12").click();
  });
}


function load_receive_chk(){
    $.post("index.php/main/load_data/t_payment_option/receive_chku", {
        search : $("#pop_search11").val() 
    }, function(r){
        $("#sr11").html(r);
        settings_receive_chk();        
    }, "text");
}

function settings_receive_chk(){ 
 $("#item_list .cl").click(function(){  
    var bank = $(this).children().eq(1).html().split("-")[0];
    $("#bank9_"+scid).val($(this).children().eq(0).html());
    $("#branch9_"+scid).val($(this).children().eq(2).html());
    $("#pop_close11").click();
  });
}

function load_bank(){
    $.post("index.php/main/load_data/t_payment_option/bank_rate", {
        search : $("#pop_search15").val() 
    }, function(r){
        $("#sr15").html(r);
        settings_bank();        
    }, "text");
}

function settings_bank(){ 
 $("#item_list .cl").click(function(){  
    $("#bank1_"+scid).val($(this).children().eq(0).html());
    $("#1bank1_"+scid).val($(this).children().eq(1).html());
    $("#month1_"+scid).val($(this).children().eq(3).html());
    $("#rate1_"+scid).val($(this).children().eq(4).html()); 
    $("#acc1_"+scid).val($(this).children().eq(2).html());
    $("#merchant1_"+scid).val($(this).children().eq(5).html());

    cal_amnt($("#amount1_"+scid).val(),$(this).children().eq(4).html(),"#amount_rate1_");
   
    $("#pop_close15").click();
  });
}

function cal_amnt(amount,rate,total_txt){

    var amount = parseFloat(amount);
    var rate = parseFloat(rate);

    var total =(amount*rate/100);

    //alert(total_txt+scid);
    $(total_txt+scid).val(total);   
    $(total_txt+scid).blur();

}


function cal_totals(){
    var tot_card=parseFloat(0);
    var tot_chq=parseFloat(0);
    var tot_cash=parseFloat($("#cash_ad").val());

    if(isNaN(tot_cash)){
        tot_cash=0;
        $("#cash_ad").val("0.00");
    }else{
        tot_cash=parseFloat($("#cash_ad").val());
    }

    for(var x=0; x<10; x++){
        if($("#amount1_"+x).val()!="" && $("#amount1_"+x).val()>0){
            tot_card+=parseFloat($("#amount1_"+x).val());
        }

        if($("#amount9_"+x).val()!="" && $("#amount9_"+x).val()>0){
            tot_chq+=parseFloat($("#amount9_"+x).val());
        }
    }
    $("#card_ad").val(m_round(tot_card));
    $("#chq_ad").val(m_round(tot_chq));
    var all_tot = parseFloat(tot_card) + parseFloat(tot_chq) + parseFloat(tot_cash);
    $("#tot_ad").val(m_round(all_tot));
}


function get_cur_stock(item,batch,no){
  $.post("index.php/main/load_data/t_sales_order/cur_stock", {
    code : item,
    batch:batch,
    store:$("#stores").val()
  }, function(res){
    if($("#hid").val() =="" || $("#hid").val() =="0"){
      if(res!=2){
        $("#cqty_"+no).val(res[0].qty);
      }else{
        $("#cqty_"+no).val(0);
      }
    }else{
      if(res!=2){
        if($("#rcvqty_"+no).val()==""){
          var rcv_qty=0;
        }else{
          var rcv_qty=$("#rcvqty_"+no).val();
        }

        var qty = parseFloat(res[0].qty) + parseFloat(rcv_qty);
        $("#cqty_"+no).val(qty);
      }else{
        $("#cqty_"+no).val(0);
      }
    }
  }, "json");
}


function load_price_range(item,batch){
    if(item!="" && batch!=""){
        load_prices($("#0_"+scid).val(),$("#1_"+scid).val(),$("#s3").val(),$("#s4").val(),$("#s3_des").val(),$("#s4_des").val());
        $("#serch_pop11").center();
        $("#blocker").css("display", "block");
    }else{
        set_msg("Please select item code and batch no");
    }
}

function load_prices(item,batch,s3,s4,s3des,s4des){
    $.post("index.php/main/load_data/t_cash_sales_sum/sales_prices", {
        item:item,
        batch:batch,
        s3:s3,
        s4:s4,
        s3des:s3des,
        s4des:s4des
    }, function(r){
        $("#sr11").html(r);
        setting_prices();
    },"text");
}

function setting_prices(){
    $("#item_list .cl").click(function(){        
        $("#3_"+scid).val($(this).children().eq(2).html());
        $("#3_"+scid).blur();
        $("#pop_close11").click();                
    });   
}

 function pop_data(){
      $.post("index.php/main/load_data/t_sales_order/pop_cus", {
          search:$("#pop_search14").val(),
      }, function(res){
        $("#sr14").html(res);
        settings9();
      },"text");
  }

  function settings9(){
    $("#item_list .cl").click(function(){ 
        var id =  $(this).children().eq(1).html();
        $("#id").val($(this).children().eq(1).html());
        load_data(id);
        $("#pop_close14").click();                
    })    
}

function dis_prec(){
  if($("#dis_update").val()!="1"){
      var qty=parseFloat($("#5_"+scid).val());
      var price=parseFloat($("#3_"+scid).val());
      var discount=parseFloat($("#7_"+scid).val());
      var dis_pre="";

      if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount)){
        dis_pre=(discount*100)/(qty*price);
        if(isNaN(dis_pre) || !isFinite(dis_pre)){    
          $("#6_"+scid).val("");
        }else{
          $("#6_"+scid).val(m_round(dis_pre));
        }
      }
    }else{
      var qty=parseFloat($("#5_"+scid).val());
      var price=parseFloat($("#3_"+scid).val());
      var discount="";
      var dis_pre=parseFloat($("#6_"+scid).val());
      if(!isNaN(qty)&& !isNaN(price) && !isNaN(dis_pre)){
        discount=((qty*price)*dis_pre)/100;
       
        if(isNaN(discount) || !isFinite(discount)){   
          $("#7_"+scid).val("");
        }else{
          $("#7_"+scid).val(m_round(discount)); 
        }
      }
    }
}


































































// var p_code = window.location.search.split('=')[2];
// var sub_items=[];
// var pr_type=1;

    var result;
    $(function(){
    $(".quns").css("display", "none");
    $(".qunsb").css("display","none");
    $(".subs").css("display","none");
    $("#payment_option").attr("checked", "checked");
    //$("#btnSave").attr("disabled","disabled");
    $("#btnApprove").attr("disabled","disabled");
    $("#btnSavee").css("display","none");



     $(".foo").focus(function(){
        set_cid($(this).attr("id"));
        $("#serch_pop7").center();
        $("#blocker2").css("display", "block");
        setTimeout("select_search7()", 100);
    });


    $(".price, .qty, .dis_pre, .foc").blur(function(){
     // check_if_reached_to_minimum_price();
     set_cid($(this).attr("id"));
     //dis_prec();

     var foc=parseFloat($("#4_"+scid).val());
      if(isNaN(foc)){foc=0;}

      if(foc==0){
        //dis_prec();
        amount();
        gross_amount();
        // gross_amount1();
        //discount_amount();
       // privilege_calculation();
        //all_rate_amount();
        net_amount();
      }else{
        //dis_prec();
        amount();
        gross_amount();
        // gross_amount1();
        //discount_amount();
        //privilege_calculation();
        //all_rate_amount();
        net_amount();
      }
    });

    load_items2();
    $("#pop_search7").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { load_items2();
        }
    });   

    $("#pop_close3").click(function(){
        check_items();
        dis_prec();
        amount();
        gross_amount();
        discount_amount();
        dis_prec();
        net_amount();
    });

        $("#id").keypress(function(e){
            if(e.keyCode == 13){
                $(this).blur();
                load_data($(this).val());
            if($("#is_cash_b").val()!=1){
               load_payment_option_data($(this).val(),"4");
               $("#btnSave").attr("disabled","disabled");
           }
            }
        });


        $("#pop_search").gselect();
        $("#pop_search2").gselect();
        $("#pop_search3").gselect();

        $("#btnPrint").click(function(){
            if($("#hid").val()=="0"){
                set_msg("Please load data before print");
                return false;
            }else{
                $("#print_pdf").submit();
            }  
        });


        $(".fo").blur(function(){
             var id=$(this).attr("id").split("_")[1];
             if($(this).val()=="" || $(this).val()=="0"){
             }else if($(this).val()!=$("#itemcode_"+id).val()){
                if($("#df_is_serial").val()=='1'){
                    deleteSerial(id);
                }
             }
          });



        $(".qty, .foc").blur(function(){
            balance_item_free(scid);
            //dis_prec();
            check_qty(scid);
        });

    $(".qty").blur(function(){
            item_free(scid);        
            is_sub_item(scid);
    });

    $("#sales_category").change(function() {
       get_group();
    });




// default_option();


 });




function check_items(){

    var check_det="";
    var cont=0;
    var items="";
    $(".chk_class").each(function(e){
        if($("#free_chk_"+e).is(':checked')){
            check_det+=$("#item_"+e).html()+"|"+$("#des_"+e).html()+"|"+$("#model_"+e).html()+"|"+$("#max_"+e).html()+"|"+$("#itemqty_"+e).html()+"|"+$("#qty_"+e).html()+",";   
            cont++;
        }
    });
    // alert();
     var fr_item=($("#fritems").html());
      //if(cont>0){
        get_chk_itm_det(check_det,fr_item,cont); 
      //}
        
}

function get_chk_itm_det(check_det,free_item,count){
   
    var free_item=free_item;
    var count=count;
    var status=$("#itm_status_"+scid).val();

if(status!="1"){
 if(free_item==count){
    if(isNaN(parseInt($("#4_"+scid).val()))){
        var qty=parseInt($("#5_"+scid).val());
       }else{
        var qty=parseInt($("#5_"+scid).val())-parseInt($("#4_"+scid).val());
       }
    if($("#4_"+scid).val() != "")
    {
        $("#bal_free_"+scid).val($("#4_"+scid).val());
        $("#issue_qty_"+scid).val($("#4_"+scid).val());
    }

    var free_qty = "";

    var check_details=check_det;
    var split_1=check_details.split(",");

    var len=split_1.length-1;
   for(x=0;x<len;x++){
        var split_2=split_1[x].split("|");
        var Item_code=split_2[0];
        var Item_name=split_2[1];
        var Item_model=split_2[2];
        var Item_price=split_2[3];
        var Item_qty=split_2[4];
        var select_qty=split_2[5];
                

       //if(Item_code != "&nbsp;"){
        if(Item_code!=$("#0_"+scid).val()){
            free_qty=parseInt(Item_qty);
            if(check_item_exist2(Item_code)){

                 var get=Item_code;
                 var name=Item_name;
                 var modal=Item_model;
                 var price=Item_price;
                 // free_qty=parseInt($(this).children().eq(4).html());
                 var sign="1";
                 var sign="1";

                    var issue_qty = (qty/select_qty);

                 if(qty%select_qty=='0'){
                     var issue_qty = (qty/select_qty)*Item_qty;
                 }else{

                    var floor_issue=Math.floor(issue_qty);
                    var issue_qty=parseInt(floor_issue*Item_qty);
                    
                 }


                  for(var i=0; i<25 ;i++){
                    if($("#0_"+i).val()==get){
                        return false;
                      }else if($("#0_"+i).val()==""){
                        if($("#df_is_serial").val()=='1'){
                            check_is_serial_item2(get,i);
                        }
                       
                        $("#0_"+i).val(get);
                        $("#h_"+i).val(get);
                        $("#n_"+i).val(name);
                        $("#2_"+i).val(modal);
                        $("#3_"+i).val(price);
                        $("#free_price_"+i).val(price);
                        $("#5_"+i).val(Math.floor(issue_qty));
                        $("#issue_qty_"+i).val(Math.floor(issue_qty));
                        $("#f_"+i).val(sign);
                        $("#bal_free_"+i).val(Math.floor(issue_qty));
                        $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
                        $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                        $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                        
                        $("#cqty_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#cqty_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');                       
                        $("#deqty_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#deqty_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');                       
                        
                        $("#deqty_"+i).closest("tr").find('input').attr("readonly","readonly");


                        $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                        $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                        $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
                        $("#8_"+i).val(parseFloat($("#5_"+i).val()*$("#3_"+i).val()));
                        $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                        $("#itm_status_"+scid).val("1");
                      /*  $("#5_"+i).focus();
                        $("#3_"+i).blur();*/
                        check_is_batch_item2(get,i);
                        check_is_sub_item2(get,i);
                        check_is_batch_item_free(i);
                        check_is_batch_item(i);
                        break; 

                      }
                  }          
                $("#11_"+scid).focus();
                all_rate_amount();
                net_amount();
                $("#pop_close2").click();  
            }else{
                var ff = qty/free_qty;
                for(var a=0; a<25 ;a++){
                    if($("#0_"+a).val()==Item_code){
                        //$("#5_"+a).val(Math.floor(ff));
                      } 
                  }  
                set_msg("Item "+Item_code+" is already added and free quantity updated.");
                }
                }else{

                    if($('#0_'+scid).hasClass("FOCAdded")){
    

                    var floor_issue=parseInt(Item_qty);
                    var qqty = parseInt($("#5_"+scid).val());
                    var issue_qty=Math.floor(qqty/select_qty);
                    $("#5_"+scid).val(issue_qty+qty);
                    $("#4_"+scid).val(issue_qty);

                    $('#0_'+scid).removeClass("FOCAdded");
                    }
                    
                }

        
            }
        }else{
           
            
        }
    }else{
        set_msg("Maximum Free Items Already Added");
    }
}




function balance_item_free(id){
   var qty = parseInt($("#5_"+id).val());
   var foc = parseInt($("#4_"+id).val());
   var bal = parseInt($("#bal_free_"+id).val());
   var each_price = parseFloat($("#3_"+id).val());
   var price = parseFloat($("#free_price_"+id).val());
   var is_free_item = $("#f_"+id).val();
  

    if($("#4_"+id).val()!=""){
        bal = bal-foc;

        $("#bal_tot_"+id).val(bal+"-"+each_price*bal);
        $("#f_"+id).val("2");

    }else{ 

        bal = bal-qty;
        $("#bal_tot_"+id).val(bal+"-"+price*bal);

    }
}

    

function item_free(no){

   if(isNaN(parseInt($("#5_"+no).val())))
   {
    var qty=0;
   }
   else
   {
    var qty=parseInt($("#5_"+no).val());
   }


   // if(isNaN(parseInt($("#4_"+no).val())))
   // {
   //  var qty=parseInt($("#5_"+no).val());
   // }
   // else
   // {
   //  var qty=parseInt($("#5_"+no).val())-parseInt($("#4_"+no).val());
   // }


    var item=$("#0_"+no).val();

    $.post("index.php/main/load_data/t_cash_sales_sum/item_free",{
        quantity:qty,
        item:item,
        date:$("#date").val()
     },function(r){
        if(r!='2'){

          // alert($("#f_"+no).attr("id"));
          // alert(r.a[0].code);
           // $("#f_"+no).val("1");
            for(i=0; i<r.a.length; i++){
                if(r.a[i].code == item){
                    var free_qty=parseInt(r.a[i].qty)
                    var issue_qty = qty/free_qty;
                    if($('#0_'+scid).hasClass("FOCAdded")){

                        //$("#5_"+no).val(Math.floor(issue_qty)+qty);
                        //$("#4_"+no).val(Math.floor(issue_qty));
                        //$('#0_'+scid).removeClass("FOCAdded");
                    }
                }



            }
            $("#serch_pop3").center();
            $("#blocker3").css("display", "block");
            setTimeout("select_search3()", 100);
            load_items5($("#0_"+scid).val(),no);
        }

    }, "json");
}



function check_is_batch_item_free(scid){
    var store=$("#stores").val();
    $.post("index.php/main/load_data/t_cash_sales_sum/is_batch_item",{
        code:$("#0_"+scid).val(),
        store:store
     },function(res){
       
       if(res==1){
        
        $("#serch_pop3").center();
        $("#blocker3").css("display", "block");
        setTimeout("select_search3()", 100);
        load_items3($("#0_"+scid).val());
        }else if(res=='0'){

            $("#1_"+scid).val("0");
            $("#1_"+scid).attr("readonly","readonly");
        }else{
            
            $("#1_"+scid).val(res.split("-")[0]);
            $("#bqty_"+scid).val(res.split("-")[1]);
            $("#1_"+scid).attr("readonly","readonly");
       }
    },'text');
}



function load_items5(x,y){
  if(isNaN(parseInt($("#5_"+y).val())))
   {
    var qty=0;
   }
   else
   {
    var qty=parseInt($("#5_"+y).val());
   }

   // if(isNaN(parseInt($("#4_"+y).val())))
   // {
   //  var qty=parseInt($("#5_"+y).val());
   // }
   // else
   // {
   //  var qty=parseInt($("#5_"+y).val())-parseInt($("#4_"+y).val());
   // }



    var item=$("#0_"+y).val();

// alert($("#5_"+y).val());
    $.post("index.php/main/load_data/t_cash_sales_sum/item_free_list",{
        quantity:qty,
        item:item,
        date:$("#date").val()
     },function(r){   
        if(r!=2){ 
            $("#sr3").html(r);
           /* settings6();*/
            //$("#4_"+y).attr("readonly","readonly");
            $("#5_"+y).attr("readonly",true);
        }
    }, "text");
}


function check_qty(scid){
    var foc  = $("#4_"+scid).val();
    var qtyy = $("#5_"+scid).val();
    var qty  = parseInt($("#5_"+scid).val());
    var issue_qtys = parseInt($("#issue_qty_"+scid).val());
    var item = $("#0_"+scid).val();
    var focs = parseInt($("#4_"+scid).val());


    if(foc=="" && qtyy != ""){
        if(qty>issue_qtys){
            set_msg("this item ("+item+") quantity should be less than "+issue_qtys,"error");
            $("#5_"+scid).val(issue_qtys);
            return false;
        }

    }else if(foc!=""){
        if(focs>issue_qtys){
            set_msg("this item ("+item+") FOC quantity should be less than "+issue_qtys,"error");
            $("#4_"+scid).val(issue_qtys);
            return false;
        }
    }

    return true;
}

function check_item_exist3(id){
    var v = true;
    return v;
}

function item_free_delete(no){

   if(isNaN(parseInt($("#4_"+no).val()))){
    var qty=parseInt($("#5_"+no).val());
   }else{
    var qty=parseInt($("#5_"+no).val())-parseInt($("#4_"+no).val());
   }
    var item=$("#0_"+no).val();

    $.post("index.php/main/load_data/t_cash_sales_sum/item_free_delete",{
        quantity:qty,
        item:item
     },function(r){

        if(r!='2'){
            $("#f_"+no).val("2");
                for(var x=0; r.a.length>x;x++){
                    for(var i=0; i<25;i++){ 
                        if($("#0_"+i).val()==item || $("#0_"+i).val()==r.a[x].code  && $("#f_"+i).val()==1){
                            console.log($("#0_"+i).val());
                            $(this).val("");
                            $("#h_"+i).val("");
                            $("#0_"+i).val("");
                            $("#n_"+i).val("");
                            $("#1_"+i).val(""); 
                            $("#2_"+i).val(""); 
                            $("#3_"+i).val(""); 
                            $("#4_"+i).val(""); 
                            $("#5_"+i).val("");
                            $("#6_"+i).val(""); 
                            $("#7_"+i).val(""); 
                            $("#8_"+i).val(""); 
                            $("#9_"+i).val("");
                            $("#f_"+i).val("");
                            $("#bal_free_"+i).val("");
                            $("#bal_tot_"+i).val("");
                            $("#free_price_"+i).val("");
                            $("#issue_qty_"+i).val("");
                            $("#subcode_"+i).val("");
                            $("#bqty"+i).val("");
                            $("#cqty_"+i).val("");
                            $("#deqty_"+i).val("");


                            $("#subcode_"+i).removeAttr("data-is_click");
                            $("#5_"+i).attr("readonly", false);


                            $("#h_"+no).val("");
                            $("#0_"+no).val("");
                            $("#n_"+no).val("");
                            $("#1_"+no).val(""); 
                            $("#2_"+no).val(""); 
                            $("#3_"+no).val(""); 
                            $("#4_"+no).val(""); 
                            $("#5_"+no).val("");
                            $("#6_"+no).val(""); 
                            $("#7_"+no).val(""); 
                            $("#8_"+no).val(""); 
                            $("#9_"+no).val("");
                            $("#f_"+no).val("");
                          
                            $("#bal_free_"+no).val("");
                            $("#bal_tot_"+no).val("");
                            $("#free_price_"+no).val("");
                            $("#issue_qty_"+no).val("");
                            $("#subcode_"+no).val("");
                            $("#bqty"+no).val("");
                            $("#subcode_"+no).removeAttr("data-is_click");
                            $("#5_"+no).attr("readonly", false);

                            $("#n_"+i).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
                            $("#2_"+i).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#1_"+i).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
                            $("#1_"+i).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
                            $("#3_"+i).closest("td").attr('style', 'width: 58px;');
                            $("#6_"+i).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            $("#8_"+i).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

                            $("#0_"+i).closest("tr").attr('style', 'background-color: #ffffff !important;');

            $("#cqty_"+i).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
            $("#cqty_"+i).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
            $("#deqty_"+i).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
            $("#deqty_"+i).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');





                            $("#n_"+no).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
                            $("#2_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#1_"+no).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
                            $("#1_"+no).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
                            $("#3_"+no).closest("td").attr('style', 'width: 58px; ');
                            $("#6_"+no).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            $("#8_"+no).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

                            $("#0_"+no).closest("tr").attr('style', 'background-color: #ffffff !important;');
                        
                            $("#btn_"+i).css("display","none"); 
                            $("#btnb_"+i).css("display","none");
                            $("#sub_"+i).css("display","none");

                            $("#btn_"+no).css("display","none"); 
                            $("#btnb_"+no).css("display","none");
                            $("#sub_"+no).css("display","none");

                            amount();
                            gross_amount();
                            all_rate_amount();
                            net_amount();

                        }
                    }
                } 
            
        }
    }, "json");
}

