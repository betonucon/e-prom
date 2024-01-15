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
		function get_rekap(){
			$.ajax({ 
					type: 'GET', 
					url: "{{ url('project/getrekap')}}?id={{$data->id}}&state=1", 
					data: { ide: 1 }, 
					dataType: 'json',
					beforeSend: function() {
						$('#total-biaya').html('<p class="card-text placeholder-glow"><span class="placeholder col-12"></span></p>')
					},
					
					success: function (data) {
						$("#nilai-project").html('Rp.'+data.nilai_project);
						$("#total-biaya").html('Rp.'+data.subtotal);
						$("#total-cm").html('Rp.'+data.biaya_cost);
						$("#total-hpp").html('Rp.'+data.hpp);
						$.each(data.data, function(i, result){
							
							$("#nilairekap"+result.kode_biaya).html('Item '+result.jumlah+' Rp.'+result.total);
							
						});
							
					}
					
				});
		}
        $(document).ready(function() {
			get_rekap();
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
				@foreach(get_biaya() as $gb)
					var data{{$gb->kode_biaya}}=$('#data-fixed-header-{{$gb->kode_biaya}}').DataTable({
						lengthMenu: [100, 200, 600],
						lengthChange:false,
						fixedHeader: {
							header: true,
							headerOffset: $('#header').height()
						},
						responsive: true,
						dom: 'lrtip',
						ajax:"{{ url('project/getbiaya')}}?biaya={{$gb->kode_biaya}}&id={{$id}}&state=1",
						columns: [
							{ data: 'id', render: function (data, type, row, meta) 
								{
									return meta.row + meta.settings._iDisplayStart + 1;
								} 
							},
							{ data: 'nama_material' },
							{ data: 'qty'  ,className: "text-right" },
							{ data: 'satuan_material' ,className: "text-center" },
							{ data: 'biaya'  ,className: "text-right" },
							{ data: 'total'  ,className: "text-right" },
							
						],
						language: {
							paginate: {
								// remove previous & next text from pagination
								previous: '<< previous',
								next: 'Next>>'
							}
						}
					});
					$('#cari_data{{$gb->kode_biaya}}').keyup(function(){
						data{{$gb->kode_biaya}}.search($(this).val()).draw() ;
					})
				@endforeach
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
					
					if (e.target.hash == '#datapekerjaan') {
						@foreach(get_biaya() as $gb)
							data{{$gb->kode_biaya}}.columns.adjust().draw()
						@endforeach
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
					<h4 class="mb-sm-0">Rencana Anggaran Biaya Dan Operasional Proyek</h4>
					<div class="page-title-right">
						<span onclick="location.assign(`{{url('project')}}`)" class="btn btn-danger btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Back</span>
					</div>
				</div>
			</div>
		</div>
		<form  id="mydata" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
            @csrf
			<!-- <input type="submit"> -->
			<input type="hidden" name="id" value="{{$id}}">
			<div class="row">
                <div class="col-lg-12">

				</div>
                <div class="col-lg-12">
					<div class="card" style="@if($data->status_id==50)background-image:url({{url_plug()}}/img/batal.png) @endif" >
						<div class="card-body">
							<span class="ribbon-three ribbon-three-success"><span>PROJECT</span></span>
							<div class="text-muted mb-5">
								<h6 class="mb-3 fw-semibold text-uppercase">&nbsp;</h6>
								<ul class="nav nav-tabs mb-3" role="tablist">
								
								
									<li class="nav-item">
										<a class="nav-link active" data-bs-toggle="tab" href="#dataproject" role="tab" aria-selected="false">
											<i class="mdi mdi-book-check"></i> DESKRIPSI PROJECT
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#datapekerjaan"  role="tab" aria-selected="false">
											<i class="mdi mdi-book-check"></i> RENCANA ANGGARAN BIAYA DAN OPERASIONAL PROYEK
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#datalog"  role="tab" aria-selected="false">
											<i class="mdi mdi-book-check"></i> RIWAYAT
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
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Status Project</b></td>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
														<td style="padding: 3px 16px;" >{{$data->status}}</td>
													</tr>
													
												</tbody>
											</table>
										</div>
									</div>
									<div class="tab-pane" id="datapekerjaan" role="tabpanel">
										<div class="tab-content  text-muted" style="background: #f2f2f5;padding: 0.1%; border: solid 1px #ececef;">
						
											
													<table class="table table-bordered align-middle table-nowrap mb-0">
														<tbody>
															<tr>
																<td style="padding: 2px 5px !important;" >A. PENDAPATAN</td>
																<td style="padding: 2px 5px !important;" id="nilai-project"></td>
																
															</tr>
															<tr>
																<td style="padding: 2px 5px !important;" >B. BIAYA LANGSUNG PROYEK</td>
																<td style="padding: 2px 5px !important;" id="total-biaya"></td>
																
															</tr>
															<tr>
																<td style="padding: 2px 5px !important;" >C. BIAYA TIDAK LANGSUNG</td>
																<td style="padding: 2px 5px !important;" id="total-cm"></td>
																
															</tr>
															<tr>
																<td style="padding: 2px 5px !important;" >HARGA POKOK PENJUALAN (TOTAL BIAYA)</td>
																<td style="padding: 2px 5px !important;" id="total-hpp"></td>
																
															</tr>
															
														</tbody>
													</table>
												
										
									</div>
									<div class="live-preview">
										<div class="accordion" id="default-accordion-example">
										@foreach(get_biaya() as $gb)
											<div class="accordion-item shadow">
												<h2 class="accordion-header" id="headingOne{{$gb->kode_biaya}}">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$gb->kode_biaya}}" aria-expanded="false" aria-controls="collapseOne{{$gb->kode_biaya}}">
													{{$gb->kode_biaya}}. {{$gb->biaya}} (<p class="mb-0" style="color:blue" id="nilairekap{{$gb->kode_biaya}}"></p>)
													</button>
												</h2>
												<div id="collapseOne{{$gb->kode_biaya}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#default-accordion-example" style="">
													<div class="accordion-body">
														<div class="row">
															<div class="col-md-8">
																<!-- <span onclick="ubah_detail(`0`,5)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Tambah {{$gb->kode_biaya}}</span> -->
															</div>
															<div class="col-md-4">
																<div class="mb-2">
																	<input type="text" class="form-control" id="cari_data{{$gb->kode_biaya}}" placeholder="cari......">
																</div>
															</div>
														</div>
														<table id="data-fixed-header-{{$gb->kode_biaya}}" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
															<thead>
																<tr>
																	<th width="4%"></th>
																	<th>Uraian</th>
																	<th width="10%">Qty</th>
																	<th width="10%">Unit</th>
																	<th width="14%">Harga</th>
																	<th width="14%">Total Harga</th>
																</tr>
															</thead>
															
														</table>
													</div>
												</div>
											</div>
										@endforeach
											
											
										</div>
									</div>
									</div>
									<div class="tab-pane" id="datalog" role="tabpanel">
										<div data-simplebar style="height: 308px;" class="px-3 mx-n3 mb-2">
											<div id="tampil-log"></div>
										</div>
									</div>
								</div>
								@if($data->status_id>7 && $data->status_id!=50)
								
								<div class="tab-content  text-muted" style="margin-top:2%;padding: 2% 2%; border: solid 1px #ececef;">
									
									<div class="tab-pane active"  role="tabpanel">
										
										<p>Verifikasi Hasil</p>
										<div class="table-responsive table-card">
											
											<table class="table table-borderless mb-0">
												<tbody>
													<tr>
														<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="20%"><b>Cost Center</b></td>
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
									<div class="tab-pane" id="datalog" role="tabpanel">
										<div data-simplebar style="height: 308px;" class="px-3 mx-n3 mb-2">
											<div id="tampil-log"></div>
										</div>
									</div>
								</div>
								@endif
								
							</div>
							<div class="row mt-2">
								<div class="col-lg-12">
									<span  class="btn btn-primary btn-label waves-effect waves-light" onclick="approve_status()"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Approve</span>
								</div>
								
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
				<form  id="mydataapprove" method="post" action="{{ url('project/approve_data') }}" enctype="multipart/form-data" >
            		@csrf
					<input type="hidden" name="id" value="{{$data->id}}">
						<div class="mt-3">
							<div class="avatar-sm mx-auto">
								<div class="avatar-title bg-light text-success display-5 rounded-circle"><i class="ri-mail-send-fill"></i></div>
							</div>
							<div class="mt-4 pt-2 fs-15" style="text-align: center;">
								<h4 class="fs-20 fw-semibold">Verifikasi / Approve Prencanaan</h4>
								<p class="text-muted mb-0 mt-3 fs-13">{{$data->deskripsi_project}}</p>
							</div>
						</div>
						<div>
							<label for="disabledInput" class="form-label">Status Approve</label>
							<div class="input-group">
								<span class="input-group-text" id="inputGroup-sizing-sm" ><i class="mdi mdi-arrow-down-drop-circle-outline"></i></span>
								<select name="status_id" class="form-control form-control-sm" onchange="pilih_status(this.value)" placeholder="0000">
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
								<textarea class="form-control" rows="4" placeholder="Ketik disini....."></textarea>
							</div>
						</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary " id="save-approve">Proses</button>
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
			function approve_status(){
           
				$('#modal-approve').modal('show');
				
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
			
			function pilih_status(id){
				if(id==2){
					$('#alasan').show();
				}else{
					$('#alasan').hide();
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
			$('#save-approve').on('click', () => {
				
				var form=document.getElementById('mydataapprove');
				var uril="{{ url('project/approve_data') }}";
				
					$.ajax({
						type: 'POST',
						url: uril,
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
									html:'Approve Succes ',
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
								location.assign("{{url('project/view')}}?id="+bat[2]);
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
