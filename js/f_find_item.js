$(document).ready(function () {



    $("#searchType").change(function () {        
        if ($(this).val() == "customer"){
            set_BC_and_Cluster();
            load_items();
        }else{
            $("#div_cluster_dropdown").css("visibility","hidden");
            $("#div_branches_dropdown").css("visibility","hidden");
            load_items();
        }
    });

    $("#cluster_dropdown").change(function(){
        set_BC_by_cluster($(this).val());
        load_items();
    });

    $("#branches_dropdown").change(function(){        
        load_items();
    });


    $("#pop_searchs").keyup(function () {

        if ($("#searchType").val() == "0") {
            alert("Please select search type");
            return false;
        } else {
            load_items();
        }


    });


    //check_code();
    $("#grid").tableScroll({
        height: 355,
        width: 880
    });

    $(".fo").keypress(function (e) {
        set_cid($(this).attr("id"));
        if (e.keyCode == 112) {
            $("#pop_search").val($("#0_" + scid).val());
            load_items();
            $("#serch_pop").center();
            $("#blocker").css("display", "block");
            setTimeout("select_search()", 100);
        }

        if (e.keyCode == 46) {

            $("#h_" + scid).val("");
            $("#0_" + scid).val("");
            $("#n_" + scid).val("");
            $("#1_" + scid).val("");
            $("#2_" + scid).val("");
            $("#3_" + scid).val("");
            $("#4_" + scid).val("");
            $("#t_" + scid).html("&nbsp;");
        }
/*
        if(e.keyCode==13){
            $.post("/index.php/main/load_data/m_item_rol/get_item", {
                code:$("#0_"+scid).val()
            }, function(res){
                if(res.a!=2){
                    $("#0_"+scid).val(res.a[0].code);

                        if(check_item_exist($("#0_"+scid).val())){
                            $("#h_"+scid).val(res.a[0].code);
                            $("#n_"+scid).val(res.a[0].description);
                            $("#0_"+scid).val(res.a[0].code);
                            $("#2_"+scid).val(res.a[0].model);
                            $("#3_"+scid).val(res.a[0].rol);
                            $("#4_"+scid).val(res.a[0].roq);
                        }else{
                            alert("Item "+$("#0_"+scid).val()+" is already added.");
                        }

                }
            }, "json");

        }

        */
    });



    load_items();

    $("#pop_search").keyup(function (e) {
        if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40) {
            load_items();
        }
    });

    $("#pop_search").gselect();


});


// function auto_load_items(scid){
//              $("#0_"+scid).autocomplete('index.php/main/load_data/m_items/auto_com', {
//                 width: 500,
//                 multiple: false,
//                 matchContains: true,
//                 formatItem: formatItems,
//                 formatResult: formatItemsResult,
//                 delay: 500
//               });
//             $("#0_"+scid).keypress(function(e){
//                 if(e.keyCode == 13 || e.keyCode == 9){
//                     set_cus_values($(this),scid);
//                 }
//             });
//             $("#0_"+scid).blur(function(){
//                 set_cus_values($(this),scid);
//             });
// }

function set_BC_and_Cluster(){
    $.post("index.php/main/load_data/f_find_item/set_BC_and_Cluster", {

    }, function (r) {
        $("#cluster_dropdown").append(r.d1);
        $("#branches_dropdown").append(r.d2);
        $("#div_cluster_dropdown,#div_branches_dropdown").css("visibility","visible");
    }, "json");
}

function set_BC_by_cluster(cluster_id){
    $.post("index.php/main/load_data/f_find_item/set_BC_by_cluster", {
        cluster_id : cluster_id
    }, function (r) {
        $("#branches_dropdown").html("").html(r);
    }, "text");
}

function set_cus_values(f, scid) {

    var v = f.val();
    v = v.split("|");

    if (v.length == 5) {
        f.val(v[0]);

        if (check_item_exist(f.val())) {
            $("#h_" + scid).val(v[0]);
            $("#n_" + scid).val(v[1]);

            $("#2_" + scid).val(v[2]);
            $("#3_" + scid).val(v[3]);
            $("#4_" + scid).val(v[4]);
            $("#2_" + scid).focus();

        } else {


            alert("Item " + f.val() + " is already added.");

        }

    }
}


function formatItems(row) {
    return "<strong> " + row[0] + "</strong> | <strong> " + row[1];
}

function formatItemsResult(row) {
    return row[0] + "|" + row[1] + "|" + row[2] + "|" + row[3] + "|" + row[4];

}

function select_search() {
    $("#pop_search").focus();

}

function load_items() {
    $.post("index.php/main/load_data/f_find_item/item_list_all", {
        search: $("#pop_searchs").val(),
        type: $("#searchType").val(),
        cluster_id : $("#cluster_dropdown").val(),
        branch_id  : $("#branches_dropdown").val()
    }, function (r) {
        $("#searchLoad").html(r);
        settings();
        settings5();

    }, "text");
}

function load_itemss() {
    //empty_grid();
    //loding();
    $.post("index.php/main/load_data/f_find_item/item_list_alls", {
        search: $("#pop_searchs").val()
    }, function (r) {

        if (r == "2") {
            alert("No records");

        } else {

            for (var i = 0; i < r.det.length; i++) {
                $("#0_" + i).val(r.det[i].code);
                $("#n_" + i).val(r.det[i].description);
                $("#2_" + i).val(r.det[i].model);
                $("#3_" + i).val(r.det[i].min_price);
                $("#4_" + i).val(r.det[i].max_price);
            }
        }
        // loding();
    }, "json");
}


function settings() {
    $("#item_list .cl").click(function () {

        if ($(this).children().eq(0).html() != "&nbsp;") {

            if (check_item_exist($(this).children().eq(0).html())) {
                $("#h_" + scid).val($(this).children().eq(0).html());
                $("#0_" + scid).val($(this).children().eq(0).html());
                $("#n_" + scid).val($(this).children().eq(1).html());
                $("#2_" + scid).val($(this).children().eq(2).html());
                $("#3_" + scid).val($(this).children().eq(3).html());
                $("#4_" + scid).val($(this).children().eq(4).html());

                if ($(this).children().eq(4).html() == 1) {
                    $("#1_" + scid).autoNumeric({
                        mDec: 2
                    });
                } else {
                    $("#1_" + scid).autoNumeric({
                        mDec: 2
                    });
                }
                $("#1_" + scid).removeAttr("disabled");
                $("#2_" + scid).removeAttr("disabled");
                $("#3_" + scid).removeAttr("disabled");
                $("#1_" + scid).focus();
                $("#pop_close").click();
            } else {
                alert("Item " + $(this).children().eq(1).html() + " is already added.");
            }
        } else {
            $("#h_" + scid).val("");
            $("#0_" + scid).val("");
            $("#n_" + scid).val("");
            $("#1_" + scid).val("");
            $("#2_" + scid).val("");
            $("#3_" + scid).val("");
            $("#4_" + scid).val("");
            $("#t_" + scid).html("&nbsp;");
            $("#1_" + scid).attr("disabled", "disabled");
            $("#2_" + scid).attr("disabled", "disabled");
            $("#3_" + scid).attr("disabled", "disabled");
            $("#4_" + scid).attr("disabled", "disabled");

            $("#pop_close").click();
        }
    });
}


function settings5() {
    $(document).on('click', '#item_list .cl', function () {

       $(".cl").children().find('input').css('background-color', '#f9f9ec');
       $(this).children().find('input').css('background-color', '#6699ff');
       //$(this).children().find('input').toggleClass('colorRow');
       


        if ($(this).children().eq(0).html() != "&nbsp;") {

            $("#itm2").val($(this).children().find('input').eq(0).val());
            $("#des2").val($(this).children().find('input').eq(1).val());
            $("#mPrice2").val($(this).children().find('input').eq(3).val());
            $("#mxPrice2").val($(this).children().find('input').eq(4).val());
            $("#btch2").val($(this).children().find('input').eq(6).val());
            $("#qnty2").val($(this).children().find('input').eq(5).val());

            //alert($(this).children().eq(0).html());
        } else {
            $("#itm2").val("");
            $("#des2").val("");
            $("#mPrice2").val("");
            $("#mxPrice2").val("");
            $("#btch2").val("");
            $("#qnty2").val("");
            $("#pop_close").click();
        }
    });
}


function check_item_exist(id) {
    var v = true;
    $("input[type='hidden']").each(function () {
        if ($(this).val() == id) {
            v = false;
        }
    });

    return v;
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
                location.reload();

            } else if (pid == 2) {
                alert("No permission to add data.");
            } else if (pid == 3) {
                alert("No permission to edit data.");
            } else {
                alert("Error : \n" + pid);
            }
            loding();
        }
    });
}

/*function get_data_table(){
    $.post("/index.php/main/load_data/m_item_rol/get_data_table", {
        
    }, function(r){
        $("#grid_body").html(r);
    }, "text");
}


function check_code(){
        //loding();
    var bc = $("#bc").val();
    
    $.post("index.php/main/load_data/m_item_rol/check_code", {
        bc : bc
    }, function(res){
        if(res == 1){
         set_edit(bc);
        }
       // loding();
    }, "text");
}
*/



function validate() {
    var v = false;
    $("input[type='hidden']").each(function () {
        if ($(this).val() != "" && $(this).val() != 0) {
            v = true;
        }
    });

    if (v == false) {
        alert("Please use minimum one item.");
    } else if ($("#stores option:selected").val() == 0) {
        alert("Please select stores");
        v = false;
    }

    return v;
}


function set_delete(code) {
    if (confirm("Are you sure delete " + code + "?")) {
        loding();
        $.post("index.php/main/delete/m_item_rol", {
            code: code
        }, function (res) {
            if (res == 1) {
                get_data_table();
            } else if (res == 2) {
                alert("No permission to delete data.");
            } else {
                alert("Item deleting fail.");
            }
            loding();
        }, "text");
    }
}




function is_edit($mod) {
    $.post("index.php/main/is_edit/user_permissions/is_edit", {
        module: $mod

    }, function (r) {
        if (r == 1) {
            $("#btnSave").removeAttr("disabled", "disabled");
        } else {
            $("#btnSave").attr("disabled", "disabled");
        }

    }, "json");

}

function set_edit(bc) {
    //loding();
    $.post("index.php/main/get_data/m_item_rol", {
        bc: bc
    }, function (res) {
        $("#code_").val(res.c[0].bc);


        for (var i = 0; i < res.c.length; i++) {
            $("#h_" + i).val(res.c[i].code);
            $("#n_" + i).val(res.c[i].description);
            $("#0_" + i).val(res.c[i].code);
            $("#2_" + i).val(res.c[i].model);
            $("#3_" + i).val(res.c[i].rol);
            $("#4_" + i).val(res.c[i].roq);

        }




        // is_edit('010');
        // loding(); input_active();
    }, "json");
}