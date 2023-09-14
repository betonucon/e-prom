
@extends('layouts.app')
@push('datatable')
        
        
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
                    ajax:"{{ url('service/getdata')}}",
                    dom: 'lrtip',
					columns: [
                        { data: 'id', render: function (data, type, row, meta) 
							{
								return meta.row + meta.settings._iDisplayStart + 1;
							} 
						},
						
						{ data: 'service_custome' },
						{ data: 'database' },
						{ data: 'endpoint' },
						{ data: 'servicetype' },
						{ data: 'adapter',"className": "text-center",},
						{ data: 'statusnya',"className": "text-center",},
						{ data: 'log' },
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
            }
        };

        function dash(){
            $.ajax({ 
				type: 'GET', 
				url: "{{ url('service/getdatadashboard')}}", 
				data: { id: 1 }, 
				dataType: 'json',
				success: function (data) {
					$('#all').html('<span class="counter-value" data-target="'+data.all+'">'+data.all+'</span>')
					$('#tiper').html('<span class="counter-value" data-target="'+data.tiper+'" >'+data.tiper+'</span>')
					$('#tipes').html('<span class="counter-value" data-target="'+data.tipes+'" >'+data.tipes+'</span>')
				}
				
			});  
        }
        $(document).ready(function() {
			show_data();
			dash();

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
                            <h4 class="mb-sm-0">SERVICE</h4>

                            <div class="page-title-right">
                            <span onclick="location.assign(`{{url('service/view')}}?id={{encoder(0)}}`)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> New Service</span>
                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="row h-100">
                    <div class="col-lg-4 col-md-6">
                        <div class="card" style="cursor: pointer;" onclick="show_data_cari('0')">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span style="font-size: 13px !important;" class="avatar-title bg-light text-primary rounded-circle shadow fs-3">
                                            <b>ALL</b>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                            All Service</p>
                                        <h4 class=" mb-0" id="all"></h4>
                                    </div>
                                    
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card" style="cursor: pointer;" onclick="show_data_cari('R')">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span style="font-size: 13px !important;" class="avatar-title bg-light text-primary rounded-circle shadow fs-3">
                                            <b>R</b>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                            Type Request Service</p>
                                        <h4 class=" mb-0" id="tiper"></h4>
                                    </div>
                                    
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card" style="cursor: pointer;" onclick="show_data_cari('S')">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span style="font-size: 13px !important;" class="avatar-title bg-light text-primary rounded-circle shadow fs-3">
                                            <b>S</b>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Type Send  Service</p>
                                            <h4 class=" mb-0" id="tipes"></h4>
                                    </div>
                                    
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
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
                                            <th>Service Name</th>
                                            <th width="8%">Target</th>
                                            <th width="8%">Method</th>
                                            <th width="8%">Type</th>
                                            <th  width="12%">Adapter</th>
                                            <th  width="5%">Act</th>
                                            <th scope="col" style="width: 10px;"></th>
                                            <th scope="col" style="width: 10px;"></th>
                                            
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
		    }
            function show_data_cari(tipe){
                var tables=$('#data-table-fixed-header').DataTable();
                    tables.ajax.url("{{ url('service/getdata')}}?tipe="+tipe).load();
            }
            function simpan_data(){
            
                var form=document.getElementById('mydataform');
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('user') }}",
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
                                    html:'Create User Succes ',
                                    icon:"success",
                                    confirmButtonText: 'Close',
                                    confirmButtonClass:"btn btn-info w-xs mt-2",
                                    buttonsStyling:!1,
                                    showCloseButton:!0
                                });
                                $('#modal-form').modal('hide')
				                $('#tampil-form').html("")
                                var tables=$('#data-table-fixed-header').DataTable();
                                        tables.ajax.url("{{ url('user/getdata')}}").load();
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
            function switch_data(id,act){
                if(act==1){
                    Swal.fire({
                        title: "Non Aktifkan Service Ini ?",
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
                                    url: "{{url('service/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses non aktifkan",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('service/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==3){
                    Swal.fire({
                        title: "Aktifkan Service Ini ?",
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
                                    url: "{{url('service/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diaktifkan",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('service/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                
            }
        </script>
@endpush   