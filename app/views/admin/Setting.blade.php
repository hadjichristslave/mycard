@extends('templates.interface')
@section('content')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span><i class="icon-wrench"></i>Settings</span>
	</div>
	 <div class="mws-panel-body no-padding">
		<form class="mws-form" >
			{{Form::token()}} 
			<div class="mws-form-inline">
						<div class="mws-form-row">
							<label class="mws-form-label">Web Services</label>
							<div class="mws-form-item">
                                <ul class="mws-form-list inline">
                                    <li><input class="ibuttonzzz" type="checkbox" data-label-on="Yes" data-label-off="No" {{Setting::find(1)->is_activated==1?'checked="checked"':""}}></li>
                                </ul>
                            </div>
						</div>
			</div>
		</form>
	</div>
</div>




@stop