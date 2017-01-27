$(document).ready(function(){

    $("#code").blur(function(){
       check_code();
    });

   $("#grid").tableScroll({height:355, width:590});

   
   $("#btnReset").click(function(){
   	location.href="";
   });


    $("#book_no").keypress(function(e){
        if(e.keyCode == 112){
          $("#pop_search2").val($("#book_no").val());
          load_book();
          $("#serch_pop2").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search2').focus()", 100);
        }
        $("#pop_search2").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_book();
          }
        }); 
        if(e.keyCode == 46){
          $("#book_no").val("");
          $("#book_des").val("");
        }
    });

  $("#srchee").keyup(function(){  
		$.post("index.php/main/load_data/m_settu_item_category/get_data_table2", {
	        code:$("#srchee").val(),
	        
	        }, function(r){
	        $("#grid_body").html(r);
	    }, "text");
	});
});

function load_book(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_settu_book_edition",
      field:"code",
      field2:"description",
      preview2:"Edition Name",
      add_query:"AND is_active='1'",
      search : $("#pop_search2").val() 
  }, 
  function(r){
      $("#sr2").html(r);
      settings_book();        
  }, "text");
}

function settings_book(){
  $("#item_list .cl").click(function(){        
    $("#book_no").val($(this).children().eq(0).html());
    $("#book_des").val($(this).children().eq(1).html());
    $("#pop_close2").click();                
  })    
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
                sucess_msg();
            }else{
                set_msg("Error : \n"+pid);
            }
            loding();
      }
    });
}

function get_data_table(){
    $.post("index.php/main/load_data/m_settu_item_category/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}

function check_code(){
    var code = $("#book_no").val()+$("#code").val();
    $.post("index.php/main/load_data/m_settu_item_category/check_code", {
        code : code,
    }, function(res){
        if(res == 1){
            if(confirm("This code ("+$("#code").val()+") already added. \n\n Do you need edit it?")){
                set_edit(code);
            }else{
                $("#code").val('');
            }
        }
    }, "text");
}

function validate(){
    if($("#code").val() === $("#code").attr('title') || $("#code").val() == ""){
        set_msg("Please enter code.");
        $("#code").focus();
        return false;
    }else if($("#name").val() === $("#name").attr('title') || $("#name").val() == ""){
        set_msg("Please enter description.");
        $("#name").focus();
        return false;
    }else if($("#name").val() === $("#code").val()){
        set_msg("Please enter different values for description & code.");
        $("#name").focus();
        return false;
    }else if($("#book_no").val() == ""){
        set_msg("Please enter book edition.");
        $("#book_no").focus();
        return false;
    }else{
        return true;
    }
}
    
function set_delete(code){
 
   if(confirm("Are you sure delete "+code+"?")){
        loding();
        $.post("index.php/main/delete/m_settu_item_category", {
            code : code
        }, function(res){
            
            if(res == 1){
                delete_msg();
            }else{
                alert("Item deleting fail.");
            }
           loding();
        }, "text");
   }
}
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/m_settu_item_category", {
        code : code
    }, function(res){
		loding();
        $("#code_").val(res.code);
        $("#code").val(res.code);
        $("#book_no").val(res.book_edition);
        $("#book_des").val(res.b_name);
        $("#name").val(res.name);
        $("#value").val(res.value);
        $("#no_of_installment").val(res.no_of_installment);
         $("#installment_amount").val(res.installment_amount);
        

		if(res.sales==1){
			$("#sales").attr("checked", "checked");
			}else{
			$("#sales").removeAttr("checked");
		}
		if(res.purchase==1){
			$("#purchase").attr("checked", "checked");
			}else{
			$("#purchase").removeAttr("checked");
		}

       if(res.group_sale==1){
            $("#group_sale").attr("checked", "checked");
            }else{
            $("#group_sale").removeAttr("checked");
        }
  
	   input_active();
    
    }, "json");
}