
$(document).ready(function(){

	//var myString = $(location).attr('href').split("&num=")[1];
	
	
    $("#code").blur(function(){
        check_code();
    });
    
    
    $("#grid").tableScroll({height:355,width:590});
    
    $("#sub_region").change(function(){
        set_select('sub_region', 'sr_des');
    });
    
    $("#sales_ref").change(function(){
        set_select('sales_ref', 'sre_des');
    });


    $("#srchee").keyup(function(){  
 	$.post("index.php/main/load_data/utility/get_data_table", {
	                code:$("#srchee").val(),
	                tbl:"r_area",
	                tbl_fied_names:"Code-Description",
	        		fied_names:"code-description"
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
                set_msg("No permission to add data.");
            }else if(pid == 3){
                set_msg("No permission to edit data.");
            }else{
                set_msg(pid);
            }
            
        }
    });
}


function check_code(){
    var code = $("#code").val();
    $.post("index.php/main/load_data/r_area/check_code", {
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


function get_data_table(){
    $.post("/index.php/main/load_data/r_area/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}

function validate(){
    if($("#code").val() == ""){
            set_msg("Please enter code.");
            $("#code").focus();
            return false;
        }else if($("#des").val() === $("#des").attr('title') || $("#des").val() == ""){
            set_msg("Please enter description.");
            $("#des").focus();
            return false;
        }else{
            return true;
        }
}
    
function set_delete(code){
       if(confirm("Are you sure delete "+code+"?")){
       loding();
        $.post("index.php/main/delete/r_area", {
            code : code
        }, function(res){
            if(res == 1){
                loding();
                delete_msg();
            }else{
                set_msg(res);
            }
        }, "text");
    }
}
    
function set_edit(code){
    loding();
    //var ajaxTime= new Date().getTime();
    $.post("index.php/main/get_data/r_area", {
        code : code
    }, function(res){


        //var totalTime = new Date().getTime()-ajaxTime;
        //alert(totalTime);
		loding(); 
        $("#code_").val(res.code);
        $("#code").val(res.code);
        $("#max_nno").val(res.max_no);
        $("#code").attr("readonly", true);
        $("#des").val(res.description);
        
           
	   input_active();
    }, "json");
}

/*
function set_edit(code){
    loding();
    //var ajaxTime= new Date().getTime();
    $.post("index.php/main/get_data/r_area", {
        code : code
    }, function(res){},
    progress: function(e) {
                 console.log(e);
                if(e.lengthComputable) {
                    //calculate the percentage loaded
                    var pct = (e.loaded / e.total) * 100;

                    //log percentage loaded
                    //console.log(pct);
                    $('#progress').html(pct.toPrecision(3) + '%');
                }
                //this usually happens when Content-Length isn't set
                else {
                    console.warn('Content Length not reported!');
                }
            }       
    , "json");
}*/