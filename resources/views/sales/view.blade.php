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
</style>
        
    <script type="text/javascript">
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        function show_data() {
            if ($('#data-table-fixed-header').length !== 0) {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20, 40, 60],
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('project/getdataview')}}?id={{$id}}",
                    dom: 'lrtip',
					columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
                        
						{ data: 'action' },
                        { data: 'statusnya' },
						
						{ data: 'customer' },
						{ data: 'judul' },
						{ data: 'sts' },
						{ data: 'createby' },
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
            }
        };


        $(document).ready(function() {
			show_data();

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
					<h4 class="mb-sm-0">Seller Details</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
							<li class="breadcrumb-item active">Seller Details</li>
						</ol>
					</div>

				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-xxl-3">
				<div class="card">
					<div class="card-body p-4">
						<div class="row">
							<div class="col-md-2">
							
								<div class="profile-user position-relative d-inline-block mx-auto  mb-0">
									<img src="{{img_profil($data->id)}}" class="rounded-circle avatar-lg img-thumbnail user-profile-image  shadow" height="45" alt="" />
								</div>
							</div>
							<div class="col-md-10">
								<table class="tabletable-bordered" width="100%">
									<tbody>
										<tr>
											<td style="text-align:center" ><h3>{{$data->name}}</h3></td>
										</tr>
										<tr>
											<td style="text-align:center" ><h4>{{$data->username}}<h4></td>
										</tr>
										<tr>
											<td style="text-align:center" >{{$data->role}}</td>
										</tr>
										
									</tbody>
								</table>
								<div class="row g-0 text-center">
									<div class="col-6 col-sm-4">
										<div class="p-3 border border-dashed border-start-0">
											<h5 class="mb-1"><span class="counter-value" data-target="{{$data->prospek}}">{{$data->prospek}}</span></h5>
											<p class="text-muted mb-0">PROSPEK / PROSES</p>
										</div>
									</div>
									<!--end col-->
									<div class="col-6 col-sm-4">
										<div class="p-3 border border-dashed border-start-0">
											<h5 class="mb-1"><span class="counter-value" data-target="{{$data->kontrak}}">{{$data->kontrak}}</span></h5>
											<p class="text-muted mb-0">KONTRAK</p>
										</div>
									</div>
									<!--end col-->
									<div class="col-6 col-sm-4">
										<div class="p-3 border border-dashed border-start-0">
											<h5 class="mb-1"><span class="counter-value" data-target="{{$data->gagal}}">{{$data->gagal}}</span></h5>
											<p class="text-muted mb-0">DIBATALKAN</p>
										</div>
									</div>
									
								</div>
							</div>
							
						</div>
					</div>
					<div class="card-body p-4 border-top border-top-dashed">
						<div class="row">
							
							<div class="col-lg-12">
								
								<div class="card">
									
									<div class="card-body">
										<div class="row">
											<div class="col-md-8">
											
											</div>
											<div class="col-md-4">
											<input type="text" class="form-control">
											</div>
										</div>
										
										<table id="data-table-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
											<thead>
												<tr>
													<th scope="col" style="width: 10px;">No</th>
													
													<th scope="col" style="width: 10px;"></th>
													<th scope="col" style="width: 10px;"></th>
													<th scope="col" width="20%">Customer</th>
													<th>Deskripsi Project</th>
													<th width="15%">Status</th>
													<th width="12%">Createdby</th>
													<th width="12%">CretatedAt</th>
													
												</tr>
											</thead>
											
										</table>
									</div>
								</div>
							</div>
						</div>



					</div>
					
				</div>
				<!--end card-->
			</div>
			<!--end col-->

			
			<!--end col-->
		</div>
		<!--end row-->
	</div>
	<!-- container-fluid -->
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
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary " id="save-schema">Save Changes</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
@endsection

@push('ajax')
        
        <script type="text/javascript">
			function tambah(id,status_id){
				if(status_id>7){
					location.assign("{{url('kontrak/view')}}?act=2&id="+id)
				}else{
					location.assign("{{url('project/view')}}?act=2&id="+id)
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
			
			function isi_target(name){
				$('#table_target').val(name)
			}
			function tambah_schema(id){
				$('#modal-schema').modal('show')
				$('#tampil-schema').load("{{url('service/tampil_schema')}}?service_id={{$data->id}}&id="+id)
			}
			$('.target_table').hide();

			function pilih_type(id){
				if(id=='S'){
					$('.target_table').show();
				}else{
					$('.target_table').hide();
				}

			}
			$('#save-data').on('click', () => {
            
				var form=document.getElementById('mydata');
					$.ajax({
						type: 'POST',
						url: "{{ url('service') }}",
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
									html:'Create Service Succes ',
									icon:"success",
									confirmButtonText: 'Close',
									confirmButtonClass:"btn btn-info w-xs mt-2",
									buttonsStyling:!1,
									showCloseButton:!0
								});
								location.assign("{{url('service/view')}}?id="+bat[2]);
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
			$('#save-schema').on('click', () => {
            
				var form=document.getElementById('mydataschema');
					$.ajax({
						type: 'POST',
						url: "{{ url('service/schema') }}",
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
								$('#modal-schema').modal('hide')
								$('#tampil-schema').html("")
								var tables=$('#data-table-fixed-header').DataTable();
								tables.ajax.url("{{ url('service/getdataschema')}}?service_id={{$data->id}}").load();
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
    	</script>
@endpush
