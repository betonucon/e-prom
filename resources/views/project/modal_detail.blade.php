<input type="hidden" name="id" value="{{$id}}">
<input type="hidden" name="kategori_ide" value="{{$kategori_ide}}">
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Keterangan </label>
	</div>
	<div class="col-lg-8">
		<input type="text" class="form-control form-control-sm"  name="nama_material" value="{{$data->nama_material}}" placeholder="Enter.....">
	</div>
	
</div>
@if($kategori_ide==1 || $kategori_ide==4)
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">@if($kategori_ide==4) Satuan Spec @else Satuan @endif</label>
	</div>
	<div class="col-lg-3">
		<input type="text" class="form-control form-control-sm"   name="satuan_material" value="{{$data->satuan_material}}" placeholder="Enter.....">
	</div>
	
</div>
@endif
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">@if($kategori_ide==1)Harga Satuan @else Biaya @endif</label>
	</div>
	<div class="col-lg-3">
		<input type="text" class="form-control form-control-sm" onkeyup="tentukan_biaya(this.value)" id="biaya" name="biaya" value="{{$data->biaya}}" placeholder="Enter.....">
	</div>
	
</div>
@if($kategori_ide!=4)
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Qty</label>
	</div>
	<div class="col-lg-2">
		<input type="text" onkeyup="tentukan_nilai(this.value)" class="form-control form-control-sm"  id="qty" name="qty" value="{{$data->qty}}" placeholder="Enter.....">
	</div>
	
</div>
@else
	<input type="hidden"  class="form-control form-control-sm"  id="qty" name="qty" value="1" placeholder="Enter.....">
@endif
<div class="row mb-1">
	<div class="col-lg-3 label-col">
		<label for="nameInput" class="form-label">Total</label>
	</div>
	<div class="col-lg-3">
		<input type="text" disabled class="form-control form-control-sm"  id="total" name="total" value="{{$data->total}}" placeholder="Enter.....">
	</div>
	
</div>




<script>
	var cleaveNumeral1=new Cleave("#biaya",{numeral:!0,numeralThousandsGroupStyle:"thousand"});
	var cleaveNumeral2=new Cleave("#qty",{numeral:!0,numeralThousandsGroupStyle:"thousand"});
	var cleaveNumeral3=new Cleave("#total",{numeral:!0,numeralThousandsGroupStyle:"thousand"});

	function tentukan_nilai(qty){
		var harga=$('#biaya').val();
		var nil = harga.replace(/,/g, "");
		var qt = qty.replace(/,/g, "");
		if(nil=="" || nil==0){
			alert('Masukan harga satuan');
			$('#qty').val(0);
		}else{
			var hasil=(qt*nil);
			

			$('#total').val(hasil);
			var cleaveNumeral3=new Cleave("#total",{numeral:!0,numeralThousandsGroupStyle:"thousand"});
		}

	}
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
