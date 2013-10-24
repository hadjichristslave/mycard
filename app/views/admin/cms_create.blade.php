@extends('templates.interface')
@section('content')

	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-pencil"></i> Cms Create</span>
						<input type="button" value="Create" class="btn btn-info cms_create" style="float: right;margin: -27px 15px 0 0;">
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form class="mws-form cms_create_form">
						 {{Form::token()}}
                        	<div class="mws-form-inline">
                            	<div class="mws-form-row">
                                	<label class="mws-form-label">Name</label>
                                	<div class="mws-form-item">
                                    	<input type="text" class="medium" name="name">
                                    </div>
                                </div>
                            	<div class="mws-form-row">
									<label class="mws-form-label">Category Pages</label>
									<div class="mws-form-item">
										<select class="mws-select2 medium categoriesselect" onChange="return hasGallery()" name="category_id">
											@foreach(Cmscategory::all() as $dat)
												<option value="{{$dat->id}}">{{$dat->name}}</option>
											@endforeach
										</select>
										<span data-original-title="The gallery is automatically generated and you can modify it from the gallery navigation menu" rel="tooltip" data-placement="right"class="badge badge-success tagsspan" style="display:none;margin-top:5px;cursor:pointer"><i class="icon-ok" ></i> Has Gallery!</span>
									</div>
								</div>
                            	<div class="mws-form-row">
                                	<label class="mws-form-label">Order</label>
                                	<div class="mws-form-item">
                                    	<input type="text" class="medium" value="0" readonly="readonly" name="order">
                                    </div>
                                </div>
                            	<div class="mws-form-row">
									<label class="mws-form-label">Language</label>
									<div class="mws-form-item">
										<select class="mws-select2 medium categoriesselect" name="lang_id">
											@foreach(Languages::all() as $dat)
												<option value="{{$dat->id}}">{{$dat->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Title</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="medium" class="mws-autocomplete" name="title">
                                    </div>
                                </div>
								<div class="mws-form-row">
									<label class="mws-form-label">Tags</label>
									<div class="mws-form-item">
										<select class="mws-select2 medium cms_tags_select" multiple size="5">
											@foreach(Cmstags::all() as $dat)
												<option value="{{$dat->id}}">{{$dat->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							<div class="mws-form-row">
								<label class="mws-form-label">Content</label>
								<div class="mws-form-item">
									<textarea id="cleditor" class="large" name="content"></textarea>
								</div>
							</div>
							 <input type="text" name="tags" class="cs_tag_ids" style="display:none;" />
                            </div>
                        </form>
                    </div>    	
                </div>




@stop