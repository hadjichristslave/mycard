@extends('templates.interface')
@section('content')
            	<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>Cms Data</span>
						{{Form::token()}}
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table messages_datatable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Content</th>
                                    <th>Is Read</th>
                                    <th>Sent At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                	@foreach($data as $dat) 
                                <tr msg_id="{{$dat->id}}" {{Message::setUnreadClass($dat->id , Input::get('message_by_id'))}} >
										
                                    <td>{{$dat->id}}</td>
                                    <td class="msg_name">{{$dat->name}}</td>
                                    <td class="msg_email">{{$dat->email}}</td>
                                    <td class="msg_text">{{$dat->message}}</td>
                                    <td class="msg_read_badge"><span class="badge badge-{{$dat->is_read==0?'warning':'success'}}">{{$dat->is_read==0?'No!':'Yes :)'}}</span></td>
                                    <td class="msg_created">{{$dat->created_at}}</td>
                                    <td>
                                        <span class="btn-group">
                                            <a href="#" class="btn btn-small"><i class="icon-search message_view"     msg_id="{{$dat->id}}" ></i></a>
                                            <a href="#" class="btn btn-small"><i class="icon-trash message_delete"    msg_id="{{$dat->id}}" row_id="{{$dat->id}}" ></i></a>
                                        </span>
                                    </td>
                                </tr>
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


<div id="dialog-confirm" title="Delete this cms?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected message will be removed. Are you sure?</p>
</div>

<div id="mws-form-dialog">
	<form class="mws-form" id="message_view">
		{{Form::token()}}
		<div class="mws-form-inline">
					<div class="mws-form-row">
						<label class="mws-form-label">Name</label>
						<div class="mws-form-item">
							<input type="text" class="medium modal_msg_name" disabled>
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Email</label>
						<div class="mws-form-item">
							<input type="text" class="medium modal_msg_email" disabled >
						</div>
					</div>					
					<div class="mws-form-row">
						<label class="mws-form-label">Content</label>
						<div class="mws-form-item">
							<textarea  class="large modal_msg_text" name="content" disabled></textarea>
						</div> 
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Sent At</label>
						<div class="mws-form-item">
							<input type="text" class="medium mws-autocomplete modal_msg_created" disabled>
						</div>
					</div>
		</div>
	</form>
</div>



@stop