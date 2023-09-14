<input type="hidden" name="id" value="{{$id}}">
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Username</label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm" onkeypress="return hanyaAngka(event)" name="username" value="{{$data->username}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Name </label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm"  name="name" value="{{$data->name}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Email</label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm"  name="email" value="{{$data->email}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">User Role</label>
	</div>
	<div class="col-lg-6">
		<select class="form-select form-select-sm" name="role_id" >
			<option value="">Select --</option>
			<option value="1">Admin</option>
			<option value="2">User Monitoring</option>
			
		</select>
		
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-4 label-col">
		<label for="nameInput" class="form-label">Password</label>
	</div>
	<div class="col-lg-8">
		<input type="password" class="form-control form-control-sm"  name="password" value="{{$data->password}}" placeholder="Enter.....">
	</div>
	
</div>


<script>
	function hanyaAngka(evt) {
				
				var charCode = (evt.which) ? evt.which : event.keyCode
				if ((charCode > 47 && charCode < 58 ) || (charCode > 96 && charCode < 123 ) || charCode==95 ){
					
					return true;
				}else{
					return false;
				}
		
				// 	return false;
				// return true;
				// alert(charCode)
			}
</script>
