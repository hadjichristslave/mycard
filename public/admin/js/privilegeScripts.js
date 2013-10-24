$(document).ready(function(){


$(".privilege_selection").bind('click', function(){
		id  =  $('.privilege_select').val();
		url   =  "/administrator/delete/Privilege/"+id;
		data     = { _token: token  , id:id}
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this page": function() {
				keyValData = {'id':'id','name':'name'};
				augmentedAjaxModifyCall(url , data, $("select"), 'select', 'delete' , keyValData);
	          $( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});

	
$(".priv_mod").on('click', function(){
		text  = $(".privilage_new_name").val();
		if(text==''){
			alert('Something must be written to the field in order to rename!!');
			return;
		}
			
		id  =  $('.privilege_select').val();
		url =  "/administrator/singlerowedit/Privilege";
	  	data = { id: id, _token: token , key: 'id' , db_row:'name' , value:text };
		
	    ajaxModifyCall(url , data);
	});



	
$(".priv_create").on('click', function(){
		
		url      = "/administrator/create/Privilege";
		data     = { _token: token , name: $(".privilage_new_name").val()}
		
		keyValData = {'id':'id','name':'name'}; 
		augmentedAjaxModifyCall(url , data, $('select'), 'select', 'create' , keyValData);
	});

$("body").on('click', '.mod_edit',function(event){		
		url       = '/administrator/edit/Privilegemodel';
		mod_id    = $(this).attr('mod_id');
		mod_txt = $("tr[model_id='"+mod_id+"']").find('.cms_name').text();
		
		$(".hidden_id").val(mod_id);		
		$("select.mws-select2").select2("val", mod_id);
		$(".editable_name").val(mod_txt);
		//------------------------------------------------------------------------
		
	        $("#mws-form-dialog").dialog("option", {
	            title: 'Edit Category',
	            modal: true,
	            buttons: [{
                    text: "Edit",
                    click: function () {
						$('.cs_pages_ids').val($("select.mws-select2").val().toString());
 						formdata = $("form.privilege_editor_form").serializeArray();
                    	ajaxModifyCall(url , formdata);
                    }
                }]
	        }).dialog("open");
	        event.preventDefault();
	    });
	
	$("body").on('click', '.mod_del',function(){		
		mod_id    = $(this).attr('mod_id');
		url   =  "/administrator/delete/Privilegemodel/"+mod_id;
		data     = { _token: token }
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this model": function() {
	          	ajaxModifyCall(url , data);
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});


	
$(".mod_edit").bind("click", function (event) {
 		url       = '/administrator/edit/Privilegemodel';
 		mod_id    = $(this).attr('mod_id');
 		mod_txt = $("tr[model_id='"+mod_id+"']").find('.cms_name').text();
 		$(".hidden_id").val(mod_id);				
		$("select.mws-select2").select2("val", $(this).attr('privil_id'));
		$(".editable_name").val(mod_txt);
		//------------------------------------------------------------------------
		
	        $("#mws-form-dialog").dialog("option", {
	            title: 'Edit Category',
	            modal: true,
	            buttons: [{
                    text: "Edit",
                    click: function () {
						$('.cs_pages_ids').val($("select.mws-select2").val().toString());
 						formdata = $("form.privilege_editor_form").serializeArray();
                   	ajaxModifyCall(url , formdata);
                     }
                 }]
 	        }).dialog("open");
 	        event.preventDefault();
 	    });
		
	$(".mod_create").bind("click", function (event) {
			url      = "/administrator/create/Privilegemodel";
			$("#mws-form-dialog").dialog("option", {
				title: 'Create Association',
				modal: true,
				buttons: [{
					text: "Create the Association",
					click: function () {
						formdata = $("form.privilege_editor_form").serializeArray();
						ajaxModifyCall(url , formdata);
					}
				}]
			}).dialog("open");
			event.preventDefault();
			});
	});