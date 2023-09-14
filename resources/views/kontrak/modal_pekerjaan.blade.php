<input type="hidden" name="id" value="{{$id}}">
<input type="hidden" name="kategori_ide" value="{{$kategori_ide}}">
<div >
	<div class="row">
		<div class="col-md-12">
			<label for="disabledInput" class="form-label">Pekerjaan</label>
			<div class="input-group">
				<span class="input-group-text">&nbsp;</span>
				<textarea class="form-control form-control-sm"  name="pekerjaan" value="" placeholder="Enter....." rows="4">{{$data->pekerjaan}}</textarea>
			</div>
		</div>
		<div class="col-md-5">
			<label for="disabledInput" class="form-label">Mulai</label>
			<div class="input-group">
				<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
				<input class="form-control form-control-sm flatpic"  name="mulai" value="{{$data->mulai}}" placeholder="Enter....." rows="4">
			</div>
		</div>
		<div class="col-md-5">
			<label for="disabledInput" class="form-label">Sampai</label>
			<div class="input-group">
				<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
				<input class="form-control form-control-sm flatpic"  name="sampai" value="{{$data->sampai}}" placeholder="Enter....." rows="4">
			</div>
		</div>
	</div>
	
</div>

<script src="{{url_plug()}}/assets/js/flatpickr.js"></script>

<script>
	
	$('.flatpic').flatpickr({
		enableTime: true,
		dateFormat: "Y-m-d",
		
	});
	
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
