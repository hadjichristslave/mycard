@extends('templates.interface')
@section('content')


	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span>Languages Actions</span>
						<input type="button" value="Delete Selected" class="btn btn-info languagedelete" style="float: right;margin: -27px 15px 0 0;">
						<input type="button" value="Modify Selected to Text" class="btn btn-info languagemodify" style="float: right;margin: -27px 15px 0 0;">
						<input type="button" value="Create language from Text" class="btn btn-info languagecreate " style="float: right;margin: -27px 15px 0 0;">
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form class="mws-form" >
                    		{{Form::token()}}
                    		<div class="mws-form-inline">
                    			<div class="mws-form-row">
                    				<label class="mws-form-label">Languages</label>
                    				<div class="mws-form-item">
                    					<select class="large privilege_selector ajax-select2">
                    						<option value=''>----</option>
                    						@foreach($data as $dat)
                    							<option value="{{$dat->id}}">{{$dat->name}}</option>
                    						@endforeach
                    					</select>
                    				</div>
                    			</div>
                    		</div>
							
							
							<div class="mws-form-row">
								<label class="mws-form-label">Name</label>
								<div class="mws-form-item">
									<input type="text" class="medium user_group_name" name="name">
								</div>
							</div>
							
                    	</form>
                    </div>    	
                </div>

<div id="dialog-confirm" title="Delete this cms?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected Language and all its translations will be removed. Are you sure?</p>
</div>	

@stop