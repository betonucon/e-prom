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

		function get_rekap(){
			$.ajax({ 
					type: 'GET', 
					url: "{{ url('project/getrekap')}}?id={{$data->id}}&state=2", 
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
						ajax:"{{ url('project/getbiaya')}}?biaya={{$gb->kode_biaya}}&id={{$id}}&state=2",
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
				var dataaktifitas=$('#data-fixed-header-aktifitas').DataTable({
					lengthMenu: [100, 200, 600],
					lengthChange:false,
					fixedHeader: {
						header: true,
						headerOffset: $('#header').height()
					},
					responsive: true,
					dom: 'lrtip',
					ajax:"{{ url('kontrak/getdatapekerjaan')}}?id={{$data->id}}",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'urut' },
						{ data: 'persennya' },
						
						
						@if($data->status_id<14 && count_pm_id($data->id)>0)
						{ data: 'action' },
						@endif
						{ data: 'pekerjaan' },
						{ data: 'mulai' },
						{ data: 'sampai' },
						{ data: 'selsih_waktu' },
						{ data: 'sisa_waktu' },
						{ data: 'created_at' },
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				$('#cari_dataaktifitas').keyup(function(){
					dataaktifitas.search($(this).val()).draw() ;
				})
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
					
					if (e.target.hash == '#datapekerjaan') {
						@foreach(get_biaya() as $gb)
							data{{$gb->kode_biaya}}.columns.adjust().draw()
						@endforeach
					}
					if (e.target.hash == '#dataaktifitas') {
						
						dataaktifitas.columns.adjust().draw()
						
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
						<span onclick="location.assign(`{{url('kontrak')}}`)" class="btn btn-danger btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Kembali</span>
					</div>
				</div>
			</div>
		</div>
		<form  id="mydata" method="post" action="{{ url('kontrak/publish') }}" enctype="multipart/form-data" >
            @csrf
			<!-- <input type="submit"> -->
			<input type="hidden" name="id" value="{{$id}}">
			<div class="card">
				<div class="card-body">
					<div style="width:100%;padding:0.5%;text-align:center;font-size:14px;font-weight:bold"><img src="{{url_plug()}}/img/kpdp.PNG" width="26%"><br>RENCANA ANGGARAN BIAYA DAN OPERASIONAL PROYEK</div>
					<!-- Nav tabs -->
					<hr style="border:solid 1px #000000">
					<ul class="nav nav-tabs mb-3" role="tablist" >
						<li class="nav-item">
							<a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true">
								<i class="mdi mdi-book-check"></i> PROJECT
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab"  href="#datapekerjaan" @endif  role="tab" aria-selected="false">
								<i class="mdi mdi-book-check"></i> RENCANA ANGGARAN BIAYA DAN OPERASIONAL PROYEK
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" @if($id==0) onclick="show_error()" @else data-bs-toggle="tab"  href="#dataaktifitas" @endif  role="tab" aria-selected="false">
								<i class="mdi mdi-book-check"></i> RENCANA PEKERJAAN
							</a>
						</li>
						
					</ul>
					@if($id>0)
						@if($data->revisi==1)
							<h6>Revisi</h6>
							<div class="alert alert-warning alert-borderless shadow" role="alert">
								<strong> Catatan </strong> {!! $data->catatan_revisi !!}
							</div>
						@endif
					
					@endif
					<div class="tab-content  text-muted" style="padding: 0.8%; border: solid 1px #ececef;">
						<div class="tab-pane active" style="padding: 2% 1%;" id="home" role="tabpanel">
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
							<hr>
							<p >Verifikasi Hasil</p>
							<div class="table-responsive table-card">
								
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="20%"><b>Cost Center</b></td>
											<td style="padding: 3px 16px;"  class="fw-medium" scope="row" width="3%"><b>:</b></td>
											<td style="padding: 3px 16px;" >{{$data->cost_center_project}} </td>
										</tr>
										<tr>
											<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Nomor Kontrak</b></td>
											<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
											<td style="padding: 3px 16px;" >{{$data->no_kontrak}}</td>
										</tr>
										<tr>
											<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>Project Manager</b></td>
											<td style="padding: 3px 16px;"  class="fw-medium" scope="row"><b>:</b></td>
											<td style="padding: 3px 16px;" >({{$data->nik_pm}}) {{$data->nama_pm}}</td>
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
						<div class="tab-pane" id="dataaktifitas" role="tabpanel">
							<div class="row">
								<div class="col-md-8">
									@if($data->status_id<14 && count_pm_id($data->id)>0)
									<span onclick="ubah_detail(`0`,5)" class="btn btn-success  waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Tambah Pekerjaan</span>
									@endif
								</div>
								<div class="col-md-4">
									<div class="mb-2">
										<input type="text" class="form-control" id="cari_datapekerjaan" placeholder="cari......">
									</div>
								</div>
							</div>
							<table id="data-fixed-header-aktifitas" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
								<thead>
									<tr>
										<th width="4%"></th>
										<th width="4%">Kode</th>
										<th width="4%">%</th>
										@if($data->status_id<14 && count_pm_id($data->id)>0)
										<th width="3%"></th>
										@endif
										<th >Pekerjaan </th>
										<th width="10%">Mulai</th>
										<th width="10%">Sampai</th>
										<th width="10%">Rencana</th>
										<th width="4%">Realisasi</th>
										<th width="10%">Update</th>
										
									</tr>
								</thead>
								
							</table>
							
						</div>
						
					</div>
					<div class="row mt-2">
						
						
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
				<h5 class="modal-title" id="myModalLabel">Upload File RABOB</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="mydataimportmaterial" method="post" action="{{ url('project/store_import_material') }}" enctype="multipart/form-data" >
					@csrf
					<!-- <input type="submit"> -->
					<input type="hidden" value="{{$id}}" name="id">
					<div class="form-group">
						<label for="inputEmail3" class="control-label">File RABOB (.xlsx)</label>

						<div >
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
			@if($id==0)
				$('#view_cost_center').hide();
				$('#show_file_kontrak').hide();
				$('#show_pm').hide();

			@else
				@if($data->status_id==8)
					$('#form-label-header').html('Cost Center')
					$('#view_cost_center').show();
					$('#show_file_kontrak').show();
					$('#show_pm').show();
				@else
					$('#form-label-header').html('Customer')
					$('#view_cost_center').hide();
					$('#show_file_kontrak').hide();
					$('#show_pm').hide();
				@endif

			@endif

			
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
			function delete_biaya(id,kode_biaya){
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
							   url: "{{url('project/delete_biaya')}}",
							   data: "id="+id+"&kode_biaya="+kode_biaya,
							   success: function(msg){
								   Swal.fire({
									   title: "Sukses dihapus",
									   type: "warning",
									   icon: "success",
									   
									   align:"center",
									   
								   });
								   get_rekap();
								   var bat=msg.split('@');
								   
									var tables=$('#data-fixed-header-'+bat[1]).DataTable();
										tables.ajax.url("{{ url('project/getbiaya')}}?biaya="+bat[1]+"&id={{$id}}&state=2").load();
									
							   }
						   });
						   
					   }
				   
			   });
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

								   var tables=$('#data-fixed-header-aktifitas').DataTable();
									tables.ajax.url("{{ url('kontrak/getdatapekerjaan')}}?id={{$data->id}}").load();
							   }
						   });
						   
					   }
				   
			   });
			}
			
			function ubah_detail(id,kategori){
				
				$('#titleubah').html('Form Pekerjaan')
				
				$('#modal-tambahdetail').modal('show');
				$('#form-tambahdetail').load("{{url('kontrak/modal_detail')}}?id="+id+"&kategori="+kategori+"&type_tagihan={{$data->type_tagihan}}");
				
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
						url: "{{ url('kontrak/publish') }}",
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
									html:'Kontrak sukses dipublish ',
									icon:"success",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-info w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
								location.assign("{{url('kontrak')}}");
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
			$('#save-data-lama').on('click', () => {
            
				var form=document.getElementById('mydata');
					$.ajax({
						type: 'POST',
						url: "{{ url('kontrak') }}",
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
									html:'Kontrak sukses dipublish ',
									icon:"success",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-info w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
								location.assign("{{url('kontrak')}}");
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
							
							var tables=$('#data-fixed-header-aktifitas').DataTable();
								tables.ajax.url("{{ url('kontrak/getdatapekerjaan')}}?id={{$data->id}}").load();
							
							
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
