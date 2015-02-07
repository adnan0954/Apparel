$(document).ready(function(){

	function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}
// Check For Username availability
$("#username").blur(function(){
	  $("#apparel_Reg_btn").attr('disabled','disabled');
		  if(($.trim($("#username").val())).length != 0){
			$("#username").removeClass("error success checking_input_field").addClass("checking_input_field");
				   $.ajax({
				type:'POST',
				data:{username:$("#username").val(),ck_username:'check_username'},
				url:'signup',
				success:function(result){
				  if(result == '1'){
				  console.log("yeah");
					$("#username_exist").text("");
					 $("#username").removeClass("error success checking_input_field").addClass("success");
					 $("#apparel_Reg_btn").removeAttr('disabled'); 
				  }else if(result == '0'){
				   console.log("nn");
					 $("#username_exist").text("Username already exist");
					$("#apparel_Reg_btn").attr('disabled','disabled');
					$("#username").removeClass("error success checking_input_field").addClass("error"); 
					
				  }
				  
				}
			  });
			}else{
			$("#username").removeClass("error success checking_input_field");
			 $("#username_exist").text("");
			}
	});

$("#email").blur(function(){
  $("#apparel_Reg_btn").attr('disabled','disabled');
	  if(($.trim($("#email").val())).length != 0){
	    $("#email").removeClass("error success checking_input_field").addClass("checking_input_field");
	    if(!isValidEmailAddress($("#email").val()))
	    {
	      $("#email").removeClass("error success checking_input_field");
	      $("#email_exist").text("Please provide a valid email");
	      $("#apparel_Reg_btn").attr('disabled','disabled');
	    }else{
    	       $.ajax({
    	    type:'POST',
    	    data:{email:$("#email").val(),ck_email:'check_email'},
    	    url:'signup',
    	    success:function(result){
    	      if(result == '1'){
				 $("#email_exist").text("");
    	         $("#email").removeClass("error success checking_input_field").addClass("success");
    	         $("#apparel_Reg_btn").removeAttr('disabled');
    	      }else if(result == '0'){
				 $("#email_exist").text("Email already exist");
    	        $("#apparel_Reg_btn").attr('disabled','disabled');
    	        $("#email").removeClass("error success checking_input_field").addClass("error");
    	      }
    	      
    	    }
    	  });
	    }
	    
	 }else{
	   $("#email").removeClass("error success checking_input_field").addClass("error");
	   $("#email_exist").text("");
	   $("#apparel_Reg_btn").attr('disabled','disabled');
	 }

});






















});