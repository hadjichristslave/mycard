@extends('templates.interface')
@section('content')
            	<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>App Users</span>
						<input type="button" value="Create" class="btn btn-info user_create" style="float: right;margin: -27px 35px 0 0;">
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table user_datatable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Group</th>
                                    <th>Is Banned</th>
                                    <th>Last account move</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                	@foreach($data as $dat) 
                                <tr user_id="{{$dat->id}}" {{Message::setUnreadClass($dat->id , Input::get('message_by_id'))}} >
										
                                    <td>{{$dat->id}}</td>
                                    <td class="">{{$dat->username}}</td>
                                    <td class="">**********</td>
                                    <td class="">{{Usergroup::find($dat->group_id)->name}}</td>
                                    <td class="">{{$dat->is_banned=="1"?'Yes':'No'}}</td>
                                    <td class="">{{$dat->updated_at}}</td>
                                    <td class="">
										 <span class="btn-group">
                                            <a href="#" class="btn btn-small"><i class="icon-pencil user_edit"  group_id="{{$dat->group_id}}" banned="{{$dat->is_banned}}"user_id="{{$dat->id}}" row_id="{{$dat->id}}"></i></a>
                                            <a href="#" class="btn btn-small"><i class="icon-trash user_delete" user_id="{{$dat->id}}" row_id="{{$dat->id}}"></i></a>
                                        </span>
									</td>
                                </tr>
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
				
				

<div id="dialog-confirm" title="Delete this cms?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected user will be removed. Are you sure?</p>
</div>

<div id="mws-form-dialog">
	<form class="mws-form" id="user_edit_form">
		<input type="text" name="id" value="0" class="modal_user_id"  style="display:none;"/>
		{{Form::token()}}
		<div class="mws-form-inline">
					<div class="mws-form-row usernamerow" style="display:none;">
						<label class="mws-form-label" >Username</label>
						<div class="mws-form-item">
							<input type="text" class="medium modal_username" name="username" >
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Password</label>
						<div class="mws-form-item">
							<input type="password" class="medium modal_password" id="modal_password" name="password">
						</div>
						<i class="icol-arrow-refresh modal_refresh" data-original-title="Click to toggle password visibility" rel="tooltip" data-placement="right" ></i>
					<div class="mws-form-row">
					</div>					
						<label class="mws-form-label">Group</label>
						<select class="mws-select2 medium modal_group_id" name="group_id" >
								@foreach(Usergroup::all() as $dat)
									<option value="{{$dat->id}}">{{$dat->name}}</option>
								@endforeach
							</select>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Is Banned</label>
							 <div class="mws-form-item">
                                <ul class="mws-form-list inline">
                                    <li><input class="ibutton" type="checkbox" data-label-on="Not Banned" data-label-off="Banned" checked="checked" name="is_banned"></li>
                                </ul>
                            </div>
					</div>
		</div>
	</form>
</div>

				
				
				
				
				
				
				
				
				
				
				
@stop