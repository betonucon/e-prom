<html>
    <head>
        <style>
            @page {
                margin: 100px 25px;
            }
            html{
                margin-top:70px;
            }
            header {
                top: -60px;
                min-height: 50px;
                width:100%;
                border:solid 1px #fff;
                color: #000;
                text-align: center;
                
            }
            td{
                vertical-align:top;
                font-size:11;
                padding:5px;
            }
            .tdh{
                text-transform:uppercase;
                padding:5px;
                text-align:center;

            }
            table{
                border-collapse:collapse;
            }
            h2{
                margin-top:0px;
                margin-bottom:0px;
            }
            footer {
                position: fixed;
                display:flex;
                bottom: -60px;
                min-height: 50px;
                color: white;
                text-align: center;
                line-height: 35px;
                width:100%;
            }
            main{
                
                margin-top:0.2%;
                margin-bottom:1%;
                
            }
        </style>
    </head>
    <body>
        <header>
            <table width="100%" border="1" >
                <tr>
                    <td  width="23%"><img src="{{url_img()}}\kpdp2.png" height="55px" width="100%"></td>
                    <td colspan="3" class="tdh"><h2>LAPORAN PEKERJAAN</h2>{{$data->deskripsi_project}}</td>
                 
                </tr>
                <tr>
                    <td bgcolor="#f1dfdf">Cost Center</td>
                    <td bgcolor="#f1dfdf" width="20%">: {{$data->cost_center_project}}</td>
                    <td bgcolor="#f1dfdf"  width="15%">Customer</td>
                    <td bgcolor="#f1dfdf">: {{$data->customer}}</td>
                </tr>
                <tr>
                    <td bgcolor="#f1dfdf">Tanggal Kontrak</td>
                    <td bgcolor="#f1dfdf">: {{date('d F Y',strtotime($data->approve_kontrak))}}</td>
                    <td bgcolor="#f1dfdf">PIC</td>
                    <td bgcolor="#f1dfdf">: {{$data->nama_pm}}</td>
                </tr>
                

            </table>
        </header>

        <footer>
            Footer
        </footer>

        <main>
            <hr style="border-bottom:double 4px #74737a">
            <table width="100%" border="1" >
                
                <tr>
                    <td bgcolor="#fff" width="3%">No</td>
                    <td bgcolor="#fff" width="19%">Nama Pekerjaan</td>
                    <td bgcolor="#fff"  width="8%">Progres</td>
                    <td bgcolor="#fff"  width="15%">Tanggal</td>
                    <td bgcolor="#fff">Aktifitas</td>
                </tr>
                @foreach($get as $s=>$o)
                    @foreach(get_detail_pekerjaan($o->id) as $no=>$m)
                        @if($no==0)
                        <tr>
                            <td>{{$s+1}}</td>
                            <td>{{$o->pekerjaan}}</td>
                            <td>{{$o->persen_project}}%</td>
                            <td>{{$m->tanggal_aktifitas}}</td>
                            <td>{!! $m->aktifitas !!}<br>
                                @if($m->foto!="")
                                    <img src="{{url_foto()}}\{{$m->foto}}" height="200px" width="100%">
                                    
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{$o->persen_project}}%</td>
                            <td>{{$m->tanggal_aktifitas}}</td>
                            <td>{!! $m->aktifitas !!}<br>
                                @if($m->foto!="")
                                    <img src="{{url_foto()}}\{{$m->foto}}" height="200px" width="100%">
                                    
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                @endforeach
                

            </table>
        </main>
    </body>
</html>