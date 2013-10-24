/*
 * MWS Admin v2.1 - Dashboard Demo JS
 * This file is part of MWS Admin, an Admin template build for sale at ThemeForest.
 * All copyright to this file is hold by Mairel Theafila <maimairel@yahoo.com> a.k.a nagaemas on ThemeForest.
 * Last Updated:
 * December 08, 2012
 *
 */

;(function( $, window, document, undefined ) {

	

    $(document).ready(function() {
	
        // Data Tables
        if( $.fn.dataTable ) {
            $(".mws-datatable").dataTable({
                "aoColumns": [
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
            $(".messages_datatable").dataTable({
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

        //$.fn.pickList && $('#pickList').pickList();
        


         if( $.fn.select2 ) {
            $("select.mws-select-tags").select2();
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
		
		$.fn.prettyPhoto && $("a[rel^='prettyPhoto']").prettyPhoto();
		
    });

}) (jQuery, window, document);