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

		
        $(document).ready(function() {
			
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
                    ajax:"{{ url('kontrak/getdatapekerjaan')}}?id={{$id}}",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'pekerjaan' },
						{ data: 'created_at' },
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
                    ajax:"{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=1",
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
						{ data: 'created_at' },
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
                    ajax:"{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=3",
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
						{ data: 'created_at' },
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
                    ajax:"{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=2",
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
						{ data: 'created_at' },
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
                    ajax:"{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=4",
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
						{ data: 'created_at' },
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
						<span onclick="location.assign(`{{url('service')}}`)" class="btn btn-danger btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Back</span>
					</div>
				</div>
			</div>
		</div>
		<form  id="mydata" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
            @csrf
			<input type="submit">
			<input type="hidden" name="id" value="{{$id}}">
			<div class="card">
				<div class="card-body">
					<center><h4><u>MANAGEMENT PROJECT</u></h4></center>
					<div class="d-flex flex-wrap justify-content-evenly mt-3 mb-3">
						<p class="text-muted mb-0"><i class="mdi mdi-numeric-1-circle text-primary fs-24 align-middle me-2 rounded-circle shadow"></i>Penyusunan RABOB</p>
						<p class="text-muted mb-0"><i class="mdi mdi-numeric-2-circle text-warning fs-24 align-middle me-2 rounded-circle shadow"></i>Evaluasi Pimpinan</p>
						<p class="text-muted mb-0"><i class="mdi mdi-numeric-3-circle text-warning fs-24 align-middle me-2 rounded-circle shadow"></i>Progres Pekerjaan</p>
						<p class="text-muted mb-0"><i class="mdi mdi-numeric-4-circle text-warning fs-24 align-middle me-2 rounded-circle shadow"></i>Selesai</p>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="progress animated-progress custom-progress progress-label">
								<div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
									<div class="label">30%</div>
								</div>
							</div>
						</div>
						
					</div>
					<!-- Nav tabs -->
					<ul class="nav nav-tabs mb-3 mt-2" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true">
								<i class="mdi mdi-book-check"></i> Info Project
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab"  href="#datapekerjaan" @endif  role="tab" aria-selected="false">
								<i class="mdi mdi-book-check"></i> Rencana Pekerjaan
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab" href="#dataoperasional" @endif  role="tab" aria-selected="false">
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
					@if($id>0)
						@if($data->revisi==1)
							<h6>Revisi</h6>
							<div class="alert alert-warning alert-borderless shadow" role="alert">
								<strong> Catatan </strong> {!! $data->catatan_revisi !!}
							</div>
						@endif
					<div class="tab-content  text-muted" style="padding: 0.8%; border: solid 1px #ececef;">
						
							<div class="align-items-center p-3 justify-content-between d-flex">
								<div class="flex-shrink-0">
									<div class="text-muted">Format Excel Rabob <a href="">Download RABOB xlsx</a></div>
								</div>
								<div class="btn-group shadow" role="group" aria-label="Basic example">
									<button type="button" onclick="show_import()" class="btn btn-info btn-sm waves-effect waves-light shadow-none"><i class="ri-add-line align-middle me-1"></i> Import Excel</button>
									<button type="button" onclick="reset_material({{$id}})" class="btn btn-danger btn-sm waves-effect waves-light shadow-none"><i class="ri-add-line align-middle me-1"></i> Reset Data</button>
								</div>
								
							</div>
						
					</div>
					@endif
					<div class="tab-content  text-muted" style="padding: 0.8%; border: solid 1px #ececef;background: #fafaff;">
						<div class="tab-pane active" id="home" role="tabpanel">
							<h6>&nbsp;</h6>
							<div class="row"  >
								<div class="col-md-8"  >
									<div class="card"  >
										<div class="card-body">
											<span class="ribbon-three ribbon-three-success"><span>PROJECT</span></span>
											<div class="text-muted mb-5">
												<h6 class="mb-3 fw-semibold text-uppercase">&nbsp;</h6>
												
												<p>Deskripsi project / Rencana Project</p>

												<div class="row">
													<div class="col-md-12">
														<table class="table table-borderless mb-0">
															<tbody>
																<tr>
																	<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="24%"><b>Customer</b></td>
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
																<tr>
																	<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Status Project</b></td>
																	<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
																	<td style="padding: 3px 16px;" >{{$data->status}}</td>
																</tr>
																
															</tbody>
														</table>
													</div>
													
												</div>
											
												
											</div>
											<div class="row mt-2">
												<!-- <div class="col-lg-12">
													<span  class="btn btn-primary btn-label waves-effect waves-light" onclick="approve()"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Approve</span>
												</div> -->
												
											</div>
										</div>
									</div>
									<div class="card"  >
										<div class="card-body">
											<div class="text-muted mt-1">
												
												<p>Verifikasi Hasil</p>
												<div class="table-responsive table-card">
													
													<table class="table table-borderless mb-0">
														<tbody>
															<tr>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="24%"><b>Cost Center</b></td>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="3%"><b>:</b></td>
																<td style="padding: 3px 16px;" >{{$data->cost_center_project}}</td>
															</tr>
															<tr>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Nomor Kontrak</b></td>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
																<td style="padding: 3px 16px;" >{{$data->no_kontrak}}</td>
															</tr>
															<tr>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Approve Kontrak</b></td>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
																<td style="padding: 3px 16px;" >{{tanggal_indo_full($data->approve_kontrak)}}</td>
															</tr>
															@if($data->file_kontrak!="")
															<tr>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Dokumen Kontrak</b></td>
																<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
																<td style="padding: 3px 16px;" ><span onclick="window.open(`{{url_plug()}}/attach/kontrak/{{$data->file_kontrak}}`)"class="badge badge-soft-secondary badge-border">{{$data->file_kontrak}}</span></td>
															</tr>
															@endif
															
														</tbody>
													</table>
												</div>
														
														
														
													
												
												
											</div>
											<div class="row mt-2">
												<!-- <div class="col-lg-12">
													<span  class="btn btn-primary btn-label waves-effect waves-light" onclick="approve()"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Approve</span>
												</div> -->
												
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
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
															<p class="text-muted mb-0"> {{$data->email}}</p>
														</div>
													</div>
												</li>
												
											</ul>
										</div>
									</div>
									
									<div class="card">
										
										<div class="card-body">
											<ul class="list-unstyled mb-0 vstack gap-3">
												<li>
													<div class="d-flex align-items-center">
														<div class="flex-shrink-0">
															<img src="{{url_plug()}}/img/akun.png" alt="" class="avatar-sm rounded shadow">
														</div>
														<div class="flex-grow-1 ms-3">
															<h6 class="fs-14 mb-1">{{$data->nama_pm}}</h6>
															<p class="text-muted mb-0"> NIK : {{$data->nik_pm}}</p>
															<p class="text-muted mb-0"> Project Management</p>
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
															<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_material_kontrak)}}</td>
														</tr>
														<tr>
															<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>B.operasional</b></td>
															<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
															<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_operasional_kontrak)}}</td>
														</tr>
														<tr>
															<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>B.jasa</b></td>
															<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
															<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_jasa_kontrak)}}</td>
														</tr>
														<tr>
															<td style="padding: 3px 9px;text-align:right" colspan="3"><hr></td>
														</tr>
														<tr>
															<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>Total</b></td>
															<td style="padding: 3px 9px;"  class="fw-medium" scope="row"><b>: Rp.</b></td>
															<td style="padding: 3px 9px;text-align:right" >{{uang($data->b_total_kontrak)}}</td>
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
															<td style="padding: 3px 9px;text-align:right" >{{uang($data->nilai_project-($data->b_total+(($data->nilai_kontrak/setting_value(1))/100)+(($data->nilai_kontrak/setting_value(2))/100)))}}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							
						</div>
						<div class="tab-pane" id="datamaterial" role="tabpanel">
							<div class="row">
								<div class="col-md-8">
									<span onclick="ubah_detail(`0`,1)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Add Jasa</span>
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
											<th width="10%">Update</th>
											<th width="3%"></th>
										</tr>
									</thead>
									
								</table>
							</div>
						</div>
						<div class="tab-pane" id="dataoperasional" role="tabpanel">
							<div class="row">
								<div class="col-md-8">
									<span onclick="ubah_detail(`0`,2)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Add Operasional</span>
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
										<th width="10%">Update</th>
										<th width="3%"></th>
									</tr>
								</thead>
								
							</table>
						</div>
						<div class="tab-pane" id="datapekerjaan" role="tabpanel">
							<div class="row">
								<div class="col-md-8">
									<span onclick="ubah_detail(`0`,5)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Add Pekerjaan</span>
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
										<th width="10%">Update</th>
										<th width="3%"></th>
									</tr>
								</thead>
								
							</table>
						</div>
						<div class="tab-pane" id="datajasa" role="tabpanel">
							<div class="row">
								<div class="col-md-8">
									<span onclick="ubah_detail(`0`,3)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Add Jasa</span>
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
										<th width="10%">Update</th>
										<th width="3%"></th>
									</tr>
								</thead>
								
							</table>
						</div>
						<div class="tab-pane" id="dataspec" role="tabpanel">
							<div class="row">
								<div class="col-md-8">
									<span onclick="ubah_detail(`0`,4)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Add Jasa</span>
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
										<th width="10%">Update</th>
										<th width="3%"></th>
									</tr>
								</thead>
								
							</table>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-lg-12">
							<!-- <span  class="btn btn-success btn-label waves-effect waves-light" id="save-data"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save & Next</span> -->
						</div>
						
					</div>
				</div><!-- end card-body -->
			</div>
		
			
		</form>
	</div>
</div>
<div id="modal-schema" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Modal Heading</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form  id="mydataschema" method="post" action="{{ url('service/schema') }}" enctype="multipart/form-data" >
            		@csrf
					<input type="text" name="service_id" value="{{$data->id}}">
					<div id="tampil-schema"></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary " id="save-schema">Save Changes</button>
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
				<form class="form-horizontal" id="mydataimportmaterial" method="post" action="{{ url('kontrak/store_import_material') }}" enctype="multipart/form-data" >
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
				<form class="form-horizontal" id="mydatadetail" method="post" action="{{ url('kontrak/store_import_material') }}" enctype="multipart/form-data" >
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
<script src="{{url_plug()}}/assets/libs/apexcharts/apexcharts.min.js"></script>
    	<script src="{{url_plug()}}/assets/js/pages/form-masks.init.js"></script>
        <script type="text/javascript">
			function getChartColorsArray(e) {
				if (null !== document.getElementById(e)) {
					var e = document.getElementById(e).getAttribute("data-colors");
					return (e = JSON.parse(e)).map(function(e) {
						var t = e.replace(" ", "");
						if (-1 === t.indexOf(",")) {
							var a = getComputedStyle(document.documentElement).getPropertyValue(t);
							return a || t
						}
						e = e.split(",");
						return 2 != e.length ? t : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")"
					})
				}
			}
			var chartTimelineColors = getChartColorsArray("color_timeline");
				chartTimelineColors && (options = {
					series: [{
						data: [{
							x: "Analysis",
							y: [new Date("2019-02-27").getTime(), new Date("2019-03-04").getTime()],
							fillColor: chartTimelineColors[0]
						}, {
							x: "Design",
							y: [new Date("2019-03-04").getTime(), new Date("2019-03-08").getTime()],
							fillColor: chartTimelineColors[1]
						}, {
							x: "Coding",
							y: [new Date("2019-03-07").getTime(), new Date("2019-03-10").getTime()],
							fillColor: chartTimelineColors[2]
						}, {
							x: "Testing",
							y: [new Date("2019-03-08").getTime(), new Date("2019-03-12").getTime()],
							fillColor: chartTimelineColors[3]
						}, {
							x: "Deployment",
							y: [new Date("2019-03-12").getTime(), new Date("2019-03-17").getTime()],
							fillColor: chartTimelineColors[4]
						}]
					}],
					chart: {
						height: 350,
						type: "rangeBar",
						toolbar: {
							show: !1
						}
					},
					plotOptions: {
						bar: {
							horizontal: !0,
							distributed: !0,
							dataLabels: {
								hideOverflowingLabels: !1
							}
						}
					},
					dataLabels: {
						enabled: !0,
						formatter: function(e, t) {
							var a = t.w.globals.labels[t.dataPointIndex],
								t = moment(e[0]),
								t = moment(e[1]).diff(t, "days");
							return a + ": " + t + (1 < t ? " days" : " day")
						}
					},
					xaxis: {
						type: "datetime"
					},
					yaxis: {
						show: !0
					}
				}, (chart = new ApexCharts(document.querySelector("#color_timeline"), options)).render());
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

			function show_draft(){
           
				$('#modal-customer').modal('show');
				
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
							   url: "{{url('kontrak/delete_detail')}}",
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
											tables.ajax.url("{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=3").load();
									}
									if(kategori==2){
										var tables=$('#data-operasional-fixed-header').DataTable();
											tables.ajax.url("{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=2").load();
									}
									if(kategori==3){
										var tables=$('#data-jasa-fixed-header').DataTable();
											tables.ajax.url("{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=1").load();
									}
									if(kategori==5){
										var tables=$('#data-pekerjaan-fixed-header').DataTable();
											tables.ajax.url("{{ url('kontrak/getdatapekerjaan')}}?id={{$id}}&ctr=1").load();
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
				if(kategori==5){
					$('#titleubah').html('Form Pekerjaan')
				}
				$('#modal-tambahdetail').modal('show');
				$('#form-tambahdetail').load("{{url('kontrak/modal_detail')}}?id="+id+"&kategori="+kategori);
				
			} 
			function show_import(){
           
				$('#modal-excel').modal('show');
				
			} 
			function show_pm(){
           
				$('#modal-pm').modal('show');
				
			} 
			function pilih_status(id){
				if(id==8){
					$('#form-label-header').html('Cost Center')
					$('#view_cost_center').show();
					$('#show_file_kontrak').show();
					$('#show_pm').show();
				}else{
					$('#form-label-header').html('Customer')
					$('#view_cost_center').hide();
					$('#show_file_kontrak').hide();
					$('#show_pm').hide();
				}
				
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
			
			$('#save-data').on('click', () => {
            
				var form=document.getElementById('mydata');
					$.ajax({
						type: 'POST',
						url: "{{ url('project') }}",
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
								location.assign("{{url('kontrak/view')}}?id="+bat[2]);
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
						url: "{{ url('kontrak/store_import_material') }}",
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
						url: "{{ url('kontrak/store_detail') }}",
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
          								tables.ajax.url("{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=3").load();
								}
								if(bat[2]==2){
									var tables=$('#data-operasional-fixed-header').DataTable();
          								tables.ajax.url("{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=2").load();
								}
								if(bat[2]==3){
									var tables=$('#data-jasa-fixed-header').DataTable();
          								tables.ajax.url("{{ url('kontrak/getdatadetail')}}?id={{$id}}&ctr=1").load();
								}
								if(bat[2]==5){
									var tables=$('#data-pekerjaan-fixed-header').DataTable();
          								tables.ajax.url("{{ url('kontrak/getdatapekerjaan')}}?id={{$id}}&ctr=1").load();
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
				   title: "Yakin reset data biaya ini ?",
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
							   url: "{{url('kontrak/reset_material')}}",
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
