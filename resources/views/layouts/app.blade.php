<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <meta charset="utf-8" />
    <title>E-PROM | KPDP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url_plug()}}/assets/images/fav.png">

    <!--datatable css-->
    <link rel="stylesheet" href="{{url_plug()}}/assets/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{url_plug()}}/assets/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="{{url_plug()}}/assets/css/buttons.dataTables.min.css">
    <link href="{{url_plug()}}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    

    <!-- Layout config Js -->
    <script src="{{url_plug()}}/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{url_plug()}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url_plug()}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url_plug()}}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{url_plug()}}/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url_plug()}}/js/select2.min.css" rel="stylesheet" />
    <style>
        [data-layout="vertical"][data-sidebar="dark"] .navbar-menu {
            background-image: linear-gradient(to right top, #f8fbff, #eaedf2, #dcdfea, #9b9fd3, #897fc0);border-right: 1px solid #d0d0db;
            border-right: 1px solid #d0d0db;
        }
        [data-layout="vertical"][data-sidebar="dark"] .navbar-nav .nav-link {
            color: #494c5e;
        }
        [data-layout="vertical"][data-sidebar="dark"] .navbar-nav .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] {
            color: #756363;
        }
        
        .navbar-brand-box {
            padding: 0 1.3rem;
            text-align: center;
            -webkit-transition: all .1s ease-out;
            transition: all .1s ease-out;
            background: #f5f5ff;
        }
        .tasks-board .tasks-list {
            min-width: 340px;
            margin-right: 24px;
        }
        table.table-bordered.dataTable td {
            border-left-width: 0;
            font-size:13px;
            padding: 4px 6px !important;
        }
        table.table-bordered.dataTable th {
            text-transform:uppercase;
            background: #eaeaf7;
        }
        .form-control-sm {
            min-height: calc(1.5em + 0.5rem + 2px);
            padding: 0.25rem 0.5rem;
            font-size: .7309375rem;
            border-radius: 0.2rem;
        }
        .navbar-menu {
            width: 230px;
            z-index: 1002;
            background: var(--vz-vertical-menu-bg);
            border-right: 1px solid #fff;
            bottom: 0;
            margin-top: 0;
            position: fixed;
            top: 0;
            -webkit-box-shadow: 0 2px 4px rgba(15,34,58,.12);
            box-shadow: 0 2px 4px rgba(15,34,58,.12);
            padding: 0 0 calc(70px + 25px) 0;
            -webkit-transition: all .1s ease-out;
            transition: all .1s ease-out;
        }
        @media (min-width: 768px){
            #page-topbar {
                left: 230px;
            }
        }
        @media (min-width: 768px){
            .main-content {
                margin-left: 230px;
            }
        }
        .navbar-menu .navbar-nav .nav-link {
            font-size: .825rem !important;
            font-family: Inter,sans-serif;
        }
        .footer {
            bottom: 0;
            padding: 20px calc(1.5rem / 2);
            position: absolute;
            right: 0;
            color: var(--vz-footer-color);
            left: 230px;
            height: 60px;
            background-color: var(--vz-footer-bg);
        }
        .input-group-sm>.btn, .input-group-sm>.form-control, .input-group-sm>.form-select, .input-group-sm>.input-group-text {
            padding: 0.25rem 0.5rem;
            font-size: .7209375rem;
            border-radius: 0.2rem;
        }
        [data-layout=vertical][data-sidebar=dark] .navbar-nav .nav-sm .nav-link {
            color: #35353a;
        }
        .modal-header {
            background: #dddde9;
            padding-bottom: 2% !important;
        }
        .modal-footer {
            background: #dddde9;
            padding-top: 1% !important;
        }
        .loadnya {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1070;
			top: 0;
			left: 0;
			background-color: rgb(0,0,0);
			background-color: rgb(243 230 230 / 81%);
			overflow-x: hidden;
			transition: transform .9s;
		}
		.loadnya-content {
			position: relative;
			top: 25%;
			width: 100%;
			text-align: center;
			margin-top: 30px;
			color:#fff;
			font-size:20px;
		}
    </style>

</head>

<body>

    <div id="loadnya" class="loadnya">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="loadnya-content">
			<button class="btn btn-light" type="button" disabled>
  				Loading...
			</button>
        </div>
	</div>
    <div id="layout-wrapper">

    <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    
                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{url_plug()}}/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                           
                            INTERFACE
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{url_plug()}}/assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{url_plug()}}/assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{url_plug()}}/assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Searchsss ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-bell fs-22'></i>
                            @if(count_approve()>0)
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{count_approve()}}<span class="visually-hidden">unread messages</span></span>
                            @else
                            <span class="visually-hidden">unread messages</span>
                            @endif
                        </button>
                        @if(count_approve()>0)
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        @else
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" >
                        @endif
                            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white"> Konfirmasi Approve</h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge badge-soft-light fs-13"> {{count_approve()}} New</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                                Notification
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>

                            </div>

                            <div class="tab-content" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    @foreach(get_approve() as $opv)
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                        <i class="bx bx-badge-check"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a href="{{url('project/view')}}?id={{encoder($opv->id)}}" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base"><b>{{$opv->status}}</b></h6>
                                                    </a>
                                                    <p class="mb-0 fs-9 fw-medium text-uppercase text-muted" title="Approve {{$opv->deskripsi_project}}">
                                                        {{substr($opv->deskripsi_project,0,50)}}
                                                    </p>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                    </p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                        
                                    </div>

                                </div>

                                
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{url_plug()}}/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Administrator</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{Auth::user()->name}}</h6>
                        <!-- <a class="dropdown-item" href="{{url('service')}}"><i class="mdi mdi-cube-outline"></i> <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></a>
                        <a class="dropdown-item" href="{{url('user')}}"><i class="mdi mdi-account-circle-outline"></i> <span class="align-middle">Authentication</span></a> -->
                        <a class="dropdown-item" href="#" id="logout" ><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{url_plug()}}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url_plug()}}/assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{url_plug()}}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url_plug()}}/assets/images/logo.png" alt="" height="50">
                     
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div class="card show-pc">
                        <div class="card-body p-2" style="background: #e7e7f1;">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="{{img_profil(Auth::user()->id)}}" id="imgPreview" class="rounded-circle avatar-lg img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <form  id="mydataavatar" method="post" action="" enctype="multipart/form-data" >
                                            @csrf    
                                            <input id="profile-img-file-input" name="file_avatar" accept="image/*" type="file" class="profile-img-file-input">
                                        </form>    
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body shadow">
                                                <i class="ri-camera-fill"></i>
                                                
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="fs-16 mb-1">{{Auth::user()->name}}</h5>
                                <p class="text-muted mb-0">{{Auth::user()->role['role']}}</p>
                            </div>
                        </div>
                    </div>
                    <div id="two-column-menu">
                    </div>
                    @include('layouts.side')
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
            <div class="main-content">
                @yield('content')
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                ©SyncPoint.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by SyncPoint
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <div id="modal-foto-profil" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <img src="{{ img_profil(Auth::user()->id) }}" id="imgPreviewmodal"
                        class="rounded-circle img-thumbnail user-profile-image  shadow" alt="user-profile-image">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary " id="save-update-profil">Update Avatar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{url_plug()}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script>
        (document.querySelectorAll("[toast-list]")||document.querySelectorAll("[data-choices]")||document.querySelectorAll("[data-provider]"))&&(document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js' async>><\/script>"),document.writeln("<script type='text/javascript' src='{{url_plug()}}/assets/libs/choices.js/public/assets/scripts/choices.min.js' async>><\/script>"),document.writeln("<script type='text/javascript' src='{{url_plug()}}/assets/libs/flatpickr/flatpickr.min.js' async>><\/script>"));
    </script>

    <!-- Modern colorpicker bundle -->
    <script src="{{url_plug()}}/assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/prismjs/prism.js"></script>
    <script src="{{url_plug()}}/js/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="{{url_plug()}}/js/bootstrap.min.js"></script>
    <script src="{{url_plug()}}/js/jquery.dataTables.min.js"></script>
    <script src="{{url_plug()}}/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{url_plug()}}/js/dataTables.responsive.min.js"></script>
    <script src="{{url_plug()}}/js/dataTables.buttons.min.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{url_plug()}}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/form-pickers.init.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/datatables.init.js"></script>
    <script src="{{url_plug()}}/js/select2.min.js"></script>

    <script src="{{url_plug()}}/assets/js/pages/select2.init.js"></script>

    <script src="{{url_plug()}}/assets/js/app.js"></script>
    @stack('datatable')
    @stack('ajax')
    <script>
        
        $("#logout").on("click", function() {
            Swal.fire({
                title: "Yakin melakukan logout?",
                text: "Proses logout akan mengluarkan anda dari sistem",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                    location.assign("{{url('logout-perform')}}")
                  } else {
                    
                  }
              });
        }) 

            $('#profile-img-file-input').change(function() {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        console.log(event.target.result);
                        $('#modal-foto-profil').modal('show');
                        $('#imgPreview').attr('src', event.target.result);
                        $('#imgPreviewmodal').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
            $('#save-update-profil').click(function() {
                var form = document.getElementById('mydataavatar');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('user/store_avatar') }}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        document.getElementById("loadnya").style.width = "100%";
                    },
                    success: function(msg) {
                        var bat = msg.split('@');
                        if (bat[1] == 'ok') {
                            $('#modal-foto-profil').modal('hide');
                            document.getElementById("loadnya").style.width = "0px";
                            Swal.fire({
                                title: "Notifikasi",
                                html: 'Update Avatar Success  ',
                                icon: "success",
                                confirmButtonText: 'Close',
                                confirmButtonClass: "btn btn-info w-xs mt-2",
                                buttonsStyling: !1,
                                showCloseButton: !0
                            });
                            location.reload();
                        } else {
                            document.getElementById("loadnya").style.width = "0px";
                            Swal.fire({
                                title: "Notifikasi",
                                html: '<div style="background:#f2f2f5;padding:1%;text-align:left;font-size:13px">' +
                                    msg + '</div>',
                                icon: "error",
                                confirmButtonText: 'Close',
                                confirmButtonClass: "btn btn-danger w-xs mt-2",
                                buttonsStyling: !1,
                                showCloseButton: !0
                            });
                        }


                    }
                });
            });
        // document.getElementById("loadnya").style.width = "100%";
    </script>
</body>

</html>