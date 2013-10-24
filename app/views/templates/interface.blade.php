<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel='shortcut icon' type='image/x-icon' href='/admin/images/favicon.ico' />

<!-- Plugin Stylesheets first to ease overrides -->
{{HTML::style("/admin/plugins/colorpicker/colorpicker.css")}}
{{HTML::style("/admin/plugins/prettyphoto/css/prettyPhoto.css")}}
{{HTML::style("/admin/custom-plugins/wizard/wizard.css")}}
{{HTML::style("/admin/plugins/select2/select2.css")}}
{{HTML::style("/admin/plugins/ibutton/jquery.ibutton.css")}}
{{HTML::style("/admin/custom-plugins/picklist/picklist.css")}}
{{HTML::style("/admin/plugins/cleditor/jquery.cleditor.css")}}

{{HTML::style("/admin/plugins/fullcalendar/fullcalendar.css")}}
{{HTML::style("/admin/plugins/fullcalendar/fullcalendar.print.css")}}


<!-- Required Stylesheets -->
{{HTML::style("/admin/bootstrap/css/bootstrap.min.css")}}
{{HTML::style("/admin/css/fonts/ptsans/stylesheet.css")}}
{{HTML::style("/admin/css/fonts/icomoon/style.css")}}

{{HTML::style("/admin/css/mws-style.css")}}
{{HTML::style("/admin/css/icons/icol16.css")}}
{{HTML::style("/admin/css/icons/icol32.css")}}

<!-- Demo Stylesheet -->
{{HTML::style("/admin/css/demo.css")}}

<!-- jQuery-UI Stylesheet -->
{{HTML::style("/admin/jui/css/jquery.ui.all.css")}}
{{HTML::style("/admin/jui/jquery-ui.custom.css")}}
{{HTML::style("/admin/jui/css/jquery.ui.timepicker.css")}}

<!-- Theme Stylesheet -->
{{HTML::style("/admin/css/mws-theme.css")}}
{{HTML::style("/admin/css/themer.css")}}

		<!--   File uploader css                                   -->
				<!-- Google web fonts -->
		{{HTML::style("http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700")}}

		<!-- The main CSS file -->
		{{HTML::style("/fileupld/assets/css/style.css")}}

<title>{{$title}}</title>

</head>

<body>

	<!-- Header -->
	<div id="mws-header" class="clearfix">
    
    	<!-- Logo Container -->
    	<div id="mws-logo-container">
        
        	<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
        	<div id="mws-logo-wrap">
				<a href="/administrator">
					<img src="/admin/images/mws-logo.png" alt="mws admin">
				</a>
			</div>
        </div>
        
        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">
        
        	<!-- Notifications -->
        	<div id="mws-user-notif" class="mws-dropdown-menu" title="Website Notifications">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-exclamation-sign"></i></a>
                
                <!-- Unread notification count -->
                <span class="mws-dropdown-notif notificationtext">{{$notif_number}}</span>
                
                <!-- Notifications dropdown -->
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-notifications notificationlist">
						<? $counter  = 0; ?>
							@foreach(User::all() as $usr)
								@if($usr->is_banned>0)
										<?php  $counter++ ?>
									<li class="unread">
										<a href="/administrator/view/Blacklistip?user_id={{$usr->id}}">
											<span class="message">
												<span class="badge badge-warning">Ban of User:</span> {{$usr->username}}
											</span>
											<span class="time">
												Date of Ban : {{$usr->updated_at}}
											</span>
										</a>
									</li>
								@endif
							@endforeach
							@foreach(Blacklistip::all() as $ip)
								@if($ip->counter>8)
									<?php  $counter++ ?>
									<li class="unread">
										<a href="/administrator/view/Blacklistip?ip_id={{$ip->id}}">
											<span class="message">
												<span class="badge badge-warning">Ban of I.P:</span> {{$ip->ip}}
											</span>
											<span class="time">
												Date of Ban : {{$ip->updated_at}}
											</span>
										</a>
									</li>
								@endif
							@endforeach
							<? if($counter==0){ ?>
								 <div class="mws-dropdown-viewall">
									<a href="#">No notifications as of yet.</a>
								</div>
							<?}?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Messages -->
            <div id="mws-user-message" class="mws-dropdown-menu" title="Webmail Notifications">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-envelope"></i></a>
                
                <!-- Unred messages count -->
                <span class="mws-dropdown-notif messagecount">{{Message::getUnreadMsgCount()}}</span>
                
                <!-- Messages dropdown -->
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-messages unreadMessageList">
						   @foreach(Message::getUnreadMsgs() as $msg)
                        	<li class="read">
                            	<a href='/administrator/view/Message?message_by_id={{$msg->id}}' >
                                    <span class="sender">{{$msg->name}}</span>
                                    <span class="message">
                                        {{{$msg->message}}}
                                    </span>
                                    <span class="time">
                                        {{$msg->created_at}}
                                    </span>
									<span class="time">
                                        {{$msg->email}}
                                    </span>
                                </a>
                            </li>
							@endforeach 
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="/administrator/view/Message">View All Messages</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">
            
            	<!-- User Photo -->
            	<div id="mws-user-photo">
                	<img src="/admin/images/profile.jpg" alt="User Photo">
                </div>
                
                <!-- Username and Functions -->
                <div id="mws-user-functions">
                    <div id="mws-username">
                        Hello, {{Auth::user()->username}}
                    </div>
                    <ul>
                    	<li><a href="/" target="_blank">Go2Site</a></li>
                        <li class="pwd_changer"><a href="#">Change Password</a></li>
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
 <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
        <!-- Necessary markup, do not remove -->
        <div id="mws-sidebar-stitch"></div>
        <div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <!-- Searchbox -->
            <div id="mws-searchbox" class="mws-inset">
                <form>
                    <input type="text" class="mws-search-input" placeholder="Search...">
                    <button type="button" class="mws-search-submit"><i class="icon-search"></i></button>
                </form>
            </div>
            <!-- Main Navigation -->
            <div id="mws-navigation"> 
                <ul>
					{{Navigation::getNavigationData()}}
                </ul>
            </div>         
        </div>



         <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
            <!-- Inner Container Start -->
            <div class="container">
			<!-- Hidden messages to be displayed after data have been received   -->
				<div class="mws-panel grid_8 hidden_pannel" style="display:none;">
					<div class="mws-panel-header">
						<span>
							<i class="icon-comments"></i>
							Message
						</span>
					</div>
					<div class="mws-panel-body no-padding">
						<form class="mws-form">
							<div class="mws-form-message error error_message">
								<ul>
									<li>foo-error</li>
									<li>foo-error 2</li>
								</ul>
							</div>
						</form>
					</div>
				</div>
				
				<!--<?
						echo 'Gallery ';
						$tester = new Gallery();
						if(Validatedata::validateoperation($tester)===true) echo 'yolo';
						$tester = Gallery::where('id' , '=' , 12)->first();
						if(Validatedata::validateoperation($tester)===true) echo 'yolo 12';
						echo '<br>';
				?>-->


	@yield('content')
	@yield('uploader')
            </div>
        </div>


	 <!-- Footer -->
            <!-- <div id="mws-footer">
            	Copyright Slave 2013. All Rights Reserved.
            </div> -->
            
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
    {{HTML::script("/admin/js/libs/jquery-1.8.3.min.js")}}
    {{HTML::script("/admin/js/libs/jquery.mousewheel.min.js")}}
    {{HTML::script("/admin/js/libs/jquery.placeholder.min.js")}}
    {{HTML::script("/admin/custom-plugins/fileinput.js")}}
    
    <!-- jQuery-UI Dependent Scripts -->
    {{HTML::script("/admin/jui/js/jquery-ui-1.9.2.min.js")}}
    {{HTML::script("/admin/jui/jquery-ui.custom.min.js")}}
    {{HTML::script("/admin/jui/js/jquery.ui.touch-punch.js")}}
    {{HTML::script("/admin/jui/js/timepicker/jquery-ui-timepicker.min.js")}}

    <!-- Plugin Scripts -->
    {{HTML::script("/admin/plugins/datatables/jquery.dataTables.min.js")}}
	{{HTML::script("/admin/plugins/prettyphoto/js/jquery.prettyPhoto.js")}}
    <!--[if lt IE 9]>
    {{HTML::script("/admin/js/libs/excanvas.min.js")}}
    <![endif]-->
    {{HTML::script("/admin/plugins/flot/jquery.flot.min.js")}}
    {{HTML::script("/admin/plugins/flot/plugins/jquery.flot.tooltip.min.js")}}
    {{HTML::script("/admin/plugins/flot/plugins/jquery.flot.pie.min.js")}}
    {{HTML::script("/admin/plugins/flot/plugins/jquery.flot.stack.min.js")}}
    {{HTML::script("/admin/plugins/flot/plugins/jquery.flot.resize.min.js")}}
    {{HTML::script("/admin/plugins/colorpicker/colorpicker-min.js")}}
    {{HTML::script("/admin/plugins/validate/jquery.validate-min.js")}}
    {{HTML::script("/admin/custom-plugins/wizard/wizard.min.js")}}
    {{HTML::script("/admin/plugins/fullcalendar/fullcalendar.min.js")}}

    <!-- Core Script -->
    {{HTML::script("/admin/bootstrap/js/bootstrap.min.js")}}
    {{HTML::script("/admin/js/core/mws.js")}}

    <!-- Themer Script (Remove if not needed) -->
    {{HTML::script("/admin/js/core/themer.js")}}

    <!-- Demo Scripts (remove if not needed) -->
    {{HTML::script("/admin/js/dataTableScripts.js")}}
    {{HTML::script('/admin/js/cmsScripts.js')}}
    {{HTML::script('/admin/js/galleryScripts.js')}}
    {{HTML::script('/admin/js/messageScripts.js')}}
    {{HTML::script('/admin/js/logScripts.js')}}
    {{HTML::script('/admin/js/privilegeScripts.js')}}
    {{HTML::script('/admin/js/userScripts.js')}}
    {{HTML::script('/admin/js/settingScripts.js')}}
    {{HTML::script('/admin/js/demo/demo.calendar.js')}}
    {{HTML::script('/admin/js/scriptObjects.js')}}
    {{HTML::script('/admin/js/languageScripts.js')}}
	
	<?
		$_SERVER['REQUEST_URI'];
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		if(strpos($uri_parts[0] , 'dashboard')){
	?>
    {{HTML::script('/admin/js/dashScripts.js')}}
    {{HTML::script('/admin/js/plotScript.js')}}
	<?}?>

    {{HTML::script('/admin/plugins/select2/select2.min.js')}}

    {{HTML::script("/admin/plugins/ibutton/jquery.ibutton.min.js")}}
    {{HTML::script("/admin/custom-plugins/picklist/picklist.min.js")}}
	
	{{HTML::script("/admin/plugins/cleditor/jquery.cleditor.min.js")}}
	{{HTML::script("/admin/plugins/cleditor/jquery.cleditor.table.min.js")}}
    {{HTML::script("/admin/plugins/cleditor/jquery.cleditor.xhtml.min.js")}}
    {{HTML::script("/admin/plugins/cleditor/jquery.cleditor.icon.min.js")}}

	
	
		<!-- jQuery File Upload Dependencies -->
		{{HTML::script("/fileupld/assets/js/jquery.knob.js")}}
		{{HTML::script("/fileupld/assets/js/jquery.ui.widget.js")}}
		{{HTML::script("/fileupld/assets/js/jquery.iframe-transport.js")}}
		{{HTML::script("/fileupld/assets/js/jquery.fileupload.js")}}
		
		<!-- Our main JS file -->
		{{HTML::script("/fileupld/assets/js/script.js")}}
	
	
<div id="new_password_form" style="display:none;">
	<form class="mws-form" id="new_password_form">
		{{Form::token()}}
		<div class="mws-form-inline">
					<div class="mws-form-row">
						<label class="mws-form-label">Old Password</label>
						<div class="mws-form-item">
							<input type="password" class="medium editable_name" name="ol_pass">
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">New Password</label>
						<div class="mws-form-item">
							<input type="password" class="medium modal_password" id="modal_passwordzz" name="password">
					</div>
					<i class="icol-arrow-refresh password_toggle" data-original-title="Click to toggle password visibility" rel="tooltip" data-placement="right" ></i>
					
		</div>
	</form>
</div>

	
</body>
</html>