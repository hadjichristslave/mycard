@extends('templates.interface')
@section('content')


	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span>Cms Category Privileges</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form class="mws-form" action="form_layouts.html">
                    		{{Form::token()}}
                    		<div class="mws-form-inline">
                    			<div class="mws-form-row">
                    				<label class="mws-form-label">Dropdown List</label>
                    				<div class="mws-form-item">
                    					<select class="large" id="cms_cat_names">
                    						<option value=''>----</option>
                    						@foreach($data as $dat)
                    							<option value="{{$dat->cms_cat_id}}">{{Cmscategory::find($dat->cms_cat_id)->name}}</option>
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
                    	</form>
                    </div>    	
                </div>



@stop