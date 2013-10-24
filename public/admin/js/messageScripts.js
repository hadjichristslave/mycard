function setMessageBehaviour(){
	$('.message_delete').bind('click',function(){
      	value = $(this).attr('msg_id');
      	url   =  "/administrator/delete/Message/"+value;
      	data     = { _token: token , id:value }
	    $( "#dialog-confirm" ).dialog({
	      	resizable: false,
	      	height:250,
	      	width:400,
	      	buttons: {
	      	modal: true,
	        "Delete this message!": function() {
	          	//ajaxModifyCall(url , data);
				
				keyValData = {'id':'id','name':'name','has_gallery':'no','cs_pages':'cs_pages','has_tags':'no','updatecatbuttons':'buttons'};
                augmentedAjaxModifyCall(url , data , message_table, 'dataTable', 'delete' , null);
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	  });

	$(".message_view").bind("click", function (event) {
			msg_id = $(this).attr('msg_id')
			$.ajax({
				type: "POST",
				url: "/administrator/singlerowedit/Message",
				data: { id: msg_id, _token: token , key: 'id' , db_row:'is_read' , value: 1}
				}).done(function( results ) {
					console.log('succesful privilage edit');
			});		
			
			
			$('.modal_msg_text').val($("tr[msg_id='"+msg_id+"']").find(".msg_text").text()).blur().hide().show();
			$('.modal_msg_name').val($("tr[msg_id='"+msg_id+"']").find(".msg_name").text());
			$('.modal_msg_email').val($("tr[msg_id='"+msg_id+"']").find(".msg_email").text());
			$('.modal_msg_created').val($("tr[msg_id='"+msg_id+"']").find(".msg_created").text());
			$("tr[msg_id='"+msg_id+"']").find('span').removeClass('badge-warning').addClass('badge-success');
			$("tr[msg_id="+msg_id+"]").find('span').first().text('Yes :)')
	        $("#mws-form-dialog").dialog("option", {
	            title: 'View Message',
	            modal: true
	        }).dialog("open");
	        event.preventDefault();
	    });



}
setMessageBehaviour();