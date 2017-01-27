$(document).ready(function(){

    $("#tgrid").tableScroll({height:250, width:1100});
   
    
   
    $("#btnResett").click(function(){
   	    location.href="";
    });

    $("#btnseettu_category").click(function(){
        location.href="?action=r_cus_category";
    });

    $("#btnDelete").click(function(){
        set_delete();
    });

    $("#id").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            load_data($(this).val());
            $(this).attr("readonly","readonly");
        }
    });

    $(".amount").blur(function(){
        amount_cal();
    })
    
    $("#btnPrint").click(function(){
        $("#print_pdf").submit();
    });

    $("#book_edition").keypress(function(e){
        if(e.keyCode == 112){
          $("#pop_search13").val($("#book_edition").val());
          load_book();
          $("#serch_pop13").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search13').focus()", 100);
        }
        $("#pop_search13").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_book();
          }
        }); 
        if(e.keyCode == 46){
          $("#book_edition").val("");
          $("#book_des").val("");
        }
    });

    $("#organizer_id").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search2").val($("#organizer_id").val());
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
            $("#organizer_id").val("");
            $("#organizer_name").val("");
            $("#address").val("");
        }
    });    

    $("#sales_rep_id").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search11").val($("#sales_rep_id").val());
            load_emp();
            $("#serch_pop11").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search11').focus()", 100);
        }
        $("#pop_search11").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_emp();
            }
        }); 
        if(e.keyCode == 46){
            $("#sales_rep_id").val("");
            $("#sales_rep_name").val("");
        }
    });    
       
    $(".cat").keypress(function(e){
        if($("#book_edition").val()!=""){
            set_cid($(this).attr("id"));
            if(e.keyCode == 112){
                $("#pop_search12").val($("#cat_"+scid).val());
                load_category();
                $("#serch_pop12").center();
                $("#blocker").css("display", "block");
                setTimeout("$('#pop_search12').focus()", 100);
            }
            $("#pop_search12").keyup(function(e){
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                     load_category();
                }
            }); 
            if(e.keyCode == 46){
                $("#h_"+scid).val("");
                $("#cat_"+scid).val("");
                $("#0_"+scid).val("");
                $("#2_"+scid).val("");
                $("#1_"+scid).val(""); 
                $("#2_"+scid).val(""); 
                $("#3_"+scid).val("");
                $("#4_"+scid).val("");  
                $("#5_"+scid).val("");
                $("#cathid_"+scid).val("");
                amount_cal();
            }
        }else{
            set_msg("please select book edition");
        }
    });      

    $(".fo").keypress(function(e){ 
        if($("#book_edition").val()!=""){
            set_cid($(this).attr("id"));
            if(e.keyCode==112){
                $("#pop_search").val($("#0_"+scid).val());
                load_items();
                $("#serch_pop").center();
                $("#blocker").css("display", "block");
                setTimeout("$('#pop_search').focus()", 100);
            }
            $("#pop_search").keyup(function(e){
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                    load_items();
                }
            });
            if(e.keyCode==13){
                $.post("index.php/main/load_data/t_settu/get_item", {
                    code:$("#0_"+scid).val()
                }, function(res){
                    if(res.a!=2){
                       // $("#h_"+scid).val(res.a[0].code);
                            if(check_item_exist($("#0_"+scid).val())){               
                                $("#h_"+scid).val(res.a[0].code);
                                $("#0_"+scid).val(res.a[0].code);                      
                                $("#2_"+scid).val(res.a[0].name);
                                $("#3_"+scid).val(res.a[0].amount);
                                $("#4_"+scid).val(res.a[0].no_int);
                                $("#5_"+scid).val(res.a[0].int_amount);             
                                $("#pop_close").click();                            
                                amount_cal();
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
                $("#2_"+scid).val("");
                $("#1_"+scid).val(""); 
                $("#2_"+scid).val(""); 
                $("#3_"+scid).val("");
                $("#4_"+scid).val("");  
                $("#5_"+scid).val("");
                amount_cal();
            }
        }else{
            set_msg("please select book edition");
        }
    });
 });/*end*/

function load_book(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_settu_book_edition",
      field:"code",
      field2:"description",
      preview2:"Edition Name",
      add_query:"AND is_active='1'",
      search : $("#pop_search13").val() 
  }, 
  function(r){
      $("#sr13").html(r);
      settings_book();        
  }, "text");
}

function settings_book(){
  $("#item_list .cl").click(function(){        
    $("#book_edition").val($(this).children().eq(0).html());
    $("#book_des").val($(this).children().eq(1).html());
    $("#pop_close13").click();                
  })    
}


function load_data9(){
    $.post("index.php/main/load_data/t_settu/load_orgernizer", {
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings9();            
    }, "text");
}

function settings9(){
    $("#item_list .cl").click(function(){        
        $("#organizer_id").val($(this).children().eq(0).html());
        $("#organizer_name").val($(this).children().eq(1).html());   
        $("#address").val($(this).children().eq(2).html());     
        $("#pop_close2").click();                
    })    
}


function load_category(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        search : $("#pop_search12").val(),
        data_tbl:"m_settu_item_category",
        field:"code",
        field2 :"name",
        preview1:"Code",
        preview2:"Name",
        hid_field:"ref_code",
        add_query:"AND book_edition='"+$("#book_edition").val()+"'"
    }, function(r){
        $("#sr12").html(r);
        settings_category();            
    }, "text");
}

function settings_category(){
    $("#item_list .cl").click(function(){   
        $("#cat_"+scid).val($(this).children().eq(0).html());
        $("#cathid_"+scid).val($(this).children().eq(2).find('input').val());
        $("#pop_close12").click();                
    })    
}

function load_emp(){
    $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        search : $("#pop_search11").val(),
        filter_emp_cat:"salesman"
    }, function(r){
        $("#sr11").html(r);
        settings_emp();            
    }, "text");
}

function settings_emp(){
    $("#item_list .cl").click(function(){        
        $("#sales_rep_id").val($(this).children().eq(0).html());
        $("#sales_rep_name").val($(this).children().eq(1).html());   
        $("#pop_close11").click();                
    })    
}


function load_items(){     
     $.post("index.php/main/load_data/t_settu/item_list_all", {
        search : $("#pop_search").val(),
        category : $("#cathid_"+scid).val(),
        book : $("#book_edition").val()
    }, function(r){
        $("#sr").html(r);
        settings();
    }, "text");
}



function settings(){
    $("#item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
            if(check_item_exist($(this).children().eq(0).html())){
                $("#h_"+scid).val($(this).children().eq(0).html());
                $("#0_"+scid).val($(this).children().eq(0).html());
                $("#2_"+scid).val($(this).children().eq(1).html());
                $("#3_"+scid).val($(this).children().eq(2).html());
                $("#4_"+scid).val($(this).children().eq(3).html());
                $("#5_"+scid).val($(this).children().eq(4).html());
                $("#pop_close").click();
                amount_cal();
            }else{
                set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
            }
        }else{
            $("#h_"+scid).val("");
            $("#0_"+scid).val("");
            $("#2_"+scid).val("");  
            $("#3_"+scid).val("");  
            $("#4_"+scid).val("");
            $("#5_"+scid).val(""); 
            $("#pop_close").click();
        }
    });
}

function amount_cal(){
    var tot_amount=parseFloat(0);
    var tot_ins=parseFloat(0);

    for(var x=0; x<25; x++){
       if($("#0_"+x).val()!="" && $("#3_"+x).val()!="" && $("#5_"+x).val()!=""){
        tot_amount+=parseFloat($("#3_"+x).val());
        tot_ins+=parseFloat($("#5_"+x).val());
       } 
    }
    $("#total_value").val(m_round(tot_amount));
    $("#installment").val(m_round(tot_ins));
}



function check_item_exist(id){
    var v = true;
    $(".fo").each(function(e){
        if($("#h_"+e).val() == id){
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

function validate(){
    if($("#organizer_id").val() == ""){
        set_msg("Please enter Orgenizer.");
        $("#organizer_id").focus();
        return false;
    }else if($("#sales_rep_id").val()==""){
        set_msg("Please enter Sales rep.");
        $("#sales_rep_id").focus();
        return false;
    }else if($("#total_value").val() =="0.00"){
        set_msg("Value can't be 0");
        return false;
    }else{
        return true;
    }
}

function save(){
    $("#qno").val($("#id").val())
    var frm = $('#form_');
        loding();
        $.ajax({
      type: frm.attr('method'),
      url: frm.attr('action'),
      data: frm.serialize(),
      success: function (pid){
        if(pid == 1){
            loding();
            $("#org_print").val("1");
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


function set_delete(){
    var id = $("#hid").val();
    if(id != 0){
        if(confirm("Are you sure to delete this settu ["+$("#hid").val()+"]? ")){
            $.post("index.php/main/delete/t_settu", {
            trans_no:id,
        },function(r){
          if(r != 1){
            set_msg(r);
          }else{
            delete_msg();
          }
        }, "text");
    }
  }else{
    set_msg("Please load record","error");
  }
}
    
function load_data(no){
   loding();
   
    $.post("index.php/main/get_data/t_settu", {
       no : no     
    }, function(res){
		   loding();
        if(res=="2"){
            set_msg("No records");
        }else{
            $("#id").val(no);
            $("#hid").val(no);
            $("#qno").val(no);
            $("#date").val(res.sum[0].ddate); 
            $("#ref_no").val(res.sum[0].ref_no);
            $("#book_no").val(res.sum[0].book_no);
            $("#organizer_id").val(res.sum[0].organizer);
            $("#organizer_name").val(res.sum[0].c_name);
            $("#address").val(res.sum[0].address1);
            $("#discription").val(res.sum[0].description);
            $("#sales_rep_id").val(res.sum[0].sales_rep);
            $("#sales_rep_name").val(res.sum[0].e_name);
            $("#total_value").val(res.sum[0].value_amount);
            $("#installment").val(res.sum[0].ins_total);
            $("#book_edition").val(res.sum[0].book_edition);
            $("#book_des").val(res.sum[0].b_name);
        
            for(var i=0; i<res.det.length;i++){
                $("#h_"+i).val(res.det[i].item_code);
                $("#0_"+i).val(res.det[i].item_code);
                $("#cat_"+i).val(res.det[i].settu_item_category);
                $("#2_"+i).val(res.det[i].name);
                $("#3_"+i).val(res.det[i].value);
                $("#4_"+i).val(res.det[i].no_ins);
                $("#5_"+i).val(res.det[i].ins_amount);
                $("#cathid_"+i).val(res.det[i].hidcat);
                amount_cal();   
            }
            if(res.sum[0].is_cancel==1){
                $("#btnDelete").attr("disabled", "disabled");
                $("#btnSave").attr("disabled", "disabled");
                $("#mframe").css("background-image", "url('img/cancel.png')");
            }
        }
    }, "json");
}