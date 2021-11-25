/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editUserForm = $("#editUser");
	
	var validator = editUserForm.validate({
		
		rules:{
			fname :{ required : true },
			cpassword : {equalTo: "#password"},
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required" },
			cpassword : {equalTo: "Please enter same password" },
			role : { required : "This field is required", selected : "Please select at least one option" }			
		}
	});
});