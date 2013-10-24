var my_idz;
$(document).ready(function(){
	$(".bl_user").click(function () {
		my_idz = $(this).attr('user_idz');
		$.ajax({
			type: "POST",
			asynch:false,
			url: "/administrator/singlerowedit/Blacklistuser",
			data: { id: $(this).attr('blacklist_user'), _token: token , key: 'username' , db_row:'counter' , value: 0}
			}).done(function( results ) {
		});	
		$.ajax({
			type: "POST",
			asynch:false,
			url: "/administrator/singlerowedit/User",
			data: { id: $(this).attr('blacklist_user'), _token: token , key: 'username' , db_row:'is_banned' , value: 0}
			}).done(function( results ) {
				$(".error_message").empty().append(results);
				$(".hidden_pannel").show(500).delay(2000).hide(500);
				var rowee = $("tr[bl_ip='"+my_idz+"']").get(0);

				blacklisted_tbl.fnDeleteRow(blacklisted_tbl.fnGetPosition(rowee));
				
		});
		
	});
	var blacklist_id;
	$(".bl_ip").click(function(){
		blacklist_id = $(this).attr('blacklist_id');
		$.ajax({
			type: "POST",
			url: "/administrator/singlerowedit/Blacklistip",
			data: { id: $(this).attr('blacklist_id'), _token: token , key: 'id' , db_row:'counter' , value: 0}
			}).done(function( results ) {
				var rowee = $("i[blacklist_id='"+blacklist_id+"']").closest('tr').get(0);
				blacklisted_tbl_ips.fnDeleteRow(blacklisted_tbl_ips.fnGetPosition(rowee));
				$(".error_message").empty().append(results);
				$(".hidden_pannel").show(500).delay(2000).hide(500);
		});
	});
});	