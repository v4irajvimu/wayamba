$(document).ready(function(){


    $("#btnPrint").click(function(){
        $('#print_pdf').submit();
    });

    $("#no").keypress(function(e){

        if (e.keyCode == 13){

            $.post("index.php/main/load_data/t_change_due_day/load_data", {           
                no : $("#no").val()
            }, function (res) {

                if (res.a ==1){
                    $("#btn_Save,#set_preview").attr("disabled",true);
                    $("#agreement_no").val(res.sum.agr_no);
                    $("#customer_id").val(res.sum.cus_id);
                    $("#customer_name").val(res.sum.name);
                    $("#loan_date").val(res.sum.loan_date);
                    $("#no_of_installments").val(res.sum.noi);
                    $("#new_due_day").val(res.sum.new_due_day);
                    $("#date").val(res.sum.date);
                    $("#last_loan_c_date").val(res.sum.last_chge_date);                
                    $(".tbl_agr_list tfoot").html("").append(res.t);

                    $("#qno").val($("#no").val());

                }else{
                    alert("no data found");
                    location.href = "";
                }

            }, "json");

        }

    });


    $("#btn_Save").click(function(){
        save();
    });

    $("#btn_Reset").click(function(){

        $("#btn_Save,#set_preview").attr("disabled",false);
        location.href = "";

    });


    $("#set_preview").click(function(){

        if ($("#agreement_no").val() == ""){
            alert("Please select agreement number");
            return;
        }

        if ($("#new_due_day").val() == ""){
            alert("Please enter new due day");
            return;
        }

        if (isNaN($("#new_due_day").val())) { 
            var new_d = 0;
        }else{
            var new_d = parseInt($("#new_due_day").val());
        }
        
        if (new_d == 0){ alert("Invalid new due day"); return; }
        if (new_d > 31){ alert("Invalid new due day"); return; }
        if (new_d < 1){ alert("Invalid new due day"); return; }

        

        $.post("index.php/main/load_data/t_change_due_day/set_preview", {           
            new_due_day : $("#new_due_day").val(),
            agr_no : $("#agreement_no").val()
        }, function (res) {
            
            $(".tbl_agr_list tfoot").html("").append(res);

        }, "text");

    });



    $("#agreement_no").keypress(function(e){
       

        if(e.keyCode == 112){
            $("#pop_search6").val();
            if($("#multi_branch").is(":checked")){
                load_data_agr("m");
            }else{
                load_data_agr("s");
            }            
            $("#serch_pop6").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search6').focus()", 100);
        }

        $("#pop_search6").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                if($("#multi_branch").is(":checked")){
                    load_data_agr("m");
                }else{
                    load_data_agr("s");
                } 
            }
        });

        if(e.keyCode == 46){
            $("#agreement_no").val("");
            $("#customer").val("");
            $("#customer_id").val("");
            $("#ins_id").val("");
        }
    });


});

function load_data_agr(bc){
    loding();
    var agr_no = $("#agreement_no").val();
    $.post("index.php/main/load_data/t_hp_instalment_payment/load_agreement_no", {
        search: $('#pop_search6').val(),
        is_multi:bc
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
        
        $("#agreement_no").val($(this).children().eq(0).html());
        
        load_agr();

        
        
        
        
    })    
}

function load_agr(){

    $("#pop_close6").click();

    $.post("index.php/main/load_data/t_change_due_day/load_agreement", {
        agr_no : $("#agreement_no").val()
    }, function (res) {

        $("#customer_id").val(res.b.code);
        $("#customer_name").val(res.b.name);
        $("#loan_date").val(res.b.ddate);
        $("#no_of_installments").val(res.b.no_of_installments);
        $("#last_loan_c_date").val(res.c);

        var t = "";
        $(".tbl_agr_list tfoot").html("");

        for (no = 0 ; no < res.a.length ; no++){
            t += "<tr><td>"+res.a[no].ins_no+"</td><td>"+res.a[no].due_date+"</td><td></td></tr>";
        }
        
        $(".tbl_agr_list tfoot").append(t);

    }, "json");


    
}

function load_agri(){
    loding();
    
    $.post("index.php/main/load_data/t_hp_other_charges/load_agreement_no", {
        
    }, function (res) {
        
        loding();
    }, "text");
}

function save(){    
      
    var frm = $('#form_');
    loding();
    
    $.ajax({
	   type: frm.attr('method'),
	   url: frm.attr('action'),
	   data: frm.serialize(),
	   success: function (pid){
            alert("Due day changed");
            location.href = "";
       }
    });

}





  
