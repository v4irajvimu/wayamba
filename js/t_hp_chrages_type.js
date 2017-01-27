$(document).ready(function()
{
	$("#value").keypress(function(e){
    if(e.keyCode == 112)
    {
    	$("#pop_search4").val($("#value").val());
        load_hp_charges();
        $("#serch_pop4").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search4').focus()", 100);
    }
    $("#pop_search4").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
             load_hp_charges();

        }
    }); 
    if(e.keyCode == 46){
        $("#value").val("");
        $("#value_des").val("");
    }

  });
$("#btnSavee").click(function(){
	
   if(validate())
    {
    	
        save();
    }  
    });
$("#code").keyup(function(e){
if(e.keyCode==13){

  load_data($("#code").val());
}
});

$("#srchee").keyup(function(){  
    $.post("index.php/main/load_data/utility/get_data_table", {
          code:$("#srchee").val(),
          tbl:"r_hp_chargers_type",
          tbl_fied_names:"Code-Description",
          fied_names:"code-description"
          
          }, function(r){
      $("#grid_body").html(r);
      }, "text");
  });
});

function load_hp_charges(){
      $.post("index.php/main/load_data/utility/f1_selection_chrages_type", {
          data_tbl:"r_hp_chargers_type",
          field:"value",
          field2:"name",
          preview2:"Supplier Name",
          search : $("#pop_search4").val() 
      }, 
      function(r){
          $("#sr4").html(r);
          settings_supf1();            
      }, "text");
  }

  function settings_supf1(){
      $("#item_list .cl").click(
        function(){        
          $("#value").val($(this).children().eq(0).html());
          $("#value_des").val($(this).children().eq(1).html());
          $("#pop_close4").click();                
      })    
  }

  function validate()
  {
  	if($("#code").val() === $("#code").attr('title') || $("#code").val() == ""){
        set_msg("Please enter code.","error");
        $("#code").focus();
        return false;
    }
    else if($("#des").val() === $("#des").attr('title') || $("#code").val() == ""){
    	set_msg("Please enter Name.","error");
        $("#des").focus();
        return false;
    }
    else if($("#value").val() === $("#value").attr('title') || $("#value").val() == ""){
    	set_msg("Please select Value.","error");
        $("#value").focus();
        return false;
    }
    else if($("#amount").val() === $("#amount").attr('title') || $("#amount").val() == ""){
    	set_msg("Please enter amount.","error");
        $("#amount").focus();
        return false;
    }
    else
    {
    	return true;
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
                location.href = '';
            } else if (pid == 2) {
                set_msg("No permission to add data.");
            } else if (pid == 3) {
                set_msg("No permission to edit data.");
            } else {
                set_msg(pid);
            }
            loding();
        }
    });
}

function get_data_table(){alert();
    $.post("index.php/main/load_data/t_hp_charges_type/get_data_table", {
       
    }, function(r){ 
        $("#grid_body").html(r);
    }, "text");
}

function load_data(id){
    loding();
    $.post("index.php/main/get_data/t_hp_charges_type/", {
        id:id
    },function (r) {

        if (r == "2") {
            alert("No records");
        } else {
            $("#code").val(r.add[0].code);
            $("#hid").val(r.add[0].code);
            $("#code").attr("readonly",true);
            $("#des").val(r.add[0].description);
            $("#value").val(r.add[0].acc_code);
            $("#value_des").val(r.add[0].acc_description);
            $("#amount").val(r.add[0].amount);
        }
        loding();
    }, "json");
  }

  function set_edit(id){
    loding();
    $.post("index.php/main/get_data/t_hp_charges_type", {
        id : id
    }, function(res){
     
        $("#code").val(res.add[0].code);
        $("#code").attr("readonly", true);
        $("#hid").val(res.add[0].code);
        $("#des").val(res.add[0].description);
        $("#value").val(res.add[0].acc_code);
        $("#value_des").val(res.add[0].acc_description);
        $("#amount").val(res.add[0].amount);
        
        //is_edit('018');
        loding(); input_active();
    }, "json");
}

function set_delete(id){

    if(confirm("Are you sure delete "+id+"?")){
       loding();
       $.post("index.php/main/delete/t_hp_charges_type", {
           id : id
       }, function(res){
           if(res == 1){
               loding();
               delete_msg();
           }else{
              loding();
               set_msg(res);

           }           
       }, "text");
   }
 
} 
  