
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
            $.ajax({ 
                type: 'GET', 
                url: "{{ url('sales/get_data')}}", 
                data: { idee: 1 }, 
                dataType: 'json',
                beforeSend: function() {
                    $("#tampil_sales").html('<div class="col-xl-12 col-lg-6">'
                                                    +'<div class="card tasks-box ">' 
                                                        +'<div class="card-body">'
                                                            +'<p class="card-text placeholder-glow">'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-12"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-11"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-10"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-9"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-8"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-7"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-6"></span>'
                                                                +'<span style="height: 10px;margin-bottom:2%" class="placeholder col-6"></span>'
                                                            +'</p>'
                                                        +'</div>'
                                                    +'</div>'
                                                +'</div>');
                },
                success: function (show) {
                    $("#tampil_sales").html('');
                    $.each(show, function(i, result){
                        
                        var tampil='<div class="col-xl-3 col-lg-6">'
                                    +'<div class="card ribbon-box right overflow-hidden">'
                                        +'<div class="card-body text-center p-3">'
                                            +'<div class="ribbon ribbon-'+result.color+' ribbon-shape trending-ribbon"><i class="ri-flashlight-fill text-white align-bottom"></i> <span class="trending-ribbon-text">'+result.persen+'</span></div>'
                                            +'<div class="profile-user position-relative d-inline-block mx-auto  mb-4">'
                                                +'<img src="'+result.photo+'" alt="" class="rounded-circle avatar-lg img-thumbnail user-profile-image  shadow" height="45">'
                                            +'</div>'
                                            +'<h5 class="mb-1 mt-4"><a href="{{url('sales/view')}}/'+result.id+'" class="link-primary" style="text-transform:uppercase">'+result.name+'</a></h5>'
                                            +'<p class="text-muted mb-4">'+result.role+'</p>'
                                            +'<div class="row justify-content-center">'
                                                +'<div class="col-lg-8">'
                                                    +'<div id="chart-seller1" data-colors="[`--vz-danger`]"></div>'
                                                +'</div>'
                                            +'</div>'
                                            +'<div class="row mt-2">'
                                                +'<div class="col-md-8">'
                                                    +'<span class="text-muted">PROSPEK / PROSES</span>'
                                                +'</div>'
                                                +'<div class="col-md-1">:</div>'
                                                +'<div class="col-md-2">'+result.prospek+'</div>'
                                                +'<div class="col-md-8">'
                                                    +'<span class="text-muted">KONTRAK</span>'
                                                +'</div>'
                                                +'<div class="col-md-1">:</div>'
                                                +'<div class="col-md-2">'+result.kontrak+'</div>'
                                                +'<div class="col-md-8">'
                                                    +'<span class="text-muted">DIBATALKAN</span>'
                                                +'</div>'
                                                +'<div class="col-md-1">:</div>'
                                                +'<div class="col-md-2">'+result.gagal+'</div>'
                                                
                                            +'</div>'
                                            +'<div class="mt-4">'
                                                +'<a href="{{url('sales/view')}}/'+result.id+'" class="btn btn-light w-100">View Details</a>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>';
                        $("#tampil_sales").append(tampil);
                    });

                }
            });
                
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
                                <h4 class="mb-sm-0">Sales Performance</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Sales Performance</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    
                    <div class="row mt-4 " id="tampil_sales">
                        
                       
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade zoomIn" id="addSeller" tabindex="-1" aria-labelledby="addSellerLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addSellerLabel">Add Seller</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-content border-0 mt-3">
                                    <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                                Personal Details
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#businessDetails" role="tab" aria-selected="false">
                                                Business Details
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#bankDetails" role="tab" aria-selected="false">
                                                Bank Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">First Name</label>
                                                            <input type="text" class="form-control" id="firstnameInput" placeholder="Enter your firstname">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Last Name</label>
                                                            <input type="text" class="form-control" id="lastnameInput" placeholder="Enter your lastname">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="contactnumberInput" class="form-label">Contact Number</label>
                                                            <input type="number" class="form-control" id="contactnumberInput" placeholder="Enter your number">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                            <input type="number" class="form-control" id="phonenumberInput" placeholder="Enter your number">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="emailidInput" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="emailidInput" placeholder="Enter your email">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="birthdayidInput" class="form-label">Date of Birth</label>
                                                            <input type="text" id="birthdayidInput" class="form-control" data-provider="flatpickr" placeholder="Enter your date of birth">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="cityidInput" class="form-label">City</label>
                                                            <input type="text" class="form-control" id="cityidInput" placeholder="Enter your city">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="countryidInput" class="form-label">Country</label>
                                                            <input type="text" class="form-control" id="countryidInput" placeholder="Enter your country">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="zipcodeidInput" class="form-label">Zip Code</label>
                                                            <input type="text" class="form-control" id="zipcodeidInput" placeholder="Enter your zipcode">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter description"></textarea>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button class="btn btn-link link-success text-decoration-none fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                            <button type="submit" class="btn btn-primary"><i class="ri-save-3-line align-bottom me-1"></i> Save</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="businessDetails" role="tabpanel">
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="companynameInput" class="form-label">Company Name</label>
                                                            <input type="text" class="form-control" id="companynameInput" placeholder="Enter your company name">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="choices-single-default" class="form-label">Company Type</label>
                                                            <select class="form-control" data-trigger name="choices-single-default" id="choices-single-default">
                                                                <option value="">Select type</option>
                                                                <option value="All" selected>All</option>
                                                                <option value="Merchandising">Merchandising</option>
                                                                <option value="Manufacturing">Manufacturing</option>
                                                                <option value="Partnership">Partnership</option>
                                                                <option value="Corporation">Corporation</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="pancardInput" class="form-label">Pan Card Number</label>
                                                            <input type="text" class="form-control" id="pancardInput" placeholder="Enter your pan-card number">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="websiteInput" class="form-label">Website</label>
                                                            <input type="url" class="form-control" id="websiteInput" placeholder="Enter your URL">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="faxInput" class="form-label">Fax</label>
                                                            <input type="text" class="form-control" id="faxInput" placeholder="Enter your fax">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="companyemailInput" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="companyemailInput" placeholder="Enter your email">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="worknumberInput" class="form-label">Number</label>
                                                            <input type="number" class="form-control" id="worknumberInput" placeholder="Enter your number">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="companylogoInput" class="form-label">Company Logo</label>
                                                            <input type="file" class="form-control" id="companylogoInput">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button class="btn btn-link link-success text-decoration-none fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                            <button type="submit" class="btn btn-primary"><i class="ri-save-3-line align-bottom me-1"></i> Save</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="bankDetails" role="tabpanel">
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="banknameInput" class="form-label">Bank Name</label>
                                                            <input type="text" class="form-control" id="banknameInput" placeholder="Enter your bank name">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="branchInput" class="form-label">Branch</label>
                                                            <input type="text" class="form-control" id="branchInput" placeholder="Branch">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="accountnameInput" class="form-label">Account Holder Name</label>
                                                            <input type="text" class="form-control" id="accountnameInput" placeholder="Enter account holder name">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="accountnumberInput" class="form-label">Account Number</label>
                                                            <input type="number" class="form-control" id="accountnumberInput" placeholder="Enter account number">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="ifscInput" class="form-label">IFSC</label>
                                                            <input type="number" class="form-control" id="ifscInput" placeholder="IFSC">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button class="btn btn-link link-success text-decoration-none fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                            <button type="submit" class="btn btn-primary"><i class="ri-save-3-line align-bottom me-1"></i> Save</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->

                </div>
                <!-- container-fluid -->
            </div>

        <div id="modal-form" class="modal fade flip " tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">                                               <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"><i class="mdi mdi-account-circle-outline"></i> Authentication</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  id="mydataform" method="post" action="{{ url('user') }}" enctype="multipart/form-data" >
                            @csrf
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
				$('#modal-form').modal('show')
				$('#tampil-form').load("{{url('user/modal')}}?id="+id)
			} 
            function hanyaAngka(evt) {
				
				var charCode = (evt.which) ? evt.which : event.keyCode
				if ((charCode > 47 && charCode < 58 ) || (charCode > 96 && charCode < 123 ) || charCode==95 ){
					
					return true;
				}else{
					return false;
				}
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
            function delete_data(id,act){
                if(act==2){
                    Swal.fire({
                        title: "Yakin menghapus user ini ?",
                        text: "data akan hilang dari data user  ini",
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
                                    url: "{{url('user/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('user/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==1){
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
                                    url: "{{url('user/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('user/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==3){
                    Swal.fire({
                        title: "Yakin mengaktifkan user ini ?",
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
                                    url: "{{url('user/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('user/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                
            } 
            function kembali_diproses(id,act){
                if(act==2){
                    Swal.fire({
                        title: "Yakin menghapus user ini ?",
                        text: "data akan hilang dari data user  ini",
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
                                    url: "{{url('user/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('user/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==1){
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
                                    url: "{{url('user/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('user/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                if(act==3){
                    Swal.fire({
                        title: "Yakin mengaktifkan user ini ?",
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
                                    url: "{{url('user/delete')}}",
                                    data: "id="+id+"&act="+act,
                                    success: function(msg){
                                        Swal.fire({
                                            title: "Sukses diproses",
                                            type: "warning",
                                            icon: "success",
                                            
                                            align:"center",
                                            
                                        });
                                        var tables=$('#data-table-fixed-header').DataTable();
                                            tables.ajax.url("{{ url('user/getdata')}}").load();
                                    }
                                });
                                
                            }
                        
                    });
                }
                
            } 
        </script>
@endpush