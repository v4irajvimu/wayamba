$(document).ready(function () {
    var save_status=1;
    $("#view_more").click(function(){
        if($("#ins_id").val()!=""){

            var viwTx=$("#view_more").val();
            viwTx=(viwTx=="More >>>")?"More <<<":"More >>>";
            $("#view_more").val(viwTx);
            $( "#paymnt_his" ).slideToggle( "slow" );

        }else{
            set_msg("please load data before get more details");
        }
    });

    $("#fu_bal_ins").click(function(){
        load_gridFBI();
    });

    $("#oth_chg_dt").click(function(){
        window.open("?action=t_hp_other_charges","_blank"); 
    });

    $("#rebeat").click(function(){
        window.open("?action=t_hp_rebate","_blank"); 
    });

    $("#earl_setl").click(function(){
        window.open("?action=t_hp_early_settlement","_blank"); 
    });

    $("#agri_dt").click(function(){
        var ag_no=$("#ins_id").val();
        window.open("?action=t_hp&agNo="+ag_no,"_blank"); 
    });




    $("#view_bal").click(function(){
        if($("#agreement_no").val()!=""){
            $("#pop_search12").val();
            if($("#multi_branch").is(":checked")){
                balance_break_up("m");
            }else{
                balance_break_up("s");
            }
            $("#serch_pop12").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search12').focus()", 100);
        }else{
            set_msg("Please select agreement no");
        }
    });

    $("#id").keypress(function(e){
        if(e.keyCode==13){
            load_payment_option_data($("#id").val(),"66");
            set_edit($(this).val());
        }
    });

    $("#btnPrint").click(function(){
        $("#print_pdf").submit();
    });

    $("#pay_his_rprt").click(function(){
        $("#print_pdf2").submit();
    });
    
    $("#btnDelete").click(function(){
        if($("#hid").val()!="0"){
            set_delete($("#id").val());
        }else{
            set_msg("please load data before delete");
        }
    });
    
    $(".tt").keyup(function(){
        var pay = parseFloat($("#net2").val());
        var rebeat = parseFloat($("#rebeat_tot").val());
        var total = parseFloat(0);
        if(!isNaN(pay)){
            total+=pay;
        }
        $("#net").val(m_round(total));
        clear_instalment();
        pay_instalment();
        setTimeout("calculate_tot();", 200);
    });

    $("#rebeat_tot").keypress(function(e){
        if($("#net").val()==""){
            if(e.keyCode==112){
                $("#pop_search13").val();
                load_rebeat();
                $("#serch_pop13").center();
                $("#blocker").css("display", "block");
                setTimeout("$('#pop_search13').focus()", 100);
            }
            $("#pop_search13").keyup(function(e){            
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                   load_rebeat();
               }
           }); 
        }else{
            set_msg("Paid amount shuld be empty for add rebeat. ");
        }
        if(e.keyCode == 46){
            $("#rebeat_tot").val("");
            $("#rebeat_capital").val("");
            $("#rebeat_interest").val("");
            $("#rebeat_panelty").val("");
            $("#rebeat_other").val("");

            $(".ins").each(function(e){
                $("#rebeat_"+e).val("0.00");
            });
            pay_instalment();
            setTimeout("calculate_tot();", 200);
        }
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

    $("#officer").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search6").val( $("#officer").val());
            load_col_officer();
            $("#serch_pop15").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search15').focus()", 100);
        }
        $("#pop_search15").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
             load_col_officer();
         }
     }); 
        if(e.keyCode == 46){
            $("#officer").val("");
            $("#officer_des").val("");
        }
    });

    $("#tabs").tabs();
    $("#tabs2").tabs();

    $("#btnReset").click(function() {
        location.href = '';
    });

    $("#showPayments").click(function(){
        payment_opt('t_credit_sales_sum',$("#net").val());
        if($("#hid").val()=="0" && $("#cheque_recieve").val()=="" && $("#credit_card").val()==""){
            $("#cash").val($("#net").val());        
        }
        $("#save_status").val("0");
    });

    $("#pay_his").click(function() {
       load_grid();
       
   });

    //$("#paymnt_his").css("display","none");

});

function load_grid(){ 

    $.post("index.php/main/load_data/t_hp_instalment_payment/load_grid", {
        agr_no:$("#agreement_no").val(),
    }, function(r){
        if(r=="2"){         
            set_msg("No records");
        }else{
            var tbl="<tr><td>Reciept Date</td>";
            tbl+="  <td>Reciept No</td>";
            tbl+="  <td>Reciept Amount</td> ";                
            tbl+="</tr>";
            for(var x=0; x<r.load.length; x++){
               
                tbl+="<tr>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' value='"+r.load[x].ddate+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' readonly='readonly'value='"+r.load[x].nno+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:Right;' readonly='readonly'value='"+r.load[x].paid_amount+"'/></td>";
                tbl+="</tr>";                
            }

            $("#tbl_tbdy").html(tbl);
            $("#tl_Nme").text("Payments History");            
        }
    }, "json");  

}


function load_gridFBI(){ 

    $.post("index.php/main/load_data/t_hp_instalment_payment/load_gridFBI", {
        ins_id:$("#agreement_no").val(),
    }, function(r){
        if(r=="2"){         
            set_msg("No records");
        }else{
            var tbl="<tr><td>No</td>";
            tbl+="  <td>Ins. No</td>";
            tbl+="  <td>Due Date</td>";
            tbl+="  <td>Amount</td> ";                
            tbl+="</tr>";
            for(var x=0; x<r.load.length; x++){
               
                tbl+="<tr>";
                tbl+="<td><input type='text' class='g_input_amo g_col_fixed' style='width : 100%;text-align:left;' value='"+(x+1)+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' value='"+r.load[x].ins_no+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' readonly='readonly'value='"+r.load[x].due_date+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:Right;' readonly='readonly'value='"+r.load[x].ins_amount+"'/></td>";
                tbl+="</tr>";                
            }

            $("#tbl_tbdy").html(tbl);
            $("#tl_Nme").text("Future Balance Instalment");            
        }
    }, "json");  

}




function load_col_officer(){
    $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        filter_emp_cat:"c_officer",
        search : $("#pop_search15").val() 
    }, function(r){
        $("#sr15").html(r);
        settings_officer();            
    }, "text");
}

function settings_officer(){
    $("#item_list .cl").click(function(){        
        $("#officer").val($(this).children().eq(0).html());
        $("#officer_des").val($(this).children().eq(1).html());
        $("#pop_close15").click();                
    })    
}


function rebeat_settle(){    
    var paid=parseFloat(0);
    var s_bal=0;
    var t_amnt=parseFloat(0);   
    
    $(".ins").each(function(e){ 
        $("#rebeat_"+e).val("0.00");
    });

    if(m_round($("#rebeat_capital").val())!="0.00"){
        s_bal=paid=parseFloat($("#rebeat_capital").val());

        $(".ins").each(function(e){ 
            if($("#rcode_"+e).val()=="1"){
                var bal = paid - parseFloat($("#balance_"+e).val());
                var amount = parseFloat($("#balance_"+e).val());
                var balance = parseFloat($("#balance_"+e).val());

                t_amnt += parseFloat($("#balance_"+e).val());
                
                if(e==0){  
                    if(bal>=0){     
                    //$("#balance_"+e).val("0.00");
                    $("#rebeat_"+e).val(m_round(amount)); 
                    s_bal = bal;      
                }else{
                    if(amount>=bal){             
                        //$("#balance_"+e).val(m_round(Math.abs(bal)));
                        $("#rebeat_"+e).val(m_round(paid));
                        return false;
                    }
                }            
            }else{
                if(s_bal>=0){
                    if(amount<=s_bal){             
                        //$("#balance_"+e).val("0.00");
                        $("#rebeat_"+e).val(m_round(amount));
                        s_bal = s_bal - amount; 
                    }else{
                        //$("#balance_"+e).val(m_round(amount-s_bal));
                        $("#rebeat_"+e).val(m_round(s_bal));
                        s_bal = balance; 
                        return false;
                    } 
                } 
            }
            paid = bal;
        }
    });
    }  
    

    if(m_round($("#rebeat_interest").val())!="0.00"){
        s_bal=paid=parseFloat($("#rebeat_interest").val());

        $(".ins").each(function(e){ 
            if($("#rcode_"+e).val()=="2"){
                var bal = paid - parseFloat($("#balance_"+e).val());
                var amount = parseFloat($("#balance_"+e).val());
                var balance = parseFloat($("#balance_"+e).val());

                t_amnt += parseFloat($("#balance_"+e).val());
                
                if(e==0){  
                    if(bal>=0){     
                    //$("#balance_"+e).val("0.00");
                    $("#rebeat_"+e).val(m_round(amount)); 
                    s_bal = bal;      
                }else{
                    if(amount>=bal){             
                        //$("#balance_"+e).val(m_round(Math.abs(bal)));
                        $("#rebeat_"+e).val(m_round(paid));
                        return false;
                    }
                }            
            }else{
                if(s_bal>=0){
                    if(amount<=s_bal){             
                        //$("#balance_"+e).val("0.00");
                        $("#rebeat_"+e).val(m_round(amount));
                        s_bal = s_bal - amount; 
                    }else{
                        //$("#balance_"+e).val(m_round(amount-s_bal));
                        $("#rebeat_"+e).val(m_round(s_bal));
                        s_bal = balance; 
                        return false;
                    } 
                } 
            }
            paid = bal;
        }
    });
    } 
    
    if(m_round($("#rebeat_panelty").val())!="0.00"){
        s_bal=paid=parseFloat($("#rebeat_panelty").val());

        $(".ins").each(function(e){ 
            if($("#rcode_"+e).val()=="3"){
                var bal = paid - parseFloat($("#balance_"+e).val());
                var amount = parseFloat($("#balance_"+e).val());
                var balance = parseFloat($("#balance_"+e).val());

                t_amnt += parseFloat($("#balance_"+e).val());
                
                if(e==0){  
                    if(bal>=0){     
                    //$("#balance_"+e).val("0.00");
                    $("#rebeat_"+e).val(m_round(amount)); 
                    s_bal = bal;      
                }else{
                    if(amount>=bal){             
                        //$("#balance_"+e).val(m_round(Math.abs(bal)));
                        $("#rebeat_"+e).val(m_round(paid));
                        return false;
                    }
                }            
            }else{
                if(s_bal>=0){
                    if(amount<=s_bal){             
                        //$("#balance_"+e).val("0.00");
                        $("#rebeat_"+e).val(m_round(amount));
                        s_bal = s_bal - amount; 
                    }else{
                        //$("#balance_"+e).val(m_round(amount-s_bal));
                        $("#rebeat_"+e).val(m_round(s_bal));
                        s_bal = balance; 
                        return false;
                    } 
                } 
            }
            paid = bal;
        }
    });
    } 

    if(m_round($("#rebeat_other").val())!="0.00"){
        s_bal=paid=parseFloat($("#rebeat_other").val());

        $(".ins").each(function(e){ 
            if($("#rcode_"+e).val()=="4"){
                var bal = paid - parseFloat($("#balance_"+e).val());
                var amount = parseFloat($("#balance_"+e).val());
                var balance = parseFloat($("#balance_"+e).val());

                t_amnt += parseFloat($("#balance_"+e).val());
                
                if(e==0){  
                    if(bal>=0){     
                    //$("#balance_"+e).val("0.00");
                    $("#rebeat_"+e).val(m_round(amount)); 
                    s_bal = bal;      
                }else{
                    if(amount>=bal){             
                        //$("#balance_"+e).val(m_round(Math.abs(bal)));
                        $("#rebeat_"+e).val(m_round(paid));
                        return false;
                    }
                }            
            }else{
                if(s_bal>=0){
                    if(amount<=s_bal){             
                        //$("#balance_"+e).val("0.00");
                        $("#rebeat_"+e).val(m_round(amount));
                        s_bal = s_bal - amount; 
                    }else{
                        //$("#balance_"+e).val(m_round(amount-s_bal));
                        $("#rebeat_"+e).val(m_round(s_bal));
                        s_bal = balance; 
                        return false;
                    } 
                } 
            }
            paid = bal;
        }
    });
    } 
}


function pay_instalment(){    
    var paid=parseFloat($("#net").val());
    var s_bal=0;
    var t_amnt=parseFloat(0);   
    
    $(".ins").each(function(e){ 
        $("#paid_"+e).val("0.00");
        //$("#balance_"+e).val("0.00");
    });

    $(".ins").each(function(e){ 
        var bal = paid - parseFloat($("#balance_"+e).val()) + parseFloat($("#rebeat_"+e).val());
        var amount = parseFloat($("#balance_"+e).val()) - parseFloat($("#rebeat_"+e).val());
        var balance = parseFloat($("#balance_"+e).val());

        t_amnt += parseFloat($("#balance_"+e).val());
        if(e==0){  
            if(bal>=0){     
                //$("#balance_"+e).val("0.00");
                $("#paid_"+e).val(m_round(amount)); 
                s_bal = bal;      
            }else{
                if(amount>=bal){             
                    //$("#balance_"+e).val(m_round(Math.abs(bal)));
                    $("#paid_"+e).val(m_round(paid));
                    return false;
                }
            }            
        }else{
            if(s_bal>=0){
                if(amount<=s_bal){             
                    //$("#balance_"+e).val("0.00");
                    $("#paid_"+e).val(m_round(amount));
                    s_bal = s_bal - amount; 
                }else{
                    //$("#balance_"+e).val(m_round(amount-s_bal));
                    $("#paid_"+e).val(m_round(s_bal));
                    s_bal = balance; 
                    return false;
                } 
            } 
        }
        paid = bal;
    });
    /*var total_pay = parseFloat($("#net").val())+parseFloat($("#rebeat_tot").val());
    if(t_amnt < parseFloat(total_pay)){
        $("#exceed_amount").val(m_round(parseFloat(total_pay)- t_amnt));
    }*/
}

function calculate_tot(){

    var balance_tot = parseFloat(0);
    var paid_tot = parseFloat(0);
    var settle_tot = parseFloat(0);
    var rebeat_tot = parseFloat(0);

    for(var e=0; e<$("#grid_tot").val(); e++){
       
        settle = parseFloat($("#rebeat_"+e).val()) + parseFloat($("#paid_"+e).val());
        $("#settle_"+e).val(m_round(settle));
        balance_tot += parseFloat($("#balance_"+e).val());
        rebeat_tot += parseFloat($("#rebeat_"+e).val());
        paid_tot += parseFloat($("#paid_"+e).val());
        settle_tot += parseFloat($("#settle_"+e).val());
    }

    $("#bal_tot").html(m_round(balance_tot));
    $("#re_tot").html(m_round(rebeat_tot));
    $("#paid_tot").html(m_round(paid_tot));
    $("#settle_tot").html(m_round(settle_tot));

    $("#exceed_amount").val("0.00");

    if($("#rebeat_tot").val()==""){
        $("#rebeat_tot").val("0.00")
    }
    if($("#net").val()==""){
        $("#net").val("0.00")
    }

    if(parseFloat(settle_tot)<(parseFloat($("#rebeat_tot").val())+parseFloat($("#net").val()))){
        var difference=(parseFloat($("#rebeat_tot").val())+parseFloat($("#net").val())) - parseFloat(settle_tot);
        $("#exceed_amount").val(m_round(difference));
    }
}

function clear_instalment(){
    /*
    $(".ins").each(function(e){
        $("#balance_"+e).val("0.00");
        $("#rebeat_"+e).val("0.00");
        $("#paid_"+e).val("0.00");
        $("#settle_"+e).val("0.00");
    });
    */
    $("#bal_tot").html("0.00");
    $("#paid_tot").html("0.00");
    $("#settle_tot").html("0.00");
    $("#re_tot").html("0.00");
    $("#exceed_amount").val("0.00");

}

function load_data_agr(bc){
    loding();
    var agr_no = $("#agreement_no").val();

    if($("#closed_agr").is(":checked")){
        var close=1;
    }else{
        var close=0;
    }

    $.post("index.php/main/load_data/t_hp_instalment_payment/load_agreement_no", {
        search: $('#pop_search6').val(),
        is_multi:bc,
        is_close:close
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
        if($(this).children().eq(7).html()=="0"){   
            $("#agreement_no").val($(this).children().eq(0).html());
            $("#customer").val($(this).children().eq(4).html());
            $("#customer_id").val($(this).children().eq(1).html());
            $("#ins_id").val($(this).children().eq(3).html());
            
            if($("#multi_branch").is(":checked")){
                installment_list("m");
                balance_break_up("m");
            }else{
                installment_list("s");
                balance_break_up("s");
            }
            $("#pop_close6").click(); 
            $("#btnDelete").attr("disabled", false);
            $("#btnSave").attr("disabled", false);
            $("#showPayments").attr("disabled", false);
        }else{
            $("#pop_close6").click(); 
            alert("This agreement no already colsed");
            $("#btnDelete").attr("disabled", "disabled");
            $("#btnSave").attr("disabled", "disabled");
            $("#showPayments").attr("disabled", "disabled");
        }                  
    })    
}

function installment_list(bc){
    loding();
    var agr_no = $("#agreement_no").val();
    $.post("index.php/main/load_data/t_hp_instalment_payment/load_instalment_list", {
        agr_no:agr_no,
        is_multi:bc,  
        search: $('#pop_search6').val(),

        date : $("#date").val(),
        max_no : $("#id").val()

    }, function (res) {
        if (res != 2) {
            $("#ins1").attr('display','block');
            $('#ins').html(res);
            $("#tgrid").tableScroll({height:200,width:770,});
            
        }
        loding();
    }, "text");
}


function balance_break_up(bc){
    loding();
    var agr_no = $("#agreement_no").val();
    $.post("index.php/main/load_data/t_hp_instalment_payment/load_balance_breakup", {
        agr_no:agr_no,  
        is_multi:bc,
        search: $('#pop_search12').val()
    }, function (res) {
        if (res != 2) {
            $("#sr12").html(res.grid);
            $("#tot_bal").val(m_round(res.tot));
        }
        loding();
    }, "json");
}


function load_rebeat(){
    loding();
    var agr_no = $("#agreement_no").val();
    $.post("index.php/main/load_data/t_hp_instalment_payment/load_rebeat", {
        agr_no:agr_no,  
        search: $('#pop_search13').val()
    }, function (res) {
        if (res != 2) {
            $("#sr13").html(res.grid)
            settings_rebeat();
        }
        loding();
    }, "json");
}

function settings_rebeat(){
    $("#item_list .cl").click(function(){  
        $("#rebeat_tot").val($(this).children().eq(1).html());
        $("#rebeat_capital").val($(this).children().eq(2).html());
        $("#rebeat_interest").val($(this).children().eq(3).html());
        $("#rebeat_panelty").val($(this).children().eq(4).html());
        $("#rebeat_other").val($(this).children().eq(5).html());
        setTimeout("rebeat_settle();", 200);
        setTimeout("calculate_tot();", 210);
        $("#pop_close13").click();   
    });
}

function save(){ 
    var tot = parseFloat($("#rebeat_tot").val()) + parseFloat($("#net").val())
    $("#tot").val(m_round(tot));
    $("#qno").val($("#id").val());
    $('#form_').attr('action',$('#form_id').val()+"t_hp_instalment_payment");
    var frm = $('#form_');
    loding();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (pid) {
            if (pid == 1) {
                $("#btnSave").attr("disabled",true);
                $("#showPayments").attr("disabled",true);
                save_status=0;  
                $("#save_status").val("0");
                if(confirm("Save Completed, Do You Want A print?")){
                    if($("#is_prnt").val()==1){
                        $("#print_pdf").submit();
                    }
                    reload_form();
                }else{
                    location.href="";
                }
            }else{
                set_msg(pid);
            }
            loding();
        }
    });
}

function reload_form(){
    setTimeout(function(){
        location.href= '';
    },50); 
}

function validate(){
    if($("#agreement_no")==""){
        set_msg("Pleae select agreenment no");
        return false;
    }else if($("#customer").val()==""){
        set_msg("Pleae select customer");
        return false;
    }else if($("#officer").val()==""){
        set_msg("Pleae select collection officer");
        return false;
    }else if($("#net").val()==""){
        set_msg("Paid amount cann't be 0");
        return false;
    }else{
        return true;
    }
}


function set_delete(code) {
    if (confirm("Are you sure delete receipt no " + code + "?")) {
        loding();
        $.post("index.php/main/delete/t_hp_instalment_payment", {
           code: code,
           agr_no:$("#agreement_no").val(),
           hid:$("#hid").val()
       }, function (res) {
        if (res == 1) {
            delete_msg();
        } else {
            set_msg(res);
        }
        loding();
    }, "text");
    }
}
function empty_grid(){
    clear_instalment();
    $("#id").val("");
    $("#hid").val("");
    $("#date").val("");
    $("#ref_no").val("");
    $("#agreement_no").val("");
    $("#ins_id").val("");
    $("#customer").val("");
    $("#description").val("");
    $("#tot_bal").val("");
    $("#net2").val("");
    $("#net").val("");
    $("#rebeat_tot").val("");
    $("#rebeat_capital").val("");
    $("#rebeat_interest").val("");
    $("#rebeat_panelty").val("");
    $("#rebeat_other").val("");
}

function set_edit(code) {
    empty_grid();
    loding();
    $.post("index.php/main/load_data/t_hp_instalment_payment/set_edit", {
        code: code
    }, function (res) {

        if (res == 2) {
            set_msg("No records ! ! !");
        }else{
            $("#id").val(res.sum[0].nno);
            $("#qno").val(res.sum[0].nno);
            $("#qno1").val(res.sum[0].inv_no);
            $("#hid").val(res.sum[0].nno);
            $("#date").val(res.sum[0].ddate);
            $("#ref_no").val(res.sum[0].ref_no);
            $("#agreement_no").val(res.sum[0].agr_no);
            $("#ins_id").val(res.sum[0].inv_no);
            $("#customer").val(res.sum[0].customer);
            $("#customer_id").val(res.sum[0].name);
            $("#description").val(res.sum[0].description);
            $("#tot_bal").val(res.sum[0].balance);
            $("#net2").val(res.sum[0].paid_amount);
            $("#net").val(res.sum[0].paid_amount);
            $("#rebeat_tot").val(res.sum[0].rebeat_amount);
            $("#rebeat_capital").val(res.sum[0].rebeat_capital);
            $("#rebeat_interest").val(res.sum[0].rebeat_interest);
            $("#rebeat_panelty").val(res.sum[0].rebeat_panelty);
            $("#rebeat_other").val(res.sum[0].rebeat_other);
            $("#exceed_amount").val(res.sum[0].exceed_amount);
            $("#cash").val(res.sum[0].pay_cash);
            $("#credit_card").val(res.sum[0].pay_ccard);
            $("#cheque_recieve").val(res.sum[0].pay_cheque);
            $("#credit_note").val(res.sum[0].pay_cnote);
            var tot = parseFloat(res.sum[0].paid_amount) + parseFloat(res.sum[0].rebeat_amount)
            $("#tot").val(m_round(tot));
            $("#officer").val(res.sum[0].collection_officer);
            $("#officer_des").val(res.sum[0].officer_name);

            if(res.sum[0].is_cancel=="1"){
                $("#btnDelete").attr("disabled", "disabled");
                $("#showPayments").attr("disabled", "disabled");
                $("#btnSave").attr("disabled", "disabled");
                $("#mframe").css("background-image", "url('img/cancel.png')");
            }

            var a  ="<fieldset>";
            a +="<legend>Installment</legend>";
            a += "<table id='tgrid' style='width:100%;'>";
            a += "<thead><tr>";
            a += "<th class='tb_head_th' style='width:40px;'>No</th>";
            a += "<th class='tb_head_th' style='width:30px; text-align:center;'>Ins No</th>";
            a += "<th class='tb_head_th' style='width:100px; text-align:center;'>Type</th>";
            a += "<th class='tb_head_th' style='width:30px; text-align:left;'>Trans No</th>";
            a += "<th class='tb_head_th' style='width:60px;'>Date</th>";
            a += "<th class='tb_head_th' style='width:55px;'>Amount</th>";
            a += "<th class='tb_head_th' style='width:55px;'>Balance</th>";
            a += "<th class='tb_head_th' style='width:55px;'>Rebeat</th>";
            a += "<th class='tb_head_th' style='width:55px;'>Paid</th>";
            a += "<th class='tb_head_th' style='width:55px;'>Settle</th>";
            a += "</thead></tr><tr class='cl'></tr><tbody>";
            
            var y=1;
            var tot_amount=tot_rebeat=tot_settle=tot_bal=tot_paid=parseFloat(0);
            for(var x=0; x<res.det.length; x++){
                var settle = parseFloat(res.det[x].rebeat)+parseFloat(res.det[x].paid);
                a += "<td style='width:40px;'><input type='text' style='width:100%; text-align:right;' readonly name='no_"+x+"' id='no_"+x+"' title='"+y+"' value='"+y+"'/></td>";
                a += "<td style='width:30px;'><input type='text' style='width:100%; text-align:right;' readonly name='ins_no_"+x+"' id='ins_no_"+x+"' title='"+res.det[x].ins_no+"' value='"+res.det[x].ins_no+"'/></td>";
                a += "<td style='width:100px;'>";
                a += "<input type='text' style='width:100%; text-align:left;' readonly name='types_"+x+"' id='types_"+x+"' title='"+res.det[x].description+"' value='"+res.det[x].description+"'/>";
                a += "<input type='hidden' style='width:100%; text-align:left;' readonly name='rcode_"+x+"' id='rcode_"+x+"' value='"+res.det[x].order_type+"'/>";

                a += "<input type='hidden' style='width:100%; text-align:left;' readonly name='scl_"+x+"' id='scl_"+x+"' value='"+res.det[x].sub_cl+"'/>";
                a += "<input type='hidden' style='width:100%; text-align:left;' readonly name='sbc_"+x+"' id='sbc_"+x+"' value='"+res.det[x].sub_bc+"'/>";
                a += "<input type='hidden' style='width:100%; text-align:left;' readonly name='tcode_"+x+"' id='tcode_"+x+"' value='"+res.det[x].trans_code+"'/>";
                a += "<input type='hidden' style='width:100%; text-align:left;' readonly name='tno_"+x+"' id='tno_"+x+"' value='"+res.det[x].trans_no+"'/>";
                a += "<input type='hidden' style='width:100%; text-align:left;' readonly name='ins_tcode_"+x+"' id='ins_tcode_"+x+"' value='"+res.det[x].ins_tcode+"'/>";

                a += "</td>";
                a += "<td style='width:40px;'><input type='text' style='width:100%; text-align:right;' readonly name='trans_no_"+x+"' id='trans_no_"+x+"' title='"+res.det[x].trans_no+"' value='"+res.det[x].trans_no+"'/></td>";
                a += "<td style='width:60px;'><input type='text' style='width:100%; text-align:right;' readonly name='date_"+x+"' id='date_"+x+"' title='"+res.det[x].date+"' value='"+res.det[x].date+"'/></td>";
                a += "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='amount_"+x+"' id='amount_"+x+"' title='"+res.det[x].amount+"' value='"+res.det[x].amount+"'/></td>";
                a += "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='balance_"+x+"' id='balance_"+x+"' title='"+res.det[x].balance+"' value='"+res.det[x].balance+"'/></td>";
                a += "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='rebeat_"+x+"' id='rebeat_"+x+"' title='"+res.det[x].rebeat+"' value='"+res.det[x].rebeat+"'/></td>";
                a += "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' class='ins' readonly name='paid_"+x+"' id='paid_"+x+"' title='"+res.det[x].paid+"' value='"+res.det[x].paid+"'/></td>";
                a += "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='settle_"+x+"' id='settle_"+x+"' title='"+m_round(settle)+"' value='"+m_round(settle)+"'/></td>";

                y++;
                tot_amount+=parseFloat(res.det[x].amount);
                tot_bal+=parseFloat(res.det[x].balance);
                tot_paid+=parseFloat(res.det[x].paid);
                tot_rebeat+=parseFloat(res.det[x].rebeat);
                tot_settle+=parseFloat(m_round(settle));
                a += "</tr></tbody>";
            }
            a += "<tr><tfoot style='margin-right:40px;'>";
            a += "<td></td>";
            a += "<td></td>";
            a += "<td></td>";
            a += "<td></td>";
            a += "<td style='text-align:left; font-size:15px;'><b>Total</b></td>";
            a += "<td style='text-align:right; font-size:15px;'><b>"+m_round(tot_amount)+"</b></td>";
            a += "<td style='text-align:right; font-size:15px;'><b><span id ='bal_tot'>"+m_round(tot_bal)+"</span></b></td>";
            a += "<td style='text-align:right; font-size:15px;'><b><span id ='re_tot'>"+m_round(tot_rebeat)+"</span></b></td>";
            a += "<td style='text-align:right; font-size:15px; padding-right:0px;'><b><span id ='paid_tot'>"+m_round(tot_paid)+"</span></b></td>";
            a += "<td style='text-align:right; font-size:15px; padding-right:0px;'><b><span id ='settle_tot'>"+m_round(tot_settle)+"</span></b></td>";
            a += "</tr></tfoot>";
            a+="</table>";
            a+="</fieldset>";
            a+="<input type='hidden' name='grid_tot' id='grid_tot' value='"+y+"'/>";

            $('#ins').html(a);
        }
        loding();
    }, "json");
}


