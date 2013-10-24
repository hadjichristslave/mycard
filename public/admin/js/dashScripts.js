function doBounce(element, times, distance, speed) {
    for(i = 0; i < times; i++) {
        element.animate({marginTop: '-='+distance},speed)
            .animate({marginTop: '+='+distance},speed);
    }        
}
window.setInterval(function(){
	$('.ppl_online').css('opacity' , '0.2');
	$('.monthlyusers').css('opacity' , '0.2');
	$('.ppl_online').css('filter(alpha)' , '20');
	$('.monthlyusers').css('filter(alpha)' , '20');
	$('.totalusers').css('opacity' , '.2');
	$('.totalusers').css('filter(alpha)' , '20');
	$('#mws-dashboard-chart').css('filter(alpha)' , '20');
	$('#mws-dashboard-chart').css('opacity' , '.2');
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/onlineusers/Logtraffic/getLiveUsers",
	  	data: { _token: token }
		}).done(function( results ) {
			$('.ppl_online').fadeTo('slow',1);
			$('.ppl_online').css('filter(alpha)' , '100');
	  		$('.ppl_online').html(results);
		});
		
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/onlineusers/Logtraffic/monthlyOverTotalPercentage",
	  	data: { _token: token }
		}).done(function( results ) {
			$('.monthlyusers').fadeTo('slow',1);
			$('.monthlyusers').css('filter(alpha)' , '100');
	  		$('.monthlyusers').html(results);
		});
		
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/onlineusers/Logtraffic/totalTraffic",
	  	data: {  _token: token }
		}).done(function( results ) {
	  		$('.totalusers').fadeTo('slow',1);
			$('.totalusers').css('filter(alpha)' , '100');
	  		$('.totalusers').html(results);
		});
		
	$.ajax({
	type: "POST",
	url: "/administrator/onlineusers/Calendar/getForthcoming",
	data: {  _token: token }
	}).done(function( results ) {
		$(".forthcomingevent").text(results);
	});
	
	$.ajax({
	type: "POST",
	url: "/administrator/onlineusers/Message/getMessageUpdates",
	data: {  _token: token }
	}).done(function( results ) {
		old_count = $(".messagecount").text();
		new_count = results[0];
		
		$(".messagecount").text(results[0]);
		$(".unreadMessageList").html(results[1]);
		$(".viewedmsgpercent").text(results[2] + "%");

		if(old_count!=new_count)
			doBounce($(".messagecount"), 4, '7px', 200);
	});
	
	$.ajax({
	type: "POST",
	url: "/administrator/onlineusers/Message/getNotificationUpdates",
	data: {  _token: token }
	}).done(function( results ) {
		old_count = $(".notificationtext").text();
		new_count = results[0];
		//notificationtext
		//notificationlist
		
		
		$(".notificationtext").text(results[0]);
		$(".notificationlist").html(results[1]);

		if(old_count!=new_count)
			doBounce($(".notificationtext"), 4, '7px', 200);
	});
	
	$.ajax({
	  	type: "POST",
	  	url: "/administrator/onlineusers/Logtraffic/plotTraffic",
	  	data: {  _token: token }
		}).done(function( results ) {
			var datz = [{
				data:eval('(' + results[0]+ ')'),
				label:"Traffic",
				color:"#c75d7b"
				},{
				data:eval('(' + results[1]+ ')'),
				label:"Login",
				color:"#c5d52b"
				},{
				data:eval('(' + results[2]+ ')'),
				label:"Cal events",
				color:"#c5d52b"
				}];
				$.plot($("#mws-dashboard-chart"), datz, {
                  series: {
                      lines: {
                          show: true
                      },
                      points: {
                          show: true
                      }
                  },
                  tooltip: true,
                  grid: {
                      hoverable: true,
                      borderWidth: 0
                  }
              });
			  $('#mws-dashboard-chart').fadeTo(250,1);
			  $('#mws-dashboard-chart').css('filter(alpha)'	, '1');
		});
			
		
}, 15000);