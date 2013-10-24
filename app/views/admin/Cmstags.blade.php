@extends('templates.interface')
@section('content')

			<div class="mws-panel grid_8 mws-collapsible">
				<div class="mws-panel-header">
					<span>App tags</span>
					<div class="mws-button-row" style="float:right;margin:-27px 35px 0 0">
							<input type="button" value="Modify" class="btn btn-warning tagmodify">
							<input type="button" value="Delete" class="btn btn-danger tagdelete">
							<input type="button" value="Create" class="btn btn-info  tagcreate">
					</div>
				</div>
				<div class="mws-panel-body no-padding">
					<form class="mws-form" action="form_elements.html">
						{{Form::token()}}
						<div class="mws-form-inline">                                
							<div class="mws-form-row">
								<label class="mws-form-label">Tags</label>
								<div class="mws-form-item">
									<select class="mws-select-tags small pagesSelector ajax-select2">
									   @foreach($data as $dat)
											<option value="{{$dat->id}}">{{Cmstags::find($dat->id)->name}}</option>
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
					</form>
				</div>
			</div>

 
<div id="dialog-confirm" title="Delete this tag?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The selected tag and all its associations will be removed. Are you sure?</p>
</div>
 
@stop
