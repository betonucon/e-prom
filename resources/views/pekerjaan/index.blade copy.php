
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
                url: "{{ url('pekerjaan/getdata')}}?id={{encoder($id)}}", 
                data: { ide: 1 }, 
                dataType: 'json',
                beforeSend: function() {
                    $('#tampil-baru').html("")
                    $('#tampil-progres').html("")
                    $('#tampil-selesai').html("")
                    
                },
                success: function (data) {
                    
                    $('#pekerjaan_baru').html(data.baru);
                    $('#pekerjaan_progres').html(data.progres);
                    $('#pekerjaan_total').html(data.total);
                    $('#pekerjaan_persen').html('<h2 class="mb-0"><span class="counter-value" data-target="'+data.persen+'">'+data.persen+'</span>%</h2>');
                    $('#pekerjaan_selesai').html(data.selesai);
                    $('#pekerjaan_outstanding').html(data.outstanding);
                    $.each(data.data_new, function(i, result){
                        $("#tampil-baru").append('<div class="accordion-item shadow">'
                            +'<h2 class="accordion-header" id="accordionnestingExample1'+result.pekerjaan_id+'">'
                                +'<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_nestingExamplecollapse2'+result.pekerjaan_id+'" aria-expanded="false" aria-controls="accor_nestingExamplecollapse2'+result.pekerjaan_id+'">'
                                    +'<div class="row" style="display: contents;">'
                                        +'<div class="col-md-11">'
                                            +'<span class="badge bg-'+result.color_status+' fs-15">'+result.int_status_project+'</span> '+result.pekerjaan
                                            +'<div class="flex-grow-1 mt-4">'
                                                +'<div class="progress animated-progress custom-progress progress-label">'
                                                    +'<div class="progress-bar bg-primary" role="progressbar" style="width: '+result.persen_project+'%" aria-valuenow="'+result.persen_project+'" aria-valuemin="0" aria-valuemax="100">'
                                                        +'<div class="label">'+result.persen_project+'%</div>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col-md-1" style="font-weight: bold; color: #4f4fa3;">'
                                            +result.total_aktivitas
                                        +'</div>'
                                     +'</div>'
                                +'</button>'
                            +'</h2>'
                            +'<div id="accor_nestingExamplecollapse2'+result.pekerjaan_id+'" class="accordion-collapse collapse" aria-labelledby="accordionnestingExample1'+result.pekerjaan_id+'" data-bs-parent="#accordionnesting">'
                                +'<div class="accordion-body" style="background: #f5f5fd;">'
                                    +'<div class="row align-items-center " style="background: #ecede7;padding: 1%; margin-bottom: 1%;">'
                                        +'<div class="col-auto" style="padding: 1%;">'
                                            +'<div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3 shadow">'
                                                +'<div class="text-center">'
                                                    +'<h5 class="mb-0">'+result.total_hari+'</h5>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col">'
                                            +'<h5 class="text-muted mt-0 mb-1 fs-13">'+result.mulai+' - '+result.sampai+'</h5>'
                                            +'<a href="#" class="text-reset fs-14 mb-0">'+result.pekerjaan+'</a>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="row row-cols-md-2 row-cols-1" style="background: #fff;">'
                                        +'<div class="col col-lg border-end">'
                                            +'<div class="py-3 px-3">'
                                                +'<h5 class="text-muted text-uppercase fs-13">Lama Pekerjaan <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>'
                                                +'</h5>'
                                                +'<div class="d-flex align-items-center">'
                                                    +'<div class="flex-shrink-0">'
                                                        +'<i class="mdi mdi-av-timer display-6 text-muted"></i>'
                                                    +'</div>'
                                                    +'<div class="flex-grow-1 ms-3">'
                                                        +'<h2 class="mb-0"><span class="counter-value" data-target="'+result.total_hari+'">'+result.total_hari+' Days</span></h2>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col col-lg border-end">'
                                            +'<div class="py-3 px-3">'
                                                +'<h5 class="text-muted text-uppercase fs-13" style="color:'+result.warna_status+'" >Sisa Waktu <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>'
                                                +'</h5>'
                                                +'<div class="d-flex align-items-center">'
                                                    +'<div class="flex-shrink-0">'
                                                        +'<i class="mdi mdi-av-timer display-6 text-muted" style="color:'+result.warna_status+'" ></i>'
                                                    +'</div>'
                                                    +'<div class="flex-grow-1 ms-3">'
                                                        +'<h2 class="mb-0"><span class="counter-value" style="color:'+result.warna_status+'" data-target="'+result.sisa_waktu+'">'+result.sisa_waktu+' Days</span></h2>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col col-lg border-end">'
                                            +'<div class="py-3 px-3">'
                                                +'<h5 class="text-muted text-uppercase fs-13">Persentase<i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>'
                                                +'</h5>'
                                                +'<div class="d-flex align-items-center">'
                                                    +'<div class="flex-shrink-0">'
                                                        +'<i class="mdi mdi-chart-bar-stacked display-6 text-muted" ></i>'
                                                    +'</div>'
                                                    +'<div class="flex-grow-1 ms-3">'
                                                        +'<h2 class="mb-0"><span class="counter-value" data-target="'+result.persen_project+'">'+result.persen_project+'</span></h2>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="row align-items-center " style="padding: 2px; margin-bottom: 1%;">'
                                        +'<div class="col-auto" style="padding: 1%;">'
                                            +'<button type="button" onclick="location.assign(`{{url('pekerjaan/view')}}?id='+result.pekerjaan_id+'`)" class="btn btn-primary btn-sm btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Aktivitas Pekerjaan</button>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>');
                    });
                    
                    $.each(data.data_selesai, function(i, result){
                        $("#tampil-selesai").append('<div class="accordion-item shadow">'
                            +'<h2 class="accordion-header" id="accordionnestingExample1'+result.pekerjaan_id+'">'
                                +'<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_nestingExamplecollapse2'+result.pekerjaan_id+'" aria-expanded="false" aria-controls="accor_nestingExamplecollapse2'+result.pekerjaan_id+'">'
                                    +'<div class="row" style="display: contents;">'
                                        +'<div class="col-md-11">'
                                            +'<span class="badge bg-'+result.color_status+' fs-15">'+result.int_status_project+'</span> '+result.pekerjaan
                                        +'</div>'
                                        +'<div class="col-md-1" style="font-weight: bold; color: #4f4fa3;">'
                                            +result.total_aktivitas
                                        +'</div>'
                                     +'</div>'
                                +'</button>'
                            +'</h2>'
                            +'<div id="accor_nestingExamplecollapse2'+result.pekerjaan_id+'" class="accordion-collapse collapse" aria-labelledby="accordionnestingExample1'+result.pekerjaan_id+'" data-bs-parent="#accordionnesting">'
                                +'<div class="accordion-body" style="background: #f5f5fd;">'
                                    +'<div class="row align-items-center " style="background: #ecede7;padding: 1%; margin-bottom: 1%;">'
                                        +'<div class="col-auto" style="padding: 1%;">'
                                            +'<div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3 shadow">'
                                                +'<div class="text-center">'
                                                    +'<h5 class="mb-0">'+result.total_hari+'</h5>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col">'
                                            +'<h5 class="text-muted mt-0 mb-1 fs-13">'+result.mulai+' - '+result.sampai+'</h5>'
                                            +'<a href="#" class="text-reset fs-14 mb-0">'+result.pekerjaan+'</a>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="row row-cols-md-2 row-cols-1" style="background: #fff;">'
                                        +'<div class="col col-lg border-end">'
                                            +'<div class="py-3 px-3">'
                                                +'<h5 class="text-muted text-uppercase fs-13">Lama Pekerjaan <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>'
                                                +'</h5>'
                                                +'<div class="d-flex align-items-center">'
                                                    +'<div class="flex-shrink-0">'
                                                        +'<i class="mdi mdi-av-timer display-6 text-muted"></i>'
                                                    +'</div>'
                                                    +'<div class="flex-grow-1 ms-3">'
                                                        +'<h2 class="mb-0"><span class="counter-value" data-target="'+result.total_hari+'">'+result.total_hari+' Days</span></h2>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col col-lg border-end">'
                                            +'<div class="py-3 px-3">'
                                                +'<h5 class="text-muted text-uppercase fs-13" style="color:'+result.warna_status+'" >Sisa Waktu <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>'
                                                +'</h5>'
                                                +'<div class="d-flex align-items-center">'
                                                    +'<div class="flex-shrink-0">'
                                                        +'<i class="mdi mdi-av-timer display-6 text-muted" style="color:'+result.warna_status+'" ></i>'
                                                    +'</div>'
                                                    +'<div class="flex-grow-1 ms-3">'
                                                        +'<h2 class="mb-0"><span class="counter-value" style="color:'+result.warna_status+'" data-target="'+result.sisa_waktu+'">'+result.sisa_waktu+' Days</span></h2>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="col col-lg border-end">'
                                            +'<div class="py-3 px-3">'
                                                +'<h5 class="text-muted text-uppercase fs-13">Persentase<i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>'
                                                +'</h5>'
                                                +'<div class="d-flex align-items-center">'
                                                    +'<div class="flex-shrink-0">'
                                                        +'<i class="mdi mdi-chart-bar-stacked display-6 text-muted" ></i>'
                                                    +'</div>'
                                                    +'<div class="flex-grow-1 ms-3">'
                                                        +'<h2 class="mb-0"><span class="counter-value" data-target="'+result.persen_project+'">'+result.persen_project+'</span></h2>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="row align-items-center " style="padding: 2px; margin-bottom: 1%;">'
                                        +'<div class="col-auto" style="padding: 1%;">'
                                            +'<button type="button" onclick="location.assign(`{{url('pekerjaan/view')}}?id='+result.pekerjaan_id+'`)" class="btn btn-primary btn-sm btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Aktivitas Pekerjaan</button>'
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
                

                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.open(`{{url('pekerjaan/cetak')}}?id={{encoder($id)}}`,`blank`)" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Cetak Laporan Pekerjaan</button>
                            </div>
                            <div class="col-lg-6" style="padding-bottom:1%">
                               
                                <select class="js-example-disabled form-control" onchange="location.assign(`{{url('pekerjaan')}}?id=`+this.value)" name="state">
                                    <option selected="">-- Pilih Project </option>
                                    @foreach(get_kontrak() as $o)
                                    <option value="{{encoder($o->id)}}" @if($ide==$o->id) selected @endif >{{$o->customer}} - {{$o->deskripsi_project}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3" style="background: #e3e3ed;padding-top:1%">
                                <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-left" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active show" id="custom-v-pills-home-tab" data-bs-toggle="pill" href="#custom-v-pills-home" role="tab" aria-controls="custom-v-pills-home" aria-selected="true">
                                        
                                    <span class="badge bg-success ms-1 fs-14" id="pekerjaan_baru">0</span> Pekerjaan Dalam Proses </a>
                                    <a class="nav-link" id="custom-v-pills-messages-tab" data-bs-toggle="pill" href="#custom-v-pills-messages" role="tab" aria-controls="custom-v-pills-messages" aria-selected="false">
                                        
                                    <span class="badge bg-success ms-1  fs-14" id="pekerjaan_selesai">0</span> Pekerjaan Selesai </a>
                                </div>
                                    
                                <div class="card" style="margin-top:3%">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1"><i class="mdi mdi-check-network"></i> Progres Pekerjaan</h4>
                                        
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="row row-cols-md-3 row-cols-1">
                                            <div class="col col-lg border-end">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13">Presentase Pekerjaan <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i>
                                                    </h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-pulse-line display-6 text-muted"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3" id="pekerjaan_persen">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 "><b><i class="mdi mdi-clipboard-list"></i> Total Pekerjaan</b></p>
                                            <div class="badge badge-soft-success fs-14" style="margin-left:5%"  id="pekerjaan_total"></div>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 "><b><i class="mdi mdi-clipboard-list"></i> Lewat Waktu / Outstanding</b></p>
                                            <div class="badge badge-soft-success fs-14" style="margin-left:5%" id="pekerjaan_outstanding"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-lg-9" style="background: #e3e3ed;padding-top:1%">
                                <div class="tab-content text-muted mt-3 mt-lg-0">
                                    <div class="tab-pane fade active show" id="custom-v-pills-home" role="tabpanel" aria-labelledby="custom-v-pills-home-tab">
                                        
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Draft Pekerjaan Baru</h4>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch form-switch-right form-switch-md">
                                                        <label for="accordion-nesting-showcode" class="form-label text-muted">Show Code</label>
                                                        <input class="form-check-input code-switcher" type="checkbox" id="accordion-nesting-showcode">
                                                    </div>
                                                </div>
                                            </div><!-- end card header -->
                                            <div class="card-body">
                                                <!-- <p class="text-muted">Use <code>nesting-accordion</code> class to create a nesting accordion.</p> -->
                                                <div class="live-preview">
                                                    <div class="accordion custom-accordionwithicon accordion-border-box" id="tampil-baru">
                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   

                                   </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane fade" id="custom-v-pills-profile" role="tabpanel" aria-labelledby="custom-v-pills-profile-tab">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Draft Pekerjaan Dalam Proses</h4>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch form-switch-right form-switch-md">
                                                        <label for="accordion-nesting-showcode" class="form-label text-muted">Show Code</label>
                                                        <input class="form-check-input code-switcher" type="checkbox" id="accordion-nesting-showcode">
                                                    </div>
                                                </div>
                                            </div><!-- end card header -->
                                            <div class="card-body">
                                                <!-- <p class="text-muted">Use <code>nesting-accordion</code> class to create a nesting accordion.</p> -->
                                                <div class="live-preview">
                                                    <div class="accordion custom-accordionwithicon accordion-border-box" id="tampil-progres">
                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane fade" id="custom-v-pills-messages" role="tabpanel" aria-labelledby="custom-v-pills-messages-tab">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Draft Pekerjaan Selesai</h4>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch form-switch-right form-switch-md">
                                                        <label for="accordion-nesting-showcode" class="form-label text-muted">Show Code</label>
                                                        <input class="form-check-input code-switcher" type="checkbox" id="accordion-nesting-showcode">
                                                    </div>
                                                </div>
                                            </div><!-- end card header -->
                                            <div class="card-body">
                                                <!-- <p class="text-muted">Use <code>nesting-accordion</code> class to create a nesting accordion.</p> -->
                                                <div class="live-preview">
                                                    <div class="accordion custom-accordionwithicon accordion-border-box" id="tampil-selesai">
                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!--end tab-pane-->
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div><!-- end card-body -->
                </div>
                <!--end card-->
                            


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