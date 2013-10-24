function setUserBehaviour(){
		$('.user_delete').bind('click',function(){
      	value = $(this).attr('user_id');
      	url   =  "/administrator/delete/User/"+value;
      	data     = { _token: token  , id:value }
	    $( "#dialog-confirm" ).dialog({
	      	resizable: false,
	      	height:250,
	      	width:400,
	      	buttons: {
	      	modal: true,
	        "Delete this user!": function() {
	          	augmentedAjaxModifyCall(url, data , user_Table , 'dataTable', 'delete' , null);
				
				
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	  });

	$(".user_edit").bind("click", function (event) {
		$(".usernamerow").hide();	
		$(".modal_user_id").val($(this).attr('user_id'));
		$(".modal_group_id").select2("val", $(this).attr('group_id'));
		$(".modal_username").val($(this).parent().parent().parent().parent().find("td:nth-child(2)").text());
		ban = $(this).attr('banned');
		$(".ibutton").iButton("toggle", ban==0);
			$("#mws-form-dialog").dialog("option", {
	            title: 'Edit User',
	            modal: true,
				buttons: [{
                    text: "Edit",
                    click: function () {
						url   =  "/administrator/edit/User";
 						formdata = $("form#user_edit_form").serializeArray();
						console.log(formdata);
						keyValData = {'id':'id','username':'username','password':'password','group_id':'group_id','is_banned':'is_banned','updated_at':'now' , 'updateuserbuttons':'buttons'};
                    	augmentedAjaxModifyCall(url , formdata , user_Table , 'dataTable', 'edit' ,keyValData);
						//-------------------------------------------------//
						$( this ).dialog( "close" );
                    }
                }]
	        }).dialog("open");
	        event.preventDefault();
	    });

	$(".user_create").bind("click", function (event) {
		formdata = $("form#user_edit_form").serializeArray();
		console.log(formdata);
		$(".usernamerow").show();
		$("#mws-form-dialog").dialog("option", {
	            title: 'Create User',
	            modal: true,
				buttons: [{
                    text: "Create",
                    click: function () {	
						url   =  "/administrator/create/User";
 						formdata = $("form#user_edit_form").serializeArray();						
						keyValData = {'id':'id','username':'username','password':'password','group_id':'group_id','is_banned':'is_banned','updated_at':'now' , 'updateuserbuttons':'buttons'};
                    	augmentedAjaxModifyCall(url , formdata , user_Table , 'dataTable', 'create' ,keyValData);
						$( this ).dialog( "close" );
                    }
                }]
	        }).dialog("open");
	        event.preventDefault();
	    });



}
setUserBehaviour();


$(document).ready(function(){
	$(".modal_refresh").click(function(){
		pass = document.getElementById('modal_password').type;
		console.log('password');
		if(pass=='password')
			return document.getElementById("modal_password").type="text";
		else
			return document.getElementById("modal_password").type="password";
	});
});


//--------User group functions----------------------------------//

function createGroupSliders(sliderClass ,value){
	$("."+sliderClass+"_privilege_lvl").slider({
                range: "min", 
                min: 0,
                max: 100,
                value: value, 
                ticks: [0, 'viewer', 20, '|', 40, 'moderator', 60, '|', 80, 'administrator', 100],
                change: function( event, ui ) { SetGroupCorrectsliderValues($(".privilege_selector").val(), $(this).attr('class').split(' ')[0], ui.value); console.log($(".privilege_selector").val());}
            });
}

function GetGroupCorrectsliderValues(cms_cat){
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/return/Usergroup/"+cms_cat+"/id",
	  	data: { cms_cat: cms_cat, _token: token }
		}).done(function( results ) {
	  		createGroupSliders('r' , results.r_privilege_lvl);
			createGroupSliders('w' , results.w_privilege_lvl);
			createGroupSliders('x' , results.x_privilege_lvl);
		});
}

function SetGroupCorrectsliderValues(cms_cat , db_row , value ){
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/singlerowedit/Usergroup",
	  	data: { id: cms_cat, _token: token , key: 'id' , db_row:db_row , value: value}
		}).done(function( results ) {
	  		console.log('succesful privilage edit');
		});
}

$(document).ready(function(){
	$('.privilege_selector').change(function(){
		GetGroupCorrectsliderValues($(this).val());
	});
	
	
	$(".usergroupcreate").click(function(){
		url   =  "/administrator/create/Usergroup";
		
		name = $(".user_group_name").val();
		data     = { _token: token  , name:name };
		keyValData = {'id':'id','name':'name'};
		bufferData = {'name':name};
		
		augmentedAjaxModifyCall(url , data, privi_table, 'select2', 'create' , keyValData , bufferData);
		//ajaxModifyCall(url , data);
	});
	$(".usergroupmodify").click(function(){
		name = $(".user_group_name").val();
		group_id = $(".privilege_selector").val();
		url   =  "/administrator/edit/Usergroup";
		data     = { _token: token  , name:name , id: group_id};
		
		keyValData = {'id':'id','name':'name'};
		bufferData = {'name':name , 'id':group_id};
		augmentedAjaxModifyCall(url , data, privi_table, 'select2', 'edit' , keyValData , bufferData);
		
		
		//ajaxModifyCall(url , data);

		
	});
	$(".usergroupdelete").click(function(){
		group_id = $(".privilege_selector").val();
		url   =  "/administrator/delete/Usergroup/"+group_id;
      	data     = { _token: token , id:group_id }
		$( "#dialog-confirm" ).dialog({
	      	resizable: false,
	      	height:250,
	      	width:400,
	      	buttons: {
	      	modal: true,
	        "Delete this user!": function() {
				keyValData = {'id':'id','name':'name'};
				bufferData = {'name':$("#tagValue").val() , 'id':group_id};				
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


$(function() {
 
    $( ".mws-search-input" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "/administrator/search/Cms",
		  method:'GET',
          dataType: "jsonp",
          data: {
            featureClass: "P",
            style: "full",
            maxRows: 12,
            name_startsWith: request.term
          },
          success: function( data ) {
			console.log(data);
            response( $.map( data.results, function( item ) {
              return {
                label: item.data.name,
				desc : item.data_cat,
                value: item.data.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.data.id :
          "Nothing selected, input was " + this.value);
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    }) .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		console.log(item);
      return $( "<li>" )
        .append( "<a>" + item.label+ "<br><i>Category:" + item.desc + "</i></a>" )
        .appendTo( ul );
    };
	;
  });