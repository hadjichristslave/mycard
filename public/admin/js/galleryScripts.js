function setClickBehaviour(){
$('.gallcatmodify').click(function(){
		url      = "/administrator/singlerowedit/Gallerycategory";
		id       =  $('select.mws-select-tags').select2("val");
		modified = 	$('#tagValue').val();
		data     =  { id: id , _token: token , key: 'id' , db_row:'name' , value: modified};
		//ajaxModifyCall(url , data);
		keyValData = {'id':'id','name':'name'};
		augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'edit' , keyValData);
	});
	$('.gallcatcreate').click(function(){
		url      = "/administrator/create/Gallerycategory";
		data     = { _token: token , name: $("#tagValue").val()}
		//ajaxModifyCall(url , data);
		keyValData = {'id':'id','name':'name'};
		augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'create' , keyValData);
	});
	$('.gallcatdelete').click(function(){
		value = $('select.mws-select-tags').select2("val");
		url   =  "/administrator/delete/Gallerycategory/"+value;
		data     = { _token: token , id:value };
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this page": function() {
				augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'delete' , null);
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});
}
setClickBehaviour();

//---------Reset pretty photo upon ajax completion------------------------------//

function setGalChngDepend(){
	$('.galleryPage').change(function(){
		getData('Gallery' , $(this).val() );
		$(".cms_hiden_id").val($(this).val());
	});
}
setGalChngDepend()

function reloadPrettyPhoto() {
	console.log('done');
	$(".pp_pic_holder").remove();
	$(".pp_overlay").remove();
	$(".ppt").remove();
	// edit it with your initialization
	$("a[rel^='prettyPhoto']").prettyPhoto();
	//
}

function getData(model , id){
	id = (typeof id === "undefined") ? "defaultValue" : '/'+id;
	url = "/administrator/galleryreturn/"+model + "" +id;	
	
	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: {  _token: token }
		}).done(function( results ) {
			$(".gallerybodyclass").html(results);
			$("a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'dark_rounded',slideshow:4000, autoplay_slideshow: false});
	  		setTrashClickDependencies();
		});
		
}

$(document).ready(function(){
	$("span.fileinput-btn").css('display', 'none');
});


function setTrashClickDependencies(){
	$('.del_gal_obj').bind('click', function(){
		id    = $(this).attr('picture_id');
		url   =  "/administrator/delete/Galleryobj/"+id;
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this picture": function() {
				data     = { _token: token }
				picture  = $("i[picture_id='"+id+"']").parent().parent().parent().remove();
				augmentedAjaxModifyCall(url, data , null, null ,  'deleteobject' , null);
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });



	});
}