var is_edit=0;
$(document).ready(function(){
    $("#code").blur(function(){
        check_code();
    });

    $("#down_pay_type_val").click(function(){

        //$("#down_pay_type_val").val("");
        $("#down_pay_pre").attr("readonly","readonly");
        $("#down_pay_val").removeAttr("readonly");
        $("#down_pay_pre").val("");
        
    });

    $("#down_pay_type_pre").click(function(){ 

        $("#down_pay_val").attr("readonly","readonly");
        $("#down_pay_pre").removeAttr("readonly");
        $("#down_pay_val").val("");
        
    });
    
    $("#btnSave1").click(function()
    {
    if(validate())
    {
        check_permission();
    }    
    });

    $("#de_code").autocomplete('index.php/main/load_data/r_department/auto_com', {
            width: 350,
            multiple: false,
            matchContains: true,
            formatItem: formatItems,
            formatResult: formatItemsResult
        });


        $("#de_code").keypress(function(e){
            if(e.keyCode == 13){
            set_cus_values($(this));
            }
        });

        $("#de_code").blur(function(){
            set_cus_values($(this));
        });


        //  $("#code").autocomplete('index.php/main/load_data/r_category/auto_com', {
        //     width: 350,
        //     multiple: false,
        //     matchContains: true,
        //     formatItem: formatItems,
        //     formatResult: formatItemsResult
        // });


        // $("#code").keypress(function(e){
        //     if(e.keyCode == 13){
        //     set_cus_values($(this));
        //     }
        // });

        // $("#code").blur(function(){
        //     set_cus_values2($(this));
        // });
   

    $("#grid").tableScroll({height:355, width:590});


    $("#srchee").keyup(function(){  
   		$.post("index.php/main/load_data/utility/get_data_table", {
                code:$("#srchee").val(),
                tbl:"m_hp_payment_scheme",
                tbl_fied_names:"Code-Description",
	        	fied_names:"code-description"
             }, function(r){
        	$("#grid_body").html(r);
    	}, "text");

	});

});

function check_permission()
{
    $.post("index.php/main/load_data/user_permissions/get_permission",{
    
        module_id : '013',
        is_edit   : is_edit
        
    },function(r){
    
    if(r=='1')
    {
       save();
       
    }    
    else if(r=='2')
    {
        set_msg("You have no permission to edit this record","error");
    }
    else
    {
      save();
    }    
});
    
}

function check_delete_permission(code)
{

    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/m_hp_payment_scheme", {
            code : code
        }, function(res){
            if(res == 1){
                location.href = "";
            }else{
                set_msg("Item deleting fail.","error");
            }
            loding();
        }, "text");
    }
   
    
   
}

// function save(){
//     $("#form_").submit();
//     is_edit=0;
// }


    function formatItems(row){
        return "<strong> " +row[0] + "</strong> | <strong> " +row[1] + "</strong>";
    }

    function formatItemsResult(row){
        return row[0]+"|"+row[1];
    }

    function set_cus_values(f){
            var v = f.val();
            v = v.split("|");
            if(v.length == 2){
            f.val(v[0]);
            $("#department").val(v[1]);
    }
 }


     function set_cus_values2(f){
            var v = f.val();
            v = v.split("|");
            if(v.length == 2){
            f.val(v[0]);
            $("#description").val(v[1]);
    }
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
                location.href = "";
                get_data_table();
                
            }else if(pid == 2){
                set_msg("No permission to add data.","error");
            }else if(pid == 3){
                set_msg("No permission to edit data.","error");
            }else{
                set_msg("Error : \n"+pid,"error");
            }
            loding();
        }
    });
}


function get_data_table(){
    $.post("index.php/main/load_data/m_hp_payment_scheme/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}


function check_code(){
    var code = $("#code").val();
    $.post("index.php/main/load_data/m_hp_payment_scheme/check_code", {
        code : code
    }, function(res){
        if(res == 1){
            if(confirm("This code ("+code+") already added. \n\n Do you need edit it?")){
                set_edit(code);
            }else{
                $("#code").val('');
            }
        }
    }, "text");
}

function validate(){
    if($("#code").val() === $("#code").attr('title') || $("#code").val() == ""){
            set_msg("Please enter code.","error");
            $("#code").focus();
            return false;
        }else if($("#code").val().length<4){
            set_msg("Code must contains 4 charactors","error");
            $("#code").focus();
            return false;
        }else if($("#description").val() === $("#description").attr('title') || $("#description").val() == ""){
            set_msg("Please enter description.","error");
            $("#des").focus();
            return false;
        }else if($("#des").val() === $("#code").val()){
            set_msg("Please enter deferent values for description & code.","error");
            $("#des").focus();
            return false;
        }else if($("#interest_rate").val() === $("#interest_rate").attr('title') || $("#interest_rate").val() == ""){
            set_msg("Please enter Interest Rate.","error");
            $("#interest_rate").focus();
            return false;
        }else if(!($('#monthly').is(':checked') || $('#yearly').is(':checked'))){
            set_msg("Please enter interest type.","error");
             return false
        }else if($("#period").val() === $("#period").attr('title') || $("#period").val() == ""){
            set_msg("Please enter period.","error");
            $("#period").focus();
            return false;
        }else if($("#payment_type").val() == ""){
            set_msg("Please enter payment type.","error");
            $("#payment_type").focus();
            return false;
        }else if($("#payment_gap").val() === $("#payment_gap").attr('title') || $("#payment_gap").val() == ""){
            set_msg("Please enter difference.","error");
            $("#payment_gap").focus();
            return false;
        }else if($("#document_charges").val() === $("#document_charges").attr('title') || $("#document_charges").val() == ""){
            set_msg("Please enter document charges.","error");
            $("#interest_rate").focus();
            return false;
        }else if(!($('#down_pay_type_val').is(':checked') || $('#down_pay_type_pre').is(':checked'))){
            set_msg("Please enter down payment type.","error");
            return false;
        }else if($("#down_pay_val").val() == "" && $("#down_pay_pre").val() == ""){
            set_msg("Please enter down payment.","error");
            return false;

        }else if($("#loan_min_amount").val() === $("#loan_min_amount").attr('title') || $("#loan_min_amount").val() == ""){
            set_msg("Please enter minimum loan amount.","error");
            $("#loan_min_amount").focus();
            return false;
        }else if($("#loan_max_amount").val() === $("#loan_max_amount").attr('title') || $("#loan_max_amount").val() == ""){
            set_msg("Please enter maximum loan amount.","error");
            $("#loan_max_amount").focus();
            return false;
        }
        else{
            return true;
        }
}
    
function set_delete(code){
 check_delete_permission(code);
}
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/m_hp_payment_scheme", {
        code : code
    }, function(res){
        $("#code_").val(res.code);
        $("#code").val(res.code);
        $("#description").val(res.description);
        $("#interest_rate").val(res.interest_rate);

        if(res.interest_type == 1){
            $("#monthly").prop("checked",true);
        }else{
            $("#yearly").prop("checked",true);
        }

        $("#period").val(res.period);
        $("#payment_type").val(res.payment_type);
        $("#payment_gap").val(res.payment_gap);
        $("#document_charges").val(res.document_charges);

        if(res.down_payment_type == 1){
            $("#down_pay_type_val").prop("checked",true);
            $("#down_pay_val").val(res.down_payment);
        }
        else{
            $("#down_pay_type_pre").prop("checked",true);
            $("#down_pay_pre").val(res.down_payment);
        }

        if(res.is_intfree == 1){
            $("#is_intfree").prop("checked",true);
        }
        else{
            $("#is_intfree").prop("checked",false);
        }

        $("#loan_min_amount").val(res.loan_min_amount);
        $("#loan_max_amount").val(res.loan_max_amount);

        if(res.is_editable == 1){
            $("#is_editable").prop("checked",true);
        }


        
        loding(); input_active();
        is_edit=1;
    }, "json");
}


