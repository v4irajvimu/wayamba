$(document).ready(function(){
});

$(document).on("click",".cl", function(){
	

	if($(this).is(":checked")){
		load_stores();
		load_branches($(this));
		
	}
});
$(document).on("click",".bc", function(){
	load_stores();
});



// *********** Functions ******************
function load_branches(obj){
	// var cluster = $("#tb_branches input:checkbox:checked").map(function(){
 //        return $(this).val();
 //    }).toArray();

 	var cluster = obj.val();
    $.post("index.php/main/load_data/r_general_report/get_branch_name", 
    {
	    cluster:cluster
	}, 
	function(r){
	   	$(".div_branch").html(r);
	}, "text");

}

function load_stores(){
	var cluster =  $(".cl:checked").val();
	var branch = $(".bc:checked").val();
	$.post("index.php/main/load_data/r_general_report/get_stores", 
    {
	    cluster:cluster,
	    branch:branch
	}, 
	function(r){
	   	$(".div_stores").html(r);
	}, "text");
}