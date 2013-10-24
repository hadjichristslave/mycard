@extends('templates.interface')
@section('content')
						{{Form::token()}}
            	<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>I.P. Bans</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table blacklisted_datatables_ips">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>IP</th>
                                    <th>Counter</th>
                                    <th>Last Request</th>
									<th></th>
                                </tr>
                            </thead>
                            <tbody>
                                	@foreach($data as $dat) 
									@if($dat->counter>4)
									<tr bl_ip="{{$dat->id}}" {{ Blacklistip::setMarkClass($dat->id , Input::get('ip_id'))}}>											
										<td>{{$dat->id}}</td> 
										<td >{{$dat->ip}}</td>
										<td >{{$dat->counter}}</td>
										<td >{{$dat->updated_at}}</td>
										<td>
											<span class="btn-group" title = "Reset the ban">
												<a href="#" class="btn btn-small"><i class="icon-refresh bl_ip" blacklist_id="{{$dat->id}}"></i></a>
											</span>
										</td>
									</tr>
									@endif
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="mws-panel grid_8 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>User Bans</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table blacklisted_datatables">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>username</th>
                                    <th>Counter</th>
                                    <th>Last Request</th>
									<th></th>
                                </tr>
                            </thead>
                            <tbody>
                                	@foreach(User::all() as $dat) 
									@if($dat->is_banned==1)
										<tr bl_ip="{{$dat->id}}" {{ Blacklistip::setMarkClass($dat->id , Input::get('user_id'))}}>												
											<td>{{$dat->id}}</td>
											<td >{{$dat->username}}</td>
											<td >{{$dat->counter}}</td>
											<td >{{$dat->updated_at}}</td>
											<td>
												<span class="btn-group" title = "Reset the ban">
													<a href="#" class="btn btn-small"><i class="icon-refresh bl_user" blacklist_user="{{$dat->username}}" target_table="blacklist_user" user_idz="{{$dat->id}}"></i></a>
												</span>
											</td>
										</tr>
									@endif
									@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
@stop