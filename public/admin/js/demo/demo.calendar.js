/*
 * MWS Admin v2.1 - Calendar Demo JS
 * This file is part of MWS Admin, an Admin template build for sale at ThemeForest.
 * All copyright to this file is hold by Mairel Theafila <maimairel@yahoo.com> a.k.a nagaemas on ThemeForest.
 * Last Updated:
 * December 08, 2012
 *
 */

;(function( $, window, document, undefined ) {

    $(document).ready(function() {

        // Full Calendar
        if( $.fn.fullCalendar ) {

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();


           var calendar =  $("#mws-calendar").fullCalendar({
				onClick: function(event ,ui){ console.log(event); console.log(ui);},
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
				selectable: true,
				selectHelper: true,
				select: function(start, end, allDay) {
					//$("#mws-calendar").fullCalendar('removeEvents' , 'idOrArray');
					 $("#mws-form-dialog").dialog("option", {
							title: 'Create Event',
							modal: true,
							buttons: [{
								text: "Create",
								click: function () {
										url      = "/administrator/create/Calendar";
										$(".calendar_start").val(start);
										$(".calendar_end").val(end);
										$(".calendar_allday").val(allDay);
										data     = $("form#message_view").serializeArray();
										calendarModifyCall(url , data);
										calendar.fullCalendar('renderEvent',
											{
												id        : $(".modal_msg_id").val(),
												title	  : $(".modal_msg_name").val(),
												start	  : start,
												end	 	  : end,
												allDay	  : allDay,
												extras    : $(".ev_comments_class").val(),
												user_id   : $(".ev_creator_class").val()
											},
											true // make the event "stick"
										);
										$( this ).dialog( "close" );
										calendar.fullCalendar('unselect');
								}
							}]
						}).dialog("open");
						event.preventDefault();
				},
				eventDrop: function(e, delta) {
					calendar.fullCalendar('removeEvents' , e.id);			
										
					url      = "/administrator/edit/Calendar";
					data     = { _token :token , id: e.id , start:e.start , end : e.end , extras:e.extras, title:e.title, allDay:e.allDay, user_id: $(".ev_creator_class").val()}
					calendarModifyCall(url , data);

					calendar.fullCalendar('renderEvent',
						{
							id        : e.id,
							title	  : e.title,
							start	  : e.start,
							end	 	  : e.end,
							allDay	  : e.allDay,
							extras    : e.extras,
							user_id   : $(".ev_creator_class").val()
						},
						true // make the event "stick"
					);
				},
				loading: function(bool) {
				  if (bool) 
					$("#loading_div").css('height', screen.height +'px' ).show();
				  else 
					$("#loading_div").delay(300).hide(200);
				},
				eventClick: function(calEvent, jsEvent, view) {
					$(".modal_msg_name").val(calEvent.title);
					$(".ev_comments_class").val(calEvent.extras);
					$(".modal_msg_id").val(calEvent.id);
					
					
					
					$("#mws-form-dialog").dialog("option", {
							title: 'Edit event',
							modal: true,
							buttons: [{
								text: "Edit the event",
								click: function () {
										calendar.fullCalendar('removeEvents' , $(".modal_msg_id").val());
										
										
										url      = "/administrator/edit/Calendar";
										$(".calendar_start").val(calEvent.start);
										$(".calendar_end").val(calEvent.end);
										$(".calendar_allday").val(calEvent.allDay);
										data     = $("form#message_view").serializeArray();
										calendarModifyCall(url , data);

										calendar.fullCalendar('renderEvent',
											{
												id        : $(".modal_msg_id").val(),
												title	  : $(".modal_msg_name").val(),
												start	  : calEvent.start,
												end	 	  : calEvent.end,
												allDay	  : calEvent.allDay,
												extras    : $(".ev_comments_class").val(),
												user_id   : $(".ev_creator_class").val()
											},
											true // make the event "stick"
										);
										
										$( this ).dialog( "close" );
								}
							},
							{
								text: "Delete the event",
								click: function () {
									url      = "/administrator/delete/Calendar/"+ $(".modal_msg_id").val();
									data     = { _token: token}
									calendar.fullCalendar('removeEvents' , $(".modal_msg_id").val());
									calendarModifyCall(url , data);
									$( this ).dialog( "close" );
								}
							}]
						}).dialog("open");
						event.preventDefault();

				},
                editable: true,
				events: "/administrator/calreturn/Calendar"

            });
        }
    });

}) (jQuery, window, document);




