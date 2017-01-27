/*function save(){
    $("#form_").submit();
}*/

function save(){
    var frm = $('#form_');
    loding();
    $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (pid){
           if(pid == 1){
              $("#btnSave").attr("disabled",true);
              loding();
              sucess_msg();
              //location.href="";
            }else{
                loding();
                set_msg(pid,"error");
            }
        }
    });
}



function validate(){
    return true;
}