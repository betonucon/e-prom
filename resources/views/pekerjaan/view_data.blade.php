
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
                url: "{{ url('pekerjaan/getdatadetail')}}?id={{$id}}&tanggal={{$tanggal}}", 
                data: { ide: 1 }, 
                dataType: 'json',
                beforeSend: function() {
                    $('#tampil-detail').html("")
                    
                },
                success: function (data) {
                    
                    // $('#pekerjaan_baru').html(data.baru);
                    // $('#pekerjaan_progres').html(data.progres);
                    // $('#pekerjaan_selesai').html(data.selesai);
                    $.each(data.detail, function(i, result){
                        $("#tampil-detail").append('<div class="col-xl-6">'
                               +'<div class="card">'
                                    +'<div class="card-header align-items-center d-flex">'
                                        +'<h4 class="card-title mb-0 flex-grow-1">'+result.tanggal+'</h4>'
                                        +'<div class="flex-shrink-0">'
                                            +'<button type="button" onclick="tambah('+result.id+')" class="btn btn-sm btn-info waves-effect waves-light"><i class="mdi mdi-grease-pencil fs-16"></i></button>'
                                            +'<button type="button" onclick="delete_data('+result.id+')" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline fs-16"></i></button>'
                                        +'</div>'
                                    
                                    +'</div>'
                                    +'<div class="card-body">'
                                        +'<p class="text-muted">'+result.aktifitas+'</p>'
                                        +'<div class="live-preview">'
                                           +'<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">'
                                                +'<div class="carousel-inner" role="listbox">'
                                                    +'<div class="carousel-item carousel-item-next carousel-item-start">'
                                                        +'<img class="d-block img-fluid mx-auto" src="{{url_plug()}}/attach/pekerjaan/'+result.foto+'" alt="First slide">'
                                                   +'</div>'
                                                    
                                                +'</div>'
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
                        <div class="row" style="padding-bottom:2%">
                            <div class="col-lg-3">
                                <button type="button" onclick="tambah(0)" class="btn btn-primary btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Tambah Aktivitas</button>
                            </div>
                            <div class="col-lg-5">

                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" ><i class="mdi mdi-calendar-month-outline"></i></span>
                                    <input type="text" class="form-control tanggal" data-provider="flatpickr" data-date-format="Y-m-d" data-deafult-date="{{date('Y-m-d')}} "  name="tanggal" value="{{$data->tanggal_aktifitas}}" placeholder="Enter.....">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <button type="button" onclick="cari()" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Cari</button>
                            </div>
                        </div>
                        <div class="row" id="tampil-detail" style="background: #e3e3ed;padding-top:1%;min-height:300px">
                            
                            

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
                        <h5 class="modal-title" id="myModalLabel"><i class="mdi mdi-account-circle-outline"></i> Form Aktifitas Pekerjaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  id="mydataaktifitas" method="post" action="{{ url('pekerjaan/aktifitas') }}" enctype="multipart/form-data" >
                            @csrf
                            <!-- <input type="submit"> -->
                            <input type="hidden" name="pekerjaan_id" value="{{$data->id}}">
                            <div id="tampil-form"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary " id="saveButton">Save Changes</button>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>       
@endsection
@push('ajax')
        <link rel="stylesheet" href={{url_plug()}}/js/flatpickr.min.css">
        <script src="{{url_plug()}}/js/flatpickr.js"></script>
        <script type="text/javascript">
			
                   
            $(".tanggal").flatpickr();    
			function tambah(id){
				$('#tampil-form').load("{{url('pekerjaan/modal_aktifitas')}}?id="+id);
				$('#modal-form').modal('show');
			} 
			function cari(){
                var tanggal=$('.tanggal').val();
				location.assign("{{url('pekerjaan/view')}}?id={{$data->id}}&tanggal="+tanggal);
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
				var editorContent = CKEDITOR.instances.editorContent.getData(); // Dapatkan konten dari CKEditor
			}
            function delete_data(id){
                
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
                                    url: "{{url('pekerjaan/delete_aktifitas')}}",
                                    data: "id="+id,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        load_data();
                                    }
                                });
                                
                            }
                        
                    });
               
            } 
            
             
        </script>
@endpush