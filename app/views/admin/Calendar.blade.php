@extends('templates.interface')
@section('content')
<div class="mws-panel grid_8">
<div class="mws-panel-header">
<span><i class="icon-calendar"></i>{{$title}} Calendar</span>
</div>
<div class="mws-panel-body no-padding no-border">
<div id="mws-calendar"></div>
</div>
</div>
<div id="loading_div" style="height: 100%px;display: none;background: url('/admin/images/stripe1.jpg');z-index: 10;width: 100%;position: absolute;opacity: .5;">
	<img src="/admin/images/loader.gif" style="position: relative;margin-left: 46%;margin-top: 26%;" />
</div>	


<div id="mws-form-dialog">
	<form class="mws-form" id="message_view">
		{{Form::token()}}
		<div class="mws-form-inline">
					<input type="text" class="medium modal_msg_id" name="id"  value="" style="display:none;">
					<div class="mws-form-row">
						<label class="mws-form-label">Title</label>
						<div class="mws-form-item">
							<input type="text" class="medium modal_msg_name" name="title" >
						</div>
					</div>
					<div class="mws-form-row" style="display:none;">
						<label class="mws-form-label">Start</label>
						<div class="mws-form-item">
							<input type="text"  class="mws-dtpicker calendar_start"  name="start" readonly="readonly" />
						</div> 
					</div>
					<div class="mws-form-row" style="display:none;">
						<label class="mws-form-label">End</label>
						<div class="mws-form-item">
							<input type="text" class="mws-dtpicker calendar_end"   name="end" readonly="readonly" />
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Comments</label>
						<div class="mws-form-item">
							<input type="text" class="medium mws-autocomplete ev_comments_class" name="extras">
						</div>
					</div>
					<div class="mws-form-row">
						<label class="mws-form-label">Last Modify From:</label>
							<select class="mws-select2 medium ev_creator_class" name="user_id" disabled="disabled">
								@foreach(User::all() as $dat)
									<option value="{{$dat->id}}" {{ $dat->id==Auth::user()->id?"selected":"";}} >{{$dat->username}}</option>
								@endforeach
							</select>
					</div>
					<div class="mws-form-row" style="display:none;">
						<label class="mws-form-label">All day </label>
						<div class="mws-form-item">
							<input type="text" class="mws-dtpicker calendar_allday" name="allDay" readonly="readonly" />
						</div>
					</div>
		</div>
	</form>
</div>

@stop