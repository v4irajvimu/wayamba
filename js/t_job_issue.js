
$(document).ready(function(){
    $("#code").blur(function(){
        check_code();
    });

    var wh=$("#mframe").width()-20;
    $("#tgrid").tableScroll({height:300, width:wh});

    $(".amt").bind('keyup blur' , function() {
        tot_amt();
    });

    $("#btnPrint").click(function(){
        if($("#qno").val()=="0" || $("#qno").val()==""){
            set_msg("Please Load a record");
        }else{
            $("#print_pdf").submit();
        }   
    });
    $("#search").keyup(function(){
        load_services();
    });

    $("#btnDelete").click(function(){
        set_delete();
    });
    $(".chk").click(function(){
        set_cid($(this).attr("id"));
        if($("#sel_"+scid).is(":checked")){
            $("#6_"+scid).removeAttr("readonly");

        }else{

            $("#6_"+scid).prop('readonly','true');
            $("#6_"+scid).val("");
            tot_amt();  
        }
    });

    $("#btnReset").click(function(){
        $("input[type='checkbox']").each(function(){
            $(this).removeAttr("checked");
        });
        $("input[type='button']").removeAttr("disabled");
    });

    $("#id").keypress(function(e){
        if(e.keyCode== 13){
          $("#hid").val($(this).val());
          load_data();
      }
  });

    $("#cus_id").keypress(function(e){
        if(e.keyCode==112){
            $("#pop_search").val();
            select_cus()
            $("#serch_pop").center();
            $("#blocker").css("display","block");
            setTimeout("$('#pop_search').focus()", 100); 
        }
        if(e.keyCode == 46){
            $("#cus_id").val("");
            $("#cus_name").val("");
        }
        $("#pop_search").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ){ 
                select_cus();
            }
        })
    })


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
                set_msg("No permission to add data.");
            }else if(pid== 3){
                set_msg("No permission to edit data.");
            }else{
                set_msg(pid);
            }

        }
    });
}


function get_data_table(){
    $.post("/index.php/main/load_data/t_job_issue/get_data_table", {

    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}


/*function check_code(){
    loding();
    var code = $("#code").val();
    $.post("index.php/main/load_data/t_job_issue/check_code", {
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
}*/

function validate(){
    if($("#cus_id").val()==""){
        set_msg("Please select a customer ");
        return false;
    }else if(!$("#sel_"+scid).is(":checked")){
        set_msg("Please Select a job");
        return false;
    }else{
        return true;
    }
    
}

function set_delete(){
    if(confirm("Are You Sure Cancel the Record")){
        loding();
        $.post("index.php/main/delete/t_job_issue", {
            code : code
        }, function(res){
            if(res == 1){
                get_data_table();
            }else if(res == 2){
                alert("No permission to delete data.");
            }else{
                alert("Record Cancelling Fail");
            }
            loding();
        }, "text");
    }
}

/*function is_edit($mod)
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
*/
/*function set_edit(code){
    loding();
    $.post("index.php/main/get_data/t_job_issue", {
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
        loding(); input_active();
    }, "json");
}*/
function select_cus(){
    $.post("index.php/main/load_data/t_job_issue/select_customer",{
        search:$("#pop_search").val()
    },function(r){
        $("#sr").html(r);
        cus_settings();
    },"text");
}
function cus_settings(){
    $("#item_list .cl").click(function(){
        $("#cus_id").val($(this).children().eq(0).html()); 
        $("#cus_name").val($(this).children().eq(1).html());
        load_services();
        $("#pop_close").click();
    });
}

function load_services(){
    var tot =0;
    $.post("index.php/main/load_data/t_job_issue/load_services",{
        customer:$("#cus_id").val(),
        search:$("#search").val()
    },function(res){
        empty_grid();
        if(res.a==2){
           
        }else{
            for(var i=0;i<res.a.length;i++){
                $("#0_"+i).val(res.a[i].job_no);
                $("#n_"+i).val(res.a[i].receive_dt);
                $("#1_"+i).val(res.a[i].item_code + " - " + res.a[i].Item_name);
                $("#3_"+i).val(res.a[i].fault);
                if(res.a[i].w_start_date == "0000-00-00"){
                    $("#4_"+i).val("");
                }else{
                    $("#4_"+i).val(res.a[i].w_start_date);
                }
                if(res.a[i].w_end_date == "0000-00-00"){
                    $("#5_"+i).val("");
                }else{
                    $("#5_"+i).val(res.a[i].w_end_date); 
                }
                var adv_amt = parseFloat(res.a[i].advance_amount);
                if(isNaN(adv_amt)){
                    adv_amt=0;
                }
                tot+=adv_amt;
            }
            $("#adv_amount").val(m_round(tot));
        }

    },"json");
}

function tot_amt(){
    var tot =0;
    var bal_amt=0;
    $(".amt").each(function(){
        var amount = parseFloat($(this).val());
        var adv_amt =parseFloat($("#adv_amount").val());
        if(isNaN(amount)){ amount=0; }
        if(isNaN(adv_amt)){ adv_amt =0; }
        tot = parseFloat(tot)+amount;
        if(tot>adv_amt){
            bal_amt = tot - adv_amt;
        }
    });
    $("#bl_amount").val(m_round(bal_amt));
    $("#amount").val(m_round(tot));
}

function load_data(){
    $.post("index.php/main/load_data/t_job_issue/load",{
        id:$("#id").val()

    },function(res){
        empty_grid();
        if(res.a==2){
            
        }else{
            if(res.a[0].is_cancel == 1){
                $("#mframe").css("background-image", "url('img/cancel.png')");
                $("#btnDelete").attr("disabled", "disabled");
                $("#btnSave").attr("disabled", "disabled");
            }
            $("#cus_id").val(res.a[0].customer);
            $("#cus_name").val(res.a[0].name);
            $("#comment").val(res.a[0].memo);
            $("#date").val(res.a[0].ddate);
            $("#ref_no").val(res.a[0].ref_no);
            $("#drn").val(res.a[0].drn_no);
            $("#amount").val(res.a[0].amount);
            $("#adv_amount").val(res.a[0].advance);
            $("#bl_amount").val(res.a[0].balance);
            $("#id").attr("readonly","readonly");
            $("#qno").val($("#id").val());

            for(var i=0;i<res.b.length;i++){
                $("#sel_"+i).attr("checked","checked");
                $("#0_"+i).val(res.b[i].job_no); 
                $("#n_"+i).val(res.b[i].r_date); 
                $("#1_"+i).val(res.b[i].item_code + " - " +res.b[i].Item_name); 
                $("#3_"+i).val(res.b[i].fault); 
                if(res.b[i].w_start_date == "0000-00-00"){
                    $("#4_"+i).val(""); 
                }else{
                    $("#4_"+i).val(res.b[i].w_start_date); 
                }
                if(res.b[i].w_end_date == "0000-00-00"){
                    $("#5_"+i).val(""); 
                }else{
                    $("#5_"+i).val(res.b[i].w_end_date); 
                }
                $("#6_"+i).val(res.b[i].amount); 
            }
        }
    },"json");
}
function empty_grid(){
    $("#tgrid input").each(function(){
        $(this).val("");
    });
}

function set_delete(){
    if(confirm("Are you sure, You Want to Cancel the record ?")){
        loding();
        $.post("index.php/main/load_data/t_job_issue/delete",{
            id: $("#hid").val()
        }, function(res){
            if(res == 1){
              reload_form();
          }else if(res == 2){
            alert("No permission to delete data.");
        }else{
            alert("Item deleting fail.");
        }
        loding();
    }, "text");
    }
}

function reload_form(){
  setTimeout(function(){
    location.href= '';
},50); 
}