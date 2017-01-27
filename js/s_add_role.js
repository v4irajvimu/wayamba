$(document).ready(function(){
    

    
    $(":checkbox").removeAttr('checked');
    $("#grid").tableScroll({height:355});
    
    
    $("#user").change(function(){
        
        load_data();
        
    });

});

function load_data(){
    
    empty_grid();
    $.post("index.php/main/get_data/s_add_role/", {
        id : $("#user option:selected").val()
    }, function(r){
        //alert(r);
        $("#tgrid tr").each(function(){
            for(var i=0; i<r.length; i++){

                    $("#check"+r[i].role_id).attr("checked", "checked"); 
                    $("#date_from"+r[i].role_id).val(r[i].date_to);
                    $("#date_to"+r[i].role_id).val(r[i].date_from);
                
                }

        });
    }, "json");
    
}


function get_data(){
        var x = y = new Array(); var a = 0;
        $("#tgrid tr").each(function(){
            y = new Array();
            $(this).find("td").each(function(i){
                if(i==0){
                    y[0] = $(this).html();
                }else if(i == 2){
                    y[1] = $(this).children().attr("checked")? 1:0;
                }else if(i == 3){
                    y[2] = $(this).children().val();
                }else if(i == 4){
                    y[3] = $(this).children().val();
                }
            });
            if(y[1] == 1) { x[a++] = y; }
        });
        
        return x;
    }

function save(){
    
    
    $("#form_").submit();
}

function check_code(){
    var code = $("#code").val();
    $.post("index.php/main/load_data/s_module/check_code", {
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

//function validate(){
//    if($("#user").val() == $("#user").attr('title') || $("#user").val() == ""){
//            alert("Please enter code.");
//            $("#user").focus();
//            return false;
//        }else if($("#des").val() === $("#des").attr('title') || $("#des").val() == ""){
//            alert("Please enter description.");
//            $("#des").focus();
//            return false;
//        }else if($("#managers option:selected").attr('value') == "0"){
//            alert("Please select manager.");
//            return false;
//        }else{
//            return true;
//        }
//}
    
function set_delete(code){
    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/s_module", {
            code : code
        }, function(res){
            if(res == 1){
                location.reload();
            }else{
                alert("Item deleting fail.");
            }
            loding();
        }, "text");
    }
}
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/s_module", {
        code : code
    }, function(res){
        $("#code_").val(res.m_code);
        $("#code").val(res.m_code);
        $("#code").attr("readonly", true);
        $("#des").val(res.m_description);
        
        loding(); input_active();
    }, "json");
}

function empty_grid(){
    
    $("#tgrid tr").each(function(){
            $(this).find("td").each(function(i){
                if(i == 2){
                    $(this).children().removeAttr("checked");
                }else if(i == 3){
                    $(this).children().val("0000-00-00");
                }else if(i == 4){
                    $(this).children().val("0000-00-00");
                }
            });
        });
}