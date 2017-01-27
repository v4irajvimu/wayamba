$(document).ready(function(){

     var save_status=1;

    $("#tgrid").tableScroll({height:100, width:1100});
    $("#tgrid1").tableScroll({height:90, width:1100});

    $(".qty").blur(function(){
       set_cid($(this).attr("id"));
       amount_cal();
    });

    $(".quality").blur(function(){
       set_cid($(this).attr("id"));
       amount_cal();
    });
    $("#code_id").blur(function(){
       check_code();
    });

    $("#i_type").change(function(){
      if($("#i_type").val()=="2"){
        $(".non").css("display","none");
      }else{
        $(".non").css("display","block");
      }
    });

    $("#book_no").keypress(function(e){
        if(e.keyCode == 112){
          $("#pop_search12").val($("#book_no").val());
          load_book();
          $("#serch_pop12").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search12').focus()", 100);
        }
        $("#pop_search12").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_book();
          }
        }); 
        if(e.keyCode == 46){
          $("#book_no").val("");
          $("#book_des").val("");
          $("#settu_item_category").val("");
          $("#category_name").val("");
        }
    });

   
    $("#btnResett").click(function(){
   	  location.href="";
    });

    $("#btn_book").click(function(){
      window.open("?action=m_settu_book_edition","_blank");  
    });

    $("#btnseettu_category").click(function(){
      window.open("?action=m_settu_item_category","_blank"); 
    });

    $("#btnDelete").click(function(){
     set_delete();
    });


   // $("#btnPrint").click(function(){
   //          if($("#hid").val()=="0"){
   //            set_msg("Please load data before print");
   //            return false;
   //          }else{
   //              $("#print_pdf").submit();
   //          }  
   //      });

   // $("#btnSave").click(function(){
   //     validate();
   //  });



   $("#id_no").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
      $(this).attr("readonly","readonly");
    }
  });
    
 

  $("#settu_item_category").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search2").val($("#settu_item_category").val());
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
      $("#settu_item_category").val("");
      $("#category_name").val("");
      $("#hid_code").val("");
    }
  });  


  $("#code_id").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search4").val($("#code_id").val());
      load_codes();
      $("#serch_pop4").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search4').focus()", 100);
    }

    $("#pop_search4").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
           load_codes();
      }
    }); 

    if(e.keyCode == 46){
      $("#code_id").val("");
    }
  }); 

     
  $(".fo").keypress(function(e){  
    set_cid($(this).attr("id"));
      if(e.keyCode==112){
        $("#pop_search").val($("#0_"+scid).val());
        load_items();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        //setTimeout("select_search()", 100);
      }
      $("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          load_items();
        }
      });
      if(e.keyCode==13){
        $.post("index.php/main/load_data/m_settu_item_setup/get_item", {
          code:$("#0_"+scid).val()
        }, function(res){
          if(res.a!=2){
            $("#0_"+scid).val(res.a[0].code);
              if(check_item_exist($("#0_"+scid).val())){               
                $("#h_"+scid).val(res.a[0].code);
                $("#n_"+scid).val(res.a[0].description);
                $("#0_"+scid).val(res.a[0].code);                      
                $("#3_"+scid).val(res.a[0].cost);
                $("#item_min_price_"+scid).val(res.a[0].min_price);
                $("#free_price_"+scid).val(res.a[0].max_price);             
                $("#2_"+scid).focus();
                $("#pop_close").click();                            
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
          $("#h_"+scid).val("");
          $("#0_"+scid).val("");
          $("#n_"+scid).val("");
          $("#1_"+scid).val(""); 
          $("#2_"+scid).val(""); 
          $("#3_"+scid).val("");
          $("#item_min_price_"+scid).val("");  
          $("#free_price_"+scid).val("");
          $("#5_"+scid).val("");
          amount_cal();
        }
    });
    
  //-------------------------------------------------
  $(".sub_i").keypress(function(e){  
    set_cid($(this).attr("id"));
           //alert(scid);
           //scid=0;
           if(e.keyCode==112){

                $("#pop_search").val($("#itemCode_"+scid).val());
                load_sub_items();
                $("#serch_pop").center();
                $("#blocker").css("display", "block");
                //setTimeout("select_search()", 100);
            }
           $("#pop_search").keyup(function(e){
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                    load_sub_items();
                }
           });
      
        if(e.keyCode==13){
            $.post("index.php/main/load_data/m_settu_item_setup/get_item", {   
                code:$("#itemCode_"+scid).val()
            }, function(res){
                if(res.a!=2){
                    //alert(scid);
                    $("#item_name_"+scid).val(res.a[0].code);
                        if(check_item_exist($("#item_name_"+scid).val())){               
                            $("#h_"+scid).val(res.a[0].code);
                            $("#item_name_"+scid).val(res.a[0].description);
                            $("#itemCode_"+scid).val(res.a[0].code);                      
                            $("#cost_"+scid).val(res.a[0].cost);
                            $("#last_price_"+scid).val(res.a[0].min_price);
                            $("#max_price_"+scid).val(res.a[0].max_price);             
                            $("#qty_"+scid).focus();
                            $("#pop_close").click();                            
                        }else{
                            set_msg("Item "+$("#itemCode_"+scid).val()+" is already added.","error");
                        }
                }else{
                    set_msg($("#itemCode_"+scid).val()+" Item not available in store","error");
                    $("#itemCode_"+scid).val("");
                }
            }, "json");

        }

        if(e.keyCode==46){
            $("#h_"+scid).val("");
            $("#itemCode_"+scid).val("");
            $("#item_name_"+scid).val(""); 
            $("#qty_"+scid).val(""); 
            $("#cost_"+scid).val("");
            $("#last_price_"+scid).val("");  
            $("#max_price_"+scid).val("");
            $("#amount_"+scid).val("");

            amount_cal();
        }
        
    });
  //------------------------------------------------------

 });/*end*/

function load_book(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_settu_book_edition",
      field:"code",
      field2:"description",
      preview2:"Edition Name",
      add_query:"AND is_active='1'",
      search : $("#pop_search12").val() 
  }, 
  function(r){
      $("#sr12").html(r);
      settings_book();        
  }, "text");
}

function settings_book(){
  $("#item_list .cl").click(function(){        
    $("#book_no").val($(this).children().eq(0).html());
    $("#book_des").val($(this).children().eq(1).html());
    $("#pop_close12").click();                
  })    
}

function load_codes(){
  $.post("index.php/main/load_data/m_settu_item_setup/load_saved_codes", {
      search : $("#pop_search4").val(),
      type :$("#i_type").val() 
    }, function(r){
      $("#sr4").html(r);
      settings_codes();            
    }, "text");
}

function settings_codes(){
  $("#item_list .cl").click(function(){        
    load_data($(this).children().eq(4).html());
    $("#pop_close4").click();
  })    
}

function empty_grid(){
  $("#book_no").val("");
  $("#book_des").val("");
  $("#settu_item_category").val("");
  $("#category_name").val("");
  $("#code_id").val("");
  $("#discription").val("");
  $("#price_value").css("display","none");
  $("#item_value").val("");
  $("#tot_item_value").val("");
  $("#free_item_value").val("");
  $("#note").val("");

  for(var x=0; x<25; x++){
    $("#h_"+x).val("");
    $("#itemCode_"+x).val("");
    $("#item_name_"+x).val("");
    $("#qty_"+x).val("");
    $("#cost_"+x).val("");
    $("#last_price_"+x).val("");
    $("#max_price_"+x).val("");
    $("#amount_"+x).val("");

    $("#0_"+x).val("");
    $("#n_"+x).val("");
    $("#2_"+x).val("");
    $("#3_"+x).val("");
    $("#item_min_price_"+x).val("");
    $("#free_price_"+x).val("");
    $("#5_"+x).val("");
    $("#subcode_"+x).val("");
  }
}

function load_data9(){
        $.post("index.php/main/load_data/utility/f1_selection_list", {
            data_tbl:"m_settu_item_category",
            field:"code",
            field2:"name",
            preview1:"Code",
            preview2:"Name",
            hid_field:"ref_code",
            add_query:"AND book_edition ='"+$("#book_no").val()+"'",
            search : $("#pop_search2").val() 
        }, function(r){
            $("#sr2").html(r);
            settings9();            
        }, "text");
    }

function settings9(){
    $("#item_list .cl").click(function(){        
        $("#settu_item_category").val($(this).children().eq(0).html());
        $("#category_name").val($(this).children().eq(1).html());
        $("#hid_code").val($(this).children().eq(2).find('input').val());
         var price=$(this).children().eq(1).html();
          var a="  Rs."+price.split('=')[1]+"=";
        
        $("#pop_close2").click();
        $("#price_value").html("");
         $("#price_value").css("display", "block");

        $("#price_value").append(a);               
    })    
}


function load_items(){        
     $.post("index.php/main/load_data/m_settu_item_setup/item_list_all", {
        search : $("#pop_search").val()
        
    }, function(r){
        $("#sr").html("");
        $("#sr").html(r);
        settings();
    }, "text");
}



function settings(){
    $("#item_list .cl").click(function(){

        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist($(this).children().eq(0).html())){

                $("#h_"+scid).val($(this).children().eq(0).html());
                $("#n_"+scid).val($(this).children().eq(1).html());
                $("#0_"+scid).val($(this).children().eq(0).html());
                $("#3_"+scid).val($(this).children().eq(2).html());
                $("#item_min_price_"+scid).val($(this).children().eq(3).html());
                $("#free_price_"+scid).val($(this).children().eq(4).html());
                $("#2_"+scid).focus();
                $("#pop_close").click();
                 
            }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#h_"+scid).val("");
            $("#n_"+scid).val("");
            $("#0_"+scid).val("");
            $("#3_"+scid).val("");  
            $("#item_min_price_"+scid).val("");  
            $("#free_price_"+scid).val("");
            $("#2_"+scid).val(""); 
            $("#pop_close").click();
        }
    });
}

function load_sub_items(){        
     $.post("index.php/main/load_data/m_settu_item_setup/item_list_all", {
        search : $("#pop_search").val()
        
    }, function(r){
        $("#sr").html("");
        $("#sr").html(r);
        settings1();
    }, "text");
}

function settings1(){
    $("#item_list .cl").click(function(){
        
        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist1($(this).children().eq(0).html())){
                //alert(scid);
                $("#h_"+scid).val($(this).children().eq(0).html());
                $("#item_name_"+scid).val($(this).children().eq(1).html());
                $("#itemCode_"+scid).val($(this).children().eq(0).html());
                $("#cost_"+scid).val($(this).children().eq(2).html());
                $("#last_price_"+scid).val($(this).children().eq(3).html());
                $("#max_price_"+scid).val($(this).children().eq(4).html());
                $("#qty_"+scid).focus();
                $("#pop_close").click();
                 
            }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#h_"+scid).val("");
            $("#itemCode_"+scid).val("");
            $("#item_name_"+scid).val("");
            $("#cost_"+scid).val("");  
            $("#last_price_"+scid).val("");  
            $("#max_price_"+scid).val("");
            $("#qty_"+scid).val(""); 
            $("#pop_close").click();
        }
    });
}

function check_item_exist(id){
    var v = true;
    $(".fo").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });    
    return v;
}

function check_item_exist1(id){
    var v = true;
    $(".sub_i").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });    
    return v;
}
function amount_cal(){
   var qty=price=tot=amount=tot1=amount1=0;

   if(!isNaN(qty)){qty=$("#2_"+scid).val();}
   if(!isNaN(price)){price=$("#free_price_"+scid).val();}

   if(!isNaN(qty)&& !isNaN(price)){
        amount=(qty*price);
        if(amount!=0){

           $("#5_"+scid).val(m_round(amount));
        }else{
           $("#5_"+scid).val("");            
        }
    }

    $(".qty").each(function(e){
        if($("#5_"+e).val() !=""){
         tot+= parseFloat($("#5_"+e).val());
        }
    });
    $("#item_value").val(m_round(tot));

    if(!isNaN(qty)){qty=$("#qty_"+scid).val();}
   if(!isNaN(price)){price=$("#max_price_"+scid).val();}

   if(!isNaN(qty)&& !isNaN(price)){
        amount1=(qty*price);
        if(amount1!=0){

           $("#amount_"+scid).val(m_round(amount1));
        }else{
           $("#amount_"+scid).val("");            
        }
    }

    $(".quality").each(function(e){
        if($("#amount_"+e).val() !=""){
         tot1+= parseFloat($("#amount_"+e).val());
        }
    });
    $("#free_item_value").val(m_round(tot1));
   $("#tot_item_value").val(m_round(tot+tot1));

}

function save(){

    var frm = $('#form_');
        loding();
        $.ajax({
      type: frm.attr('method'),
      url: frm.attr('action'),
      data: frm.serialize(),
      success: function (pid){
           if(pid==1){
               loding();
              $("#btnSave").attr("disabled",true);
                sucess_msg();
            }else if(pid == 2){
                alert("No permission to add data.");
            }else if(pid == 3){
                alert("No permission to edit data.");
            }else{
                loding();
                set_msg(pid);
            }
           // loding();
      }
    });
}


function check_code(){
    var code = $("#code_id").val();
    $.post("index.php/main/load_data/m_settu_item_setup/check_code", {
        code : code
    }, function(res){
        if(res.num == 1){
            if(confirm("This code ("+code+") already added. \n\n Do you need edit it?")){
                load_data(res.det[0].no);
            }else{
                $("#code_id").val('');
            }
        }
    }, "json");
}

function validate(){
    var y=true;
    var category = $("#settu_item_category").val();
    var code = $("#code_id").val();
    var t_value = $("#item_value").val();    
    var price=$("#category_name").val();

    if($("#i_type").val()=="1" && $("#book_no").val()!="" && $("#category").val()!=""){
      var a=price.split('=')[1];
      var b=a.split('/')[0]+ ".00";
    }
     
   if(($("#0_0").val()=="") && $("#2_0").val()==""){
      y=false;
   }
   for(var t=0; t<10; t++){
       if( ($("#0_"+t).val()!="") &&  $("#2_"+t).val()==""){
          y=false;
      }
   }

   for(var z=0; z<5; z++){
       if( ($("#itemCode_"+z).val()!="") &&  $("#qty_"+z).val()==""){
          y=false;
      }
   }

   if($("#book_no").val()=="" && $("#i_type").val()=="1"){
      set_msg("Please add book Edition");
      $("#book_no").focus();
      return false;
   }else if((category==""||category==null) && $("#i_type").val()=="1"){
      set_msg("Please add category");
      $("#settu_item_category").focus();
      return false;
   }else if (code==""||code==null){
      set_msg("Please add item code");
      $("#code_id").focus();
      return false;
   }else if(y==false && $("#i_type").val()=="1"){    
      set_msg("Please add item code with quantity");
      return false;
   }//else if(parseFloat(t_value)!=(parseFloat(b)) && $("#i_type").val()=="1"){
   //    set_msg("Total Item Amount and Category are not Equals");
   //    return false;
   //}
   else{
      return true;
   }    

}
    
function set_delete(){
     var id = $("#hid").val();
    
   if(confirm("Are you sure delete "+id+"?")){
        //loding();
        $.post("index.php/main/delete/m_settu_item_setup", {
            id_no : id

        }, function(res){
            //loding();
            
            if(res == 1){
                location.reload();
            }else{
                alert("Item deleting fail.");
            }
           
        }, "text");
   }
}
    
function load_data(id_no){
   loding();
   empty_grid();
    $.post("index.php/main/get_data/m_settu_item_setup", {
       id_no : id_no     
    }, function(res){
		   loding();
        if(res=="2"){
               set_msg("No records");
        }else{
        
          $("#id_no").val(id_no);
          $("#hid").val(id_no);
          $("#date").val(res.sum[0].ddate); 
          $("#settu_item_category").val(res.sum[0].settu_item_category);
          $("#category_name").val(res.sum[0].item_name);
          $("#code_id").val(res.sum[0].item_code);
          $("#hid_code").val(res.sum[0].hid_code);
          $("#book_no").val(res.sum[0].book_edition);
          $("#book_des").val(res.sum[0].b_name);
          $("#discription").val(res.sum[0].name);
          $("#item_value").val(res.sum[0].item_value);
          $("#note").val(res.sum[0].note);
          $("#i_type").val(res.sum[0].type);

          if(res.sum[0].type == "1"){
            var price=(res.sum[0].item_name);
            var a="  Rs."+price.split('=')[1]+"=";
            $("#price_value").html("");
            $("#price_value").css("display", "block");
            $("#price_value").append(a);  
            $(".non").css("display","block"); 
          }else{
            $(".non").css("display","none");
          }

          for(var i=0; i<res.det.length;i++){
            $("#h_"+i).val(res.det[i].item_code);
            $("#0_"+i).val(res.det[i].item_code);
            $("#n_"+i).val(res.det[i].description);  
            $("#2_"+i).val(res.det[i].qty);
            $("#3_"+i).val(res.det[i].item_cost_price);
            $("#item_min_price_"+i).val(res.det[i].item_last_price);
            $("#free_price_"+i).val(res.det[i].item_max_price);
             scid=i;
             amount_cal();  
          }

          
          if(res.det_free!=2){
            for(var i=0; i<res.det_free.length;i++){
              $("#itemCode_"+i).val(res.det_free[i].item_codes);
              $("#item_name_"+i).val(res.det_free[i].dis);
              $("#qty_"+i).val(res.det_free[i].quantity);
              $("#cost_"+i).val(res.det_free[i].cost);
              $("#last_price_"+i).val(res.det_free[i].last_p);
              $("#max_price_"+i).val(res.det_free[i].max_p);
              //$("#5_"+i).val(res.det[i].description);
              scid=i;
              amount_cal();   
            }
          }

        if(res.sum[0].is_cancel==1){
            $("#btnDelete").attr("disabled", "disabled");
            $("#btnSave").attr("disabled", "disabled");
            $("#mframe").css("background-image", "url('img/cancel.png')");
        }

        
    }
      

    
    }, "json");

   

}