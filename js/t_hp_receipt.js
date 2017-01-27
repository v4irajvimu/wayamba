var search_module = "";

$(document).ready(function(){
        
    $("#pop_search").gselect();

    $(".load_popup").click(function(){
        $("#blocker").css("display", "block");
        $("#serch_pop").center();
        $("#pop_search").css("display", "none");
        var q = $(this).attr("data");

        $.post("index.php/main/load_data/t_hp_receipt/get_details", {
            stat : q
        }, function(res){

        }, "json");
    });

























$("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40  && e.keyCode != 112) { 
        load_search();
    }
});

$("#code").keyup(function(e){
    $("#sr").html("");    
    $("#pop_search").focus();
    search_module = $(this).attr("mod_code");

    if(e.keyCode==112){        
        $("#pop_search").select();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
    }
});

$("#code").keyup(function(e){

    $("#sr").html("");    
    $("#pop_search").focus();
    search_module = $(this).attr("mod_code");

    if(e.keyCode==112){
        $("#pop_search").select();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
    }
});

$("#agreement_no").keyup(function(e){    
    $("#sr").html("");    
    $("#pop_search").focus();
    $("#pop_search").focus();
    search_module = $(this).attr("mod_code");

    if(e.keyCode==112){            
        $("#pop_search").select();       
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
    }
});












































    $("#load_req_duplecate").css("display","none");
    

     
    $("#tgrid").tableScroll({height:355});

    $("#load_req").click(function(){
        if($("#supplier_id").val()!="" || $("#supplier").val()!=""){
		load_request_note();
        }else{
            alert("Please select supplier");
        }

    });

    $(".fo").keypress(function(e){
        set_cid($(this).attr("id"));

        if(e.keyCode=='112'){
            $("#pop_search").val($("#0_"+scid).val());
            load_items();    
            $("#serch_pop").center();
            $("#blocker").css("display", "block");
            setTimeout("select_search()", 100);

        }

        if(e.keyCode==13){
            $.post("index.php/main/load_data/t_po_sum/get_item", {
                code:$("#0_"+scid).val()
            }, function(res){
                if(res.a!=2){
                  $("#0_"+scid).val(res.a[0].code);
                  if(check_item_exist($("#0_"+scid).val())){

                    $("#h_"+scid).val(res.a[0].code);
                    $("#0_"+scid).val(res.a[0].code);
                    $("#n_"+scid).val(res.a[0].description);
                    $("#1_"+scid).val(res.a[0].model);
                    $("#2_"+scid).val(res.a[0].qty);
                    $("#4_"+scid).val(res.a[0].purchase_price);
                    
                    $("#3_"+scid).focus();
                    $("#pono").addClass("hid_value"); 
                  }else{
                    alert("Item "+$("#0_"+scid).val()+" is already added.");
                  }
                }else{
                  set_msg($("#0_"+scid).val()+" Item not available in item list","error");
                  $("#0_"+scid).val("");
                }
                }, "json");
            }
            

        if(e.keyCode=='46'){
            $("#0_"+scid).val("");
            $("#n_"+scid).val("");
            $("#1_"+scid).val("");
            $("#2_"+scid).val("");
            $("#3_"+scid).val("");
            $("#4_"+scid).val("");
            $("#5_"+scid).val("");

        }

    });

    $("#btnDelete").click(function(){
       if($("#hid").val()!=0) {
            set_delete($("#hid").val());
       }
    });

    $("#btnPrint").click(function(){
    	if($("#hid").val()=="0")
    	{
    		alert("Please load data before print");
        	return false;
    	}
    	else{
        $("#print_pdf").submit();
    	}


    });

    $("#supplier_id").change(function(){
        empty_grid();
    });

    $("#supplier_id").autocomplete('index.php/main/load_data/m_supplier/auto_com', {
        width: 350,
        multiple: false,
        matchContains: true,
        formatItem: formatItems,
        formatResult: formatItemsResult
        });
   

        $("#supplier_id").keypress(function(e){
            if(e.keyCode == 13){
                set_cus_values($(this));
            }
        });
    
        $("#supplier_id").blur(function(){
            set_cus_values($(this));
        });    

       $(".qty, .price").blur(function(){


           set_cid($(this).attr("id"));
           var qty=parseFloat($("#3_"+scid).val());
           var price=parseFloat($("#4_"+scid).val());
         
           if(isNaN(qty)){ qty=0; }
           if(isNaN(price)){ price=0; }

           var amount=qty*price;
           if(amount==0){amount="";}else{
             $("#5_"+scid).val(m_round(amount));
           }
          

           var loop=total_amount=0; 

           $(".amount").each(function(){

           var get_amount=parseFloat($("#5_"+loop).val()); 
           if(isNaN(get_amount)){ get_amount=0;}
           total_amount=total_amount+get_amount;
           loop++;
           });



           $("#total2").val(m_round(total_amount));


      });


         $("#id").keypress(function(e){
            if(e.keyCode == 13){
                $(this).blur();
                load_data($(this).val());
                $("#load_req").css("display","none");
                $("#load_req_duplecate").css("display","inline");
            }
        });
});


function load_search(){

    if (search_module == "customer"){
        $.post("index.php/main/load_data/utility/f1_selection_list", {
            search : $("#pop_search").val(),
            field2 :'name',
            add_query:'',
            data_tbl:'m_customer'
        }, function(r){
            $("#sr").html(r);
            settings();
        }, "text");    
    }else if(search_module == "Agreement No"){
        $.post("index.php/main/load_data/utility/f1_selection_list", {
            search : $("#pop_search").val(),
            field  : "agreement_no",
            field2 :'agreement_no',
            add_query:'',
            data_tbl:'t_hp_sales_sum'
        }, function(r){
            $("#sr").html(r);
            settings();
        }, "text");
    }

}


function set_cus_values(f){
            var v = f.val();
            v = v.split("|");
             if(v.length == 2){
                f.val(v[0]);
                $("#supplier").val(v[1]);
               // $("#supplier").attr("class", "input_txt_f");

        }
    }


    function formatItems(row){
        return "<strong> " +row[0] + "</strong> | <strong> " +row[1] + "</strong>";
    }

    function formatItemsResult(row){
        return row[0]+"|"+row[1];
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
                location.href='';   
            }else if(pid == 2){
                alert("No permission to add data.");
            }else if(pid == 3){
                alert("No permission to edit data.");
            }else{
                alert(pid);
            }
            loding();            
        }
    });
}



function validate(){
    if($("#id").val()==""){
        alert("Please enter id");
        return false
    }else if($("#supplier_id").val()=="" || $("#supplier").val()==""){
        alert("Please enter supplier.");
        return false;
    }else{
        return true;
    }
}
    
function set_delete(id){
    if(confirm("Are you sure to delete transaction no "+id+"?")){
        loding();
        $.post("index.php/main/delete/t_po_sum", {
            id : id
        }, function(res){
            if(res == 1){
                location.href="";
            }else if(res == 2){
                alert("No permission to delete data.");
            }else{
                set_msg(res);
            }
            loding();
        }, "text");
    }
}

function is_edit($mod)
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
    
function set_edit(code){
    loding();
    $.post("index.php/main/get_data/t_po_sum", {
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
        
        
        
       // is_edit('010');
        loding(); input_active();
    }, "json");
}


function select_search(){
    $("#pop_search").focus();   
}

function load_items(){
    $.post("index.php/main/load_data/t_po_sum/item_list_all", {
        search : $("#pop_search").val(),
        stores : false
    }, function(r){
        $("#sr").html(r);
        settings();
        
    }, "text");
}

function settings(){
    $("#item_list .cl").click(function(){        
        
        if (search_module == "customer"){
            $("#code").val($(this).children().eq(0).html());
            $("#name").val($(this).children().eq(1).html());            
        }else if(search_module == "Agreement No"){
            $("#agreement_no").val($(this).children().eq(1).html());
        }else{
            
        }       

        $("#pop_search").val("");
        $("#pop_close").click();
    });
}

function check_item_exist(id){
    var v = true;
    $("input[type='hidden']").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });
    
    return v;
}

function load_request_note(){
    empty_grid();
     $.post("index.php/main/load_data/t_po_sum/load_request_note",{
                supplier:$("#supplier_id").val()
              },function(r){
              	if(r.det!=2){
                	
                     for(var i=0; i<r.det.length;i++){
                        $("#h_"+i).val(r.det[i].item);
                        $("#0_"+i).val(r.det[i].item);
                        $("#n_"+i).val(r.det[i].description);
                        $("#1_"+i).val(r.det[i].model);
                        $("#2_"+i).val(r.det[i].cur_qty);
                        $("#3_"+i).val(r.det[i].approve_qty);
                        $("#4_"+i).val(r.det[i].purchase_price);
                        $("#5_"+i).val(r.det[i].total);                
                    }
                     $(".price").blur();
                }else{
                    alert("No Data");
                }
  },"json");
}


function load_data(id){
    empty_grid();
    loding();
    $.post("index.php/main/get_data/t_po_sum/", {
        id: id
    }, function(r){

            if(r=="2"){
               alert("No records");
            }else{
                if(r.sum[0].is_cancel=="1"){
                    
                    $("#mframe").css("background-image", "url('img/cancel.png')");
                    $("#btnSave").attr('disabled','disabled');
                    $("#btnDelete").attr('disabled','disabled');
                    
                }

            $("#hid").val(id);   
            $("#id").val(id); 
            $("#qno").val(id); 
            $("#supplier_id").val(r.supplier[0].supp_id);
            $("#supplier").val(r.supplier[0].name);
            $("#rep_sup").val(r.supplier[0].supp_id);
            $("#memo").val(r.sum[0].comment);
            $("#date").val(r.sum[0].ddate); 
            $("#ref_no").val(r.sum[0].ref_no);
            $("#total2").val(r.sum[0].total_amount);
            $("#deliver_date").val(r.sum[0].deliver_date);
            $("#ship_to_bc").val(r.sum[0].ship_to_bc);
            $("#rep_date").val(r.sum[0].ddate);
            $("#rep_deliver_date").val(r.sum[0].deliver_date);

            for(var i=0; i<r.det.length;i++){
                $("#h_"+i).val(r.det[i].item);
                $("#0_"+i).val(r.det[i].item);
                $("#n_"+i).val(r.det[i].description);
                $("#1_"+i).val(r.det[i].model);
                $("#2_"+i).val(r.det[i].current_qty);
                $("#3_"+i).val(r.det[i].qty);
                $("#4_"+i).val(r.det[i].cost);
                $("#5_"+i).val(r.det[i].amount);
            }

            
            }

            loding();
        }, "json");

  
}


 function empty_grid(){
    for(var i=0; i<25; i++){
        $("#h_"+i).val(0);
        $("#0_"+i).val("");
        $("#n_"+i).val("");
        $("#t_"+i).html("&nbsp;");
        $("#1_"+i).val("");
        $("#2_"+i).val("");
        $("#3_"+i).val("");
        $("#5_"+i).val("");
        $("#4_"+i).val("");
        $("#6_"+i).val("");
        $("#7_"+i).val("");
        $("#8_"+i).val("");
        $("#9_"+i).val("");
        
    }

}
