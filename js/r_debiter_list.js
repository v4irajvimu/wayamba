$(document).ready(function(){
 $("#btnPrint").click(function(){	   	
   if($("input[type='radio']:checked").length == 0){
    alert("Please select report");
    return false;
  }
  else
  {
    $("#print_pdf").submit();
  }


});

 $("#cluster").change(function(){

  var path;

  if($("#cluster").val()!=0)
  {
    path="index.php/main/load_data/r_stock_report/get_branch_name2";
  }
  else
  {
    path="index.php/main/load_data/r_stock_report/get_branch_name3";
  }


  $.post(path,{
    cl:$(this).val(),
  },function(res){
    $("#branch").html(res);
  },'text');  

});

 $("#cus_id").keypress(function(e){ 
  if(e.keyCode==112){
    $("#pop_search2").val($("#cus_id").val());
    load_cus();
    $("#serch_pop2").center();
    $("#blocker2").css("display", "block");
    setTimeout("$('#pop_search2').focus()", 100);   
  }
  $("#pop_search2").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
      load_cus();
    }
  });
  if(e.keyCode==46){
   $("#cus_id").val("");
   $("#customer").val("");
   $("#cu_id").val("");
 }  
}); 

 $("#area_code").keypress(function(e){ 
  if(e.keyCode==112){
    $("#pop_search2").val($("#area_code").val());
    load_area();
    $("#serch_pop2").center();
    $("#blocker2").css("display", "block");
    setTimeout("$('#pop_search2').focus()", 100);   
  }
  $("#pop_search2").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
      load_area();
    }
  });
  if(e.keyCode==46){
   $("#area_code").val("");
   $("#area").val(""); 
   $("#are_id").val("");
 }  
});


 $("#cus_type").keypress(function(e){ 
  if(e.keyCode==112){
    $("#pop_search10").val($("#cus_type").val());
    load_cus_type();
    $("#serch_pop10").center();
    $("#blocker").css("display", "block");
    setTimeout("$('#pop_search10').focus()", 100);   
  }
  $("#pop_search10").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
      load_cus_type();
    }
  });
  if(e.keyCode==46){
   $("#cus_type").val("");
   $("#type").val(""); 
 }  
}); 


 $("#cus_category").keypress(function(e){
  if(e.keyCode == 112){
    $("#pop_search11").val($("#cus_category").val());
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
    $("#cus_category").val("");
    $("#category").val("");
  }
});

 $("#town_id").keypress(function(e){
  if(e.keyCode == 112){
    $("#pop_search12").val($("#town_id").val());
    load_data10();
    $("#serch_pop12").center();
    $("#blocker").css("display", "block");
    setTimeout("$('#pop_search12').focus()", 100);
  }

  $("#pop_search12").keyup(function(e){

    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
     load_data10();
   }
 }); 

  if(e.keyCode == 46){
    $("#town_id").val("");
    $("#town_name").val("");
  }
});


 $("#root_id").keypress(function(e){
  if(e.keyCode == 112){
    $("#pop_search13").val($("#root_id").val());
    load_data12();
    $("#serch_pop13").center();
    $("#blocker").css("display", "block");
    setTimeout("$('#pop_search13').focus()", 100);
  }

  $("#pop_search13").keyup(function(e){

    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
     load_data12();
   }
 }); 

  if(e.keyCode == 46){
    $("#root_id").val("");
    $("#root_name").val("");
  }
});

 $("#cluster").val($("#d_cl").val());
 cl_change();

});

function load_cus(){
  var br=$('#branch').val();
  var cl=$('#cluster').val();
  if(cl!="0"){
    var query="AND cl='"+cl+"'";
  }if(br!="0"){
    var query="AND bc='"+br+"'";
  }
  if(cl!="0" && br!="0"){
    var query="AND cl='"+cl+"'AND bc='"+br+"'";
  }
  $.post("index.php/main/load_data/utility/f1_selection_list_customer", {
    data_tbl:"m_customer",
    field:"code",
    field2:"name",
    field3:"nic",
    field4:"tp",
    add_query:query,
    preview2:"Customer Name",
    preview3:"NIC",
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html(r);
    settings_cus();     
  }, "text");
}

function settings_cus(){
  $("#item_list .cl").click(function(){        
    $("#cus_id").val($(this).children().eq(0).html());
    $("#customer").val($(this).children().eq(1).html());
    $("#cu_id").val($(this).children().eq(0).html());
    $("#pop_close2").click();                
  })    
}

function load_area(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"r_area",
    field:"code",
    field2:"description",
    preview2:"Supplier Name",
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html(r);
    settings_area();     
  }, "text");
}

function settings_area(){
  $("#item_list .cl").click(function(){        
    $("#area_code").val($(this).children().eq(0).html());
    $("#area").val($(this).children().eq(1).html());
    $("#are_id").val($(this).children().eq(0).html());
    $("#pop_close2").click();                
  })    
}

function load_cus_type(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"r_customer_type",
    field:"code",
    field2:"description",
    preview2:"Supplier Name",
    search : $("#pop_search10").val() 
  }, function(r){
    $("#sr10").html(r);
    settings_cus_type();     
  }, "text");
}

function settings_cus_type(){
  $("#item_list .cl").click(function(){        
    $("#cus_type").val($(this).children().eq(0).html());
    $("#type").val($(this).children().eq(1).html());
    $("#pop_close10").click();                
  })    
}

function load_data9(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"r_cus_category",
    field:"code",
    field2:"description",
    preview1:"Category ID",
    preview2:"Category Name",
    search : $("#pop_search11").val() 
  }, function(r){
    $("#sr11").html("");
    $("#sr11").html(r);
    settings9();            
  }, "text");
}

function settings9(){
  $("#item_list .cl").click(function(){        
    $("#cus_category").val($(this).children().eq(0).html());
    $("#category").val($(this).children().eq(1).html());   
    $("#pop_close11").click();                
  })    
}

function load_data10(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"r_town",
    field:"code",
    field2:"description",
    preview1:"Town ID",
    preview2:"Town Name",
    search : $("#pop_search12").val() 
  }, function(r){

    $("#sr12").html(r);
    settings10();            
  }, "text");
}

function settings10(){
  $("#item_list .cl").click(function(){        
    $("#town_id").val($(this).children().eq(0).html());
    $("#town_name").val($(this).children().eq(1).html());   
    $("#pop_close12").click();                
  })    
}

function load_data12(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"r_root",
    field:"code",
    field2:"description",
    preview1:"Root ID",
    preview2:"Root Name",
    search : $("#pop_search13").val() 
  }, function(r){
    $("#sr13").html(r);
    settings12();            
  }, "text");
}

function settings12(){
  $("#item_list .cl").click(function(){        
    $("#root_id").val($(this).children().eq(0).html());
    $("#root_name").val($(this).children().eq(1).html());   
    $("#pop_close13").click();                
  })    
}

function cl_change(){
  $("#store").val("");

  var path;
  var path_store;

  if($("#cluster").val()!=0)
  {
    path="index.php/main/load_data/r_stock_report/get_branch_name2";
    path_store="index.php/main/load_data/r_stock_report/get_stores_cl";
  }
  else
  {
    path="index.php/main/load_data/r_stock_report/get_branch_name3";
    path_store="index.php/main/load_data/r_stock_report/get_stores_default";
  }


  $.post(path,{
    cl:$("#cluster").val(),
  },function(res){
    $("#branch").html(res);
    $("#branch").val($("#d_bc").val());
  },'text');  


  $.post(path_store,{
    cl:$("#cluster").val(),
  },function(res){
    $("#store").html(res);
    $("#branch").val($("#d_bc").val());
  },'text');  
}