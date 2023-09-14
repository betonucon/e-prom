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
                    ajax:"{{ url('service/getdataschema')}}?service_id={{$data->id}}",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'action' },
						{ data: 'field_name' },
						{ data: 'field_type' },
						{ data: 'field_length' },
						{ data: 'is_required' },
						
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
					<h4 class="mb-sm-0">VIEW SERVICE</h4>
					<div class="page-title-right">
						<span onclick="location.assign(`{{url('service')}}`)" class="btn btn-danger btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Back</span>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->
		<form  id="mydata" method="post" action="{{ url('service') }}" enctype="multipart/form-data" >
            @csrf
			<!-- <input type="submit"> -->
			<input type="hidden" name="id" value="{{$id}}">
			<ul class="nav nav-tabs nav-justified" role="tablist">
				<li class="nav-item">
					<a class="nav-link @if($data->set==1) @else active @endif" data-bs-toggle="tab" href="#base-justified-home" role="tab" aria-selected="false">
						Service & Config
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link  @if($data->set==1) active @else  @endif" @if($data->set==0) onclick="alert('Service & Config is reuqire')" @else data-bs-toggle="tab" href="#base-justified-product" role="tab" @endif  aria-selected="false">
						Field
					</a>
				</li>
				
			</ul>
			<div class="tab-content  text-muted" style="padding: 1%; background: #e5e5e9;">
                <div class="tab-pane  @if($data->set==1) @else active @endif" id="base-justified-home" role="tabpanel">
					<div class="row">
						<div class="col-lg-8">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Service</h5>
								</div>
								<div class="card-body row">
									<div class="col-lg-9">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Service Name</label>
											<input type="text" name="service_name" id="service_name" onkeyup="isi_target(this.value)" onkeypress="return hanyaAngka(event)"  value="{{$data->service_name}}" class="form-control" id="project-title-input" placeholder="Enter...">
										</div>
									</div>
									<div class="col-lg-5">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Service Target</label>
											<div class="input-group">
												<span class="input-group-text" id="inputGroup-sizing-default">tcq_</span>
												<input type="text" class="form-control"  readonly value="{{$data->service_name}}" id="table_target">
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">End Point</label>
											<input type="text" name="endpoint" placeholder="https://" value="{{$data->endpoint}}"  class="form-control" id="project-title-input" placeholder="Enter...">
										</div>
									</div>
									
								</div>
							</div>
						
						</div>
					
						<div class="col-lg-4">
							
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Config</h5>
								</div>
								<div class="card-body row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Type</label>
											<select class="form-select"  name="service_type" onchange="pilih_type(this.value)"id="inputGroupSelect01">
												<option value="">Select--</option>
												<option value="R" @if($data->service_type=='R') selected @endif >R (Request)</option>
												<option value="S" @if($data->service_type=='S') selected @endif >S (Send)</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Adapter</label>
											<select class="form-select"  name="service_adapter" id="inputGroupSelect01">
												<option value="">Select--</option>
												<option value="rest" @if($data->service_adapter=='rest') selected @endif >Rest</option>
												<option value="web-service" @if($data->service_adapter=='web-service') selected @endif >Web-Service</option>
												<option value="file" @if($data->service_adapter=='file') selected @endif >File</option>
											</select>
										</div>
									</div>
									<div class="col-lg-12 target_table">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Source</label>
											<select class="form-select"  name="tcq_source" id="inputGroupSelect01">
												<option value="">Select--</option>
												@foreach( get_service() as $ser)
												<option value="{{$ser->tcq_target}}" @if($data->tcq_source==$ser->tcq_target) selected @endif >{{$ser->service_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Methode</label>
											<select class="form-select"  name="endpoint_method" id="inputGroupSelect01">
												<option value="">Select--</option>
												<option value="POST" @if($data->endpoint_method=='POST') selected @endif >POST</option>
												<option value="GET" @if($data->endpoint_method=='GET') selected @endif >GET</option>
												<option value="PUT" @if($data->endpoint_method=='PUT') selected @endif >PUT</option>
												<option value="DELETE" @if($data->endpoint_method=='DELETE') selected @endif >DELETE</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label" for="project-title-input">Interval</label>
											<input type="number" name="loop_interval" placeholder="numeric" value="{{$data->loop_interval}}"  class="form-control" id="project-title-input" placeholder="Enter project title">
										</div>
									</div>
								</div>
							</div>
						
						</div>
						
						
						

						<div class="col-lg-12" style="margin-bottom:2%">
							<span  class="btn btn-success btn-label waves-effect waves-light" id="save-data"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save & Next</span>
						</div>
					</div>
				</div>
				<div class="tab-pane @if($data->set==1) active @else  @endif" id="base-justified-product" role="tabpanel">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="card" style="background: whitesmoke;">
								<div class="card-header">
									<h5 class="card-title mb-0"><span onclick="tambah_schema(0)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Add Schema</span></h5>
								</div>
								<div class="card-body row" style="padding:2%" >
								
									<table id="data-table-fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
										<thead>
											<tr>
												<th scope="col" style="width: 10px;">No</th>
												<th scope="col" style="width: 10px;"></th>
												<th>Field Name</th>
												<th width="10%">Type</th>
												<th  width="10%">Length</th>
												<th  width="10%">Is Required</th>
											</tr>
										</thead>
										
									</table>
									
								</div>
							</div>
						
						</div>
					</div>
				</div>
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
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary " id="save-schema">Save Changes</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
@endsection

@push('ajax')
        
        <script type="text/javascript">
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
