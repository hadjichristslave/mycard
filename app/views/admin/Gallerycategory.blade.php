@extends('templates.interface')
@section('content')


<div class="mws-panel grid_8 mws-collapsible">
                        <div class="mws-panel-header">
                            <span>Gallery categories edit</span>
                        </div>
                        <div class="mws-panel-body no-padding">
                            <form class="mws-form" action="form_elements.html">
                            	{{Form::token()}}
                                <div class="mws-form-inline">                                
                                    <div class="mws-form-row">
                                        <label class="mws-form-label">Gallery</label>
                                        <div class="mws-form-item">
                                            <select class="mws-select-tags small ajax-select2">
                                               @foreach($data as $dat)
													<option value="{{$dat->id}}">{{$dat->name}}</option>
												@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mws-form-row">
                    				<label class="mws-form-label">Current Tag Value</label>
                    				<div class="mws-form-item">
                                    	<input type="text" placeholder="current_val" name="newTagVal" id="tagValue" class="small"/>
                    				</div>
                    			</div>
                                   
                                </div>
                                <div class="mws-button-row">
                                    <input type="button" value="Modify" class="btn btn-warning gallcatmodify">
                                    <input type="button" value="Delete" class="btn btn-danger gallcatdelete">
                                    <input type="button" value="Create" class="btn btn-info  gallcatcreate">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

 
<div id="dialog-confirm" title="Delete this tag?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected page and all its associations will be removed. Are you sure?</p>
</div>


















@stop