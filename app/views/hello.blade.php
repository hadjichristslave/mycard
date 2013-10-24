@extends('templates.main')
@section('content')


        
            

            <section id="content" >

			
			
			
				{{Cmspages::getPageData('profile')}}
				
				{{Cmspages::getPageData('page_navigation')}}				
					
				{{Cmspages::getPageData('resume')}}
                                        
				{{Cmspages::getPageData('portfolio')}}

				{{Cmspages::getPageData('contact')}}
				

				

            </section>

			
			
            
@stop