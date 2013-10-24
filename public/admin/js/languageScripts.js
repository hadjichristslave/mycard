
$(document).ready(function(){
	$(".languagecreate").click(function(){
		url   =  "/administrator/create/Languages";
		
		name = $(".user_group_name").val();
		data     = { _token: token  , name:name };
		keyValData = {'id':'id','name':'name'};
		bufferData = {'name':name};
		
		augmentedAjaxModifyCall(url , data, privi_table, 'select2', 'create' , keyValData , bufferData);
		//ajaxModifyCall(url , data);
	});
	$(".languagemodify").click(function(){
		name = $(".user_group_name").val();
		group_id = $(".privilege_selector").val();
		url   =  "/administrator/edit/Languages";
		data     = { _token: token  , name:name , id: group_id};
		
		keyValData = {'id':'id','name':'name'};
		bufferData = {'name':name , 'id':group_id};
		augmentedAjaxModifyCall(url , data, privi_table, 'select2', 'edit' , keyValData , bufferData);
	});
	$(".languagedelete").click(function(){
		group_id = $(".privilege_selector").val();
		url   =  "/administrator/delete/Languages/"+group_id;
      	data     = { _token: token , id:group_id }
		$( "#dialog-confirm" ).dialog({
	      	resizable: false,
	      	height:250,
	      	width:400,
	      	buttons: {
	      	modal: true,
	        "Delete this user!": function() {
				keyValData = {'id':'id','name':'name'};
				bufferData = {'name':$(".user_group_name").val() , 'id':group_id};				
				augmentedAjaxModifyCall(url , data, privi_table, 'select2', 'delete' , keyValData , bufferData);
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});
});