$(function() {
	$(document).ready(function(){
	setPassToggleBehaviour();
		$(".pwd_changer").click(function(){
			$("#new_password_form").dialog("option", {
	            title: 'Change Password',
	            modal: true,
	            buttons: [{
                    text: "Edit",
                    click: function () {
						url = '/administrator/modifyuserpwd/User';
 						formdata = $("form#new_password_form").serializeArray();
                    	userPassModifyCall(url , formdata);
						$( this ).dialog( "close" );
                    }
                }]
	        }).dialog("open");
	        event.preventDefault();
		});
	});
});
function setPassToggleBehaviour(){
	$(".password_toggle").click(function(){
		pass = document.getElementById('modal_passwordzz').type;
		console.log(pass);
		if(pass=='password') return document.getElementById("modal_passwordzz").type="text";
		else 				 return document.getElementById("modal_passwordzz").type="password";
		
	});
}