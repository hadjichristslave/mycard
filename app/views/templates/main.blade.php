<!DOCTYPE HTML>
<html dir="ltr" lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <title>Panagiotis Chatzichristodoulou vCard</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    {{HTML::style("css/reset.css")}}
    {{HTML::style("css/style.css")}}
    {{HTML::style("css/prettyPhoto.css")}}
	{{HTML::style("http://fonts.googleapis.com/css?family=Open+Sans:400,600,300,800,700,400italic|PT+Serif:400,400italic")}}
    <!--[if IEMobile]> 
    <link rel="stylesheet" type="text/css" href="css/iemobile.css"/>
    <![endif]--> 
    
    {{HTML::script("js/jquery.min.js")}}
    {{HTML::script("js/jquery.easytabs.min.js")}}
    {{HTML::script("js/respond.min.js")}}
    {{HTML::script("js/jquery.prettyPhoto.js")}}
    {{HTML::script("js/jquery.isotope.min.js")}}
    {{HTML::script("http://maps.google.com/maps/api/js?sensor=false")}}
    {{HTML::script("js/jquery-ui-map.js")}}
    {{HTML::script("js/jquery.carouFredSel.js")}}
    {{HTML::script("js/plugins.js")}}
    {{HTML::script("js/custom.js")}}

    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
</head>


    <body>
        <!-- Container -->
		<section id="container">
        
            <!-- Header -->
            <header>
                {{Cms::cmsTrnslData('header' , 1)}}                 
            </header>
            <!-- /Header -->

@yield('content')


	 <!-- Footer -->
            <footer>
                <div class="copyright">Copyright © 2013 by slave</div>
            </footer>
            <!-- /Footer --> 
            
        </section>
        <!-- /Container -->

    </body>
</html>

{{Logtraffic::record()}}