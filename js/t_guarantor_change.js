$(document).ready(function(){



    $("#new_g1").keypress(function (e) {
        if (e.keyCode == 112) {
            $("#pop_search13").val($("#new_g1").val());
            load_data7();
            $("#serch_pop13").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search13').focus();", 100);
        }
        $("#pop_search13").keyup(function (e) {
            if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112) {
                load_data7();
            }
        });
        if(e.keyCode== 46){
            $("#new_g1").val("");
            $("#new_gn1").val("");
        }
    });

    $("#new_g2").keypress(function (e) {
        if (e.keyCode == 112) {
            $("#pop_search13").val($("#new_g2").val());
            load_data8();
            $("#serch_pop13").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search13').focus();", 100);
        }
        $("#pop_search13").keyup(function (e) {
            if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112) {
                load_data8();
            }
        });
        if(e.keyCode== 46){
            $("#new_g2").val("");
            $("#new_gn2").val("");
        }
    });




    $("#btnPrint").click(function(){
        $('#print_pdf').submit();
    });

    $("#no").keypress(function(e){

        if (e.keyCode == 13){

            $.post("index.php/main/load_data/t_guarantor_change/load_data", {           
                no : $("#no").val()
            }, function (res) {

                if (res.a ==1){
                    $("#btn_Save").attr("disabled",true);
                    $("#agreement_no").val(res.sum.agr_no);
                    $("#customer_id").val(res.sum.cus_id);
                    $("#customer_name").val(res.sum.name);                                                           
                    $("#date").val(res.sum.date);
                    $("#qno").val($("#no").val());
                    $("#address").val(res.sum.address);
                }else{
                    alert("no data found");
                    location.href = "";
                }

            }, "json");

        }

    });


    $("#btn_Save").click(function(){
        save();
    });

    $("#btn_Reset").click(function(){

        $("#btn_Save").attr("disabled",false);
        location.href = "";

    });


    $("#agreement_no").keypress(function(e){       

        if(e.keyCode == 112){
            $("#pop_search6").val();
            if($("#multi_branch").is(":checked")){
                load_data_agr("m");
            }else{
                load_data_agr("s");
            }            
            $("#serch_pop6").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search6').focus()", 100);
        }

        $("#pop_search6").keyup(function(e){            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                if($("#multi_branch").is(":checked")){
                    load_data_agr("m");
                }else{
                    load_data_agr("s");
                } 
            }
        });

        if(e.keyCode == 46){
            $("#agreement_no").val("");
            $("#customer").val("");
            $("#customer_id").val("");
            $("#ins_id").val("");
        }
    });


});

function load_data_agr(bc){
    loding();
    var agr_no = $("#agreement_no").val();
    $.post("index.php/main/load_data/t_hp_instalment_payment/load_agreement_no", {
        search: $('#pop_search6').val(),
        is_multi:bc
    }, function (res) {
        if (res != 2) {
            $("#sr6").html(res);
            settings_agr_no();
        }
        loding();
    }, "text");
}

function settings_agr_no(){
    $("#item_list .cl").click(function(){       
        
        $("#agreement_no").val($(this).children().eq(0).html());        
        load_agr();        
        
    })    
}

function load_agr(){

    $("#pop_close6").click();

    $.post("index.php/main/load_data/t_guarantor_change/load_agreement", {
        agr_no : $("#agreement_no").val()
    }, function (res) {

        $("#customer_id").val(res.b.code);
        $("#customer_name").val(res.b.name);       
        $("#address").val(res.b.address);       

        $("#g1_h").val(res.b.guarantor_01);
        $("#g2_h").val(res.b.guarantor_02);

        var T = "";

        for (num = 0 ; num < res.g.length ; num++){

            if (num == 0){
                T += "<tr><td class='defualt_g'>"+res.g[num].date+"</td><td class='defualt_g'>"+res.g[num].g1+" - "+res.g[num].n1+"</td><td class='defualt_g'>"+res.g[num].g2+" - "+res.g[num].n2+"</td><td></td><td></td></tr>";
            }else{
                T += "<tr><td class='non_defualt_g'>"+res.g[num].date+"</td><td class='non_defualt_g'>"+res.g[num].g1+" - "+res.g[num].n1+"</td><td class='non_defualt_g'>"+res.g[num].g2+" - "+res.g[num].n2+"</td><td></td><td></td></tr>";
            }

        }

        $(".tbl_agr_list tfoot").html("").append(T);


    }, "json");


    
}

function load_agri(){
    loding();
    
    $.post("index.php/main/load_data/t_hp_other_charges/load_agreement_no", {
        
    }, function (res) {
        
        loding();
    }, "text");
}

function save(){    

    if ($("#agreement_no").val() == ""){
        alert("Please select agreement number");
        return;
    }

    if ($("#new_g1").val() == "" && $("#new_g2").val() == ""){
        alert("Please enter new guarantor");
        return;
    }

      
    var frm = $('#form_');
    loding();
    
    $.ajax({
	   type: frm.attr('method'),
	   url: frm.attr('action'),
	   data: frm.serialize(),
	   success: function (pid){
            alert("Guarantor(s) changed");
            location.href = "";
       }
    });

}


function load_data7() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl: "m_guarantor",
        field: "code",
        field2: "full_name",
        search: $("#pop_search13").val()
    }, function (r) {
        $("#sr13").html(r);
        common_setting('#new_g1','#new_gn1','#pop_close13');
    }, "text");
}

function load_data8() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl: "m_guarantor",
        field: "code",
        field2: "full_name",
        search: $("#pop_search13").val()
    }, function (r) {
        $("#sr13").html(r);
        common_setting('#new_g2','#new_gn2','#pop_close13');
    }, "text");
}

function common_setting(code,name,close){
    $("#item_list .cl").click(function () {
        $(code).val($(this).children().eq(0).html());
        $(name).val($(this).children().eq(1).html());
        $(close).click();
    })
}
  

