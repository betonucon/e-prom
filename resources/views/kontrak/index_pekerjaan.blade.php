
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
                    ajax:"{{ url('kontrak/getdata')}}",
                    dom: 'lrtip',
					columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
                        
						{ data: 'action' },
                        { data: 'cost_center_project' },
						
						{ data: 'customer' },
						{ data: 'deskripsi_project' },
						{ data: 'sts' },
						{ data: 'nama_pm' },
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
                            <h4 class="mb-sm-0" style="text-transform:uppercase" >Pekerjaan</h4>

                            <div class="page-title-right">
                            <!-- <span onclick="tambah(`{{encoder(0)}}`)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> New Project</span> -->
                            </div>

                        </div>
                    </div>
                </div>
                

                <div class="card">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-lg-auto">
                                <div class="hstack gap-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createboardModal"><i class="ri-add-line align-bottom me-1"></i> Tambah Pekerjaan</button>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-7 col-auto">
                                <div class="search-box">
                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected="">-- Pilih Project </option>
                                        @foreach(get_kontrak() as $o)
                                        <option value="1">{{$o->customer}} - {{$o->deskripsi_project}}</option>
                                        @endforeach
                                    </select>
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="tasks-board mb-3" id="kanbanboard">

                    <div class="tasks-list">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h6 class="fs-14 text-uppercase fw-semibold mb-0">Dalam Pengerjaan <small class="badge bg-success align-bottom ms-1 totaltask-badge">2</small></h6>
                            </div>
                            
                        </div>
                        <div data-simplebar="init" style="max-height: 500px;" class="tasks-wrapper px-3 mx-n3"><div class="simplebar-wrapper" style="margin: 0px -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 16px;">
                            <div id="unassigned-task" class="tasks">

                                <div class="card tasks-box">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title"><a href="apps-tasks-details.html" class="text-body d-block">Profile Page Structure</a></h6>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                    <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="text-muted">Pemeliharaan Mesin A321</p>
                                        <div class="mb-3">
                                            <div class="d-flex mb-1">
                                                <div class="flex-grow-1">
                                                    <h6 class="text-muted mb-0"><span class="text-secondary">15%</span> of 100%</h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span class="text-muted">03 Jan, 2022</span>
                                                </div>
                                            </div>
                                            <div class="progress rounded-3 progress-sm bg-soft-danger">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="badge badge-soft-primary">Admin</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-dashed">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-0">#VL2436</h6>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <ul class="link-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-eye-line align-bottom"></i> 04</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> 19</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> 02</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--end tasks-->
                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 463px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        
                    </div>
                    <div class="tasks-list">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h6 class="fs-14 text-uppercase fw-semibold mb-0">Penyusunan BA (Berita Acara) <small class="badge bg-success align-bottom ms-1 totaltask-badge">2</small></h6>
                            </div>
                            
                        </div>
                        <div data-simplebar="init" style="max-height: 500px;" class="tasks-wrapper px-3 mx-n3"><div class="simplebar-wrapper" style="margin: 0px -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 16px;">
                            <div id="unassigned-task" class="tasks">

                                <div class="card tasks-box">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title"><a href="apps-tasks-details.html" class="text-body d-block">Profile Page Structure</a></h6>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                    <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="text-muted">Pemeliharaan Motor Listrik</p>
                                        <div class="mb-3">
                                            <div class="d-flex mb-1">
                                                <div class="flex-grow-1">
                                                    <h6 class="text-muted mb-0"><span class="text-secondary">15%</span> of 100%</h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span class="text-muted">03 Jan, 2022</span>
                                                </div>
                                            </div>
                                            <div class="progress rounded-3 progress-sm bg-soft-danger">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="badge badge-soft-primary">Admin</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-dashed">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-0">#VL2436</h6>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <ul class="link-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-eye-line align-bottom"></i> 04</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> 19</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> 02</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--end tasks-->
                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 463px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        
                    </div>
                    <div class="tasks-list">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <h6 class="fs-14 text-uppercase fw-semibold mb-0">Selesai <small class="badge bg-success align-bottom ms-1 totaltask-badge">2</small></h6>
                            </div>
                            
                        </div>
                        <div data-simplebar="init" style="max-height: 500px;" class="tasks-wrapper px-3 mx-n3"><div class="simplebar-wrapper" style="margin: 0px -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 16px;">
                            <div id="unassigned-task" class="tasks">

                                <div class="card tasks-box">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title"><a href="apps-tasks-details.html" class="text-body d-block">Profile Page Structure</a></h6>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                    <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="text-muted">Perbaikan Mesin Blast</p>
                                        <div class="mb-3">
                                            <div class="d-flex mb-1">
                                                <div class="flex-grow-1">
                                                    <h6 class="text-muted mb-0"><span class="text-secondary">15%</span> of 100%</h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span class="text-muted">03 Jan, 2022</span>
                                                </div>
                                            </div>
                                            <div class="progress rounded-3 progress-sm bg-soft-danger">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="badge badge-soft-primary">Admin</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-dashed">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-0">#VL2436</h6>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <ul class="link-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-eye-line align-bottom"></i> 04</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> 19</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> 02</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--end tasks-->
                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 463px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        
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
				location.assign("{{url('kontrak/view')}}?id="+id)
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
					   if (result.isConfirmed==true) {
						   $.ajax({
							   type: 'GET',
							   url: "{{url('kontrak/publish_data')}}",
							   data: "id="+id,
							   success: function(msg){
								   Swal.fire({
									   title: "Sukses dipublish",
									   type: "warning",
									   icon: "success",
									   
									   align:"center",
									   
								   });

                                   var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('kontrak/getdata')}}").load();
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
                                    url: "{{url('kontrak/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('kontrak/getdata')}}").load();
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
                                    url: "{{url('kontrak/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('kontrak/getdata')}}").load();
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
                                    url: "{{url('kontrak/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses proses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('kontrak/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                
            } 
             
        </script>
@endpush