@extends('templates.interface')
@section('content')
            	<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>Cms Data</span>
						{{Form::token()}}
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table cms_edit_datatable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Category_id</th>
                                    <th>Order</th>
                                    <th>Language</th>
                                    <th>Title</th>
                                    <th style="display:none;">Content</th>
                                    <th>Tags</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                	@foreach($data as $dat) 
                                <tr cms_id="{{$dat->id}}">
										
                                    <td>{{$dat->id}}</td>
                                    <td class="cms_name">{{$dat->name}}</td>
                                    <td category_id='{{$dat->category_id}}' class="cms_cat">{{Cmscategory::find($dat->category_id)->name}}</td>
                                    <td class="cms_order">{{$dat->order}}</td>
                                    <td lang_id="{{$dat->lang_id}}" class="lang_class">{{Languages::find($dat->lang_id)->name}}</td>
                                    <td class="cms_title" >{{$dat->title}}</td>
                                    <td class="cms_content" style="display:none;">{{{$dat->content}}}</td>
                                    <td class="cms_tags" tagValue='{{$dat->tags}}'> {{Cmstags::csTagsToBadges($dat->tags)}}</td>
                                    <td>
                                        <span class="btn-group">
                                            <a href="#" class="btn btn-small"><i class="icon-pencil cms_edit_but" cms_id="{{$dat->id}}" ></i></a>
                                            <a href="#" class="btn btn-small"><i class="icon-trash cms_delete"    cms_id="{{$dat->id}}" ></i></a>
                                        </span>
                                    </td>
                                </tr>
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


<div id="dialog-confirm" title="Delete this cms?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected cms and all its associations will be removed. Are you sure?</p>
</div>			

<div id="mws-form-dialog">
	<form class="mws-form" id="cms_edit_form">
		<input type="text" name="id" style="display:none;" class="cms_hidden_id" value='' />
		{{Form::token()}}
		<input type="text" name="tags" style="display:none;" class="cs_tag_ids" value='' />
		<div class="mws-form-inline">
					<div class="mws-form-row">
						<label class="mws-form-label">Name</label>
						<div class="mws-form-item">
							<input type="text" class="medium editable_name" name="name">
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
							<input type="number" class="medium editable_order" value="0" name="order">
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Language</label>
						<div class="mws-form-item">
							<select class="mws-select2 medium languageselect" name="lang_id">
								@foreach(Languages::all() as $dat)
									<option value="{{$dat->id}}">{{$dat->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Title</label>
						<div class="mws-form-item">
							<input type="text" class="medium mws-autocomplete cms_editable_title" name="title">
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
						<textarea id="cleditor" class="large cms_editable_content" name="content"></textarea>
					</div> 
				</div>
			 <input type="text" name="tags" class="cs_tag_ids" style="display:none;" />
		</div>
	</form>
</div>



@stop