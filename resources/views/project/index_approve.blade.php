
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
        function load_data(){
			$.ajax({ 
                type: 'GET', 
                url: "{{ url('project/getdatadashboard')}}", 
                data: { ide: 1 }, 
                dataType: 'json',
                beforeSend: function() {
                    $('#rencana').val(0)
                    $('#penyusunan').val(0)
                    $('#approve').val(0)
                    $('#varifikasi').val(0)
                    
                },
                success: function (data) {
                    $('#rencana').html('<span class="counter-value" data-target="'+data.rencana+'" ></span>'+data.rencana);
                    $('#penyusunan').html('<span class="counter-value" data-target="'+data.penyusunan+'" ></span>'+data.penyusunan);
                    $('#approve').html('<span class="counter-value" data-target="'+data.approve+'" ></span>'+data.approve);
                    $('#verifikasi').html('<span class="counter-value" data-target="'+data.verifikasi+'" ></span>'+data.verifikasi);
                  
                }
            });
        }
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
                    ajax:"{{ url('project/getdata')}}",
                    dom: 'lrtip',
					columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
                        
						{ data: 'action' },
                        
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
            load_data();
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
                            <h4 class="mb-sm-0" style="text-transform:uppercase" >Draft Project</h4>

                            <div class="page-title-right">
                            <span onclick="tambah(`{{encoder(0)}}`)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> New Project</span>
                            </div>

                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                            
                                <!-- card -->
                                <div class="card card-animate  bg-soft-warning">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total RABOB</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="rencana"></h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="bx bx-bar-chart-alt-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate bg-soft-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">  Penyusunan</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="penyusunan"></h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="bx bx-bar-chart-alt-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate bg-soft-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">  Approval</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="approve"></h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="bx bx-bar-chart-alt-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate bg-soft-secondary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">  Bidding</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="verifikasi"></h4>
                                                
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="bx bx-bar-chart-alt-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>
                    </div>
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
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <div id="modal-form" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"><i class="mdi mdi-account-circle-outline"></i> Employe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  id="mydataform" method="post" action="{{ url('employe') }}" enctype="multipart/form-data" >
                            @csrf
                            <!-- <input type="submit"> -->
                            <div id="tampil-form"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary " onclick="simpan_data()">Save Changes</button>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>       
@endsection
@push('ajax')
        
        <script type="text/javascript">
			
			function tambah(id){
				location.assign("{{url('project/view')}}?id="+id)
			} 
            function hanyaAngka(evt) {
				
				var charCode = (evt.which) ? evt.which : event.keyCode
				if ((charCode > 47 && charCode < 58 ) || (charCode > 96 && charCode < 123 ) || charCode==95 ){
					
					return true;
				}else{
					return false;
				}
		    }
            function publish_data(id){
				Swal.fire({
				   title: "Yakin akan melakukan proses publish ?",
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
							   url: "{{url('project/publish_data')}}",
							   data: "id="+id,
							   success: function(msg){
								   Swal.fire({
									   title: "Sukses dipublish",
									   type: "warning",
									   icon: "success",
									   
									   align:"center",
									   
								   });

                                   var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('project/getdata')}}").load();
							   }
						   });
						   
					   }
				   
			   });
			}
            function delete_data(id,act){
                
                    Swal.fire({
                        title: "Yakin menghapus data ini ?",
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
                                    url: "{{url('project/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('project/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
               
            } 
            function switch_data(id,act){
                if(act==1){
                    Swal.fire({
                        title: "Unpublish Project Ini ?",
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
                                    url: "{{url('project/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('project/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==3){
                    Swal.fire({
                        title: "Publish Akses Ini ?",
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
                                    url: "{{url('project/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses proses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('project/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                
            } 
             
        </script>
@endpush