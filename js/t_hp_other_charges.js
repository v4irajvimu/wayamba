$(document).ready(function(){


    $("#btnSave2").click(function(){
        $("#btnSave").attr("disabled", false);
    });


	$("#btnReset").click(function(){
		location.href="";
	});

     
    $("#tgrid").tableScroll({height:300});

    $("#agri_no").keypress(function(e){
        if(e.keyCode==112){
            $("#pop_search6").val($("#agri_no").val());
            load_agri();
            $("#serch_pop6").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search6').focus();", 100);     
        }
        if(e.keyCode==46){
            $("#agri_no").val("");
            $("#customer").val("");
            $("#customer_des").val("");
            $("#inv_no").val("");
            $("#inv_date").val("");
        }
        $("#pop_search6").keyup(function(e){
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                    load_agri();
                }
           });
    });


    $(".price").blur(function(){
        gross_amount();
    });


    $(".fo").keypress(function(e){
        set_cid($(this).attr("id"));
        if(e.keyCode==112){
            $("#pop_search").val($("#0_"+scid).val());
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
            $("#acc_"+scid).val("");
            $("#2_"+scid).val("");
            gross_amount();
        }
        $("#pop_search").keyup(function(e){
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                    load_items(scid);
                }
           });
    });

  
    $("#id").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            load_data($(this).val());
        }
    });

    $("#btnDelete").click(function(){
        set_delete();   
    });

    $("#btnPrint").click(function(){
        if($("#hid").val()=="0"){
          set_msg("Please load data before print","error");
          return false;
        }else{
          $("#print_pdf").submit();
        }
    });
});

function load_agri(){
    loding();
    var agr_no = $("#agreement_no").val();
    $.post("index.php/main/load_data/t_hp_other_charges/load_agreement_no", {
        search: $('#pop_search6').val()
    }, function (res) {
        if (res != 2) {
            $("#sr6").html(res);
            settings_agr_no();
        }
        loding();
    }, "text");
}

function settings_agr_no(){
    $("#item_list .cl").click(function(){        
        $("#agri_no").val($(this).children().eq(0).html());
        $("#customer").val($(this).children().eq(4).html());
        $("#customer_des").val($(this).children().eq(1).html());
        $("#inv_no").val($(this).children().eq(3).html());
        $("#inv_date").val($(this).children().eq(5).html());
        $("#pop_close6").click();                
    })    
}


function save(){
    $("#qno").val($("#id").val());
      
    var frm = $('#form_');
    loding();
    $.ajax({
	type: frm.attr('method'),
	url: frm.attr('action'),
	data: frm.serialize(),
	success: function (pid){
            if(pid == 1){
                $("#btnSave").attr("disabled",true);
                loding();
               if(confirm("Save Completed, Do You Want A print?")){
                    if($("#is_prnt").val()==1){
                        $("#print_pdf").submit();
                    }
                        location.href="";
                    }else{
                        location.href="";
                    }

               
            }else if(pid == 2){
                alert("No permission to add data.");
            }else if(pid == 3){
                alert("No permission to edit data.");
            }else{
                alert("Error : \n"+pid);
            }
            
        }
    });
}



function validate(){
    if($("#agri_no").val()==""){
        set_msg("Please enter agreement no");
    }else if($("#customer").val()==""){
        set_msg("Please enter customer no");
    }else if($("#net").val()=="" || $("#net").val()=="0.00"){
        set_msg("Net value can't be 0");
    }else{
        return true;
    }
}
    
function set_delete(){
    var code = $("#id").val();
    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/t_hp_other_charges", {
            code : code,
        }, function(res){
            if(res == 1){
               delete_msg();
            }else{
                set_msg(res);
            }
            loding();
        }, "text");
    }
}

    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/t_voucher_general", {
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
         loding(); 
         input_active();
    }, "json");
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

function load_items(scid){
      $.post("index.php/main/load_data/t_hp_other_charges/load_chargers", {
        search :$("#pop_search").val()
    }, function(r){
        $("#sr").html(r);
        settings2(scid);        
    }, "text");
}

function select_search(){
    $("#pop_search").focus();
   
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

function settings2(scid){
    $("#item_list .cl").click(function(){        
        if(check_item_exist($(this).children().eq(0).html())){  
            $("#h_"+scid).val($(this).children().eq(0).html());      
            $("#0_"+scid).val($(this).children().eq(0).html());
            $("#n_"+scid).val($(this).children().eq(1).html());
            $("#acc_"+scid).val($(this).children().eq(2).html());
            $("#2_"+scid).val($(this).children().eq(3).html());
            gross_amount();
            $("#pop_close").click();
        }else{
            set_msg("Chargers code ("+$(this).children().eq(1).html()+") is already added.");
        }
    });    
}

function gross_amount(){
    var gross=loop=0;
    $(".price").each(function(){
        var gs=parseFloat($("#2_"+loop).val());
        if(!isNaN(gs)){    
        gross=gross+gs;
        }    
        loop++;
    });
    $("#net").val(m_round(gross));
}

function empty_grid(){
    for(var i=0; i<25; i++){
        $("#h_"+i).val("");
        $("#0_"+i).val("");
        $("#n_"+i).val("");
        $("#1_"+i).val("");
        $("#2_"+i).val("");
    }
}

function load_data(id){
    loding();
    empty_grid();
    $.post("index.php/main/load_data/t_hp_other_charges/get_data", {
        id : id,
        type:$("#type").val()
    }, function(r){
        loding();
        if(r!="2"){
            $("#id").attr("readonly","readonly");
            $("#hid").val(r.sum[0].nno);
            $("#id").val(r.sum[0].nno);
            $("#qno").val(r.sum[0].nno);
            $("#agri_no").val(r.sum[0].agreement_no);
            $("#customer").val(r.sum[0].customer);
            $("#customer_des").val(r.sum[0].name);
            $("#inv_no").val(r.sum[0].inv_no);
            $("#inv_date").val(r.sum[0].inv_date);
            $("#date").val(r.sum[0].ddate);
            $("#ref_no").val(r.sum[0].ref_no);
            $("#net").val(r.sum[0].paid_amount);
            $("#note").val(r.sum[0].note);
            
            if(r.sum[0].is_cancel==1){           
                 $("#btnDelete").attr("disabled", true);
                 $("#btnSave").attr("disabled", true);
                 $("#mframe").css("background-image", "url('img/cancel.png')");
            }

            for(var i=0; i<r.det.length; i++){
                $("#h_"+i).val(r.det[i].chg_type);
                $("#0_"+i).val(r.det[i].chg_type);
                $("#n_"+i).val(r.det[i].des);
                $("#acc_"+i).val(r.det[i].acc_code);
                $("#1_"+i).val(r.det[i].description);
                $("#2_"+i).val(r.det[i].amount);
                gross_amount();
            }

        }
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