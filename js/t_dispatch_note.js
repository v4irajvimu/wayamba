
$(document).ready(function(){

  $(".qunsb").css("display","none");

  $(".fo").blur(function(){
    var id=$(this).attr("id").split("_")[1];
    if($(this).val()=="" || $(this).val()=="0"){
    }else if($(this).val()!=$("#itemcode_"+id).val()){
      if($("#df_is_serial").val()=='1'){
       deleteSerial(id);
     }
    }
  });


  $(".ky").keyup(function(){
    var aqty = parseFloat($("#qtyh_"+scid).val());
    var tqty = parseFloat($("#3_"+scid).val());    
    if(aqty<tqty)
    {
      set_msg("Maximum available quantity is"+aqty);
      //$("#3_"+scid).val("0");
      return false;
    }  
  });

  $("#group_id").keypress(function(e){
      if(e.keyCode == 112){
          $("#pop_search6").val($("#group_id").val());
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
          $("#group_id").val("");
          $("#group").val("");
      }
  });
  $("#officer").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search11").val($("#officer").val());
            load_data9();
            $("#serch_pop11").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search11').focus()", 100);
        }

       $("#pop_search11").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_data9();
            }
        }); 

        if(e.keyCode == 46){
            $("#officer").val("");
            $("#officer_id").val("");
        }
    });

  $(".qunsb").click(function(){
    set_cid($(this).attr("id"));
    check_is_batch_item(scid);
  });


  $("#free_fix,#pst").blur(function(){
    var get_code=$(this).val();
    $(this).val(get_code.toUpperCase());
  });


  $(".fo").focus(function(){
    if($("#from_store").val()==0)
    {
      set_msg("Please select From Store");
    }
    else if($("#to_store").val()==0)
    {
      set_msg("Please select To Store");
    }
  });


  $("#btnDelete").click(function () {
    loding();
        $.post("index.php/main/load_data/t_dispatch_note/checkdelete", {
            no: $("#id").val(),
        },
        function (r) {
         loding();
            if (r == 2) {
                set_msg("Please enter exsits ID");
                return false;
                
            } else {
                var no = $("#id").val();
             loding();
                if (confirm("Are you sure delete " + no + "?")) {

                    $.post("index.php/main/delete/t_dispatch_note", {
                        id: no,
                    },
                    function (r) {
                        if(r==1)
                        { loding();
                            delete_msg();
                        }
                        else if(r==2)
                        { loding();
                            set_msg("Not enough quatity to cancel");
                        }
                        else if(r==3)
                        { loding();
                            set_msg("Serial not available");
                        }
                        else
                        { loding();
                           set_msg(r);
                        }
                       
                    }, "text")
                }
            }
          
        }, "json")
  });


  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#3_"+get_id).focus();
  });


  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#3_"+scid).focus();
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


  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $("#save_chk").attr({title:"1",value:"1"});
      $("#pdf_id").val($(this).val());
      $(this).blur();
      $("#id").attr('readonly','readonly');
      load_data($(this).val());
    }
  });


  $("#from_store").change(function(){
    set_select("from_store","from_store_id");
    empty_grid();
  });
    
  $("#officer").change(function(){
    set_select("officer", "officer_id");
  });
     
  $("#to_store").change(function(){
    set_select("to_store","to_store_id");
    empty_grid();
  });
    
  $("#btnPrint").click(function(){
    $("#print_pdf").submit();
  });
     
  check_qty();
  
  $("#grid").tableScroll({height:355});
  
  $("#tgrid").tableScroll({height:300});
  

  $(".fo").keypress(function(e){
    set_cid($(this).attr("id"));
    if(e.keyCode==112){
              
      $("#pop_search").val($("#0_"+scid).val());
      load_items();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("select_search()", 100);
    }

    if(e.keyCode==13){
          $.post("index.php/main/load_data/t_damage_sum/get_item", {
              code:$("#0_"+scid).val(),
              stores:$("#from_store").val()
          }, function(res){
              if(res.a!=2){
                  $("#0_"+scid).val(res.a[0].item);

                      if(check_item_exist3($("#0_"+scid).val())){

                          if($("#df_is_serial").val()=='1'){
                            check_is_serial_item2(res.a[0].item,scid); 
                          }
                          check_is_batch_item2(res.a[0].item,scid); 

                          $("#h_"+scid).val(res.a[0].item);
                          $("#0_"+scid).val(res.a[0].item);
                          $("#1_"+scid).val(res.a[0].description);
                          $("#2_"+scid).val(res.a[0].batch_no);
                          $("#qtyh_"+scid).val(res.a[0].qty);
                          $("#3_"+scid).attr("placeholder",res.a[0].qty);
                          $("#3_"+scid).focus();
       
                          check_is_batch_item(scid);
                      }else{
                          set_msg("Item "+$("#0_"+scid).val()+" is already added.");
                      }
              }else{
                set_msg($("#0_"+scid).val()+" Item not available in stock", "error");
                $("#0_"+scid).val("");
              }
          }, "json");

        }


    if(e.keyCode==46){
      if($("#df_is_serial").val()=='1'){
        $("#all_serial_"+scid).val(""); 
      }
      $("#0_"+scid).val("");
      $("#1_"+scid).val(""); 
      $("#2_"+scid).val(""); 
      $("#3_"+scid).val("");
      $("#qtyh_"+scid).val(""); 
      $("#3_"+scid).attr("placeholder",""); 
      $("#btn_"+scid).css("display","none");
      $("#btnb_"+scid).css("display","none");
      $("#t_"+scid).html("&nbsp;");
      $("#subcode_"+scid).val("");
      $("#subcode_"+scid).removeAttr("data-is_click"); 
    }  
  });
      
  $("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items();
  }
});  

    $("#pop_search").gselect();

    $("#officer").autocomplete('index.php/main/load_data/t_dispatch_sum/auto_com', {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
        });
   

        $("#officer").keypress(function(e){
            if(e.keyCode == 13){
                set_cus_values($(this));
            }
        });
    
        $("#officer").blur(function(){
            set_cus_values($(this));
        });



    function formatItems(row){
        return "<strong> " +row[0] + "</strong> | <strong> " +row[1] + "</strong>";
    }

    function formatItemsResult(row){
        return row[0]+"|"+row[1];
    }


    function set_cus_values(f){
            var v = f.val();
            v = v.split("|");
             if(v.length == 2){
                f.val(v[0]);
                $("#officer_id").val(v[1]);
        }
    }

    $(".qun").blur(function(){
      set_cid($(this).attr("id"));
      is_sub_item(scid);
    });


});

function load_data9(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_employee",
        field:"code",
        field2:"name",
        preview2:"Employee Name",
        search : $("#pop_search11").val() 
    }, function(r){
        $("#sr11").html(r);
        settings9();            
    }, "text");
}

function settings9(){
    $("#item_list .cl").click(function(){        
        $("#officer").val($(this).children().eq(0).html());
        $("#officer_id").val($(this).children().eq(1).html());
        $("#pop_close11").click();                
    })    
}

function load_data8(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"r_groups",
        field:"code",
        field2:"name",
        preview2:"Group Name",
        search : $("#pop_search6").val() 
    }, function(r){
        $("#sr6").html(r);
        settings8();            
    }, "text");
}

function settings8(){
    $("#item_list .cl").click(function(){        
        $("#group_id").val($(this).children().eq(0).html());
        $("#group").val($(this).children().eq(1).html());
        $("#pop_close6").click();                
    })    
}

 
  function is_sub_item(x){
    sub_items=[];
    $("#subcode_"+x).val("");
    $.post("index.php/main/load_data/utility/is_sub_items", {
          code:$("#0_"+x).val(),
          qty:$("#3_"+x).val(),
          batch:$("#2_"+x).val()
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
        grid_qty:$("#3_"+x).val(),
        batch:$("#2_"+x).val(),
        hid:$("#hid").val(),
        store:$("#from_store").val(),
        trans_type:"13"
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



function select_search(){
    $("#pop_search").focus();
}

function empty_grid(){
    for(var i=0; i<25; i++){       
        $("#0_"+i).val("");       
        $("#1_"+i).val("");
        $("#2_"+i).val("");
        $("#3_"+i).val(""); 
        $("#qtyh_"+i).val(""); 
        $("#3_"+i).attr("placeholder","");  
        $("#subcode_"+i).val("");
        $("#subcode_"+i).removeAttr("data-is_click");      
    }
    $(".quns").css("display","none");
    $(".qunsb").css("display","none");
}


function select_search(){
    $("#pop_search").focus();
}

function save(){

  if($("#df_is_serial").val()=='1'){
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);
  }
  var frm = $('#form_');
  loding();
  $.ajax({
	type: frm.attr('method'),
	url: frm.attr('action'),
	data: frm.serialize(),
	success: function (pid){
            if(pid==5){
              set_msg('Please check the serial numbers');
            }else if(pid == 1){
              $("#btnSave").attr("disabled",true);
              loding();
              //sucess_msg();
              if(confirm("Save Completed, Do You Want A print?")){
                    if($("#is_prnt").val()==1){
                      $("#qno").val($("#id").val());
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
              loding();
              set_msg(pid);
            }
            
        }
    });
      if($("#df_is_serial").val()=='1'){
        serial_items.splice(0);
      }
}

$("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items();}
    });

$("#id").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            $("#id").attr("readonly","readonly");
            load_data($(this).val());
        }
    });

function load_items(){
  

    $.post("index.php/main/load_data/t_dispatch_sum/item_list_all", {
        search : $("#pop_search").val(),
        stores: $("#from_store").val()
    }, function(r){
        $("#sr").html(r);
        settings();
            
    }, "text");
}

function check_code(){
    var code = $("#0_0").val();
    if (code=="") {
        set_msg("Please Enter atleast one item");
    }
}



function settings(){                                                                                                
  $("#item_list .cl").click(function(){
     var qty=$(this).children().eq(3).html();

      if(qty<1)
      {
        set_msg("Item quantity not enough");
        return false;
      }
      else
      {
        if($(this).children().eq(0).html() != "&nbsp;"){   
          if($("#df_is_serial").val()=='1'){
            check_is_serial_item2($(this).children().eq(0).html(),scid);
          }
          check_is_batch_item2($(this).children().eq(0).html(),scid);

          $("#0_"+scid).val($(this).children().eq(0).html());
          $("#1_"+scid).val($(this).children().eq(1).html());
          $("#2_"+scid).val($(this).children().eq(2).html());
          $("#3_"+scid).val($(this).children().eq(3).html());
          $("#qtyh_"+scid).val(qty);
          $("#pop_close").click();
          $("#3_"+scid).focus();
          check_is_batch_item(scid); 
               
        }else{

          $("#customer_id").val("");
          $("#address").val("");
          $("#tp").val("");
          $("#email").val("");           
          $("#pop_close").click();
          $("#3_"+scid).focus();
        }     
      }
  });
}



function get_data_table(){
    $.post("/index.php/main/load_data/t_dispatch_sum/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}

function validate(){

  for(var t=0; t<25; t++){
    if($("#subcode_"+t).data("is_click")==1 && $("#subcode_"+t).val()==""){
      set_msg("Not enough sub items in ("+$("#0_"+t).val()+")" ,"error");
      return false;
    }
  }

    var code = $("#0_0").val();
    var save_chk = $("#save_chk").val();
    if (code==""||code==null || save_chk=="1") {
        set_msg("Invalid Operation.");
        return false;
    }
    else{
        return true;
    }    
}  

function set_delete(code){
    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/t_dispatch_sum", {
            code : code
        }, function(res){
            if(res == 1){
                get_data_table();
            }else if(res == 2){
                set_msg("No permission to delete data.");
            }else{
                set_msg("Item deleting fail.");
            }
            loding();
        }, "text");
    }
}

function is_edit($mod){
    $.post("index.php/main/is_edit/user_permissions/is_edit", {
        module : $mod
        
    }, function(r){
       if(r==1)
           {
             $("#btnSave").removeAttr("disabled", "disabled");
           }
       else{
             $("#btnSave").attr("disabled", "disabled");
       }
       
    }, "json");

}
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/t_dispatch_sum", {
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
function get_from_store(){
        $.post("/index.php/main/load_data/t_dispatch_sum/get_from_store",{},
            function(res){            
                 $("#from_store").html(res);
            },

            "text");


    }
function get_to_store(){
        $.post("/index.php/main/load_data/t_dispatch_sum/get_to_store",{},
            function(res){
                $("#to_store").html(res);

                      },

            "text");


    }

function load_data(id){
    var g=[];
    empty_grid();
    $.post("index.php/main/get_data/t_dispatch_note/", {
        id: id,
    }, function(r){

        if(r=="2"){
           set_msg("No records");
         }else{
             
             $("#id").val(id);
             $("#hid").val(id);
             $("#qno").val(id);
            
             $("#from_store").val(r.sum[0].store_from);
             set_select("from_store","from_store_id");

             $("#to_store").val(r.sum[0].store_to);
             set_select("to_store", "to_store_id");

             $("#officer").val(r.sum[0].officer);
             $("#officer_id").val(r.sum[0].name);

             $("#group_id").val(r.sum[0].group_sale_id);
             $("#group").val(r.sum[0].group_name);
            
             $("#ref_no").val(r.sum[0].ref_no);

             $("#action_date").val(r.sum[0].ddate);
             $("#memo").val(r.sum[0].memo);

             if(r.sum[0].is_cancel==1)
             {
              $("#form_").css("background-image", "url('img/cancel.png')");
              $("#btnDelete").attr("disabled", true);
              $("#btnSave").attr("disabled", true);
             }


             for(var i=0; i<r.det.length;i++){

                $("#0_"+i).val(r.det[i].code);
                $("#1_"+i).val(r.det[i].description);
                $("#2_"+i).val(r.det[i].batch_no);
                $("#3_"+i).val(r.det[i].qty);
                $("#itemcode_"+i).val(r.det[i].code);
                if($("#df_is_serial").val()=='1'){
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
                check_is_batch_item2(r.det[i].code,i);               
                is_sub_item(i);    
            }
         }  




            // if(r=="2"){
            //    set_msg("No records");
              
            // }else{
            // $("#id").val(id);
            // $("#hid").val(id);
            
            // $("#from_store").val(r.det[0].store_from);
            // set_select("from_store","from_store_id");

            // $("#to_store").val(r.det[0].store_to);
            // set_select("to_store", "to_store_id");


            // $("#officer").val(r.det[0].officer);
            // set_select("officer", "officer_id");

            // $("#ref_no").val(r.det[0].ref_no);
            // $("#action_date").val(r.det[0].action_date);
            // $("#memo").val(r.det[0].memo);
                                  
           
            // for(var i=0; i<r.det.length;i++){

            //     $("#0_"+i).val(r.det[i].item);
            //     $("#1_"+i).val(r.det[i].description);
            //     $("#2_"+i).val(r.det[i].batch_no);
            //     $("#3_"+i).val(r.det[i].dqty);               
                    
            // }



           
   // }

}, "json");
}





function get_max_no(){
    $.post("/index.php/main/load_data/t_dispatch_sum/get_max_no",{

    },function(res){
        $("#id").val(res);
max_no
    },'text');
}

function get_officer(){
        $.post("/index.php/main/load_data/t_dispatch_sum/get_officer",{},
            function(res){
                $("#officer").html(res);

                      },

            "text");


    }

function set_cus_values(f){
            var v = f.val();
            v = v.split("-");
            
                if(v.length == 2){
                //$("#vehicle_no").val(v[0]);
                f.val(v[0]);
                $("#customer_id").val(v[1]);
               // $("#customer_id").attr("class", "input_txt_f");
                var cus=$("#customer").val();
                $.post("index.php/main/load_data/t_dispatch_sum/load",
                {
                code:cus,
                },function(rs){
             
                 $("#address").val(rs.data.address1+", "+rs.data.address2+", "+rs.data.address3); 
                 input_active();
                 },"json");

        }
    }

function check_qty(){
        $(".chk").keypress(function(e){
            
            if(e.keyCode==13){
               set_cid($(this).attr("id"));
               var qty = $("#"+$(this).attr("id")).val();
               var item = $("#0_"+scid).val();
               $.post("/index.php/main/load_data/t_dispatch_sum/check_qty",{
                    item:item,
                    qty:qty
               },
               function(res){
                if(parseFloat(res.a[0].qty) < parseFloat(qty) ){
                    set_msg("quntity is insufficient");
                    $("#3_"+scid).focus();
                }
                else{
                    $("#amount_"+scid).val(parseFloat(qty) * parseFloat(res.a[0].purchase_price));
                    set_total2();
                    $("#0_"+parseInt(scid)).focus();                    

                }

               },"json");
            
             }            
     
    });
    }

function set_total2(){
    var t = tt = 0; 
    $(".g_amount").each(function(){;
        tt = parseFloat($(this).val());
        if(isNaN(tt)){ tt = 0;}
        t += tt;
    });
  $("#total2").val(m_round(t));
}


// function emptyElement(element) {
//     if (element == null || element == 0 || element.toString().toLowerCase() == 'false' || element == '')
//        return false;
//        else return true;
//   }
  
  
  
 
//  function load_serial_form(scid){
  
//      get_id=scid;
//      var serial_table="";
//      var serial_table2="";
//      $("#item_code").val($("#0_"+scid).val());
//      $("#item").val($("#1_"+scid).val());
//      $("#no").val($("#id").val());   
//      $("#qty,#quantity").val($("#3_"+scid).val()); 
//      //$("#type").val("13");    t_trans_code 1
//      $("#type").val("DISPATCH NOTE");
     
//      var count=parseInt($("#3_"+scid).val());
//      if($("#setserial_"+scid).val()=="1"){
//         loading_serial_items(scid);
//      }else{
//         var serial_table=serial_table2="";
//         for(x=0;x<count;x++){
//           if(x<10){var row_count="0"+x;}else{ var row_count=x;}
//             serial_table=serial_table+"<tr><td> "+row_count+" <input type='text' id='serial_"+x+"' class='g_input_txt srl_count' style='border:1px solid #000; width:150px;'/></td></tr>";
//             serial_table2=serial_table2+"<tr><td> "+row_count+" <input type='text' class='g_input_txt srl_count2' id='srl_"+x+"' style='border:1px solid #000; width:150px;'/></td></tr>";
//         }

//      $("#set_serial").html(serial_table);
//      $("#set_serial2").html(serial_table2);
//     }

//     seriall_items();
//       //display popup  
//      document.getElementById('light').style.display='block';
//      document.getElementById('fade').style.display='block';
// }


// function loading_serial_items(scid){
   
//     var serial_table="";
//     var serial_table2="";
//     var item_code=$("#0_"+scid).val();


//         if(parseInt($("#numofserial_"+scid).val())<=parseInt($("#3_"+scid).val())){
           
//              var y=0;
//              var num_of_qty=parseInt($("#3_"+scid).val());
//              serial_items.sort();
//              for(x=0;serial_items.length>x;x++){
//                 var get_code=serial_items[x].split("-")[0];
//                 if(get_code==item_code){
//                 var serial_code=serial_items[x].split("-")[1];
//                 if(y<10){var row_count="0"+y;}else{ var row_count=y;}
//                 serial_table=serial_table+"<tr><td> "+row_count+" <input type='text' id='serial_"+y+"' title='"+serial_code+"' value='"+serial_code+"' class='g_input_txt srl_count' style='border:1px solid #000; width:150px;'/></td></tr>";
//                 serial_table2=serial_table2+"<tr><td> "+row_count+" <input type='text' class='g_input_txt srl_count2' id='srl_"+y+"' style='border:1px solid #000; width:150px;'/></td></tr>";
//                 y++;
//                 }
//             }

//             var count=parseInt($("#3_"+scid).val())-parseInt($("#numofserial_"+scid).val());
             
//              for(x=0;count>x;x++){
//               if(y<10){var row_count="0"+y;}else{ var row_count=y;}
//                serial_table=serial_table+"<tr><td> "+row_count+" <input type='text' id='serial_"+y+"' class='g_input_txt srl_count' style='border:1px solid #000; width:150px;'/></td></tr>";
//                serial_table2=serial_table2+"<tr><td> "+row_count+" <input type='text' class='g_input_txt srl_count2' id='srl_"+y+"' style='border:1px solid #000; width:150px;'/></td></tr>"; 
//                y++;
//             }

//        }else{
//         serial_items.sort();
//         for(x=0;serial_items.length>x;x++){
//                 var get_code=serial_items[x].split("-")[0];
//                 if(get_code==item_code){
//                 var serial_code=serial_items[x].split("-")[1];
//                 if(x<10){var row_count="0"+x;}else{ var row_count=x;}
//                 serial_table=serial_table+"<tr><td> "+row_count+" <input type='text' id='serial_"+x+"' title='"+serial_code+"' value='"+serial_code+"' class='g_input_txt srlcd srl_count' style='border:1px solid #000; width:150px;'/><input type='button' title='Remove' value='Remove' style='width:75px;height:22px;border:1px solid #000;border-radius:0' class='removeSerial' id='removeSeri_"+x+"' /></td></tr>";
//                 serial_table2=serial_table2+"<tr><td> "+row_count+" <input type='text' class='g_input_txt srl_count2' id='srl_"+x+"' style='border:1px solid #000; width:150px;'/></td></tr>";
//                 }
//        }

//     }

//      $("#set_serial").html(serial_table);
//      $("#set_serial2").html(serial_table2);
// }


// function deleteSerial(scid){
//             var item_code= $("#itemcode_"+scid).val();
//             for(x=serial_items.length-1;x>=0;x--){
//                    var get_code=serial_items[x].split("-")[0];
//                    var serial_code=serial_items[x].split("-")[1];
//                   if(get_code==item_code){
//                     var cd=get_code+"-"+serial_code;
//                     var del=serial_items.indexOf(cd);
//                     serial_items.splice(del, 1);
//                   }
//             }

//             $("#numofserial_"+scid).removeAttr("title");
//             $("#numofserial_"+scid).removeAttr("value");
//             $("#setserial_"+scid).removeAttr("title");
//             $("#setserial_"+scid).removeAttr("value");
//             $("#itemcode_"+scid).removeAttr("value");
//             $("#itemcode_"+scid).removeAttr("title");

// }

// //{/serial}


// function check_is_serial_item(scid){
//     var item_code=$("#0_"+scid).val();
//     if(item_code!=""){
//      $.post("index.php/main/load_data/t_dispatch_note/check_is_serial_item",{
//             code:item_code,
//          },function(r){
//             if(r==1){
//               load_serial_form(scid);
//             }
//          },"text"); 
//    }
// }


// function insertSerial(x){   
//     var serial=x;
//     var check=$("#hid").val();
   
//     if(check=='0'){
//         $.post("index.php/main/load_data/t_dispatch_note/is_serial_available", {
//                serial:serial,
//                item:$("#item_code").val()
//             }, function(res){
//                   serial_window(res,x);
//         }, "text");

//     }else{
//         $.post("index.php/main/load_data/t_dispatch_note/is_serial_available", {
//                nno:$("#id").val(), 
//                serial:serial,
//                item:$("#item_code").val()
//             }, function(res){
                    
//                   serial_window(res,x);
//         }, "text");
//     }  
  

// }


// function serial_window(res,x){
      
//        var item_code=$("#item_code").val();
//        var count=$("#qty").val();
//        var serial=x; 
       


//         if(res==0){
//          set_msg("This "+serial+" no is not in stock."); 
//          serialWind=0;   
         
//         }else if(x==""){
//            set_msg("Please check the serial number 1");
           
//         }else if($(".srl_count").length !=count){
//            set_msg("Please check the serial number 2");
          
//         }else{
//            serial_items.push($("#item_code").val()+"-"+serial);
//            serialWind=1;
          
//         }

//          if($(".srl_count").length ==count && res==1){
//                    $("#clear").click();
//                    document.getElementById('light').style.display='none';
//                    document.getElementById('fade').style.display='none';
//                    $("#btnExit1").removeAttr("disabled");
//                   globalZ=0;
//         }

//          if(serialWind==0){
//            for(x=serial_items.length-1;x>=0;x--){
//                   var get_code=serial_items[x].split("-")[0];
//                   var serial_code=serial_items[x].split("-")[1];
//                   if(get_code==item_code){
//                     var cd=get_code+"-"+serial_code;
//                     var del=serial_items.indexOf(cd);
//                     serial_items.splice(del, 1);                  
//                   }
//             }

//            $(".srl_count").each(function(e){
//               if(e<count){
//                   if($("#serial_"+e).val()==""){
//                      set_msg("Please check the serial number");
//                   }else{
//                       if($("#serial_"+x).val()!=""){
//                           serial_items.push(item_code+"-"+$(this).val());
//                       } 
//                   }
//                }else{  
//                 set_msg("Please check the serial number");
//               }
//             });
//           load_serial_form(get_id);         
//          }

// }


// function seriall_items(){
//       $.post("index.php/main/load_data/t_dispatch_note/serial_item", {
//           search : $("#pop_search44").val(),
//           item:$("#item_code").val(),
//           stores :$("#from_store").val(),
//           batch_no:$("#2_"+get_id).val()
//       }, function(r){
//            $("#sr44").html(r);
//            $("#serial_item_list tr td input").focus();
//           settings4();
//       }, "text");
// }

// function settings4(){
//     $("#serial_item_list .cl").dblclick(function(){
//       var q =parseInt($("#qty").val());
//         if($(this).children().eq(0).html() != "&nbsp;"){
//             if(check_item_exist4($(this).children().eq(2).html())){
//                 var get=$(this).children().eq(2).html();
                
//                  for(var i=0; i<q ;i++){

//                     if($("#serial_"+i).val()==get)
//                       {
//                         //set_msg("Item "+row_value1+" is already added.");
//                         return false;
//                       }
//                     else if($("#serial_"+i).val()=="")
//                       {
//                         $("#serial_"+i).val(get);
//                         break;    
//                       }
//                   }


//                 //current_serial_no.value=get;
//                 $("#pop_close4").click();
//            }else{
//                set_msg("Serial "+$(this).children().eq(2).html()+" is already added.");
//            }
//         }else{
//              //current_serial_no.value="";
//             $("#pop_close4").click();

//         }
//     });
// }


//   function check_item_exist4(id){
//       var v = true;
//       $(".srl_count").each(function(){
//           if($(this).val() == id){
//               v = false;
//           }
//       });
      
//       return v;
//     }

function select_search4(){
    $("#pop_search4").focus();
}



function check_item_exist3(id){
    var v = true;
    return v;
}

function settings3(){
    $("#batch_item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist3($(this).children().eq(0).html())){
                $("#2_"+scid).val($(this).children().eq(0).html());
                $("#3_"+scid).val($(this).children().eq(1).html());
                $("#qtyh_"+scid).val($(this).children().eq(1).html());
               //$("#3_"+scid).val($(this).children().eq(2).html());
                $("#1_"+scid).attr("readonly","readonly");
                $("#3_"+scid).focus();
                          
                $("#pop_close3").click();
            }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#2_"+scid).val("");
           // $("#5_"+scid).val("");
            $("#3_"+scid).val("");
                discount();
                amount();
        
                gross_amount();
                privilege_calculation();
                all_rate_amount();
                net_amount();
            $("#pop_close3").click();
        }
    });
}


function load_items3(x){
    $.post("index.php/main/load_data/t_dispatch_note/batch_item", {
        search : x,
        stores : $("#from_store").val()
    }, function(r){
        $("#sr3").html(r);
        settings3();
    }, "text");
}

function select_search3(){
    $("#pop_search3").focus();
}

function check_is_batch_item(scid){

        var store=$("#from_store").val();
        $.post("index.php/main/load_data/t_dispatch_note/is_batch_item",{
            code:$("#0_"+scid).val(),
            store:store
         },function(res){
            
           if(res==1){
            $("#serch_pop3").center();
            $("#blocker3").css("display", "block");
            setTimeout("select_search3()", 100);
            load_items3($("#0_"+scid).val());
            } else if(res=='0'){
                $("#2_"+scid).val("0");
                $("#2_"+scid).attr("readonly","readonly");
            } else {
                //$("#2_"+scid).val(res.split("-")[0]);
                $("#5_"+scid).val(res.split("-")[1]);
                $("#bqty_"+scid).val(res.split("-")[1]);
                //$("#2_"+scid).attr("readonly","readonly");
           }
        },'text');
}

function check_is_batch_item2(x,scid){

        var store=$("#from_store").val();
        $.post("index.php/main/load_data/t_dispatch_note/is_batch_item",{
            code:x,
            store:store
         },function(res){
            $("#btnb_"+scid).css("display","none");  
          if(res==1){
            $("#btnb_"+scid).css("display","block");
          }
        },'text');
}



    

