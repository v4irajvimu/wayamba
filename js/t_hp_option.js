$(document).ready(function () {

    default_load();
    default_details();
 
    $("#tabs").tabs();
   

    $("#is_sales_cat").click(function () {
        check_sales_cat();
    });

    $("#def_store").autocomplete('index.php/main/load_data/m_supplier/auto_com', {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
    });


    $("#def_store").keypress(function (e) {
        if (e.keyCode == 13) {
            set_cus_values($(this));
        }
    });

    $("#def_store").blur(function () {
        set_cus_values($(this));
    });

    $("#btnReset").click(function() {
        location.href = '';
    });

    $("#doc_separate").click(function(){
        if($("#doc_separate").is(":checked")){
            $("#doc_acc").removeClass("hid_value");
            $("#doc_acc").addClass("is_checked input_txt");
            $("#doc_acc").attr("readonly", false);
        }else{
            $("#doc_acc").removeClass("is_checked input_txt");
            $("#doc_acc").addClass("hid_value");
            $("#doc_acc").attr("readonly", true);
            $("#doc_acc").val("");
            $("#doc_acc_des").val("");
        }

    });

    $(document).on('keypress','.is_checked', function(e){
        if(e.keyCode == 112){
            $("#pop_search6").val($("#doc_acc").val());
            load_acc();
            $("#serch_pop6").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search6').focus()", 100);
        }

       $("#pop_search6").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_acc();
            }
        }); 

        if(e.keyCode == 46){
            $("#doc_acc").val("");
            $("#doc_acc_des").val("");
        }
    });

});

function load_acc(){
        $.post("index.php/main/load_data/utility/f1_selection_list", {
            data_tbl:"m_account",
            field:"code",
            field2:"description",
            preview2:"Account Name",
            search : $("#pop_search6").val() 
        }, function(r){
            $("#sr6").html(r);
            load_acc_setting();            
        }, "text");
    }

function load_acc_setting(){
    $("#item_list .cl").click(function(){        
        $("#doc_acc").val($(this).children().eq(0).html());
        $("#doc_acc_des").val($(this).children().eq(1).html());
        $("#pop_close6").click();                
    })    
}

function default_load(){
    $.post("index.php/main/load_data/t_hp_option/get_form_data", 
        function(r){ 
           settings(r);   
        },"json");
}


function default_details(){
    $.post("index.php/main/load_data/t_hp_option/get_display", 
        function(r){ 
            if(r.option_hp[0].use_auto_no_format=="1"){
                $("#is_use_auto_no_format").attr("checked",true);
            }
            if(r.option_hp[0].panelty_cal_type=="1"){
                $("#panalty_d").attr("checked",true);
            }
            if(r.option_hp[0].panelty_cal_type=="2"){
                $("#panalty_m").attr("checked",true);
            }
            if(r.option_hp[0].panelty_cal_type=="3"){
                $("#panalty_a").attr("checked",true);
            }
            if(r.option_hp[0].panelty_cal_type=="4"){
                $("#panalty_b").attr("checked",true);
            }
            if(r.option_hp[0].is_separate_doc=="1"){
                $("#doc_separate").attr("checked",true);
            }
            if(r.option_hp[0].show_memo_hp_receipt=="1"){
                $("#sh_memo").attr("checked",true);
            }else{
                 $("#sh_memo").attr("checked",false);
            }
            $("#doc_acc").val(r.option_hp[0].doc_acc);
            $("#doc_acc_des").val(r.option_hp[0].doc_acc);
            
            if(r.option_hp[0].grace_period_cal_type=="1"){
                $("#em_grace").attr("checked",true);
            }
            if(r.option_hp[0].grace_period_cal_type=="2"){
                $("#fm_grace").attr("checked",true);
            }

            $("#p_rate").val(r.option_acc[0].Penalty_Rate);
            $("#gr_day").val(r.option_acc[0].grace_period);

    },"json");

}

function check_sales_cat() {
    if ($("#is_sales_cat").is(':checked')) {
        // alert("checked");
        $("#sales_cat").removeAttr("readonly");

    } else {
        // alert("un-checked");
        $("#sales_cat").attr("readonly", "readonly");
    }
}


function save() {
    var frm = $('#form_');
    loding();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (pid) {

            if (pid == 1) {
                location.reload();
            } else if (pid == 2) {
                alert("No permission to add data.");
            } else if (pid == 3) {
                alert("No permission to edit data.");
            } else {
                alert("Error : \n" + pid);
            }
            loding();
            location.href = "";
        }
    });
}


function reload_form() {
    setTimeout(function () {
        window.location = '';
    }, 50);
}


function check_code() {
    loding();
    var code = $("#code").val();
    $.post("index.php/main/load_data/t_cash_sales_sum/check_code", {
        code: code
    }, function (res) {
        if (res == 1) {
            if (confirm("This code (" + code + ") already added. \n\n Do you need edit it?")) {
                set_edit(code);
            } else {
                $("#code").val('');
                $("#code").attr("readonly", false);
            }
        }
        loding();
    }, "text");
}

function validate(){

    var is_order_set = false;
    var is_sample_set = false;
    var is_order_same = false;

    for (i = 0; i <= 6; i++) {
        if($('#fn_'+i).prop('checked')){

            if(i != 6){
                if($("#order_"+i).val() == ""){
                    is_order_set = true;
                    break;
                }
            }
                   
            if($("#sample_"+i).val() == ""){
                is_sample_set = true;
                break;
            }
        }
    }


    if($("#code_place").val()==""){
        set_msg("Please enter code place.");
        return false
    }else if($("#description").val()==""){
        set_msg("Please enter description.");
        return false;
    }else if($("#table_name").val()==""){
        set_msg("Please enter table name.");
        return false;
    }else if($("#serial_field").val()==""){
        set_msg("Please enter serial field.");
        return false;
    }else if($("#date_field").val()==""){
        set_msg("Please enter date field.");
        return false;
    }else if(is_order_set){
        set_msg("Please enter order.");
        return false;
    }else if(is_sample_set){
        set_msg("Please enter sample.");
        return false;
    }else if(is_order_same){
        set_msg("Please enter correct order.");
        return false;
    }else{
        return true;
    }
}


function set_delete(code) {
    if (confirm("Are you sure delete " + code + "?")) {
        loding();
        $.post("index.php/main/delete/t_cash_sales_sum", {
            code: code
        }, function (res) {
            if (res == 1) {
                get_data_table();
            } else if (res == 2) {
                alert("No permission to delete data.");
            } else {
                alert("Item deleting fail.");
            }
            loding();
        }, "text");
    }
}



function set_cus_values(f) {
    var v = f.val();
    v = v.split("|");
    if (v.length == 2) {
        f.val(v[0]);
        $("#desc_def_store").val(v[1]);
    }
}

function formatItems(row) {
    return "<strong> " + row[0] + "</strong> | <strong> " + row[1] + "</strong>";
}

function formatItemsResult(row) {
    return row[0] + "|" + row[1];
}

function settings(r){  
    //sum table details
    $("#code_place").val(r[0].code_place);
    $("#description").val(r[0].cp_description);
    $("#table_name").val(r[0].table_name);
    $("#serial_field").val(r[0].serial_field);
    $("#date_field").val(r[0].date_field);

    if(r[0].restart_in_each == "monthly" ){
        $("#monthly").prop('checked', true);
    }
    else if(r[0].restart_in_each == "anually" ){
        $("#anually").prop('checked', true);
    }
    else if(r[0].restart_in_each == "daily" ){
        $("#daily").prop('checked', true);
    }
    else if(r[0].restart_in_each == "continus" ){
        $("#continus").prop('checked', true);
    }
    
    if(r[0].restart_branch_code == 1){
        $("#restart_branch_code").prop('checked', true);
    }
    if(r[0].restart_sales_cat == 1){
        $("#restart_sales_cat").prop('checked', true);
    }

    if(r[1].use_auto_no_format == 1){
        $("#is_use_auto_no_format").prop('checked', true);
    }

    var num_rows = r[3];

    for (i = 0; i < num_rows; i++) {
        if( r[2][i].field_name == "day" || 
            r[2][i].field_name == "month" || 
            r[2][i].field_name == "year" ||
            r[2][i].field_name == "serial_no" ||
            r[2][i].field_name == "branch_code" ||
            r[2][i].field_name == "sales_category" ||
            r[2][i].field_name == "seperator" )

        {
            if(i != 6){
                $("#order_"+i).val(r[2][i].field_order);
            }
            $("#fn_"+i).prop('checked', true); 
            $("#sample_"+i).val(r[2][i].field_format);
        } 
    }

    if(r[1].panelty_cal_type == 1){
        $("#panalty_d").prop('checked', true);
    }
    if(r[1].panelty_cal_type == 2){
        $("#panalty_m").prop('checked', true);
    }
    if(r[1].panelty_cal_type == 3){
        $("#panalty_a").prop('checked', true);
    }
    if(r[1].panelty_cal_type == 4){
        $("#panalty_b").prop('checked', true);
    }
    if(r[1].is_separate_doc == 1){
        $("#doc_separate").prop('checked', true);
        $("#doc_acc").attr('readonly', false);
        $("#doc_acc").removeClass('hid_value');
        $("#doc_acc").addClass('input_txt is_checked');        
        $("#doc_acc").val(r[1].doc_acc);
        $("#doc_acc_des").val(r[1].doc_acc_name);
    }
     

   
}
    
