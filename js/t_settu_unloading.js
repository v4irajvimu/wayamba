$(document).ready(function(){

    $("#tgrid1").tableScroll({height:300, width:940});

    $("#unlod_id").keypress(function(e){
    if(e.keyCode == 13){
        $(this).blur();
        load_data($(this).val());
        $("#qno").val($('#unlod_id').val());
        
    }
  });

    $("#btnResett").click(function(){
        location.href="";
    });

    $("#btnDelete").click(function(){
        set_delete();
    });

     $("#btnPrint").click(function(){
        $("#print_pdf").submit();
      });

    $("#load_id").keypress(function(e){
        if(e.keyCode == 112){
            load_id();
            $("#serch_pop2").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search2').focus()", 100);
        }
        $("#pop_search2").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_id();
            }
        }); 
        if(e.keyCode == 46){
            $("#load_id").val("");
            $("#root_id").val("");
            $("#root_name").val("");
            $("#store_from_id").val("");
            $("#store_from_name").val("");
            $("#store_to_id").val("");
            $("#store_to_name").val("");
        }
    });  

    
});


function load_id(){
  $.post("index.php/main/load_data/t_settu_unloading/load_pending_loadings", {
      search : $("#pop_search2").val()
  }, function(r){
      $("#sr2").html(r);
      settings_load();     
 }, "text");
}

function settings_load(){
    $("#item_list .cl").click(function(){        
        $("#load_id").val($(this).children().eq(0).html());
        $("#root_id").val($(this).children().eq(3).html());
        $("#root_name").val($(this).children().eq(4).html());
        $("#store_from_id").val($(this).children().eq(5).html());
        $("#store_from_name").val($(this).children().eq(6).html());  
        $("#store_to_id").val($(this).children().eq(7).html());
        $("#store_to_name").val($(this).children().eq(8).html()); 
        load_grid($(this).children().eq(0).html()); 
        $("#pop_close2").click();                
    })    
}


function load_grid(load_id){
  $.post("index.php/main/load_data/t_settu_unloading/load_grid", {
        load_id : load_id,
    }, function(r){
      if(r=="2"){
        set_msg("No records");
      }else{
        for(var x=0; x<r.det.length; x++){
          $("#org_"+x).val(r.det[x].organizer);
          $("#n_"+x).val(r.det[x].name);
          $("#1_"+x).val(r.det[x].settu_no);
          $("#4_"+x).val(r.det[x].category);
          $("#refno_"+x).val(r.det[x].ref_code);
          $("#5_"+x).val(r.det[x].item);
          $("#6_"+x).val(r.det[x].des);                
          $("#check_"+x).css("display","block");
        }
      }
    }, "json");  
}


function validate(){

  if($("#load_id").val()==""){
       set_msg("Please Select Load No.");
        $("#load_id").focus();
        return false;
  }else{
        return true;
      }
    
}

function save(){
   $("#qno").val($('#unlod_id').val());
    var frm = $('#form_');
    loding();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (pid){   
            if(pid == 1){
                $("#btnSave").attr("disabled",true);
                if(confirm("Save Completed, Do You Want A print?")){
                    if($("#is_prnt").val()==1){
                        $("#print_pdf").submit();
                    }
                    reload_form();
                }else{
                    location.href="";
                }
                $("#btnSave").css("display","none");       
            }else if(pid == 2){
                set_msg("No permission to add data.");
            }else if(pid == 3){
                set_msg("No permission to edit data.");
            }else{
                set_msg(pid,"error");
            }
            loding();
        }
    });
}

function reload_form(){
  setTimeout(function(){
    location.href = '';
  },100); 
}

function load_data(id){

loding();
var g=[];
$.post("index.php/main/get_data/t_settu_unloading/", {
    no: id
}, function(r){
        if(r=="2"){
           set_msg("No records","error");
        }else{
          $("#hid").val(id);    
          $("#qno").val(id);    
          $("#unlod_id").attr("readonly","readonly") 
          $("#load_id").val(r.sum[0].load_no);            
          $("#root_id").val(r.sum[0].route);
          $("#root_name").val(r.sum[0].route_name);
          $("#store_from_id").val(r.sum[0].store_from);
          $("#store_from_name").val(r.sum[0].store_from_name);
          $("#store_to_id").val(r.sum[0].store_to);
          $("#store_to_name").val(r.sum[0].store_to_name);
          $("#date").val(r.sum[0].date);
          $("#ref_no").val(r.sum[0].ref_no);
          $("#memo").val(r.sum[0].memo);


     for(var i=0; i<r.det.length; i++){

        $("#n_"+i).val(r.det[i].name);
        $("#org_"+i).val(r.det[i].organizer);
        $("#1_"+i).val(r.det[i].seettu_no);
        $("#4_"+i).val(r.det[i].cat);
        $("#refno_"+i).val(r.det[i].category);
        $("#5_"+i).val(r.det[i].code);
        $("#6_"+i).val(r.det[i].des);
        $("#check_"+i).css("display","block");
        if((r.det[i].status)=="1"){  
        $("#check_"+i).attr("checked",true);
        
    }
            if(r.sum[0].is_cancel==1){
                $("#btnDelete").attr("disabled", "disabled");
                $("#btnSave").attr("disabled", "disabled");
                $("#mframe").css("background-image", "url('img/cancel.png')");
            }

          }
      }
        
      loding();
    }, "json");
}


function set_delete(){
    var id = $("#hid").val();
    if(id != 0){
        if(confirm("Are you sure to delete this settu loading request no ["+$("#hid").val()+"]? ")){
            $.post("index.php/main/delete/t_settu_unloading", {
            nno:id,
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


