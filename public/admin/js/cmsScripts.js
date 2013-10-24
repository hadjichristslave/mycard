/*
GLOBAL VARIABLES DECLARATION
*/
var usedkeyValuesArray = [];
var token;
token = $('input[name=_token]').val();

//---------------------------------------------------------------------------------------//
function createSliders(sliderClass ,value){
	$("."+sliderClass+"_privilege_lvl").slider({
                range: "min", 
                min: 0,
                max: 100,
                value: value, 
                ticks: [0, 'viewer', 20, '|', 40, 'moderator', 60, '|', 80, 'administrator', 100],
                change: function( event, ui ) { SetCorrectsliderValues($("#cms_cat_names").val(), $(this).attr('class').split(' ')[0], ui.value)}
            });
}

function GetCorrectsliderValues(cms_cat){
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/return/Privilege/"+cms_cat+"/id",
	  	data: { cms_cat: cms_cat, _token: token }
		}).done(function( results ) {
	  		createSliders('r' , results.r_privilege_lvl);
			createSliders('w' , results.w_privilege_lvl);
			createSliders('x' , results.x_privilege_lvl);
		});
}

function SetCorrectsliderValues(cms_cat , db_row , value ){
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/singlerowedit/Privilege",
	  	data: { id: cms_cat, _token: token , key: 'id' , db_row:db_row , value: value}
		}).done(function( results ) {
	  		console.log('succesful privilage edit');
		});
}

$(document).ready(function(){
	$('#cms_cat_names').change(function(){
		GetCorrectsliderValues($(this).val());
	});
});

function ajaxModifyCall(url , data){
	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: data
		}).done(function( results ) {
			location.reload();
	});
}
function augmentedAjaxModifyCall(url, data , dataSelector , dataType ,  action , keyValData , bufferData){
	bufferData = typeof bufferData=='undefined' ? null: bufferData;
	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: data
		}).done(function( results ) {
			if(results != null && typeof results === 'object'){
				$(".error_message").empty();
				$.each(results, function(key,val){
					$(".error_message").append('<p>' +val+'</p>');
				});
				$(".hidden_pannel").show(500).delay(2000).hide(500);
			}else if(results.split('__________').length>1){
				if(action=="create"){
					id = results.split('__________')[0];
					keyValData['id'] =id;
					$(".error_message").empty().append(results.split('__________')[1]);
					$(".hidden_pannel").show(500).delay(2000).hide(500);				
					if(dataType=='dataTable'){
						insertDataTable(data, dataSelector , keyValData,  id , 'insert');
					}else if(dataType=='select2'){
						id = results.split('__________')[0];
						if(bufferData==null)
							select2Operations(data, 'ajax-select2' , keyValData,  id , 'insert');
						else
							select2Operations(data, 'ajax-select2' , keyValData,  id , 'insert' , bufferData);
					}else if(dataType=='select'){
						id = results.split('__________')[0];
						name = data.name;
						dataSelector.append('<option value="'+id+'">'+name+'</option>');
					}
				}
				
			}else{
				if(action=="delete"){
					id = getdataFromArray(data , 'id' , 'value');
					if(dataType=="dataTable"){
						console.log(id);
						//------Pseudo operations-simulating the delete----//
						var rowee = $("i[row_id='"+id+"']").closest("tr").get(0);
						dataSelector.fnDeleteRow(dataSelector.fnGetPosition(rowee));
						
						//$("i[row_id='"+id+"']").parent().parent().parent().parent().show(0).delay(500).hide(350);
						//--------------------------------------------------//
					}else if(dataType=='select2'){
						select2Operations(data, 'ajax-select2' , keyValData,  id , 'delete');
					}
					else if(dataType=='select'){
						dataSelector.find('option[value="'+id+'"]').remove();
					}
				}
				else if(action=="edit"){
					id = getdataFromArray(data , 'id' , 'value');
					if(dataType=="dataTable"){
						keyValData['id'] =getIdFromArray(data);
						id = keyValData['id'];
						insertDataTable(data, dataSelector , keyValData,  id, 'edit');
					}else if(dataType=="select2"){
						if(bufferData==null)
							select2Operations(data, 'ajax-select2' , keyValData,  id , 'edit');
						else
							select2Operations(data, 'ajax-select2' , keyValData,  id , 'edit' , bufferData);
					}
				}
				$(".error_message").empty().append(results);
				$(".hidden_pannel").show(500).delay(2000).hide(500);
			
			}
	});
}
function getIdFromArray(data){
	console.log(data);
	for(i=0;i<data.length;i++){
		if(data[i].name=='id')
			return data[i].value;
		}
	return -1;
}
function getdataFromArray(data , key , key2){
	console.log(data);
	key2 = typeof key2=='undefined' ? null: key2;

	if(key2==null){
		for(var index in data){
			if(index == key)
				return data[index];
		}
	}
	else{
		for(var index in data){
			if(index == key || index == key2)
				return data[index];
		}
	}
	return -1;
}

var select2Data =[];
function select2Operations(data, dataSelector , keyValData,  id , action , bufferData){
	
	console.log(data);
	console.log(bufferData);
	console.log(id);
	bufferData = typeof bufferData=='undefined' ? null: bufferData;
	if(bufferData==null){
		console.log('data');
		var name = getdataFromArray(data , 'name');
		var dataid = getdataFromArray(data , 'id');
	}else{
		console.log('buffzdata');
		var name = getdataFromArray(bufferData , 'name');
		var dataid = getdataFromArray(bufferData , 'id');
	}
	console.log('name -->' +name);
	console.log('id -->' +dataid);
	if(action=='insert'){
		$("."+dataSelector).append('<option value="'+id+'">'+name+'</option>');
	}else if(action=='edit'){
		if(bufferData==null) name = getdataFromArray(data , 'value');
		
		$("."+dataSelector).find('option[value="'+dataid+'"]').text(name);
	}else if(action=='delete'){
		$("."+dataSelector).find('option[value="'+dataid+'"]').remove();
	}
}


var insertdata;
function insertDataTable(data, dataSelector , keyValData , id , action){
	usedkeyValuesArray =[];	
	var now = new Date();
	var date = now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

	
	row   = {id:id};
	usedkeyValuesArray.push('id');
	insertdata = new Tablerow(keyValData);
	
	if (keyValData['updateuserbuttons'] !==undefined){ 
		insertdata.modifyData({'updateuserbuttons': '<span class="btn-group"><a href="#" class="btn btn-small"><i class="icon-pencil user_edit"  group_id="'+insertdata.getDatafromOject('group_id', data , 'group_id' , 'value')+'"banned="'+ (insertdata.getDatafromOject('is_banned', data , 'is_banned' , 'value')=='on'?0:1) +'"user_id="'+id+'" row_id="'+id+'" ></i></a><a href="#" class="btn btn-small"><i class="icon-trash user_delete" user_id="'+id+'" row_id="'+id+'" ></i></a></span>'});
		usedkeyValuesArray.push('updateuserbuttons');
	}if (keyValData['password'] !==undefined){ 
		insertdata.modifyData({'password': '**********'});
		usedkeyValuesArray.push('password');
	}if (keyValData['updated_at'] !==undefined){ 
		insertdata.modifyData({'updated_at': date});
		usedkeyValuesArray.push('updated_at');
	}if(keyValData['updatecatbuttons']!==undefined){
		insertdata.modifyData({'updatecatbuttons': '<span class="btn-group"><a href="#" class="btn btn-small"><i class="icon-pencil edit" category_id="'+id+'" row_id="'+id+'" ></i></a><a href="#" class="btn btn-small"><i class="icon-trash delete" category_id="'+id+'" row_id="'+id+'" ></i></a></span>'});
		usedkeyValuesArray.push('updatecatbuttons');
	}
	row   = [id];
	$.each(data, function(key,val){
		if( keyValData[val.name] !== undefined  && usedkeyValuesArray.indexOf(val.name)==-1){
			insertdata.set(val.name, val.value);
		}
	});
	row =[];
	for(var indexer in keyValData){
		row.push(insertdata[indexer]);
	}
	if(action == 'insert'){
		dataSelector.fnAddData(row);
	}else if(action='edit'){
		var rowTD = $("i[row_id='"+id+"']").parent().parent().parent().parent().index();		
		var rowee = $("i[row_id='"+id+"']").closest("tr").get(0);		
		dataSelector.fnUpdate(row, dataSelector.fnGetPosition(rowee));
	}
	window.setTimeout(updateButtonDependencies() , 4500);		
}

function updateButtonDependencies(){
	setUserBehaviour();
}

function editDataTable(data, dataSelector , keyValData){
	usedkeyValuesArray =[];
	var now = new Date();
	var date = now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

}


function userPassModifyCall(url , data){
	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: data
		}).done(function( results ) {
				$(".error_message").empty().append(results);
				$(".hidden_pannel").show(500).delay(2000).hide(500);
			
	});
}
function calendarModifyCall(url , data){
	$.ajax({
	  	type: "POST",
	  	url: url,
		async: false,
	  	data: data
		}).done(function( results ) {
			$(".modal_msg_id").val(results);
			console.log($(".modal_msg_id").val());
	});
}
//----------------------------------------------------------------------------------------//

$(document).ready(function(){
	$('select.mws-select-tags').on('change' , function(){
		$('#tagValue').val($('select.mws-select-tags').select2("data").text)
	});

/////////////////////////////Tags functions///////////////////////////////////////////////////////////////
	$(".tagmodify").click(function(){
		url      = "/administrator/singlerowedit/Cmstags";
		id       =  $('select.mws-select-tags').select2("val");
		modified = 	$('#tagValue').val();
		data     =  { id: id , _token: token , key: 'id' , db_row:'name' , value: modified};
		keyValData = {'id':'id','name':'name'};
		augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'edit' , keyValData);
	});
	$(".tagcreate").click(function(){
		url      = "/administrator/create/Cmstags";
		data     = { _token: token , name: $("#tagValue").val()};		
		keyValData = {'id':'id','name':'name'};
		augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'create' , keyValData);
	});
	$('.tagdelete').click(function(){
      	value = $('select.mws-select-tags').select2("val");
      	url   =  "/administrator/delete/Cmstags/"+value;
      	data     = { _token: token , id: value  }
	    $( "#dialog-confirm" ).dialog({
	      	resizable: false,
	      	height:250,
	      	width:400,
	      	buttons: {
	      	modal: true,
	        "Delete this tag": function() {
				augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'delete' , null);
	          $( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	  });
/////////////////////////////////Pages functions///////////////////////////////////////////////////////////
	$('.pagemodify').click(function(){
		url      = "/administrator/edit/Cmspages";
		id       =  $('select.pagesSelect').select2("val");
		formdata = $("form.page_operation_form").serializeArray();
		
		keyValData = {'id':'id','name':'name'};
		bufferData = {'name':$("#tagValue").val() , 'id':id};
		augmentedAjaxModifyCall(url , formdata, tagselector, 'select2', 'edit' , keyValData , bufferData);
	});
	$('.pagecreate').click(function(){
		url      = "/administrator/create/Cmspages";
		formdata = $("form.page_operation_form").serializeArray();	
		keyValData = {'id':'id','name':'name'};
		bufferData = {'name':$("#tagValue").val()};
		augmentedAjaxModifyCall(url , formdata, tagselector, 'select2', 'create' , keyValData , bufferData);
	});
	$('.pagedelete').click(function(){
		value = $('select.pagesSelect').select2("val");
		url   =  "/administrator/delete/Cmspages/"+value;
		data     = { _token: token, id:value }
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this page": function() {
				keyValData = {'id':'id','name':'name'};
				bufferData = {'name':$("#tagValue").val() , 'id':value};
				augmentedAjaxModifyCall(url , data, tagselector, 'select2', 'delete' , keyValData , bufferData);
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});
});
/*
+
+Pages sortable cs_categories functions
+
+
*/
var  sortstring;
  $(function() {
    $( "#sortable1, #sortable2" ).sortable({
		update:function(event, ui){
			sortstring  ="";
			$("#sortable2").find('li').each(function(){
				sortstring += $(this).attr('value') +',';
				id          = $(".pagesSelect").select2('val');
			});
			sortstring = sortstring.substr(0 , sortstring.length-1);
			$.ajax({
				type: "POST",
				url: "/administrator/singlerowedit/Cmspages",
				data: { id: id, _token: token , key: 'id' , db_row:'cs_categories' , value: sortstring}						
			}).done(function( results ) {
				console.log('succesful sorting edit');
			});
		},
      connectWith: ".connectedSortable"
    }).disableSelection();
  });
  
$(document).ready(function(){
  $(".pagesSelect").change(function(){
	   page_id =  $('select.pagesSelect').select2("val");
	   url     = '/administrator/returncscategories/Cmspages/'+page_id;
	   data    = { _token :token , id:page_id};
	   $.ajax({
	  	type: "POST",
	  	url: url,
		async: false,
	  	data: data
		}).done(function( results ) {
			console.log(results);
			$("#sortable1").empty().append('<p class="categorieswatermark">Categories not included</p>');;
			$("#sortable2").empty().append('<p class="categorieswatermark">Categories included</p>');;
			for(i=0; i<results.exist.length; i++){
				$("#sortable2").append('<li class="ui-state-default" value="'+results.exist[i].id+'">'+results.exist[i].name+'</li>');
			}
			for(i=0; i<results.dontexist.length; i++){
				$("#sortable1").append('<li class="ui-state-default" value="'+results.dontexist[i].id+'">'+results.dontexist[i].name+'</li>');
			}
			$( "#sortable1, #sortable2" ).sortable('refreshPositions');
			$(".begins_with").val(results.begins);
			$(".ends_with").val(results.ends);
			$(".page_method").val(results.method);
		});
  
  
  });
  
  
  
});
/////////////////////////////////Categories functions///////////////////////////////////////////////////////////
$(function(){
 	$("#category_create").bind("click", function (event) {
		$(".cms_cat_id").val(""); 
 		url      = '/administrator/create/Cmscategory';
        $("#mws-form-dialog").dialog("option", {
            title: 'Create Category',
            modal: true,
            buttons: [{
                    text: "Create",
                    click: function () {
 						formdata = $("form#cms_cat_form").serializeArray();
 						console.log(formdata);
						keyValData = {'id':'id','name':'name','has_gallery':'no','cs_pages':'cs_pages','has_tags':'no','begins_with':'begins_with','ends_with':'ends_with','updatecatbuttons':'buttons'};
                    	augmentedAjaxModifyCall(url , formdata , mws_datatable, 'dataTable', 'create' , keyValData);
						$( this ).dialog( "close" );
                    }
                }]
        }).dialog("open");
        event.preventDefault();
    });
	$("body").on("click" , '.edit', function (event) {
		url      = '/administrator/edit/Cmscategory';
		cat_id  =  $(this).attr('category_id');
		
		
		//------------------------------------------------------------------------
		cms_cat_id = $(this).parent().parent().parent().parent().find("td:nth-child(1)").text();
		$(".cms_cat_id").val(cms_cat_id);
		//------------------------------------------------------------------------
		name = $(this).parent().parent().parent().parent().find("td:nth-child(2)").text();
		$(".cms_cat_form_name").val(name);
		//------------------------------------------------------------------------
		//------------------------------------------------------------------------
		badge = $(this).parent().parent().parent().parent().find("td:nth-child(3)").text();		
		$(".ibutton").iButton("toggle", badge=='yes' || badge=='on');
		//------------------------------------------------------------------------
		badge = $(this).parent().parent().parent().parent().find("td:nth-child(5)").text();		
		$(".ibuttonz").iButton("toggle", badge=='yes'|| badge=='on');
		//------------------------------------------------------------------------
		begins = $(this).parent().parent().parent().parent().find("td:nth-child(6)").text();		
		$(".begins_with").val(begins.html());
		//------------------------------------------------------------------------
		ends  = $(this).parent().parent().parent().parent().find("td:nth-child(7)").text();		
		$(".ends_with").val(escape(ends.html()));
		
	        $("#mws-form-dialog").dialog("option", {
	            title: 'Edit Category',
	            modal: true,
	            buttons: [{
                    text: "Edit",
                    click: function () {
 						formdata = $("form#cms_cat_form").serializeArray();
 						console.log(formdata);
						keyValData = {'id':'id','name':'name','has_gallery':'no','cs_pages':'cs_pages','has_tags':'no','begins_with':'begins_with','ends_with':'ends_with','updatecatbuttons':'buttons'};
                    	augmentedAjaxModifyCall(url , formdata , mws_datatable, 'dataTable', 'edit' , keyValData);
						$(this).dialog( "close" );
                    }
                }]
	        }).dialog("open");
	        event.preventDefault();
	    });
	$("body").on('click', '.delete',function(){
		cat_id  =  $(this).attr('category_id');
		url   =  "/administrator/delete/Cmscategory/"+cat_id;
		data     = { _token: token , id:cat_id }
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this page": function() {
				keyValData = {'id':'id','name':'name','has_gallery':'no','cs_pages':'cs_pages','has_tags':'no','updatecatbuttons':'buttons'};
                augmentedAjaxModifyCall(url , data , mws_datatable, 'dataTable', 'delete' , null);
	          	//ajaxModifyCall(url , data);
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});

});

/////////////////////////////////CMS functions///////////////////////////////////////////////////////////


function hasGallery(cms_id){
	cms_id = $(".categoriesselect").select2("val");
	data     = { _token: token }
	url      = "/administrator/return/Cmscategory/"+cms_id;
	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: data
		}).done(function( results ) {
			if(results.has_gallery=='1') $(".tagsspan").show('250');
			else                         $(".tagsspan").hide('250');
			
			if(results.has_tags=='1')   $(".cms_tags_select").select2("enable");
			else{
				$(".cms_tags_select").select2("val" , '');
				$(".cms_tags_select").select2("disable");				
			}
		});
}

function setCmsDependencies(){
	$(".cms_create").click(function(){
		$('.cs_tag_ids').val($(".cms_tags_select").select2("val").toString());
		formdata = $("form.cms_create_form").serializeArray();
		url      = "/administrator/create/Cms";
		ajaxModifyCall(url , formdata);
	});
	
$(".cms_delete").bind('click', function(){
		id  =  $(this).attr('cms_id');
		url   =  "/administrator/delete/Cms/"+id;
		data     = { _token: token }
		$( "#dialog-confirm" ).dialog({
	    	resizable: false,
	      	height:250,
	      	width:400,
	      	modal: true,
	      	buttons: {
	        "Delete this page": function() {
	          	ajaxModifyCall(url , data);
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});
	
$('.cms_edit_but').bind('click', function(){
	cms_id  = $(this).attr('cms_id');
	//$("tr[cms_id='"+cms_id+"']")
	//-----------------------------Our CMS ID set---------------------------------//
	$(".cms_hidden_id").val(cms_id);
	//----------------------------Our name set------------------------------------//
	$(".editable_name").val($("tr[cms_id='"+cms_id+"']").find(".cms_name").text());
	//----------------------------Our order set------------------------------------//
	$(".editable_order").val($("tr[cms_id='"+cms_id+"']").find(".cms_order").text());
	//----------------------------Our category set------------------------------------//
	$(".categoriesselect").select2('val' , $("tr[cms_id='"+cms_id+"']").find(".cms_cat").attr('category_id'));
	//----------------------------Our language set------------------------------------//
	$(".languageselect").select2('val' , $("tr[cms_id='"+cms_id+"']").find(".lang_class").attr('lang_id'));
	//----------------------------Our title set------------------------------------//
	$('.cms_editable_title').val($("tr[cms_id='"+cms_id+"']").find(".cms_title").text());
	//----------------------------Our content set------------------------------------//
	$('#cleditor').val($("tr[cms_id='"+cms_id+"']").find(".cms_content").text()).blur().hide().show();
	//----------------------------Our tag set------------------------------------//

	 data =  $("tr[cms_id='"+cms_id+"']").find(".cms_tags").attr('tagValue');
	 data = data.split(',');
	 $(".cms_tags_select").select2("val", data);	
	 $("#mws-form-dialog").dialog("option", { 
	            title: 'Edit Cms',
	            modal: true,
				width:'1536',
				height:'768',
	            buttons: [{
                    text: "Edit",
                    click: function () {
						$('.cs_tag_ids').val($(".cms_tags_select").select2("val").toString());
						url      = '/administrator/edit/Cms';
 						formdata = $("form#cms_edit_form").serializeArray();
                    	ajaxModifyCall(url , formdata);
                    }
                }]
	        }).dialog("open");
			
	        event.preventDefault();
	    });
		
		
		
}
setCmsDependencies();