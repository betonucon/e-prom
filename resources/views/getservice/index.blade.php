
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
                    ajax:"{{ url('getkey/'.$data->service_name.'/getdata')}}",
                    dom: 'lrtip',
					columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						{ data: 'aksi' },
						{ data: 'statusnya' },
						{ data: 'receive_at' },
						{ data: 'payload_short' },
						
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
          	$.ajax({ 
				type: 'GET', 
				url: "{{ url('getkey/'.$data->service_name.'/getdatadashboard')}}", 
				data: { id: 1 }, 
				dataType: 'json',
				success: function (data) {
					$('#all').html('<span class="counter-value" data-target="'+data.all+'">'+data.all+'</span>')
					$('#error').html('<span class="counter-value" data-target="'+data.error+'" >'+data.error+'</span>')
					$('#success').html('<span class="counter-value" data-target="'+data.success+'" >'+data.success+'</span>')
					$('#close').html('<span class="counter-value" data-target="'+data.close+'" >'+data.close+'</span>')
						
				}
				
			});  
        });

        function cari_data(){
            var tanggal_cari=$('#flatpickr').val();
            var tables=$('#data-table-fixed-header').DataTable();
					tables.ajax.url("{{ url('getkey/'.$data->service_name.'/getdata')}}?tanggal_cari="+tanggal_cari).load();
        }
        $(document).ready(function() {
			show_data();

		});

        function show_request(id){
            $('#modal-form').modal('show');
            
			$('#tampil-form').load("{{ url('getkey/'.$data->service_name.'/request')}}?id="+id)
        }
		
    </script>
@endpush
@section('content')
    

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">SERVICE</h4>

                            <div class="page-title-right">
                            <!-- <span onclick="location.assign(`{{url('service/view')}}?id={{encoder(0)}}`)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> New</span> -->
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">#{{$data->service_name}}</h4>
                                <p class="text-muted mb-0">Endpoint: {{$data->endpoint}}</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                
                                <div class="row g-3 mb-0 align-items-center">
                                    <div class="col-sm-auto">
                                        <div class="input-group">
                                            <input type="text" id="flatpickr" class="form-control border-0 dash-filter-picker shadow flatpickr-input" data-provider="flatpickr" data-range-date="true" data-date-format="Y-m-d"  data-deafult-date="2023-01-01 to 2023-12-31" readonly="readonly">
                                            <div class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-2-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-auto">
                                        <span class="btn btn-soft-success shadow-none" onclick="cari_data()"><i class="ri-add-circle-line align-middle me-1"></i> Search</button>
                                    </div>
                                    
                                </div>
                                
                                
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-2 fs-2">
                                            <i data-feather="clock"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">All Request</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-4 flex-grow-1 mb-0" id="all"></h4>
                                        </div>
                                        <!-- <p class="text-muted text-truncate mb-0">Projects this month</p> -->
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger rounded-2 fs-2">
                                            <i data-feather="clock"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Error Request</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-4 flex-grow-1 mb-0" id="error"></h4>
                                        </div>
                                        <!-- <p class="text-muted text-truncate mb-0">Projects this month</p> -->
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success rounded-2 fs-2">
                                            <i data-feather="clock"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Success Request</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-4 flex-grow-1 mb-0" id="success"></h4>
                                        </div>
                                        <!-- <p class="text-muted text-truncate mb-0">Projects this month</p> -->
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning rounded-2 fs-2">
                                            <i data-feather="clock"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Close Request</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-4 flex-grow-1 mb-0" id="close"></h4>
                                        </div>
                                        <!-- <p class="text-muted text-truncate mb-0">Projects this month</p> -->
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                   
                    

                </div>
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
                                            <th scope="col" width="5%">No</th>
                                            <th scope="col" width="5%"></th>
                                            <th scope="col" width="8%">Status</th>
                                            <th scope="col" width="15%">Datetime</th>
                                            <th scope="col">Payload</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <div id="modal-form" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">  
            <div class="modal-dialog modal-lg">    
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"><i class="mdi mdi-account-circle-outline"></i> Response</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="tampil-form"></div>
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div> 
        
@endsection
@push('ajax')
        
        <script type="text/javascript">
			
            function kembali_diproses(id,act){
                if(act==1){
                    Swal.fire({
                        title: "Yakin Memproses ulang log ini?",
                        text: "",
                        type: "warning",
                        icon: "error",
                        showCancelButton: true,
                        align:"center",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        closeOnConfirm: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'GET',
                                    url: "{{ url('getkey/'.$data->service_name.'/kembali_diproses')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('getkey/'.$data->service_name.'/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==2){
                    Swal.fire({
                        title: "Yakin non aktifkan user ini ?",
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
                                    url: "{{ url('getkey/'.$data->service_name.'/kembali_diproses')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('getkey/'.$data->service_name.'/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                
                
            } 
        </script>
@endpush    