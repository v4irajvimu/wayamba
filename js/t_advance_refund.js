$(document).ready(function(){
  $("#tab").tabs();

  $("#btnPrint").click(function(){
   if($("#hid").val()=="0"){
    alert("Please load data before print");
    return false;
  }
  else{
    $("#print_pdf").submit();
  }
});

  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
      $("#qno").val($('#id').val());

    }
  });

   $("#rec_no").keypress(function(e) {
    if(e.keyCode==46){

      $("#rec_no").val("");
      $("#rec_no_des").val("");
      $("#ddate").val("");
      $("#cus_id").val(""); 
      $("#cus_name").val(""); 
      $("#cash_amo").val(""); 
      $("#credit").val(""); 
      $("#cheque").val("");
      $("#total").val(""); 

      for(var x=0; x<5; x++){
        $("#bank9_"+x).val(""); 
        $("#branch9_"+x).val(""); 
        $("#acc9_"+x).val("");
        $("#cheque9_"+x).val(""); 
        $("#amount9_"+x).val(""); 
        $("#date9_"+x).val("");
      }

      for(var y=0; y<5; y++){
        $("#type1_"+y).val(""); 
        $("#no1_"+y).val(""); 
        $("#amount1_"+y).val("");
        $("#1bank1_"+y).val(""); 
        $("#bank1_"+y).val(""); 
        $("#month1_"+y).val("");
        $("#rate1_"+y).val(""); 
        $("#amount_rate1_"+y).val(""); 
        $("#merchant1_"+y).val("");
        $("#acc1_"+y).val(""); 
      }

      for(var z=0; z<10; z++){
        $("#n_"+z).val(""); 
        $("#1_"+z).val(""); 
        $("#2_"+z).val("");
      }
      
    }
  });

  $("#btnReset").click(function(){
    location.href="?action=t_advance_payment";
  });
  
  $(".tgrid3").css("overflow","scroll").css("height","110px");
  $("#qno").val($('#id').val());


  $("#btnDelete").click(function(){

   if($("#hid").val()!=0) {
    set_delete($("#hid").val(),$("#cus_id").val(),$("#rec_no").val());
  }else{
    set_msg("Please load the record","error");
  }
});

  $("#rec_no").keypress(function(e){ 
    if(e.keyCode==112){
      $("#pop_search").val($("#rec_no").val());
      load_rec_no();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_rec_no();
      }
    });
    if(e.keyCode==46){
     $("#rec_no").val("");
     $("#customer_id").val("");
   }  
 });


});

function load_rec_no(){
  $.post("index.php/main/load_data/t_advance_refund/load_rece_details", {
    search : $("#pop_search").val() 
  }, function(r){
    $("#sr").html("");
    $("#sr").html(r);
    settings_rec();            
  }, "text");
}

function settings_rec(){
  $("#item_list .cl").click(function(){        
    $("#rec_no").val($(this).children().eq(0).html());
    $("#rec_no_des").val($(this).children().eq(1).html());
    $("#ddate").val($(this).children().eq(2).html());
    $("#cus_id").val($(this).children().eq(3).html());
    $("#cus_name").val($(this).children().eq(4).html());
    $("#cash_amo").val($(this).children().eq(5).html());
    $("#cheque").val($(this).children().eq(7).html());
    $("#credit").val($(this).children().eq(6).html());
    $("#total").val($(this).children().eq(8).html());
    $("#reciviedAmount").val($(this).children().eq(8).html());
    other_details($(this).children().eq(0).html(),$(this).children().eq(3).html()); 
    if($(this).children().eq(7).html()!='0.00'){
      load_cheque_details($(this).children().eq(0).html());
    }
    if($(this).children().eq(6).html()!='0.00'){
      load_credit_details($(this).children().eq(0).html());
    }
    $("#pop_close").click();                
  })    
}


function other_details(rece_no,cus_id){
  $.post("index.php/main/load_data/t_advance_refund/load_other_details", {
    rece_no:rece_no,
    cus_id:cus_id
  }, function(r){
    for(var x=0; x<r.a.length; x++){
      $("#n_"+x).val(r.a[x].nno);
      $("#1_"+x).val(r.a[x].ddate);
      $("#2_"+x).val(r.a[x].total_amount);
    }
  }, "json");
}


function load_cheque_details(nno){
  $.post("index.php/main/load_data/t_advance_refund/load_cheque_details", {
    rece_no:nno

  }, function(r){
    for(var x=0; x<r.b.length; x++){
      $("#bank9_"+x).val(r.b[x].bank);
      $("#branch9_"+x).val(r.b[x].branch);
      $("#acc9_"+x).val(r.b[x].account_no);
      $("#cheque9_"+x).val(r.b[x].cheque_no);
      $("#amount9_"+x).val(r.b[x].amount);
      $("#date9_"+x).val(r.b[x].cheque_date);
    }
  }, "json");
}

function load_credit_details(nno){
  $.post("index.php/main/load_data/t_advance_refund/load_credit_details", {
    rece_no:nno
  }, function(r){
    for(var x=0; x<r.c.length; x++){
     $("#type1_"+x).val(r.c[x].card_type);
     $("#no1_"+x).val(r.c[x].card_no);
     $("#amount1_"+x).val(r.c[x].amount);
     $("#1bank1_"+x).val(r.c[x].description);
     $("#bank1_"+x).val(r.c[x].bank_id);
     $("#month1_"+x).val(r.c[x].month);
     $("#rate1_"+x).val(r.c[x].rate);
     $("#amount_rate1_"+x).val(r.c[x].int_amount);
     $("#merchant1_"+x).val(r.c[x].merchant_id);
     $("#acc1_"+x).val(r.c[x].acc_code);
   }
 }, "json");
}

function set_delete(no,cus_id,rec_no){
  if(confirm("Are you sure delete "+no+"?")){
    loding();
    $.post("index.php/main/delete/t_advance_refund", {
      no : no,
      cus_id:cus_id,
      rec_no:rec_no
    }, function(res){
      if(res == 1){
        loding();
        delete_msg();
      }else if(res == 2){
        alert("No permission to delete data.");
      }else{
        loding();
        set_msg(res,"error");
      }

      
    }, "text");
  }
}


function save(){
  $("#dt").val($("#edate").val());
  $("#qno").val($('#id').val());
  $("#reciviedAmount").val($("#total").val());
  $("#cus_id_print").val($("#cus_id").val());
  var frm = $('#form_');
  loding();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (pid){
      if(pid == 1){
        loding();
        $("#btnSave").attr("disabled",true);
        $("#showPayments").attr("disabled",true);
        
                //$("#btnSavee").css("display","inline");

                if(confirm("Save Completed, Do You Want A print?")){
                  if($("#is_prnt").val()==1){
                    $("#print_pdf").submit();
                  }
                  setTimeout(function(){
                    location.href="";
                  }, 100);
                }else{
                 location.href="";
               }                 
             }else if(pid == 2){
              alert("No permission to add data.");
            }else if(pid == 3){
              alert("No permission to edit data.");
            }else{
              loding();
              set_msg(pid,"error");
            }
            
          }
        });
}


function load_data(id){

  loding();
  $.post("index.php/main/get_data/t_advance_refund/", {
    id: id
  }, function(r){
    if(r=="2"){
     alert("No records");
   }else{
    $("#hid").val(id); 
    $("#date").val(r.det[0].ddate); 
    $("#ddate").val(r.det[0].advance_date); 
    $("#ref_no").val(r.det[0].ref_no);
    $("#rec_no").val(r.det[0].receip_no);  
    $("#rec_no_des").val(r.det[0].description);
    $("#cus_id").val(r.det[0].acc_code);
    $("#cus_id_print").val(r.det[0].acc_code);
    $("#cus_name").val(r.det[0].name);
    $("#reciviedAmount").val(r.det[0].total_amount);
    $("#total").val(r.det[0].total_amount);
    $("#id").attr("readonly","readonly")  
    $("#cash_amo").val(r.det[0].cash_amount);
    $("#cheque").val(r.det[0].cheque_amount);
    $("#credit").val(r.det[0].card_amount);
    $("#btnSave").attr("disabled", true);
    $("#dt").val(r.det[0].ddate);

    other_details(r.det[0].receip_no,r.det[0].acc_code);
    load_cheque_details(r.det[0].receip_no);
    load_credit_details(r.det[0].receip_no);


    if(r.det[0].is_cancel=="1") {
     set_msg("Advance Refund Canceled","error");
     $("#mframe").css("background-image", "url('img/cancel.png')");
     $("#btnDelete").attr("disabled", true);
     $("#btnSave").attr("disabled", true);
   }         
   input_active();
   
 }
 loding();
}, "json");
}


function validate(){

  if($('#rec_no').val()==''){
    set_msg('Please Select Receipt No');
    return false;
  }
  return true;

}

