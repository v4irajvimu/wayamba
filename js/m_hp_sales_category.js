var is_edit=0;
$(document).ready(function(){
    $("#code").blur(function(){
        check_code();
    });
    
    $("#btnSave1").click(function(){
    if(validate())
    {
        save();
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

     

    $("#grid").tableScroll({height:355, width:590});


    $("#srchee").keyup(function(){  
   		$.post("index.php/main/load_data/utility/get_data_table", {
                code:$("#srchee").val(),
                tbl:"m_hp_sales_category",
                tbl_fied_names:"Code-Description",
	        	fied_names:"code-description"
             }, function(r){
        	$("#grid_body").html(r);
    	}, "text");

	});

});



function check_delete_permission(code){
    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/r_category", {
                code : code
        }, function(res){
            if(res == 1){
                location.reload();
            }else{
                set_msg("Item deleting fail.","error");
            }
            loding();
        }, "text");
    }
}


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
                loding(); 
                sucess_msg();
            }else{
                loding();
                set_msg(pid);
            }
            
        }
    });
}


function get_data_table(){
    $.post("index.php/main/load_data/m_hp_sales_category/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}


function check_code(){
    var code = $("#code").val();
    $.post("index.php/main/load_data/m_hp_sales_category/check_code", {
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
    }else if($("#agriment_no_start_with").val() === $("#agriment_no_start_with").attr('title') || $("#agriment_no_start_with").val() == ""){
        set_msg("Please enter Agriment No Starting Letters","error");
        $("#agriment_no_start_with").focus();
        return false;
    }else if($("#start_serial_no").val() === $("#start_serial_no").attr('title') || $("#start_serial_no").val() == ""){
        set_msg("Please enter Start Serial No.","error");
        $("#start_serial_no").focus();
        return false;
    }else if($("#note").val() === $("#note").attr('title') || $("#note").val() == ""){
        set_msg("Please enter Note.","error");
        $("#note").focus();
        return false;
    }else{
        return true;
    }
}
    
function set_delete(code){

     if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/m_hp_sales_category", {
            code : code
        }, function(res){
            if(res == 1){
                location.href="";
            }else{
                set_msg(res);
            }
            loding();
        }, "text");
    }
 
}
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/m_hp_sales_category", {
        code : code
    }, function(res){
        $("#code_").val(res.code);
        $("#code").val(res.code);
        $("#description").val(res.description);
        $("#agriment_no_start_with").val(res.agriment_no_start_with);
        $("#start_serial_no").val(res.start_serial_no);
        $("#note").val(res.note);

        loding(); input_active();
        is_edit=1;
    }, "json");
}


