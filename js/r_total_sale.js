$(document).ready(function(){

    $(".cus").css('display', 'none');


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

    $('input:radio').click(function () {
     
        if($(this).val()=='r_total_sale_summary'){
            $(".cus").css('display', 'inline');

        }else{
            $(".cus").css('display', 'none');
        }
    });

    $("#cluster").change(function(){
        var path;
        var path_store;

        if($("#cluster").val()!=0)
        {
            path="index.php/main/load_data/r_total_sale/get_branch_name2";
        }
        else
        {
            path="index.php/main/load_data/r_total_sale/get_branch_name3";
        }

        $.post(path,{
            cl:$(this).val(),
        },function(res){
            $("#branch").html(res);
        },'text');  
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




    $("#cus").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search15").val($("#cus").val());
            load_customer();
            $("#serch_pop15").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search15').focus()", 100);
        }
        $("#pop_search15").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                load_customer()
            }
        }); 
        if(e.keyCode == 46){
            $("#cus").val("");
            $("#cus_des").val("");
        }
    });





    $("#emp").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search4").val($("#emp").val());
            load_data_emp();
            $("#serch_pop4").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search4').focus()", 100);
        }
        $("#pop_search4").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                load_data_emp()
            }
        }); 
        if(e.keyCode == 46){
            $("#emp").val("");
            $("#emp_des").val("");
        }
    });

    $("#item").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search12").val($("#item").val());
            load_data_item();
            $("#serch_pop12").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search12').focus()", 100);
        }
        $("#pop_search12").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                load_data_item()
            }
        }); 
        if(e.keyCode == 46){
            $("#item").val("");
            $("#item_des").val("");
        }
    });

    $("#cluster").val($("#d_cl").val());
    cl_change();
});

$("input[type='radio']").click(function(){
    var thId=$(this).attr("title");
    if(thId=='r_total_sale_gross_profit'){
        $(".emp").css("display","none");
    }else{
        $(".emp").css("display","block");
        $(".item").css("display","none");
    }
});

function load_data_emp(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_employee",
        field:"code",
        field2:"name",
        preview1:"Employee ID",
        preview2:"Employee Name",
        search : $("#pop_search4").val() 
    }, function(r){
        $("#sr4").html(r);
        settings_emp();            
    }, "text");
}

function settings_emp(){
    $("#item_list .cl").click(function(){        
        $("#emp").val($(this).children().eq(0).html());
        $("#emp_des").val($(this).children().eq(1).html());        
        $("#pop_close4").click();                
    })    
}


function load_data_item(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_item",
        field:"code",
        field2:"description",
        preview1:"Item Code",
        preview2:"Name",
        search : $("#pop_search12").val() 
    }, function(r){
        $("#sr12").html(r);
        settings_item();            
    }, "text");
}

function settings_item(){
    $("#item_list .cl").click(function(){        
        $("#item").val($(this).children().eq(0).html());
        $("#item_des").val($(this).children().eq(1).html());        
        $("#pop_close12").click();                
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

function load_customer(){
    $.post("index.php/main/load_data/r_total_sale/f1_selection_list_cus", {
        data_tbl:"m_customer",
        field:"code",
        field2:"name",
        field3:"nic",
        preview1:"Code",
        preview2:"Name",
        preview3:"nic",
        search : $("#pop_search15").val() 
    }, function(r){
        $("#sr15").html(r);
        settings_cus();            
    }, "text");
}

function settings_cus(){
    $("#item_list .cl").click(function(){        
        $("#cus").val($(this).children().eq(0).html());
        $("#cus_des").val($(this).children().eq(1).html());        
        $("#pop_close15").click();                
    })    
}

