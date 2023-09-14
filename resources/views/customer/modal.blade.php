<input type="hidden" name="id" value="{{$id}}">
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Customer Code</label>
	</div>
	<div class="col-lg-3">
		<input type="text" class="form-control form-control-sm" {{$disabled}} onkeypress="return hanyaAngka(event)" name="customer_code" value="{{$data->customer_code}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Customer </label>
	</div>
	<div class="col-lg-6">
		<input type="text" class="form-control form-control-sm"  name="customer" value="{{$data->customer}}" placeholder="Enter.....">
	</div>
	
</div>
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Alamat</label>
	</div>
	<div class="col-lg-9">
		<input type="text" class="form-control form-control-sm"  name="alamat" value="{{$data->alamat}}" placeholder="Enter.....">
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
