@extends('templates.interface')
@section('content')


	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span>Privileges Mod</span>
						<input type="button" value="Create Privilages Group from Text" class="btn btn-info priv_create" style="float: right;margin: -27px 15px 0 0;">
						<input type="button" value="Modify Selected to Text" class="btn btn-warning priv_mod" style="float: right;margin: -27px 15px 0 0;">
						<input type="button" value="Delete Selected" class="btn btn-danger privilege_selection" style="float: right;margin: -27px 15px 0 0;">
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form class="mws-form" >
                    		{{Form::token()}}
                    		<div class="mws-form-inline">
                    			<div class="mws-form-row">
                    				<label class="mws-form-label">Dropdown List</label>
                    				<div class="mws-form-item">
                    					<select class="large privilege_select" id="cms_cat_names">
                    						<option value=''>----</option>
                    						@foreach($data as $dat)
                    							<option value="{{$dat->id}}">{{$dat->name}}</option>
                    						@endforeach
                    					</select>
                    				</div>
                    			</div>
                    			<div class="mws-form-row">
                                    <label class="mws-form-label">Read Privilages</label>
                                    <div class="mws-form-item">
                                        <div class="r_privilege_lvl"></div>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Write Privilages</label>
                                    <div class="mws-form-item">
                                        <div class="w_privilege_lvl"></div>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Excecute Privilages</label>
                                    <div class="mws-form-item">
                                        <div class="x_privilege_lvl"></div>
                                    </div>
                                </div>
                    		</div>
							
							
							<div class="mws-form-row">
								<label class="mws-form-label">Name</label>
								<div class="mws-form-item">
									<input type="text" class="medium privilage_new_name" name="name">
								</div>
							</div>
							
                    	</form>
                    </div>    	
                </div>

<div id="dialog-confirm" title="Delete this cms?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected Privilege Category and all its associations will be removed. Are you sure?</p>
</div>	

@stop