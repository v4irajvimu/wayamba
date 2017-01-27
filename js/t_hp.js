    var tc=0;
    $(document).ready(function () {
/*var pathname = window.location.pathname;
*/
$("#btnshedule").click(function(){
    update_shedule();
});

var sPageURL = window.location.search.substring(1);
var sURLVariables = sPageURL.split('&');
if (typeof(sURLVariables[1])!="undefined") {
    var id=sURLVariables[1].split('=');  
    id= id[1];        
    load_data(id);
};
$("#btn_agrr").click(function(){
    if($("#hid").val()=="" || $("#hid").val()==0){
        set_msg("Please Load a Agreement")
    }else{
        $("#print_agreement").submit();
    }
    
});
$(".qty").keyup(function() {
    var n_qty = parseFloat($("#7_"+scid).val());
    var d_qty = parseFloat($("#55_"+scid).val());
    if(isNaN(n_qty)){
        n_qty=0
    }if(isNaN(d_qty)){
        d_qty=0;
    }
    if(d_qty>n_qty){
        set_msg("Delvery quantity should be less than or equal to qty");
        $("#55_"+scid).val("0");
    }
});

$(".price, .qty, .dis_pre, .foc").blur(function(){
     set_cid($(this).attr("id"));

     if($("#6_"+scid).val()!="" && $("#0_"+scid).val()!=""){
        check_item_in_grid($("#0_"+scid).val(),$("#6_"+scid).val(),scid);
     }
    });

$(".quns").css("display", "none");
$(".qunsb").css("display","none");
$(".subs").css("display","none");
$("#load_req_duplecate").css("display", "none");
$("#code").blur(function () {
    check_code();
});
load_def_sales();
$("#tabs").tabs();
$("#tabs2").tabs();
$('#tabs3').tabs();
$('#tabs4').tabs();
$("#tgrid").tableScroll({
    height: 90
});
$("#tgrid2").tableScroll({
    height: 40
});
$("#dealer_id").keypress(function(e){
  if(e.keyCode == 112){
      $("#pop_search13").val($("#dealer_id").val());
      load_dealer();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);
  }
  $("#pop_search13").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
         load_dealer();
     }
 }); 
  if(e.keyCode == 46){
      $("#dealer_id").val("");
  }
});
$(".price").keypress(function(e){
    if(e.keyCode==112){
        set_cid($(this).attr("id"));
        load_price_range($("#0_"+scid).val(),$("#6_"+scid).val());
    }
});
$("#dueDate").bind('keydown keyup keypress change', function() {
    if (($(this).val() < 1 || $(this).val() > 31) && $(this).val().length != 0) {
        if ($(this).val() < 1) {
            $(this).val(1)
        }
        if ($(this).val() > 10) {
            $(this).val(31)
        }
    }
});
$("#down_payment").keyup(function(){
    cal_balance();
});
$("#num_of_installment").keyup(function(){
    cal_installment();
    cal_tot_interest();
});
$("#interest_rate").keyup(function(){
    cal_tot_interest();
});
$(".qty").blur(function(){
    set_cid($(this).attr("id"));
    check_batch_qty(scid);
    is_sub_item(scid);
    item_free(scid); 
    tc=scid;
    balance_item_free(scid);
    get_scheme($("#scheme").val());
});
$("#book_no").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search15").val($("#book_no").val());
      load_book();
      $("#serch_pop15").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search15').focus()", 100);
  }
  $("#pop_search15").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_book();
    }
}); 
  if(e.keyCode == 46){
      $("#book_no").val("");
      $("#book_des").val("");
  }
});
$("#s_cat").keypress(function(e){
    if($("#book_no").val()!=""){
        if(e.keyCode == 112){
            $("#pop_search4").val($("#s_cat").val());
            load_data9();
            $("#serch_pop4").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search4').focus()", 100);
        }
        $("#pop_search4").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
             load_data9();
         }
     }); 
    }else{
        set_msg("please select book edition");
    }
    if(e.keyCode == 46){
        $("#s_cat").val("");
        $("#s_cat_des").val("");
    }
}); 
$("#settu_item").keypress(function(e){
    if($("#s_cat").val()!=""){
        if($("#stores").val()!=0){
            if(e.keyCode == 112){
                $("#pop_search7").val($("#settu_item").val());
                load_settu_item();
                $("#serch_pop7").center();
                $("#blocker2").css("display", "block");
                setTimeout("$('#pop_search7').focus()", 100);
            }
            $("#pop_search7").keyup(function(e){
                if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_settu_item();
             }
         }); 
        }else{
            set_msg("please select store");
        }
    }else{
        set_msg("please select settu item category");
    }
    if(e.keyCode == 46){
        $("#settu_item").val("");
        $("#settu_item_des").val("");
    }
}); 
$("#sales_rep").keypress(function(e){
    if(e.keyCode == 112){
        $("#pop_search6").val();
        load_rep();
        $("#serch_pop6").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search6').focus()", 100);
    }
    $("#pop_search6").keyup(function(e){            
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
           load_rep();
       }
   }); 
    if(e.keyCode == 46){
        $("#sales_rep").val("");
        $("#sales_rep2").val("");
    }
});
$("#sales_rep_create").click(function(){
 window.open("?action=m_employee","_blank");  
});
$("#btn_open_customer").click(function(){
 window.open("?action=m_customer","_blank");  
});
$("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#7_"+get_id).focus();
});
$("#sales_category").change(function() {
 get_group();
});
$("#load_req").click(function () {
    if ($("#supplier_id").val() != "" || $("#supplier").val() != "") {
        load_request_note();
    } else {
        set_msg("Please select supplier");
    }
});
$(".qunsb").click(function () {
    set_cid($(this).attr("id"));
    check_is_batch_item(scid);
});
$("#pop_search3").keyup(function (e) {
    if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40) {
        load_items3($("#0_" + scid).val());
    }
});

$(".subs").click(function(){
 set_cid($(this).attr("id"));
 check_is_sub_item(scid); 
});
$("#sales_category").change(function(){
    $("#sales_category1").val($("#sales_category").val());
    if($("#sales_category").val()==0){
        $("#sub_no").val("0");
        set_msg("Please select sales category");
    }else{
        sales_category_max();            
    }
});
$(".fo").keypress(function (e) {
    set_cid($(this).attr("id"));
    if (e.keyCode == '46') {
        item_free_delete(scid)
        $("#0_" + scid).val("");
        $("#h_" + scid).val("");
        $("#n_" + scid).val("");
        $("#1_" + scid).val("");
        $("#2_" + scid).val("");
        $("#3_" + scid).val("");
        $("#4_" + scid).val("");
        $("#5_" + scid).val("");
        $("#6_" + scid).val("");
        $("#7_" + scid).val("");
        $("#8_" + scid).val("");
        $("#9_" + scid).val("");
        $("#cost_"+scid).val("");
        $("#bal_free_"+scid).val("");
        $("#bal_tot_"+scid).val("");
        $("#free_price_"+scid).val("");
        $("#issue_qty_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#bqty"+scid).val("");
        $("#item_min_price_"+scid).val("");
        $("#subcode_"+scid).removeAttr("data-is_click");
        $("#7_"+scid).attr("readonly", false);

        $("#btn_"+scid).css("display","none"); 
        $("#btnb_"+scid).css("display","none");
        $("#sub_"+scid).css("display","none");
        $("#n_"+scid).closest("td").attr('style', ' background-color: #f9f9ec !important');
        $("#n_"+scid).attr('style', 'width: 145px; background-color: #f9f9ec !important');
        $("#2_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        $("#1_"+scid).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
        $("#1_"+scid).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
        $("#3_"+scid).closest("td").attr('style', 'width: 58px;');
        $("#6_"+scid).closest("td").attr('style', 'width: 60px; background-color: #f9f9ec !important');
        $("#6_"+scid).attr('style', 'width: 44px; background-color: #f9f9ec !important');
        $("#9_"+scid).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
        $("#9_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        $("#4_"+scid).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
        $("#4_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        $("#8_"+scid).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');
        $("#8_"+scid).closest("td").attr('style', 'width: 60px; background-color: #f9f9ec !important'); 
        $("#0_"+scid).closest("tr").attr('style', 'width:44px; background-color: #ffffff !important;');
        $("#7_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        amount();
        net_amount();
    }
});
$(".fo").keypress(function (e) {
    set_cid($(this).attr("id"));
    if (e.keyCode == 112) {
        $("#pop_search").val($("#0_" + scid).val());
        load_items();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("select_search()", 100);
    } else if (e.keyCode == 13) {
        $.post("index.php/main/load_data/t_hp/get_item2", {
            code: $("#0_" + scid).val(),
            stores: $("#stores").val()
        }, function (res) {
            if (res.a != 2) {
                $("#0_" + scid).val(res.a[0].code);
                if (check_item_exist($("#0_" + scid).val())) {
                    $("#h_" + scid).val(res.a[0].code);
                    $("#n_" + scid).val(res.a[0].description);
                    $("#0_" + scid).val(res.a[0].code);
                    $("#1_" + scid).val(res.a[0].model);
                    $("#6_" + scid).val(res.a[0].batch_no);
                    $("#2_" + scid).val(res.a[0].max_price);
                    $("#7_" + scid).focus();
                } else {
                    alert("Item " + $("#0_" + scid).val() + " is already added.");
                }
            } else {
                set_msg($("#0_" + scid).val() + " Item not available in store", "error");
                $("#0_" + scid).val("");
            }
        }, "json");
    }
    $("#pop_search").keyup(function (e) {
        load_items();
    });
});
$("#customer").keypress(function (e) {
    if (e.keyCode == 112) {
        $("#pop_search10").val($("#customer").val());
        load_data3();
        $("#serch_pop10").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search10').focus();", 100);
    }
    $("#pop_search10").keyup(function (e) {
        if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112) {
            load_data3();
        }
    });
    if(e.keyCode== 46){
        $("#customer").val("");
        $("#customer_id").val("");
    }
});
$("#scheme").keypress(function (e) {
    if (e.keyCode == 112) {
        $("#pop_search11").val($("#scheme").val());
        load_data4();
        $("#serch_pop11").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search11').focus();", 100);
    }
    $("#pop_search11").keyup(function (e) {
        if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112) {
            load_data4();
        }
    });
    if(e.keyCode== 46){
        $("#scheme").val("");
        $("#scheme_des").val("");
    }
});
$("#category").keypress(function (e) {
    if (e.keyCode == 112) {
        $("#pop_search12").val($("#category").val());
        load_data6();
        $("#serch_pop12").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search12').focus();", 100);
    }
    $("#pop_search12").keyup(function (e) {
        if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112) {
            load_data6();
        }
    });
    if(e.keyCode== 46){
        $("#category").val("");
        $("#category_des").val("");
    }
});
$("#guarantor_1").keypress(function (e) {
    if (e.keyCode == 112) {
        $("#pop_search13").val($("#guarantor_1").val());
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
        $("#guarantor_1").val("");
        $("#guarantor_1_des").val("");
    }
});
$("#guarantor_2").keypress(function (e) {
    if (e.keyCode == 112) {
        $("#pop_search14").val($("#guarantor_2").val());
        load_data8();
        $("#serch_pop14").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search14').focus();", 100);
    }
    $("#pop_search14").keyup(function (e) {
        if (e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112) {
            load_data8();
        }
    });
    if(e.keyCode== 46){
        $("#guarantor_2").val("");
        $("#guarantor_2_des").val("");
    }
});

$("#btnDelete").click(function () {
    if ($("#hid").val() != 0) {
        set_delete($("#hid").val());
    }
});
$("#btnPrint").click(function () {
    if ($("#hid").val() == "0") {
        set_msg("Please load data before print");
        return false;
    } else {
        $("#print_pdf").submit();
    }
});
$("#supplier_id").change(function () {
    empty_grid();
});

/*    $(".foc,.price").blur(function () {
        set_cid($(this).attr("id"));
        var foc_amount = parseFloat(0);
        foc_amount = parseFloat($("#8_" + scid).val()) * parseFloat($("#2_" + scid).val());
        $('#foc_amount').val(m_round(foc_amount));
    });
    */
    $(".qty, .price").blur(function () {
        set_cid($(this).attr("id"));
        account_settle();
        cal_balance();
        cal_installments();
        free_tot();

    });
    $(".dis").blur(function () {
        total_dis();
    });
    $(".aa").blur(function () {
        set_cid($(this).attr("id"));
        set_rate();
        get_additional_amt();
        cal_balance();
        cal_tot_interest()
    });
  /*  $(".rate").blur(function () {
        set_cid($(this).attr("id"));
        var additional_amt = set_additional_amt(scid);
        $("#tt_" + scid).val(additional_amt);
        get_additional_amt($("#add_or_subs").val());
        cal_balance();
    });*/

    $("#num_of_installment").blur(function () {
        cal_installment();
    });

    $(".dis,.price").blur(function () {
        set_cid($(this).attr("id"));
        dis_prec();
        gross_amount();
        free_tot();
        calculate_free_total();
        amount();
        get_additional_amt();
        net_amount();
        cal_balance();
    });

    $("#id").keypress(function (e) {
        if (e.keyCode == 13) {
            load_data($(this).val());
        }
    });
    $("#cluster").change(function () {
        var clust = $("#cluster").val();
        $.post("index.php/main/select/login", {
            cluster: clust
        }, function (res) {
            $("#branch").html(res.result);
        }, "json"
        );
    });

    $("#stores").change(function () {
        set_select('stores', 'store_id');
    });
    $(".foo").focus(function () {
        set_cid($(this).attr("id"));
        load_items2();
        $("#serch_pop2").center();
        $("#blocker2").css("display", "block");
        setTimeout("select_search2()", 100);
    });
    $(".fo").focus(function () {
        if ($("#stores").val() == "" || $("#store_id").val() == "") {
            set_msg("Please enter store.");
            return false;
        }
    });
    $(document).on('click', '#installment_calc', function(){
        cal_installment();
        cal_tot_interest();
        cal_installments();
    });
    $("#pop_close14").click(function(){
        check_items();
    });
    default_option();
    $(document).keypress(function(e){
        if(e.keyCode== 116 || e.keyCode== 123){
            RstPgLocation()
        }
    });
    $("#btnReset").click(function(){
        RstPgLocation();
    });    

    $(".freitm").click(function(){
        free3=loop=0;
        set_cid($(this).attr("id"));
        if($("#free_"+scid).is(":checked")){ 
            if($("#0_"+scid).val() != ""){
                $("#issue_qty_"+scid).val($("#7_"+scid).val());
                $("#8_"+scid).val($("#7_"+scid).val());
                if(parseInt($("#7_"+scid).val()) > 0){
                    mark_as_free(scid,$("#0_"+scid).val());
                    calculate_free_total();
                    free_tot();
                    dis_prec();
                    gross_amount();
                    amount();
                    get_additional_amt();
                    net_amount();
                    cal_balance();
                }else{
                    set_msg("quantity should be greater than zero");
                    $("#7_"+scid).focus();
                    $("#free_"+scid).attr("checked",false);
                }
            }else{
              set_msg("please enter item first");
              $("#free_"+scid).attr("checked",false);
          }
      }else{
        $("#8_"+scid).val("");
        uncheck_free(scid,$("#0_"+scid).val());
        dis_prec();
        gross_amount();
        free_tot();
        calculate_free_total();
        amount();
        get_additional_amt();
        net_amount();
        cal_balance();
    }
});

});
    function calculate_free_total(){
      var foc_total=loop=0;
      $(".amount").each(function(){
        var gs=parseFloat($("#8_"+loop).val() * $("#2_"+loop).val());
        if(!isNaN(gs)){    
          foc_total=foc_total+gs;
      }  

      loop++;
  });
      $("#tot_free").val(foc_total); 
  }

  function RstPgLocation()
  {
    $(location).attr("href","?action=t_hp")
}
function free_tot(){
    $(".foc").each(function(e){
        if($("#8_"+e).val()!=""){
            var free_qty=$("#8_"+e).val();
            var price=$("#2_"+e).val();
            var free_tot=(free_qty*price);
            var free_tot1= $("#free_tot").val();
            $("#free_tot2").val(free_tot);
        }
    });
}

function load_price_range(item,batch){
    if(item!="" && batch!=""){
        load_prices($("#0_"+scid).val(),$("#1_"+scid).val(),$("#s3").val(),$("#s4").val(),$("#s5").val(),$("#s6").val(),$("#s3_des").val(),$("#s4_des").val(),$("#s5_des").val(),$("#s6_des").val());
        $("#serch_pop11").center();
        $("#blocker").css("display", "block");
    }else{
        set_msg("Please select item code and batch no");
    }
}
function load_prices(item,batch,s3,s4,s5,s6,s3des,s4des,s5des,s6des){
    $.post("index.php/main/load_data/t_hp/sales_prices", {
        item:item,
        batch:batch,
        s3:s3,
        s4:s4,
        s5:s5,
        s6:s6,
        s3des:s3des,
        s4des:s4des,
        s5des:s5des,
        s6des:s6des
    }, function(r){
        $("#sr11").html(r);
        setting_prices();
    },"text");
}
function setting_prices(){
    $("#item_list .cl").click(function(){        
        $("#2_"+scid).val($(this).children().eq(2).html());
        $("#2_"+scid).blur();
        $("#pop_close11").click();                
    });   
}
function default_option(){
    $.post("index.php/main/load_data/utility/default_option", {
    }, function(r){
      if(r.use_sales_category!="0"){
        $(".ct").css("display","none");
        var sale_cat=r.def_sales_category;
        $("#sales_category1").val(sale_cat);
    }
    if(r.use_sales_group!="0"){
     $(".gr").css("display","none");
     $("#dealer_id").val(r.def_sales_group);
 }
 if(r.use_sales_category!="0" && r.use_sales_group!="0"){
    $(".grct").css("display","none");
}
if(r.use_salesman!="0"){
    $("#sales_rep").val(r.def_salesman_code);
    $("#sales_rep2").val(r.def_salesman);
}
$("#customer").val(r.def_cash_customer);
$("#customer_id").val(r.customer);
}, "json");
}
/*function settings6(){

   if(isNaN(parseInt($("#8_"+scid).val()))){
    var qty=parseInt($("#7_"+scid).val());
   }else{
    var qty=parseInt($("#7_"+scid).val())-parseInt($("#8_"+scid).val());
   }
    if($("#8_"+scid).val() != "")
    {
        $("#bal_free_"+scid).val($("#8_"+scid).val());
        $("#issue_qty_"+scid).val($("#8_"+scid).val());
    }
    var free_qty = "";
  
$("#free_item_list .cl").click(function(){
        if($(this).children().eq(0).html() != "&nbsp;"){
            free_qty=parseInt($(this).children().eq(4).html());
            if(check_item_exist2($(this).children().eq(0).html())){
                 var get=$(this).children().eq(0).html();
                 var name=$(this).children().eq(1).html();
                 var modal=$(this).children().eq(2).html();
                 var price=$(this).children().eq(3).html();
                 var sign=$(this).children().eq(5).html();
                 var sign=$(this).children().eq(5).html();
                 var issue_qty = qty/free_qty;
                  for(var i=0; i<25 ;i++){
                    if($("#0_"+i).val()==get){
                        return false;
                      }else if($("#0_"+i).val()==""){
                        if($("#df_is_serial").val()=='1'){
                            check_is_serial_item2(get,i);
                        }
                       
                        
                        $("#0_"+i).val(get);
                        $("#h_"+i).val(get);
                        $("#n_"+i).val(name);
                        $("#1_"+i).val(modal);
                        $("#2_"+i).val(price);
                        $("#free_price_"+i).val(price);
                        $("#7_"+i).val(Math.floor(issue_qty));
                        $("#issue_qty_"+i).val(Math.floor(issue_qty));
                        $("#f_"+i).val(sign);
                        $("#bal_free_"+i).val(Math.floor(issue_qty));
                        $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:179px; background-color: rgb(224, 228, 146) !important');
                        $("#n_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :160px; float: left; text-align:left;');
                        $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                        $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                        $("#9_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#9_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                        $("#4_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                        $("#4_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                        $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 40px; background-color: rgb(224, 228, 146) !important');
                        $("#6_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                        $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                        $("#8_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 40px; background-color: rgb(224, 228, 146) !important');
                        $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :40px; float: right; text-align:right;');
                        $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                        $("#5_"+i).focus();
                        $("#3_"+i).blur();
                        check_is_batch_item2(get,i);
                        check_is_sub_item2(get,i);
                        check_is_batch_item_free(i);
                        check_is_batch_item(i);
                        break;                
                      }
                  }          
                $("#11_"+scid).focus();
                dis_prec();
                gross_amount();
                net_amount();
                amount();
                get_additional_amt();
                cal_balance();
                //$("#pop_close14").click();  
            }else{
                var ff = qty/free_qty;
                for(var a=0; a<25 ;a++){
                    if($("#0_"+a).val()==$(this).children().eq(0).html()){
                        //$("#5_"+a).val(Math.floor(ff));
                      }
                    
                  }             
                set_msg("Item "+$(this).children().eq(1).html()+" is already added and free quantity updated.");
            }
        }else{
            $("#h_"+scid).val("");
            $("#0_"+scid).val("");
            $("#n_"+scid).val("");
            $("#1_"+scid).val(""); 
            $("#t_"+scid).val(""); 
           
            dis_prec();
            amount();
            gross_amount();
            net_amount();
            get_additional_amt();
            cal_balance();
            
            $("#pop_close14").click();
        }
    });
}*/


function cal_installments(){
    $("#installment_calc").attr("clicked","yes");
    if ($("#down_payment").val() == "") {
        $("#down_payment").val(0);
    }
    var get_downpay_date = $("#date").val();
    var total_amount = parseFloat($("#net_amt").val());
    var down_payment = m_round(parseFloat($("#down_payment").val()));
    var int_rate = parseFloat($("#interest_rate").val()) / 100;
    var period = parseFloat($("#period").val());
        // var balance_amount = parseFloat(total_amount - down_payment);
        var balance_amount = parseFloat($("#balance").val());
        var num_of_install = parseInt($("#num_of_installment").val());
        var total_interest_amount = parseFloat((balance_amount  * int_rate) * num_of_install);
        var total_installment_amount = parseInt((total_interest_amount + balance_amount) / period);
        var capital_amount = m_round(balance_amount / num_of_install);
        var interest_amount = m_round(parseFloat(balance_amount) * (parseFloat(int_rate)));
        var installment_amount = m_round(parseFloat(interest_amount) + parseFloat(capital_amount));
        var ddate;
        var install_tot = capital_tot = int_tot = parseFloat(0);
        //alert(balance_amount);
        // if(period==0){alert("abc");period="";}
        if (!isNaN(period) && period != 0) {
            var dd = "";
            var num_of_rows = 1 + (parseInt($("#num_of_installment").val()));
            var add_installment_grid = '<thead> <th class="tb_head_th">NO</th> <th class="tb_head_th">Due Date</th> <th class="tb_head_th">Installment</th>  <th class="tb_head_th">Capital</th>  <th class="tb_head_th">Interest</th> </thead>';
            
            for (x = 0; x < num_of_rows; x++) {
                if (x == 0) {
                    add_installment_grid += '<tbody> <tr><td><input type="text" readonly="readonly" id="insno_' + x + '" name="no_' + x + '" value="' + x + '" style="width:100%"></td> <td><input type="text" id="duedate_' + x + '" name="duedate_' + x + '" value="' + get_downpay_date + '" class="input_date_down_future"  style="width:100%;border:none;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="installment_' + x + '" name="installment_' + x + '" value="' + down_payment + '" style="width:100%;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="capital_' + x + '" name="capital_' + x + '" value="' + down_payment + '" style="width:100%" ></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="interest_' + x + '" name="interest_' + x + '" value="0" style="width:100%"></td></tr></tbody>';
                } else {
                    dd = dd + x + "~~";
                    add_installment_grid += '<tbody> <tr><td><input type="text" readonly="readonly" id="insno_' + x + '" name="no_' + x + '" value="' + x + '" style="width:100%"></td> <td><input type="text" id="duedate_' + x + '" name="duedate_' + x + '" value="" class="input_date_down_future"  style="width:100%;border:none;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="installment_' + x + '" name="installment_' + x + '" value="' + installment_amount + '" style="width:100%;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="capital_' + x + '" name="capital_' + x + '" value="' + capital_amount + '" style="width:100%" ></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="interest_' + x + '" name="interest_' + x + '" value="' + interest_amount + '" style="width:100%"></td></tr></tbody>';
                    install_tot+=parseFloat(installment_amount);
                    capital_tot+=parseFloat(capital_amount);
                    int_tot+=parseFloat(interest_amount);
                }
            }
            add_installment_grid += '<tfoot> <tr><td></td> <td><b>Total</b></td> <td><b>'+m_round(install_tot)+'</b></td>  <td><b>'+m_round(capital_tot)+'</b></td>  <td><b>'+m_round(int_tot)+'</b></td> </tr></tfoot>';
            due_date2(dd);
            $("#installment_det").html(add_installment_grid);
        } else {
            var dd = "";
            var num_of_rows = 1 + (parseInt($("#num_of_installment").val()));
            var add_installment_grid = '<thead> <th class="tb_head_th">NO</th> <th class="tb_head_th">Due Date</th> <th class="tb_head_th">Installment</th>  <th class="tb_head_th">Capital</th>  <th class="tb_head_th">Interest</th> </thead>';
            for (x = 0; x < num_of_rows; x++) {
                if (x == 0) {
                    add_installment_grid += '<tbody> <tr><td><input type="text" readonly="readonly" id="insno_' + x + '" name="no_' + x + '" value="' + x + '" style="width:100%"></td> <td><input type="text" id="duedate_' + x + '" name="duedate_' + x + '" value="' + get_downpay_date + '" class="input_date_down_future"  style="width:100%; border:none;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="installment_' + x + '" name="installment_' + x + '" value="' + down_payment + '" style="width:100%"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="capital_' + x + '" name="capital_' + x + '" value="' + down_payment + '" style="width:100%" ></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="interest_' + x + '" name="interest_' + x + '" value="0" style="width:100%"></td></tr></tbody>';
                } else {
                    dd = dd + x + "~~";
                    add_installment_grid += '<tbody> <tr><td><input type="text" readonly="readonly" id="insno_' + x + '" name="no_' + x + '" value="' + x + '" style="width:100%"></td> <td><input type="text" id="duedate_' + x + '" name="duedate_' + x + '" value="" class="input_date_down_future"  style="width:100%;border:none;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="installment_' + x + '" name="installment_' + x + '" value="' + installment_amount + '" style="width:100%;"></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="capital_' + x + '" name="capital_' + x + '" value="' + capital_amount + '" style="width:100%;" ></td> <td><input type="text" class="g_input_amo" readonly="readonly" id="interest_' + x + '" name="interest_' + x + '" value="' + interest_amount + '" style="width:100%;"></td></tr></tbody>';
                    install_tot+=parseFloat(installment_amount);
                    capital_tot+=parseFloat(capital_amount);
                    int_tot+=parseFloat(interest_amount);
                }
            }
            add_installment_grid += '<tfoot> <tr style="text-align:right;"><td></td><td><b>Total</b></td>  <td><b>'+m_round(install_tot)+'</b></td>  <td><b>'+m_round(capital_tot)+'</b></td>  <td><b>'+m_round(int_tot)+'</b></td> </tr></tfoot>';
            due_date(dd);
            $("#installment_det").html(add_installment_grid);
        }
        $("#total_interest_amount").val(total_interest_amount);
    }

    function load_settu_item(){     
       $.post("index.php/main/load_data/t_settu/item_list_all", {
        search : $("#pop_search7").val(),
        category : $("#s_cat_hid").val(),
        book : $("#book_no").val()
    }, function(r){
        $("#sr7").html(r);
        settu_settings();
    }, "text");
   }
   function settu_settings(){
    $("#item_list .cl").click(function(){        
        $("#settu_item").val($(this).children().eq(0).html());
        $("#settu_item_des").val($(this).children().eq(1).html());
        load_settu_item_all($(this).children().eq(0).html());
        $("#pop_close7").click(); 
    });    
}
function load_settu_item_all(settu_item){
    $.post("index.php/main/load_data/t_hp/all_settu_item", {
        item_code:settu_item,
        store_code:$("#stores").val()
    }, 
    function(r){
        if(r=="2"){
            set_msg("no records");
        }else{
            for(var x=0; x<r.a.length; x++){
                if(r.a[x].free=="1"){                    
                    if($("#df_is_serial").val()=='1'){
                        check_is_serial_item2(r.a[x].code,x);
                    }
                    $("#0_"+x).val(r.a[x].code);
                    $("#h_"+x).val(r.a[x].code);
                    $("#n_"+x).val(r.a[x].description);
                    $("#1_"+x).val(r.a[x].model);
                    $("#2_"+x).val(r.a[x].max_price);
                    $("#free_price_"+x).val(r.a[x].max_price);
                    $("#7_"+x).val(Math.floor(r.a[x].qty));
                    $("#issue_qty_"+x).val(Math.floor(r.a[x].qty));
                    $("#f_"+x).val(r.a[x].free);
                    $("#bal_free_"+x).val(Math.floor(r.a[x].qty));
                    $("#n_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width:179px; background-color: rgb(224, 228, 146) !important');
                    $("#n_"+x).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :160px; float: left; text-align:left;');
                    $("#2_"+x).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                    $("#1_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                    $("#1_"+x).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:left;');
                    $("#9_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                    $("#9_"+x).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                    $("#4_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                    $("#4_"+x).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                    $("#6_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width: 40px; background-color: rgb(224, 228, 146) !important');
                    $("#6_"+x).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                    $("#6_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                    $("#8_"+x).closest("td").removeClass('g_col_fixed').attr('style', 'width: 40px; background-color: rgb(224, 228, 146) !important');
                    $("#8_"+x).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :40px; float: right; text-align:right;');
                    $("#0_"+x).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                    $("#5_"+x).focus();
                    $("#3_"+x).blur();
                    $("#2_"+x).blur();
                    check_is_batch_item2(r.a[x].code,x);
                    check_is_sub_item2(r.a[x].code,x);
                    check_is_batch_item_free(x);
                    check_is_batch_item(x);
                }else{
                    if($("#df_is_serial").val()=='1'){
                        check_is_serial_item2(r.a[x].code,x);
                    }
                    check_is_batch_item2(r.a[x].code,x);
                    check_is_sub_item2(r.a[x].code,x);
                    $("#h_"+x).val(r.a[x].code);
                    $("#0_"+x).val(r.a[x].code);
                    $("#n_"+x).val(r.a[x].description);
                    $("#1_"+x).val(r.a[x].model);
                    $("#2_"+x).val(r.a[x].max_price);
                    $("#7_"+x).val(r.a[x].qty);
                    check_is_batch_item(x);
                    $("#2_"+x).blur();
                }
            }
        }        
    }, "json");
}


function load_data9(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_settu_item_category",
        field:"code",
        field2:"name",
        preview1:"Code",
        preview2:"Name",
        hid_field:"ref_code",
        add_query:"AND book_edition ='"+$("#book_no").val()+"'",
        search : $("#pop_search4").val() 
    }, function(r){
        $("#sr4").html(r);
        settings9();            
    }, "text");
}
function settings9(){
    $("#item_list .cl").click(function(){        
        $("#s_cat").val($(this).children().eq(0).html());
        $("#s_cat_des").val($(this).children().eq(1).html());
        $("#s_cat_hid").val($(this).children().eq(2).find('input').val());
        $("#pop_close4").click(); 
    });    
}

function load_book(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_settu_book_edition",
      field:"code",
      field2:"description",
      preview2:"Edition Name",
      add_query:"AND is_active='1'",
      search : $("#pop_search15").val() 
  }, 
  function(r){
      $("#sr15").html(r);
      settings_book();        
  }, "text");
}
function settings_book(){
  $("#item_list .cl").click(function(){        
    $("#book_no").val($(this).children().eq(0).html());
    $("#book_des").val($(this).children().eq(1).html());
    $("#pop_close15").click();                
})    
}

function tot_amount(scid) {
    var loop = total_amount = 0;
    var qty = parseFloat($("#7_" + scid).val());
    var price = parseFloat($("#2_" + scid).val());
    var net = $("#total_amt").val();
    if (isNaN(qty)) {
        qty = 0;
    }
    if (isNaN(price)) {
        price = 0;
    }
    var amount = qty * price;
    if (amount == 0) {
        amount = "";
        net = "";
    } else {
        $("#4_" + scid).val(m_round(amount));
    }
    $(".amount").each(function () {
        var get_amount = parseFloat($("#4_" + loop).val());
        if (isNaN(get_amount)) {
            get_amount = 0;
        }
        total_amount = total_amount + get_amount;
        if ($("#0_" + loop).val() != "") {
            $("#3_" + loop).blur();
        }
        loop++;
    });
    $("#total_amt").val(m_round(total_amount));
    $("#net_amt").val(m_round(total_amount));

}
function formatItems(row) {
    return "<strong> " + row[0] + "</strong> | <strong> " + row[1] + "</strong>";
}
function formatItemsResult(row) {
    return row[0] + "|" + row[1];
}
function save() {
    var frm = $('#form_');
    $("#agr_no").val($("#agreement_no").val());
    $("#qno").val($("#id").val());
    $("#cus_id").val($("#customer").val());
    $("#salesp_id").val($("#sales_rep").val());
    $("#dt").val($("#date").val());
    loding();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (pid) {
            if (pid == 1) {
               $("#btnSave").attr("disabled",true);
               if(confirm("Save Completed, Do You Want A print?")){
                if($("#is_prnt").val()==1){
                    $("#print_pdf").submit();
                }
                reload_form();
            }else{
                location.href="";
            }
        } else if (pid == 2) {
            set_msg("No permission to add data.");
        } else if (pid == 3) {
            set_msg("No permission to edit data.");
        } else {
            set_msg(pid);
        }
        loding();
    }
});
}
function reload_form(){
  setTimeout(function(){
    window.location = '';
},50); 
}
function validate() {
    if ($("#scheme").val() == "" || $("#scheme_des").val() == "") {
        set_msg("Please enter scheme.");
        return false
    } else if ($("#category").val() == "" || $("#category_des").val() == "") {
        set_msg("Please enter category.");
        return false;
    } else if ($("#agreement_no").val() == "") {
        set_msg("Please enter agreement number.");
        return false;
    } else if ($("#customer").val() == "" || $("#customer_id").val() == "") {
        set_msg("Please enter customer.");
        return false;
    } else if ($("#guarantor_1").val() == "" || $("#guarantor_1_des").val() == "") {
        set_msg("Please enter guarantor 1.");
        return false;
    } else if ($("#guarantor_2").val() == "" || $("#guarantor_2_des").val() == "") {
        set_msg("Please enter guarantor 2.");
        return false;
    } else if ($("#guarantor_1").val() == $("#guarantor_2").val()) {
        set_msg("Please enter different guarantor for guarantor 2.");
        return false;
    } else if ($("#stores").val() == "" || $("#store_id").val() == "") {
        set_msg("Please enter store.");
        return false;
    } else if ($("#num_of_installment").val() <= 0) {
        set_msg("No of installment sholud be greater than 0 (zero)");
        return false;
    }else if ($("#installment_calc").attr('clicked') == "no") {
        set_msg("Please click calculate button");
        return false;
    }else if ($("#installment").val() == "" || $("#installment").val() == "0") {
        set_msg("Instalment sholud be greater than 0 (zero)");
        return false;
    }else if ($("#sales_rep").val() == "") {
        set_msg("Please enter salesman");
        return false;
    }else {
        return true;
    }
    
}
function set_delete(id) {
    if (confirm("Are you sure to delete transaction no " + id + "?")) {
        loding();
        $.post("index.php/main/delete/t_hp", {
            id: id
        }, function (res) {
            if (res == 1) {
                location.href = "";
            } else if (res == 2) {
                set_msg("No permission to delete data.");
            } else {
                set_msg(res);
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
function set_edit(code) {
    loding();
    $.post("index.php/main/get_data/t_internal_transfer_order", {
        code: code
    }, function (res) {
        $("#code_").val(res.code);
        $("#code").val(res.code);
        $("#code").attr("readonly", true);
        $("#description").val(res.description);
        if (res.is_vehical == 1) {
            $("#is_vehical").attr("checked", "checked");
        } else {
            $("#is_vehical").removeAttr("checked");
        }
        loding();
        input_active();
    }, "json");
}

function select_search() {
    $("#pop_search").focus();
}
function price_type(){
   $.post("index.php/main/load_data/utility/price_type", {
   }, function(r){
      pr_type=r;
  }, "text");
}
function settings1() {
    $("#item_list .cl").click(function () {
        var qty = $(this).children().eq(4).html();       
        if ($(this).children().eq(0).html() != "&nbsp;") {
            //if (check_item_exist($(this).children().eq(0).html())) {
                if($("#df_is_serial").val()=='1'){
                    check_is_serial_item2($(this).children().eq(0).html(),scid);
                }
                check_is_batch_item2($(this).children().eq(0).html(),scid);
                check_is_sub_item2($(this).children().eq(0).html(),scid);

                $("#h_" + scid).val($(this).children().eq(0).html());
                $("#0_" + scid).val($(this).children().eq(0).html());
                $("#n_" + scid).val($(this).children().eq(1).html());
                $("#1_" + scid).val($(this).children().eq(2).html());
               if(pr_type =="1"){          //  none price
                $("#2_"+scid).val();    
                }else if(pr_type =="2"){    //  cost price
                    $("#2_"+scid).val($(this).children().eq(5).html());
                }else if(pr_type =="3"){    //  min price
                    $("#2_"+scid).val($(this).children().eq(4).html());
                }else if(pr_type=="4"){    //  max price
                    $("#2_"+scid).val($(this).children().eq(3).html());    
               }else if(pr_type=="5"){   //  sale Price 3
                $("#2_"+scid).val($(this).children().eq(6).html());    
                }else if(pr_type=="6"){  //  sale Price 4
                    $("#2_"+scid).val($(this).children().eq(7).html());    
                }else if(pr_type=="7"){   //  sale Price 5
                    $("#2_"+scid).val($(this).children().eq(8).html());    
                }else {                     //  sale Price 6
                    $("#2_"+scid).val($(this).children().eq(9).html());    
                }      
                
                $("#pop_close").click();
                check_is_batch_item(scid);
            //} else {
                //set_msg("Item " + $(this).children().eq(1).html() + " is already added.");
            //}
        } else {
            $("#0_" + scid).val("");
            $("#n_" + scid).val("");
            $("#1_" + scid).val("");
            $("#2_" + scid).val("");
            $("#3_" + scid).val("");
            $("#4_" + scid).val("");
            $("#5_" + scid).val("");
            $("#6_" + scid).val("");
            $("#7_" + scid).val("");
            $("#8_" + scid).val("");
            $("#9_" + scid).val("");
            //$("#4_"+scid).focus();
            $("#pop_close").click();
            $("#0_" + scid).focus();
        }
    });

}
function common_setting(code,name,close){
    $("#item_list .cl").click(function () {
        $(code).val($(this).children().eq(0).html());
        $(name).val($(this).children().eq(1).html());
        $(close).click();
    })
}
function common_setting2(code,name,close){
    $("#item_list .cl").click(function () {
        $(code).val($(this).children().eq(0).html());
        $(name).val($(this).children().eq(1).html());
        get_scheme($(this).children().eq(0).html())
        $(close).click();
    })
}

function settings10(r) {
    $("#document_charges").val(r.a[0].document_charges);
    if(r.a[0].interest_type=='1'){
        var int_rate=r.a[0].interest_rate;
    }else{
       var int_rate=(r.a[0].interest_rate/12);
   }
   $("#interest_rate").val(int_rate);
   $("#min_limit").val(r.a[0].loan_min_amount);
   $("#max_limit").val(r.a[0].loan_max_amount);
   $("#dwn_type").val(r.a[0].down_payment_type);
   $("#dwn_py").val(r.a[0].down_payment);

   if (r.a[0].is_editable == 0) {
    $('#document_charges').attr('readonly', true);
    $('#down_payment').attr('readonly', true);
    $('#interest_rate').attr('readonly', true);
}
if(r.a[0].down_payment_type == 2){
    if(!isNaN($("#net_amt").val()) && $("#net_amt").val() !=""){
        var dp = (parseFloat($("#net_amt").val()) * parseFloat(r.a[0].down_payment)) / 100;
        $("#down_payment").val(dp);
    }else{
        $("#down_payment").val("0.00");
    }
}else{
    $("#down_payment").val(r.a[0].down_payment);
}
cal_balance();
}
function settings11() {
    $(".cl").click(function () {
        if ($(this).children().eq(0).html() != "&nbsp;") {
            if (check_item_exist($(this).children().eq(0).html())) {
                $("#hh_" + scid).val($(this).children().eq(3).html());
                $("#00_" + scid).val($(this).children().eq(0).html());
                $("#nn_" + scid).val($(this).children().eq(1).html());
                $("#11_" + scid).val($(this).children().eq(2).html());
                var additional_amt = set_additional_amt(scid);
                $("#tt_" + scid).val(additional_amt);
                get_additional_amt($(this).children().eq(3).html());
                $("#add_or_subs").val($(this).children().eq(3).html());
                cal_balance();
                $("#pop_close2").click();
                $("#tt_" + scid).focus();
            } else {
                set_msg("Item " + $(this).children().eq(1).html() + " is already added.");
            }
        } else {
            $("#00_" + scid).val("");
            $("#nn_" + scid).val("");
            $("#11_" + scid).val("");
            $("#tt_" + scid).val("");
            amount();
            gross_amount();
            get_additional_amt();
            cal_balance();
            $("#pop_close2").click();
        }
    });
}
function load_request_note() {
    empty_grid();
    $.post("index.php/main/load_data/t_po_sum/load_request_note", {
        supplier: $("#supplier_id").val()
    }, function (r) {
        if (r.det != 2) {
            for (var i = 0; i < r.det.length; i++) {
                $("#h_" + i).val(r.det[i].item);
                $("#0_" + i).val(r.det[i].item);
                $("#n_" + i).val(r.det[i].description);
                $("#1_" + i).val(r.det[i].model);
                $("#2_" + i).val(r.det[i].cur_qty);
                $("#3_" + i).val(r.det[i].approve_qty);
                $("#4_" + i).val(r.det[i].purchase_price);
                $("#5_" + i).val(r.det[i].total);
            }
            $(".price").blur();
        } else {
            set_msg("No Data");
        }
    }, "json");
}


function load_data(id){
    empty_grid();
    loding();
    var g=[];
    $.post("index.php/main/get_data/t_hp/", {
        id: id
    }, function (r) {
        var fre =parseFloat(0);
        if (r == "2") {
            alert("No records");
        } else {
            if(r.sum[0].is_opening_hp==1){
                if(confirm("This Is A Opening HP, Do You Want To Open In Opening HP?")){
                    window.open("?action=t_opening_hp","_blank"); 
                    location.href="";
                }else{
                    location.href="";
                }
            }else{
                $('#id').attr('readonly', 'true');
                $("#id").val(r.sum[0].nno);
                $("#hid").val(r.sum[0].nno);
                $("#qno").val(r.sum[0].nno);
                $("#qno1").val(r.sum[0].nno);
                $("#date").val(r.sum[0].ddate);
                $("#dt").val(r.sum[0].ddate);
                $("#ref_no").val(r.sum[0].ref_no);
                $("#scheme").val(r.sum[0].scheme_id);
                $("#scheme_des").val(r.sum[0].scheme_des);
                $("#category").val(r.sum[0].category_id);
                $("#category_des").val(r.sum[0].cat_des);
                $("#agreement_no").val(r.sum[0].agreement_no);
                $("#agr_no").val(r.sum[0].agreement_no);
                $("#agr_no").val(r.sum[0].agreement_no);
                $("#customer").val(r.sum[0].cus_id);
                $("#cus_id").val(r.sum[0].cus_id);
                $("#customer_id").val(r.sum[0].name);
                $("#guarantor_1").val(r.sum[0].guarantor_01);
                $("#guarantor_1_des").val(r.sum[0].g1);
                $("#guarantor_2").val(r.sum[0].guarantor_02);
                $("#guarantor_2_des").val(r.sum[0].g2);
                $("#stores").val(r.sum[0].store_id);
                $("#store_id").val(r.sum[0].store_des);
                $("#total_amt").val(r.sum[0].gross_amount);
                $("#tot_dis").val(r.sum[0].discount);
                $("#net_amt").val(r.sum[0].net_amount);
                $("#document_charges").val(r.sum[0].document_charges);
                $("#down_payment").val(r.sum[0].down_payment);
                $("#balance").val(r.sum[0].balance);
                $("#num_of_installment").val(r.sum[0].no_of_installments);
                $("#interest_rate").val(r.sum[0].interest_rate);
                $("#period").val(r.sum[0].period_by_days);
                $("#total_interest").val(r.sum[0].interest_amount);
                $("#installment").val(r.sum[0].installment_amount);
                $("#book_no").val(r.sum[0].settu_book_edition);
                $("#book_des").val(r.sum[0].b_name);
                $("#s_cat").val(r.sum[0].s_cat);
                $("#s_cat_hid").val(r.sum[0].hid_s_cat);
                $("#s_cat_des").val(r.sum[0].s_cat_name);
                $("#settu_item").val(r.sum[0].settu_item);
                $("#settu_item_des").val(r.sum[0].settu_name);
                if(r.sum[0].crn_no!=0){
                    $("#crn_no").val(r.sum[0].crn_no);
                    $("#crn_no_hid").val(r.sum[0].crn_no);
                }else{
                   $("#crn_no").val(r.crn);
                   $("#crn_no_hid").val(0);
               }
               $("#memo").val(r.sum[0].memo);
                //$("#groups").val(r.sum[0].group_sale_Id);
                $("#dealer_id").val(r.sum[0].group_sale_Id);
                $("#sales_category").val(r.sum[0].category);
                $("#sales_category1").val(r.sum[0].category);
                $("#sub_no").val(r.sum[0].sub_no);
                $("#sales_rep").val(r.sum[0].rep);
                $("#sales_rep2").val(r.sum[0].e_name);
               // $("#net_amt").val(r.sum[0].net_amount);
               $("#dueDate").val(r.sum[0].dueDate);
               var total_discount = 0;
               var gross_amount = parseFloat(r.sum[0].gross_amount);
               for (var i = 0; i < r.det.length; i++) {
                $("#h_" + i).val(r.det[i].item_code);
                $("#0_" + i).val(r.det[i].item_code);

                if($("#df_is_serial").val()=='1')
                {
                    $("#numofserial_"+i).val(r.det[i].qty);
                    check_is_serial_item2(r.det[i].item_code,i); 
                    for(var a=0;a<r.serial.length;a++){
                     if(r.det[i].item_code==r.serial[a].item){
                        g.push(r.serial[a].serial_no);
                        $("#all_serial_"+i).val(g);
                    }   
                }
                g=[];  
            }
            $("#n_" + i).val(r.det[i].description);
            $("#6_" + i).val(r.det[i].batch_no);
            $("#1_" + i).val(r.det[i].model);
            $("#8_" + i).val(r.det[i].foc);
            $("#2_" + i).val(r.det[i].sales_price);
            $("#7_" + i).val(r.det[i].qty);
            $("#9_" + i).val(r.det[i].discount_pre);
            $("#3_" + i).val(r.det[i].discount);
            $("#55_" + i).val(r.det[i].delivery_qty);
            total_discount = total_discount + parseFloat(r.det[i].discount);
            $("#free_price_"+i).val(r.det[i].sales_price);
            $("#4_" + i).val(r.det[i].amount);
            $("#5_" + i).val(r.det[i].warenty);
            $("#f_"+i).val(r.det[i].is_free);
            $("#serial_"+i).val(r.det[i].serials);
            if(r.det[i].is_free=="1")
            {
               if(r.det[i].foc==""){
                $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].qty));
                $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].qty));
            }else{
                $("#free_"+i).attr('checked', true);
                $("#free_price_"+i).val(r.det[i].price);
                $("#bal_free_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
                $("#issue_qty_"+i).val(parseFloat(r.det[i].free_balance)+parseFloat(r.det[i].foc));
            }
        }
        if(r.det[i].is_free=='1'){
          $("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
          $("#n_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;');
          $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
          $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
          $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :100%; float: right; text-align:left;');
          $("#9_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
          $("#9_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
          $("#4_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
          $("#4_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
          $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
          $("#6_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
          $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
          $("#8_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
          $("#8_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
          $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
          $("#2_"+i).val(r.det[i].sales_price);
          fre +=parseFloat(r.det[i].amount);    
      }else{
        $("#2_"+i).val(r.det[i].sales_price);
        $("#free_price_"+i).val(r.det[i].sales_price);
    }
    var bal_tot=parseFloat(r.det[i].sales_price)*r.det[i].free_balance;
    $("#bal_tot_"+i).val(r.det[i].free_balance+"-"+bal_tot);
    check_is_batch_item2(r.det[i].item_code,i);
    check_is_sub_item2(r.det[i].item_code,i); 
    is_sub_item(i);  
}
result = r.add.length;
for (var i = 0; i < r.add.length; i++) {
    $("#hhh_" + i).val(r.add[i].sales_type);
    $("#hh_" + i).val(r.add[i].is_add);
    $("#00_" + i).val(r.add[i].sales_type);
    $("#nn_" + i).val(r.add[i].description);
    $("#11_" + i).val(r.add[i].rate_p);
    $("#tt_" + i).val(r.add[i].amount);
}
$("#installment_calc").click();
if (r.sum[0].is_cancel == 1) {
    $("#btnDelete").attr("disabled", "disabled");
    $("#btnSave").attr("disabled", "disabled");
    $("#mframe").css("background-image", "url('img/cancel.png')");
}
if (r.sum[0].is_closed == 1) {
    set_msg("This agreement no already colsed");
    $("#btnDelete").attr("disabled", "disabled");
    $("#btnSave").attr("disabled", "disabled");
    $("#mframe").css("background-image", "url('img/closed.png')");
}
if (r.sum[0].is_closed == 1 && r.sum[0].is_cancel == 1){
    set_msg("This agreement no already Returned");
    $("#btnDelete").attr("disabled", "disabled");
    $("#btnSave").attr("disabled", "disabled");
    $("#mframe").css("background-image", "url('img/returned.png')");
}
                //   $("#total_discount").val(m_round(total_discount));
                //   $("#total_amount").val(m_round(gross_amount+total_discount));
                amount();
                net_amount();
                get_additional_amt();
                //cal_balance();
                get_scheme(r.sum[0].scheme_id);
                //account_settle();
                $("#tot_free").val(m_round(fre));
                $("#net_amt").val(m_round(gross_amount-fre));
                var tt = (parseFloat(r.sum[0].balance) * parseFloat(r.sum[0].interest_rate)/100);
                $("#total_interest").val(m_round(tt));
            }
        }
        loding();
    }, "json");
    //setTimeout("cal_tot_interest()",400);
}
function empty_grid() {
    for (var i = 0; i < 25; i++) {
        $("#h_" + i).val(0);
        $("#0_" + i).val("");
        $("#n_" + i).val("");
        $("#t_" + i).html("&nbsp;");
        $("#1_" + i).val("");
        $("#2_" + i).val("");
        $("#3_" + i).val("");
        $("#5_" + i).val("");
        $("#4_" + i).val("");
        $("#6_" + i).val("");
        $("#7_" + i).val("");
        $("#8_" + i).val("");
        $("#9_" + i).val("");
        $("#btnDelete").prop("disabled", false);
        $("#btnSave").prop("disabled", false);
        $("#mframe").css("background-image", "none");
    }
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
function check_is_batch_item2(x, scid) {
    var store = $("#stores").val();
    $.post("index.php/main/load_data/t_hp/is_batch_item", {
        code: x,
        store: store
    }, function (res) {
        $("#btnb_" + scid).css("display", "none");
        if (res == 1) {
            $("#btnb_" + scid).css("display", "block");
        }
    }, 'text');
}

function check_is_batch_item(scid) {
    var store = $("#stores").val();
    $.post("index.php/main/load_data/t_hp/is_batch_item", {
        code: $("#0_" + scid).val(),
        store: store
    }, function (res) {
        if (res == 1) {
            $("#serch_pop3").center();
            $("#blocker3").css("display", "block");
            setTimeout("select_search3()", 100);
            load_items3($("#0_" + scid).val());
        } else if (res == '0') {
            $("#6_" + scid).val("0");
            $("#6_" + scid).attr("readonly", "readonly");
        } else {
            $("#6_" + scid).val(res.split("-")[0]);
            //$("#7_" + scid).val(res.split("-")[1]);
            //$("#bqty_"+scid).val(res.split("-")[1]);
            $("#1_" + scid).attr("readonly", "readonly");
        }
    }, 'text');
}
function dis_prec() {
    var qty = parseFloat($("#7_" + scid).val());
    var price = parseFloat($("#2_" + scid).val());
    var discount = parseFloat($("#3_" + scid).val());
    var dis_pre = 0;

    if (isNaN(qty)) {
        qty = 0;
    }
    if (isNaN(price)) {
        price = 0;
    }
    if (isNaN(discount)) {
        discount = 0;
    }
    if (!isNaN(qty) && !isNaN(price) && !isNaN(discount)) {
        dis_pre = (discount * 100) / price;
        //dis_pre=(discount*100)/(qty*price); //discount pre for all item
        if (isNaN(dis_pre) || !isFinite(dis_pre)) {
            $("#9_" + scid).val("");
        } else {
            $("#9_" + scid).val(m_round(dis_pre));
        }
    }
}
function amount() {
    var all_foc= tot_foc=amnt = 0;
    $(".qty").each(function (e) {
        if($("#0_"+e).val()!="" && $("#8_"+e).val()=="1"){
            tot_foc+=parseFloat($("#2_"+e).val());
        }
        if($("#0_"+e).val()!="" && $("#f_"+e).val()!="1" && $("#2_"+e).val()!=""){
            amnt+=parseFloat($("#2_"+e).val());
        }
    });
    //$("#tot_free").val(m_round(tot_foc));
    $("#total_amt2").val(m_round(amnt));
    var qty = parseFloat($("#7_" + scid).val());
    var price = parseFloat($("#2_" + scid).val());
    var foc = parseFloat($("#8_" + scid).val());
    var amount = "";
    if (isNaN(qty)) {
        qty = 0;
    }
    if (isNaN(price)) {
        price = 0;
    }
    if (isNaN(foc)) {
        foc = 0;
    }
    var total_dis = 0;
    var total_foc = m_round(price * foc);
    $("#tot_foc_" + scid).val(m_round(total_foc));
    var discount = parseFloat($("#3_" + scid).val());
    var dis_pre = 0;
    if (isNaN(discount)) {
        discount = 0;
    }
    if (!isNaN(qty) && !isNaN(price) && !isNaN(discount) && !isNaN(foc)) {
        //amount=(qty+foc)*price;
        amount = (qty) * price;
        total_dis = (qty) * discount;
        amount = amount - total_dis;
        dis_pre = (discount * 100) / price;
        if (isNaN(dis_pre) || !isFinite(dis_pre)) {
            $("#9_" + scid).val("");
        } else {
            $("#9_" + scid).val(m_round(dis_pre));
        }
        $("#tot_dis_" + scid).val(m_round(total_dis));
        $("#4_" + scid).val(m_round(amount));
    } else if (!isNaN(qty) && !isNaN(price) && !isNaN(discount)) {
        amount = (qty * price) - discount;
        if (amount != 0) {
            $("#4_" + scid).val(m_round(amount));
        } else {
            $("#4_" + scid).val("");
        }
    } else if (!isNaN(qty) && !isNaN(price)) {
        amount = (qty * price);
        if (amount != 0) {
            $("#4_" + scid).val(m_round(amount));
        } else {
            $("#4_" + scid).val("");
        }
    }
}
function gross_amount() {
    var gross = loop=free2=free= 0;
    $(".amount").each(function () {
        var gs = parseFloat($("#2_" + loop).val() * $("#7_" + loop).val());
        if (!isNaN(gs)) {
            gross = gross + gs;
        }if($("#f_"+loop).val()==1){
            free+=parseFloat($("#4_"+loop).val())
        }
        loop++;
    });if($("#free_tot2").val()!=""){
       var free2=parseFloat($("#free_tot2").val());
   }else{
    var free2="0.00";
}
$("#total_amt").val(m_round(gross));
//$("#tot_free").val(m_round(parseFloat(free)+parseFloat(free2)));
$("#net_amt").val(m_round(gross));
}
function total_dis() {
    var discount = parseFloat(0);
    $(".dis").each(function (e) {
        if (!isNaN(parseFloat($("#3_" + e).val()))) {
            discount = discount + (parseFloat($("#3_" + e).val()) * parseFloat($("#7_" + e).val()));
        }
    });
    $("#tot_dis").val(m_round(discount));
}

function net_amount() {
    var gross_amount = 0;
    var free_tot2=parseFloat($("#free_tot2").val());

    $(".amount").each(function (loop) {
        var gs = parseFloat($("#4_" + loop).val());
        if (!isNaN(gs)) {
            gross_amount = gross_amount + gs;
        }
    });
    
    var net_amount = additional = loop = 0;
    $(".foo").each(function () {
        var add = parseFloat($("#tt_" + loop).val());
        var f = $("#hh_" + loop).val();
        if (!isNaN(add)) {
            if (f == 1) {
                additional = additional + add;
            } else {
                additional = additional - add;
            }
        }
        loop++;
    });
    if(isNaN(free_tot2)){
        free_tot2='0.00';
    }
    if (!isNaN(additional) && !isNaN(gross_amount)) {
        net_amount = gross_amount + additional;
        $("#net").val(m_round(net_amount));
    } else {
     net_amount = gross_amount + additional;
     $("#net").val(m_round(net_amount));
 }
 var discount = 0;
 $(".tot_discount").each(function (e) {
    if (!isNaN(parseFloat($("#tot_dis_" + e).val()))) {
        discount = discount + parseFloat($("#tot_dis_" + e).val());
    }
});
 $("#total_discount").val(m_round(discount));
 $("#total_amount").val(m_round(gross_amount + discount));
}
function load_items3(x) {
    $.post("index.php/main/load_data/t_cash_sales_sum/batch_item", {
        search: x,
        stores: $("#stores").val()
    }, function (r) {
        $("#sr3").html(r);
        settings3();
    }, "text");
}
function settings3() {
    $("#batch_item_list .cl").click(function () {
        if ($(this).children().eq(0).html() != "&nbsp;") {
            if (check_item_exist3($(this).children().eq(0).html())) {
                $("#6_" + scid).val($(this).children().eq(0).html());
                //$("#5_"+scid).val($(this).children().eq(1).html());
                $("#bqty_" + scid).val($(this).children().eq(1).html());
                $("#2_" + scid).val($(this).children().eq(2).html());
                $("#6_" + scid).attr("readonly", "readonly");
                $("#7_" + scid).focus();
                //discount();
                dis_prec();
                amount();
                gross_amount();
                all_rate_amount();
                net_amount();
                get_additional_amt();
                $("#pop_close3").click();
            } else {
                set_msg("Item " + $(this).children().eq(1).html() + " is already added.");
            }
        } else {
            $("#6_" + scid).val("");
            $("#7_" + scid).val("");
            $("#2_" + scid).val("");
            //discount();
            dis_prec();
            amount();
            gross_amount();
            privilege_calculation();
            all_rate_amount();
            net_amount();
            get_additional_amt();
            $("#pop_close3").click();
        }
    });
}
function select_search3() {
    $("#pop_search3").focus();
}
function check_item_exist3(id) {
    var v = true;
    return v;
}
function all_rate_amount() {
    var gross_amount = parseFloat($("#gross").val());
    var additional = loop = 0;
    $(".rate").each(function () {
        var rate = parseFloat($("#11_" + loop).val());
        var rate_amount = 0;
        if (!isNaN(rate) && !isNaN(rate_amount)) {
            rate_amount = (gross_amount * rate) / 100;
            $("#tt_" + loop).val(m_round(rate_amount));
        }
        loop++;
    });
}
function set_cus_values(f) {
    var v = f.val();
    v = v.split("|");
    if (v.length == 2) {
        f.val(v[0]);
        $("#customer_id").val(v[1]);
    }
}
function set_scheme_values(f) {
    var v = f.val();
    v = v.split("|");
    if (v.length == 2) {
        f.val(v[0]);
        $("#scheme_des").val(v[1]);
    }
}
function set_category_values(f) {
    var v = f.val();
    v = v.split("|");
    if (v.length == 2) {
        f.val(v[0]);
        $("#category_des").val(v[1]);
    }
}
function load_items() {
    $.post("index.php/main/load_data/t_hp/item_list_all", {
        search: $("#pop_search").val(),
        stores: $("#stores").val(),
        dealer: $("#dealer_id").val()
    }, function (r) {
        $("#sr").html(r);
        settings1();
        price_type();
    }, "text");
}
function load_data3() {
    $.post("index.php/main/load_data/utility/f1_selection_list_customer", {
        data_tbl:"m_customer",
        field:"code",
        field2:"name",
        field3:"nic",
        field4:"tp",
        add_query:" AND is_customer='1'",
        preview1:"Customer ID",
        preview2:"Customer Name",
        preview3:"Customer NIC",
        search : $("#pop_search10").val() 
    }, function(r){
        $("#sr10").html(r);
        common_setting('#customer','#customer_id','#pop_close10');     
    }, "text");
}
function load_data4() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl: "m_hp_payment_scheme",
        field: "code",
        field2: "description",
        search: $("#pop_search11").val()
    }, function (r) {
        $("#sr11").html(r);
        common_setting2('#scheme','#scheme_des','#pop_close11');
    }, "text");
}

function load_data6() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl: "m_hp_sales_category",
        field: "code",
        field2: "description",
        search: $("#pop_search12").val()
    }, function (r) {
        $("#sr12").html(r);
        //common_setting('#category','#category_des','#pop_close12');
        settings8();
    }, "text");
}
function settings8(){
    $("#item_list .cl").click(function(){        
        $("#category").val($(this).children().eq(0).html());
        $("#category_des").val($(this).children().eq(1).html());
        load_serialNo($(this).children().eq(0).html());
        $("#pop_close12").click();                
    })    
}
function load_serialNo(category){
    $.post("index.php/main/load_data/t_hp/serial_number",{
        category_id: category,
        type: "2"
    }, function (r) {
       //alert(r);
       $("#agreement_no").val(r);
   }, "text");
}

function load_data7() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl: "m_guarantor",
        field: "code",
        field2: "full_name",
        search: $("#pop_search13").val()
    }, function (r) {
        $("#sr13").html(r);
        common_setting('#guarantor_1','#guarantor_1_des','#pop_close13');
    }, "text");
}

function load_data8() {
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl: "m_guarantor",
        field: "code",
        field2: "full_name",
        search: $("#pop_search14").val()
    }, function (r) {
        $("#sr14").html(r);
        common_setting('#guarantor_2','#guarantor_2_des','#pop_close14');
    }, "text");
}
function select_search2() {
    $("#pop_search2").focus();
}
function load_items2() {
    $.post("index.php/main/load_data/r_additional_items/item_list_all", {
        search: $("#pop_search2").val(),
        stores: false
    }, function (r) {
        $("#sr2").html(r);
        settings11();
    }, "text");
}

function get_scheme(code) {
    $.post("index.php/main/load_data/t_hp/get_scheme", {
        code: code
    }, function (r) {
        if($("#hid").val()!="0"){   
        }else{
          settings10(r);
      }
  }, "json");
}
function get_additional_amt(is_add) {
   var gross_amount = 0;
   $(".amount").each(function (loop) {
    var gs = parseFloat($("#4_" + loop).val());
    if (!isNaN(gs)) {
        gross_amount = gross_amount + gs;
    }
});
   var net_amount = additional = loop = 0;
   $(".foo").each(function () {
    var add = parseFloat($("#tt_" + loop).val());
    var f = $("#hh_" + loop).val();
    if (!isNaN(add)) {
        if (f == 1) {
            additional = additional + add;
        } else {
            additional = additional - add;
        }
    }
    loop++;
});
   if (!isNaN(additional) && !isNaN(gross_amount)) {
    net_amount = gross_amount + additional - parseFloat($("#tot_free").val());
    $("#net_amt").val(m_round(net_amount));
} else {
    $("#net_amt").val(m_round(net_amount-parseFloat($("#tot_free").val())));
}
}
function cal_balance() {
    separate_balance();
    /*if($("#dwn_type").val()=="2"){
        var dwn_p = parseFloat($("#net_amt").val()) * parseFloat($("#down_payment").val()) / 100;
    }else{
        var dwn_p = $("#down_payment").val();
    }
    $("#down_payment").val(dwn_p);*/
    //alert(dwn_p);
    if($("#sep_bal").val()==0){
         // alert($("#net_amt").val()+"--"+$("#document_charges").val()+"---"+$("#down_payment").val());
         var balance = (parseFloat($("#net_amt").val()) + parseFloat($("#document_charges").val())) - parseFloat($("#down_payment").val());
     }
     else{
        var balance = (parseFloat($("#net_amt").val())) - parseFloat($("#down_payment").val()); 
    }
    if($("#hid").val()=="" || $("#hid").val()=="0"){
        $("#balance").val(m_round(balance));
    }
    cal_installments();
}
function separate_balance(){
    $.post("index.php/main/load_data/t_hp/sep_bal", {
    }, function (r) {
        $("#sep_bal").val(r);
    }, "text");
}
function cal_tot_interest() {
    var interest = (parseFloat($("#balance").val()) * parseFloat($("#interest_rate").val())) / 100;
    var tot_interest=interest*parseFloat($("#num_of_installment").val())
    $(total_interest).val(m_round(tot_interest));
}
function cal_installment() {
    var balance = parseFloat($("#balance").val());
    var total_interest = parseFloat($("#total_interest").val());
    var num_of_installment = parseFloat($("#num_of_installment").val());
    if (!(isNaN(balance) || isNaN(num_of_installment) || isNaN(total_interest))) {
        var installment = (balance + total_interest) / num_of_installment;
        $("#installment").val(m_round(installment));
    }
}
function due_date(x) {
    $.post("index.php/main/load_data/t_payment_option/get_due_date_hp", {
        trans_date: $("#dueDate").val(),
        trans_date2: $("#date").val(),
        num_of_days: $("#period").val(),
        num_of_installment: $("#num_of_installment").val(),
        installment_num: x
    }, function (res) {
        for (n = 0; n < res.a.length; n++) {
            $("#duedate_" + (n + 1)).val(res.a[n]);
        }
    }, "json");
}
function due_date2(x) {
    $.post("index.php/main/load_data/t_payment_option/get_due_date2", {
        trans_date: $("#date").val(),
        num_of_days: $("#period").val(),
        num_of_installment: $("#num_of_installment").val(),
        installment_num: x
    }, function (res) {
        for (n = 0; n < res.a.length; n++) {
            $("#duedate_" + (n + 1)).val(res.a[n]);
        }
    }, "json");
}
function set_additional_amt(scid) {
    var gross_amount = 0;
    $(".amount").each(function (loop) {
        var gs = parseFloat($("#4_" + loop).val());
        if (!isNaN(gs)) {
            gross_amount = gross_amount + gs;
        }
    });
    var additional_amt = (parseFloat(gross_amount) * parseFloat($("#11_" + scid).val())) / 100;
    return additional_amt;
}
function set_rate() {
    var amount = parseFloat($("#tt_" + scid).val());
    var total_amount = parseFloat($("#total_amt").val());
    if (!(isNaN(amount) || isNaN(total_amount))) {
        var rate = parseFloat(0);
        rate = (amount * 100) / total_amount;
        $("#11_" + scid).val(rate);
    }
}

function account_settle() {
    dis_prec();
    amount();
    tot_amount(scid);
    total_dis();
    gross_amount();
    set_rate();
    set_additional_amt();
    get_additional_amt();
    net_amount();
    cal_balance();
    cal_tot_interest();
    cal_installment();
}
function check_is_sub_item2(x,scid){
    var store=$("#stores").val();
    $.post("index.php/main/load_data/utility/is_sub_item",{
        code:x          
    },function(res){
        $("#sub_"+scid).css("display","none");    
        if(res==1){
            $("#sub_"+scid).css("display","block");
        }
    },'text');
}
function get_group(){
    $.post("index.php/main/load_data/r_groups/select_by_category", {
        category_id : $("#sales_category").val()
    }, function(r){
     $("#groups").html(r);
 }, "text");
}
function load_rep(){
    $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        filter_emp_cat:"salesman",
        search : $("#pop_search6").val() 
    }, function(r){
        $("#sr6").html("");
        $("#sr6").html(r);
        settings_rep();            
    }, "text");
}
function settings_rep(){
    $("#item_list .cl").click(function(){        
        $("#sales_rep").val($(this).children().eq(0).html());
        $("#sales_rep2").val($(this).children().eq(1).html());
        $("#pop_close6").click();                
    })    
}
function sales_category_max(){
  $.post("index.php/main/load_data/utility/get_max_sales_category", {
    nno:"sub_no",
    table:"t_hp_sales_sum",
    category:$("#sales_category").val(),
    hid:$("#hid").val()
}, function(r){
    $("#sub_no").val(r);          
},"text");
}
function is_sub_item(x){
  sub_items=[];
  
  $("#subcode_"+x).val("");
  $.post("index.php/main/load_data/utility/is_sub_items", {
    code:$("#0_"+x).val(),
    qty:$("#7_"+x).val(),
    batch:$("#6_"+x).val()
}, function(r){
    if(r!=2){
      for(var i=0; i<r.sub.length;i++){
        add(x,r.sub[i].sub_item,r.sub[i].qty);
    }  
    $("#subcode_"+x).attr("data-is_click","1");
}
},"json");
}
function add(x,items,qty){
  $.post("index.php/main/load_data/utility/is_sub_items_available", {
      code:items,
      qty:qty,
      grid_qty:$("#7_"+x).val(),
      batch:$("#6_"+x).val(),
      hid:$("#hid").val(),
      trans_type:"6",
      store:$("#stores").val()
  }, function(res){
    if(res!=2){
      sub_items.push(res.sub[0].sub_item+"-"+res.sub[0].qty);
      $("#subcode_"+x).val(sub_items);
  }else{
      set_msg("Not enough quantity in this sub item ("+items+")","error");
      $("#subcode_"+x).val("");
  }
},"json");
}
function check_is_sub_item(scid){        
    var store=$("#stores").val();
    $.post("index.php/main/load_data/utility/is_sub_item",{
        code:$("#0_"+scid).val(),          
    },function(res){        
     if(res==1)
     {
        $("#serch_pop3").center();
        $("#blocker3").css("display", "block");
        setTimeout("select_search3()", 100);
        load_items4($("#0_"+scid).val(),$("#6_"+scid).val());
    }
},'text');
}
function load_items4(x,batch){
    $.post("index.php/main/load_data/utility/sub_item", {
        search : x,
        batch :batch
    }, function(r){
        $("#sr3").html(r);
    }, "text");
}
function check_batch_qty(scid){
    $.post("index.php/main/load_data/t_hp/get_batch_qty",{
        store:$("#stores").val(),
        batch_no:$("#6_"+scid).val(),
        code:$("#0_"+scid).val(),
        hid:$("#hid").val(),
        dealer:$("#dealer_id").val()
    },function(res){
        if(parseFloat(res)<0){
            res=0;
        }
        if(parseFloat(res) < parseFloat($("#7_"+scid).val())){
          $("#8_"+scid).val("");
          set_msg("There is not enough quantity in this batch","error");
      }
  },"text");
}
function balance_item_free(id){
 var qty = parseInt($("#7_"+id).val());
 var foc = parseInt($("#8_"+id).val());
 var bal = parseInt($("#bal_free_"+id).val());
 var each_price = parseFloat($("#2_"+id).val());
 var price = parseFloat($("#free_price_"+id).val());
 var is_free_item = $("#f_"+id).val();

 if($("#8_"+id).val()!="" && $("#8_"+id).val()!="0"){
    bal = bal-foc;
    $("#bal_tot_"+id).val(bal+"-"+each_price*bal);
    $("#f_"+id).val("2");
}else{
    bal = bal-qty;
    $("#bal_tot_"+id).val(bal+"-"+price*bal);
}
}

function item_free_delete(no){
 if(isNaN(parseInt($("#8_"+no).val()))){
    var qty=parseInt($("#7_"+no).val());
}else{
    var qty=parseInt($("#7_"+no).val())-parseInt($("#8_"+no).val());
}
var item=$("#0_"+no).val();
$.post("index.php/main/load_data/t_hp/item_free_delete",{
    quantity:qty,
    item:item
},function(r){
    if(r!='2'){
        $("#f_"+no).val("2");
        for(var x=0; r.a.length>x;x++){
            for(var i=0; i<25;i++){ 
                if($("#0_"+i).val()==item || $("#0_"+i).val()==r.a[x].code  && $("#f_"+i).val()==1){
                    console.log($("#0_"+i).val());
                    $(this).val("");
                    $("#h_"+i).val("");
                    $("#0_"+i).val("");
                    $("#n_"+i).val("");
                    $("#1_"+i).val(""); 
                    $("#2_"+i).val(""); 
                    $("#3_"+i).val(""); 
                    $("#4_"+i).val(""); 
                    $("#5_"+i).val("");
                    $("#6_"+i).val(""); 
                    $("#7_"+i).val(""); 
                    $("#8_"+i).val(""); 
                    $("#9_"+i).val("");
                    $("#f_"+i).val("");
                    $("#bal_free_"+i).val("");
                    $("#bal_tot_"+i).val("");
                    $("#free_price_"+i).val("");
                    $("#issue_qty_"+i).val("");
                    $("#subcode_"+i).val("");
                    $("#bqty"+i).val("");
                    $("#subcode_"+i).removeAttr("data-is_click");
                    $("#7_"+i).attr("readonly", false);

                    $("#h_"+no).val("");
                    $("#0_"+no).val("");
                    $("#n_"+no).val("");
                    $("#1_"+no).val(""); 
                    $("#2_"+no).val(""); 
                    $("#3_"+no).val(""); 
                    $("#4_"+no).val(""); 
                    $("#5_"+no).val("");
                    $("#6_"+no).val(""); 
                    $("#7_"+no).val(""); 
                    $("#8_"+no).val(""); 
                    $("#9_"+no).val("");
                    $("#f_"+no).val("");
                    $("#bal_free_"+no).val("");
                    $("#bal_tot_"+no).val("");
                    $("#free_price_"+no).val("");
                    $("#issue_qty_"+no).val("");
                    $("#subcode_"+no).val("");
                    $("#bqty"+no).val("");
                    $("#subcode_"+no).removeAttr("data-is_click");
                    $("#7_"+no).attr("readonly", false);
                    $("#n_"+i).closest("td").attr('style', 'background-color: #f9f9ec !important');
                    $("#n_"+i).attr('style', 'width: 145px; background-color: #f9f9ec !important');
                    $("#2_"+i).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                    $("#1_"+i).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
                    $("#1_"+i).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
                    $("#3_"+i).closest("td").attr('style', 'width: 58px;');
                    $("#6_"+i).closest("td").attr('style', 'width:60px; background-color: #f9f9ec !important');
                    $("#6_"+i).attr('style', 'width: 44px; background-color: #f9f9ec !important');
                    $("#8_"+i).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');
                    $("#9_"+i).closest("td").attr('style', 'width:58px; background-color: #f9f9ec !important');
                    $("#9_"+i).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                    $("#0_"+i).closest("tr").attr('style', 'background-color: #ffffff !important;');
                    $("#4_"+i).closest("td").attr('style', 'width:58px; background-color: #f9f9ec !important');
                    $("#4_"+i).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                    $("#8_"+i).closest("td").attr('style', 'width:44px; background-color: #f9f9ec !important');
                           /* $("#n_"+no).closest("td").attr('style', 'width:132px; background-color: #f9f9ec !important');
                            $("#n_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#2_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#1_"+no).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
                            $("#1_"+no).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
                            $("#3_"+no).closest("td").attr('style', 'width: 58px; ');
                            $("#6_"+no).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            $("#6_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#9_"+no).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            $("#9_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#4_"+no).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
                            $("#4_"+no).attr('style', 'width: 100%; background-color: #f9f9ec !important');
                            $("#8_"+no).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');
                            */
                            $("#0_"+no).closest("tr").attr('style', 'background-color: #ffffff !important;');

                            /*$("#n_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width:132px; background-color: rgb(224, 228, 146) !important');
                            $("#n_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                            $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
                            $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                            $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                            $("#9_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                            $("#9_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                            $("#4_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                            $("#4_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                            $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
                            $("#6_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
                            $("#6_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
                            $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                            */
                            $("#btn_"+i).css("display","none"); 
                            $("#btnb_"+i).css("display","none");
                            $("#sub_"+i).css("display","none");
                            $("#btn_"+no).css("display","none"); 
                            $("#btnb_"+no).css("display","none");
                            $("#sub_"+no).css("display","none");
                            dis_prec();
                            amount();
                            gross_amount();
                            net_amount();
                            get_additional_amt();
                            cal_balance();
                        }
                    }
                } 
            }
        }, "json");
}
var xc =0;
function item_free(no){
    xc=no;
    if(isNaN(parseInt($("#8_"+no).val())))
    {
        var qty=parseInt($("#7_"+no).val());
    }
    else
    {
        var qty=parseInt($("#7_"+no).val())-parseInt($("#8_"+no).val());
    }

    var item=$("#0_"+no).val();
    $.post("index.php/main/load_data/t_cash_sales_sum/item_free",{
        quantity:qty,
        item:item,
        date:$("#date").val()
    },function(r){
        if(r!='2')
        {
            for(i=0; i<r.a.length; i++)
            {
                if(r.a[i].code == item)
                {
                    var free_qty=parseInt(r.a[i].qty)
                    var issue_qty = qty/free_qty;
                    $("#7_"+no).val(Math.floor(issue_qty)+qty);
                    $("#8_"+no).val(Math.floor(issue_qty));
                }
            }

            $("#serch_pop14").center();
            $("#blocker").css("display", "block");
            //setTimeout("select_search14()", 100);
            load_items5($("#0_"+scid).val(),no);
            xc=scid;
        }
    }, "json");
}

function load_items5(x,y){
 if(isNaN(parseInt($("#8_"+y).val())))
 {
    var qty=parseInt($("#7_"+y).val());
}
else
{
    var qty=parseInt($("#7_"+y).val())-parseInt($("#8_"+y).val());
}
var item=$("#0_"+y).val();
$.post("index.php/main/load_data/t_cash_sales_sum/item_free_list",{
    quantity:qty,
    item:item,
    date:$("#date").val()
},function(r){   
    if(r!=2){ 
        $("#sr14").html(r);
        /* settings6();*/
        $("#7_"+y).attr("readonly",true);
    }
}, "text");
}


function check_items(){
    var check_det="";
    var cont=0;
    $(".chk_class").each(function(e){
        if($("#free_chk_"+e).is(':checked')){
            check_det+=$("#item_"+e).html()+"|"+$("#des_"+e).html()+"|"+$("#model_"+e).html()+"|"+$("#max_"+e).html()+"|"+$("#itemqty_"+e).html()+"|"+$("#qty_"+e).html()+",";   
            cont++;
            
        }
    });
    var fr_item=($("#fritems").html());
    get_chk_itm_det(check_det,fr_item,cont); 
}
function check_item_exist2(id){
    var v = true;
    $("input[type='hidden']").each(function(){
        if($(this).val() == id){
            v = false;
        }
    });    
    return v;
}

function check_is_batch_item_free(scid){
    var store=$("#stores").val();
    $.post("index.php/main/load_data/t_cash_sales_sum/is_batch_item",{
        code:$("#0_"+scid).val(),
        store:store
    },function(res){
     if(res==1){
        $("#serch_pop3").center();
        $("#blocker3").css("display", "block");
        setTimeout("select_search3()", 100);
        load_items3($("#0_"+scid).val());
    }else if(res=='0'){
        $("#6_"+scid).val("0");
        $("#6_"+scid).attr("readonly","readonly");
    }else{
        $("#6_"+scid).val(res.split("-")[0]);
        $("#bqty_"+scid).val(res.split("-")[1]);
        $("#6_"+scid).attr("readonly","readonly");
    }
},'text');
}
function load_def_sales(){
   $.post("index.php/main/load_data/t_hp/load_sales_stores/", {
   }, function(r){
     //alert(r);
     if(r!=3){
      $("#stores").val(r[0].def_sales_store_code);
      $("#store_id").val(r[0].description);
  }
}, "json");
}
function load_dealer(){
    if($("#load_type").val()=="2"){
        var tbl="m_customer";
        var p_name="Dealer Name";
        var a_query='AND type="003"';
    }else{
        var tbl="r_groups";
        var p_name="Group Name";
        var a_query="";
    }
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:tbl,
        field:"code",
        field2:"name",
        preview2:p_name,
        add_query:a_query,
        search : $("#pop_search13").val() 
    }, function(r){
        $("#sr13").html(r);
        settings14();            
    }, "text");
}
function settings14(){
    $("#item_list .cl").click(function(){        
        $("#dealer_id").val($(this).children().eq(0).html());    
        $("#pop_close13").click();     
    })    
}

function get_chk_itm_det(check_det,free_item,count){
    var free_item=free_item;
    var count=count;
    var status=$("#itm_status_"+scid).val();
    scid =tc;
    if(status!="1"){
       if(free_item==count){
        if(isNaN(parseInt($("#4_"+scid).val()))){
            var qty=parseInt($("#5_"+scid).val());
        }else{
            var qty=parseInt($("#5_"+scid).val())-parseInt($("#4_"+scid).val());
        }
        if($("#4_"+scid).val() != "")
        {
            $("#bal_free_"+scid).val($("#4_"+scid).val());
            $("#issue_qty_"+scid).val($("#4_"+scid).val());
        }
        var free_qty = "";
        var check_details=check_det;
        var split_1=check_details.split(",");
        var len=split_1.length-1;
        for(x=0;x<len;x++){
            var split_2=split_1[x].split("|");
            var Item_code=split_2[0];
            var Item_name=split_2[1];
            var Item_model=split_2[2];
            var Item_price=split_2[3];
            var Item_qty=split_2[4];
            var select_qty=split_2[5];

       //if(Item_code != "&nbsp;"){
        free_qty=parseInt(Item_qty);
        if(check_item_exist2(Item_code)){
          var get=Item_code;
          var name=Item_name;
          var modal=Item_model;
          var price=Item_price;
          var sign="1";
          var sign="1";
          var issue_qty = (qty/select_qty);
          if(qty%select_qty=='0'){
           var issue_qty = (qty/select_qty)*Item_qty;
       }else{
        var floor_issue=Math.floor(issue_qty);
        var issue_qty=parseInt(floor_issue*Item_qty);
    }

    for(var i=0; i<25 ;i++){
        if($("#0_"+i).val()==get){
            return false;
        }else if($("#0_"+i).val()==""){
            if($("#df_is_serial").val()=='1'){
                check_is_serial_item2(get,i);
            }

            $("#0_"+i).val(get);
            $("#h_"+i).val(get);
            $("#n_"+i).val(name);
            $("#1_"+i).val(modal);
            $("#2_"+i).val(price);
            $("#free_price_"+i).val(price);
            $("#4_"+i).val($("#7"+i).val()*$("#4"+i).val());
            $("#issue_qty_"+i).val(Math.floor(issue_qty));
            $("#f_"+i).val(sign);
            $("#bal_free_"+i).val(Math.floor(issue_qty));
            $("#n_"+i).removeClass('g_col_fixed').attr('style', 'width:100%; background-color: rgb(224, 228, 146) !important');
            $("#2_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
            $("#9_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
            $("#1_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 71px; background-color: rgb(224, 228, 146) !important');
            $("#4_"+i).removeClass('g_col_fixed').attr('style', ' width: 100%; background-color: rgb(224, 228, 146) !important');
            $("#1_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; margin:0;padding:0;width :56px; float: right; text-align:right;');
            $("#3_"+i).closest("td").removeClass('g_col_fixed').attr('style', 'width: 58px; background-color: rgb(224, 228, 146) !important');
            $("#6_"+i).removeClass('g_col_fixed').attr('style', 'width: 100%; background-color: rgb(224, 228, 146) !important');
            $("#7_"+i).removeClass('g_col_fixed').attr('style', 'background-color: rgb(224, 228, 146) !important; width : 100%; text-align:right;');
            $("#7_"+i).val(free_qty);
            $("#0_"+i).closest("tr").attr('style', 'background-color: rgb(224, 228, 146) !important;');
                      /*  $("#5_"+i).focus();
                      $("#3_"+i).blur();*/
                      check_is_batch_item2(get,i);
                      check_is_sub_item2(get,i);
                      check_is_batch_item_free(i);
                      check_is_batch_item(i);
                      break; 
                  }
              } 

              $("#11_"+scid).focus();
              all_rate_amount();
              net_amount();
              $("#pop_close2").click();  
          }else{
            var ff = qty/free_qty;
            for(var a=0; a<25 ;a++){
                if($("#0_"+a).val()==$(this).children().eq(0).html()){
                        //$("#5_"+a).val(Math.floor(ff));
                    }
                    
                }  
                set_msg("Item "+$(this).children().eq(1).html()+" is already added and free quantity updated.");
            }

        }
    }else{

    }
}else{
    set_msg("Maximum Free Items Already Added");
}
}

function update_shedule(){
  var frm = $('#form_');
  loding();
  $.ajax({
    type: frm.attr('method'),
    url: "index.php/main/load_data/t_hp/update_shedule",
    data:frm.serialize(),
    success: function (pid){
      loding();
      if(pid=="1"){
        alert("OK");
        location.href="";
    }else{
        alert("Fail");
    }
}
},'text');
}
function mark_as_free(i,item){
  $("#free_"+scid).prop('disabled', false);
  $("#0_"+scid).closest("tr").find("td").css('background-color', 'rgb(224, 228, 146)');
  $("#0_"+scid).closest("tr").find("input").removeClass('g_col_fixed');
  $("#0_"+scid).closest("tr").find("input").css('background-color', 'rgb(224, 228, 146)');
  $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');
  $("#issue_qty_"+i).val($("#7_"+i).val());
  $(".subs").css('background-color', 'rgb(224, 228, 146)');
  $("#f_"+i).val("1"); 
  $("#free_"+i).attr('checked', true);
}
function uncheck_free(scid,item){
  $("#0_"+scid).closest("tr").find("td").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input").css('background-color', '#ffffff');
  $("#0_"+scid).closest("tr").find("input[type='button']").css('background-color','');
  $("#1_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#1_"+scid).css('background-color','#f9f9ec');
  $("#2_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#2_"+scid).css('background-color','#f9f9ec');
  $("#3_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#3_"+scid).css('background-color','#f9f9ec');
  $("#n_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#n_"+scid).css('background-color','#f9f9ec');
  $("#4_"+scid).css('background-color','#f9f9ec');
  $("#4_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#5_"+scid).css('background-color','#f9f9ec');
  $("#5_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#55_"+scid).css('background-color','#f9f9ec');
  $("#55_"+scid).closest("td").css('background-color','#f9f9ec');
  $("#f_"+scid).val("0");
  $("#free_"+scid).attr('checked', false);
  $("#4_"+scid).val("0"); 
}



function check_item_in_grid(item,batch,id){
    $(".qty").each(function(e){
        if($("#0_"+e).val()==item && $("#6_"+e).val()==batch && e!=id){
            set_msg("Item ("+item+") in same batch ("+batch+") already added");


        item_free_delete(scid)
        $("#0_" + scid).val("");
        $("#h_" + scid).val("");
        $("#n_" + scid).val("");
        $("#1_" + scid).val("");
        $("#2_" + scid).val("");
        $("#3_" + scid).val("");
        $("#4_" + scid).val("");
        $("#5_" + scid).val("");
        $("#6_" + scid).val("");
        $("#7_" + scid).val("");
        $("#8_" + scid).val("");
        $("#9_" + scid).val("");
        $("#cost_"+scid).val("");
        $("#bal_free_"+scid).val("");
        $("#bal_tot_"+scid).val("");
        $("#free_price_"+scid).val("");
        $("#issue_qty_"+scid).val("");
        $("#subcode_"+scid).val("");
        $("#bqty"+scid).val("");
        $("#item_min_price_"+scid).val("");
        $("#subcode_"+scid).removeAttr("data-is_click");
        $("#7_"+scid).attr("readonly", false);

        $("#btn_"+scid).css("display","none"); 
        $("#btnb_"+scid).css("display","none");
        $("#sub_"+scid).css("display","none");
        $("#n_"+scid).closest("td").attr('style', ' background-color: #f9f9ec !important');
        $("#n_"+scid).attr('style', 'width: 145px; background-color: #f9f9ec !important');
        $("#2_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        $("#1_"+scid).closest("td").attr('style', 'width: 71px; background-color: #f9f9ec !important');
        $("#1_"+scid).attr('style', 'margin:0;padding:0;width :56px; float: right; text-align:right; background-color: #f9f9ec !important');
        $("#3_"+scid).closest("td").attr('style', 'width: 58px;');
        $("#6_"+scid).closest("td").attr('style', 'width: 60px; background-color: #f9f9ec !important');
        $("#6_"+scid).attr('style', 'width: 44px; background-color: #f9f9ec !important');
        $("#9_"+scid).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
        $("#9_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        $("#4_"+scid).closest("td").attr('style', 'width: 58px; background-color: #f9f9ec !important');
        $("#4_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        $("#8_"+scid).attr('style', 'background-color: #f9f9ec !important; width : 100%; text-align:right;');
        $("#8_"+scid).closest("td").attr('style', 'width: 60px; background-color: #f9f9ec !important'); 
        $("#0_"+scid).closest("tr").attr('style', 'width:44px; background-color: #ffffff !important;');
        $("#7_"+scid).attr('style', 'width: 100%; background-color: #f9f9ec !important');
        amount();
        net_amount();
        }
    });
}