var is_edit=0; 
$(document).ready(function(){

    $("#code").blur(function(){
        check_code();
		//check_ID();
    });
    
    $("#btnSave1").click(function(){


    if(validate()){

        check_permission();
    }  
     
    });

    $("#btnReset").click(function(){
   	location.href="?action=m_guarantor";
	});


    $("#btnPrint").click(function(){
     //set_msg('in print ');

        $("#print_pdf").submit();
     });


    $("#tgrid").tableScroll({height:200});
    $("#grid").tableScroll({height:355});
    
    $("#area").change(function(){
        set_select('area', 'area_id');
    });
    
    $("#nation").change(function(){
        set_select('nation', 'nationality');
    });

     $("#town").change(function(){
        set_select('town', 'town_id');
    });
    
     $("#root").change(function(){
        set_select('root', 'root_id');
    });

    $('#tabs').tabs();

    $('#cus_category').change(function(){
        set_select("cus_category","category");
    });

    
    $("#srchee").keyup(function(){  
	$.post("index.php/main/load_data/utility/get_data_table", {
	                code:$("#srchee").val(),
	                tbl:"m_guarantor",
	                tbl_fied_names:"Code-Name-T/P",
			        fied_names:"code-full_name-tp",
			        col4:"Y"
	             }, function(r){
	        $("#grid_body").html(r);
	    }, "text");
	});
	


});



function check_ID(){

	var ccode=$("#code").val();
	var code_num=ccode.substring(0,9);

	if($("#cus_type").val()=="1")
	{
		if(ccode.length=="10")
		{
			if(ccode.substring(9)=="v" || ccode.substring(9)=="V")
			{
				
				var intRegex = /^\d+$/;
				var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
				var str = code_num;
				if(intRegex.test(str) || floatRegex.test(str))
				{

				}  
  				else
				{
					set_msg('Please enter valid code','error');
					return false;
				}
			}
			else
			{
				set_msg("Please enter valid code","error");
			}
		}
		else
		{
			set_msg("Please enter valid code","error");
		}
	}
}

function check_level(){
    var l1 = parseFloat($("#l1").val());
    var l2 = parseFloat($("#l2").val());
    var l3 = parseFloat($("#l3").val());
    
    if(! isNaN(l2) && !isNaN(l3) && !isNaN(l3)){
        if((l1 < l2) && (l2 < l3)){
            return true;
        }else{
            set_msg("Please use credit limits correctly");
            return false;
        }
    }else{
        set_msg("Please use credit limits correctly");
        return false;
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
                location.href="";
                get_data_table();
                $('#form_')[0].reset(); 
            }else if(pid == 2){
                set_msg("No permission to add data.");
            }else if(pid == 3){
                set_msg("No permission to edit data.");
            }else{
                set_msg("Error : \n"+pid);
            }
            loding();
      }
    });
}


function get_data_table(){
    $.post("index.php/main/load_data/m_guarantor/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}



function check_code(){
    var code = $("#code").val();
    $.post("index.php/main/load_data/m_guarantor/check_code", {
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

	
    if($("#code").val() == "" || $("#code").val() == $("#code").attr("title") )
    {
        set_msg("Please enter code","error");
        $("#code").focus();
        return false;
    }
    else if($("#name").val() == "" || $("#name").val() == $("#name").attr("title"))
    {
        set_msg("Please enter name","error");
        $("#name").focus();
        return false;
    }
   if($("#full_name").val() == "" || $("#full_name").val() == $("#full_name").attr("title"))
    {
        set_msg("Please enter full name","error");
        $("#full_name").focus();
        return false;
    } 
    if($("#address1").val() == "" && $("#address2").val() == "" && $("#address3").val() == "" )
    {
        set_msg("Please enter address","error");
        return false;
    } 
    else 
    if($("#tp").val() == "" && $("#tp").val() == "" && $("#tp").val() == "" )
    {
        set_msg("Please enter telephone number","error");
        $("#tp").focus();
        return false;
    } 
    if($("#area").val() == 0)
    {
        set_msg("Please enter area","error");
        return false;
    } 
    
    else 
    {
    return true;
    }
}
    
function set_delete(code){
   if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/m_guarantor", {
            code : code
        }, function(res){
            if(res == 1){
                location.reload();
            }else{
                set_msg("Item deleting fail.");
            }
            loding();
        }, "text");
    }
}



    
function set_edit(code){
     loding();
    $("#code_find").attr({value:code,Title:code});
    $.post("index.php/main/get_data/m_guarantor", {
        code : code
    }, function(res){
        $("#code_").val(res.data.code);
        $("#code").val(res.data.code);
        $("#name").val(res.data.name);
        $("#full_name").val(res.data.full_name);
        $("#address1").val(res.data.address1);
        $("#address2").val(res.data.address2);
        $("#address3").val(res.data.address3);
        $("#tp").val(res.data.tp);
        $("#fax").val(res.data.fax);
        $("#mobile_number").val(res.data.mobile);
        $("#email").val(res.data.email);
        $("#relation").val(res.data.relation);
        $("#area").val(res.data.area);
        $("#occupation").val(res.data.occupation);
        $("#office_tp").val(res.data.office_tp);
        $("#epf").val(res.data.epf);
        $("#mobile").val(res.data.office_tp);
        $("#office_fax").val(res.data.office_fax);
        $("#salary").val(res.data.salary);
     
        if(res.data.is_black_list == 1){
            
            $("#is_black_list").attr('checked',true);
        }
        else{

            $("#is_black_list").attr('checked',false); 
        }

        $("#date").val(res.data.date);
        $("#reason").val(res.data.reason);
        $("#officer").val(res.data.officer);
      
     
        

            $("#area").val(res.data.area);
            set_select('area', 'area_id');

        loding(); 
        input_active();
        is_edit=1;
    }, "json");
}


