<input type="hidden" name="id" value="{{$id}}">
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Field Name</label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm" name="field_name" value="{{$data->field_name}}" placeholder="Enter First Name">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Field Type & Length</label>
	</div>
	<div class="col-lg-5">
		<select class="form-select form-select-sm" onchange="cari_type(this.value)" name="field_type" >
			<option value="">Select --</option>
			@foreach(get_type_field() as $fil)
				<option value="{{$fil->field}}" @if($data->field_type==$fil->field) selected @endif >{{$fil->field}}</option>
			@endforeach
		</select>
		
	</div>
	<div class="col-lg-3">
		<input type="text" class="form-control form-control-sm" name="field_length" value="{{$data->field_length}}" placeholder="1 - 1000">
	</div>
</div>
<div class="row mb-1 date-format">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Date Format</label>
	</div>
	<div class="col-lg-4">
		<input type="text" class="form-control form-control-sm" name="date_format" value="{{$data->date_format}}" placeholder="YYYY-MM-DD">
	</div>
</div>
<div class="row mb-1 multiple-format">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Multiple</label>
	</div>
	<div class="col-lg-4 label-col">
		<select class="form-select form-select-sm" name="is_multiple" >
			<option value="N" @if($data->is_multiple=='N') selected @endif >NO</option>
			<option value="Y" @if($data->is_multiple=='Y') selected @endif >YES</option>
			
		</select>
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Required</label>
	</div>
	<div class="col-lg-4 label-col">
		<select class="form-select form-select-sm" name="is_required" >
			<option value="N" @if($data->is_required=='N') selected @endif >Yes Null</option>
			<option value="Y" @if($data->is_required=='Y') selected @endif >Not Null</option>
			
		</select>
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Parent </label>
	</div>
	<div class="col-lg-5">
		<select class="form-select form-select-sm" name="parent_id" >
			<option value="">No Parent --</option>
			@foreach(get_paren($service_id) as $fil)
				<option value="{{$fil->id}}" @if($data->parent_id==$fil->id) selected @endif >{{$fil->field_name}}</option>
			@endforeach
		</select>
		
	</div>
	
</div>


<script>
	@if($id==0)
		$('.date-format').hide();
		$('.multiple-format').hide();
	@else
		@if($data->field_type=='header')
			$('.multiple-format').show();
			$('.date-format').hide();
		@elseif($data->field_type=='date' || $data->field_type=='datetime')
			$('.date-format').show();
			$('.multiple-format').hide();
		@else

		@endif
	@endif
	function cari_type(id){
		if(id=='header'){
			$('.multiple-format').show();
			$('.date-format').hide();
		}else{
			if(id=='datetime' || id=='date'){
				$('.date-format').show();
				$('.multiple-format').hide();
			}else{
				$('.date-format').hide();
				$('.multiple-format').hide();
			}
		}
		
	}
</script>
