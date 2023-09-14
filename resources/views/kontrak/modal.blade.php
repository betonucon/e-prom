<input type="hidden" name="id" value="{{$id}}">
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">NIK</label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm" {{$disabled}} onkeypress="return hanyaAngka(event)" name="nik" value="{{$data->nik}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Nama </label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm"  name="nama" value="{{$data->nama}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Email</label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm"  name="email" value="{{$data->email}}" placeholder="Enter.....">
	</div>
	
</div>

<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Jabatan</label>
	</div>
	<div class="col-lg-6">
		<select class="form-select form-select-sm" name="jabatan_id" >
			<option value="">Select --</option>
			@foreach(get_jabatan() as $jb)
				<option value="{{$jb->id}}" @if($data->jabatan_id==$jb->id) selected @endif >{{$jb->jabatan}}</option>
			@endforeach
			
		</select>
		
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Otorisasi Sistem</label>
	</div>
	<div class="col-lg-6">
		<select class="form-select form-select-sm" name="role_id" >
			<option value="">Select --</option>
			@foreach(get_role() as $jb)
				<option value="{{$jb->id}}" @if($data->role_id==$jb->id) selected @endif >{{$jb->role}}</option>
			@endforeach
			
		</select>
		
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
