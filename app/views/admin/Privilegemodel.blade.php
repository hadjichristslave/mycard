@extends('templates.interface')
@section('content')
            	<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>Privilege to model Associations</span>
						<input type="button" value="Create Model to Privilege Association" class="btn btn-info mod_create" style="float: right;margin: -27px 35px 0 0;">
                    </div>
						{{Form::token()}}
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table privilege_datatabl">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Privilege name</th>
                                    <th>Privilege category</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                	@foreach($data as $dat) 
                                <tr model_id="{{$dat->id}}">
										
                                    <td>{{$dat->id}}</td>
                                    <td class="cms_name">{{$dat->modelname}}</td>
                                    <td privil_id="{{$dat->privil_id}}" >{{Privilege::find($dat->privil_id)->name}}</td>
                                    <td>
                                        <span class="btn-group">
                                            <a href="#" class="btn btn-small"><i class="icon-pencil mod_edit" mod_id="{{$dat->id}}" privil_id="{{$dat->privil_id}}" ></i></a>
                                            <a href="#" class="btn btn-small"><i class="icon-trash mod_del" mod_id="{{$dat->id}}" ></i></a>
                                        </span>
                                    </td>
                                </tr>
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


<div id="dialog-confirm" title="Delete this cms?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected model will be removed. Are you sure?</p>
</div>			

<div id="mws-form-dialog">
	<form class="mws-form privilege_editor_form" id="cms_edit_form" >
		{{Form::token()}}
		<div class="mws-form-inline">
					<div class="mws-form-row">
						<label class="mws-form-label">Name</label>
						<div class="mws-form-item">
							<input type="text" class="medium editable_name" name="modelname">
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Category Pages</label>
						<div class="mws-form-item">
							<select class="mws-select2 medium categoriesselect" name="privil_id">
								@foreach(Privilege::all() as $dat)
									<option value="{{$dat->id}}">{{$dat->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
			 <input type="text" name="id" class="hidden_id" style="display:none;" />
		</div>
	</form>
</div>



@stop