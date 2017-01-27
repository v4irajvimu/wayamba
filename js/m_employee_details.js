

$(document).ready(function(){

    $("#btnReset").click(function(){
        location.href="index.php?action=m_employee_details";
    });

    $("#code").blur(function(){
        check_code();
    });
     
    $("#grid").tableScroll({height:355});

    $("#designation").change(function(){
        set_select('designation','designation_id');
    });

    $("#emp_list").click(function(){

        $("#print_pdf").submit();


    });



   /* $("#category").change(function(){
        set_select('category','category_id');
    });*/

$("#cat_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search").val($("#cat_id").val());
      load_category();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_category();
      }
    });
    if(e.keyCode==46){
       $("#cat_id").val("");
       $("#category_id").val("");
      }  
   });



    $("#srchee").keyup(function(){  
     $.post("index.php/main/load_data/utility/get_data_table", {
                    code:$("#srchee").val(),
                    tbl:"m_employee",
                    tbl_fied_names:"Code-Name",
                    fied_names:"code-name"
                 }, function(r){
            $("#grid_body").html(r);
        }, "text");

    });


});

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
            }else if(pid == 2){
                alert("No permission to add data.");
            }else if(pid == 3){
                alert("No permission to edit data.");
            }else{
                loding();
                alert("Error : \n"+pid);
            }
            
        }
    });
}



function get_data_table(){
    $.post("index.php/main/load_data/m_employee_details/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}


function check_code(){
        loding();
    var code = $("#code").val();
    $.post("index.php/main/load_data/m_employee_details/check_code", {
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
    }else if($("#name").val() === $("#name").attr('title') || $("#name").val() == ""){
        alert("Please enter name.");
        $("#name").focus();
        return false;
    }else if($("#designation").val() == "0"){
        alert("Please select a designation");
        $("#designation").focus();
        return false;
    }else{
        return true;
    }
}
    
function set_delete(code){
    if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/m_employee_details", {
            code : code
        }, function(res){
            if(res == 1){
                loding();
                delete_msg();
            }else if(res == 2){
                alert("No permission to delete data.");
            }else{
                loding();
                alert("Item deleting fail.");
            }
            
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

function load_category(){
    $.post("index.php/main/load_data/m_employee_details/category_details", {
      search : $("#pop_search").val(),
    }, function(r){
        $("#sr").html(r);
        settings_cat();   
    }, "text");
}

function settings_cat(){
    $("#item_list .cl").click(function(){     
        $("#cat_id").val($(this).children().eq(0).html());
        $("#category_id").val($(this).children().eq(1).html());
        $("#pop_close").click();                
    })    
}
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/m_employee_details", {
        code : code
    }, function(res){
        $("#code_").val(res.code);
        $("#code").val(res.code);
        $("#code").attr("readonly", true);
        $("#description").val(res.description);
        $("#name").val(res.name);
        $("#address1").val(res.address1);
        $("#address2").val(res.address2);
        $("#address3").val(res.address3);
        $("#tp1").val(res.tp1);
        $("#tp2").val(res.tp2);
        $("#tp3").val(res.tp3);
        $("#doj").val(res.doj);
        $("#designation").val(res.designation);
        set_select('designation','designation_id');
        $("#cat_id").val(res.cat_id);
        $("#category_id").val(res.description);
        //set_select('description ','category_id');

        if(res.inactive==1){
            $("#inactive").attr("checked", "checked");
            }else{
            $("#inactive").removeAttr("checked");
        }

        loding(); input_active();
    }, "json");
}