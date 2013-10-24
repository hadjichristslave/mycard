@extends('templates.interface')
@section('content')
            
	<!-- Statistics Button Container -->
	<div class="mws-stat-container clearfix">
    	
        <!-- Statistic Item -->
    	<a class="mws-stat" href="#">
        	<!-- Statistic Icon (edit to change icon) -->
        	<span class="mws-stat-icon icol32-medal-gold-3"></span>
            
            <!-- Statistic Content -->
            <span class="mws-stat-content">
            	<span class="mws-stat-title">Websites Resolved</span>
                <span class="mws-stat-value">{{Cms::where('category_id' , '=' , 7)->count()}}</span>
            </span>
        </a>

    	<a class="mws-stat" href="#">
        	<!-- Statistic Icon (edit to change icon) -->
        	<span class="mws-stat-icon icol32-email-open"></span>
            
            <!-- Statistic Content -->
            <span class="mws-stat-content">
            	<span class="mws-stat-title">Messages Viewed</span>
                <span class="mws-stat-value viewedmsgpercent">{{number_format(Message::viewedMessagePercentage(), 2, '.', '')}}%</span>
            </span>
        </a>

    	<a class="mws-stat" href="#">
        	<!-- Statistic Icon (edit to change icon) -->
        	<span class="mws-stat-icon icol32-www-page"></span>
            
            <!-- Statistic Content -->
            <span class="mws-stat-content">
				{{Form::token()}}
            	<span class="mws-stat-title">Visitors Online</span>
                <span class="mws-stat-value ppl_online">{{Logtraffic::getLiveUsers()}}</span>
            </span>
        </a>
        
    	<a class="mws-stat" href="#">
        	<!-- Statistic Icon (edit to change icon) -->
        	<span class="mws-stat-icon icol32-exclamation"></span>
            
            <!-- Statistic Content -->
            <span class="mws-stat-content">
            	<span class="mws-stat-title">Banned Users</span>
                <span class="mws-stat-value">{{User::where('is_banned', '=' , 1)->count()}}</span>
            </span>
        </a>
        
    	<a class="mws-stat" href="#">
        	<!-- Statistic Icon (edit to change icon) -->
        	<span class="mws-stat-icon icol32-calendar"></span>

            <!-- Statistic Content -->
            <span class="mws-stat-content">
            	<span class="mws-stat-title">Forthcoming events</span>
                <span class="mws-stat-value forthcomingevent">{{Calendar::getForthComing()}}</span>
            </span>
        </a>
    </div>
    
    <!-- Panels Start -->
     
	<div class="mws-panel grid_5">
    	<div class="mws-panel-header">
        	<span><i class="icon-graph"></i> Website statistics</span>
        </div>
        <div class="mws-panel-body">
            <div id="mws-dashboard-chart" style="height: 222px;"></div>
        </div>
    </div>
    
	<div class="mws-panel grid_3">
    	<div class="mws-panel-header">
        	<span><i class="icon-book"></i>Website Summary</span>
        </div>
        <div class="mws-panel-body no-padding">
            <ul class="mws-summary clearfix">
                <li>
                    <span class="key"><i class="icon-cyclop"></i>Num of Projects</span>
                    <span class="val">
                        <span class="text-nowrap">{{Cms::where('category_id' , '=' , 7)->count()}}</span>
                    </span>
                </li>
                <li>
                    <span class="key"><i class="icon-meter-medium"></i>Traffic /Month</span>
                    <span class="val">
                        <span class="text-nowrap monthlyusers">{{Logtraffic::monthlyOverTotalPercentage()}}</span>
                    </span>
                </li>
                <li>
                    <span class="key"><i class="icon-meter-fast"></i> Total Traffic</span>
                    <span class="val">
                        <span class="text-nowrap totalusers">{{Logtraffic::all()->count()}}</span>
                    </span>
                </li>
                <li>
                    <span class="key"><i class="icon-key"></i> Last Login</span>
                    <span class="val">
                        <span class="text-nowrap">{{Auth::user()->updated_at}}</span>
                    </span>
                </li>
                <li>
                    <span class="key"><i class="icon-windows"></i> Operating System</span>
                    <span class="val">
                        <span class="text-nowrap">Ubuntu Linux on Lampp</span>
                    </span>
                </li>
                <li>
                    <span class="key"><i class="icon-keyboard"></i>Sleepless coder(s)</span>
                    <span class="val">
                        <span class="text-nowrap">1</span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
	
	<div class="mws-panel grid_5">
    	<div class="mws-panel-header">
        	<span><i class="icon-graph"></i> Messages</span>
        </div>
       <div class="mws-panel-content">
				<div id="mws-bar-chart" style="width:100%;height:300px;"></div>
			</div>
    </div>
	
	
    <!-- Panels End -->
	
	<script type="text/javascript">
		 var PageViews = {{Logtraffic::getCountViewsForMonth('Logtraffic' , 'updated_at')}},
                 Login = {{Logtraffic::getCountViewsForMonth('Loglogin' , 'updated_at')}},
                 CalendarEvents = {{Logtraffic::getCountViewsForMonth('Calendar' , 'start')}};
             var data = [{
                 data: PageViews,
                 label: "Traffic",
                 color: "#c75d7b"
             }, {
                 data: Login,
                 label: "Login",
                 color: "#c5d52b"
             },{
                 data: CalendarEvents,
                 label: "Cal events",
                 color: "#c5d52b"
             }];
	</script>
    
@stop