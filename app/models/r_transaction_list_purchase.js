$(document).ready(function(){
	   $("#btnPrint").click(function(){

	   	
	   	 if($("input[type='radio']:checked").length == 0){
	   	 	alert("Please select report");
	   	 	return false;
	   	 }
	   	 else
	   	 {	   	 
            $("#print_pdf").submit();
         }
        });
});