@extends('templates.interface')
@section('content')

				<!--   File uploader css                                   -->
				<!-- Google web fonts -->
		{{HTML::style("http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700")}}

		<!-- The main CSS file -->
		
		{{HTML::style("/fileupld/assets/css/style.css")}}



			<div class="mws-panel grid_8">
			
					<div class="mws-panel">
						<div class="mws-panel-header">
							<span>Cms Galleries</span>
						</div>
						<div class="mws-panel-body no-padding">
							<form class="mws-form" action="form_elements.html">
								{{Form::token()}}
								<div class="mws-form-inline">                                
									<div class="mws-form-row">
										<label class="mws-form-label">Cms with gallery</label>
										<div class="mws-form-item">
											<select class="mws-select-tags small galleryPage">
													<option value="0">--</option>
											   @foreach(Cmsgallery::all() as $dat)
													@if(Cms::hasGallery($dat->cms_id))
														<option value="{{$dat->cms_id}}">{{Cms::find($dat->cms_id)->name}}</option>
													@endif	
												@endforeach
											</select>
										</div>
									</div>								   
								</div>
							</form>
						</div>
					</div>

			
			
                	<div class="mws-panel-header">
                    	<span><i class="icon-pictures"></i> Image Gallery</span>
                    </div>
                    <div class="mws-panel-body">
                		<ul class="thumbnails mws-gallery gallerybodyclass">
                			      			
                		</ul>
                    </div>
				
				
					<div class="mws-panel-header">
                    	<span><i class="icon-upload"></i> Drag 'n' Drop your photos To upload</span>
                    </div>
                    <div class="mws-panel-body">
						<form id="upload" method="post" action="/administrator/fileupld/upload" enctype="multipart/form-data">
							<input type="text" value="{{ Cmsgallery::first()->cms_id }}" style="display:none;" name="cms_id" class="cms_hiden_id"/>
							{{Form::token()}}
							<div id="drop">
								Drop Here
								<a>Browse</a>
								<input type="file" name="upl" multiple />
							</div>
							<div class="gal_photodescription">
								<input type="text" value="" placeholder="Photo Description"class="medium" name="photo_description"/>
							</div>
							<ul>
								<!-- The file uploads will be shown here -->
							</ul>
						</form>
						<!-- JavaScript Includes -->
					</div>

				</div>

<div id="dialog-confirm" title="Delete this picture?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected picture will be deleted. Are you sure?</p>
</div>				
	



	
	
				
@stop

