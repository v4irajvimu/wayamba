$(document).ready(function(){
      
  $("#codes").blur(function(){
    check_code($(this).val());
  });

  $("#srchee").keyup(function(){  
    $.post("index.php/main/load_data/m_settu_book_edition/search_result", {
            code:$("#srchee").val(),
        }, function(r){
          $("#grid_body").html(r);
      }, "text");
  });

  $("#btnPrint").click(function(){
    if($("#hid").val()=="0"){
      set_msg("Please load data before print");
      return false;
    }else{
      $("#print_pdf").submit();
    }
  });
    
});

function check_code(code){
  loding();
  $.post("index.php/main/load_data/m_settu_book_edition/check_code", {
      code : code
  }, function(res){
    if(res == 1){
      if(confirm("This code ("+code+") already added. \n\n Do you need edit it?")){
          set_edit(code);
      }else{
          $("#codes").val('');
          $("#code_").val('');
      }
    }
    loding();
  }, "text");
}

function validate(){
    if($("#codes").val()==""){
      set_msg("Please enter code");
      $("#codes").focus();
      return false;
    }else if($("#des").val()==""){
      set_msg("Please enter description");
      $("#des").focus();
      return false;
    }else{
      return true;
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

function empty_grid(){
  $("#codes").val("");
  $("#code_").val("");
  $("#des").val("");
  $("#note").val("");
  $("#is_active").attr("checked",false);
}

function set_edit(code){
    empty_grid();
    loding();
    $.post("index.php/main/get_data/m_settu_book_edition", {
        code : code
    }, function(res){
        $("#codes").val(res[0].code);
        $("#codes").attr("readonly",true);
        $("#code_").val(res[0].code);
        $("#des").val(res[0].description);
        $("#note").val(res[0].note);
        if(res[0].is_active=="1"){
          $("#is_active").attr("checked",true);
        }
        loding(); 
    }, "json");
}

function set_delete(code){
  if(confirm("Are you sure delete "+code+"?")){
    loding();
    $.post("index.php/main/delete/m_settu_book_edition", {
       code : code
    },function(res){
      if(res == 1){
        loding();
        delete_msg();
      }else{
        set_msg(res);
      }
    }, "text");
  }
}