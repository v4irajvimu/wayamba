var sub_items =[];
var is_click=0;
$(document).ready(function(){

$(".subs").css("display","none");
$("#btnSavee").css("display","none");
$(".focb").css("display","none");
$(".colors").css("display","none");

load_purchase();

$("input[type=text]").blur(function(){
  calculate_actual_cost();
})


$(".colors").click(function(){
  set_cid($(this).attr("id"));
  $("#serch_pop").center();
  $("#blocker").css("display", "block");
  setTimeout("select_search()", 100);
  view_colors();
});
$("#pop_search").keyup(function(e){
  if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) {
    view_colors();
  }
});


$("#is_po").click(function(){
   if($("#is_po").attr("checked")=="checked"){
    $("#po_update").val("1");
    $("#pono").attr("readonly","readonly");
    $("#pono").val("");
   }else{
    $("#po_update").val("0");
    $("#pono").removeAttr("readonly");
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

$(".rc").keyup(function(){
  set_cid($(this).attr("id"));
  for(var t=0; t<25; t++){
    if($("#0_"+t).val()!=""){
      if($("#f0_"+scid).val()==$("#0_"+t).val()){
        var bal = parseInt($("#f3_"+scid).val()) - parseInt($("#f4_"+scid).val());
        var qty = parseInt($("#3_"+t).val())-parseInt(bal);
        $("#2_"+t).val(qty);
        $("#2_"+i).blur();
      }
    }
   }
});


$(".freitm").click(function(){
  set_cid($(this).attr("id"));
  if($("#free_"+scid).is(":checked")){
    if($("#0_"+scid).val() != ""){
      if(parseInt($("#2_"+scid).val()) > 0){
        mark_as_free(scid,$("#0_"+scid).val());
      }else{
        set_msg("quantity should be greater than zero");
        $("#2_"+scid).focus();
        $("#free_"+scid).attr("checked",false);
      }
    }else{
      set_msg("please enter item first");
      $("#free_"+scid).attr("checked",false);
    }
  }else{
    uncheck_free(scid,$("#0_"+scid).val());
  }
});

$(".fo").dblclick(function(){
  set_cid($(this).attr("id"));
  if($(this).val()!=""){
      $.post("index.php/main/load_data/utility/get_sub_item_detail3", {
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



$(".fr").keypress(function(e){
  set_cid($(this).attr("id"));
    if(e.keyCode == 46){
      $("#fmain_"+scid).val("");
      $("#f0_"+scid).val("");
      $("#fh_"+scid).val("");
      $("#f1_"+scid).val("");
      $("#f2_"+scid).val("");
      $("#f3_"+scid).val("");
      $("#f4_"+scid).val("");
      $("#f5_"+scid).val("");
      $("#f6_"+scid).val("");
    }
  })

$(".focb").click(function(){
  set_cid($(this).attr("id"));
  view_free_items($("#0_"+scid).val(),$("#2_"+scid).val());
  $('#pop_search14').css("display","none");
  $("#serch_pop14").center();
  $("#blocker").css("display", "block");
  setTimeout("$('#pop_search14').focus()", 100);
});

function set_id(id){
    id = id.split('_');
    fcid = id[0];
    d = id[1];
}

  $(".edit_btn").click(function(){
    set_cid($(this).attr("id"));
    if($("#hid").val()=="0"){
     settings_ponof1($("#0_"+scid).val());
      if($("#po_"+scid).val()!=""){
       window.setTimeout(function () {
                var po_pur=$("#po_"+scid).val();
                var pur_spl = po_pur.split(",");
                for(var len=0; len<pur_spl.length-1; len++){
                  var all_det = po_pur.split(",")[len];
                  var pono=all_det.split("-")[0];
                  var qty=all_det.split("-")[1];
                  $("#purchqty_"+len).val(qty);
                }
            }, 500);
       }
    }else{
      if($("#po_"+scid).val()!=""){
       window.setTimeout(function () {
                var po_pur=$("#po_"+scid).val();
                var pur_spl = po_pur.split(",");
                var tbl="";
                tbl="<table style='width:100%' >";
                tbl+="<thead><tr>";
                tbl+="<th class='tb_head_th'>Po Number</th>";
                tbl+="<th class='tb_head_th'>Request Qty</th>";
                tbl+="<th class='tb_head_th'>Balance Qty</th>";
                tbl+="<th class='tb_head_th'>Purchase Qty</th>";
                tbl+="</tr>";

                for(var len=0; len<pur_spl.length-1; len++){

                  var all_det = po_pur.split(",")[len];
                  var pono=all_det.split("-")[0];
                  var req_qty=all_det.split("-")[2];
                  var bal_qty=all_det.split("-")[3];
                  var qty=all_det.split("-")[1];

                tbl+="<tr class='cl'>";
                tbl+="<td style='text-align:center;'><input type='text' value='"+pono+"' readonly='readonly' style='width:100%;'  id='nno_"+len+"'></td>";
                tbl+="<td style='text-align:right;'><input type='text' value='"+req_qty+"' readonly='readonly' style='width:100%;' class='req_qty' id='req_"+len+"'>";
                tbl+="<td style='text-align:right;'><input type='text' value='"+bal_qty+"' readonly='readonly' style='width:100%;' class='bal_qty' id='balanqty_"+len+"'>";
                tbl+="<td style='text-align:center;'><input type='text' value='"+qty+"' style='width:100%;' class='pur_qty' id='purchqty_"+len+"' value=''></td>";
                tbl+="</tr>";

                }  tbl+="</table>";
                $("#pop_search").css("display","none");
                $("#serch_pop").center();
                $("#blocker").css("display", "block");
                $("#sr").html(tbl);

            }, 500);
    }
  }
  // $("#pop_close10").click();
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

$(document).on('keyup','.pur_qty',function(){
  set_id($(this).attr("id"));
  if(parseInt($(this).val())>parseInt($("#balanqty_"+d).val())){
    set_msg("Purchase Quantity Should be Lower than Balance Quantity");
    $("#purchqty_"+d).val("");
  }
});

$(document).on('click','#pop_close',function(){
  $("#po_"+scid).val("");
  var po="";
  var sum_pur=parseFloat(0);
   $(".pur_qty").each(function(e){
    po+=$("#nno_"+e).val()+"-"+$("#purchqty_"+e).val()+"-"+$("#req_"+e).val()+"-"+$("#balanqty_"+e).val()+',';
    if($("#purchqty_"+e).val()!=""){
      sum_pur += parseFloat($("#purchqty_"+e).val());
    }
  });
   is_has_free($('#0_'+scid).val(),scid);
   $("#2_"+scid).val(sum_pur);
   $("#po_"+scid).val(po);
   $("#2_"+scid).blur();
});



  $(".ad_cst").click(function(){
    var t = parseFloat(0);

    $(".ad_cst").each(function(x){
      if($("#hh_"+x).val()=="1"){
        if($(this).is(":checked")){
          t+=parseFloat($("#22_"+x).val());
        }
      }
    });
    $("#tot_add_cost").val(m_round(t));

    for(var i=0; i<25; i++){
      if($("#0_"+i).val()!=""){
        var item_cost = parseFloat($("#ccc_"+i).val());
        var trsprt_amount = parseFloat(t);
        var qty = parseFloat($("#2_"+i).val());
        var grn_amount = parseFloat($("#gross_amount").val());

        var add_cost = ((trsprt_amount/grn_amount)*item_cost*qty)/qty;
        $("#4_"+i).val(m_round(add_cost+item_cost));

        $("#2_"+i).blur();
        calculate_last_price_margin();
        calculate_sales_price_margin();
      }
    }

    calculate_free_total();
    dis_prec();
    amount();
    additional_amount();
    gross_amount2();
    net_amount2();
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

  $("#typess").change(function(){
    $("#pono").val("");
    empty_grid();
  });

  $(".price").keyup(function(){
    calculate_last_price_margin();
    calculate_sales_price_margin();
  });

  $(".quns").css("display", "none");
    $("#code").blur(function(){
        check_code();
    });

  $("#supplier_create").click(function(){
      window.open($("#base_url").val()+"?action=m_supplier","_blank");
      return false;
  });

  $("#btnDelete5").click(function(){
    set_delete();
  });

  $("#btnPrint").click(function(){
  	if($("#hid").val()=="0"){
   		set_msg("Please load data before print");
     	return false;
   	}
   	else
   	{
      $("#print_pdf").submit();
   	}
  });

  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
    }
  });

  $(".qty").keyup(function(){
    $("#qtyt_"+scid).val($("#2_"+scid).val());
  });

  $(".foc").keyup(function(){
   tot_qty();
   calculate_free_total();
  });

  $(".foc , .qty").blur(function(){
   tot_qty();
   calculate_free_total();
  });

  $("#btnApprove").attr("disabled",true);
  $("#btnApprove").click(function(){
    $("#app_status").val("2");
    if(validate()){
      save();
    }
  });

  $("#supplier_id").keypress(function(e){
    if(e.keyCode == 112){
        $("#pop_search4").val($("#supplier_id").val());
        load_data_supf1();
        $("#serch_pop4").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search4').focus()", 100);
    }

   $("#pop_search4").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) {
             load_data_supf1();

        }
    });

    if(e.keyCode == 46){
        $("#supplier_id").val("");
        $("#supplier").val("");
    }
  });
  $("#checkby").keypress(function(e){
    if(e.keyCode == 112){
        $("#pop_search13").val($("#checkby").val());
        load_checkby();
        $("#serch_pop13").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search13').focus()", 100);
    }
   $("#pop_search13").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) {
             load_checkby();
        }
    });

    if(e.keyCode == 46){
        $("#checkby").val("");
        $("#checkby_des").val("");
    }
  });


$(".fo").keypress(function(e){
 if(e.keyCode == 112){
        $("#pop_search10").val();
        if($("#po_update").val()!="0"){
            load_data_2();
          }else{
            load_data_codef1();
          }

        $("#serch_pop10").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search10').focus()", 100);
    }
    $("#pop_search10").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) {
             if($("#po_update").val()!="0"){
          load_data_2();
          }else{
            load_data_codef1();
          }

        }
    });
    if(e.keyCode == 46){

    }
});


function load_data_codef1(){
      $.post("index.php/main/load_data/t_grn_sum/get_pono_code", {
        po_no:$("#pono").val(),
        type:$("#typess").val(),
        def_sales3:$("#def_sales3").val(),
        def_sales4:$("#def_sales4").val(),
        def_sales5:$("#def_sales5").val(),
        def_sales6:$("#def_sales6").val(),

      }, function(r)
      {
          $("#sr10").html(r);
          settings_codef1();

      }, "text");
  }

function settings_codef1(){
      $("#item_list .cl").click(
        function(){
        /* if(check_item_exist($(this).children().eq(0).html())){*/
          $("#btnedit_"+scid).css("display","block");
          $("#h_"+scid).val($(this).children().eq(0).html());
          $("#0_"+scid).val($(this).children().eq(0).html());
          $("#n_"+scid).val($(this).children().eq(1).html());
          $("#1_"+scid).val($(this).children().eq(2).html());
          $("#4_"+scid).val($(this).children().eq(3).html());
          $("#ccc_"+scid).val($(this).children().eq(3).html());
          $("#max_"+scid).val($(this).children().eq(4).html());
          $("#min_"+scid).val($(this).children().eq(5).html());
          $("#s3_"+scid).val($(this).children().eq(6).html());
          $("#s4_"+scid).val($(this).children().eq(7).html());
          $("#s5_"+scid).val($(this).children().eq(8).html());
          $("#s6_"+scid).val($(this).children().eq(9).html());

          var lpm= parseFloat(0);
            lpm = (parseFloat($(this).children().eq(5).html())-parseFloat($(this).children().eq(3).html()))/parseFloat($(this).children().eq(5).html())*100;
            $("#lpm_"+scid).val(m_round(lpm)+"%");

            var spm= parseFloat(0);
            spm = (parseFloat($(this).children().eq(4).html())-parseFloat($(this).children().eq(3).html()))/parseFloat($(this).children().eq(4).html())*100;
            $("#spm_"+scid).val(m_round(spm)+"%");
            $("#2_"+scid).focus();
          $("#pop_close10").click();
               settings_ponof1($(this).children().eq(0).html());
           /* }else{
              set_msg($(this).children().eq(1).html()+" is already added.");
              $("#pop_close10").click();
            }  */
      })
  }

  function load_data_2(){
    $.post("index.php/main/load_data/t_grn_sum/get_item_without_po", {
      search:$("#pop_search10").val(),
      def_sales3:$("#def_sales3").val(),
      def_sales4:$("#def_sales4").val(),
      def_sales5:$("#def_sales5").val(),
      def_sales6:$("#def_sales6").val(),
    }, function(r){
        $("#sr10").html(r);
        settings_item_w_po();
    }, "text");
  }

  function settings_item_w_po(){
      $("#item_list .cl").click(
        function(){
          /*if(check_item_exist($(this).children().eq(0).html())){*/
            $("#h_"+scid).val($(this).children().eq(0).html());
            $("#0_"+scid).val($(this).children().eq(0).html());
            $("#n_"+scid).val($(this).children().eq(1).html());
            $("#1_"+scid).val($(this).children().eq(2).html());
            $("#4_"+scid).val($(this).children().eq(3).html());
            $("#ccc_"+scid).val($(this).children().eq(3).html());
            $("#max_"+scid).val($(this).children().eq(4).html());
            $("#min_"+scid).val($(this).children().eq(5).html());
            $("#s3_"+scid).val($(this).children().eq(6).html());
            $("#s4_"+scid).val($(this).children().eq(7).html());
            $("#s5_"+scid).val($(this).children().eq(8).html());
             $("#s6_"+scid).val($(this).children().eq(9).html());

            var lpm= parseFloat(0);
              lpm = (parseFloat($(this).children().eq(5).html())-parseFloat($(this).children().eq(3).html()))/parseFloat($(this).children().eq(5).html())*100;
              $("#lpm_"+scid).val(m_round(lpm)+"%");
            var spm= parseFloat(0);
              spm = (parseFloat($(this).children().eq(4).html())-parseFloat($(this).children().eq(3).html()))/parseFloat($(this).children().eq(4).html())*100;
              $("#spm_"+scid).val(m_round(spm)+"%");
              $("#2_"+scid).focus();
              if($("#df_is_serial").val()!="0"){
              check_is_serial_item2($(this).children().eq(0).html(),scid);
              }
              check_is_sub_item2($(this).children().eq(0).html(),scid);
              is_sub_item(scid);
              is_has_free($(this).children().eq(0).html(),scid);
              is_color_item($(this).children().eq(0).html(),scid);
            $("#pop_close10").click();
            if($(this).children().eq(10).html()==1){
              $("#pop_search").val();
              view_colors();
              $("#serch_pop").center();
              $("#blocker").css("display", "block");
              setTimeout("$('#pop_search').focus()", 100);
            }else{
              set_default_color();
            }
      })
  }


  function settings_ponof1(item){
    $.post("index.php/main/load_data/t_grn_sum/load_po_sel", {
        item:item,
        po_no:$("#pono").val(),
        search : $("#pop_search").val(),
        type: $("#typess").val(),
        sup : $("#supplier_id").val()
    }, function(r){
        $("#sr").html(r);
        $("#pop_search").css("display","none");
         /*settings_po();  */
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("select_search()", 100);

    }, "text");

  }

  function load_checkby(){
      $.post("index.php/main/load_data/utility/f1_selection_list", {
          data_tbl:"m_employee",
          field:"code",
          field2:"name",
          preview2:"Employee Name",
          search : $("#pop_search13").val()
      },
      function(r){
          $("#sr13").html(r);
          settings_checkby();
      }, "text");
  }

  function settings_checkby(){
      $("#item_list .cl").click(
        function(){
          $("#checkby").val($(this).children().eq(0).html());
          $("#checkby_des").val($(this).children().eq(1).html());
          $("#pop_close13").click();
      })
  }

  function load_data_supf1(){
      $.post("index.php/main/load_data/utility/f1_selection_list", {
          data_tbl:"m_supplier",
          field:"code",
          field2:"name",
          preview2:"Supplier Name",
          search : $("#pop_search4").val()
      },
      function(r){
          $("#sr4").html(r);
          settings_supf1();
      }, "text");
  }

  function settings_supf1(){
      $("#item_list .cl").click(
        function(){
          $("#supplier_id").val($(this).children().eq(0).html());
          $("#supplier").val($(this).children().eq(1).html());
          load_supplier_credit_period($(this).children().eq(0).html());
          $("#pop_close4").click();
      })
  }

  $("#btnDelete").click(function(){
    if($("#hid").val()!=0) {
      set_delete($("#hid").val());
    }
  });

  $("#inv_no").keyup(function(){
    this.value = this.value.replace(/[^0-9\.a-z,',A-Z]/g,'');
  });

  $("#inv_no").css("text-transform","uppercase");
  $("#inv_no").val().toUpperCase();


  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
    $("#2_"+get_id).focus();
  });

  $("#id").keyup(function(){
    this.value = this.value.replace(/[^0-9\.a-z,',A-Z]/g,'');
   });

  $(".price, .qty, .dis_pre, .foc").blur(function(){
    set_cid($(this).attr("id"));
    //discount();
    calculate_free_total();
    dis_prec();
    amount();
    gross_amount();
    discount_amount();
    //all_rate_amount();
    additional_amount();
    net_amount();
  });

  $(".dis").blur(function(){
    set_cid($(this).attr("id"));
    dis_prec();
    amount();
    gross_amount();
    discount_amount();
    //all_rate_amount();
    additional_amount();
    net_amount();
  });

  $(".rate").blur(function(){
    set_cid($(this).attr("id"));
    //rate_amount();
    additional_amount();
    net_amount();
  });

  $(".aa").blur(function(){
    set_cid($(this).attr("id"));
    rate_pre();
    additional_amount();
    net_amount();
  });


  $(".fo").keypress(function(e){
  	var y = $("#pono").val();
      set_cid($(this).attr("id"));

      if(e.keyCode==46){
        delete_free_items($("#0_"+scid).val());
        delete_main_free_items($("#0_"+scid).val());
        set_cid($(this).attr("id"));
        if($("#df_is_serial").val()=='1')
        {
          $("#all_serial_"+scid).val("");
        }
        $("#h_"+scid).val("");
        $("#0_"+scid).val("");
        $("#n_"+scid).val("");
        $("#1_"+scid).val("");
        $("#b1_"+scid).val("");
        $("#2_"+scid).val("");
        $("#3_"+scid).val("");
        $("#4_"+scid).val("");
        $("#ccc_"+scid).val("");
        $("#colc_"+scid).val("");
        $("#col_"+scid).val("");
        $("#pprice_"+scid).val("");
        $("#5_"+scid).val("");
        $("#6_"+scid).val("");
        $("#max_"+scid).val("");
        $("#min_"+scid).val("");
        $("#s3_"+scid).val("");
        $("#s4_"+scid).val("");
        $("#s5_"+scid).val("");
        $("#s6_"+scid).val("");
        $("#lpm_"+scid).val("");
        $("#spm_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#is_click_"+scid).val("");
        $("#t_"+scid).val("");
        $("#sub_"+scid).css("display","none");
        $("#btn_"+scid).css("display","none");
        $("#focb_"+scid).css("display","none");
        $("#focb_"+scid).attr("disabled",false);
        $("#sub_"+scid).removeAttr("data-is_click");
        $("#free_"+scid).attr("disabled",false);

        $("#0_"+scid).closest("tr").find("td").css('background-color', '#ffffff');
        $("#0_"+scid).closest("tr").find("input").css('background-color', '#ffffff');
        $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');

        $("#1_"+scid).closest("td").css('background-color','#f9f9ec');
        $("#1_"+scid).css('background-color','#f9f9ec');

        $("#b1_"+scid).closest("td").css('background-color','#f9f9ec');
        $("#b1_"+scid).css('background-color','#f9f9ec');

        $("#t_"+scid).closest("td").css('background-color','#f9f9ec');
        $("#t_"+scid).css('background-color','#f9f9ec');

        $("#n_"+scid).closest("td").css('background-color','#f9f9ec');
        $("#n_"+scid).css('background-color','#f9f9ec');

        $("#lpm_"+scid).css('background-color','#f9f9ec');
        $("#lpm_"+scid).closest("td").css('background-color','#f9f9ec');

        $("#spm_"+scid).css('background-color','#f9f9ec');
        $("#spm_"+scid).closest("td").css('background-color','#f9f9ec');

        discount();
        dis_prec();
        amount();
        gross_amount();
        discount_amount();
        all_rate_amount();
        additional_amount();
        net_amount();
      }


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


  $(".foo").keypress(function(e){
    if(e.keyCode==112){
        set_cid($(this).attr("id"));
        $("#serch_pop2").center();
        $("#blocker2").css("display", "block");
        setTimeout("select_search2()", 100);
    }
    if(e.keyCode==46){
       set_cid($(this).attr("id"));
      $("#00_"+scid).val("");
      $("#hh_"+scid).val("");
      $("#hhh_"+scid).val("");
      $("#nn_"+scid).val("");
      $("#11_"+scid).val("");
      $("#22_"+scid).val("");
      $("#cost_"+scid).attr("checked",false);
      $("#22_"+scid).blur();

    }
  });

  $("#tgrid").tableScroll({height:200, width:1170});
  $("#tgrid2").tableScroll({height:150,width:500});
  $("#tgrid1").tableScroll({height:150,width:600});

  $("#id,#sub_no").keyup(function(){
    this.value = this.value.replace(/\D/g,'');
  });

  $("#ref_no").keyup(function(){
    this.value = this.value.replace(/[^0-9a-zA-Z]/g,'');
  });

  $("#stores").change(function(){
    set_select("stores","store_no");
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

  load_items();
  load_items2();
  load_po_no();


  $("#pop_search2").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112)
      {
        load_items2();
      }
  });


  $("#pono").keypress(function(e){
    var p = $("#pono").val();
  if(e.keyCode == 13)
    {
      empty_grid();

      $.post("index.php/main/load_data/t_grn_sum/get_pono", {
        po_no:$("#pono").val(),
        type:$("#typess").val()
      }, function(r)
      {

        if(r.det==2){
          set_msg("No records");
        }else{

          for(var i=0; i<r.det.length;i++){
            $("#pono").val(p);
            $("#h_"+i).val(r.det[i].item_code);
            $("#0_"+i).val(r.det[i].item_code);
            $("#n_"+i).val(r.det[i].description);
            $("#1_"+i).val(r.det[i].model);
            $("#b1_"+i).val(r.det[i].balance);
            $("#4_"+i).val(r.det[i].cost);
            $("#ccc_"+i).val(r.det[i].cost);
            $("#max_"+i).val(r.det[i].max_price);
            $("#min_"+i).val(r.det[i].min_price);
            $("#colc_"+i).val(r.det[i].color_code);
            $("#col_"+i).val(r.det[i].color);

            var lpm= parseFloat(0);
            lpm = (parseFloat(r.det[i].min_price)-parseFloat(r.det[i].cost))/parseFloat(r.det[i].min_price)*100;
            $("#lpm_"+i).val(m_round(lpm)+"%");

            var spm= parseFloat(0);
            spm = (parseFloat(r.det[i].max_price)-parseFloat(r.det[i].cost))/parseFloat(r.det[i].max_price)*100;
            $("#spm_"+i).val(m_round(spm)+"%");

            check_is_serial_item2(r.det[i].item_code,i);
            check_is_sub_item2(r.det[i].item_code,i);
            is_sub_item(i);
            is_has_free(r.det[i].item_code,i);
          }

          $("#pono").attr("readonly","readonly");
          $("#supplier_id").val(r.sum[0].supplier);
          $("#supplier").val(r.sum[0].name);
        }
      settings();
      },
      "json");
    }
    if(e.keyCode==112){
     if($("#po_update").val()!="1"){
      $("#pop_search").val($("#pono").val());
      load_po_no();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("select_search()", 100);


      $("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112)
      {
        load_po_no();
      }
      });
    }
  }
  });


  $("#pop_search").gselect();
  $("#pop_search2").gselect();

  $(document).on("click",".approve",function(){
    var q="";
    $(".approve").each(function(e){
      if($('#app_' +e).is(":checked")){
        q=q+$("#sub_"+e).text()+"-"+$("#subqty_"+e).text()+",";
      }
    });
      $("#subcode_"+scid).val(q);
  });



$(document).on("click",".subs",function(){
      set_cid($(this).attr("id"));
      check_is_sub_item(scid);
      $("#is_click_"+scid).val("1");

  });

  $(".approve").blur(function(){
    //is_sub_item(scid);
  });

});


function is_sub_item(x){

  $.post("index.php/main/load_data/utility/is_sub_items_load", {
        code:$("#0_"+x).val(),
        hid:$("#hid").val(),
        type:'3'
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

function tot_qty(){
   var tot_qty = parseInt($("#qtyt_"+scid).val())+parseInt($("#3_"+scid).val());
    if(!isNaN(tot_qty)){
      //$("#2_"+scid).val(tot_qty);
    }
}

function select_search(){
  $("#pop_search").focus();
}

function select_search3(){
    $("#pop_search3").focus();
}

function calculate_last_price_margin(){
  var cost = parseFloat($("#4_"+scid).val()) ;
  var last = parseFloat($("#min_"+scid).val()) ;
  var lpm =  parseFloat(0);

  lpm = ((last-cost)/last)*100;

  $("#lpm_"+scid).val(m_round(lpm)+"%");

}

function calculate_free_total(){
  var foc_total=loop=0;
  $(".tf").each(function(){
    var gs=parseFloat($("#freeqty_"+loop).val() * $("#4_"+loop).val());
    if(!isNaN(gs)){
      foc_total=foc_total+gs;
    }
    loop++;
  });
   $("#freet").val(foc_total);
}

function calculate_sales_price_margin(){
  var cost = parseFloat($("#4_"+scid).val()) ;
  var max = parseFloat($("#max_"+scid).val()) ;
  var lpm =  parseFloat(0);

  spm = ((max-cost)/max)*100;

  $("#spm_"+scid).val(m_round(spm)+"%");

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

function load_items4(x){
    $.post("index.php/main/load_data/utility/sub_item_window", {
        search : x,
    }, function(r){
        $("#sr3").html(r);
        match_sub_item();
    }, "text");

}


// function emptyElement(element) {
//   if (element == null || element == 0 || element.toString().toLowerCase() == 'false' || element == '')
//     return false;
//     else return true;
//   }



function select_search2(){
  $("#pop_search2").focus();
}

function load_items(){
     $.post("index.php/main/load_data/t_grn_sum/item_list_all", {
        search : $("#pop_search").val(),
        id:$("#pono").val(),
        stores : false
    }, function(r){
        $("#sr").html(r);
        settings();
    }, "text");
}

function load_items2(){
  $.post("index.php/main/load_data/r_additional_items/item_list_all", {
    search : $("#pop_search2").val(),
    stores : false,
    type : "1"
  }, function(r){
    $("#sr2").html(r);
    settings2();
  }, "text");
}

function load_po_no(){
     $.post("index.php/main/load_data/t_grn_sum/load_po_nos", {
        search : $("#pop_search").val(),
        type: $("#typess").val(),
        sup : $("#supplier_id").val()
    }, function(r){
        $("#sr").html(r);
        settings_po();
    }, "text");
}

function settings(){
  $("#item_list .cl").click(function(){
    if($(this).children().eq(0).html() != "&nbsp;"){
      if(check_item_exist($(this).children().eq(0).html())){
        if($("#df_is_serial").val()=='1')
        {
          check_is_serial_item2($(this).children().eq(0).html(),scid);
        }
        check_is_sub_item2($(this).children().eq(0).html(),scid);

       		$("#h_"+scid).val($(this).children().eq(0).html());
         	$("#0_"+scid).val($(this).children().eq(0).html());
         	$("#n_"+scid).val($(this).children().eq(1).html());
         	$("#1_"+scid).val($(this).children().eq(2).html());
         	$("#4_"+scid).val($(this).children().eq(3).html());
          $("#ccc_"+scid).val($(this).children().eq(3).html());
          $("#max_"+scid).val($(this).children().eq(4).html());
          $("#min_"+scid).val($(this).children().eq(5).html());

        $("#2_"+scid).focus();
        $("#pop_close").click();
        //$("#pono").attr('readonly', true);
        $("#pono").addClass("hid_value");

      }
      else
      {
        set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
      }
    }
    else
    {
      $("#h_"+scid).val("");
      $("#0_"+scid).val("");
      $("#n_"+scid).val("");
      $("#1_"+scid).val("");
      $("#2_"+scid).val("");
      $("#3_"+scid).val("");
      $("#4_"+scid).val("");
      $("#5_"+scid).val("");
      $("#6_"+scid).val("");
      $("#t_"+scid).val("");
      $(".qty").blur();
      $("#pop_close").click();
    }
  });
}

function settings2(){
  $("#item_list2 .cl").click(function(){
    if($(this).children().eq(0).html() != "&nbsp;"){
      if(check_item_exist2($(this).children().eq(0).html())){
        $("#hh_"+scid).val($(this).children().eq(3).html());
        $("#00_"+scid).val($(this).children().eq(0).html());
        $("#nn_"+scid).val($(this).children().eq(1).html());
        $("#11_"+scid).val($(this).children().eq(2).html());
        $("#hhh_"+scid).val($(this).children().eq(0).html());
        if($(this).children().eq(4).html() == 1){
          $("#11_"+scid).autoNumeric({mDec:2});
        }
        else
        {
          $("#11_"+scid).autoNumeric({mDec:2});
        }
        // $("#1_"+scid).removeAttr("disabled");
        // $("#2_"+scid).removeAttr("disabled");
        // $("#3_"+scid).removeAttr("disabled");
        //$("#11_"+scid).focus();
        rate_amount();
        additional_amount();
        net_amount();
        $("#pop_close2").click();
        //$("#blocker2").css("display","none");

      }
      else
      {
       set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
      }
    }
    else
    {
      $("#hh_"+scid).val("");
      $("#00_"+scid).val("");
      $("#nn_"+scid).val("");
      $("#11_"+scid).val("");
      $("#22_"+scid).val("");
      $("#hhh_"+scid).val("");
      // $("#3_"+scid).val("");
      // $("#t_"+scid).html("&nbsp;");
      // $("#1_"+scid).attr("disabled", "disabled");
      // $("#2_"+scid).attr("disabled", "disabled");
      // $("#3_"+scid).attr("disabled", "disabled");
      rate_amount();
      additional_amount();
      net_amount();
      $("#pop_close2").click();
    }
  });
}

function settings_po(){
  $("#po_list .cl").click(function(e){
      $("#pono").val($(this).children().eq(0).html());
      $("#pop_close").click();
     //alert($(this).children().eq(0).html());
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

function check_item_exist2(id){
  var v = true;
  $(".ad").each(function(){
 //$("input[type='hidden']").each(function(){
    if($(this).val() == id){
      v = false;
    }
  });
  return v;
}

function check_item_exist3(id){
  var v = true;
  $(".fo").each(function(e){
    if($("#h_"+e).val() == id){
      v = false;
    }
  });
  return v;
}

function check_item_exist4(id){
  var v = true;
  $(".fr").each(function(e){
    if($("#fh_"+e).val() == id){
      v = false;
    }
  });
  return v;
}

function check_item_exist5(id){
  var v = true;
  $(".fo").each(function(e){
    if($("#h_"+e).val() == id){
      v = false;
    }
  });
  return v;
}

function set_cus_values(f){
  var v = f.val();
  v = v.split("|");
  if(v.length == 2){
    f.val(v[0]);
    $("#supplier").val(v[1]);
    load_supplier_credit_period(v[0]);
  }
}




function formatItems(row){
  return "<strong> " +row[0] + "</strong> | <strong> " +row[1] + "</strong>";
}

function formatItemsResult(row){
  return row[0]+"|"+row[1];
}


function load_supplier_credit_period(code){
    $.post("index.php/main/load_data/t_grn_sum/supplier_credit_period", {
        code:code
      },function(r){
          $("#credit_period").val(r);
      }, "text");
}


function save(){

	loding();
  $("#qno").val($("#id").val());
  $("#inv_date").val($("#date").val());
  $("#inv_nop").val($("#inv_no").val());
  $("#po_nop").val($("#pono").val());
  $("#po_dt").val($("#ddate").val());
  $("#credit_prd").val($("#credit_period").val());

  if($("#df_is_serial").val()=='1')
  {
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);
  }

  var frm = $('#form_');

  $.ajax({
	 type: frm.attr('method'),
	 url: frm.attr('action'),
	 data: frm.serialize(),
	 success: function (pid){

     if(pid == 0){

    }else if(pid == 2){
      set_msg("No permission to add data.");
    }else if(pid == 3){
      set_msg("No permission to edit data.");
    }else if(pid==1){
      loding();
      $("#btnSave").attr("disabled",true);
      if(confirm("Save Completed, Do You Want A print?")){
        if($("#is_prnt").val()==1){
            $("#print_pdf").submit();
        }
        reload_form();
      }else{
        location.href="";
      }
    }else{
      loding();
      set_msg(pid,"error");
    }
    }
  });
}

function reload_form(){
  setTimeout(function(){
    window.location = '';
  },50);
}

function set_delete(){

  if($("#df_is_serial").val()=='1'){
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);
  }

  var id = $("#hid").val();
  if(id != 0){
    if(confirm("Are you sure to delete this purchase ["+$("#id").val()+"]? ")){
      $.post("index.php/main/delete/t_grn_sum", {
        trans_no:id,
        type:$("#typess").val()
      },function(r){
          if(r != 1){
            set_msg(r);
          }else{
            delete_msg();
          }
      }, "text");
    }
  }else{
    set_msg("Please load record");
  }
}

function check_code(){
  loding();
  var code = $("#code").val();
  $.post("index.php/main/load_data/t_grn_sum/check_code", {
    code : code
  }, function(res){
    if(res == 1){
      if(confirm("This code ("+code+") already added. \n\n Do you need edit it?")){
        set_edit(code);
      }else{
        $("#code").val('');
		    $("#code").attr("readonly", false);
      }
    }
    loding();
  }, "text");
}

function validate(){
  var g = true;

  $(".balq").each(function(e){

    if($("#b1_"+e).val()!="" && parseFloat($("#b1_"+e).val()) < parseFloat($("#2_"+e).val()))
    {
      set_msg($("#b1_"+e).val() +"<"+  $("#2_"+e).val());
      set_msg("Quantity should be less than balance quantity","error");
      g=false;
    }
   });

  for(var i=0; i<25; i++){
    if($("#is_click_"+i).val()!=1 && $("#sub_"+i).data("is_click")==1){
      set_msg("Please check sub items in ("+$("#0_"+i).val()+")" ,"error");
      return false;
    }
  }

  if($("#supplier").val() === $("#supplier").attr('title') || $("#supplier").val() == "")
  {
    set_msg("Please Select Supplier");
    $("#supplier_id").focus();
    return false;
  }
  else if($("#inv_no").val() == "")
  {
    set_msg("Please Enter Invoice Number");
    $("#id").focus();
    return false;
  }
  else if($("#id").val() == "")
  {
    set_msg("Please Enter Number");
    $("#id").focus();
    return false;
  }
  else if($("#stores").val() == 0 )
  {
    set_msg("Please Select Store");
    $("#stores").focus();
    return false;
  }
  else if($("#checkby").val() == "" )
  {
    set_msg("Please fill check by");
    $("#checkby").focus();
    return false;
  }
  else if(g==false){
    return false;
  }else{
    return true;
  }
}


function discount(){
  var qty=parseFloat($("#3_"+scid).val());
  var price=parseFloat($("#4_"+scid).val());
  var dis_pre=parseFloat($("#5_"+scid).val());
  var discount="";

  if(!isNaN(qty)&& !isNaN(price) && !isNaN(dis_pre)){
    discount=(qty*price*dis_pre)/100;
    $("#6_"+scid).val(m_round(discount));
  }
  calculate_actual_cost();
}

function dis_prec(){
  if($("#dis_update").val()!="1"){

      var qty=parseFloat($("#2_"+scid).val());
      var price=parseFloat($("#4_"+scid).val());
      var discount=parseFloat($("#6_"+scid).val());
      var free_qty=parseFloat($("#freeqty_"+scid).val());
      var net_qty=qty-free_qty;
      var dis_pre="";

      if(!isNaN(net_qty)&& !isNaN(price) && !isNaN(discount)){
        dis_pre=(discount*100)/(net_qty*price);
        if(isNaN(dis_pre) || !isFinite(dis_pre)){
          $("#5_"+scid).val("");
        }else{
          $("#5_"+scid).val(m_round(dis_pre));
        }
      }
    }else{

      var qty=parseFloat($("#2_"+scid).val());
      var price=parseFloat($("#4_"+scid).val());
      var discount="";
      var free_qty=parseFloat($("#freeqty_"+scid).val());
      var net_qty=qty-free_qty;
      var dis_pre=parseFloat($("#5_"+scid).val());

      if(!isNaN(net_qty)&& !isNaN(price) && !isNaN(dis_pre)){
        discount=((net_qty*price)*dis_pre)/100;

        if(isNaN(discount) || !isFinite(discount)){
          $("#6_"+scid).val("");
        }else{
          $("#6_"+scid).val(m_round(discount));
        }
      }
    }
    calculate_actual_cost();
}

function amount(){
  var qty=parseFloat($("#2_"+scid).val());
  var price=parseFloat($("#4_"+scid).val());
  var discount=parseFloat($("#6_"+scid).val());
 // var free_qty=parseFloat($("#freeqty_"+scid).val());
  //var net_qty=qty-free_qty;
  var amount="";
  //alert(net_qty);

  if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount)){
    dis_pre=(qty*price)-discount;
    $("#t_"+scid).val(m_round(dis_pre));
  }else if(!isNaN(qty)&& !isNaN(price)){
    dis_pre=(qty*price);
    $("#t_"+scid).val(m_round(dis_pre));
  }
}


function gross_amount2(){
  var t=tt=0;
   $(".tf").each(function(e){
    var q = parseInt($("#3_"+e).val());
    var p = parseInt($("#ccc_"+e).val());
    if(!isNaN(p)){
      t = t + parseFloat(q*p);
    }
  });
  $(".ad_cst").each(function(x){
    if($("#hh_"+x).val()=="1"){
      if($("#cost_"+x).is(":checked")){
        tt+=parseFloat($("#22_"+x).val());
      }
    }
  });
  $("#gross_amount").val(m_round(t+tt));
  $("#gross_amount222").val(m_round(t));
}


function gross_amount(){
  var gross=loop=0;
  $(".tf").each(function(){
    var gs=parseFloat($("#t_"+loop).val());
    if(!isNaN(gs)){
      gross=gross+gs;
    }
    loop++;
  });
  $("#gross_amount").val(m_round(gross));
}

function discount_amount(){
  var dis=loop=0;
  $(".dis").each(function(){
    var gs=parseFloat($("#6_"+loop).val());
    if(!isNaN(gs)){
      dis=dis+gs;
    }
    loop++;
  });
  $("#dis_amount").val(m_round(dis));
}

function rate_amount(){
  var rate_pre=parseFloat($("#11_"+scid).val());
  var gross_amount=parseFloat($("#gross_amount").val());
  var rate_amount="";
  if(!isNaN(rate_pre)&& !isNaN(gross_amount)){
    rate_amount=(gross_amount*rate_pre)/100;
    $("#22_"+scid).val(m_round(rate_amount));
  }
}


function rate_pre(){
  var gross_amount=parseFloat($("#gross_amount").val());
  var rate=parseFloat($("#22_"+scid).val());
  var rate_amount_pre="";

  if(!isNaN(rate)&& !isNaN(gross_amount)){
    rate_amount_pre=(rate*100)/gross_amount;
    $("#11_"+scid).val(m_round(rate_amount_pre));
  }
}


function all_rate_amount(){
  var gross_amount=parseFloat($("#gross_amount").val());
  var additional=loop=0;

  $(".rate").each(function(){
    var rate=parseFloat($("#11_"+loop).val());
    var rate_amount=0;
    if(!isNaN(rate) && !isNaN(rate_amount) ){
      rate_amount=(gross_amount*rate)/100;
      $("#22_"+loop).val(m_round(rate_amount));
    }
    loop++;
  });
}

function additional_amount(){
  var additional=loop=t=0;
  $(".tf").each(function(){
    var add=parseFloat($("#22_"+loop).val());
    var f= $("#hh_"+loop).val();

    if(!isNaN(add)){
      if(f==1){
        additional=additional+add;

      }
      else
      {
        additional=additional-add;

      }
    }

    if($("#hh_"+loop).val()=="1"){
      if($("#cost_"+loop).is(":checked")){
        t+=parseFloat($("#22_"+loop).val());
      }
    }



    loop++;
  });
  $("#total2").val(m_round(additional-t));
  $("#total22").val(m_round(additional));
}

function net_amount(){
  var discount=parseFloat($("#dis_amount").val());
  var additional=parseFloat($("#total2").val());
  var gross_amount=parseFloat($("#gross_amount").val());
  var net_amount=0;
  var free=parseFloat($("#freet").val());
  if(!isNaN(additional)&& !isNaN(gross_amount)){
    net_amount=((gross_amount+additional))-free;
    $("#net_amount").val(m_round(net_amount));
  }
  else
  {
    $("#net_amount").val(net_amount);
  }
}

function net_amount2(){
  var additional=parseFloat($("#total22").val());
  var gross_amount=parseFloat($("#gross_amount222").val());
  var net_amount=0;

  if(!isNaN(additional)&& !isNaN(gross_amount)){
    net_amount=gross_amount+additional;
    $("#net_amount").val(m_round(net_amount));
  }
  else
  {
    $("#net_amount").val(net_amount);
  }
}

function loadPO(id){
  //empty_grid();
  loding();
  $.post("index.php/main/load_data/t_grn_sum/get_purchase_order", {
    id:id
  }, function(r){
	  $("#sr").html(r);
    settings();
    loding();
  }, "text");
}

function load_purchase(){
 $.post("index.php/main/load_data/t_grn_sum/load_purchase_stores/", {
  }, function(r){
     //alert(r);
    if(r!=2){
      $("#stores").val(r[0].def_purchase_store_code);
      $("#store_no").val(r[0].description);
    }

  }, "json");
}

function load_data(id){
  var g=[];
  empty_grid();
  loding();
  $.post("index.php/main/get_data/t_grn_sum/", {
    id: id
  }, function(r){
    if(r=="2"){
      set_msg("No records");
    }
    else
    {
      $("#hid").val(id);
      $("#supplier_id").val(r.sum[0].scode);
      $("#supplier").val(r.sum[0].name);
      $("#stores").val(r.sum[0].stcode);
      set_select("stores","store_no");
      $("#pono").val(r.sum[0].po_no);
      $("#credit_period").val(r.sum[0].credit_period);
      $("#pono2").val(r.sum[0].po_no2);
      $("#pono3").val(r.sum[0].po_no3);
      $("#date").val(r.sum[0].ddate);
      $("#inv_no").val(r.sum[0].inv_no);
      $("#ref_no").val(r.sum[0].ref_no);
      $("#ddate").val(r.sum[0].inv_date);
      $("#gross_amount").val(r.sum[0].gross_amount);
      //$("#gross_amount222").val(r.sum[0].gross_amount);
      $("#total2").val(r.sum[0].additional);
      //$("#total22").val(r.sum[0].additional);
      $("#net_amount").val(r.sum[0].net_amount);
      $("#id").attr("readonly","readonly")
      $("#qno").val(id);
      $("#inv_date").val(r.sum[0].inv_date);
      $("#inv_nop").val(r.sum[0].inv_no);
      $("#po_nop").val(r.sum[0].po_no);
      $("#po_dt").val(r.sum[0].inv_date);
      $("#credit_prd").val(r.sum[0].credit_period);
      $("#note").val(r.sum[0].memo);
      $("#memo").val(r.sum[0].memo);
      $("#checkby").val(r.sum[0].check_by);
      $("#checkby_des").val(r.sum[0].check_by_des);
      $("#vehicleNo").val(r.sum[0].vehicle_no);
      $("#del_officer").val(r.sum[0].del_officer);
      $("#typess").val(r.sum[0].type);
      $("#btnApprove").attr("disabled",false);
      if(r.sum[0].is_cancel==1){
        $("#btnDelete").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
        $("#mframe").css("background-image", "url('img/cancel.png')");
        $("#btnApprove").attr("disabled",true);
      }

      if(r.sum[0].is_approve==1 && r.sum[0].is_cancel!=1){
        $("#btnDelete").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
        $("#mframe").css("background-image", "url('img/approved1.png')");
        $("#btnApprove").attr("disabled",true);
      }
      if(r.sum[0].po_active==1){
        $("#is_po").attr("checked","checked");
      }

      for(var i=0; i<r.free.length;i++){
        $("#f0_"+i).val(r.free[i].item_code);
        $("#fh_"+i).val(r.free[i].item_code);
        $("#f1_"+i).val(r.free[i].description);
        $("#f2_"+i).val(r.free[i].model);
        $("#f3_"+i).val(r.free[i].receivable_qty);
        $("#f4_"+i).val(r.free[i].received_qty);
        $("#f5_"+i).val(r.free[i].purchase_price);
        $("#f6_"+i).val(r.free[i].total);
      }
      for(var i=0; i<r.det.length;i++){
        $("#h_"+i).val(r.det[i].icode);
        $("#0_"+i).val(r.det[i].icode);
        $("#n_"+i).val(r.det[i].idesc);
        $("#1_"+i).val(r.det[i].model);
        $("#2_"+i).val(r.det[i].qty);
        $("#3_"+i).val(r.det[i].foc);
        $("#4_"+i).val(r.det[i].price);
        $("#ccc_"+i).val(r.det[i].price);
        $("#pprice_"+i).val(r.det[i].cost_price);
        $("#5_"+i).val(r.det[i].discountp);
        $("#6_"+i).val(r.det[i].discount);
        $("#t_"+i).html(r.det[i].amount);
        $("#max_"+i).val(r.det[i].max_price);
        $("#min_"+i).val(r.det[i].min_price);
        $("#s3_"+i).val(r.det[i].sale_price_3);
        $("#s4_"+i).val(r.det[i].sale_price_4);
        $("#s5_"+i).val(r.det[i].sale_price_5);
        $("#s6_"+i).val(r.det[i].sale_price_6);
        $("#po_"+i).val(r.det[i].po_pur);
        $("#colc_"+i).val(r.det[i].color);
        $("#col_"+i).val(r.det[i].description);
        if(r.sum[0].po_no=="" && r.sum[0].po_active!="1" ){
          $("#btnedit_"+i).css("display", "block");
        }
        is_color_item(r.det[i].icode,i);

        var lpm= parseFloat(0);
        lpm = (parseFloat(r.det[i].min_price)-parseFloat(r.det[i].price))/parseFloat(r.det[i].min_price)*100;
        $("#lpm_"+i).val(m_round(lpm)+"%");

        var spm= parseFloat(0);
        spm = (parseFloat(r.det[i].max_price)-parseFloat(r.det[i].price))/parseFloat(r.det[i].max_price)*100;
        $("#spm_"+i).val(m_round(spm)+"%");


        scid=i;
        amount();


        $("#itemcode_"+i).val(r.det[i].icode);
        $("#2_"+i).val(r.det[i].qty);

        if($("#df_is_serial").val()=='1')
        {
          check_is_serial_item2(r.det[i].icode,i);
          $("#numofserial_"+i).val(r.det[i].qty);
          for(var a=0;a<r.serial.length;a++){
            if(r.det[i].icode==r.serial[a].item){
              g.push(r.serial[a].serial_no+"-"+r.serial[a].other_no1+"-"+r.serial[a].other_no2);
              $("#all_serial_"+i).val(g);
            }
          }
          g=[];
        }
        check_is_sub_item2(r.det[i].icode,i);
        is_sub_item(i);

        $("#qtyt_"+i).val(parseFloat(r.det[i].qty)-parseFloat(r.det[i].foc))
        $("#freet").val(parseFloat(r.det[i].price)*parseFloat(r.det[i].foc))

        is_has_free(r.det[i].icode,i);
        $("#freeqty_"+i).val(r.det[i].foc);

        if(r.det[i].is_free==1){

          $("#0_"+i).closest("tr").find("td").css('background-color', 'rgb(224, 228, 146)');
          $("#0_"+i).closest("tr").find("input").removeClass('g_col_fixed');
          $("#0_"+i).closest("tr").find("input").css('background-color', 'rgb(224, 228, 146)');
          $("#0_"+i).closest("tr").find("input[type='button']").css('background-color','');
          $("#free_"+i).attr("checked",true);
          $("#isfree_"+i).val("1");
        }

      }
      //gross_amount();


      if(r.add!=2){
       for(var i=0; i<r.add.length;i++){
          $("#hhh_"+i).val(r.add[i].type);
          $("#00_"+i).val(r.add[i].type);
          $("#nn_"+i).val(r.add[i].description);
          $("#11_"+i).val(r.add[i].rate_p);
          $("#22_"+i).val(r.add[i].amount);
          get_sales_type(i);

          if(r.add[i].add_to_cost=="1"){
            $("#cost_"+i).attr("checked",true);
          }
        }
      }

     // gross_amount2();
     // net_amount2();
      calculate_free_total();
      discount_amount();
      input_active();
    }
  loding();
  }, "json");
}


function get_sales_type(i){
  $.post("index.php/main/load_data/r_additional_items/get_type",{
    id:$("#00_"+i).val()
  },function(res){
    $("#hh_"+i).val(res);

    },"text");

}


function empty_grid(){
  for(var i=0; i<25; i++){
    delete_free_items($("#0_"+i).val());
    $("#h_"+i).val("");
    $("#0_"+i).val("");
    $("#n_"+i).val("");
    $("#1_"+i).val("");
    $("#b1_"+i).val("");
    $("#2_"+i).val("");
    $("#3_"+i).val("");
    $("#4_"+i).val("");
    $("#pprice_"+i).val("");
    $("#ccc_"+i).val("");
    $("#5_"+i).val("");
    $("#6_"+i).val("");
    $("#colc_"+i).val("");
    $("#col_"+i).val("");
    $("#max_"+i).val("");
    $("#min_"+i).val("");
    $("#subcode_"+i).val("");
    $("#is_click_"+i).val("");
    $("#t_"+i).val("");
    $("#subcode_"+i).val("");
    $("#is_click_"+i).val("");
    $("#hh_"+i).val("");
    $("#hhh_"+i).val("");
    $("#00_"+i).val("");
    $("#nn_"+i).val("");
    $("#11_"+i).val("");
    $("#22_"+i).val("");
    $("#lpm_"+i).val("");
    $("#spm_"+i).val("");
    $("#sub_"+i).removeAttr("data-is_click");
    $("#btnedit_"+i).css("display","none");
    $("#colb_"+i).css("display","none");
    $("#fmain_"+i).val("");
    $("#f0_"+i).val("");
    $("#fh_"+i).val("");
    $("#f1_"+i).val("");
    $("#f2_"+i).val("");
    $("#f3_"+i).val("");
    $("#f4_"+i).val("");
    $("#f5_"+i).val("");
    $("#f6_"+i).val("");

  $("#0_"+scid).closest("tr").find("td").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');

  $("#1_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#1_"+scid).css('background-color','#f9f9ec');

  $("#b1_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#b1_"+scid).css('background-color','#f9f9ec');

  $("#t_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#t_"+scid).css('background-color','#f9f9ec');

  $("#n_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#n_"+scid).css('background-color','#f9f9ec');

  $("#lpm_"+scid).css('background-color','#f9f9ec');
  $("#lpm_"+scid).closest("td").css('background-color','#f9f9ec');

  $("#spm_"+scid).css('background-color','#f9f9ec');
  $("#spm_"+scid).closest("td").css('background-color','#f9f9ec');


  }
  $(".subs").css("display","none");
  $(".quns").css("display","none");
}


function is_has_free(item,i){
  $.post("index.php/main/load_data/t_grn_sum/has_free_items",{
    code:item,
    date:$("#date").val()
  },function(res){
    if(res==1){
      $("#focb_"+i).css("display","block");
    }
  },"text");
}


function view_free_items(item,qty){
  $.post("index.php/main/load_data/t_grn_sum/views_free_items",{
    code:item,
    date:$("#date").val(),
    qty:qty
  },function(res){
    $("#sr14").html("");
    $("#sr14").html(res.tbl);
    settings_free(res.count);

  },"json");
}


function settings_free(count_rows){

  $(document).on("click", ".item_list22 ",function(){
    $("#focb_"+scid).attr("disabled",true);
  for(var e=0; e<count_rows; e++){
    if(check_item_exist4($("#fitem_"+e).text())){
    var item=$("#fitem_"+e).text();
    var name=$("#fdes_"+e).text();
    var model=$("#fmodel_"+e).text();
    var price=$("#fprice_"+e).text();
    var rcv_qty=$("#ifoc_"+e).text();
    var rcyed_qty=$("#ifoc_"+e).text();
    var last_price=$("#lp_"+e).text();
    var max_price=$("#mxp_"+e).text();
    var main_item = $("#main_"+e).text();

    var total=parseFloat(rcv_qty) * parseFloat(price);

    for(var i=0; i<25 ;i++){
      if($("#f0_"+i).val()==""){
        $("#f0_"+i).val(item);
        $("#fh_"+i).val(item);
        //alert(main_item);
        $("#fmain_"+i).val(main_item);
        $("#f1_"+i).val(name);
        $("#f2_"+i).val(model);
        $("#f3_"+i).val(rcv_qty);
        $("#f4_"+i).val(rcyed_qty);
        $("#f5_"+i).val(m_round(price));
        $("#f6_"+i).val(m_round(total));
        break;
      }
    }
    }else{
      /*for(var a=0; a<25 ;a++){
        if($("#f0_"+a).val()==$("#fitem_"+e).text()){
          var q = parseInt($("#f3_"+a).val()) + parseInt($("#fqty_"+e).text());
          $("#f3_"+a).val(q);
        }
      } */
      //set_msg("Item "+$("#fitem_"+e).text()+" is already added.");
    }
    if(check_item_exist5($("#fitem_"+e).text())){
    for(var i=0; i<25 ;i++){
      if($("#0_"+i).val()==""){
        if($("#df_is_serial").val()=='1'){
          check_is_serial_item2(item,i);
        }
        $("#mainitem_"+i).val(main_item);
        $("#0_"+i).val(item);
        $("#h_"+i).val(item);
        $("#n_"+i).val(name);
        $("#1_"+i).val(model);
        $("#2_"+i).val(rcv_qty);
        $("#4_"+i).val(price);
        $("#min_"+i).val(last_price);
        $("#max_"+i).val(max_price);
        $("#t_"+i).val(m_round(total));
        $("#isfree_"+i).val(1);

        $("#3_"+i).val(parseInt(rcyed_qty));
        $("#freeqty_"+i).val(rcyed_qty);
        var lpm= parseFloat(0);
        lpm = (parseFloat(last_price)-parseFloat(price))/parseFloat(last_price)*100;
        $("#lpm_"+i).val(m_round(lpm)+"%");

        var spm= parseFloat(0);
        spm = (parseFloat(max_price)-parseFloat(price))/parseFloat(max_price)*100;
        $("#spm_"+i).val(m_round(spm)+"%");

        $("#2_"+i).blur();

        $("#0_"+scid).closest("tr").find("td").css('background-color', 'rgb(224, 228, 146)');
        $("#0_"+scid).closest("tr").find("input").removeClass('g_col_fixed');
        $("#0_"+scid).closest("tr").find("input").css('background-color', 'rgb(224, 228, 146)');
        $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');
        $("#free_"+scid).attr("disabled",true);
        check_is_sub_item2(item,i);
        net_amount();
        break;
      }
    }
    }else{
      for(var a=0; a<25 ;a++){
        if($("#0_"+a).val()!=""){
          if($("#0_"+a).val()==$("#fitem_"+e).text()){
            if(rcyed_qty !== undefined){
              var q = parseInt($("#2_"+a).val()) + parseInt(rcyed_qty);
              $("#2_"+a).val(q);
              $("#3_"+a).val(rcyed_qty);
              $("#freeqty_"+a).val(rcyed_qty);
              $("#2_"+a).blur();
              //alert(parseInt($("#2_"+i).val()) + parseInt(rcyed_qty));
            }
          }
        }
      }
      //set_msg("Item "+$("#fitem_"+e).text()+" is already added.");
    }
    }
    $("#pop_close14").click();
});

}


function delete_main_free_items(item){
  for(var x=0; x<25; x++){
    if(item!=""){
      if($("#mainitem_"+x).val()==item){
        $("#h_"+x).val("");
        $("#0_"+x).val("");
        $("#n_"+x).val("");
        $("#1_"+x).val("");
        $("#b1_"+x).val("");
        $("#2_"+x).val("");
        $("#3_"+x).val("");
        $("#4_"+x).val("");
        $("#ccc_"+x).val("");
        $("#5_"+x).val("");
        $("#6_"+x).val("");
        $("#max_"+x).val("");
        $("#min_"+x).val("");
        $("#subcode_"+x).val("");
        $("#is_click_"+x).val("");
        $("#t_"+x).val("");
        $("#subcode_"+x).val("");
        $("#is_click_"+x).val("");
        $("#lpm_"+x).val("");
        $("#spm_"+x).val("");
        $("#colc_"+x).val("");
        $("#col_"+x).val("");
        $("#sub_"+x).removeAttr("data-is_click");
        $("#btnedit_"+x).css("display","none");
        $("#colb_"+x).css("display","none");

        $("#0_"+x).closest("tr").find("td").css('background-color', '#ffffff');
        $("#0_"+x).closest("tr").find("input").css('background-color', '#ffffff');
        $("#0_"+x).closest("tr").find("input[type='button']").css('background-color','');

        $("#1_"+x).closest("td").css('background-color','#f9f9ec');
        $("#1_"+x).css('background-color','#f9f9ec');

        $("#b1_"+x).closest("td").css('background-color','#f9f9ec');
        $("#b1_"+x).css('background-color','#f9f9ec');

        $("#t_"+x).closest("td").css('background-color','#f9f9ec');
        $("#t_"+x).css('background-color','#f9f9ec');

        $("#n_"+x).closest("td").css('background-color','#f9f9ec');
        $("#n_"+x).css('background-color','#f9f9ec');

        $("#lpm_"+x).css('background-color','#f9f9ec');
        $("#lpm_"+x).closest("td").css('background-color','#f9f9ec');

        $("#spm_"+x).css('background-color','#f9f9ec');
        $("#spm_"+x).closest("td").css('background-color','#f9f9ec');
        $("#isfree_"+x).val("0");
      }
    }
  }
}



function delete_free_items(item){
  for(var x=0; x<25; x++){
    if($("#fmain_"+x).val()==item){
      $("#fmain_"+x).val("");
      $("#f0_"+x).val("");
      $("#fh_"+x).val("");
      $("#f1_"+x).val("");
      $("#f2_"+x).val("");
      $("#f3_"+x).val("");
      $("#f4_"+x).val("");
      $("#f5_"+x).val("");
      $("#f6_"+x).val("");
    }
  }
}


function mark_as_free(i,item){

  $("#0_"+scid).closest("tr").find("td").css('background-color', 'rgb(224, 228, 146)');
  $("#0_"+scid).closest("tr").find("input").removeClass('g_col_fixed');
  $("#0_"+scid).closest("tr").find("input").css('background-color', 'rgb(224, 228, 146)');
  $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');

  $("#isfree_"+i).val("1");
  $("#freeqty_"+i).val($("#2_"+i).val());
  $("#3_"+i).val($("#2_"+i).val());
  add_item_to_free_grid(item,$("#2_"+i).val());
  calculate_free_total();
  net_amount();
}


function uncheck_free(scid,item){

  $("#0_"+scid).closest("tr").find("td").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');

  $("#1_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#1_"+scid).css('background-color','#f9f9ec');

  $("#b1_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#b1_"+scid).css('background-color','#f9f9ec');

  $("#t_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#t_"+scid).css('background-color','#f9f9ec');

  $("#n_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#n_"+scid).css('background-color','#f9f9ec');

  $("#lpm_"+scid).css('background-color','#f9f9ec');
  $("#lpm_"+scid).closest("td").css('background-color','#f9f9ec');

  $("#spm_"+scid).css('background-color','#f9f9ec');
  $("#spm_"+scid).closest("td").css('background-color','#f9f9ec');

  $("#isfree_"+scid).val("0");
  $("#freeqty_"+scid).val("0");
  $("#3_"+scid).val("0");
  delete_free_items(item);
  calculate_free_total();
  net_amount();
}


function add_item_to_free_grid(item,qty){
  $.post("index.php/main/load_data/t_grn_sum/add_free_item", {
    item:item
  }, function(r){
    if(r!=2){
      for(var i=0; i<25 ;i++){
        if($("#f0_"+i).val()==""){
          $("#f0_"+i).val(r[0].code);
          $("#fh_"+i).val(r[0].code);
          $("#fmain_"+i).val(r[0].code);
          $("#f1_"+i).val(r[0].description);
          $("#f2_"+i).val(r[0].nmodel);
          $("#f3_"+i).val(qty);
          $("#f4_"+i).val(qty);
          $("#f5_"+i).val(m_round(r[0].purchase_price));
          $("#f6_"+i).val(m_round(parseFloat(r[0].purchase_price) * parseInt(qty)));
          break;
        }
      }
    }
  }, "json");
}


function calculate_actual_cost(){
  var d_price=parseFloat($("#4_"+scid).val());
  var discount = parseFloat($("#6_"+scid).val());
  var qty = parseFloat($("#2_"+scid).val());
  var act_cost=parseFloat(0);

  if(isNaN(d_price)){d_price=0}
  if(isNaN(discount)){discount=0}
  if(isNaN(qty)){qty=0}
  act_cost = d_price - (discount/qty);
  if(isNaN(act_cost)){act_cost=0}
  if($("#cost_cal").is(":checked")){
    if($("#0_"+scid).val()!=""){
      $("#pprice_"+scid).val(m_round(act_cost));
    }
  }else{
    if($("#0_"+scid).val()!=""){
      $("#pprice_"+scid).val(m_round(d_price));
    }
  }
}


function view_colors(){
 $.post("index.php/main/load_data/utility/f1_selection_list", {
  data_tbl:"r_color",
  field:"code",
  field2:"description",
  preview2:"Color",
  search : $("#pop_search").val()
}, function(r){
  $("#sr").html(r);
  settings_color();
}, "text");
}

function settings_color(){
  $("#item_list .cl").click(function(){
      $("#colc_"+scid).val($(this).children().eq(0).html());
      $("#col_"+scid).val($(this).children().eq(1).html());
      $("#pop_close").click();

  })
}

function is_color_item(i_code,scid){
  $.post("index.php/main/load_data/utility/is_color_item",{
    code:i_code
  },function(res){
    $("#colb_"+scid).css("display","none");
    if(res==1){
      $("#colb_"+scid).css("display","block");
    }
  },'text');
}

function set_default_color(){
  $.post("index.php/main/load_data/utility/default_color", {
  }, function(r){
    if(r!=""){
      //if(check_item_exist10(r,$("#0_"+scid).val())){
       $("#colc_"+scid).val(r);
    /* }else{
       set_msg($("#0_"+scid).val()+" "+$(this).children().eq(1).html()+" is already added This Item.");
        $("#h_"+scid).val("");
        $("#0_"+scid).val("");
        $("#n_"+scid).val("");
        $("#1_"+scid).val("");
        $("#b1_"+scid).val("");
        $("#2_"+scid).val("");
        $("#3_"+scid).val("");
        $("#4_"+scid).val("");
        $("#ccc_"+scid).val("");
        $("#5_"+scid).val("");
        $("#6_"+scid).val("");
        $("#max_"+scid).val("");
        $("#min_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#is_click_"+scid).val("");
        $("#t_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#is_click_"+scid).val("");
        $("#lpm_"+scid).val("");
        $("#spm_"+scid).val("");
        $("#colb_"+scid).css("display","none");
     }*/
   }else{
    set_msg('Please Set Default Color First');
    $("#h_"+scid).val("");
        $("#0_"+scid).val("");
        $("#n_"+scid).val("");
        $("#1_"+scid).val("");
        $("#b1_"+scid).val("");
        $("#2_"+scid).val("");
        $("#3_"+scid).val("");
        $("#4_"+scid).val("");
        $("#ccc_"+scid).val("");
        $("#5_"+scid).val("");
        $("#6_"+scid).val("");
        $("#max_"+scid).val("");
        $("#min_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#is_click_"+scid).val("");
        $("#t_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#is_click_"+scid).val("");
        $("#lpm_"+scid).val("");
        $("#spm_"+scid).val("");
        $("#colb_"+scid).css("display","none");

  }
}, "json");
}

function check_item_exist10(color,item){
  var v = true;
  $("input[type='hidden']").each(function(e){
    if($("#0_"+e).val()==item && $("#colc_"+e).val() == color){
      v = false;
    }
  });
  return v;
}
