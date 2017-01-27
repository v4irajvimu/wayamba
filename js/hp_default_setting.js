$(document).ready(function () {

    $.post("index.php/main/load_data/hp_default_setting/get_form_data", 
        function(r){ 

            settings(r);   

        },"json");

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
        location.href = "?action=hp_default_setting";
    });

});


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
            // for (x = 0; x < 6; x++) {
            //     if($('#fn_'+x).prop('checked')){ 
            //         alert($("#order_"+i).val() + "---" + $("#order_"+x).val());
            //         // if($("#order_"+i).val() == $("#order_"+x).val()){
            //         //     is_order_same = true;
            //         //     break;
            //         // }
            //     }
            // }
            
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

    //hp_option table details
    if(r[1].use_auto_no_format == 1){
        $("#is_use_auto_no_format").prop('checked', true);
    }

    //det table details

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
     
        
}
    
