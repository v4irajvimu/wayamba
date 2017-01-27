var ove = true; var d = false; var to; var fcid, scid; var banks; var tab_id = 0;
// var message="";

// function clickIE() {if (document.all) {(message);return false;}}
// function clickNS(e) {if 
// (document.layers||(document.getElementById&&!document.all)) {
// if (e.which==2||e.which==3) {(message);return false;}}}
// if (document.layers) 
// {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
// else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

// document.oncontextmenu=new Function("return false");



$(document).ready(function(){
    // $(document).bind("contextmenu",function(e) {
    //  e.preventDefault();
    // });



    $("#light").css("display","none");
    $("#fade").css("display","none");
      
    $(document).on('click', '#hed1', function(){
        $("#sub1").slideToggle();
    });

    $(document).on('click', '#hed2', function(){
        $("#sub2").slideToggle();
    });
 
    $(".menuitem").mouseover(function(){
        set_menu($(this).attr("id"));
    });

    
    $(".submenu").mouseleave(function(e){
	unset_menu();
    });

    $("#close_msg_box").click(function(){
        $("#msg_box").slideUp();
    });

   $("#close_det_box").click(function(){
        $("#det_box").slideUp();
    });
    

    $("#pop_close").click(function(){
        $("#serch_pop").css("display", "none");
        $("#blocker").css("display", "none");
    });

    $("#pop_close2").click(function(){
        $("#serch_pop2").css("display", "none");
        $("#blocker2").css("display", "none");
    });

    $("#pop_close3").click(function(){
        $("#serch_pop3").css("display", "none");
        $("#blocker3").css("display", "none");
    });
    
      $("#pop_close4").click(function(){
        $("#serch_pop4").css("display", "none");
        $("#blocker4").css("display", "none");
        $("#pop_search4").val("");

    });
    
    
    $("#btnSave").click(function(){
        if(validate()){
            save();
        }
    });
    
    $("#btnReset").click(function(){
        reset();
    });
    
    setup_payment_form();
    
    $("#btnClosePay").click(function(){
	$("#payment_methods").css("display", "none");
	$("#blocker").css("display", "none");
    });
    
    $("#btnPayments").click(function(){
	$("#payment_methods").center();
	$("#blocker").css("display", "block");
        
    });
    
    
    $("#btnExit").click(function(){
	window.open('index.php', '_self');
    });
    

    
    $("#btnGenerate").click(function(){
	make_ser();
    });
    
    $("#btnClear").click(function(){
	clear_ser();
    });
    
    $("#btnAdd").click(function(){
	$("#select_all_ser").removeAttr("checked");
	add_serials();
    });
    
    $("#select_all_gen").change(function(){
	if($(this).attr("checked") == "checked"){
	    $(".ser").attr("checked", "checked");
	}else{
	    $(".ser").removeAttr("checked");
	}
    });
    
    $("#select_all_ser").change(function(){
	set_select_ser($(this).attr("checked"));
    });
    
    $("#scustomers").keypress(function(e){
	if(e.keyCode == 13){
	    set_cus_values($(this));
	}
    });
    
    $("#btnOK").click(function(){
	if(parseInt($("#sel_qty").val(), 10) < parseInt($("#ser_quantity").val(), 10)){
	    alert("Please select "+$("#ser_quantity").val()+" serial number(s).");
	}else{
	    $("#serials").css("display", "none");
	    $("#blocker").css("display", "none");
	    $("#serch_pop").css("display", "none");
	}
    });
    

});


function setup_payment_form(){
    var form = $("#pay_form").html();
    $("#payment_methods").html(form);
    $("#pay_form").html("");
}

$(document).keypress(function(e){
    //alert(e.keyCode);
    if(e.keyCode == 27){
          $("#pop_close").click();
          $("#pop_close2").click();
          $("#pop_close3").click();
          $("#pop_close4").click();
    }else if(e.keyCode == 113){
       // $("#btnSave").click();
    }
});

function reset(){
    location.reload();
}



function error_maz(){
    if(d == true){
	alert("Operation fail please contact admin.");
	loding();
	d=false;
    }
}

function set_t_body(){
    var x = $(window).width()-50;
    $("#t_body").css("width", x);
    $("#t_body").css("top", 130);
    $("#t_body").css("left", 25);
}

$(document).keypress(function(e){
    if(e.keyCode == 27){
        unset_menu();
    }
});

function set_menu(id){
    unset_menu();
    var pos = $("#"+id).offset();
    $("#"+id).css("background-color", "#FFF");
    $("#"+id+"_m").css("top", pos.top+15);
    $("#"+id+"_m").css("left", pos.left);
    $("#"+id+"_m").fadeIn(500);
}

function unset_menu(){
    $(".submenu").fadeOut(500);
    $(".menuitem").css("background-color", "#CCC");
}



function m_round(val){
    var number = Math.round(val * Math.pow(10, 2)) / Math.pow(10, 2);
    return number.toFixed(2);
}


function loding(){
    if($("#blanket").css("display")=="none"){
	to = setTimeout("error_maz()", 10000);
	d = true;
	$("#blanket").css("display", "block");
    }else{
	clearTimeout(to);
	d = false;
	$("#blanket").css("display", "none");
    }
}

function set_select(select_id, input_id){

    if($("#"+select_id+" option:selected").val() != '0'){
        $("#"+input_id).val($("#"+select_id+" option:selected").attr("title"));
      //  $("#"+input_id).attr("class", "input_txt_f");
    }else{
        $("#"+input_id).val($("#"+input_id).attr("title"));
       // $("#"+input_id).attr("class", "input_txt");
    }
}

 

$.fn.center = function(){
    var h = this.height();
    var w = this.width();
    
    h = (h - $(window).height())/2;
    w = (w - $(window).width())/2;
    
    if(h<0){ h = h*-1; }
    if(w<0){ w = w*-1; }
    
    this.css("top", h);
    this.css("left", w);
    
    this.css("display", "block");
}


function set_cid(id){
    id = id.split('_');
    
    fcid = id[0];
    scid = id[1];
}

 $.fn.gselect = function(){
    var index = 1; 
    this.keypress(function(e){
        if(e.keyCode == 38){
            $("#item_list tr").eq(index).css("background-color", "transparent");
            index--;
            $("#item_list tr").eq(index).css("background-color", "#e0e492");
        }else if(e.keyCode == 40){
            $("#item_list tr").eq(index).css("background-color", "transparent");
            index++;
            $("#item_list tr").eq(index).css("background-color", "#e0e492");
        }else if(e.keyCode == 13){
            $("#item_list tr").eq(index).click();
        }else{
            index = 1;
        }
    });
}

function get_column_total(cn,id){
    var total=0;
    $(cn).each(function(e){    
        if($(id+e).val()!="")
        {
            total=total+parseFloat($(id+e).val());
        }
    });
    return total;
}

function set_msg(msg,type){
    if(type=='undefined'){type='error';}
    if(type=="error"){
        $("#display_msg").css("background-color","red")
        }else if(type=="notify"){
        $("#display_msg").css("background-color","green")
    }
    $("#display_inner_msg").html(msg.toUpperCase());
    $("#display_msg").fadeIn(500);
    setTimeout("close_display_msg()",1000);
}

function close_display_msg(){
    $("#display_msg").fadeOut(4000);
}
