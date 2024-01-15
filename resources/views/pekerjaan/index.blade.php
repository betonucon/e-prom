
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
                <h5 class="mb-3">Custom Vertical Tabs</h5>
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">Use <code>custom-verti-nav-pills</code> class to create custom vertical tabs.</p>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active show" id="custom-v-pills-home-tab" data-bs-toggle="pill" href="#custom-v-pills-home" role="tab" aria-controls="custom-v-pills-home" aria-selected="true">
                                        <i class="ri-home-4-line d-block fs-20 mb-1"></i>
                                        Home</a>
                                    <a class="nav-link" id="custom-v-pills-profile-tab" data-bs-toggle="pill" href="#custom-v-pills-profile" role="tab" aria-controls="custom-v-pills-profile" aria-selected="false">
                                        <i class="ri-user-2-line d-block fs-20 mb-1"></i>
                                        Profile</a>
                                    <a class="nav-link" id="custom-v-pills-messages-tab" data-bs-toggle="pill" href="#custom-v-pills-messages" role="tab" aria-controls="custom-v-pills-messages" aria-selected="false">
                                        <i class="ri-mail-line d-block fs-20 mb-1"></i>
                                        Messages</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-lg-9">
                                <div class="tab-content text-muted mt-3 mt-lg-0">
                                    <div class="tab-pane fade active show" id="custom-v-pills-home" role="tabpanel" aria-labelledby="custom-v-pills-home-tab">
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-4.jpg" alt="" width="150" class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0">Experiment and play around with the fonts that you already have in the software you’re working with reputable font websites. commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus.</p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-grow-1 me-3">
                                                <p class="mb-0">Always want to make sure that your fonts work well together and try to limit the number of fonts you use to three or less. Experiment and play around with the fonts that you already have in the software you’re working with reputable font websites.</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-5.jpg" alt="" width="150" class="rounded">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane fade" id="custom-v-pills-profile" role="tabpanel" aria-labelledby="custom-v-pills-profile-tab">
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-3.jpg" alt="" width="150" class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0">In some designs, you might adjust your tracking to create a certain artistic effect. It can also help you fix fonts that are poorly spaced to begin with. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-grow-1 me-3">
                                                <p class="mb-0">Each design is a new, unique piece of art birthed into this world, and while you have the opportunity to be creative and make your own style choices. For that very reason, I went on a quest and spoke to many different professional graphic designers.</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-6.jpg" alt="" width="150" class="rounded">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane fade" id="custom-v-pills-messages" role="tabpanel" aria-labelledby="custom-v-pills-messages-tab">
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-7.jpg" alt="" width="150" class="rounded">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0">Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR.</p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-grow-1 me-3">
                                                <p class="mb-0">They all have something to say beyond the words on the page. They can come across as casual or neutral, exotic or graphic. That's why it's important to think about your message, then choose a font that fits. Cosby sweater eu banh mi, qui irure terry richardson ex squid.</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/small/img-8.jpg" alt="" width="150" class="rounded">
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