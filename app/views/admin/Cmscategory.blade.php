@extends('templates.interface')
@section('content')
  <div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>Cms categories</span>
						<button type="button" id="category_create" class="btn btn-info">
							<i class="icon-feather"></i> Create Category
						</button>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table mws-datatable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Has Gallery</th>
                                    <th>Comma sep. pages</th>
                                    <th>Has Tags</th>
                                    <th>Begins With</th>
                                    <th>Ends With</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($data as $dat)
                                <tr categoryofid="{{$dat->id}}">
                                    <td class="my_cms_cat_id">{{$dat->id}}</td>
                                    <td class="cat_name">{{$dat->name}}</td>
                                    <td><span class="badge badge-info galleryspan">{{$dat->has_gallery==0?'no':'yes'}}</span></td>
                                    <td class="cs_pages">-----NOT USED----</td>
                                    <td><span class="badge badge-info tagsspan">{{$dat->has_tags==0?'no':'yes'}}</span></td>
                                    <td>{{{$dat->begins_with}}}</td>
                                    <td>{{{$dat->ends_with}}}</td>
                                    <td>
                                        <span class="btn-group">
                                            <a href="#" class="btn btn-small"><i class="icon-pencil edit" category_id="{{$dat->id}}" row_id="{{$dat->id}}"></i></a>
                                            <a href="#" class="btn btn-small"><i class="icon-trash delete" category_id="{{$dat->id}}" row_id="{{$dat->id}}"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
						

<div id="dialog-confirm" title="Delete this tag?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected category and all its associations will be removed. Are you sure?</p>
</div>

<div id="mws-form-dialog">
			<form class="mws-form" id="cms_cat_form">
                	<input type="text" name="id" style="display:none;" class="cms_cat_id" value='' />
                	{{Form::token()}}
                	<input type="text" name="cs_pages" style="display:none;" class="cs_pages_ids" value='-----NOT USED----' />
                    <div class="mws-form-inline">
                    	<div class="mws-form-row">
                        	<label class="mws-form-label">Name</label>
                        	<div class="mws-form-item">
                            	<input type="text" name="name" class="input large cms_cat_form_name" value="">
                            </div>
                        </div>
                        <div class="mws-form-row">
                            <label class="mws-form-label">Has Gallery</label>
                            <div class="mws-form-item">
                                <ul class="mws-form-list inline">
                                    <li><input class="ibutton" type="checkbox" data-label-on="Yes Gallery" data-label-off="No Gallery" checked="checked" name="has_gallery"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mws-form-row">
                            <label class="mws-form-label">Category Pages</label>
                            <div class="mws-form-item">
								<select class="mws-select2 medium categoriesselect" multiple size="5">
                                	@foreach(Cmspages::all() as $dat)
                                		<option value="{{$dat->id}}">{{$dat->name}}</option>
                                	@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mws-form-row">
                            <label class="mws-form-label">Has Tags</label>
                            <div class="mws-form-item">
                                <ul class="mws-form-list inline">
                                    <li><input class="ibuttonz" type="checkbox" data-label-on="Yes Tags" data-label-off="No Tags" checked="checked" name="has_tags"></li>
                                </ul>
							</div>
						</div>
						<div class="mws-form-row">
                        	<label class="mws-form-label">Begins With</label>
                        	<div class="mws-form-item">
                            	<input type="text" name="begins_with" class="input large begins_with">
                            </div>
                        </div>
						<div class="mws-form-row">
                        	<label class="mws-form-label">Ends With</label>
                        	<div class="mws-form-item">
                            	<input type="text" name="ends_with" class="input ends_with">
                            </div>
                        </div>
                </div>`
            </form>

</div>

@stop


