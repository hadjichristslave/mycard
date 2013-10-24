<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Required Stylesheets -->

{{HTML::style("css/reset.css")}}
{{HTML::style("admin/bootstrap/css/bootstrap.min.css")}}
{{HTML::style("admin/css/fonts/ptsans/stylesheet.css")}}
{{HTML::style("admin/css/fonts/icomoon/style.css")}}

{{HTML::style("admin/css/login.css")}}

{{HTML::style("admin/css/mws-theme.css")}}

<title>Heuristic-web Login Page</title>

</head>

<body>
	@yield('content')




	    <!-- JavaScript Plugins -->
    {{HTML::script("admin/js/libs/jquery-1.8.3.min.js")}}
    {{HTML::script("admin/js/libs/jquery.placeholder.min.js")}}
    {{HTML::script("admin/custom-plugins/fileinput.js")}}
    
    <!-- jQuery-UI Dependent Scripts -->
    {{HTML::script("admin/jui/js/jquery-ui-effects.min.js")}}

    <!-- Plugin Scripts -->
    {{HTML::script("admin/plugins/validate/jquery.validate-min.js")}}

    <!-- Login Script -->
    {{HTML::script("admin/js/core/login.js")}}

</body>
</html>