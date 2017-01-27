var sub_cat;

var is_edit = 0;

$(function() {
    
    $("#brand").change(function() {
        set_select("brand", "brand_des");
    });
    $("#sc").tableScroll({
        height: 200
    });
    $("#item_gen").click(function() {
        generate_code();
    });
    input_active();

    $("#cluster").val($("#d_cl").val());

    cl_change();

    


    //alert($("#d_bc").val());

    $("input[type='radio']").click(function(){

    var thId=$(this).attr("title");

    if(thId=='r_stock_in_hand_all_branch'){
        $("#MnTbl").find( "tr" ).hide();   
        $("#MnTbl").find( "tr" ).eq(6).show();
        $("#MnTbl").find( "tr" ).eq(6).find( "td" ).eq(3).hide();      
        $("#MnTbl").find( "tr" ).eq(6).find( "td" ).eq(4).hide();      
        $("#MnTbl").find( "tr" ).eq(6).find( "td" ).eq(5).hide();  
    } 
    else if(thId=='r_stock_in_hand_all_stores'){
        $("#MnTbl").find( "tr" ).hide();   
        $("#MnTbl").find( "tr" ).eq(6).show();
        $("#MnTbl").find( "tr" ).eq(6).find( "td" ).eq(3).hide();      
        $("#MnTbl").find( "tr" ).eq(6).find( "td" ).eq(4).hide();      
        $("#MnTbl").find( "tr" ).eq(6).find( "td" ).eq(5).hide();  
    }    
    else{
        $("#MnTbl").find( "tr" ).show();
        $("#MnTbl").find( "tr" ).find( "td" ).show();         
    } 

    });
   




     $("#item").click(function() {
        $(this).addClass("input_active");
        $("#main_category").removeClass("input_active");
        $("#sub_category").removeClass("input_active");
        $("#unit").removeClass("input_active");
        $("#supplier").removeClass("input_active");
    });

    $("#department").click(function() {
        $(this).addClass("input_active");
        $("#main_category").removeClass("input_active");
        $("#sub_category").removeClass("input_active");
        $("#unit").removeClass("input_active");
        $("#supplier").removeClass("input_active");
    });
    $("#main_category").click(function() {
        $(this).addClass("input_active");
        $("#department").removeClass("input_active");
        $("#sub_category").removeClass("input_active");
        $("#unit").removeClass("input_active");
        $("#supplier").removeClass("input_active");
    });
    $("#sub_category").click(function() {
        $(this).addClass("input_active");
        $("#department").removeClass("input_active");
        $("#main_category").removeClass("input_active");
        $("#unit").removeClass("input_active");
        $("#supplier").removeClass("input_active");
    });
    $("#unit").click(function() {
        $(this).addClass("input_active");
        $("#department").removeClass("input_active");
        $("#sub_category").removeClass("input_active");
        $("#main_category").removeClass("input_active");
        $("#supplier").removeClass("input_active");
    });
    $("#supplier").click(function() {
        $(this).addClass("input_active");
        $("#department").removeClass("input_active");
        $("#sub_category").removeClass("input_active");
        $("#main_category").removeClass("input_active");
        $("#unit").removeClass("input_active");
    });
    $("#department").focus(function() {
        $("#department").addClass("input_active");
    });

    $("#itm_lst").click(function() {

        $(".itemList_chk").css("display","block"); 
        $(".gr").css("display","none");  
        $(".dea").css("display","none");   

    });


$("#dealer_id").keypress(function(e){
      if(e.keyCode == 112){
        
          $("#pop_search14").val($("#dealer_id").val());
            load_dealer();
          /*load_data8();*/
          $("#serch_pop14").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search14').focus()", 100);
      }


     $("#pop_search14").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
              // load_data8();
              load_dealer()
          }
      }); 

      if(e.keyCode == 46){
          $("#dealer_id").val("");
          $("#dealer_des").val("");
      }
  });

  


     $("#item").keypress(function(a) {
        var b = a.keyCode || a.which;
        if (9 == b) {
            a.preventDefault();
            $("#main_category").focus();
            $("#department").removeClass("input_active");
            $("#main_category").addClass("input_active");
        }
        if (46 == b ){
            $("#item").val("");
            $("#item_des").val("");
        }
    });


    $("#department").keypress(function(a) {
        var b = a.keyCode || a.which;
        if (9 == b) {
            a.preventDefault();
            $("#main_category").focus();
            $("#department").removeClass("input_active");
            $("#main_category").addClass("input_active");
        }
        if (46 == b){
            $("#department").val("");
            $("#department_des").val("");
        }
    });
    $("#main_category").keypress(function(a) {
        var b = a.keyCode || a.which;
        if (9 == b) {
            a.preventDefault();
            $("#main_category").removeClass("input_active");
            $("#sub_category").addClass("input_active");
            $("#sub_category").focus();
        }
        if (46 ==b ){
            $("#main_category").val("");
            $("#main_category_des").val("");
        }
    });
    $("#sub_category").keypress(function(a) {
        var b = a.keyCode || a.which;
        if (9 == b) {
            a.preventDefault();
            $("#sub_category").removeClass("input_active");
            $("#unit").addClass("input_active");
            $("#unit").focus();
        }
        if (46 == b){
            $("#sub_category").val("");
            $("#sub_category_des").val("");
        }
    });
    $("#unit").keypress(function(a) {
        var b = a.keyCode || a.which;
        if (9 == b) {
            a.preventDefault();
            $("#unit").removeClass("input_active");
            $("#brand").addClass("input_active");
            $("#brand").focus();
        }
        if(46 == b){
            $("#unit").val("");
            $("#unit_des").val("");
        }
    });

   

    $("#brand").keypress(function(a){
        var b = a.keyCode || a.which;
        if (9 == b ){
            a.preventDefault();
            $("#brand").removeClass("input_active");
            $("#supplier").addClass("input_active");
            $("#supplier").focus();
        }
        if(46 == b){
            $("#brand").val("");
            $("#brand_des").val("");
        }
    });

    $("#supplier").keypress(function(a) {
        var b = a.keyCode || a.which;
        if (9 == b) {
            a.preventDefault();
            $("#supplier").removeClass("input_active");
            $("#supplier").focus();
        }
        if (46 ==b ){
            $("#supplier").val("");
            $("#supplier_des").val("");
        }
    });
});

$(document).ready(function() {




//$("#r_stock_in_hand").val("");
//$("#r_serial_in_hand").val("");
$("#r_stock_in_hand").click(function(){

 $("#by").val("r_stock_in_hand");
 $("#by").attr("title","r_stock_in_hand");
 $("#type").val("r_stock_in_hand");
 $("#type").attr("title","r_stock_in_hand");

});


$("#r_serial_in_hand").click(function(){

    $("#by").val("r_serial_in_hand");
    $("#by").attr("title","r_serial_in_hand");
    $("#type").val("r_serial_in_hand");
    $("#type").attr("title","r_serial_in_hand");
    $(".itemList_chk").css("display","none");  
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  
});

$("#r_stock_in_hand").click(function(){

    $("#by").val("r_stock_in_hand");
    $("#by").attr("title","r_stock_in_hand");
    $("#type").val("r_stock_in_hand");
    $("#type").attr("title","r_stock_in_hand");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");   

});

$("#r_batch_in_hand").click(function(){

    $("#by").val("r_batch_in_hand");
    $("#by").attr("title","r_batch_in_hand");
    $("#type").val("r_batch_in_hand");
    $("#type").attr("title","r_batch_in_hand");
    $(".itemList_chk").css("display","none");  
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});


$("#r_bin_card_stock").click(function(){
    $("#by").val("r_bin_card_stock");
    $("#by").attr("title","r_bin_card_stock");
    $("#type").val("r_bin_card_stock");
    $("#type").attr("title","r_bin_card_stock");
    $(".itemList_chk").css("display","none");  
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  
});

$("#r_stock_detail").click(function(){

    $("#by").val("r_stock_detail");
    $("#by").attr("title","r_stock_detail");
    $("#type").val("r_stock_detail");
    $("#type").attr("title","r_stock_detail");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_item_category").click(function(){
    $("#by").val("r_item_category");
    $("#by").attr("title","r_item_category");
    $("#type").val("r_item_category");
    $("#type").attr("title","r_item_category");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_item_department").click(function(){
    $("#by").val("r_item_department");
    $("#by").attr("title","r_item_department");
    $("#type").val("r_item_department");
    $("#type").attr("title","r_item_department");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_sub_item_category").click(function(){

    $("#by").val("r_sub_item_category");
    $("#by").attr("title","r_sub_item_category");
    $("#type").val("r_sub_item_category");
    $("#type").attr("title","r_sub_item_category");
    $(".itemList_chk").css("display","none");
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_stock_details").click(function(){

    $("#by").val("r_stock_details");
    $("#by").attr("title","r_stock_details");
    $("#type").val("r_stock_details");
    $("#type").attr("title","r_stock_details");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_po_qty_received").click(function(){

    $("#by").val("r_po_qty_received");
    $("#by").attr("title","r_po_qty_received");
    $("#type").val("r_po_qty_received");
    $("#type").attr("title","r_po_qty_received");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_po_status").click(function(){

    $("#by").val("r_po_status");
    $("#by").attr("title","r_po_status");
    $("#type").val("r_po_status");
    $("#type").attr("title","r_po_status");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  
});

$("#r_open_stock").click(function(){

    $("#by").val("r_open_stock");
    $("#by").attr("title","r_open_stock");
    $("#type").val("r_open_stock");
    $("#type").attr("title","r_open_stock");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_sub_item").click(function(){

    $("#by").val("r_sub_item");
    $("#by").attr("title","r_sub_item");
    $("#type").val("r_sub_item");
    $("#type").attr("title","r_sub_item");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#r_stock_in_hand_wo_zero").click(function(){

    $("#by").val("r_stock_in_hand_wo_zero");
    $("#by").attr("title","r_stock_in_hand_wo_zero");
    $("#type").val("r_stock_in_hand");
    $("#type").attr("title","r_stock_in_hand");
    $(".itemList_chk").css("display","none"); 
    $(".dea").css("display","inline"); 
    $(".gr").css("display","inline"); 
    $(".ex_td").css("display","none");  

});

$("#itm_lst").click(function(){
     $("#by").val("");
});

$("#item_lists").click(function(){

    $("#by").val("item_lists");
    $("#by").attr("title","item_lists");
    $("#type").val("item_lists");
    $("#type").attr("title","item_lists");

});

$("#r_item_list_prices").click(function(){

    $("#by").val("r_item_list_prices");
    $("#by").attr("title","r_item_list_prices");
    $("#type").val("r_item_list_prices");
    $("#type").attr("title","r_item_list_prices");

});

$("#r_sales_det").click(function(){

    $("#by").val("r_sales_det");
    $("#by").attr("title","r_sales_det");
    $("#type").val("r_sales_det");
    $("#type").attr("title","r_sales_det");

});

$("#r_item_sales").click(function(){

    $("#by").val("r_item_sales");
    $("#by").attr("title","r_item_sales");
    $("#type").val("r_item_sales");
    $("#type").attr("title","r_item_sales");

});




$("#r_stock_in_hand_all_branch").click(function(){

    $("#by").val("r_stock_in_hand_all_branch");
    $("#by").attr("title","r_stock_in_hand_all_branch");
    $("#type").val("r_stock_in_hand_all_branch");
    $("#type").attr("title","r_stock_in_hand_all_branch");

});

$("#r_stock_in_hand_all_stores").click(function(){

    $("#by").val("r_stock_in_hand_all_stores");
    $("#by").attr("title","r_stock_in_hand_all_stores");
    $("#type").val("r_stock_in_hand_all_stores");
    $("#type").attr("title","r_stock_in_hand_all_stores");


});


$("#branch").click(function(){
	if($("#cluster").val()=="0"){
		alert("Please select cluster");
		return false;
	}
});

$("#store").click(function(){
	if($("#cluster").val()=="0"){
		alert("Please select cluster");
		return false;
	}
});


$("#department").keypress(function(e){ 
    if(e.keyCode==112){
        $("#pop_search").val($("#department").val());
        load_dep();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_dep();
      }
    });
    if(e.keyCode==46){
        $("#department").val("");
        $("#department_des").val("");
    }  
});


$("#main_category").keypress(function(e){ 
    if(e.keyCode==112){
        $("#pop_search2").val($("#main_category").val());
        load_mcat();
        $("#serch_pop2").center();
        $("#blocker2").css("display", "block");
        setTimeout("$('#pop_search2').focus()", 100);   
    }
    $("#pop_search2").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_mcat();
      }
    });
    if(e.keyCode==46){
        $("#main_category").val("");
        $("#main_category_des").val("");
    }  
});

$("#sub_category").keypress(function(e){ 
    if(e.keyCode==112){    
        $("#pop_search10").val($("#sub_category").val());
        load_scat();
        $("#serch_pop10").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search10').focus()", 100);   
    }
    $("#pop_search10").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_scat();
      }
    });
    if(e.keyCode==46){
        $("#sub_category").val("");
        $("#sub_category_des").val("");
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


$("#unit").keypress(function(e){ 
    if(e.keyCode==112){    
        $("#pop_search12").val($("#unit").val());
        load_unit();
        $("#serch_pop12").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search12').focus()", 100);   
    }
    $("#pop_search12").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_unit();
      }
    });
    if(e.keyCode==46){
        $("#unit").val("");
        $("#unit_des").val("");
    }  
});

$("#brand").keypress(function(e){ 
    if(e.keyCode==112){    
        $("#pop_search13").val($("#brand").val());
        load_brand();
        $("#serch_pop13").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search13').focus()", 100);   
    }
    $("#pop_search13").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_brand();
      }
    });
    if(e.keyCode==46){
        $("#brand").val("");
        $("#brand_des").val("");
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

//sub_item key press event
$("#sub_item").keypress(function(e){ 
    if(e.keyCode==112){    
        $("#pop_search15").val($("#sub_item").val());
        load_sub_item();
        $("#serch_pop15").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search15').focus()", 100);   
    }
    $("#pop_search15").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_sub_item();
      }
    });
    if(e.keyCode==46){
        $("#sub_item").val("");
        $("#sub_item_des").val("");
    }  
});
//--------------------------------------------------------------------------------


	$("#branch").change(function(){
        br_change();

	});





	$("#cluster").change(function(){
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
	    cl:$(this).val(),
	    },function(res){
	    $("#branch").html(res);
	    },'text');	


	    $.post(path_store,{
	    cl:$(this).val(),
	    },function(res){
	    $("#store").html(res);
	    },'text');	
		
	});

    $("#print").click(function(){

        if($("#by").val()!=""){
             $("#print_pdf").submit(); 
        }else{
            
            alert("Please select report type");
            return false;
        }

        /*
        if($("#r_stock_in_hand").val()=="r_stock_in_hand" && $("#r_serial_in_hand").val()=="r_serial_in_hand"){
           $("#print_pdf").submit(); 
        }
        else{
             
             alert("Please select report type");
            return false; 
        }
        */
        //if($("#cluster").val()==0)
       // {
         //   alert("Please select cluster");
        //    return false;
        //}
        //else
        //{

           /* $("#print_pdf").submit(); */
        //}
        
        
    });    

    $("#btnExit").click(function(){
        return false;
    });


    $("#item").autocomplete("index.php/main/load_data/r_stock_report/auto_com_item", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#item").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values8($(this));
    });
    $("#item").blur(function() {
        set_cus_values8($(this));
    });

   
    $("#department").autocomplete("index.php/main/load_data/r_department/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#department").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values($(this));
    });
    $("#department").blur(function() {
        set_cus_values($(this));
    });
    $("#main_category").autocomplete("index.php/main/load_data/r_category/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#main_category").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values2($(this));
    });
    $("#main_category").blur(function() {
        set_cus_values2($(this));
    });
    $("#sub_category").autocomplete("index.php/main/load_data/r_sub_cat/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#sub_category").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values3($(this));
    });
    $("#sub_category").blur(function() {
        set_cus_values3($(this));
    });
    $("#unit").autocomplete("index.php/main/load_data/r_units/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#unit").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values4($(this));
    });
    $("#unit").blur(function() {
        set_cus_values4($(this));
    });
    $("#supplier").autocomplete("index.php/main/load_data/m_supplier/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#supplier").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values5($(this));
    });
    $("#supplier").blur(function() {
        set_cus_values5($(this));
    });
    $("#brand").autocomplete("index.php/main/load_data/r_brand/auto_com", {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });
    $("#brand").keypress(function(a) {
        if (13 == a.keyCode) set_cus_values6($(this));
    });
    $("#brand").blur(function() {
        set_cus_values6($(this));
    });




});

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
        br_change();        
        },'text');  




}

function br_change(){

        $("#store").val("");

        if($("#branch").val()!=0)
        {
            $.post("index.php/main/load_data/r_stock_report/get_stores_bc",{
            bc:$("#branch").val(),
            },function(res){
            $("#store").html(res);
            },'text'); 

        }
        else if($("#cluster").val()!="0")
        {
            $.post("index.php/main/load_data/r_stock_report/get_stores_cl",{
            cl:$("#cluster").val(),
            },function(res){
            $("#store").html(res);
            },'text'); 

        }
        else
        {
            $.post("index.php/main/load_data/r_stock_report/get_stores_default",{
            cl:$("#cluster").val(),
            },function(res){
            $("#store").html(res);
            },'text');  

        }


    }

function set_cus_values8(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#item_des").val(b[1]);
    }
}

function set_cus_values(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#department_des").val(b[1]);
    }
}

function set_cus_values2(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#main_category_des").val(b[1]);
    }
}

function set_cus_values3(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#sub_category_des").val(b[1]);
    }
}

function set_cus_values4(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#unit_des").val(b[1]);
    }
}

function set_cus_values5(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#supplier_des").val(b[1]);
    }
}

function set_cus_values6(a) {
    var b = a.val();
    b = b.split("|");
    if (2 == b.length) {
        a.val(b[0]);
        $("#brand_des").val(b[1]);
    }
}

function formatItems(a) {
    return "<strong> " + a[0] + "</strong> | <strong> " + a[1] + "</strong>";
}

function formatItemsResult(a) {
    return a[0] + "|" + a[1];
}


function select_search() {
    $("#pop_search").focus();
}


function default_option(){
   
    $.post("index.php/main/load_data/utility/default_option", {
  }, function(r){

            var store=r.def_sales_store;
            $('#store').val(store)
          //$("#store_id").val(r.store);
          
 }, "json");
}



function load_dep(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_department",
      field:"code",
      field2:"description",
      preview2:"Department Name",
      search : $("#pop_search").val() 
  }, function(r){
      $("#sr").html(r);
      settings_dep();      
 }, "text");
}

function settings_dep(){
    $("#item_list .cl").click(function(){        
        $("#department").val($(this).children().eq(0).html());
        $("#department_des").val($(this).children().eq(1).html());
        $("#pop_close").click();                
    })    
}

function load_mcat(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_category",
      field:"code",
      field2:"description",
      preview2:"Category Name",
      search : $("#pop_search2").val() 
  }, function(r){
      $("#sr2").html(r);
      settings_mcat();      
 }, "text");
}

function settings_mcat(){
    $("#item_list .cl").click(function(){        
        $("#main_category").val($(this).children().eq(0).html());
        $("#main_category_des").val($(this).children().eq(1).html());
        $("#pop_close2").click();                
    })    
}

function load_data8(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_customer",
        field:"code",
        field2:"nic",
        field3:"name",
        add_query:" AND is_guarantor='1'",
        preview2:"Nic",
        preview3:"Customer Name",
        search : $("#pop_search6").val() 
    }, function(r){
        $("#sr6").html(r);
        settings8();            
    }, "text");
}

function settings8(){
    $("#item_list .cl").click(function(){        
        $("#dealer_id").val($(this).children().eq(0).html());
        $("#dealer_des").val($(this).children().eq(1).html());
        $("#pop_close6").click();                
    })    
}

function load_scat(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_sub_category",
      field:"code",
      field2:"description",
      preview2:"Sub Category Name",
      search : $("#pop_search10").val() 
  }, function(r){
      $("#sr10").html(r);
      settings_scat();      
 }, "text");
}

function settings_scat(){
    $("#item_list .cl").click(function(){        
        $("#sub_category").val($(this).children().eq(0).html());
        $("#sub_category_des").val($(this).children().eq(1).html());
        $("#pop_close10").click();                
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


function load_unit() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_unit",
      field:"code",
      field2:"description",
      preview2:"Unit Name",
      search : $("#pop_search12").val() 
  }, function(r){
      $("#sr12").html(r);
      settings_unit();      
 }, "text");
}

function settings_unit(){
    $("#item_list .cl").click(function(){        
        $("#unit").val($(this).children().eq(0).html());
        $("#unit_des").val($(this).children().eq(1).html());
        $("#pop_close12").click();                
    })    
}

function load_brand() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_brand",
      field:"code",
      field2:"description",
      preview2:"Unit Name",
      search : $("#pop_search13").val() 
  }, function(r){
      $("#sr13").html(r);
      settings_brand();      
 }, "text");
}

function settings_brand(){
    $("#item_list .cl").click(function(){        
        $("#brand").val($(this).children().eq(0).html());
        $("#brand_des").val($(this).children().eq(1).html());
        $("#pop_close13").click();                
    })    
}


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

//sub Item F1 key function
function load_sub_item() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_sub_item",
      field:"code",
      field2:"description",
      preview2:"Sub Item Name",
      search : $("#pop_search15").val() 
  }, function(r){
      $("#sr15").html(r);
      settings_subItem();      
 }, "text");
}

//*-*-

function settings_subItem(){
    $("#item_list .cl").click(function(){        
        $("#sub_item").val($(this).children().eq(0).html());
        $("#sub_item_des").val($(this).children().eq(1).html());
        $("#pop_close15").click();                
    })    
}

function load_dealer(){//t_hp
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
        settings14();            
    }, "text");
}

function settings14(){
    $("#item_list .cl").click(function(){        
        $("#dealer_id").val($(this).children().eq(0).html());  
        $("#dealer_des").val($(this).children().eq(1).html());           
        $("#pop_close14").click();     
    })    
}


