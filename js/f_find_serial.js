$(document).ready(function () {
    $("#btnPrint").click(function(){
        $("#print_pdf").submit();
    });


    $("#searchType").change(function () {
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

    });



    load_items();

    $("#pop_search").keyup(function (e) {
        if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40) {
            load_items();
        }
    });

    $("#pop_search").gselect();

});



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
    $.post("index.php/main/load_data/f_find_serial/item_list_all", {
        search: $("#pop_searchs").val(),

    }, function (r) {
        $("#searchType").html(r);
        settings();
        settings5();

    }, "text");
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

        if ($(this).children().eq(0).html() != "&nbsp;") {

            $("#itm2").val($(this).children().find('input').eq(0).val());
            $("#des2").val($(this).children().find('input').eq(1).val());
            $("#mPrice2").val($(this).children().find('input').eq(3).val());
            $("#mxPrice2").val($(this).children().find('input').eq(4).val());
            $("#btch2").val($(this).children().find('input').eq(6).val());
            $("#qnty2").val($(this).children().find('input').eq(5).val());

            
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


