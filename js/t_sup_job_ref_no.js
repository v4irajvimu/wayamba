$(document).ready(function(){
    
/*$(".gridTr").dblclick(function(){
    var thid=$(this).attr("id");
    $(".gridTr").removeClass("tgrid5");    
    $(this).addClass("tgrid5");
       $("#SJRNo").val($('#'+thid).find('td:eq(9)').text());
       $("#UpCode").val(thid);
         //alert();
//alert("alt");
    var alt="<p>Job No : "+$('#'+thid).find('td:eq(1)').text()+"</p>";
        alt+="<p>Inv.Date : "+$('#'+thid).find('td:eq(2)').text()+"</p>";
        alt+="<p>Inv.Type : "+$('#'+thid).find('td:eq(3)').text()+"</p>";
        alt+="<p>Inv.No : "+$('#'+thid).find('td:eq(4)').text()+"</p>";
        alt+="<p>Item Code : "+$('#'+thid).find('td:eq(5)').text()+"</p>";
        alt+="<p>Item : "+$('#'+thid).find('td:eq(6)').text()+"</p>";
        alt+="<p>Customer : "+$('#'+thid).find('td:eq(7)').text()+"</p>";
        alt+="<p>Amount : "+$('#'+thid).find('td:eq(8)').text()+"</p>";
        alt+="<hr/>";
        alt+="<p>Supplier Job Referance No</p>";
        alt+="<input type='text' class='input_text' id='SJRNo' value='"+$('#'+thid).find('td:eq(9)').text()+"'/>";
        alt+="<input type='button' value='Add' id='"+thid+"' onClick='addSuNo();'/>";
        alt+="<input type='hidden' value='"+thid+"' id='UpCode'/>";

        // 
        $("#LdData").html(alt);

    });*/

    $("#serc_id ,#sup_id").keyup(function(e){ 
        scrch_itm();
    });

    $("#sup_id").keyup(function(e){  
        if(e.keyCode==112){
          $("#pop_search2").val($("#sup_id").val());
          load_sup();
          $("#serch_pop2").center();
          $("#blocker2").css("display", "block");
          setTimeout("$('#pop_search2').focus()", 100);   
        }

        $("#pop_search2").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_sup();
          }
        });
        if(e.keyCode==46){
           $("#sup_id").val("");
           $("#sup_nm").val("");
            scrch_itm();  
        }  


    });
});

function addSuNo(){

    if ($("#UpCode").val()=="") {
            set_msg('Please Double Click Row to Add Suppliers Job Referance Numbers'); 
    } else if ($("#SJRNo").val()==""){
            set_msg('Please Enter Supplier Job Referance No');        
    }
    else{
        
    
    var Upc=$("#UpCode").val();
    var Sjn=$("#SJRNo").val();

        $.post("index.php/main/save/t_sup_job_ref_no", {
            'Upc':Upc,'Sjn':Sjn
        }, function(r){
            if (r==1) {
                loding();
            sucess_msg();
            }
            else{
                error_maz();
                
            };
            
            //alert(r);           
        }, "text");
    };
}


function load_sup(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_supplier",
      field:"code",
      field2:"name",
      preview2:"Supplier Name",
      search : $("#pop_search2").val() 
  }, function(r){
      $("#sr2").html(r);
      settings_sup();      
 }, "text");
}

function settings_sup(){
    $("#item_list .cl").click(function(){        
        $("#sup_id").val($(this).children().eq(0).html());
        $("#sup_nm").val($(this).children().eq(1).html());
        $("#pop_close2").click();  
        scrch_itm();              
    })   

}


function scrch_itm(){
    $("#UpCode").val("");
    $("#SJRNo").val("");

    var sid=$("#sup_id").val(); 
    var code=$("#serc_id").val(); 

    //alert(code+" "+sid);
    $.post("index.php/main/load_data/t_sup_job_ref_no/get_Su_data", {
        code:code,sid:sid
    }, function(r){
        $("#GtGrData").html(r);
    }, "text");
}

function onDclik(thid){

    //var thid=$(this).attr("id");

    $(".gridTr").removeClass("tgrid5");    
    $('#'+thid).addClass("tgrid5");
       $("#SJRNo").val($('#'+thid).find('td:eq(9)').text());
       $("#UpCode").val(thid);
}
