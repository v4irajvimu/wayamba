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



    $("#supp").autocomplete("index.php/main/load_data/m_supplier/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#supp").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values5($(this));
    });
    $("#supp").blur(function() {
        set_cus_values5($(this));
    }); 

    $("#supp").keypress(function(e){ 
      if(e.keyCode==112){    
          $("#pop_search14").val($("#supp").val());
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
          $("#supp").val("");
          $("#supp_des").val("");
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
        $("#supp").val($(this).children().eq(0).html());
        $("#supp_des").val($(this).children().eq(1).html());
        $("#pop_close14").click();                
    })    
}


function set_cus_values5(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#supp_des").val(b[1]);
    }
}

function formatItems(a) {
    return "<strong> " + a[0] + "</strong> | <strong> " + a[1] + "</strong>";
}

function formatItemsResult(a) {
    return a[0] + "|" + a[1];
}
