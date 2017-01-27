$(document).ready(function()
{
  $("#loan_no").keypress(function(e){
    if(e.keyCode == 112)
    {
      $("#pop_search4").val($("#loan_no").val());
      load_data_loanf1();
      $("#serch_pop4").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search4').focus()", 100);
    }
    $("#pop_search4").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_data_loanf1();

     }
   }); 
    if(e.keyCode == 46){
      $("#loan_no").val("");
      $("#loan").val("");
    }
  });

  $(".input_rebate").keyup(function (e) {
    reabte_cal();
  });

  $(".input_panalty").keyup(function (e) {
    var panalty_tot=parseFloat($("#panalty_rebate").val())+ parseFloat($("#tot_re").val());

    if(!isNaN(panalty_tot)){
      $("#tot_re").val(m_round(panalty_tot));
    }else{
      $("#panalty_rebate").val(m_round(0.00));
    }
  });

  $(".input_other").keyup(function (e) {

    var final_tot=parseFloat($("#other_rebate").val())+ parseFloat($("#tot_re").val());

    if(!isNaN(final_tot)){
      $("#tot_re").val(m_round(final_tot));
    }else{
      $("#other_rebate").val(m_round(0.00));
    }
  });

  $("#capital_rebate").keyup(function() {
    var reb_capital=$(this).val();
    var capital=$("#capital").val();

    var paid_capital=capital-reb_capital;
    if(isNaN(paid_capital)){
      paid_capital='0.00';
    }
    $("#capital_paid").val(paid_capital);
    net_amount();
    net_rebate();
  });

  $("#Interest_rebate").keyup(function() {
    var reb_interest=$(this).val();
    var interest=$("#interrest").val();

    var paid_interest=interest-reb_interest;
    if(isNaN(paid_interest)){
      paid_interest='0.00';
    }
    $("#interest_paid").val(paid_interest);
    net_amount();
    net_rebate();
  });

  $("#panalty_rebate").keyup(function() {
    var reb_panalty=$(this).val();
    var panalty=$("#panalty").val();

    var paid_panalty=panalty-reb_panalty;
    if(isNaN(paid_panalty)){
      paid_panalty='0.00';
    }
    $("#panalty_paid").val(paid_panalty);
    net_amount();
    net_rebate();
  });


  $("#other_rebate").keyup(function() {
    var reb_other_charges=$(this).val();
    var other_charges=$("#other_charges").val();

    var paid_other_charges=other_charges-reb_other_charges;
    if(isNaN(paid_other_charges)){
      paid_other_charges='0.00';
    }
    $("#other_charges_paid").val(paid_other_charges);
    net_amount();
    net_rebate();
  });


  $("#btnSave").click(function(){
   save(); 
   
 });

  $("#no").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
      $(this).attr("readonly","readonly");
      /*$("#btnSave").attr("disabled","disabled")*/
      
    }
  });

  $("#btnPrint").click(function(){
    if($("#hid").val()=="0"){
      set_msg("Please load data before print");
      return false;
    }
    else
    {
      $("#print_pdf").submit();
    }
  });

  $("#btnCancel").click(function(){
    if($("#hid").val()!=0) {
      set_cancel($("#hid").val());
    }else{
     set_msg("Please Load Data");
     return false;
   }
 });

});



function reabte_cal(){

  var capital=parseFloat($("#capital_installment").val());
  var tot_capital=parseFloat($("#capital").val())*capital;
  if(!isNaN(tot_capital)){
    $("#capital_rebate").val(m_round(tot_capital));
    if(capital!=""){
      $("#capital_rebate").attr("readonly",true);
      $("#capital_rebate").addClass("hid_value");
    }else{
      $("#capital_rebate").attr("readonly",false);
      $("#capital_rebate").removeClass("hid_value");
    }
  }else{
    $("#capital_rebate").attr("readonly",false);
    $("#capital_rebate").removeClass("hid_value");
  }

  var interest_installm=parseFloat($("#Interest_installment").val());
  var tot_installlment=parseFloat($("#interrest").val())*interest_installm;
  if(!isNaN(tot_installlment)){
    $("#Interest_rebate").val(m_round(tot_installlment));
    if(interest_installm!=""){
      $("#Interest_rebate").attr("readonly",true);
      $("#Interest_rebate").addClass("hid_value");
    }else{
      $("#Interest_rebate").attr("readonly",false);
      $("#Interest_rebate").removeClass("hid_value");
    }
  }else{
    $("#Interest_rebate").attr("readonly",false);
    $("#Interest_rebate").removeClass("hid_value");
  }

  var tot_rebate=tot_capital+tot_installlment;
  if(!isNaN(tot_rebate)){
    $("#tot_re").val(m_round(tot_rebate));

    
  }

} 


function load_data_loanf1(){
 $.post("index.php/main/load_data/t_hp_rebate/load_agreement_no", {
  search: $('#pop_search4').val(),
}, 
function(r){
  $("#sr4").html(r);
  settings_supf1();            
}, "text");
}

function settings_supf1(){
  $("#item_list .cl").click(
    function(){        
      $("#loan_no").val($(this).children().eq(0).html());
      $("#loan").val($(this).children().eq(1).html());
      $("#bill_no").val($(this).children().eq(3).html());
      ins_det_capital($(this).children().eq(0).html());
      ins_det_other_charges($(this).children().eq(0).html());
      ins_det_advance($(this).children().eq(0).html());
      $("#pop_close4").click(); 
      window.setTimeout(function () {
        var advance_amo=parseFloat($("#advance_amount").val());
        var other_chg=parseFloat($("#other_charges").val());
        if(isNaN(advance_amo)){
          advance_amo='0.00';
        }if(isNaN(other_chg)){
          other_chg='0.00';
        }
        var fin_tot=parseFloat($("#tot_h").val())+parseFloat(other_chg)-parseFloat(advance_amo);  
        $("#tot").val(m_round(fin_tot));           
      }, 1000); 
    }) 
  
}

function ins_det_advance(agr_no){
  $.post("index.php/main/load_data/t_hp_rebate/advane_amo",{
    agr_no:agr_no    
  },
  function (r) {
    $("#advance").val(m_round(r));
    $("#advance_amount").val(m_round(r));
    $("#advance_paid").val(m_round(r));
  }, "json");
}

function ins_det_capital(capital){
  $.post("index.php/main/load_data/t_hp_rebate/capital",{
    ins_capital:capital    
  },
  function (r) {
    $("#ins_detail_capital").val(r.a[0].capital_amount);
    $("#interest").val(r.a[0].int_amount);
    $("#installment").val(r.a[0].ins_amount);
    $("#capital").val(r.a[0].cap_balance);
    $("#interrest").val(r.a[0].intr_bal);
    $("#panalty").val(r.a[0].penalty_bal);
    var tot=parseFloat(r.a[0].cap_balance)+parseFloat(r.a[0].intr_bal)+parseFloat(r.a[0].penalty_bal);
    $("#tot_h").val(m_round(tot));
  }, "json");
}

function ins_det_other_charges(loan_no)
{
  $.post("index.php/main/load_data/t_hp_rebate/other_charges",{

    loan_no:loan_no    
  },
  function (r) {

    if((r.b[0].other_balance)!=null){
      $("#other_charges").val(r.b[0].other_balance);
    }else{
      $("#other_charges").val(m_round(0.00));
    }
    
  }, "json");

}

function validate() {
  if($("#loan_no").val()==""){
    set_msg("Please select Group Sales Code");
    return false;
  }
}

function save(){
  $("#org_print").val("1"); 
  $("#nno").val($("#no").val()); 
  var frm = $('#form_');
  validate();
  loding();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (pid){
      if(pid == 1){               
        $("#btnSave").attr("disabled",true);
        loding();
        if(confirm("Save Completed, Do You Want A print?")){
          if($("#is_prnt").val()==1){
            $("#nno").val($("#no").val());
            $("#print_pdf").submit();
          }
          reload_form();
        }else{
          location.href="";
        }  
        reload_form();
      }else if(pid == 2){
        set_msg("No permission to add data.");
      }else if(pid == 3){
        set_msg("No permission to edit data.");
      }else{
       loding();
       set_msg(pid);
     }
     
   }
 });
}

function reload_form(){
  setTimeout(function(){
    location.href= '';
  },50); 
}

function load_data(id){  
  loding();
  $.post("index.php/main/get_data/t_hp_rebate/", {
    id: id,

  }, function(r){

    if(r=="2"){
      set_msg("No records");
    }else{

      $("#hid").val(id); 
      $("#no").val(id); 
      $("#nno").val(id); 
      $("#date").val(r.hp_reb[0].ddate);
      $("#ref_no").val(r.hp_reb[0].ref_no);
      $("#loan_no").val(r.hp_reb[0].loan_no);
      $("#loan").val(r.hp_reb[0].name);
      $("#ins_detail_capital").val(r.hp_reb[0].capital_amount);
      $("#interest").val(r.hp_reb[0].int_amount);
      $("#installment").val(r.hp_reb[0].ins_amount);
      
      $("#capital").val(r.hp_reb[0].bal_capital);
      $("#interrest").val(r.hp_reb[0].bal_interest);
      $("#panalty").val(r.hp_reb[0].bal_panalty); 
      $("#other_charges").val(r.hp_reb[0].bal_other_Chg); 

      $("#capital_paid").val(r.hp_reb[0].paid_capital); 
      $("#interest_paid").val(r.hp_reb[0].paid_interest); 
      $("#panalty_paid").val(r.hp_reb[0].paid_panalty); 
      $("#other_charges_paid").val(r.hp_reb[0].paid_other_chg); 

      $("#capital_rebate").val(r.hp_reb[0].rbt_capital);
      $("#Interest_rebate").val(r.hp_reb[0].rbt_interest); 
      $("#panalty_rebate").val(r.hp_reb[0].rbt_panalty); 
      $("#other_rebate").val(r.hp_reb[0].rbt_other_chg);
      
      $("#tot").val(r.hp_reb[0].tot_balance); 
      $("#tot_reb").val(r.hp_reb[0].tot_rebate);
      $("#tot_paid").val(r.hp_reb[0].tot_paid);

      $("#advance").val(r.hp_reb[0].advance_amount);
      $("#advance_paid").val(r.hp_reb[0].advance_amount);
      $("#advance_amount").val(r.hp_reb[0].advance_amount);

      if(r.hp_reb[0].is_cancel==1){
        $("#mframe").css("background-image","url('img/cancel.png')");
        $("#btnSave").attr("disabled","disabled");
      }
      if(r.hp_reb[0].is_settled==1){
        $("#btnSave").attr("disabled","disabled");
        $("#btnCancel").attr("disabled","disabled");
        set_msg("This Transaction Cannot Edit.");
      }
    }
    loding();
  }, "json");  

}

function set_cancel(id){
  if(confirm("Are you sure Cancel "+id+"?")){
    loding();
    $.post("index.php/main/load_data/t_hp_rebate/cancel", {
      id : id,
      loan_no: $("#loan_no").val()
    }, function(res){
      if(res == 1){
        loding();
        delete_msg();
      }else if(res == 2){
        set_msg("No permission to delete data.");
      }else{
        set_msg(res);
      }
    }, "text");
  }
}


function net_amount(){
  var paid_capital=parseFloat($("#capital_paid").val());
  var paid_interest=parseFloat($("#interest_paid").val());
  var paid_panalty=parseFloat($("#panalty_paid").val());
  var paid_other=parseFloat($("#other_charges_paid").val());
  var paid_advance=parseFloat($("#advance_paid").val());

  if(isNaN(paid_capital)){
    paid_capital='0.00';
  }
  if(isNaN(paid_interest)){
    paid_interest='0.00';
  }
  if(isNaN(paid_panalty)){
    paid_panalty='0.00';
  }
  if(isNaN(paid_other)){
    paid_other='0.00';
  }
  if(isNaN(paid_advance)){
    paid_advance='0.00';
  }

  var total_paid=parseFloat(paid_capital)-parseFloat(paid_interest)-parseFloat(paid_panalty)-parseFloat(paid_other)-parseFloat(paid_advance);

  $("#tot_paid").val(total_paid);
}


function net_rebate(){
  var reb_capital=parseFloat($("#capital_rebate").val());
  var reb_interest=parseFloat($("#Interest_rebate").val());
  var reb_panalty=parseFloat($("#panalty_rebate").val());
  var reb_other=parseFloat($("#other_rebate").val());

  if(isNaN(reb_capital)){
    reb_capital='0.00';
  }
  if(isNaN(reb_interest)){
    reb_interest='0.00';
  }
  if(isNaN(reb_panalty)){
    reb_panalty='0.00';
  }
  if(isNaN(reb_other)){
    reb_other='0.00';
  }
  

  var total_reb=parseFloat(reb_capital)+parseFloat(reb_interest)+parseFloat(reb_panalty)+parseFloat(reb_other);

  $("#tot_reb").val(total_reb);
}


