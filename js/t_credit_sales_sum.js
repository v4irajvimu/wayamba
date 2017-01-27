  var result;
  var sub_items=[];

  $(function(){

    $(".freitm").click(function(){
      var Thid=$(this).attr('id').split("_");

      if ($("#h_"+Thid[1]).val()!="0" && $("#h_"+Thid[1]).val()!=""){
        if($(this).is(':checked')){
          mark_as_free(Thid[1]);
          $("#f_"+Thid[1]).val("1");
          $("#4_"+Thid[1]).val($("#5_"+Thid[1]).val());
          calculate_free_total();
          dis_prec();
          amount();
          gross_amount();
          gross_amount1();
          discount_amount();
          privilege_calculation();
          all_rate_amount();

          net_amount();

        }
        else
        {
          uncheck_free(Thid[1]);
          $("#f_"+Thid[1]).val("0");
          calculate_free_total();      
          dis_prec();
          amount();
          gross_amount();
          gross_amount1();
          discount_amount();
          privilege_calculation();
          all_rate_amount();

          net_amount();
        }

      }else{
        $("#free_"+Thid[1]).attr('checked', false);
      }


    });


    $(".qty,#pop_close3").blur(function(){

    });


    $(".qunsb").css("display","none");
    $(".quns").css("display","none");
    $(".subs").css("display","none");
    $("#btnSavee").css("display","none");
    $("#btnSave").attr("disabled","disabled");
    $("#approvebtn").attr("disabled","disabled");

    $("#cutomer_create").click(function(){
      window.open($("#base_url").val()+"?action=m_customer","_blank");      
    });

    $("#cic").prop("checked", true); 

    $("#is_main").click(function(){
      if($("#is_main").is(':checked')){
        $(".bill_to_cus").css("display","block");
        $(".main_cus").css("display","none");
        $("#customer").css("display","none");
      }else{
        $(".main_cus").css("display","block");
        $(".bill_to_cus").css("display","none");
        $("#customer").css("display","block");
      }
    });

    $(".price").keypress(function(e){
      if(e.keyCode==112){
        set_cid($(this).attr("id"));
        load_price_range($("#0_"+scid).val(),$("#1_"+scid).val());
      }
    });


    $('input:radio').click(function(){
      if($(this).val()=='1'){
        $("#dis_type").val('1');
      }else if($(this).val()=='2'){
        $("#dis_type").val('2');
      }else{
        $("#dis_type").val('3');
      }
    });
    $(".qty").keyup(function() {
      var n_qty = parseFloat($("#5_"+scid).val());
      var d_qty = parseFloat($("#55_"+scid).val());

      if(isNaN(n_qty)){
        n_qty=0
      }if(isNaN(d_qty)){
        d_qty=0;
      }
      if(d_qty>n_qty){
        set_msg("Delvery quantity should be less than or equal to qty");
        $("#55_"+scid).val("0");
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


    $("#dealer_id").keypress(function(e){
      if(e.keyCode == 112){
        $("#pop_search14").val($("#dealer_id").val());
        load_dealer();
        $("#serch_pop14").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search14').focus()", 100);
      }
      $("#pop_search14").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
         load_dealer();
       }
     }); 
      if(e.keyCode == 46){
        $("#dealer_id").val("");
      }
    });



    $("#approvebtn").click(function(){
      $("#approve_h").val("1");
      save();
    });

    $("input[type='text']").blur(function(){
      var net = parseFloat($("#net").val());
      $("#net_hid").val(net);
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

    $("#b_foc").click(function(){
      if($("#stores").val()!="0"){
        $("#pop_search").val();
        load_data10();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("select_search()", 100);
      }else{
        set_msg("Please select store")
      }
    });

    $(".price , .dis").blur(function(){
      set_cid($(this).attr("id"));
      check_min_price(scid);
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

    $("#customer").keypress(function(e){
      if(e.keyCode == 112){
        $("#pop_search2").val($("#customer").val());
        load_data9();
        $("#serch_pop2").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search2').focus()", 100);
      }

      $("#pop_search2").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
         load_data9();
       }
     }); 

      if(e.keyCode == 46){
        $("#customer").val("");
        $("#customer_id").val("");
        $("#customer_id").addClass("hid_value");
        $("#customer_id").removeClass("input_txt");
        $("#customer_id").css("background-color","");
        $("#address").val("");
      }
    });

    $("#sales_rep").keypress(function(e){
      if(e.keyCode == 112){
        $("#pop_search6").val($("#sales_rep").val());
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


    $("#quotation").keypress(function(e){ 
      if($("#customer").val() != ""){ 
        if(e.keyCode==112){
          $("#pop_search4").val($("#quotation").val());
          load_data2();
          $("#serch_pop4").center();
          $("#blocker").css("display", "block");
          setTimeout("select_search4()", 100);                
        }

        $("#pop_search4").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
           load_data2();
         }
       });
            // $("#pop_search").keyup(function(e){

            //     load_data2();

            // });
  }
  else{

    set_msg("Please Select Customer","error");
  }

});

    $("#sales_category").change(function(){
      $("#sales_category1").val($("#sales_category").val());
      if($("#sales_category").val()==0){
        $("#sub_no").val("0");
        set_msg("Please select sales category");
      }else{

        sales_category_max();            
      }
    }); 

    $(".price").keyup(function(){
      set_cid($(this).attr("id"));
      $("#free_price_"+scid).val($(this).val());
    });

    $(".subs").click(function(){
      set_cid($(this).attr("id"));
      check_is_sub_item(scid); 
    });

    $("#sales_rep_create").click(function(){
      window.open($("#base_url").val()+"?action=m_employee","_blank");  
    });

    $("#btnDelete").click(function(){
      set_delete();
    });

    $("#showPayments").click(function(){
      if($("#hid").val()=="0" || $("#hid").val()==""){
        $("#credit").val($("#net").val());
      }
      
      payment_opt('t_credit_sales_sum',$("#net").val());

      if($("#hid").val()!="0"){
        $("#approvebtn").attr("disabled",false);
      }

      if($("#installment").val()=="" && $("#credit").val()==""){
        if($("#hid").val()=="0"){
          $("#credit").val($("#net").val());          
        }
      }else if($("#credit").val()==""){
        $("#installment").val($("#net").val());  
      }else if($("#installment").val()==""){
        $("#credit").val($("#net").val());
      }
      $("#save_status").val("0");
    });

    $("#payment_option").attr("checked", "checked");
    
    $("#free_fix,#pst").blur(function(){
      var get_code=$(this).val();
      $(this).val(get_code.toUpperCase());
    });

    $("#btnClearr").click(function(){
      location.reload();
    });

    $(".qunsb").click(function(){
      set_cid($(this).attr("id"));
      check_is_batch_item(scid);  
    });


    $( "#tabs" ).tabs();

    $("#btnExit1").click(function(){
      document.getElementById('light').style.display='none';
      document.getElementById('fade').style.display='none';  
      $("#5_"+get_id).focus();
    });
  });


  $(document).ready(function(){

    $("#btnResett").click(function(){
      location.href="?action=t_credit_sales_sum";
    });

    $("#id,#sub_no").keyup(function(){
      this.value = this.value.replace(/\D/g,'');
    });

    $("#ref_no").keyup(function(){
      this.value = this.value.replace(/[^0-9a-zA-Z]/g,'');
    });

    $("#tgrid").tableScroll({height:200});
    $("#tgrid2").tableScroll({height:100});

    $(".fo").focus(function(){
      if($("#store_id").val()=="" || $("#stores").val()==0){
        set_msg("Please Select Store");
        $("#0_"+scid).val("");
        $("#stores").focus(); 
      }
    });


    $(".fo").keypress(function(e){  
      set_cid($(this).attr("id"));

      if(e.keyCode==112)
      {
        $("#pop_search").val($("#0_"+scid).val());
        load_items();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("select_search()", 100);
      }

      $("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items();
        }
      });


      
      if(e.keyCode==13)
      {
        $.post("index.php/main/load_data/t_credit_sales_sum/get_item", {
          code:$("#0_"+scid).val(),
          group_sale:$("#groups").val(),
          stores:$("#stores").val()
        }, function(res){
          if(res.a!=2)
          {
            $("#0_"+scid).val(res.a[0].code);
            if(check_item_exist($("#0_"+scid).val()))
            {

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
              check_is_batch_item(scid);
            }
            else
            {
              set_msg("Item "+$("#0_"+scid).val()+" is already added.");
            }
          }else{
            set_msg($("#0_"+scid).val()+" Item not available in store","error");
            $("#0_"+scid).val("");
          }
        }, "json");

}

if(e.keyCode==46){
  if($("#df_is_serial").val()=='1')
  {
              //deleteSerial(scid);
              $("#all_serial_"+scid).val("");
            }
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
            $("#cost_"+scid).val("");

            $("#f_"+scid).val("");

            $("#free_"+scid).attr('checked', false);

            $("#bal_free_"+scid).val("");
            $("#bal_tot_"+scid).val("");
            $("#free_price_"+scid).val("");
            $("#issue_qty_"+scid).val("");
            $("#subcode_"+scid).val("");
            $("#bqty"+scid).val("");
            $("#item_min_price_"+scid).val("");
            $("#subcode_"+scid).removeAttr("data-is_click");
            $("#5_"+scid).attr("readonly", false);

            $("#btn_"+scid).css("display","none");
            $("#btnb_"+scid).css("display","none");
            $("#sub_"+scid).css("display","none");

            uncheck_free(scid);
            // $("#n_"+scid).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
            // $("#2_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
            // $("#1_"+scid).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
            // $("#1_"+scid).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
            // $("#3_"+scid).closest("td").attr('style', 'width: 58px; ');
            // $("#6_"+scid).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
            // $("#8_"+scid).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');
            // $("#0_"+scid).closest("tr").attr('style', 'width:100%; background-color: #ffffff !important;');

            // $("#n_"+scid).closest("td").attr('style', 'background-color: #f9f9ec !important');
            // $("#2_"+scid).attr('style', 'background-color: #f9f9ec !important');
            // $("#1_"+scid).attr('style', 'background-color: #f9f9ec !important');
            // $("#3_"+scid).closest("td").attr('style', 'background-color: #f9f9ec !important');
            // $("#8_"+scid).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

            // $("#0_"+scid).closest("tr").attr('style', 'background-color: #ffffff !important;');


                //discount();
                dis_prec();
                amount();
                gross_amount();
                gross_amount1();
                gross_amount1();
                discount_amount();
                privilege_calculation();
                all_rate_amount();

                net_amount();

              }


            });


  $(".foo").focus(function(){
    set_cid($(this).attr("id"));
    $("#serch_pop7").center();
    $("#blocker2").css("display", "block");
    setTimeout("select_search7()", 100);
  });


  $(".price, .qty, .dis_pre, .foc").blur(function(){
   set_cid($(this).attr("id"));

   if($("#1_"+scid).val()!="" && $("#0_"+scid).val()!=""){
      check_item_in_grid($("#0_"+scid).val(),$("#1_"+scid).val(),scid);
   }

   var foc=parseFloat($("#4_"+scid).val());
   if(isNaN(foc)){foc=0;}

   if(foc==0){
        // discount();
        dis_prec();
        amount();
        gross_amount();
        gross_amount1();
        discount_amount();
        privilege_calculation();
        
        //all_rate_amount();
        net_amount();
      }else{

        dis_prec();
        amount();
        gross_amount();
        gross_amount1();
        discount_amount();
        privilege_calculation();
        
        //all_rate_amount();
        net_amount();
      }


    });

  
  $(".qty").blur(function(){
    set_cid($(this).attr("id"));
    check_batch_qty(scid);
  });

  $(".dis").blur(function(){
    set_cid($(this).attr("id"));
    dis_prec();
    amount();
    gross_amount();
    gross_amount1();
    discount_amount();
    privilege_calculation();

        //all_rate_amount();
        net_amount();
      });

  $(".rate").blur(function(){
    set_cid($(this).attr("id"));
        //rate_amount();
        
        net_amount();

      });

  $(".aa").blur(function(){
    set_cid($(this).attr("id"));
    rate_pre();

    net_amount();
  });

  $("#pop_close3").click(function(){
    check_items();
  });




  $("#pop_search3").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { 
      load_items3($("#0_"+scid).val());
    }
  });

  $("#pop_search3").gselect();
  load_items();
  load_items2();

  $("#pop_search7").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items2();
    }
  });    


  $("#customer").change(function(){
    set_select('customer','customer_id');
  });


  $("#stores").change(function(){
    set_select('stores','store_id');
    empty_grid();

    $.post("index.php/main/load_data/validation/check_is_group_store", {
      store_code:$("#stores").val()
    }, function(res){
        //  alert(res);
        if(res==1){
          if($("#dealer_id").val()==""){
            set_msg("Please select group number","error");
            $("#stores").val("0");
            $("#store_id").val("");
          }
        }else{
              /*if($("#dealer_id").val()!=""){
                set_msg("Please select group store");

                $("#stores").val("0");
                $("#store_id").val("");
              }*/
            }


          },"text");
  });

  $("#groups").change(function(){

    $("#stores").val("0");
    $("#store_id").val("");

        // if($(this).val()==0 && $("#stores").val()!=0){
        //   $.post("index.php/main/load_data/validation/check_is_group_store", {
        //     store_code:$("#stores").val()
        //     }, function(res){
        //     if(res==0){
        //         set_msg("Please select group store","error");
        //         $("#stores").val("0");
        //         $("#store_id").val("");
        //     }
        //   },"text");
        // }

        //  if($(this).val()==0){
        //     $("#stores").val("0");
        //     $("#store_id").val("");
        //  }
      });


/*      $("#customer").autocomplete('index.php/main/load_data/m_customer/auto_com', {
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
          });*/

  $("#customer").blur(function(){
    set_cus_values($(this));
  });

/*        $("#sales_rep").autocomplete('index.php/main/load_data/m_employee/auto_com', {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
        });
    
        $("#sales_rep").keypress(function(e){
          if(e.keyCode == 13){
            set_cus_values2($(this));
          }
        });*/

  $("#sales_rep").blur(function(){
    set_cus_values2($(this));
  });

  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
      load_payment_option_data($(this).val(),"5");
      $("#btnSave").attr("disabled","disabled");

    }
  });

  $("#pop_search").gselect();
  $("#pop_search2").gselect();
  $("#pop_search3").gselect();

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


  $(".fo").blur(function(){
   var id=$(this).attr("id").split("_")[1];
   if($(this).val()=="" || $(this).val()=="0"){
   }else if($(this).val()!=$("#itemcode_"+id).val()){
    if($("#df_is_serial").val()=='1')
    {
      deleteSerial(id);
    }
  }
});


  $("#gen").click(function(){
    var free_fix=$("#free_fix").val();
    var post_fix=$("#pst").val();
    var start_no=parseInt($("#abc").val());
    var quantity=parseInt($("#quantity").val());

    for(x=0;x<quantity;x++){
      start_no=start_no+1;
      var code_gen=free_fix+start_no.toString()+post_fix;
      $("#srl_"+x).val(code_gen);
    }
  });


  $(".qty").blur(function(){
    item_free(scid);
  });

  $(".qty, .foc").blur(function(){
    balance_item_free(scid);
    dis_prec();
           // check_qty(scid);
         });

  $(".qty").blur(function(){
    is_sub_item(scid);
  });

  $("#sales_category").change(function() {
   get_group();
 });

  default_option();
});

  function load_price_range(item,batch){
    if(item!="" && batch!=""){
      load_prices($("#0_"+scid).val(),$("#1_"+scid).val(),$("#s3").val(),$("#s4").val(),$("#s5").val(),$("#s6").val(),$("#s3_des").val(),$("#s4_des").val(),$("#s5_des").val(),$("#s6_des").val());
      $("#serch_pop11").center();
      $("#blocker").css("display", "block");
    }else{
      set_msg("Please select item code and batch no");
    }
  }

  function load_prices(item,batch,s3,s4,s5,s6,s3des,s4des,s5des,s6des){
    $.post("index.php/main/load_data/t_credit_sales_sum/sales_prices", {
      item:item,
      batch:batch,
      s3:s3,
      s4:s4,
      s5:s5,
      s6:s6,
      s3des:s3des,
      s4des:s4des,
      s5des:s5des,
      s6des:s6des
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

  function default_option(){

    $.post("index.php/main/load_data/utility/default_option", {
    }, function(r){
      if(r.use_sales_category!="0"){
        $(".ct").css("display","none");

        var sale_cat=r.def_sales_category;
        $("#sales_category1").val(sale_cat);
      }
      if(r.use_sales_group!="0"){
       $(".gr").css("display","none");
       $("#dealer_id").val(r.def_sales_group);
     }
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

  function check_items(){
    var check_det="";
    var cont=0;
    $(".chk_class").each(function(e){
      if($("#free_chk_"+e).is(':checked')){
        check_det+=$("#item_"+e).html()+"|"+$("#des_"+e).html()+"|"+$("#model_"+e).html()+"|"+$("#max_"+e).html()+"|"+$("#itemqty_"+e).html()+"|"+$("#qty_"+e).html()+",";   
        cont++;

      }
    });
    var fr_item=($("#fritems").html());

    get_chk_itm_det(check_det,fr_item,cont); 

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
                    $("#4_"+i).val(qty);
                    $("#free_price_"+i).val(price);
                    $("#5_"+i).val(Math.floor(issue_qty));
                    $("#issue_qty_"+i).val(Math.floor(issue_qty));
                    $("#f_"+i).val(sign);
                    $("#bal_free_"+i).val(Math.floor(issue_qty));
                    $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
                    $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                    $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                    $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                    $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
                    $("#8_"+i).val(parseFloat($("#5_"+i).val()*$("#3_"+i).val()));
                    $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                    $("#free_"+i).attr("disabled","disabled");

                      /*  $("#5_"+i).focus();
                      $("#3_"+i).blur();*/
                      check_is_batch_item2(get,i);
                      check_is_sub_item2(get,i);
                      check_is_batch_item_free(i);
                      check_is_batch_item(i);
                      dis_prec();
                      amount();
                      gross_amount();
                      gross_amount1();
                      discount_amount();
                      calculate_free_total();
                      net_amount();

                      break; 
                    }
                  }          
                  $("#11_"+scid).focus();
                  all_rate_amount();
                  calculate_free_total();
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
                    $("#issue_qty_"+scid).val(issue_qty);
                  }   
                }        
              }
            }else{

            }
          }else{
            set_msg("Maximum Free Items Already Added");
          }
        }




/*function load_data9(){
    $.post("index.php/main/load_data/t_cash_sales_sum/customer_list", {
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings9();            
    }, "text");
}*/

function check_min_price(scid){
  var p = parseFloat($("#3_"+scid).val());
  var discount = parseFloat($("#7_"+scid).val());
  var qty=parseFloat($("#5_"+scid).val());
  var price = p-(discount/qty);
  var min = parseFloat($("#item_min_price_"+scid).val());
  if(price<min){ 

   set_msg("Price couldn't  Be lower than ("+m_round(min)+")");
   $("#3_"+scid).focus();
 }
}



function load_data9(){
  $.post("index.php/main/load_data/utility/f1_selection_list_customer", {
    data_tbl:"m_customer",
    field:"code",
    field2:"name",
    field3:"nic",
    field4:"tp",
    field_address:"field_address",
    hid_field:"customer_status",
    add_query:"AND is_customer = '1'",
    preview1:"Customer ID",
    preview2:"Customer Name",
    preview3:"Customer NIC",
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html("");
    $("#sr2").html(r);
    settings9();            
  }, "text");
}

function load_data8(){
  $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
    filter_emp_cat:"salesman",
    search : $("#pop_search6").val() 
  }, function(r){
    $("#sr6").html(r);
    settings8();            
  }, "text");
}

function settings9(){
  $("#item_list .cl").click(function(){        
    $("#customer").val($(this).children().eq(0).html());
    $("#customer_id").val($(this).children().eq(1).html());
    $("#address").val($(this).children().eq(4).html());
    $("#balance").val($(this).children().find('input').eq(1).val());
    var main_color_code=$(this).children().eq(3).find('input').val();
    get_cus_color(main_color_code);
    $("#pop_close2").click();                
  })    
}

function settings8(){
  $("#item_list .cl").click(function(){        
    $("#sales_rep").val($(this).children().eq(0).html());
    $("#sales_rep2").val($(this).children().eq(1).html());
    $("#pop_close6").click();                
  })    
}


function sales_category_max(){
  $.post("index.php/main/load_data/utility/get_max_sales_category", {
    nno:"sub_no",
    table:"t_credit_sales_sum",
    category:$("#sales_category").val(),
    hid:$("#hid").val()
  }, function(r){
    $("#sub_no").val(r);          
  },"text");
}


function is_sub_item(x){
  sub_items=[];
  $("#subcode_"+x).val("");
  $.post("index.php/main/load_data/utility/is_sub_items", {
    code:$("#0_"+x).val(),
    qty:$("#5_"+x).val(),
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
    grid_qty:$("#5_"+x).val(),
    batch:$("#1_"+x).val(),
    hid:$("#hid").val(),
    trans_type:"5",
    store:$("#stores").val()
  }, function(res){ 
    if(res!=2){
      sub_items.push(res.sub[0].sub_item+"-"+res.sub[0].qty);
      $("#subcode_"+x).val(sub_items);         
    }else{
      set_msg("Not enough quantity in this sub item ("+items+")","error");
      $("#subcode_"+x).val("");
          //$("#5_"+x).val(0);
        }
      },"json");
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

function item_free_delete(no){
 if(isNaN(parseInt($("#4_"+no).val()))){
  var qty=parseInt($("#5_"+no).val());
}else{
  var qty=parseInt($("#5_"+no).val())-parseInt($("#4_"+no).val());
}
var item=$("#0_"+no).val();

$.post("index.php/main/load_data/t_credit_sales_sum/item_free_delete",{
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
          $("#t_"+i).html("&nbsp;");
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
          $("#subcode_"+i).removeAttr("data-is_click");
          $("#5_"+i).attr("readonly", false);

          $("#h_"+no).val("");
          $("#0_"+no).val("");
          $("#n_"+no).val("");
          $("#t_"+no).html("&nbsp;");
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
          $("#subcode_"+no).removeAttr("data-is_click");
          $("#5_"+no).attr("readonly", false);


          uncheck_free(i);
                            // $("#n_"+i).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
                            // $("#2_"+i).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            // $("#1_"+i).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
                            // $("#1_"+i).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
                            // $("#3_"+i).closest("td").attr('style', 'width: 58px;');
                            // $("#6_"+i).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            // $("#8_"+i).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

                            // $("#0_"+i).closest("tr").attr('style', 'background-color: #ffffff !important;');

                            // $("#n_"+no).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
                            // $("#2_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            // $("#1_"+no).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
                            // $("#1_"+no).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
                            // $("#3_"+no).closest("td").attr('style', 'width: 58px;');
                            // $("#6_"+no).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            // $("#8_"+no).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

                            // $("#0_"+no).closest("tr").attr('style', 'background-color: #ffffff !important;');



                            // $("#n_"+i).closest("td").attr('style', 'background-color: #f9f9ec !important');
                            // $("#2_"+i).attr('style', 'background-color: #f9f9ec !important');
                            // $("#1_"+i).attr('style', 'background-color: #f9f9ec !important');
                            // $("#3_"+i).closest("td").attr('style', 'background-color: #f9f9ec !important');
                            // $("#8_"+i).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

                            // $("#0_"+i).closest("tr").attr('style', 'background-color: #ffffff !important;');

                            // $("#n_"+no).closest("td").attr('style', 'background-color: #f9f9ec !important');
                            // $("#2_"+no).attr('style', 'background-color: #f9f9ec !important');
                            // $("#1_"+no).attr('style', 'background-color: #f9f9ec !important');
                            // $("#3_"+no).closest("td").attr('style', 'background-color: #f9f9ec !important');
                            // $("#8_"+no).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

                            // $("#0_"+no).closest("tr").attr('style', 'background-color: #ffffff !important;');



                            $("#btn_"+i).css("display","none"); 
                            $("#btnb_"+i).css("display","none");
                            $("#sub_"+i).css("display","none");

                            $("#btn_"+no).css("display","none"); 
                            $("#btnb_"+no).css("display","none");
                            $("#sub_"+no).css("display","none");

                            //discount();
                            dis_prec();
                            amount();
                            gross_amount();
                            gross_amount1();
                            discount_amount();
                            privilege_calculation();
                            all_rate_amount();
                            
                            net_amount();

                          }
                        }
                      } 

                    }
                  }, "json");
}

function load_items5(x,y){
  if(isNaN(parseInt($("#4_"+y).val()))){
    var qty=parseInt($("#5_"+y).val());
  }else{
    var qty=parseInt($("#5_"+y).val())-parseInt($("#4_"+y).val());
  }
  var item=$("#0_"+y).val();
  $.post("index.php/main/load_data/t_credit_sales_sum/item_free_list",{
    quantity:qty,
    item:item,
    date:$("#date").val()
  },function(r){   
    if(r!=2){ 
      $("#sr3").html(r);
      /*settings6();*/
      $("#5_"+y).attr("readonly","readonly");
    }
  }, "text");
}

function load_data2(){

  $.post("index.php/main/load_data/utility/f1_selection_list", {

    data_tbl:"t_quotation_sum",
    field:"nno",
    field2:"cus_id",
    preview2:"Customer ID",
    add_query:"AND cus_id = " + "'" + $("#customer").val() + "'",
    search : $("#pop_search4").val() 
  }, function(r){

    $("#sr4").html(r);
    settings10();

  }, "text");
}

/*function settings6(){
  if(isNaN(parseInt($("#4_"+scid).val()))){
    var qty=parseInt($("#5_"+scid).val());
  }else{
    var qty=parseInt($("#5_"+scid).val())-parseInt($("#4_"+scid).val());
  }

    if($("#4_"+scid).val() != ""){
        $("#bal_free_"+scid).val($("#4_"+scid).val());
        $("#issue_qty_"+scid).val($("#4_"+scid).val());
    }

     var free_qty = "";

$("#free_item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
          free_qty=parseInt($(this).children().eq(4).html());
            if(check_item_exist2($(this).children().eq(0).html())){

                 var get=$(this).children().eq(0).html();
                 var name=$(this).children().eq(1).html();
                 var modal=$(this).children().eq(2).html();
                 var price=$(this).children().eq(3).html();
                 // free_qty=parseInt($(this).children().eq(4).html());
                 var sign=$(this).children().eq(5).html();

                 var issue_qty = qty/free_qty;



                  for(var i=0; i<25 ;i++){
                    if($("#0_"+i).val()==get)
                      {
                        return false;
                      }
                    else if($("#0_"+i).val()=="")
                      {
                        if($("#df_is_serial").val()=='1')
                        {
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
                        $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                        $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                        $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');

                        $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                        $("#5_"+i).focus();
                        $("#3_"+i).blur();
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
                    if($("#0_"+a).val()==$(this).children().eq(0).html())
                      {
                        $("#5_"+a).val(Math.floor(ff));
                      }
                  }     
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#h_"+scid).val("");
            $("#0_"+scid).val("");
            $("#n_"+scid).val("");
            $("#1_"+scid).val(""); 
            $("#t_"+scid).val(""); 
           
            all_rate_amount();
            net_amount();
            
            $("#pop_close2").click();
        }
    });
}*/

function check_qty(scid){

  var ss = 1;
  var foc = $("#4_"+scid).val();

  var qty = parseInt($("#5_"+scid).val());
  var issue_qtys = parseInt($("#issue_qty_"+scid).val());
  var item = $("#0_"+scid).val();
  var focs = parseInt($("#4_"+scid).val());


  if(foc==""){
    if(qty>issue_qtys){
      set_msg("this item ("+item+") quantity should be less than "+issue_qtys,"error");
      $("#5_"+scid).val(issue_qtys);
      return false;
    }

  }else{
    if(focs>issue_qtys){
      set_msg("this item ("+item+") FOC quantity should be less than "+issue_qtys,"error");
      $("#4_"+scid).val(issue_qtys);
      return false;
    }
  }

  return true;
}

function item_free(no){

 if(isNaN(parseInt($("#4_"+no).val())))
 {
  var qty=parseInt($("#5_"+no).val());
}
else
{
  var qty=parseInt($("#5_"+no).val())-parseInt($("#4_"+no).val());
}


var item=$("#0_"+no).val();

$.post("index.php/main/load_data/t_credit_sales_sum/item_free",{
  quantity:qty,
  item:item,
  date:$("#date").val()
},function(r){
  if(r!='2')
  {
    for(i=0; i<r.a.length; i++)
    {
      if(r.a[i].code == item)
      {

        var free_qty=parseInt(r.a[i].qty)
        var issue_qty = qty/free_qty;

        $("#5_"+no).val(Math.floor(issue_qty)+qty);
        $("#4_"+no).val(Math.floor(issue_qty));
      }
    }


    $("#serch_pop3").center();
    $("#blocker3").css("display", "block");
    setTimeout("select_search3()", 100);
    load_items5($("#0_"+scid).val(),no);
    check_items();
    gross_amount();
    gross_amount1();
  }

}, "json");
}


function check_is_batch_item_free(scid){
  var store=$("#stores").val();
  $.post("index.php/main/load_data/t_credit_sales_sum/is_batch_item",{
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
           // $("#5_"+scid).val(res.split("-")[1]);
           $("#bqty_"+scid).val(res.split("-")[1]);
           $("#1_"+scid).attr("readonly","readonly");
         }
       },'text');
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


function check_is_batch_item(scid){
  var store=$("#stores").val();
  $.post("index.php/main/load_data/t_credit_sales_sum/is_batch_item",{
    code:$("#0_"+scid).val(),
    store:store
  },function(res){

   if(res==1){
    $("#serch_pop3").center();
    $("#blocker3").css("display", "block");
    setTimeout("select_search3()", 100);
    load_items3($("#0_"+scid).val());
  } else if(res=='0'){
    $("#1_"+scid).val("0");
    $("#1_"+scid).attr("readonly","readonly");
  } else {
    $("#1_"+scid).val(res.split("-")[0]);
         // $("#5_"+scid).val(res.split("-")[1]);
         $("#bqty_"+scid).val(res.split("-")[1]);
         $("#1_"+scid).attr("readonly","readonly");
       }
     },'text');
}

function check_is_batch_item2(x,scid){
        // set_cid($(this).attr("id"));
        var store=$("#stores").val();
        $.post("index.php/main/load_data/t_credit_sales_sum/is_batch_item",{
          code:x,
          store:store
        },function(res){
          $("#btnb_"+scid).css("display","none");
          if(res==1){
            $("#btnb_"+scid).css("display","block");
          }
        },'text');
      }


      function select_search3(){
        $("#pop_search3").focus();
      }


      function load_items3(x){
        $.post("index.php/main/load_data/t_credit_sales_sum/batch_item", {
          search : x,
          stores : $("#stores").val()
        }, function(r){
          $("#sr3").html(r);
          settings3();
        }, "text");
      }

      function load_items4(x,batch){
        $.post("index.php/main/load_data/utility/sub_item", {
          search : x,
          batch:batch
        }, function(r){
          $("#sr3").html(r); 
        }, "text");
      }



      function settings3(){
        $("#batch_item_list .cl").click(function(){
          if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist3($(this).children().eq(0).html())){
              $("#1_"+scid).val($(this).children().eq(0).html());
                //$("#5_"+scid).val($(this).children().eq(1).html());
                $("#bqty_"+scid).val($(this).children().eq(1).html());
                if(pr_type=="1"){          //  none price
                  $("#3_"+scid).val();    
                  $("#free_price_"+scid).val();   
                }else if(pr_type=="2"){    //  cost price
                  $("#3_"+scid).val($(this).children().eq(4).html());
                  $("#free_price_"+scid).val($(this).children().eq(4).html());
                }else if(pr_type=="3"){    //  min price
                  $("#3_"+scid).val($(this).children().eq(3).html());
                  $("#free_price_"+scid).val($(this).children().eq(3).html());
                }else if(pr_type=="4"){   //  max price
                  $("#3_"+scid).val($(this).children().eq(2).html());    
                  $("#free_price_"+scid).val($(this).children().eq(2).html());    
                }else if(pr_type=="5"){   //  sale Price 3
                  $("#3_"+scid).val($(this).children().eq(6).html());    
                  $("#free_price_"+scid).val($(this).children().eq(6).html());    
                }else if(pr_type=="6"){  //  sale Price 4
                  $("#3_"+scid).val($(this).children().eq(7).html());    
                  $("#free_price_"+scid).val($(this).children().eq(7).html());    
                }else if(pr_type=="7"){                     //  sale Price 5
                  $("#3_"+scid).val($(this).children().eq(8).html());    
                  $("#free_price_"+scid).val($(this).children().eq(8).html());    
                }else {                     //  sale Price 6
                  $("#3_"+scid).val($(this).children().eq(9).html());    
                  $("#free_price_"+scid).val($(this).children().eq(9).html());    
                }                  
                $("#1_"+scid).attr("readonly","readonly");

                $("#5_"+scid).focus();

                //discount();
                dis_prec();
                amount();
                gross_amount();
                gross_amount1();
                discount_amount();
                all_rate_amount();
                
                net_amount();
                $("#pop_close3").click();
                check_items();
              }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
              }
            }else{



              $("#1_"+scid).val("");
              $("#5_"+scid).val("");
              $("#3_"+scid).val("");
                //discount();
                dis_prec();
                amount();
                gross_amount();
                gross_amount1();
                discount_amount();
                privilege_calculation();
                all_rate_amount();
                
                net_amount();
                $("#pop_close3").click();
                check_items();
              }
            });
}

function settings10(){
  $("#item_list .cl").click(function(){


    $("#quotation").val($(this).children().eq(0).html());
    $("#pop_close4").click();

  })


}



function check_item_exist3(id){
  var v = true;
  return v;
}

function set_cus_values2(f){
  var v = f.val();
  v = v.split("-");
  if(v.length == 2){
    f.val(v[0]);
    $("#sales_rep2").val(v[1]);

  }
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
     $("#balance").val(rs.acc); 
     input_active();
   },"json");


    $.post("index.php/main/load_data/t_credit_sales_sum/load_crdt_period",
    {
      code:cus,
    },function(rs){
     $("#credit_period").val(rs); 
   },"json");
  }
}


function save(){
  for(var i=0; i<25; i++){
    if($("#f_"+i).val()==1 && $("#0_"+i).val()!=""){
      is_sub_item(i);
    }
  }
  var a =0;
  var net=0; 
  $(".tt").each(function(){    
    var d= parseFloat($("#tt_"+a).val());
    var f= $("#hh_"+a).val();
    if(f==1){
      if(isNaN(d)){d=0;}
      net=net+d;
    }else{
      if(isNaN(d)){d=0;}
      net=net-d; 
    }
    a++;
  });

  $("#additional_amount").val(net);

  if($("#df_is_serial").val()=='1')
  {
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);    
  }

  $('#form_').attr('action',$('#form_id').val()+"t_credit_sales_sum");

  var frm = $('#form_');

  $("#sales_type").val($("#type").val());
  $("#qno").val($("#id").val());
  $("#cus_id").val($("#customer").val());
  $("#salesp_id").val($("#sales_rep").val());
  $("#dt").val($("#date").val());

    // var confirmation=0;
    // for(x=0;x<25;x++){
    //     if($("#0_"+x).val()!=""){
    //         if($("#3_"+x).val()<$("#item_min_price_"+x).val()){
    //           confirmation=1;
    //         }
    //     }
    // }

    // var xyz=0;
    // if(confirmation==1){
    //     var r = confirm("For Approval");
    //     if(r == true) {
    //        xyz = 1;
    //        $("#approve_status").val("0");
    //     } else {
    //        xyz = 2;
    //        $("#approve_status").val("1");
    //     } 
    // }

    // if(xyz==2){
    //     return false;
    // }



    loding();
    $.ajax({
      type: frm.attr('method'),
      url: frm.attr('action'),
      data: frm.serialize(),
      success: function (pid){

       if(pid ==0){
        set_msg("Transaction is not completed");
                  //location.href="";
                }else if(pid == 2){
                  set_msg("No permission to add data.");
                }else if(pid == 3){
                  set_msg("No permission to edit data.");
                }else if(pid==1){
                  loding();
                  $("#btnSave").attr("disabled",true);
                  $("#showPayments").attr("disabled",true);
                  //$("#btnSavee").css("display","inline");
                  save_status=0;
                  $("#save_status").val("0");

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
       //loding();         
     }
   });

 // }
}


function reload_form(){
  setTimeout(function(){
    location.href = '';
  },50); 
}


function check_code(){
  loding();
  var code = $("#code").val();
  $.post("index.php/main/load_data/t_credit_sales_sum/check_code", {
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

 if($("#sales_category").val()=="0" && $("#sales_category1").val()=="0"){
   set_msg("Please Select Category","error");
   $("#sales_category").focus();
   return false;
 }


 for(var t=0; t<25; t++){
  if($("#subcode_"+t).data("is_click")==1 && $("#subcode_"+t).val()==""){
    set_msg("Not enough sub items in ("+$("#0_"+t).val()+")" ,"error");
    return false;
  }

      // if($("#cost_"+t).val() < $("#7_"+t).val()){
      // set_msg("Please Check the discount" ,"error");
      // return false;
      // }
    }
    var v = false;
    $("input[type='hidden']").each(function(){
      if($(this).val() != "" && $(this).val() != 0){
        v = true;
      }
    });

       /*for(var f=0; f<25; f++){
        return check_qty(f);
      }*/

      for(var i=0; i<25; i++){
        if($("#sub_"+i).data("is_click")==1 && ($("#subcode_").val()!=0 || $("#subcode_").val()!="")){
          set_msg("Please check sub items in ("+$("#0_"+i).val()+")" ,"error");
          g=false;
          break;
        } 
      }

      if($("#id").val() == ""){
        set_msg("Please Enter No");
        $("#id").focus();
        return false;
      }
      else if($("#customer_id").val()=="" || $("#customer_id").attr("title")==$("#customer_id").val()){
       set_msg("Please Enter Customer");
       $("#customer_id").focus();
       return false;
     }

     else if($("#type").val()==0){
       set_msg("Please Select Type");
       $("#type").focus();
       return false;
     }


     else if($("#date").val()==""){
      set_msg("Please Select Date");
      $("#date").focus();
      return false;
    }

    else if(v == false){
      set_msg("Please use minimum one item.");
      return false;
    }


    else if($("#store_id").val()=="" || $("#stores").val()==0){
      set_msg("Please Select Store");
      $("#stores").focus();
      return false;
    }

    else if($("#sales_rep2").val()=="" || $("#sales_rep").val()==0){
      set_msg("Please Enter Sales Rep");
      $("#sales_rep").focus();
      return false;
    }

        // else if($("#net").val()=="" || $("#net").val()==0){

        //     return false;
        // }
        else if($("#sales_category").val()==0){

          set_msg("Please Select Category");
          $("#sales_category").focus();

          return false;

        }else if($("#load_opt").val()==0 && $("#payment_option").is(':checked')){ 

         if($("#type").val()==4){
          payment_opt('t_credit_sales_sum',$("#net").val());
          return false; 
        }else if($("#type").val()==5){
          payment_opt('t_credit_sales_sum',$("#net").val());
          return false;
        } 


      }else{
        return true;
      }  

    }


    
    function set_delete(){
      var id = $("#hid").val();
      if(id != 0){
        if(confirm("Are you sure to delete this credit sale ["+$("#hid").val()+"]? ")){
          $.post("index.php/main/delete/t_credit_sales_sum", {
            trans_no:id,
          },function(r){
            if(r != 1){
              set_msg(r);
            }else{
              delete_msg();
              $("#btnReset").click();
            }
          }, "text");
        }
      }else{
        set_msg("Please load record");
      }
    }


    
    function set_edit(code){
      loding();
      $.post("index.php/main/get_data/t_credit_sales_sum", {
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
        
        loding(); input_active();
      }, "json");
    }



    function select_search(){
      $("#pop_search").focus();

    }


    function select_search2(){
      $("#pop_search2").focus();

    }

    function load_items(){
     $.post("index.php/main/load_data/t_credit_sales_sum/item_list_all", {
      search : $("#pop_search").val(),
      stores : $("#stores").val(),
      dealer : $("#dealer_id").val()
    }, function(r){
      $("#sr").html(r);
      settings();
      price_type();
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

   function price_type(){
     $.post("index.php/main/load_data/utility/price_type", {
     }, function(r){
      pr_type=r;
    }, "text");
   }

   function settings(){
    $("#item_list .cl").click(function(){
      if($(this).children().eq(0).html() != "&nbsp;"){
        //if(check_item_exist($(this).children().eq(0).html())){
          if($("#df_is_serial").val()=='1')
          {
            check_is_serial_item2($(this).children().eq(0).html(),scid);
          }
          check_is_batch_item2($(this).children().eq(0).html(),scid);
          check_is_sub_item2($(this).children().eq(0).html(),scid);

          $("#h_"+scid).val($(this).children().eq(0).html());
          $("#0_"+scid).val($(this).children().eq(0).html());
          $("#n_"+scid).val($(this).children().eq(1).html());
          $("#2_"+scid).val($(this).children().eq(2).html()); 
                if(pr_type=="1"){          //  none price
                  $("#3_"+scid).val();    
                  $("#free_price_"+scid).val();   
                }else if(pr_type=="2"){    //  cost price
                  $("#3_"+scid).val($(this).children().eq(5).html());
                  $("#free_price_"+scid).val($(this).children().eq(5).html());
                }else if(pr_type=="3"){    //  min price
                  $("#3_"+scid).val($(this).children().eq(4).html());
                  $("#free_price_"+scid).val($(this).children().eq(4).html());
                }else if(pr_type=="4"){   //  max price
                  $("#3_"+scid).val($(this).children().eq(3).html());    
                  $("#free_price_"+scid).val($(this).children().eq(3).html());    
                }else if(pr_type=="5"){   //  sale Price 3
                  $("#3_"+scid).val($(this).children().eq(6).html());    
                  $("#free_price_"+scid).val($(this).children().eq(6).html());    
                }else if(pr_type=="6"){  //  sale Price 4
                  $("#3_"+scid).val($(this).children().eq(7).html());    
                  $("#free_price_"+scid).val($(this).children().eq(7).html());    
                }else if(pr_type=="7"){                     //  sale Price 5
                  $("#3_"+scid).val($(this).children().eq(8).html());    
                  $("#free_price_"+scid).val($(this).children().eq(8).html());    
                }else {                     //  sale Price 6
                  $("#3_"+scid).val($(this).children().eq(9).html());    
                  $("#free_price_"+scid).val($(this).children().eq(9).html());    
                }         

                
                $("#item_min_price_"+scid).val($(this).children().eq(4).html());
                $("#cost_"+scid).val($(this).children().eq(5).html());
                $("#1_"+scid).focus();
                $("#pop_close").click();
                check_is_batch_item(scid);
              //}else{
                //set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
              //}
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
              
                //discount();
                dis_prec();
                amount();

                gross_amount();
                gross_amount1();
                discount_amount();
                privilege_calculation();
                all_rate_amount();
                
                net_amount();

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
  $("input[type='hidden']").each(function(){
    if($(this).val() == id){
      v = false;
    }
  });    
  return v;
}



function load_data(id){
  var g=[];
  empty_grid();
  loding();
  $.post("index.php/main/get_data/t_credit_sales_sum/", {
    id: id
  }, function(r){
    var fre =parseFloat(0);
    if(r=="2"){
     set_msg("No records");
   }else{

    $("#load_opt").val("");    
    $("#hid_cash").val(r.sum[0].pay_cash);
    $("#hid_cheque_issue").val(r.sum[0].pay_issue_chq);
    $("#hid_credit_card").val(r.sum[0].pay_ccard);
    $("#hid_credit_note").val(r.sum[0].pay_cnote);
    $("#hid_debit_note").val(r.sum[0].previlliage_card_no);
    $("#hid_bank_debit").val(r.sum[0].pay_bank_debit);
    $("#hid_discount").val(r.sum[0].previlliage_card_no);
    $("#hid_advance").val(r.sum[0].pay_advance);
    $("#hid_gv").val(r.sum[0].pay_gift_voucher);
    $("#hid_credit").val(r.sum[0].pay_credit);
    $("#hid_pc").val(r.sum[0].previlliage_card_no);
    $("#hid_pc_type").val(r.sum[0].previlliage_card_no);  
    $("#hid_priv_card").val(r.sum[0].pay_privi_card);
    $("#credit_period").val(r.sum[0].credit_period);

    $("#hid_ins_period_by_days").val(r.sum[0].ins_period_by_days);
    $("#hid_ins_down_payment").val(r.sum[0].ins_down_payment);
    $("#hid_ins_rate_per_month").val(r.sum[0].ins_rate_per_month);
    $("#hid_num_of_installment").val(r.sum[0].num_of_installment);

    $("#ttl_amount").val(r.sum[0].net_amount);
    $("#period").val(r.sum[0].ins_period_by_days);
    $("#down_payment").val(r.sum[0].ins_down_payment);
    $("#rate_per_month").val(r.sum[0].ins_rate_per_month);
    $("#num_of_installment").val(r.sum[0].num_of_installment);

    $("#bill_cuss_name").val(r.sum[0].cus_name);
    $("#cus_address").val(r.sum[0].cus_address);

    $("#additional_add").val(r.sum[0].additional_add);
    $("#additional_deduct").val(r.sum[0].additional_deduct);

    $("#do_no").val(r.sum[0].do_no);
    $("#rcpt_no").val(r.sum[0].receipt_no);

    if(r.sum[0].is_multi_payment==1){
      $("#payment_option").attr("checked", "checked");
      $("#payment_option").css("display","none");
    }else{
      $("#payment_option").removeAttr("checked");
    }

    $("#load_opt").val("");    
    $("#cash").val(r.sum[0].pay_cash);
    $("#cheque_issue").val(r.sum[0].pay_issue_chq);
    $("#cheque_recieve").val(r.sum[0].pay_receive_chq);
    $("#credit_card").val(r.sum[0].pay_ccard);
    $("#credit_note").val(r.sum[0].pay_cnote);
    $("#debit_note").val(r.sum[0].pay_dnote);
    $("#bank_debit").val(r.sum[0].pay_bank_debit);
    $("#discount").val(r.sum[0].pay_discount);
    $("#advance").val(r.sum[0].pay_advance);
    $("#gv").val(r.sum[0].pay_gift_voucher);
    $("#credit").val(r.sum[0].pay_credit);
    $("#pc").val(r.sum[0].pay_privi_card);  
    $("#installment").val(r.sum[0].pay_installment); 
    $("#hid").val(id);   
    $("#qno").val(id); 
    $("#customer").val(r.sum[0].cus_id);
    $("#cus_id").val(r.sum[0].cus_id);
    $("#balance").val(r.balance);
    $("#customer_id").val(r.sum[0].name);
    $("#address").val(r.sum[0].address1+", "+r.sum[0].address2+", "+r.sum[0].address3);
    $("#date").val(r.sum[0].ddate); 
    $("#dt").val(r.sum[0].ddate);
    $("#type").val(r.sum[0].type);
    $("#sales_type").val(r.sum[0].type);
    $("#sales_category").val(r.sum[0].category);
    $("#sales_category1").val(r.sum[0].category);
    $("#sub_no").val(r.sum[0].sub_no);
    $("#dealer_id").val(r.sum[0].group_no);
    $("#stores").val(r.sum[0].store);
    $("#quotation").val(r.sum[0].quotation);
    set_select("stores","store_id");
    $("#ref_no").val(r.sum[0].ref_no);
    $("#memo").val(r.sum[0].memo);
    $("#sales_rep").val(r.sum[0].rep);
    $("#salesp_id").val(r.sum[0].rep);
    $("#sales_rep2").val(r.sum[0].rep_name);
    $("#gross").val(r.sum[0].gross_amount);
    $("#gross1").val(r.sum[0].gross_amount);
    $("#net").val(r.sum[0].net_amount);
    $("#is_foc").val(r.sum[0].is_bulk_foc);

    $("#sales_category").prop("disabled", true);

    $("#credit").val(r.sum[0].pay_credit);

    if(r.sum[0].crn_no!=0){
      $("#crn_no").val(r.sum[0].crn_no);
      $("#crn_no_hid").val(r.sum[0].crn_no);
    }else{
      $("#crn_no").val(r.crn);
      $("#crn_no_hid").val(0);
    }

    $("#amount8_0").val(r.sum[0].pay_privillege_card);
    $("#pc").val(r.sum[0].pay_privillege_card);
    $("#id").attr("readonly","readonly");

    var total_discount=0;
    var gross_amount=parseFloat(r.sum[0].gross_amount);       

    for(var i=0; i<r.det.length;i++){
      $("#h_"+i).val(r.det[i].code);
      $("#0_"+i).val(r.det[i].code);
      $("#itemcode_"+i).val(r.det[i].code);
      if($("#df_is_serial").val()=='1')
      {
        $("#numofserial_"+i).val(r.det[i].qty);
        check_is_serial_item2(r.det[i].code,i); 
        for(var a=0;a<r.serial.length;a++){
         if(r.det[i].code==r.serial[a].item){
          g.push(r.serial[a].serial_no);
          $("#all_serial_"+i).val(g);
        }   
      }
      g=[]; 
    }

    $("#n_"+i).val(r.det[i].item_des);
    $("#1_"+i).val(r.det[i].batch_no);
    $("#2_"+i).val(r.det[i].model);
    $("#3_"+i).val(r.det[i].price);
    $("#4_"+i).val(r.det[i].foc);
    $("#5_"+i).val(r.det[i].qty);
    $("#55_"+i).val(r.det[i].delivery_qty);
    $("#6_"+i).val(r.det[i].discountp);
    $("#7_"+i).val(r.det[i].discount);
    $("#8_"+i).val(r.det[i].amount);
    $("#9_"+i).val(r.det[i].warranty);
    $("#cost_"+i).val(r.det[i].cost);
    $("#item_min_price_"+i).val(r.det[i].min_price);

    $("#f_"+i).val(r.det[i].is_free);

    $("#free_price_"+i).val(r.det[i].price);
    $("#serial_"+i).val(r.det[i].serials);



    if(r.det[i].is_free=="1")
    {
      mark_as_free(i);
      if(r.det[i].foc==""){
        $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].qty));
        $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].qty));
      }else{
       $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
       $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
     }
   }else{
    if(r.det[i].is_free!="1" && r.det[i].foc>0){
      $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
      $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));

    }
  }

  if(r.det[i].is_free=='1'){
   fre +=parseFloat(r.det[i].amount);

 }

 if(r.det[i].is_free=='1')
 {
                      // alert(i);
                      
                      //mark_as_free(i);

                      // $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
                      // $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                      // $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                      // $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                      // $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                      // $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                      // $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
                      // $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');

                      // $("#n_"+i).closest("td").removeClass('g_col_fixed');
                      // $("#2_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important');
                      // $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important');
                      // $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important');
                      // $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
                      // $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');

                    }

                    var bal_tot=parseFloat(r.det[i].price)*r.det[i].free_balance;
                    $("#bal_tot_"+i).val(r.det[i].free_balance+"-"+bal_tot);

                    check_is_batch_item2(r.det[i].code,i); 
                    check_is_sub_item2(r.det[i].code,i);   
                    total_discount=total_discount+parseFloat(r.det[i].discount);  
                    is_sub_item(i);  
                    //$("#7_"+i).blur();    
                  }

                  result=r.add.length;
                  for(var i=0; i<r.add.length;i++){
                    $("#hhh_"+i).val(r.add[i].sales_type);
                    $("#00_"+i).val(r.add[i].sales_type);
                    $("#nn_"+i).val(r.add[i].description);
                    $("#11_"+i).val(r.add[i].rate_p);
                    $("#tt_"+i).val(r.add[i].amount);
                    get_sales_type(i);
                  }



                  if(r.sum[0].is_cancel==1){
                    $("#btnDelete").attr("disabled", "disabled");
                    $("#btnSave").attr("disabled", "disabled");
                    $("#mframe").css("background-image", "url('img/cancel.png')");
                  }

                  if(r.sum[0].is_approve==1){
                    $("#btnDelete").attr("disabled", "disabled");
                    $("#btnSave").attr("disabled", "disabled");
                    $("#mframe").css("background-image", "url('img/approved1.png')");
                  }

                  $("#total_discount").val(m_round(total_discount));
            // $("#free_tot").val(m_round(fre));
            
            $("#total_amount").val(m_round(gross_amount-fre));
            discount_amount();
            $("#gross").val(r.sum[0].gross_amount);
            $("#gross1").val(r.sum[0].gross_amount);
            $("#net").val(r.sum[0].net_amount);
            $("#free_tot").val(r.sum[0].total_foc_amount);
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
    $("#h_"+i).val("");
    $("#0_"+i).val("");
    $("#n_"+i).val("");
    $("#t_"+i).html("&nbsp;");
    $("#1_"+i).val("");
    $("#2_"+i).val("");
    $("#3_"+i).val("");
    $("#4_"+i).val("");
    $("#5_"+i).val("");
    $("#6_"+i).val("");
    $("#7_"+i).val("");
    $("#8_"+i).val("");
    $("#9_"+i).val("");
    $("#cost_"+i).val("");
    $("#f_"+i).val("");

    $("#5_"+i).attr("readonly", false);
    $("#bal_free_"+i).val("");
    $("#bal_tot_"+i).val("");
    $("#free_price_"+i).val("");
    $("#issue_qty_"+i).val("");
    $("#subcode_"+i).val("");
    $("#bqty"+i).val("");
    $("#subcode_"+i).removeAttr("data-is_click");
    $("#item_min_price_"+i).val("");
    $("#btn_"+i).css("display","none"); 
    $("#btnb_"+i).css("display","none");
    $("#sub_"+i).css("display","none");

    uncheck_free(i);
        // $("#n_"+i).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
        // $("#2_"+i).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        // $("#1_"+i).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
        // $("#1_"+i).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
        // $("#3_"+i).closest("td").attr('style', 'width: 58px;');
        // $("#6_"+i).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
        // $("#8_"+i).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');

        // $("#0_"+i).closest("tr").attr('style', 'background-color: #ffffff !important;');

        
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


    function discount(){
      var qty=parseFloat($("#5_"+scid).val());
      var price=parseFloat($("#3_"+scid).val());
      var dis_pre=parseFloat($("#6_"+scid).val());
      var discount="";
      if(isNaN(qty)){qty=0;}
      if(isNaN(price)){price=0;}
      if(isNaN(dis_pre)){dis_pre=0;}


      if(!isNaN(qty)&& !isNaN(price) && !isNaN(dis_pre)){
        discount=(price*dis_pre)/100;


        if(discount!=0){
          $("#7_"+scid).val(m_round(discount));
        }else{
          $("#7_"+scid).val("");
        }
      }

    }

/*    function dis_prec(){
      if($("#dis_update").val()!="1"){
        var qty=parseFloat($("#5_"+scid).val());
        var price=parseFloat($("#3_"+scid).val());
        var discount=parseFloat($("#7_"+scid).val());
        var foc=parseFloat($("#4_"+scid).val());
        var dis_pre="";

        if(isNaN(foc)){foc=0;}

        if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount)){
          dis_pre=(discount*100)/((qty-foc)*price);
          if(isNaN(dis_pre) || !isFinite(dis_pre)){    
            $("#6_"+scid).val("");
          }else{
            $("#6_"+scid).val(m_round(dis_pre));
          }
        }
      }else{

        var qty=parseFloat($("#5_"+scid).val());
        var price=parseFloat($("#3_"+scid).val());
        var foc=parseFloat($("#4_"+scid).val());
        var discount="";
        var dis_pre=parseFloat($("#6_"+scid).val());
        if(isNaN(foc)){foc=0;}

        if(!isNaN(qty)&& !isNaN(price) && !isNaN(dis_pre)){
          discount=((price)*dis_pre)/100;

          if(isNaN(discount) || !isFinite(discount)){    
            $("#7_"+scid).val("");
          }else{
            $("#7_"+scid).val(m_round(discount));
          }
        }
      }
    }


    function amount(){
      var all_foc=0;
      $(".tot_foc").each(function(e){
        var f=parseFloat($("#tot_foc_"+e).val());
        if(!isNaN(f)){
          all_foc=all_foc+parseFloat(f);
        }
      });


      $("#all_foc_amount").val(m_round(all_foc));

      var qty=parseFloat($("#5_"+scid).val());
      var price=parseFloat($("#3_"+scid).val());
      var foc=parseFloat($("#4_"+scid).val());
      var amount="";

      if(isNaN(qty)){qty=0;}
      if(isNaN(price)){price=0;}
      if(isNaN(foc)){foc=0;}

      var total_dis=0;
      var total_foc=m_round(price*foc);
      $("#tot_foc_"+scid).val(m_round(total_foc));
      var discount=parseFloat($("#7_"+scid).val());
      var dis_pre=0;
      if(isNaN(discount)){discount=0;}

      if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount) && !isNaN(foc)){
        amount = (price - discount)*(qty-foc);
        // amount=(qty-foc)*price;
        total_dis=(qty)*discount;
        //amount=amount-total_dis;
        //dis_pre=(discount*100)/price;

        $("#tot_dis_"+scid).val(m_round(total_dis));
        $("#8_"+scid).val(m_round(amount)); 

      }else if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount)){
        amount=((qty-foc)*price)-discount;
        if(amount!=0){
         $("#8_"+scid).val(m_round(amount)); 
       }else{
         $("#8_"+scid).val(""); 
       }

     }else if(!isNaN(qty)&& !isNaN(price)){
      amount=((qty-foc)*price);
      if(amount!=0){
       $("#8_"+scid).val(m_round(amount)); 
     }else{
       $("#8_"+scid).val(""); 
     }
   }
 }
 */


 function dis_prec(){
  if($("#dis_update").val()!="1"){
    var qty=parseFloat($("#5_"+scid).val());
    var price=parseFloat($("#3_"+scid).val());
    var foc=parseFloat($("#4_"+scid).val());
    var discount=parseFloat($("#7_"+scid).val());
    if(isNaN(foc)){foc=0;}
    var amount=parseFloat(price*(qty-foc));
    var dis_pre="";
    if(isNaN(amount)){amount=0;}
    if(!isNaN(qty)&& !isNaN(foc)&& !isNaN(price) && !isNaN(discount)&& !isNaN(amount)){
      if($('#dis_type').val()=='1'){
        dis_pre=(discount*100)/(price);
      }else if($('#dis_type').val()=='2'){
        dis_pre=(discount*100)/(amount);
      }

      if(isNaN(dis_pre) || !isFinite(dis_pre)){    
        $("#6_"+scid).val("");
      }else{
        $("#6_"+scid).val(m_round(dis_pre));
      }
    }
  }else{

    var qty=parseFloat($("#5_"+scid).val());
    var price=parseFloat($("#3_"+scid).val());
    var foc=parseFloat($("#4_"+scid).val());
    var discount="";
    var dis_pre=parseFloat($("#6_"+scid).val());
    if(isNaN(foc)){foc=0;}
    var amount=parseFloat(price*(qty-foc));

    if(!isNaN(qty)&& !isNaN(foc)&& !isNaN(price) && !isNaN(dis_pre) && !isNaN(amount)){
      if($('#dis_type').val()=='1'){
        discount=((price)*dis_pre)/100;
      }else if($('#dis_type').val()=='2'){
        discount=((amount)*dis_pre)/100;
      }

      if(isNaN(discount) || !isFinite(discount)){    
        $("#7_"+scid).val("");
      }else{
        $("#7_"+scid).val(m_round(discount));
      }
    }
  }
}

function amount(){
  var all_foc=0;
  $(".tot_foc").each(function(e){
    var f=parseFloat($("#tot_foc_"+e).val());
    if(!isNaN(f)){
      all_foc=all_foc+parseFloat(f);
    }
  });
  

  $("#all_foc_amount").val(m_round(all_foc));

  var qty=parseFloat($("#5_"+scid).val());
  var price=parseFloat($("#3_"+scid).val());
  var foc=parseFloat($("#4_"+scid).val());
  var amount="";

  if(isNaN(qty)){qty=0;}
  if(isNaN(price)){price=0;}
  if(isNaN(foc)){foc=0;}

  var amo=parseFloat(price*(qty-foc));
  if(isNaN(amo)){amo=0;}

  var total_dis=0;
  var total_foc=m_round(price*foc);
  $("#tot_foc_"+scid).val(m_round(total_foc));
  var discount=parseFloat($("#7_"+scid).val());
  var dis_pre=0;
  if(isNaN(discount)){discount=0;}
  amount=(qty-foc)*price;
  total_dis=(qty-foc)*discount;  
  if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount) && !isNaN(foc)){

    if($('#dis_type').val()=='1'){
      amount=amount-total_dis;
      $("#tot_dis_"+scid).val(m_round(total_dis));
    }else if($('#dis_type').val()=='2'){
      amount=amo-discount;    
      $("#tot_dis_"+scid).val(m_round(discount));
    }
    $("#8_"+scid).val(m_round(amount)); 

  }else if(!isNaN(qty)&& !isNaN(price) && !isNaN(discount)){

   if($('#dis_type').val()=='1'){
    amount=(qty*price)-discount;
  }else if($('#dis_type').val()=='2'){
    amount=amo-discount;    
  }
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

function mark_as_free(i,item){
  $("#free_"+scid).prop('disabled', false);
  $("#0_"+i).closest("tr").find("td").css('background-color', 'rgb(224, 228, 146)');
  $("#0_"+i).closest("tr").find("td").removeClass('g_col_fixed');
  $("#0_"+i).closest("tr").find("input").removeClass('g_col_fixed');
  $("#0_"+i).closest("tr").find("input").css('background-color', 'rgb(224, 228, 146)');
  $("#0_"+i).closest("tr").find("input[type='button']").css('background-color','');
  //$("#issue_qty_"+i).val($("#5_"+i).val());
  $("#isfree_"+i).val("1"); 
  $("#free_"+i).attr('checked', true);
  calculate_free_total();

}

function uncheck_free(scid,item){
  $("#free_"+scid).prop('disabled', false);
  $("#0_"+scid).closest("tr").find("td").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');

  $("#1_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#1_"+scid).css('background-color','#f9f9ec');

  $("#2_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#2_"+scid).css('background-color','#f9f9ec');

  // $("#6_"+scid).closest("td").css('background-color','#f9f9ec');
  // $("#6_"+scid).css('background-color','#f9f9ec');

  $("#n_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#n_"+scid).css('background-color','#f9f9ec');

  // $("#4_"+scid).css('background-color','#f9f9ec');
  // $("#4_"+scid).closest("td").css('background-color','#f9f9ec');

  $("#8_"+scid).css('background-color','#f9f9ec');
  $("#8_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#issue_qty_"+scid).val("0");
  $("#isfree_"+scid).val("0");
  $("#free_"+scid).attr('checked', false);
  calculate_free_total();

}



function gross_amount(){
  var gross=loop=0;
  var free=parseFloat(0);

  $(".amount").each(function(){
    var gs=parseFloat($("#8_"+loop).val());
    if(!isNaN(gs)){    
      gross=gross+gs;
    }  
    if($("#f_"+loop).val()==1){
      free+=parseFloat($("#8_"+loop).val())
    }  
    loop++;

  });
  calculate_free_total();    
  $("#gross").val(m_round(gross));
    // $("#free_tot").val(m_round(free));

    //$("#free_tot").focus();
  }

  function gross_amount1(){
    var gross=loop=0;
    var free=parseFloat(0);

    $(".amount").each(function(){
      var gs=parseFloat($("#5_"+loop).val()*$("#3_"+loop).val());
      if(!isNaN(gs)){    
        gross=gross+gs;
      }  
      if($("#f_"+loop).val()==1){
        free+=parseFloat($("#5_"+loop).val()*$("#3_"+loop).val())
      }  
      loop++;
    });
    //calculate_free_total();    
    $("#gross1").val(m_round(gross));
    //$("#free_tot").focus();

  }

  function discount_amount(){
   var dis=loop=0;
   $(".amount").each(function(){
    var price=parseFloat($("#7_"+loop).val());
    var qty=parseFloat($("#5_"+loop).val());
    var foc=parseFloat($("#4_"+loop).val());
    if(isNaN(foc)){foc=0;}
    if($("#dis_type").val()=="1"){
      var gs=price*(qty-foc);
    }else{
      var gs=price;
    }
    if(!isNaN(gs)){    
      dis=dis+gs;
    }    
    loop++;
  });
   calculate_free_total();
   $("#dis_amount").val(m_round(dis));
   $("#total_discount").val(m_round(dis));



 }


 function rate_amount(){
  var rate_pre=parseFloat($("#11_"+scid).val());
  var gross_amount=parseFloat($("#gross").val());
  var rate_amount="";

  if(!isNaN(rate_pre)&& !isNaN(gross_amount)){
    rate_amount=(gross_amount*rate_pre)/100;
    $("#tt_"+scid).val(m_round(rate_amount));
  }
}


function rate_pre(){
  var gross_amount=parseFloat($("#gross").val());
  var rate=parseFloat($("#tt_"+scid).val());
  var rate_amount_pre="";



  if(!isNaN(rate)&& !isNaN(gross_amount)){
    rate_amount_pre=(rate*100)/gross_amount;
    $("#11_"+scid).val(m_round(rate_amount_pre));
  }

}



function all_rate_amount(){
  var gross_amount=parseFloat($("#gross").val());  
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

function net_amount(){

  var gross_amount=parseFloat($("#gross").val());
  var free_amount=parseFloat($("#free_tot").val());
  var free=parseFloat(0);
  var net_amount=additional=loop=addit=ddt=0;
  $(".foo").each(function(){
    var add=parseFloat($("#tt_"+loop).val());
    var f= $("#hh_"+loop).val();

    if(!isNaN(add)){
      if(f==1){
        additional=additional+add;
        addit+=add;
        $("#additional_add").val(addit);
      }else{
        additional=additional-add;  
        ddt+=add;
        $("#additional_deduct").val(ddt);    
      }
    }    
    loop++;

  });





  var discount=0;

  $(".tot_discount").each(function(e){
    if(!isNaN(parseFloat($("#tot_dis_"+e).val()))){
      discount=discount+parseFloat($("#tot_dis_"+e).val());
    }
    if($("#f_"+e).val()==1){
      free+=parseFloat($("#8_"+e).val())
    }
  });
   // $("#free_tot").val(free);
   calculate_free_total();
   var gros = parseFloat($("#gross1").val());
   var fr = parseFloat($("#free_tot").val());
   var di = parseFloat($("#dis_amount").val());

   net_amount = gros-(fr+di);

   if(!isNaN(additional)&& !isNaN(gross_amount)){
    net_amount=net_amount+additional;
    $("#net").val(m_round(net_amount));
  }else{
    $("#net").val(net_amount);
  }


  $("#total_amount").val(m_round(gross_amount+discount-free));


}

function calculate_free_total(){

  var foc_total=loop=0;
  $(".amount").each(function(){
  //if ($("#f_"+loop).val()!="0") {
    var gs=parseFloat($("#issue_qty_"+loop).val() * $("#3_"+loop).val());
    if(!isNaN(gs)){    
      foc_total=foc_total+gs;
    }    
  //};
  loop++;
});
  $("#free_tot").val(m_round(foc_total)); 

   // alert(foc_total);
 }


 function check_batch_qty(scid){
  $.post("index.php/main/load_data/t_credit_sales_sum/get_batch_qty",{
    store:$("#stores").val(),
    batch_no:$("#1_"+scid).val(),
    code:$("#0_"+scid).val(),
    hid:$("#hid").val(),
    dealer:$("#dealer_id").val()
  },function(res){     
    if(parseFloat(res)<0){
      res=0;
    }
    if(parseFloat(res) < parseFloat($("#5_"+scid).val())){
            //$("#5_"+scid).val("");
            //$("#5_"+scid).focus();
            //$("#subcode_"+scid).val(''); 
            set_msg("There is not enough quantity in this batch","error");            
          }
        },"text");
}



function select_search4(){
  $("#pop_search4").focus();
}

function get_group(){
  $.post("index.php/main/load_data/r_groups/select_by_category", {
    category_id : $("#sales_category").val()
  }, function(r){
   $("#groups").html(r);
 }, "text");

}

function load_data10(){
  $.post("index.php/main/load_data/t_cash_sales_sum/load_b_foc", {
    date:$("#date").val(),
    search : $("#pop_search").val() 
  }, function(r){
    $("#sr").html(r);
    settings11();            
  }, "text");
}

function settings11(){
  $("#item_list .cl").click(function(){        

    load_foc_items($(this).children().eq(0).html(),$("#date").val()); 
    $("#is_foc").val($(this).children().eq(0).html());      
    $("#pop_close").click();                
  })  
  calculate_free_total(); 
}


function load_foc_items(code,date){
  loding();
  empty_grid();
  $.post("index.php/main/load_data/t_cash_sales_sum/load_foc_items", {
    code:code,
    date:date
  }, function(r){ 
    loding();          
    for(var i=0; i<r.a.length;i++){
      $("#h_"+i).val(r.a[i].code);
      $("#0_"+i).val(r.a[i].code);
      $("#itemcode_"+i).val(r.a[i].code);
      if($("#df_is_serial").val()=='1')
      {
        check_is_serial_item2(r.a[i].code,i); 
      }
      $("#n_"+i).val(r.a[i].description);
      $("#2_"+i).val(r.a[i].model);
      $("#cost_"+i).val(r.a[i].cost);
      $("#5_"+i).val(r.a[i].qty);
      $("#item_min_price_"+i).val(r.a[i].min_price);
      $("#free_price_"+i).val(r.a[i].price);
      $("#free_price_"+i).val(r.a[i].price);
      $("#3_"+i).val(r.a[i].price);
      $("#free_price_"+i).val(r.a[i].price);

      check_is_batch_item2(r.a[i].code,i);
      check_is_sub_item2(r.a[i].code,i); 
      is_sub_item(i);  
      check_is_batch_item(i);

      if(r.a[i].is_free==1){
        $("#f_"+i).val("1");

        mark_as_free(i);

        $("#free_"+i).prop('disabled', true);

                    // $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
                    // $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                    // $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                    // $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                    // $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    // $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    // $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
                    // $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');

                  }
                  $("#5_"+i).blur();
                  calculate_free_total();                            
                }

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


function load_dealer(){
  if($("#load_type").val()=="2"){
    var tbl="m_customer";
    var p_name="Dealer Name";
    var a_query='AND type="003"';
  }else{
    var tbl="r_groups";
    var p_name="Group Name";
    var a_query="";
  }
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:tbl,
    field:"code",
    field2:"name",
    preview2:p_name,
    add_query:a_query,
    search : $("#pop_search14").val() 
  }, function(r){
    $("#sr14").html(r);
    settings_dealer();            
  }, "text");
}

function settings_dealer(){
  $("#item_list .cl").click(function(){        
    $("#dealer_id").val($(this).children().eq(0).html());
    $("#pop_close14").click();                
  })    
}
function get_cus_color(code){
  $.post("index.php/main/load_data/utility/select_color",{
   color_code:code
 },function(r){
  if(r.a!=2){
    $("#customer_id").removeClass("hid_value main_cus");
    $("#customer_id").addClass("input_txt");
    $("#customer_id").css("background-color",r.a[0].color);
  }else {
   $("#customer_id").addClass("hid_value main_cus");
   $("#customer_id").css("background-color","");
 }
},"json");
}


function check_item_in_grid(item,batch,id){
    $(".qty").each(function(e){
        if($("#0_"+e).val()==item && $("#1_"+e).val()==batch && e!=id){
            set_msg("Item ("+item+") in same batch ("+batch+") already added");
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
            $("#cost_"+scid).val("");
            $("#bal_free_"+scid).val("");
            $("#bal_tot_"+scid).val("");
            $("#free_price_"+scid).val("");
            $("#issue_qty_"+scid).val("");
            $("#subcode_"+scid).val("");
            $("#bqty"+scid).val("");
            $("#item_min_price_"+scid).val("");
            $("#subcode_"+scid).removeAttr("data-is_click");
            $("#btn_"+scid).css("display","none"); 
            $("#btnb_"+scid).css("display","none");
        }
    });
}
