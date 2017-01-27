

$(document).ready(function(){

	$("#btnReset").click(function(){
		location.href="index.php?action=t_receipt_general";
	});

    $("#code").blur(function(){
        check_code();
    });
     
    $("#tgrid").tableScroll({height:300});


    $("#cash_acc").keypress(function(e){
        if(e.keyCode==112){
            $("#pop_search").val($("#cash_acc").val());
            load_data2();
            $("#serch_pop").center();
            $("#blocker").css("display", "block");
            setTimeout("select_search()", 100);     
        }
        $("#pop_search").keyup(function(e){
            
            load_data2();
            
        });
    });

     $(".fo").keypress(function(e){
    set_cid($(this).attr("id"));
    if(e.keyCode==112){
        $("#pop_search").val($("#cash_acc").val());
        load_items(scid);
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("select_search()", 100);     
    }
    if(e.keyCode==46){

        $("#h_"+scid).val("");
        $("#0_"+scid).val("");
        $("#n_"+scid).val("");
        $("#1_"+scid).val("");
        $("#2_"+scid).val("");

        gross_amount();
    }
    $("#pop_search").keyup(function(e){
        
        type = $("#type").val();
        $("#type2").val(type);
        load_items(scid);
        
    });
    });

    $(".amount").blur(function(){
    
        gross_amount();
        var tot = $("#net").val();

        if($("#type").val() == "cash"){

            $("#cash").val(tot);
        }
        if($("#type").val() == "chaque"){
           
            $("#cheque_issue").val(tot);
        }
        

    });

    
    $("#showPayments").click(function(){
      var net_value=parseFloat($("#net").val());
      payment_opt('t_voucher',m_round(net_value));
      // $("#cash").val(m_round(net_value+balance));
      // $("#save_status").val("0");
    });

});

function select_search(){
    $("#pop_search").focus();
   
}

function save(){
    var frm = $('#form_');
    loding();
    $.ajax({
	type: frm.attr('method'),
	url: frm.attr('action'),
	data: frm.serialize(),
	success: function (pid){
            if(pid == 1){
                input_reset();
                get_data_table();
            }else if(pid == 2){
                alert("No permission to add data.");
            }else if(pid == 3){
                alert("No permission to edit data.");
            }else{
                alert("Error : \n"+pid);
            }
            loding();
        }
    });
}

function settings2(){

    $("#item_list .cl").click(function(){

        if(check_item_exist($(this).children().eq(0).html())){
        
            $("#0_"+scid).val($(this).children().eq(0).html());
            $("#h_"+scid).val($(this).children().eq(0).html());
            $("#n_"+scid).val($(this).children().eq(1).html());
            $("#pop_close").click();
        }else{
            alert("Account code "+$(this).children().eq(1).html()+" is already added.");
        }
    });    
}

function load_items(scid){

      $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_account",
        field:"code",
        field2:"description",
        search : $("#0_"+scid).val() 
    }, function(r){
        

        $("#sr").html(r);
        settings2(scid);
        
    }, "text");
}

function settings(){
    $("#item_list .cl").click(function(){

        
        $("#cash_acc").val($(this).children().eq(0).html());
        $("#cash_acc_des").val($(this).children().eq(1).html());
        $("#pop_close").click();

        var acc_code = $(this).children().eq(0).html(); 

        $.post("index.php/main/load_data/utility/get_account_balance_voucher",{

            code : acc_code
        },   
        function(rs){
            $("#balance").val(rs); 
            input_active();
        },"json");
                
    });    
}

function get_data_table(){
    $.post("/index.php/main/load_data/t_receipt_general/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}


function load_data2(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {

        data_tbl:"m_account",
        field:"code",
        field2:"description",
        add_query : "AND control_acc NOT IN ((SELECT `acc_code` FROM `m_default_account` WHERE `code` = 'CREDITOR_CONTROL')  AND ((SELECT `acc_code` FROM `m_default_account` WHERE `code` = 'DEBTOR_CONTROL')))",
        search : $("#pop_search").val() 
    }, function(r){
        

        $("#sr").html(r);
        settings();
        
    }, "text");
}

function check_code(){
        loding();
    var code = $("#code").val();
    $.post("index.php/main/load_data/t_receipt_general/check_code", {
        code : code
    }, function(res){
        if(res == 1){
            if(confirm("This code ("+code+") already added. \n\n Do you need edit it?")){
                set_edit(code);
            }else{
                $("#code").val('');
		$("#code").attr("readonly", false);
            }
        }
        loding();
    }, "text");
}

function validate(){
    if($("#code").val() === $("#code").attr('title') || $("#code").val() == ""){
        alert("Please enter code.");
        $("#code").focus();
        return false;
    }else if($("#description").val() === $("#description").attr('title') || $("#description").val() == ""){
        alert("Please enter description.");
        $("#description").focus();
        return false;
    }else if($("#description").val() === $("#code").val()){
        alert("Please enter deferent values for description & code.");
        $("#des").focus();
        return false;
    }else{
        return true;
    }
}
    
function set_delete(code){
    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/t_receipt_general", {
            code : code
        }, function(res){
            if(res == 1){
                get_data_table();
            }else if(res == 2){
                alert("No permission to delete data.");
            }else{
                alert("Item deleting fail.");
            }
            loding();
        }, "text");
    }
}

function is_edit($mod)
{
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
    $.post("index.php/main/get_data/t_receipt_general", {
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

function check_item_exist(id){
    var v = true;
    $("input[type='hidden']").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });
    
    return v;
}

function gross_amount(){

    var gross=loop=0;

    $(".amount").each(function(){
        var gs=parseFloat($("#1_"+loop).val());
        if(!isNaN(gs)){    
        gross=gross+gs;
        }    
        loop++;
    });
    $("#net").val(m_round(gross));
   
}