                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0">Aktifitas Pekerjaan</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <textarea name="content" style="width:100%;height:300px;padding:1%" placeholder="ketik........." class="textarea">{!! $data->aktifitas !!}</textarea>
                                    <div>
                                        <label for="formSizeDefault" class="form-label">Tanggal Aktifitas</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroup-sizing-sm" ><i class="mdi mdi-calendar-month-outline"></i></span>
                                            <input type="text" class="form-control tanggal" data-provider="flatpickr" data-date-format="Y-m-d" data-deafult-date="{{date('Y-m-d')}} "  name="tanggal" value="{{$data->tanggal_aktifitas}}" placeholder="Enter.....">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="formSizeDefault" class="form-label">File Attachment / Lampiran</label>
                                        
                                        <input class="form-control" name="file" id="formSizeDefault" type="file"  >
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <link href="{{url_plug()}}/assets/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
                    <script src="{{url_plug()}}/assets/bootstrap3-wysihtml5.all.min.js"></script>
                    <link rel="stylesheet" href={{url_plug()}}/js/flatpickr.min.css">
                    <script src="{{url_plug()}}/js/flatpickr.js"></script>
                    <script>
                        $('.textarea').wysihtml5();
                        $(".tanggal").flatpickr();    
                                $("#saveButton").click(function() {
                                    var form=document.getElementById('mydataaktifitas');
                                    var data = new FormData(form);
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{ url('pekerjaan/aktifitas') }}",
                                            data: data,
                                            contentType: false,
                                            cache: false,
                                            processData:false,
                                            beforeSend: function() {
                                                $('#tampil-detail').html("")
                                                document.getElementById("loadnya").style.width = "100%";
                                            },
                                            success: function(msg){
                                                var bat=msg.split('@');
                                                if(bat[1]=='ok'){
                                                    document.getElementById("loadnya").style.width = "0px";
                                                    Swal.fire({
                                                        title:"Notifikasi",
                                                        html:'Create project Succes ',
                                                        icon:"success",
                                                        confirmButtonText: 'Close',
                                                        confirmButtonClass:"btn btn-info w-xs mt-2",
                                                        buttonsStyling:!1,
                                                        showCloseButton:!0
                                                    });
                                                    load_data();
                                                    $('#tampil-form').html("");
				                                    $('#modal-form').modal('hide');
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
                                                    load_data();
                                                }
                                                
                                                
                                            }
                                        });
                                });
                            
                    </script>