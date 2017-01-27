$(document).ready(function(){


 $("#cluster").change(function(){
  var path;
  var path_store;
  if($("#cluster").val()!=0)
  {
    path="index.php/main/load_data/r_transaction_list_cash/get_branch_name";
    $.post(path,{
      cl:$(this).val(),
    },function(res){
      $("#branch").html(res);
    },'text');  
  }
  else
  {
    $("#branch").html("<option value='0'>---</option>");
  }
});

 $("#btnPrint").click(function(){

  if($("input[type='radio']:checked").length == 0)
  {
    alert("Please select report");
    return false;
  }
  else
  {
    $("#print_pdf").submit();
  }
});

 $("#r_customer").keypress(function(e){
  if(e.keyCode == 112){
    $("#pop_search2").val($("#r_customer").val());
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
    $("#r_customer").val("");
    $("#r_customer_des").val("");
  }
});

 $("#item").keypress(function(e){ 
  if(e.keyCode==112){    
    $("#pop_search11").val($("#item").val());
    load_item();
    $("#serch_pop11").center();
    $("#blocker").css("display", "block");
    setTimeout("$('#pop_search11').focus()", 100);   
  }
  $("#pop_search11").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
      load_item();
    }
  });
  if(e.keyCode==46){
    $("#item").val("");
    $("#item_des").val("");
  }  
});

 $("#supplier").keypress(function(e){ 
  if(e.keyCode==112){    
    $("#pop_search14").val($("#supplier").val());
    load_supp();
    $("#serch_pop14").center();
    $("#blocker").css("display", "block");
    setTimeout("$('#pop_search14').focus()", 100);   
  }
  $("#pop_search14").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
      load_supp();
    }
  });
  if(e.keyCode==46){
    $("#supplier").val("");
    $("#supplier_des").val("");
  }  
});


});

function load_supp() {
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_supplier",
    field:"code",
    field2:"name",
    preview2:"Supplier Name",
    search : $("#pop_search14").val() 
  }, function(r){
    $("#sr14").html(r);
    settings_supp();      
  }, "text");
}

function settings_supp(){
  $("#item_list .cl").click(function(){        
    $("#supplier").val($(this).children().eq(0).html());
    $("#supplier_des").val($(this).children().eq(1).html());
    $("#pop_close14").click();                
  })    
}




function load_item() {
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_item",
    field:"code",
    field2:"description",
    preview2:"Item Name",
    search : $("#pop_search11").val() 
  }, function(r){
    $("#sr11").html(r);
    settings_item();      
  }, "text");
}

function settings_item(){
  $("#item_list .cl").click(function(){        
    $("#item").val($(this).children().eq(0).html());
    $("#item_des").val($(this).children().eq(1).html());
    $("#pop_close11").click();                
  })    
}


function load_data9(){
  $.post("index.php/main/load_data/utility/f1_selection_list_customer", {
    data_tbl:"m_customer",
    field:"code",
    field2:"name",
    field3:"nic",
    field4:"tp",
    preview1:"Customer ID",
    preview2:"Customer Name",
    preview3:"Customer NIC",
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html(r);
    settings9();            
  }, "text");
}

function settings9(){
  $("#item_list .cl").click(function(){        
    $("#r_customer").val($(this).children().eq(0).html());
    $("#r_customer_des").val($(this).children().eq(1).html());        
    $("#pop_close2").click();                
  })    
}