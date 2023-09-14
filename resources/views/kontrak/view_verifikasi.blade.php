@extends('layouts.app')

@push('datatable')
<style>
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		color: var(--vz-nav-tabs-link-active-color);
		background-color: #e5e5e9 !important;
		border-color: #d0d4d7 var(--vz-gray-300) var(--vz-nav-tabs-link-active-bg) !important;
	}
	.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
		width: 100%;
		border: solid 1px #e2e2e3 !important;
	}
	table.table-bordered.dataTable thead tr:first-child th, table.table-bordered.dataTable thead tr:first-child td {
      border-top-width: 1px;
	  font-size:12px;
  	}
	  .label-col .form-label {
		padding: 3%;
		width: 100% !important;
		text-align: right !important;
		vertical-align: middle;
	}
	.text-right{
		text-align:right !important;
	}
</style>
        
    <script type="text/javascript">
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        
                
                
                
            

		function pilih_customer(customer_code,customer,cost,cost_center){
           
           $('#modal-customer').modal('hide');
           $('#customer_name').val(customer);
           $('#customer_code').val(customer_code);
           $('#cost').val(cost);
           $('#cost_center').val(cost_center);
           
        }  
		function pilih_employe(nik,nama){
           
           $('#modal-pm').modal('hide');
           $('#nik_pm').val(nik);
           $('#nama_pm').val(nama);
           
        }  

		function load_log(){ 
			$.ajax({ 
					type: 'GET', 
					url: "{{ url('project/getdatalog')}}?id={{encoder($data->id)}}", 
					data: { idee: 1 }, 
					dataType: 'json',
					
					success: function (show) {
						$.each(show.data, function(i, result){
								$("#tampil-log").append('<div class="d-flex mb-4">'
															+'<div class="flex-shrink-0">'
																+'<img src="{{url_plug()}}/img/akun.png" alt="" class="avatar-xs rounded-circle shadow" />'
															+'</div>'
															+'<div class="flex-grow-1 ms-3">'
																+'<h5 class="fs-13"><a href="javascript: void(0);" class="text-body">'+result.role+'</a> <small class="text-muted">24 Dec 2021 - 05:20PM</small></h5>'
																+'<p class="text-muted">'+result.deskripsi+'</p>'
															+'</div>'
														+'</div>');
						});
					}
				});
			
		}
        $(document).ready(function() {
			
			load_log();
				var table=$('#data-table-fixed-header').DataTable({
						searching:true,
						lengthChange:false,
						fixedHeader: {
							header: true,
							headerOffset: $('#header').height()
						},
						responsive: true,
						ajax:"{{ url('customer/getdata')}}",
						columns: [
							{ data: 'seleksi_kontrak' },
							{ data: 'customer_code' },
							{ data: 'customer' },
							
						],
						
               	});
			
                var employe=$('#data-employe-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
					
                    ajax:"{{ url('employe/getdata')}}?crt=1",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'nik' },
						{ data: 'nama' },
						{ data: 'jabatan' },
						{ data: 'seleksi' },
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
                });

				var datapekerjaan=$('#data-pekerjaan-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: false,
					dom: 'lrtip',
                    ajax:"{{ url('project/getdatapekerjaan')}}?id={{$id}}",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'pekerjaan' },
						{ data: 'action' },
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
                });
				$('#cari_datapekerjaan').keyup(function(){
                  datapekerjaan.search($(this).val()).draw() ;
                })

                var datajasa=$('#data-jasa-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: false,
					dom: 'lrtip',
                    ajax:"{{ url('project/getdatadetail')}}?id={{$id}}&ctr=1",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'nama_material' },
						{ data: 'biaya' ,className: "text-right" },
						{ data: 'satuan_material' },
						{ data: 'qty',className: "text-right" },
						{ data: 'total',className: "text-right"  },
						
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
                });
				$('#cari_datajasa').keyup(function(){
                  datajasa.search($(this).val()).draw() ;
                })
				
                var datamaterial=$('#data-material-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
					dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('project/getdatadetail')}}?id={{$id}}&ctr=3",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'nama_material' },
						{ data: 'biaya' ,className: "text-right" },
						{ data: 'satuan_material' },
						{ data: 'qty',className: "text-right" },
						{ data: 'total',className: "text-right"  },
						
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
                });
				$('#cari_datamaterial').keyup(function(){
                  datamaterial.search($(this).val()).draw() ;
                })
				
                var dataoperasional=$('#data-operasional-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
					dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('project/getdatadetail')}}?id={{$id}}&ctr=2",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'nama_material' },
						{ data: 'biaya' ,className: "text-right" },
						{ data: 'satuan_material' },
						{ data: 'qty',className: "text-right" },
						{ data: 'total',className: "text-right"  },
						
						
					],
					
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
                });
				$('#cari_dataoperasional').keyup(function(){
                  dataoperasional.search($(this).val()).draw() ;
                })
                var dataspec=$('#data-spec-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
					dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('project/getdatadetail')}}?id={{$id}}&ctr=4",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'nama_material' },
						{ data: 'biaya' ,className: "text-right" },
						{ data: 'satuan_material' },
						{ data: 'total',className: "text-right"  },
						
						
					],
					
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
                });
				$('#cari_dataspec').keyup(function(){
                  dataspec.search($(this).val()).draw() ;
                })
				$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
					if (e.target.hash == '#datamaterial') {
						datamaterial.columns.adjust().draw()
					}
					if (e.target.hash == '#dataoperasional') {
						dataoperasional.columns.adjust().draw()
					}
					if (e.target.hash == '#datajasa') {
						datajasa.columns.adjust().draw()
					}
					if (e.target.hash == '#dataspec') {
						dataspec.columns.adjust().draw()
					}
					if (e.target.hash == '#datapekerjaan') {
						datapekerjaan.columns.adjust().draw()
					}
				})
					
		});

		
    </script>
@endpush
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">VIEW SERVICE</h4>
					<div class="page-title-right">
						<span onclick="location.assign(`{{url('project')}}`)" class="btn btn-danger btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Back</span>
					</div>
				</div>
			</div>
		</div>
		<form  id="mydata" method="post" action="{{ url('project/store_verifikasi') }}" enctype="multipart/form-data" >
            @csrf
			<!-- <input type="submit"> -->
			<input type="hidden" name="id" value="{{$id}}">
			<div class="row">
                <div class="col-lg-12">

				</div>
                <div class="col-lg-9">
					<div class="card" >
						<div class="card-body">
							<span class="ribbon-three ribbon-three-success"><span>PROJECT</span></span>
							<div class="text-muted mb-5">
								<h6 class="mb-3 fw-semibold text-uppercase">&nbsp;</h6>
								<ul class="nav nav-tabs mb-3" role="tablist">
								
								
									<li class="nav-item">
										<a class="nav-link active" data-bs-toggle="tab" href="#dataproject" role="tab" aria-selected="false">
											<i class="mdi mdi-book-check"></i> Deskripsi Project
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#datalog"  role="tab" aria-selected="false">
											<i class="mdi mdi-book-check"></i> Riwayat
										</a>
									</li>
								</ul>
								<div class="tab-content  text-muted" style="padding: 5% 2%; border: solid 1px #ececef;">
								
									<div class="tab-pane active" id="dataproject" role="tabpanel">
										<p>Deskripsi project / Rencana Project</p>

										<div class="table-responsive table-card">
											<table class="table table-borderless mb-0">
												<tbody>
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="20%"><b>Customer</b></td>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="3%"><b>:</b></td>
														<td style="padding: 3px 16px;" >{{$data->customer}}</td>
													</tr>
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Nama Project</b></td>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
														<td style="padding: 3px 16px;" >{{$data->deskripsi_project}}</td>
													</tr>
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Nilai Project</b></td>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
														<td style="padding: 3px 16px;" >Rp.{{uang($data->nilai_project)}}</td>
													</tr>
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Kategori Project</b></td>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
														<td style="padding: 3px 16px;" >{{$data->kategori_project}} ({{$data->keterangan_tipe_project}})</td>
													</tr>
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Waktu Project</b></td>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
														<td style="padding: 3px 16px;" >{{$data->start_date}} S/D {{$data->end_date}} ({{$data->selisih}} Hari) </td>
													</tr>
													
												</tbody>
											</table>
										</div>
									</div>
									<div class="tab-pane" id="datalog" role="tabpanel">
										<div data-simplebar style="height: 308px;" class="px-3 mx-n3 mb-2">
											<div id="tampil-log"></div>
										</div>
									</div>
								</div>
								
								<div class="tab-content  text-muted" style="margin-top:2%;padding: 2% 2%; border: solid 1px #ececef;">
									
									<div class="tab-pane active"  role="tabpanel">
									<span class="ribbon-three ribbon-three-success"><span>PROJECT</span></span>
										<p>Verifikasi Hasil</p>

										
										<div class="row mb-1">
											<div class="col-lg-3 label-col">
												<label for="nameInput" class="form-label">Hasil Pengajuan </label>
											</div>
											<div class="col-lg-5">
												<div class="input-group input-group-sm">
													<span class="input-group-text" id="inputGroup-sizing-sm" ><i class="mdi mdi-arrow-down-drop-circle-outline"></i></span>
													<select name="status_id" onchange="pilih_status(this.value)" class="form-control form-control-sm" placeholder="0000">
														<option value="">Pilih------</option>
														<option value="8">Lanjut dan Proses Kontrak</option>
														<option value="50">Dibatalkan / Cancel</option>
														
													</select>
												</div>
											</div>
											
										</div>
										<div class="alasan_cancel row mb-1" >
											<div class="col-lg-3 label-col">
												<label for="nameInput" class="form-label">Alasan dibatalkan </label>
											</div>
											<div class="col-lg-7">
												<div class="input-group">
													<span class="input-group-text">&nbsp;</span>
													<textarea class="form-control form-control-sm"  name="catatan_dibatalkan" value="" placeholder="Enter....." rows="4">{{$data->catatan}}</textarea>
												</div>
											</div>
											
										</div>
										<div class="alasan_lanjut row mb-1">
											<div class="col-lg-3 label-col">
												<label for="nameInput" class="form-label" id="form-label-header">Cost Center</label>
											</div>
											<div class="col-lg-3" id="view_cost_center">
												<div class="input-group input-group-sm">
													<input type="text"   id="cost_center" class="form-control" placeholder="Cost Center" name="cost_center" value="{{penomoran_cost_center($data->customer_code)}}">
												</div>
											</div>
											
										</div>
										<div class="alasan_lanjut row mb-1">
											<div class="col-lg-3 label-col">
												<label for="nameInput" class="form-label" id="form-label-header">No Kontrak</label>
											</div>
											<div class="col-lg-5" id="view_cost_center">
												<div class="input-group input-group-sm">
													<input type="text"   id="no_kontrak" class="form-control" placeholder="00000000000" name="no_kontrak" value="{{$data->no_kontrak}}">
												</div>
											</div>
											
										</div>
										<div class="alasan_lanjut row mb-1" >
											<div class="col-lg-3 label-col">
												<label for="nameInput" class="form-label" id="form-label-header">Project Manager</label>
											</div>
											<div class="col-lg-3">
												<div class="input-group input-group-sm">
													<span class="input-group-text" id="inputGroup-sizing-sm" onclick="show_pm()"><i class="mdi mdi-search-web"></i></span>
													<input type="text" readonly id="nik_pm" class="form-control" placeholder="" name="nik_pm" value="{{$data->nik_pm}}">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="input-group input-group-sm">
													<input type="text" readonly  id="nama_pm" class="form-control" placeholder="Nama Project Manager" name="nama_pm" value="{{$data->nama_pm}}">
												</div>
											</div>
											
										</div>
										<div class="alasan_lanjut row mb-1" >
											<div class="col-lg-3 label-col">
												<label for="nameInput" class="form-label">Dokumen Kontrak </label>
											</div>
											<div class="col-lg-4">
												<input type="file" class="form-control form-control-sm"  name="file" value="{{$data->deskripsi_project}}" placeholder="Enter.....">
											</div>
											
										</div>
										
									</div>
									<div class="tab-pane" id="datalog" role="tabpanel">
										<div data-simplebar style="height: 308px;" class="px-3 mx-n3 mb-2">
											<div id="tampil-log"></div>
										</div>
									</div>
								</div>

								
							</div>
							<div class="row mt-2">
								<div class="col-lg-12">
									<span  class="btn btn-primary btn-label waves-effect waves-light" id="save-verifikasi"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Verifikasi</span>
								</div>
								
							</div>
						</div>
					</div>



					<div class="card">
						<div class="card-body">
							<p class="text-muted">Rincian Pembiayaan dan Standar Harga </p>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs mb-3" role="tablist">
								
								<li class="nav-item">
									<a class="nav-link active" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab" href="#dataoperasional" @endif  role="tab" aria-selected="false">
										<i class="mdi mdi-book-check"></i> Operasional
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab" href="#datamaterial" @endif  role="tab" aria-selected="false">
										<i class="mdi mdi-book-check"></i> Material Project
									</a>
								</li>
								
								<li class="nav-item">
									<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab"  href="#datajasa" @endif  role="tab" aria-selected="false">
										<i class="mdi mdi-book-check"></i> Jasa Project
									</a>
								</li>
								@if($data->tipe_project_id==1)
								<li class="nav-item">
									<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab"  href="#dataspec" @endif  role="tab" aria-selected="false">
										<i class="mdi mdi-book-check"></i> Spare Spec
									</a>
								</li>
								@endif
							</ul>
							
							<div class="tab-content  text-muted" style="padding: 0.8%; border: solid 1px #ececef;">
								
								<div class="tab-pane active" id="datamaterial" role="tabpanel">
									<div class="row">
										<div class="col-md-8">
											
										</div>
										<div class="col-md-4">
											<div class="mb-2">
												<input type="text" class="form-control" id="cari_datamaterial" placeholder="cari......">
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table id="data-material-fixed-header" class="table table-bordered table-striped align-middle" style="width:100%">
											<thead>
												<tr>
													<th width="3%"></th>
													<th >Keterangan</th>
													<th width="15%">H.Satuan</th>
													<th width="14%">Satuan</th>
													<th width="10%">Qty</th>
													<th width="10%">Total</th>
												</tr>
											</thead>
											
										</table>
									</div>
								</div>
								<div class="tab-pane" id="dataoperasional" role="tabpanel">
									<div class="row">
										<div class="col-md-8">
											
										</div>
										<div class="col-md-4">
											<div class="mb-2">
												<input type="text" class="form-control" id="cari_dataoperasional" placeholder="cari......">
											</div>
										</div>
									</div>
									<table id="data-operasional-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
										<thead>
											<tr>
												<th width="4%"></th>
												<th >Keterangan</th>
												<th width="10%">H.Satuan</th>
												<th width="14%">F(X)</th>
												<th width="10%">Qty</th>
												<th width="10%">Total</th>
											</tr>
										</thead>
										
									</table>
								</div>
								<div class="tab-pane" id="datajasa" role="tabpanel">
									<div class="row">
										<div class="col-md-8">
											
										</div>
										<div class="col-md-4">
											<div class="mb-2">
												<input type="text" class="form-control" id="cari_datajasa" placeholder="cari......">
											</div>
										</div>
									</div>
									<table id="data-jasa-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
										<thead>
											<tr>
												<th width="4%"></th>
												<th >Keterangan</th>
												<th width="10%">H.Satuan</th>
												<th width="14%">F(X)</th>
												<th width="10%">Qty</th>
												<th width="10%">Total</th>
											</tr>
										</thead>
										
									</table>
								</div>
								<div class="tab-pane" id="dataspec" role="tabpanel">
									<div class="row">
										<div class="col-md-8">
											
										</div>
										<div class="col-md-4">
											<div class="mb-2">
												<input type="text" class="form-control" id="cari_dataspec" placeholder="cari......">
											</div>
										</div>
									</div>
									<table id="data-spec-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
										<thead>
											<tr>
												<th width="4%"></th>
												<th >Keterangan</th>
												<th width="10%">H.Satuan</th>
												<th width="14%">Satuan</th>
												<th width="10%">Total</th>
											</tr>
										</thead>
										
									</table>
								</div>
							</div>
							
						</div><!-- end card-body -->
					</div>
					<div class="card">
						<div class="card-body">
							<p class="text-muted">Rencana Pekerjaan </p>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs mb-3" role="tablist">
								
								<li class="nav-item">
									<a class="nav-link active" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab"  href="#datapekerjaan" @endif  role="tab" aria-selected="false">
										<i class="mdi mdi-book-check"></i> Rencana Pekerjaan
									</a>
								</li>
								
							</ul>
							
							<div class="tab-content  text-muted" style="padding: 0.8%; border: solid 1px #ececef;">
								<div class="tab-pane active" id="datapekerjaan" role="tabpanel">
									<div class="row">
										<div class="col-md-8">
										</div>
										<div class="col-md-4">
											<div class="mb-2">
												<input type="text" class="form-control" id="cari_datapekerjaan" placeholder="cari......">
											</div>
										</div>
									</div>
									<table id="data-pekerjaan-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
										<thead>
											<tr>
												<th width="4%"></th>
												<th >Pekerjaan</th>
												<th width="3%"></th>
											</tr>
										</thead>
										
									</table>
								</div>
								
							</div>
							
						</div><!-- end card-body -->
					</div>
				</div>
				<div class="col-lg-3">
					<div class="card">
						
						<div class="card-body">
							<span class="ribbon-three ribbon-three-success"><span>PROFIL</span></span>
							<ul class="list-unstyled mb-0 vstack gap-3 mt-4">
								<li>
									<div class="d-flex align-items-center">
										<div class="flex-shrink-0">
											<img src="{{url_plug()}}/img/akun.png" alt="" class="avatar-sm rounded shadow">
										</div>
										<div class="flex-grow-1 ms-3">
											<h6 class="fs-14 mb-1">{{$data->createby}}</h6>
											<p class="text-muted mb-0"><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i> {{$data->email}}</p>
										</div>
									</div>
								</li>
								
							</ul>
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Pembiayaan</h5>
						</div>
						<div class="card-body mb-3">
							<div class="table-responsive table-card">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row" width="20%"><b>B.Material</b></td>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row" width="21%"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_material)}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>B.operasional</b></td>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_operasional)}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>B.jasa</b></td>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_jasa)}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;text-align:right" colspan="3"><hr></td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>Total</b></td>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_total)}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Estimasi Project</h5>
						</div>
						<div class="card-body mb-3">
							<div class="table-responsive table-card">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row" width="20%"><b>Nilai Project</b></td>
											<td style="padding: 3px 4px;"  class="fw-medium" scope="row" width="25%"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->nilai_project)}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row" width="20%"><b>M.Perusahaan</b></td>
											<td style="padding: 3px 4px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang(($data->nilai_project/setting_value(1))/100)}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row" width="20%"><b>M.Sales</b></td>
											<td style="padding: 3px 4px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang(($data->nilai_project/setting_value(2))/100)}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>B.Project</b></td>
											<td style="padding: 3px 4px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_total)}}</td>
										</tr>
										
										<tr>
											<td style="padding: 3px 9px;text-align:right" colspan="3"><hr></td>
										</tr>
										<tr>
											<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>S.Total</b></td>
											<td style="padding: 3px 4px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
											<td style="padding: 3px 9px;text-align:right" >{{uang($data->nilai_project-($data->b_total+(($data->nilai_project/setting_value(1))/100)+(($data->nilai_project/setting_value(2))/100)))}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			
		</form>
	</div>
</div>
<div id="modal-approve" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel"><i class="ri-mail-send-fill"></i> Approve</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form  id="mydataschema" method="post" action="{{ url('project/approve') }}" enctype="multipart/form-data" >
            		@csrf
					<input type="hidden" name="id" value="{{$data->id}}">
						<div class="mt-3">
							<div class="avatar-sm mx-auto">
								<div class="avatar-title bg-light text-success display-5 rounded-circle"><i class="ri-mail-send-fill"></i></div>
							</div>
							<div class="mt-4 pt-2 fs-15" style="text-align: center;">
								<h4 class="fs-20 fw-semibold">Verifikasi / Approve Prencanaan</h4>
								<p class="text-muted mb-0 mt-3 fs-13">Proses approval jika lanjut proses akan diteruskan ke tahap berikutnya dan jika revisi dokumen akan dikembalikan keproses awal</p>
							</div>
						</div>
						<div>
							<label for="disabledInput" class="form-label">Status Approve</label>
							<div class="input-group">
								<span class="input-group-text" id="inputGroup-sizing-sm" ><i class="mdi mdi-arrow-down-drop-circle-outline"></i></span>
								<select name="status_id" class="form-control form-control-sm" placeholder="0000">
									<option value="">Pilih-------</option>
									<option value="1">Setujui dan Lanjut</option>
									<option value="2">Revisi dan Perbaiki</option>
									
								</select>
							</div>
						</div>
						<div id="alasan">
							<label for="disabledInput" class="form-label">Catatan Revisi</label>
							<div class="input-group">
								<span class="input-group-text" id="inputGroup-sizing-sm" ><i class="mdi mdi-arrow-down-drop-circle-outline"></i></span>
								<select name="status_id" class="form-control form-control-sm" placeholder="0000">
									<option value="">Pilih-------</option>
									<option value="1">Setujui dan Lanjut</option>
									<option value="2">Revisi dan Perbaiki</option>
									
								</select>
							</div>
						</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary " id="save-schema">Proses</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<div id="modal-customer" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Customer</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table id="data-table-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="20%">Cust Code</th>
                            <th >Nama Customer</th>
                        </tr>
                    </thead>
                    
                </table>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<div id="modal-pm" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Project Manager</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table id="data-employe-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">NIK</th>
                            <th >Nama </th>
                            <th width="25%" >Jabatan</th>
                            <th width="5%" > </th>
                        </tr>
                    </thead>
                    
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<div id="modal-excel" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Import Excel</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="mydataimportmaterial" method="post" action="{{ url('project/store_import_material') }}" enctype="multipart/form-data" >
					@csrf
					<input type="submit">
					<input type="text" value="{{$id}}" name="id">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">File Excel</label>

						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon" ><i class="fa fa-file-excel-o"></i></span>
								<input type="file" id="file_excel_material" name="file_excel_material" readonly value="{{$data->start_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-success" onclick="simpan_import_material()">Proses</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<div id="modal-tambahdetail" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               
	<div class="modal-dialog" style="max-width:50%">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titleubah"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="mydatadetail" method="post" action="{{ url('project/store_import_material') }}" enctype="multipart/form-data" >
					@csrf
					<input type="hidden" name="project_header_id" value="{{$id}}">
					<div id="form-tambahdetail"></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-success" onclick="simpan_detail()">Proses</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
@endsection

@push('ajax')
		<script src="{{url_plug()}}/assets/libs/cleave.js/cleave.min.js"></script>
    <!-- form masks init -->
    	<script src="{{url_plug()}}/assets/js/pages/form-masks.init.js"></script>
        <script type="text/javascript">
			$('#alasan').hide();
			$('.alasan_cancel').hide();
			$('.alasan_lanjut').hide();
			
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
			function approve(){
           
				$('#modal-approve').modal('show');
				
			} 
			function pilih_status(id){
				if(id==50){
					$('.alasan_cancel').show();
					$('.alasan_lanjut').hide();
				}else{
					$('.alasan_cancel').hide();
					$('.alasan_lanjut').show();
				}
				
			} 
			function delete_data(id,kategori){
				Swal.fire({
				   title: "Yakin akan menghapus data ini ?",
				   text: "",
				   type: "warning",
				   icon: "info",
				   showCancelButton: true,
				   align:"center",
				   confirmButtonClass: "btn-danger",
				   confirmButtonText: "Yes",
				   closeOnConfirm: false
				   }).then((result) => {
					   if (result.isConfirmed) {
						   $.ajax({
							   type: 'GET',
							   url: "{{url('project/delete_detail')}}",
							   data: "id="+id+"&kategori="+kategori,
							   success: function(msg){
								   Swal.fire({
									   title: "Sukses direset",
									   type: "warning",
									   icon: "success",
									   
									   align:"center",
									   
								   });

								   if(kategori==1){
										var tables=$('#data-material-fixed-header').DataTable();
											tables.ajax.url("{{ url('project/getdatadetail')}}?id={{$id}}&ctr=3").load();
									}
									if(kategori==2){
										var tables=$('#data-operasional-fixed-header').DataTable();
											tables.ajax.url("{{ url('project/getdatadetail')}}?id={{$id}}&ctr=2").load();
									}
									if(kategori==3){
										var tables=$('#data-jasa-fixed-header').DataTable();
											tables.ajax.url("{{ url('project/getdatadetail')}}?id={{$id}}&ctr=1").load();
									}
							   }
						   });
						   
					   }
				   
			   });
			}
			
			function ubah_detail(id,kategori){
				if(kategori==1){
					$('#titleubah').html('Material')
				}
				if(kategori==2){
					$('#titleubah').html('Operasional')
				}
				if(kategori==3){
					$('#titleubah').html('Jasa')
				}
				if(kategori==4){
					$('#titleubah').html('Spec Spare')
				}
				$('#modal-tambahdetail').modal('show');
				$('#form-tambahdetail').load("{{url('project/modal_detail')}}?id="+id+"&kategori="+kategori);
				
			} 
			function show_import(){
           
				$('#modal-excel').modal('show');
				
			} 
			function show_pm(){
           
				$('#modal-pm').modal('show');
				
			} 
			
			function show_error(){
				Swal.fire({
					title:"Notifikasi",
					html:'Harap buat dahulu info projectnya ',
					icon:"info",
					confirmButtonText: 'Close',
					confirmButtonClass:"btn btn-info w-xs mt-2",
					buttonsStyling:!1,
					showCloseButton:!0
				});
			}
			
			$('#save-verifikasi').on('click', () => {
            
				var form=document.getElementById('mydata');
					$.ajax({
						type: 'POST',
						url: "{{ url('project/store_verifikasi') }}",
						data: new FormData(form),
						contentType: false,
						cache: false,
						processData:false,
						beforeSend: function() {
							document.getElementById("loadnya").style.width = "100%";
						},
						success: function(msg){
							var bat=msg.split('@');
							if(bat[1]=='ok'){
								document.getElementById("loadnya").style.width = "0px";
								Swal.fire({
									title:"Notifikasi",
									html:'Create project Succes ',
									icon:"success",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-info w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
								location.assign("{{url('project')}}");
							}else{
								document.getElementById("loadnya").style.width = "0px";
								Swal.fire({
									title:"Notifikasi",
									html:'<div style="background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>',
									icon:"error",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-danger w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
							}
							
							
						}
					});
			});


			function simpan_import_material(){
          
            
				var form=document.getElementById('mydataimportmaterial');
				
					
					$.ajax({
						type: 'POST',
						url: "{{ url('project/store_import_material') }}",
						data: new FormData(form),
						contentType: false,
						cache: false,
						processData:false,
						beforeSend: function() {
							document.getElementById("loadnya").style.width = "100%";
						},
						success: function(msg){
							var bat=msg.split('@');
							if(bat[1]=='ok'){
								document.getElementById("loadnya").style.width = "0px";
								Swal.fire({
									title:"Notifikasi",
									html:'Success ',
									icon:"success",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-info w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
								location.reload();
							}else{
								document.getElementById("loadnya").style.width = "0px";
								swal({
									title: 'Notifikasi',
									
									html:true,
									text:'ss',
									icon: 'error',
									buttons: {
										cancel: {
											text: 'Tutup',
											value: null,
											visible: true,
											className: 'btn btn-dangers',
											closeModal: true,
										},
										
									}
								});
								$('.swal-text').html('<div style="width:100%;background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>')
							}
							
							
						}
					});
        	}
			function simpan_detail(){
          
            
				var form=document.getElementById('mydatadetail');
				
					
					$.ajax({
						type: 'POST',
						url: "{{ url('project/store_detail') }}",
						data: new FormData(form),
						contentType: false,
						cache: false,
						processData:false,
						beforeSend: function() {
							document.getElementById("loadnya").style.width = "100%";
						},
						success: function(msg){
							var bat=msg.split('@');
							if(bat[1]=='ok'){
								document.getElementById("loadnya").style.width = "0px";
								Swal.fire({
									title:"Notifikasi",
									html:'Success ',
									icon:"success",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-info w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
								$('#modal-tambahdetail').modal('hide');
								$('#form-tambahdetail').html("");
								if(bat[2]==1){
									var tables=$('#data-material-fixed-header').DataTable();
          								tables.ajax.url("{{ url('project/getdatadetail')}}?id={{$id}}&ctr=3").load();
								}
								if(bat[2]==2){
									var tables=$('#data-operasional-fixed-header').DataTable();
          								tables.ajax.url("{{ url('project/getdatadetail')}}?id={{$id}}&ctr=2").load();
								}
								if(bat[2]==3){
									var tables=$('#data-jasa-fixed-header').DataTable();
          								tables.ajax.url("{{ url('project/getdatadetail')}}?id={{$id}}&ctr=1").load();
								}
								
							}else{
								document.getElementById("loadnya").style.width = "0px";
                                Swal.fire({
                                    title:"Notifikasi",
                                    html:'<div style="background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>',
                                    icon:"error",
                                    confirmButtonText: 'Close',
                                    confirmButtonClass:"btn btn-danger w-xs mt-2",
                                    buttonsStyling:!1,
                                    showCloseButton:!0
                                });
								
							}
							
							
						}
					});
        	}
			function reset_material(id){
               
			   Swal.fire({
				   title: "Yakin reset material ini ?",
				   text: "",
				   type: "warning",
				   icon: "info",
				   showCancelButton: true,
				   align:"center",
				   confirmButtonClass: "btn-danger",
				   confirmButtonText: "Yes",
				   closeOnConfirm: false
				   }).then((result) => {
					   if (result.isConfirmed) {
						   $.ajax({
							   type: 'GET',
							   url: "{{url('project/reset_material')}}",
							   data: "id="+id,
							   success: function(msg){
								   Swal.fire({
									   title: "Sukses direset",
									   type: "warning",
									   icon: "success",
									   
									   align:"center",
									   
								   });

								   location.reload();
							   }
						   });
						   
					   }
				   
			   });
		   
	   		}
    	</script>
@endpush
