/*
 * MWS Admin v2.1 - Dashboard Demo JS
 * This file is part of MWS Admin, an Admin template build for sale at ThemeForest.
 * All copyright to this file is hold by Mairel Theafila <maimairel@yahoo.com> a.k.a nagaemas on ThemeForest.
 * Last Updated:
 * December 08, 2012
 *
 */
var user_Table;
var mws_datatable;
var tagselector;
var privi_table;
var message_table;
var blacklisted_tbl;
var blacklisted_tbl_ips;
;(function( $, window, document, undefined ) {

	

    $(document).ready(function() {
		//hack to close the navigation
		//to much of a slacker to search the nonexistant api for that
		$("#mws-navigation").find('ul').first().find('ul').each(function(){
			$(this).addClass('closed');
			$(this).css('display' , 'none');
		});

	
	
	
        // Data Tables
        if( $.fn.dataTable ) {
          mws_datatable =  $(".mws-datatable").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null, 
                    null, 
                    null, 
                    null, 
                    null, 
                    { "bSortable": false }
                ]
            });
        }

         if( $.fn.dataTable ) {
            $(".mws-datatable2").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null, 
                    null, 
                    null, 
                    null, 
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.dataTable ) {
            $(".cms_edit_datatable").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null, 
                    null, 
                    null, 
                    null, 
                    null, 
                    null, 
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.dataTable ) {
            message_table = $(".messages_datatable").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null, 
                    null, 
                    null, 
                    null, 
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.dataTable ) {
            $(".login_datatable").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null,
                    null,
                    null,
                    { "bSortable": false }
                ],
				"aaSorting": [[0,'desc']]
            });
        }
		
		if( $.fn.dataTable ) {
           blacklisted_tbl =  $(".blacklisted_datatables").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null,
                    null,
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.dataTable ) {
           blacklisted_tbl_ips =  $(".blacklisted_datatables_ips").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null,
                    null,
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.dataTable ) {
           privi_table = $(".privilege_datatabl").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null,
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.dataTable ) {
            user_Table  = $(".user_datatable").dataTable({
                "aoColumns": [
                    null, 
                    null,
                    null,
                    null,
                    null,
                    null,
                    { "bSortable": false }
                ]
            });
        }
		if( $.fn.timepicker ) {
                $(".mws-dtpicker").datetimepicker();

                $(".mws-tpicker").timepicker({});
            }
		


        $.fn.iButton && $('.ibutton').iButton({
            change: function(event, ui){
                try{
                    console.log($(".ibutton").iButton()[0].getAttribute("checked").length>0);
                }catch(err){
                    console.log('false');
                }
            }
        });

		 $.fn.iButton && $('.ibuttonz').iButton({
			change: function(event, ui){
				 try{
					console.log($(".ibuttonz").iButton()[0].getAttribute("checked").length>0);
				}catch(err){
					console.log('false');
				}
			}
		});
		$.fn.iButton && $('.ibuttonzzz').iButton({
            change: function(event, ui){
                 try{					
					//data = {key:'id', id:1  , db_row:'is_activated' , is_activated: 0 , _token:token };
					//url  = "/administrator/singlerowedit/Setting";
					//ajaxModifyCall(url,data);
					
                }catch(err){
					//data = {key:'id', id:1  , db_row:'is_activated' , is_activated: 1 , _token:token };
					//url  = "/administrator/singlerowedit/Setting";
					//ajaxModifyCall(url,data);
                }
            }
        });

         if( $.fn.select2 ) {
            tagselector = $("select.mws-select-tags").select2();
        }
         if( $.fn.select2 ) {
            $("select.mws-select2").select2();
        }
		$.fn.cleditor && $( '#cleditor').cleditor({width: 850, height: 400,});

        $("#mws-form-dialog").dialog({
                autoOpen: false,
                modal: true,
                width: "640"
            });   
		$("#new_password_form").dialog({
                autoOpen: false,
                modal: true,
                width: "640"
            });   
		
		$.fn.prettyPhoto && $("a[rel^='prettyPhoto']").prettyPhoto();
		
		
		         $.fn.pickList && $('#pickList').pickList();
				 
    });

}) (jQuery, window, document);