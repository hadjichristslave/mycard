@extends('templates.interface')
@section('content')
            	<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>Login Data</span>
						{{Form::token()}}
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table login_datatable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Browser</th>
                                    <th>Platform</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                	@foreach($data as $dat) 
                                <tr msg_id="{{$dat->id}}" {{Message::setUnreadClass($dat->id , Input::get('message_by_id'))}} >
										
                                    <td>{{$dat->id}}</td>
                                    <td class="msg_name">{{User::find($dat->user_id)->username}}</td>
                                    <td class="msg_email">{{$dat->action}}</td>
                                    <td class="msg_email">{{$dat->browser}}</td>
                                    <td class="msg_email">{{$dat->platform}}</td>
                                    <td class="msg_text">{{$dat->created_at}}</td>
                                </tr>
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
@stop