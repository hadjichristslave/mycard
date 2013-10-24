@extends('templates.interface')
@section('content')

<div class="mws-panel grid_8 mws-collapsible">
                        <div class="mws-panel-header">
                            <span>Cms pages</span>
							 <div class="mws-button-row" style="float: right;position: relative;margin: -27px 35px 0 0;">
                                    <input type="button" value="Modify" class="btn btn-warning pagemodify">
                                    <input type="button" value="Delete" class="btn btn-danger pagedelete">
                                    <input type="button" value="Create" class="btn btn-info  pagecreate">
                                </div>
                        </div>
                        
                            <form class="mws-form page_operation_form">
                            	{{Form::token()}}
                                <div class="mws-form-inline">                                
                                    <div class="mws-form-row">
                                        <label class="mws-form-label">Page</label>
                                        <div class="mws-form-item">
                                            <select class="mws-select-tags small pagesSelect ajax-select2" name="id">
                                               @foreach($data as $dat)
													<option value="{{$dat->id}}">{{$dat->name}}</option>
												@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mws-form-row">
                    				<label class="mws-form-label">Current Tag Value</label>
                    				<div class="mws-form-item">
                                    	<input type="text" placeholder="current_val" name="name" id="tagValue" class="small"/>
                    				</div>
									</div>
									<div class="mws-form-row">
                    				<label class="mws-form-label">Begins with</label>
                    				<div class="mws-form-item">
                                    	<textarea type="text" placeholder="Any html the page may begin with" name="begins_with" class="small begins_with" ></textarea>
                    				</div>
									</div>
									<div class="mws-form-row">
                    				<label class="mws-form-label">Ends With</label>
                    				<div class="mws-form-item">
                                    	<textarea type="text" placeholder="The html that closes the hypothetical html" name="ends_with" class="small ends_with"></textarea>
                    				</div>
									</div>
									
									<div class="mws-form-row">
                    				<label class="mws-form-label">Method</label>
                    				<div class="mws-form-item">
                                    	<input type="text" placeholder="current_val" name="method" class="small page_method"/>
                    				</div>
									</div>
									<div class="mws-form-row">
                    				<label class="mws-form-label">Page Categories</label>
										<div class="mws-form-item">
											<ul id="sortable1" class="connectedSortable">
											<p class="categorieswatermark">Categories not included</p>
											 
											</ul>
											 
											<ul id="sortable2" class="connectedSortable">
											<p class="categorieswatermark">Categories included</p>
											 
											</ul>
										</div>
									</div>
									
                                   
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
				
				
				
				
				

 
<div id="dialog-confirm" title="Delete this tag?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected page and all its associations will be removed. Are you sure?</p>
</div>


@stop