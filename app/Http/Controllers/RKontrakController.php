<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Imports\ImportMaterial;
use App\Imports\ImportMaterialKontrak;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\ViewEmploye;
use App\Models\ViewLog;
use App\Models\Viewrole;
use App\Models\Viewstatus;
use App\Models\Role;
use App\Models\HeaderProject;
use App\Models\ViewHeaderProject;
use App\Models\ProjectPekerjaan;
use App\Models\ProjectPeriode;
use App\Models\ProjectMaterial;
use App\Models\ProjectPersonal;
use App\Models\ViewProjectMaterial;
use App\Models\ProjectRisiko;
use App\Models\ProjectOperasional;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ViewCost;
use App\Models\User;
use PDF;

class RKontrakController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        // if(count_pm()>0){
            return view('kontrak.index',compact('template'));
        // }else{
        //     return view('error');
        // }
       
    }
    public function index_pekerjaan(request $request)
    {
        error_reporting(0);
        $template='top';
        if(count_pm()>0){
            return view('kontrak.index_pekerjaan',compact('template'));
        }else{
            return view('error');
        }
       
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Employe::find($request->id);
        $id=$request->id;
        
        return view('employe.modal',compact('template','data','disabled','id'));
    }
    public function modal_detail(request $request)
    {
        error_reporting(0);
        $id=$request->id;
        $kategori_ide=$request->kategori;
        if($kategori_ide==5){
            $data=ProjectPekerjaan::find($request->id);
            return view('kontrak.modal_pekerjaan',compact('template','data','disabled','id','disabled','kategori_ide'));
        }else{
            $template='top';
            $data=ViewProjectMaterial::find($request->id);
            
            if($id>0){
                $disabled="readonly";
            }else{
                $disabled="";
            }
            
            return view('project.modal_detail',compact('template','data','disabled','id','disabled','kategori_ide'));
        }
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        if(Auth::user()->role_id==1){
            return view('kontrak.view_all',compact('template','data','disabled','id'));
        }
        elseif(Auth::user()->role_id==2){
            if($data->status_id==5){
                return view('kontrak.view_project',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view_all',compact('template','data','disabled','id'));
            }
        }
        elseif(Auth::user()->role_id==3){
            if($data->status_id==4){
                return view('kontrak.view_project',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view_all',compact('template','data','disabled','id'));
            }
        }
        elseif(Auth::user()->role_id==4){
            if($data->status_id==2){
                return view('kontrak.view_project',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view_all',compact('template','data','disabled','id'));
            }
        }
        
        elseif(Auth::user()->role_id==7){
            if($data->status_id==9){
                return view('kontrak.view_project',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view_all',compact('template','data','disabled','id'));
            }
        }else{
            if($data->nik_pm==Auth::user()->username){
                if($data->status_id>8){
                    if($data->status_id==6){
                        return view('kontrak.view_verifikasi',compact('template','data','disabled','id'));
                    }else{
                        return view('kontrak.view_all',compact('template','data','disabled','id'));
                    }
                    
                }else{
                    return view('kontrak.view',compact('template','data','disabled','id'));
                }
            }else{
                return view('error');
            }
        }
        
        
    }
   
   
    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewHeaderProject::query();
        if(Auth::user()->role_id==1){
            
        }
        if(Auth::user()->role_id==2){
            $data=$query->where('status_id','>',4);
        }
        if(Auth::user()->role_id==3){
            $data=$query->where('status_id','>',3);
        }
        if(Auth::user()->role_id==4){
            $data=$query->where('status_id','>',1);
        }
        if(Auth::user()->role_id==5){
            $data=$query->where('username',Auth::user()->username);
        }
        if(Auth::user()->role_id==6){
            $data=$query->where('nik_pm',Auth::user()->username);
        }
        if(Auth::user()->role_id==7){
            $data=$query->where('status_id','>',8);
        }
        // $data=$query->where('status_id','>',7)->where('status_id','!=',50);
        $data = $query->where('status_kontrak_id',2)->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_employe(`'.$row->nik.'`,`'.$row->nama.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('sts', function ($row) {
                if($row->revisi==1){
                    $text='<b>Revisi</b>';
                    $color="danger";
                }else{
                    $text='';
                    $color="secondary";
                }
                $btn='<span class="badge badge-outline-'.$color.'" onclick="tambah('.encoder($row->id).')">'.$text.' '.$row->status.'</span>';
                return $btn;
            })
            ->addColumn('judul', function ($row) {
                if(strlen($row->deskripsi_project)>50){
                    return '<p class="mb-0" title="'.$row->deskripsi_project.'">'.substr($row->deskripsi_project,0,60).'...</p>';
                }else{
                    return $row->deskripsi_project;
                }
                
            })
            ->addColumn('pm', function ($row) {
                
                    return '('.$row->nik_pm.') '.$row->nama_pm;
                
                
            })
            ->addColumn('deskripsi_project', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);" style="color:aqua" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }
                return $btn;
            })
            ->addColumn('customer', function ($row) {
               
                $btn='<a href="javascript: void(0);" class="text-mute">'.$row->customer.'</a>';
                
                return $btn;
            })
            
            ->addColumn('action', function ($row) {
                if(Auth::user()->role_id==6){
                    if(Auth::user()->role_id==6){
                        if($row->status_id==1){
                            
                            if($row->revisi==1){
                                $text='Revisi / Edit';
                                $color="danger";
                            }else{
                                $text='Edit';
                                $color="secondary";
                            }
                        }else{
                            if($row->status_id==6){
                                $text='Verifikasi / Hasil';
                                $color="secondary";
                            }else{
                                $text='View Project';
                                $color="soft-secondary";
                            }
                            
                        }
                    }
                    $btn='
                    <span class="dtr-data">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-'.$color.' btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">';
                                
                                
                                if($row->status_id==1){
                                $btn.='
                                <li onclick="tambah(`'.encoder($row->id).'`)"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> '.$text.'</a></li>
                                <li onclick="publish_data(`'.encoder($row->id).'`,3)">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="mdi mdi-share-all-outline me-2 text-muted"></i> Publish Project
                                    </a>
                                </li>
                                <li onclick="delete_data(`'.encoder($row->id).'`,3)">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </a>
                                </li>';
                                }else{
                                $btn.='
                                <li onclick="tambah(`'.encoder($row->id).'`,3)">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="mdi mdi-share-all-outline me-2 text-muted"></i> '.$text.'
                                    </a>
                                </li>';
                                }
                                
                                $btn.='
                            </ul>
                        </div>
                    </span>
                    ';
                }else{
                    if(Auth::user()->role_id==1){
                        
                    }
                    if(Auth::user()->role_id==2){
                        if($row->status_id==5){
                            $color="secondary";
                            
                        }else{
                            $color="soft-secondary";
                        }
                    }
                    if(Auth::user()->role_id==3){
                        if($row->status_id==4){
                            $color="secondary";
                            
                        }else{
                            $color="soft-secondary";
                        }
                    }
                    if(Auth::user()->role_id==4){
                        if($row->status_id==2){
                            $color="secondary";
                            
                        }else{
                            $color="soft-secondary";
                        }
                    }
                    if(Auth::user()->role_id==5){
            
                    }
                    if(Auth::user()->role_id==6){
            
                    }
                    if(Auth::user()->role_id==7){
                        if($row->status_id==9){
                            $color="secondary";
                            
                        }else{
                            $color="soft-secondary";
                        }
                    }
                    $btn='
                    <span class="dtr-data">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-'.$color.' btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li onclick="tambah(`'.encoder($row->id).'`,3)">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="mdi mdi-share-all-outline me-2 text-muted"></i> View Project
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </span>';
                }
                return $btn;
            })
            
            ->addColumn('statusnya', function ($row) {
                if($row->status_id==1){
                    if($row->active==1){
                        $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                    <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" onclick="switch_data(`'.encoder($row->id).'`,1)" checked>
                                </div>';
                    }else{
                        $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                    <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" onclick="switch_data(`'.encoder($row->id).'`,3)" >
                                </div>';
                    }
                }else{
                    $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                    <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" disabled checked>
                                </div>';
                }
                
                return $btn;
            })
            
            ->rawColumns(['action','rolenya','judul','statusnya','sts','deskripsi_project','customer'])
            ->make(true);
    }

    public function get_data_json(request $request)
    {
        error_reporting(0);
        $query = ViewHeaderProject::query();
        $data=$query->where('status_id','>',7)->where('status_id','!=',50);
        $data = $query->where('status_kontrak',1)->orderBy('id','Desc')->get();
        $success=[];
        $detsuccess=[];
        foreach($data as $o){
            $sub['id']=$o->id;
            $sub['deskripsi_project']=$o->deskripsi_project;
            $sub['start_date']=$o->start_date_at;
            $sub['end_date']=$o->end_date_at;
            $sub['nik_pm']=$o->nik_pm;
            $sub['nama_pm']=$o->nama_pm;
            $sub['file_kontrak']=$o->file_kontrak;
            $sub['customer']=$o->customer;
            $sub['status']=$o->status;
            $sub['cost_center_project']=$o->cost_center_project;
            $sub['customer_code']=$o->customer_code;
            $sub['approve_kontrak']=$o->approve_kontrak;
            $sub['nilai']=uang($o->nilai);
            $sub['b_material']=uang($o->b_material);
            $sub['b_operasional']=uang($o->b_operasional);
            $sub['b_jasa']=uang($o->b_jasa);
            $sub['b_total']=uang($o->b_total);
            $detsuccess[]=$sub;
        }
        $success=$detsuccess;
        $response = [
            'status' => true,
            'data'    => $success,
        ];


        return response()->json($response, 200);
    }
    public function get_data_log(request $request)
    {
        error_reporting(0);
        $id=decoder($request->id);
        $query = ViewLog::query();
        
        $data = $query->where('project_header_id',$id)->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('deskripsi', function ($row) {
                $btn=$row->deskripsi;
                return $btn;
            })
            ->rawColumns(['deskripsi'])
            ->make(true);
    }
    public function delete_detail(request $request){
        $id=$request->id;
        $mst=ProjectPekerjaan::where('id',$id)->delete();
       
        
        

    }
    public function get_data_pekerjaan(request $request)
    {
        error_reporting(0);
        
        $data=ProjectPekerjaan::where('project_header_id',$request->id)->orderBy('id','Asc')->get();
        
        return Datatables::of($data)
            
            ->addColumn('selsih_waktu', function ($row) {
                return $row->selisih .'Hari';
            })
            ->addColumn('action', function ($row) {
                $btn='
                <span class="dtr-data">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li onclick="ubah_detail('.$row->id.',5)"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li onclick="delete_data('.$row->id.',5)">
                                <a class="dropdown-item remove-item-btn">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </span>
                ';
                return $btn;
            })
            
            ->rawColumns(['action','seleksi'])
            ->make(true);
    }

    public function delete(request $request){
        $id=decoder($request->id);
        if($request->act==1){
            $emp=HeaderProject::where('id',$id)->update(['active'=>0]);
        }
        if($request->act==3){
            $emp=HeaderProject::where('id',$id)->update(['active'=>1]);
        }
        if($request->act==2){
            $emp = HeaderProject::where('id',$id)->delete();
        }
        

    }
    

    
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        if($request->id=='0'){
            $rules['customer_code']= 'required';
            $messages['customer_code.required']= 'Harap lengkapi data customer';

        }
        if($request->status_id==8){
            $rules['nik_pm']= 'required';
            $messages['nik_pm.required']= 'Harap lengkapi data project manager';
            if($request->file!=""){
                $rules['file']= 'required|mimes:pdf';
                $messages['file.required']= 'Harap lengkapi file';
                $messages['file.mimes']= 'Format file kontrak harus pdf';
            }
        }
        

        $rules['deskripsi_project']= 'required';
        $messages['deskripsi_project.required']= 'Harap lengkapi nama project';

        
        
        $rules['nilai_project']= 'required';
        $messages['nilai_project.required']= 'Harap lengkapi nilai project';

        
        $rules['kategori_project_id']= 'required';
        $messages['kategori_project_id.required']= 'Harap lengkapi jenis project';

        $rules['tipe_project_id']= 'required';
        $messages['tipe_project_id.required']= 'Harap lengkapi tipe project';

        $rules['start_date']= 'required';
        $messages['start_date.required']= 'Harap lengkapi waktu mulai';

        $rules['end_date']= 'required';
        $messages['end_date.required']= 'Harap lengkapi waktu sampai';

        
       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            if($request->id=='0'){
                if($request->status_id==8){
                    $status_kontrak=2;
                }else{
                    $status_kontrak=1;
                }
                $data=HeaderProject::Create([
                    'username'=>Auth::user()->username,
                    'status_id'=>$request->status_id,
                    'step'=>1,
                    'status_kontrak'=>$status_kontrak,
                    'customer_code'=>$request->customer_code,
                    'kategori_project_id'=>$request->kategori_project_id,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'nilai'=>ubah_uang($request->nilai_project),
                    'tipe_project_id'=>$request->tipe_project_id,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'active'=>0,
                ]);
                if($request->status_id==8){
                    
                    $datadet=HeaderProject::where('id',$data->id)->update([
                        
                        'nik_pm'=>$request->nik_pm,
                        'nama_pm'=>$request->nama_pm,
                        'cost_center_project'=>$request->cost_center,
                        'tgl_send_komersil'=>date('Y-m-d H:i:s'),
                        'tgl_send_procurement'=>date('Y-m-d H:i:s'),
                        'approve_kadis_komersil'=>date('Y-m-d H:i:s'),
                        'approve_kadis_operasional'=>date('Y-m-d H:i:s'),
                        'approve_mgr_operasional'=>date('Y-m-d H:i:s'),
                        'approve_direktur_operasional'=>date('Y-m-d H:i:s'),
                    ]);

                    if($request->file!=""){
                        $thumbnail = $request->file('file');
                        $thumbnailFileName =$request->customer_code.'-'.date('ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                        $filename =$thumbnailFileName;
                        $file = \Storage::disk('public_kontrak');
                        
                        if($file->put($filename, file_get_contents($thumbnail))){
                            $proj=HeaderProject::where('id',$data->id)->update([
                                'file_kontrak'=>$filename
                            ]);
                        }
                    }

                    $ket='Kontrak berhasil dibuat';
                }else{
                    $ket='Rencana project berhasil dibuat';
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$data->id,
                    'deskripsi'=>$ket,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok@'.encoder($data->id);
            }else{
                $data=HeaderProject::where('id',$request->id)->update([
                    'kategori_project_id'=>$request->kategori_project_id,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'nilai'=>ubah_uang($request->nilai_project),
                    'tipe_project_id'=>$request->tipe_project_id,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                if($request->status_id==8){
                    $datadet=HeaderProject::where('id',$request->id)->update([
                        
                        'nik_pm'=>$request->nik_pm,
                        'nama_pm'=>$request->nama_pm,
                        'cost_center_project'=>$request->cost_center,
                    ]);

                    if($request->file!=""){
                        $thumbnail = $request->file('file');
                        $thumbnailFileName =$request->customer_code.'-'.date('ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                        $filename =$thumbnailFileName;
                        $file = \Storage::disk('public_kontrak');
                        
                        if($file->put($filename, file_get_contents($thumbnail))){
                            $proj=HeaderProject::where('id',$request->id)->update([
                                'file_kontrak'=>$filename
                            ]);
                        }
                    }

                    $ket='Kontrak berhasil diupdate';
                }else{
                    $ket='Rencana project berhasil diupdate';
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$ket,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok@'.encoder($request->id);
            }
           
        }
    }
    public function approve_data(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Harap pilih status';
        if($request->status_id==2){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap catatan perbaikan';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $mst=HeaderProject::where('id',$id)->first();
            // Kadis Komersil / Enginering
            if(Auth::user()->role_id==4){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Kadis Komersil';
                    $stat=8;
                    $status_id=9;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $stat=8;
                    $status_id=8;
                    $revisi=1;
                }
            }
            // Kadis Operasional
            if(Auth::user()->role_id==7){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Kadis Operasional';
                    $stat=9;
                    $status_id=10;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $stat=9;
                    $status_id=8;
                    $revisi=1;
                }
            }
            // Manager Operasional
            if(Auth::user()->role_id==3){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Manager Operasional';
                    $status_id=11;
                    $stat=10;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $status_id=8;
                    $stat=10;
                    $revisi=1;
                }
            }
            // Direktur Operasional
            if(Auth::user()->role_id==2){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Direktur Operasional';
                    $status_id=12;
                    $stat=11;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $status_id=8;
                    $stat=11;
                    $revisi=1;
                }
            }
            
            if($mst->status_id==$stat){
                if(Auth::user()->role_id==4){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_kontrak_kadis_komersil'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi_kontrak'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),

                    ]);
                }
                if(Auth::user()->role_id==7){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_kontrak_kadis_operasional'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi_kontrak'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),
                    ]);
                }
                if(Auth::user()->role_id==3){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_kontrak_mgr_operasional'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi_kontrak'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),
                    ]);
                }
                if(Auth::user()->role_id==2){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_kontrak_direktur_operasional'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi_kontrak'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),
                    ]);
                }
                
                $log=LogPengajuan::create([
                    'project_header_id'=>$id,
                    'deskripsi'=>$ket,
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'state'=>2,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Proses ini sudah dilakukan silahkan untuk refreshalaman ini</div></div>';
            }
        }
        
               
        
        
    }
    public function store_publish(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $mst=HeaderProject::where('id',$request->id)->first();
        if($mst->status_id!=8){
            $rules['xxxxx']= 'required';
            $messages['xxxxx.required']= 'Harap refresh ulang halaman ini';
        }
        

        
       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{

                $data=HeaderProject::where('id',$request->id)->update([
                    'status_id'=>9,
                    'update'=>date('Y-m-d H:i:s'),
                    
                ]);
                $det=ProjectPekerjaan::where('project_header_id',$request->id)->orderBy('mulai','Asc')->get();
                foreach($det as $o){
                    $sv=ProjectPekerjaan::where('id',$o->id)->update(['urut'=>($no+1)]);
                }
                echo'@ok@';
           
           
        }
    }
    public function store_verifikasi(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        if($request->status_id==8){
            $rules['cost_center']= 'required';
            $messages['cost_center.required']= 'Harap lengkapi cost center';
            $rules['nik_pm']= 'required';
            $messages['nik_pm.required']= 'Harap lengkapi data project manager';
            $rules['no_kontrak']= 'required';
            $messages['no_kontrak.required']= 'Harap lengkapi nomor kontrak';
            if($request->file!=""){
                $rules['file']= 'required|mimes:pdf';
                $messages['file.required']= 'Harap lengkapi file';
                $messages['file.mimes']= 'Format file kontrak harus pdf';
            }
        }else{
            $rules['catatan_dibatalkan']= 'required';
            $messages['catatan_dibatalkan.required']= 'Harap masukan alasan pembatalan';
        }
        

        
       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{

                $data=HeaderProject::where('id',$request->id)->update([
                    'status_id'=>$request->status_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                    
                ]);
                if($request->status_id==8){
                    $datadet=HeaderProject::where('id',$request->id)->update([
                        
                        'nik_pm'=>$request->nik_pm,
                        'nama_pm'=>$request->nama_pm,
                        'no_kontrak'=>$request->no_kontrak,
                        'cost_center_project'=>$request->cost_center,
                        'approve_kontrak'=>date('Y-m-d H:i:s'),
                    ]);

                    if($request->file!=""){
                        $thumbnail = $request->file('file');
                        $thumbnailFileName ='KONTRAK-'.$request->no_kontrak.'-'.date('ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                        $filename =$thumbnailFileName;
                        $file = \Storage::disk('public_kontrak');
                        
                        if($file->put($filename, file_get_contents($thumbnail))){
                            $proj=HeaderProject::where('id',$request->id)->update([
                                'file_kontrak'=>$filename
                            ]);
                        }
                    }

                    $ket='Verifikasi Project';
                }else{
                    $ket='Rencana project dibatalkan <br>'.$request->catatan_dibatalkan;
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$ket,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok@'.encoder($request->id);
           
           
        }
    }
    public function store_detail(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['pekerjaan']= 'required';
        $messages['pekerjaan.required']= 'Harap lengkapi nama pekerjaan';
        $rules['mulai']= 'required|date';
        $messages['mulai.required']= 'Harap lengkapi tanggal mulai';
        $messages['mulai.date']= 'Format tanggal mulai (yyyy-mm-dd)';

    
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            if($request->id=='0'){
                $data=ProjectPekerjaan::Create([
                    'pekerjaan'=>$request->pekerjaan,
                    'mulai'=>$request->mulai,
                    'sampai'=>$request->sampai,
                    'project_header_id'=>$request->project_header_id,
                    'status'=>1,
                    'selisih'=>selisih_tanggal($request->mulai,$request->sampai),
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                
                echo'@ok@'.$request->kategori_ide;
            }else{
                $data=ProjectPekerjaan::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'pekerjaan'=>$request->pekerjaan,
                    'selisih'=>selisih_tanggal($request->mulai,$request->sampai),
                    'mulai'=>$request->mulai,
                    'sampai'=>$request->sampai,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);

                echo'@ok@'.$request->kategori_ide;
            }
        
        }
        
    }


    public function store_import_material(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        $rules['file_excel_material']= 'required';
        $messages['file_excel_material.required']= 'Harap isi upload excel';
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $mst=HeaderProject::where('id',$id)->first();
            if($mst->tab>2){
                $tab=$mst->tab;
            }else{
                $tab=4;
            }
            $filess = $request->file('file_excel_material');
            $nama_file = 'MATERIAL'.$id.'-'.rand().$filess->getClientOriginalName();
            $dex=HeaderProject::where('id',$id)->update([
                'file_exel'=>$nama_file
            ]);
            $filess->move('attach/file_excel',$nama_file);
            Excel::import(new ImportMaterial($id,$mst->tipe_project_id), public_path('/attach/file_excel/'.$nama_file));
            echo'@ok';
        }
        
               
        
        
    }

    public function approve_kadis_komersil(request $request){
        error_reporting(0);
        $id=decoder($request->id);
        $rules = [];
        $messages = [];
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Harap pilih status';
        if($request->status_id==2){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap catatan perbaikan';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $mst=HeaderProject::where('id',$id)->first();
            
            if($request->status_id==1){
                $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh '.Auth::user()->role['role'];
                $status_id=3;
                $revisi=0;
            }else{
                $ket='<b>Revisi</b><br>'.$request->catatan;
                $status_id=1;
                $revisi=1;
            }
            if($mst->status_id==2){
                $data=HeaderProject::where('id',$id)->update([
                    'approve_kadis_komersil'=>date('Y-m-d H:i:s'),
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'step'=>3,
                ]);
                $log=LogPengajuan::create([
                    'project_header_id'=>$id,
                    'deskripsi'=>$ket,
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Proses ini sudah dilakukan silahkan untuk refreshalaman ini</div></div>';
            }
        }
        
               
        
        
    }

    public function approve_kadis_operasional(request $request){
        error_reporting(0);
        $id=decoder($request->id);
        $rules = [];
        $messages = [];
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Harap pilih status';
        if($request->status_id==2){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap catatan perbaikan';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $mst=HeaderProject::where('id',$id)->first();
            
            if($request->status_id==1){
                $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh '.Auth::user()->role['role'];
                $status_id=4;
                $revisi=0;
            }else{
                $ket='<b>Revisi</b><br>'.$request->catatan;
                $status_id=1;
                $revisi=1;
            }
            if($mst->status_id==3){
                $data=HeaderProject::where('id',$id)->update([
                    'approve_kadis_operasional'=>date('Y-m-d H:i:s'),
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'step'=>4,
                ]);
                $log=LogPengajuan::create([
                    'project_header_id'=>$id,
                    'deskripsi'=>$ket,
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Proses ini sudah dilakukan silahkan untuk refreshalaman ini</div></div>';
            }
        }
        
               
        
        
    }

    public function approve_mgr_operasional(request $request){
        error_reporting(0);
        $id=decoder($request->id);
        $rules = [];
        $messages = [];
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Harap pilih status';
        if($request->status_id==2){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap catatan perbaikan';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $mst=HeaderProject::where('id',$id)->first();
            
            if($request->status_id==1){
                $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh '.Auth::user()->role['role'];
                $status_id=5;
                $revisi=0;
            }else{
                $ket='<b>Revisi</b><br>'.$request->catatan;
                $status_id=1;
                $revisi=1;
            }
            if($mst->status_id==4){
                $data=HeaderProject::where('id',$id)->update([
                    'approve_mgr_operasional'=>date('Y-m-d H:i:s'),
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'step'=>5,
                ]);
                $log=LogPengajuan::create([
                    'project_header_id'=>$id,
                    'deskripsi'=>$ket,
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Proses ini sudah dilakukan silahkan untuk refreshalaman ini</div></div>';
            }
        }
        
               
        
        
    }

    public function approve_direktur_operasional(request $request){
        error_reporting(0);
        $id=decoder($request->id);
        $rules = [];
        $messages = [];
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Harap pilih status';
        if($request->status_id==2){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap catatan perbaikan';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            $mst=HeaderProject::where('id',$id)->first();
            
            if($request->status_id==1){
                $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh '.Auth::user()->role['role'];
                $status_id=6;
                $revisi=0;
            }else{
                $ket='<b>Revisi</b><br>'.$request->catatan;
                $status_id=1;
                $revisi=1;
            }
            if($mst->status_id==5){
                $data=HeaderProject::where('id',$id)->update([
                    'approve_mgr_operasional'=>date('Y-m-d H:i:s'),
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'step'=>6,
                ]);
                $log=LogPengajuan::create([
                    'project_header_id'=>$id,
                    'deskripsi'=>$ket,
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Proses ini sudah dilakukan silahkan untuk refreshalaman ini</div></div>';
            }
        }
        
               
        
        
    }


    public function reset_material(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('state',2)->delete();
    }
}
