<input type="hidden" name="id" value="{{$id}}">
<input type="hidden" name="kategori_ide" value="{{$kategori_ide}}">
<div class="row">
	<div class="col-12">
		<h5 class="text-decoration-underline mb-3 pb-1">Informasi Pekerjaan & Tagihan</h5>
	</div>
</div>
<div class="card">
    <div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="row mb-1">
					<div class="col-lg-12">
						<div class="alert alert-warning shadow shadow" role="alert">
							<strong>Perhatian </strong>,  Jika <b>Tipe tagihan</b> yaitu "<b><i>Tagihan dalam pekerjaan</i></b>" silahkan masukan nilai tagihan yang sudah diperhitungkan 
						</div>
					</div>
					
				</div>
			</div>
			<div class="col-md-12">
				<div class="row mb-1">
					<div class="col-lg-3 label-col">
						<label for="nameInput" class="form-label">Nama Pekerjaan</label>
					</div>
					<div class="col-lg-8">
						<div class="input-group input-group-sm">
							<span class="input-group-text">&nbsp;</span>
							<textarea class="form-control form-control-sm"  name="pekerjaan" value="" placeholder="Enter....." rows="4">{{$data->pekerjaan}}</textarea>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-md-12 mt-4">
				<div class="row mb-1">
					<div class="col-lg-3 label-col">
						<label for="nameInput" class="form-label">Mulai & Sampai</label>
					</div>
					<div class="col-lg-4">
						<div class="input-group input-group-sm">
							<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
							<input class="form-control form-control-sm flatpic"  name="mulai" value="{{$data->mulai}}" placeholder="Enter....." rows="4">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="input-group input-group-sm">
							<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
							<input class="form-control form-control-sm flatpic"  name="sampai" value="{{$data->sampai}}" placeholder="Enter....." rows="4">
						</div>
					</div>
					
				</div>
			</div>
			<div class="col-md-12">
				<div class="row mb-1">
					<div class="col-lg-3 label-col">
						<label for="nameInput" class="form-label">Type Tagihan</label>
					</div>
					<div class="col-lg-5">
						<input class="form-control form-control-sm "  name="type_tagihan" value="{{$type_tagihan}}" placeholder="Enter....." type="hidden">
						@if($type_tagihan==1)
							<input class="form-control form-control-sm " disabled value="Tagihan dalam project" placeholder="Enter....." type="text">
						@else
							<input class="form-control form-control-sm " disabled value="Tagihan dalam pekerjaan" placeholder="Enter....." type="text">
						@endif
						
					</div>
					
				</div>
			</div>
			
			@if($type_tagihan==2)
			<div class="col-md-12">
				<div class="row mb-1">
					<div class="col-lg-3 label-col">
						<label for="nameInput" class="form-label">Nilai Tagihan</label>
					</div>
					<div class="col-lg-5">
						<div class="input-group input-group-sm">
							<span class="input-group-text"><i class="mdi mdi-contactless-payment"></i></span>
							<input class="form-control form-control-sm"  name="nilai_tagihan" value="{{$nilai_tagihan}}" placeholder="Enter....." id="nilai_tagihan">
						</div>
					</div>
					
				</div>
			</div>
			@endif
		</div>
	
	</div>
</div>


<script src="{{url_plug()}}/assets/js/flatpickr.js"></script>

<script>
	var cleaveNumeral=new Cleave("#nilai_tagihan",{numeral:!0,numeralThousandsGroupStyle:"thousand"});
	$('.flatpic').flatpickr({
		enableTime: true,
		dateFormat: "Y-m-d",
		
	});
	
	function pilih_type_bayar(qty){
		
		if(qty==1){
			$('.tipe1').show();
			$('.tipe2').hide();
		}else{
			if(qty==2){
				$('.tipe1').hide();
				$('.tipe2').show();
			}else{
				
			}
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
