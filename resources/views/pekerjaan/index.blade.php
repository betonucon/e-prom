
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
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 35px;
        padding: 0.5%;
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
                url: "{{ url('pekerjaan/getdata')}}?id={{encoder($id)}}&act={{$act}}", 
                data: { ide: 1 }, 
                dataType: 'json',
                beforeSend: function() {
                    $('#tampil-baru').html("")
                    $('#tampil-progres').html("")
                    $('#tampil-selesai').html("")
                    
                },
                success: function (data) {
                    
                    $('#pekerjaan_baru').html(data.baru);
                    $('#pekerjaan_total').html('<span class="counter-value" data-target="'+data.total+'" ></span>'+data.total);
                    $('#pekerjaan_persen').html('<span class="counter-value" data-target="'+data.persen+'" ></span>'+data.persen+'%');
                    $('#pekerjaan_outstanding').html('<span class="counter-value" data-target="'+data.outstanding+'" ></span>'+data.outstanding+'/'+data.progres);
                    $('#pekerjaan_selesai').html('<span class="counter-value" data-target="'+data.selesai+'" ></span>'+data.selesai+'/'+data.total);
                    $('#pekerjaan_progres').html('<span class="counter-value" data-target="'+data.progres+'" ></span>'+data.progres+'/'+data.total);
                    $.each(data.data_new, function(i, result){
                        if(result.outstanding==1 && result.status!=3){
                            varwc='danger';
                        }else{
                            varwc=result.color_status;
                        }
                        if(result.status!=3){
                            var tombol='<button type="button" onclick="location.assign(`{{url('pekerjaan/view')}}?id='+result.pekerjaan_id+'`)" class="btn btn-info btn-sm btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Aktivitas</button><button type="button" onclick="close_data('+result.pekerjaan_id+')" class="btn btn-success btn-sm btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Close</button>';
                        }else{
                            var tombol='<button type="button" onclick="location.assign(`{{url('pekerjaan/view')}}?id='+result.pekerjaan_id+'`)" class="btn btn-primary btn-sm btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Aktivitas</button>';
                        }
                        $("#tampil-baru").append('<div class="col-xxl-3 col-sm-6 project-card">'
                            +'<div class="card card-height-100">'    
                                +'<div class="card-body bg-soft-'+varwc+'">'
                                    +'<div class="d-flex flex-column h-100">'
                                        +'<div class="d-flex">'
                                            +'<div class="flex-grow-1">'
                                                +'<p class="text-muted mb-4">'+result.update+'</p>'
                                            +'</div>'
                                            +'<div class="flex-shrink-0">'
                                            +tombol
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="d-flex mb-2">'
                                            +'<div class="flex-shrink-0 me-3">'
                                                +'<div class="avatar-sm">'
                                                    +'<span class="avatar-title bg-soft-warning rounded p-2">'
                                                        +'<img src="assets/images/brands/slack.png" alt="" class="img-fluid p-1">'
                                                    +'</span>'
                                                +'</div>'
                                            +'</div>'
                                            +'<div class="flex-grow-1">'
                                                +'<h5 class="mb-1 fs-15"><a href="apps-projects-overview.html" class="text-dark">'+result.nomor+'</a></h5>'
                                                +'<p class="text-muted text-truncate-two-lines mb-3">'+result.pekerjaan+'</p>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="mt-auto">'
                                            +'<div class="d-flex mb-2">'
                                                +'<div class="flex-grow-1">'
                                                    +'<div>Progres</div>'
                                                +'</div>'
                                                +'<div class="flex-shrink-0">'
                                                    +'<div><i class="ri-list-check align-bottom me-1 text-muted"></i> '+result.persen_project+'%</div>'
                                                +'</div>'
                                            +'</div>'
                                            +'<div class="progress  animated-progress">'
                                                +'<div class="progress-bar bg-success" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" style="width: '+result.persen_project+'%;"></div>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="card-footer bg-transparent border-top-dashed py-2">'
                                    +'<div class="d-flex align-items-center">'
                                        +'<div class="flex-grow-1">'
                                        +'<p class="text-muted text-truncate-two-lines mb-3"><i class="ri-calendar-event-fill me-1 align-bottom"></i> '+result.mulai+' s/d '+result.sampai+'</p>'
                                        +'</div>'
                                        
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>');
                        
                    });
                    
                    
                }
			});
		}


        $(document).ready(function() {
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
                            <h4 class="mb-sm-0" style="text-transform:uppercase" >{{$pekerjaan}}</h4>

                            <div class="page-title-right">
                            <!-- <span onclick="tambah(`{{encoder(0)}}`)" class="btn btn-success btn-sm waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> New Project</span> -->
                            </div>

                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                    
                        <!-- card -->
                        <div class="card card-animate  bg-soft-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Progres Pekerjaan</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="pekerjaan_persen"></h4>
                                        
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
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">  Pengerjaan</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="pekerjaan_progres"></h4>
                                        
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
                        <!-- card -->
                        <div class="card card-animate  bg-soft-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Outstanding Pekerjaan</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="pekerjaan_outstanding"></h4>
                                        
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
                        <!-- card -->
                        <div class="card card-animate  bg-soft-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Selesai / Close</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle" ></i>
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4" id="pekerjaan_selesai"></h4>
                                        
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
                
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="card" style="margin-top:3%">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1 row">
                                    <div class="col-md-8">
                                        <select class="js-example-disabled form-control" onchange="location.assign(`{{url('pekerjaan')}}?id=`+this.value)" name="state">
                                            <option selected="">-- Pilih Project </option>
                                            @foreach(get_kontrak() as $o)
                                            <option value="{{encoder($o->id)}}" @if($ide==$o->id) selected @endif >{{$o->customer}} - {{$o->deskripsi_project}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="btn-group btn-group-sm shadow" role="group" aria-label="Button group with nested dropdown">
                                            <button type="button" onclick="window.open(`{{url('pekerjaan/cetak')}}?id={{encoder($id)}}`,`blank`)" class="btn btn-success waves-effect waves-light shadow-none"><i class="mdi mdi-printer"></i> Cetak Laporan</button>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-light waves-effect waves-light shadow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-filter"></i> Filter
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item" href="{{url('pekerjaan')}}?id={{encoder($id)}}&act=0" onchange="location.assign(`{{url('pekerjaan')}}?id={{encoder($id)}}&act=0`)">Tampilkan Semua</a></li>
                                                    <li><a class="dropdown-item" href="{{url('pekerjaan')}}?id={{encoder($id)}}&act=1" onchange="location.assign(`{{url('pekerjaan')}}?id={{encoder($id)}}&act=1`)">Proses Pengerjaan</a></li>
                                                    <li><a class="dropdown-item" href="{{url('pekerjaan')}}?id={{encoder($id)}}&act=2" onchange="location.assign(`{{url('pekerjaan')}}?id={{encoder($id)}}&act=2`)">Selesai</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </h4>
                                
                            </div>
                        </div>
                        <div class="row" id="tampil-baru">
                            
                        </div>
                        
                    </div> <!-- end col-->
                    <div class="col-lg-2" style="background: #e3e3ed;padding-top:1%">
                        
                            
                        <div class="card" style="margin-top:3%">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="mdi mdi-check-network"></i> Progres Pekerjaan</h4>
                                
                            </div><!-- end card header -->
                            
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
                    
                            


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
            function close_data(id){
				Swal.fire({
				   title: "Yakin akan melakukan close pada pekerjaan ini ?",
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
                                url: "{{url('pekerjaan/close_data')}}",
                                data: "id="+id,
                                beforeSend: function() {
                                    document.getElementById("loadnya").style.width = "100%";
                                },
                                success: function(msg){
                                    var bat=msg.split('@');
                                    if(bat[1]=='ok'){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });

                                        location.reload();
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