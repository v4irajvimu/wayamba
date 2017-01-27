var sub_cat;
var is_edit = 0;

$(function() {

    $(".chq_status").css("display","none");

    $("#brand").change(function() {
        set_select("brand", "brand_des");
    });
    $("#tgrid").tableScroll({
        height: 200
    });
    $("#item_gen").click(function() {
        generate_code();
    });
    $("#cluster").change(function() {
        $("#clusters").val($(this).val());
    });
    $("#branch").change(function() {
        $("#branchs").val($(this).val());
    });

    input_active();

    $("#cluster").val($("#d_cl").val());
    cl_change();

});

$(document).ready(function() {

    $("#btnExit").click(function(){
        return false;
    });

    $("#btnReset").click(function(){  //reset all values in the textboxes
      
        return false;
    });

$("#status_h").val("0");

//Bank Entry List
 $("#bank_entry_list").click(function(){
        $("#by").val("r_bank_entry");// model name
        $("#type").val("r_bank_entry"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","none");
        $("#ddate").css("display","none");
        $("#filter").css("display","none");
        $(".chq_status").css("display","none");
   });

 $("#pen_credit_crd_det").click(function(){
        $("#by").val("r_pending_credit_card");// model name
        $("#type").val("r_pending_credit_card"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","none");
        $("#ddate").css("display","none");
        $("#filter").css("display","none");
        $(".chq_status").css("display","none");
   });

   
   /*$("#cheque_return_list").click(function(){
        $("#by").val("r_cheque_return_list");// model name
        $("#type").val("r_cheque_return_list"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","none");
        $("#ddate").css("display","none");
   });
*/
    $("#r_cheque_in_hand").click(function(){
        $("#by").val("r_cheque_in_hand");// model name
        $("#type").val("r_cheque_in_hand"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","block");
        $("#ddate").css("display","block");
        $("#filter").css("display","block");
        $(".chq_status").css("display","none");

   });

     $("#r_issued_pending_cheque").click(function(){
        $("#by").val("r_issued_pending_cheque");// model name
        $("#type").val("r_issued_pending_cheque"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","block");
        $("#ddate").css("display","block");
        $("#filter").css("display","block");
        $(".chq_status").css("display","none");
   });

     $("#r_issued_cheque").click(function(){
        $("#by").val("r_issued_cheque");// model name
        $("#type").val("r_issued_cheque"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","block");
        $("#ddate").css("display","block");
        $("#filter").css("display","block");
        $(".chq_status").css("display","none");
   });

     $("#transaction_date").click(function(){

        $("#tran_dat").val("1");
        $("#realise_dat").val("0");
       
   });
     $("#realise_date").click(function(){
        $("#realise_dat").val("1");
        $("#tran_dat").val("0");
       
   });

    $("#status").change(function(){
        $("#status_h").val($("#status").val());

    });

    $("#chq_b_registry").click(function(){
        $(".chq_status").css("display","block");
        $("#by").val("r_chq_b_registry");// model name
        $("#type").val("r_chq_b_registry"); //tc pdf file name
        $("#acc_table").css("display","none");
        $("#trans_type").css("display","none");
        $("#account_c").css("display","none");
        $("#ddate").css("display","none");
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

    $("#print").click(function(){
        if($("#by").val()=="" ){
            set_msg("Please select report","error");
            return false;
        }else{
           $("#print_pdf").submit(); 
        }
    });    

    

    $("#cntrl_acc").blur(function() {
        set_cus_values3($(this));
    });
 
 $("#acc_code").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search11").val($("#acc_code").val());
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
            $("#acc_code").val("");
            $("#acc_code_des").val("");
        }
    });

});

function load_data9(){
    $.post("index.php/main/load_data/r_account_report/get_account", {
        data_tbl:"m_account",
        field:"code",
        field2:"description",
        preview2:"Account Name",
        search : $("#pop_search11").val() 
    }, function(r){
        $("#sr11").html(r);
        settings9();            
    }, "text");
}

function settings9(){
    $("#item_list .cl").click(function(){        
        $("#acc_code").val($(this).children().eq(0).html());
        $("#acc_code_des").val($(this).children().eq(1).html());
        $("#pop_close11").click();                
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







