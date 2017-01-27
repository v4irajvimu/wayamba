$(document).ready(function(){

    $("#tgrid").tableScroll({height:250, width:980});
   
    $("#btnResett").click(function(){
   	    location.href="";
    });

    $("#btnDelete").click(function(){
        set_delete();
    });

    $("#id").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            load_data($(this).val());
            $(this).attr("readonly","readonly");
        }
    });

    $(".fo").click(function(){
        set_cid($(this).attr("id"));
        is_check_clicked(scid);
    });
    
    $("#btnPrint").click(function(){
        $("#print_pdf").submit();
    });

    $("#organizer_id").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search2").val($("#organizer_id").val());
            load_data9();
            $("#serch_pop2").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search2').focus()", 100);
        }
        $("#pop_search2").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_data9();
            }
        }); 
        if(e.keyCode == 46){
            $("#organizer_id").val("");
            $("#organizer_name").val("");
        }
    });    

    $("#seettu_id").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search11").val($("#seettu_id").val());
            load_settu();
            $("#serch_pop11").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search11').focus()", 100);
        }
        $("#pop_search11").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_settu();
            }
        }); 
        if(e.keyCode == 46){
            $("#seettu_id").val("");
            $("#seettu_no").val("");
        }
    });    
       
 });/*end*/

function is_check_clicked(scid){
    for(var r=0; r<25; r++){
        $("#0_"+r).attr("checked",false);
    }
    $("#0_"+scid).attr("checked",true);
}


function load_settu(){
    $.post("index.php/main/load_data/t_settu_item_req/load_settu", {
        search : $("#pop_search11").val(), 
        organizer : $("#organizer_id").val()
    }, function(r){
        $("#sr11").html(r);
        settings_settu();            
    }, "text");
}

function settings_settu(){
    $("#item_list .cl").click(function(){        
        $("#seettu_id").val($(this).children().eq(0).html());
        $("#organizer_id").val($(this).children().eq(2).html());     
        $("#organizer_name").val($(this).children().eq(3).html()); 
        $("#root").val($(this).children().eq(5).html()); 
        load_pending_tots($(this).children().eq(2).html(),$(this).children().eq(5).html());
        load_settu_item($(this).children().eq(0).html()); 

        $("#pop_close11").click();                
    })    
}

function load_data9(){
    $.post("index.php/main/load_data/t_settu_item_req/load_orgernizer", {
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings9();            
    }, "text");
}

function settings9(){
    $("#item_list .cl").click(function(){        
        $("#organizer_id").val($(this).children().eq(0).html());
        $("#organizer_name").val($(this).children().eq(1).html());   
        $("#address").val($(this).children().eq(2).html());     
        $("#pop_close2").click();                
    })    
}

function empty_grid(){
    for(var y=0; y<25; y++){
        $("#n_"+y).val("");
        $("#1_"+y).val("");
        $("#2_"+y).val("");
        $("#0_"+y).attr("checked",false);
    }
}

function load_settu_item(id){
    $.post("index.php/main/load_data/t_settu_item_req/load_settu_item", {
        no : id
    }, function(r){
        if(r=="2"){
            set_msg("No records !")
        }else{
            empty_grid()
            for(var x=0; x<r.length; x++){
                $("#n_"+x).val(r[x].code);
                $("#1_"+x).val(r[x].item_code);
                $("#2_"+x).val(r[x].name);
            }
        }      
    }, "json");
}

function load_pending_tots(orgernizer,root){
    $.post("index.php/main/load_data/t_settu_item_req/load_pending_details", {
        id : orgernizer,
        root : root
    }, function(r){
        if(r=="2"){
            set_msg("No records !")
        }else{
            $("#pending_tot").val(r.tot_pending);
            $("#root_pending").val(r.tot_root_pending);
            $("#r_name").val(r.root_name);
        }
    }, "json");
}


function check_item_exist(id){
    var v = true;
    $(".fo").each(function(e){
        if($("#h_"+e).val() == id){
            v = false;
        }
    });    
    return v;
}

function check_item_exist1(id){
    var v = true;
    $(".sub_i").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });    
    return v;
}

function validate(){
    var v=false;
    for(var t=0; t<25; t++){
        if($("#0_"+t).is(":checked")){
            v=true;
        }
    }
    if($("#organizer_id").val() == ""){
        set_msg("Please enter Orgenizer.");
        $("#organizer_id").focus();
        return false;
    }else if($("#seettu_id").val()==""){
        set_msg("Please enter Settu no.");
        $("#sales_rep_id").focus();
        return false;
    }else if(v == false){
        set_msg("Please select at least one item in a grid ");
        return false;
    }else{
        return true;
    }
}

function save(){
    $("#qno").val($("#id").val())
    var frm = $('#form_');
        loding();
        $.ajax({
      type: frm.attr('method'),
      url: frm.attr('action'),
      data: frm.serialize(),
      success: function (pid){
        if(pid == 1){
            loding();
            $("#org_print").val("1");
            $("#btnSave").attr("disabled",true);
            if(confirm("Save Completed, Do You Want A print?")){
                if($("#is_prnt").val()==1){
                    $("#print_pdf").submit();
                }
                reload_form();
            }else{
                location.href="";
            }
        }else{
            loding();
            set_msg(pid);
        }
      }
    });
}

function reload_form(){
  setTimeout(function(){
    location.href= '';
  },50); 
}


function set_delete(){
    var id = $("#hid").val();
    if(id != 0){
        if(confirm("Are you sure to delete this settu loading request no ["+$("#hid").val()+"]? ")){
            $.post("index.php/main/delete/t_settu_item_req", {
            trans_no:id,
            seettu_id:$("#seettu_id").val()
        },function(r){
          if(r != 1){
            set_msg(r);
          }else{
            delete_msg();
          }
        }, "text");
    }
  }else{
    set_msg("Please load record","error");
  }
}
    
function load_data(no){
   loding();
    $.post("index.php/main/get_data/t_settu_item_req", {
       no : no     
    }, function(res){
		   loding();
        if(res=="2"){
            set_msg("No records");
        }else{
            empty_grid();
            $("#id").val(no);
            $("#hid").val(no);
            $("#qno").val(no);
            $("#date").val(res.sum[0].ddate); 
            $("#ref_no").val(res.sum[0].ref_no);
            $("#organizer_id").val(res.sum[0].orgernizer);
            $("#organizer_name").val(res.sum[0].name);
            $("#seettu_id").val(res.sum[0].settu_no);
            $("#root").val(res.sum[0].root);
            load_pending_tots(res.sum[0].orgernizer,res.sum[0].root);
            for(var i=0; i<res.det.length;i++){
                $("#n_"+i).val(res.det[i].c_code);
                $("#1_"+i).val(res.det[i].code);
                $("#2_"+i).val(res.det[i].name);
                $("#0_"+i).attr("checked",true);
            }
            if(res.sum[0].is_cancel==1){
                $("#btnDelete").attr("disabled", "disabled");
                $("#btnSave").attr("disabled", "disabled");
                $("#mframe").css("background-image", "url('img/cancel.png')");
            }
        }
    }, "json");
}