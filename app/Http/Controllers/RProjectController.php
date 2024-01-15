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
use App\Models\ViewDashboard;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ProjectTagihan;
use App\Models\Biaya;
use App\Models\ViewCost;
use App\Models\User;
use PDF;

class RProjectController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==6){
            return view('project.index',compact('template'));
        }else{
            return view('project.index_approve',compact('template'));
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
            return view('project.modal_pekerjaan',compact('template','data','disabled','id','disabled','kategori_ide'));
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
        if($request->act!=2){
            if($id==0){
                $disabled='';
            }else{
                $disabled='readonly';
            }
            if(Auth::user()->role_id==1){
                
            }
            if(Auth::user()->role_id==2){
                if($data->status_id==5){
                    return view('project.view_project',compact('template','data','disabled','id'));
                }else{
                    return view('project.view_all',compact('template','data','disabled','id'));
                }
            }
            if(Auth::user()->role_id==3){
                if($data->status_id==4){
                    return view('project.view_project',compact('template','data','disabled','id'));
                }else{
                    return view('project.view_all',compact('template','data','disabled','id'));
                }
            }
            if(Auth::user()->role_id==4){
                if($data->status_id==2){
                    return view('project.view_project',compact('template','data','disabled','id'));
                }else{
                    return view('project.view_all',compact('template','data','disabled','id'));
                }
            }
            if(Auth::user()->role_id==5){

            }
            if(Auth::user()->role_id==6){
                if($data->status_id>1){
                    if($data->status_id==6){
                        return view('project.view_verifikasi',compact('template','data','disabled','id'));
                    }else{
                        return view('project.view_all',compact('template','data','disabled','id'));
                    }
                    
                }else{
                    return view('project.view',compact('template','data','disabled','id'));
                }
            }
            if(Auth::user()->role_id==7){
                if($data->status_id==3){
                    return view('project.view_project',compact('template','data','disabled','id'));
                }else{
                    return view('project.view_all',compact('template','data','disabled','id'));
                }
            }
        }else{
            return view('project.view_all',compact('template','data','disabled','id'));
        }
        
        
    }
    public function get_data_rekap(request $request)
    {
        error_reporting(0);
        $success=[];
        $item=[];
        $state=$request->state;
        $query = ProjectMaterial::query();
        $mst=HeaderProject::where('id',$request->id)->first();
        $subtotal=$query->where('state',$state)->where('project_header_id',$request->id)->sum('total_decimal_3');
        foreach(get_biaya() as $proj){
            $qw=ProjectMaterial::query();
            $total=$qw->where('state',$state)->where('kode_biaya',$proj->kode_biaya)->where('project_header_id',$request->id)->sum('total_decimal_3');
            $jumlah=$qw->where('state',$state)->where('kode_biaya',$proj->kode_biaya)->where('project_header_id',$request->id)->count();
            $scs=[];
            $scs['kode_biaya']=$proj->kode_biaya;
            $scs['jumlah']=$jumlah;
            $scs['biaya']=$proj->biaya;
            $scs['total']=uang_decimal($total);
            $item[]=$scs;
        }
        $biaya_cost=($mst->persen_cost*$mst->hari_cost*$subtotal);
        $success['nilai_project']=uang_decimal($mst->nilai_project);
        $success['subtotal']=uang_decimal($subtotal);
        $success['hpp']=uang_decimal($biaya_cost+$subtotal);
        $success['biaya_cost']=uang_decimal($biaya_cost);
        $success['data']=$item;
        
        
        return response()->json($success, 200);
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

        }
        if(Auth::user()->role_id==7){
            $data=$query->where('status_id','>',2);
        }
        $data = $query->where('status_id','<',8)->orderBy('id','Desc')->get();

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
                    if($row->status_id==50){
                        $text='';
                        $color="danger";
                    }else{
                        $text='';
                        $color="secondary";
                    }
                    
                }
                if($row->status_kontrak_id==2){
                    $btn='<span class="badge badge-outline-success" onclick="tambah('.encoder($row->id).')">Kontrak</span>';
                }else{
                    $btn='<span class="badge badge-outline-'.$color.'" onclick="tambah('.encoder($row->id).')">'.$text.' '.$row->status.'</span>';
                }
                
                return $btn;
            })
            ->addColumn('deskripsi_project', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);"  onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }
                return $btn;
            })
            ->addColumn('customer', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->customer.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);"  onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->customer.'</a>';
                }
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
                        if($row->status_id==3){
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
            ->addColumn('judul', function ($row) {
                if(strlen($row->deskripsi_project)>50){
                    return '<p class="mb-0" title="'.$row->deskripsi_project.'">'.substr($row->deskripsi_project,0,50).'...</p>';
                }else{
                    return $row->deskripsi_project;
                }
                
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
            
            ->rawColumns(['action','rolenya','statusnya','sts','deskripsi_project','customer','judul'])
            ->make(true);
    }
    public function get_data_view(request $request)
    {
        error_reporting(0);
        $usr=User::where('id',$request->id)->first();
        $query = ViewHeaderProject::query();
        
        $data=$query->where('username',$usr->username);
        
        $data = $query->orderBy('id','Desc')->get();

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
                    if($row->status_id==50){
                        $text='';
                        $color="danger";
                    }else{
                        $text='';
                        $color="secondary";
                    }
                    
                }
                if($row->status_id>7){
                    if($row->status_id==50){
                        $btn='<span class="badge badge-outline-danger" onclick="tambah('.encoder($row->id).')">Dibatalkan</span>';
                    }else{
                        $btn='<span class="badge badge-outline-success" onclick="tambah('.encoder($row->id).')">Kontrak</span>';
                    }
                    
                }else{
                    $btn='<span class="badge badge-outline-secondary" onclick="tambah('.encoder($row->id).')">Rencana </span>';
                }
                
                return $btn;
            })
            ->addColumn('deskripsi_project', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);"  onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }
                return $btn;
            })
            ->addColumn('customer', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->customer.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);"  onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->customer.'</a>';
                }
                return $btn;
            })
            
            ->addColumn('action', function ($row) {
                
                    $color="soft-secondary";
                     $btn='
                    <span class="dtr-data">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-'.$color.' btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li onclick="tambah(`'.encoder($row->id).'`,'.$row->status_id.')">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="mdi mdi-share-all-outline me-2 text-muted"></i> View Project
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </span>';
                
                return $btn;
            })
            ->addColumn('judul', function ($row) {
                if(strlen($row->deskripsi_project)>50){
                    return '<p class="mb-0" title="'.$row->deskripsi_project.'">'.substr($row->deskripsi_project,0,50).'...</p>';
                }else{
                    return $row->deskripsi_project;
                }
                
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
            
            ->rawColumns(['action','rolenya','statusnya','sts','deskripsi_project','customer','judul'])
            ->make(true);
    }
    public function get_data_kontrak(request $request)
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

        }
        if(Auth::user()->role_id==7){
            $data=$query->where('status_id','>',2);
        }
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
                    if($row->status_id==50){
                        $text='';
                        $color="danger";
                    }else{
                        $text='';
                        $color="secondary";
                    }
                    
                }
                if($row->status_id>6 && $row->status_id!=50){
                    $btn='<span class="badge badge-outline-success" onclick="tambah('.encoder($row->id).')">Kontrak</span>';
                }else{
                    $btn='<span class="badge badge-outline-'.$color.'" onclick="tambah('.encoder($row->id).')">'.$text.' '.$row->status.'</span>';
                }
                
                return $btn;
            })
            ->addColumn('deskripsi_project', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);"  onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->deskripsi_project.'</a>';
                }
                return $btn;
            })
            ->addColumn('customer', function ($row) {
                if($row->active==1){
                    $btn='<a href="javascript: void(0);" onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->customer.'</a>';
                }else{
                    $btn='<a href="javascript: void(0);"  onclick="tambah(`'.encoder($row->id).'`)" class="text-mute">'.$row->customer.'</a>';
                }
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
                        if($row->status_id==3){
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
            ->addColumn('judul', function ($row) {
                if(strlen($row->deskripsi_project)>50){
                    return '<p class="mb-0" title="'.$row->deskripsi_project.'">'.substr($row->deskripsi_project,0,60).'...</p>';
                }else{
                    return $row->deskripsi_project;
                }
                
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
            
            ->rawColumns(['action','rolenya','statusnya','sts','deskripsi_project','customer','judul'])
            ->make(true);
    }
    public function get_data_log(request $request)
    {
        error_reporting(0);
        $id=decoder($request->id);
        $query = ViewLog::query();
        
        $data = $query->where('project_header_id',$id)->where('state',1)->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('deskripsi', function ($row) {
                $btn=$row->deskripsi;
                return $btn;
            })
            ->rawColumns(['deskripsi'])
            ->make(true);
    }
    public function get_biaya(request $request)
    {
        error_reporting(0);
        $data=ViewProjectMaterial::where('state',$request->state)->where('kode_biaya',$request->biaya)->where('project_header_id',$request->id)->orderBy('nama_material','Asc')->get();
        
        

        return Datatables::of($data)
            
            ->addColumn('biaya', function ($row) {
                return uang($row->biaya);
            })
            ->addColumn('total', function ($row) {
                return uang($row->total);
            })
            ->addColumn('qty', function ($row) {
                return uang($row->qty);
            })
            ->addColumn('nama_material', function ($row) {
                if(strlen($row->nama_material)>50){
                    return '<p class="mb-0" title="'.$row->nama_material.'">'.substr($row->nama_material,0,60).'...</p>';
                }else{
                    return $row->nama_material;
                }
                
            })
            ->addColumn('action', function ($row) {
                $btn='
                <span class="btn btn-danger btn-sm" onclick="delete_biaya('.$row->id.',`'.$row->kode_biaya.'`)" >
                    <i class="ri-delete-bin-fill "></i>
                </span>
                
                ';
                return $btn;
            })
            
            ->rawColumns(['action','seleksi','nama_material'])
            ->make(true);
    }
    public function get_data_detail(request $request)
    {
        error_reporting(0);
        // jasa
        if($request->ctr==1){
            $data=ViewProjectMaterial::where('state',1)->where('project_header_id',$request->id)->where('kategori_ide',3)->orderBy('nama_material','Asc')->get();
        }
        // operasional
        if($request->ctr==2){
            $data=ViewProjectMaterial::where('state',1)->where('project_header_id',$request->id)->where('kategori_ide',2)->orderBy('nama_material','Asc')->get();
        }
        // material
        if($request->ctr==3){
            $data=ViewProjectMaterial::where('state',1)->where('project_header_id',$request->id)->where('kategori_ide',1)->orderBy('nama_material','Asc')->get();
        }
        if($request->ctr==4){
            $data=ViewProjectMaterial::where('state',3)->where('project_header_id',$request->id)->where('kategori_ide',4)->orderBy('nama_material','Asc')->get();
        }
        if($request->ctr==""){
            $data=ViewProjectMaterial::where('state',4)->where('project_header_id',$request->id)->where('kategori_ide',1)->orderBy('nama_material','Asc')->get();
        }
        

        return Datatables::of($data)
            
            ->addColumn('biaya', function ($row) {
                return uang($row->biaya);
            })
            ->addColumn('total', function ($row) {
                return uang($row->total);
            })
            ->addColumn('qty', function ($row) {
                return uang($row->qty);
            })
            ->addColumn('action', function ($row) {
                $btn='
                <span class="dtr-data">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li onclick="ubah_detail('.$row->id.','.$row->kategori_ide.')"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li onclick="delete_data('.$row->id.','.$row->kategori_ide.')">
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
    public function get_data_pekerjaan(request $request)
    {
        error_reporting(0);
        
        $data=ProjectPekerjaan::where('project_header_id',$request->id)->orderBy('id','Asc')->get();
        
        return Datatables::of($data)
            
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
    public function publish_data(request $request){
        $id=decoder($request->id);
        $mst=HeaderProject::where('id',$id)->first();
        if($mst->step==1){
            $step=2;
        }else{
            $step=$mst->step;
        }
        $emp=HeaderProject::where('id',$id)->where('status_id',1)->update(['status_id'=>2,'step'=>$step,'revisi'=>0]);
        $log=LogPengajuan::create([
            'project_header_id'=>$mst->id,
            'deskripsi'=>'Project telah dipublish',
            'status_id'=>2,
            'state'=>1,
            'nik'=>Auth::user()->username,
            'role_id'=>Auth::user()->role_id,
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        

    }
    public function delete_biaya(request $request){
        $id=$request->id;
        $mst=ProjectMaterial::where('id',$id)->delete();
        echo'@'.$request->kode_biaya;
        
        

    }
    public function switch_to(request $request)
    {
        $data=User::where('username',Auth::user()->username)->update(['role_id'=>$request->role_id]);
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
                    'status_kontrak_id'=>$status_kontrak,
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
                    'state'=>1,
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
                    'state'=>1,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok@'.encoder($request->id);
            }
           
        }
    }
    public function get_data_dashboard_pm(request $request)
    {
        error_reporting(0);
        
        $data = Viewdashboardpm::where('username',Auth::user()->username)->first();
        $success=[];
        $success['id']=$data->id;
        $success['project']=$data->total_project;
        $success['rencana']=$data->total_rencana;
        $success['penyusunan']=$data->total_penyusunan;
        $success['verifikasi']=$data->total_verifikasi;
        $success['approve']=$data->total_approve;
        $success['selesai']=$data->total_selesai;
        $success['persen']=(int) $data->persen;
        return response()->json($success, 200);
    }
    public function get_data_dashboard(request $request)
    {
        error_reporting(0);
        
        $data = ViewDashboard::where('id',1)->first();
        $success=[];
        $success['id']=$data->id;
        $success['project']=$data->total_project;
        $success['rencana']=$data->total_rencana;
        $success['penyusunan']=$data->total_penyusunan;
        $success['verifikasi']=$data->total_verifikasi;
        $success['approve']=$data->total_approve;
        $success['selesai']=$data->total_selesai;
        $success['persen']=(int) $data->persen;
        return response()->json($success, 200);
    }
    public function store_verifikasi(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $fore=count((array) $request->persen);
        $array_sum=array_sum((array) $request->persen);
        // $termin=0;
        // for($x=0;$x<$fore;$x++){
        //     if($request->persen[$x]==0 || $request->termin[$x]==""){
        //         $termin+=0;
        //     }else{
        //         $termin+=1;
        //     }
        // }
        if($request->status_id==8){
            $rules['cost_center']= 'required';
            $messages['cost_center.required']= 'Harap lengkapi cost center';
            $rules['nik_pm']= 'required';
            $messages['nik_pm.required']= 'Harap lengkapi data project manager';
            $rules['no_kontrak']= 'required';
            $messages['no_kontrak.required']= 'Harap lengkapi nomor kontrak';
            $rules['type_tagihan']= 'required';
            $messages['type_tagihan.required']= 'Pilih type tagihan '.$termin;
            if($request->file!=""){
                $rules['file']= 'required|mimes:pdf';
                $messages['file.required']= 'Harap lengkapi file';
                $messages['file.mimes']= 'Format file kontrak harus pdf';
            }
            if($request->type_tagihan==1 && $array_sum!=100){
                $rules['cccc']= 'required';
                $messages['cccc.required']= 'Masukan termin pembayaran dan total persen adalah 100%';
            }
            
            $cekcost=HeaderProject::where('status_id',6)->where('id',$request->id)->count();
            // $ceksolved=HeaderProject::where('status_id','>',7)->where('status_id','!=',50)->where('cost_center_project',$request->cost_center)->count();
            if($cekcost==0){
                $rules['xxxxxx']= 'required';
                $messages['xxxxxx.required']= 'Terjadi kesalahan, Silahkan refresh ulang halaman ini ss';
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
                    $termin=0;
                    if($request->type_tagihan=1){
                        for($x=0;$x<$fore;$x++){
                            if($request->persen[$x]==0 || $request->termin[$x]==""){
                                $termin+=0;
                            }else{
                                $termin+=1;
                                $tagihan=ProjectTagihan::create([
                                    'project_header_id'=>$request->id,
                                    'cost_center'=>$request->cost_center,
                                    'cost_center_no'=>$request->cost_center,
                                    'no'=>($x+1),
                                    'type_tagihan'=>1,
                                    'persen'=>$request->persen[$x],
                                    'termin'=>$request->termin[$x],
                                    'status_tagihan_id'=>0,
                                    'created_at'=>date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }else{

                    }
                    $datadet=HeaderProject::where('id',$request->id)->update([
                        
                        'nik_pm'=>$request->nik_pm,
                        'nama_pm'=>$request->nama_pm,
                        'no_kontrak'=>$request->no_kontrak,
                        'status_kontrak_id'=>2,
                        'type_tagihan'=>$request->type_tagihan,
                        'termin'=>$termin,
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
                    $getdet=ProjectMaterial::where('project_header_id',$request->id)->get();
                    foreach($getdet as $row){
                        $savedet=ProjectMaterial::UpdateOrcreate([
                            'project_header_id'=>$request->id,
                            'nama_material'=>$row->nama_material,
                            'status'=>1,
                            'kategori_ide'=>1,
                            'state'=>2,
                        ],[
                            'biaya'=>$row->biaya,
                            'kode_material'=>0,
                            
                            'kode_biaya'=>$row->kode_biaya,
                            'satuan_material'=>$row->satuan_material,
                            'biaya_actual'=>$row->biaya_actual,
                            'qty'=>$row->qty,
                            'status_pengadaan'=>1,
                            'total'=>($row->qty*$row->biaya_actual),
                            'total_decimal_3'=>($row->qty*$row->biaya_actual),
                            'total_actual'=>($row->qty*$row->biaya_actual),
                            'created_at'=>date('Y-m-d H:i:s'),
                        ]);
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
        if($request->kategori_ide==5){
            $rules['pekerjaan']= 'required';
            $messages['pekerjaan.required']= 'Harap lengkapi nama pekerjaan';

        
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
                        'project_header_id'=>$request->project_header_id,
                        'status'=>1,
                        'created_at'=>date('Y-m-d H:i:s'),
                    ]);
                    
                    echo'@ok@'.$request->kategori_ide;
                }else{
                    $data=ProjectPekerjaan::UpdateOrcreate([
                        'id'=>$request->id,
                    ],[
                        'pekerjaan'=>$request->pekerjaan,
                        'created_at'=>date('Y-m-d H:i:s'),
                    ]);

                    echo'@ok@'.$request->kategori_ide;
                }
            
            }
        }else{
        
                $rules['nama_material']= 'required';
                $messages['nama_material.required']= 'Harap lengkapi nama material';

                $rules['biaya']= 'required';
                $messages['biaya.required']= 'Harap lengkapi biaya';

                $rules['qty']= 'required';
                $messages['qty.required']= 'Harap lengkapi qty';
            
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
                        $data=ProjectMaterial::Create([
                            'nama_material'=>$request->nama_material,
                            'project_header_id'=>$request->project_header_id,
                            'kategori_ide'=>$request->kategori_ide,
                            'biaya'=>ubah_uang($request->biaya),
                            'qty'=>ubah_uang($request->qty),
                            'biaya_actual'=>ubah_uang($request->biaya),
                            'total'=>(ubah_uang($request->biaya)*ubah_uang($request->qty)),
                            'total_actual'=>(ubah_uang($request->biaya)*ubah_uang($request->qty)),
                            'satuan_material'=>$request->satuan_material,
                            'state'=>1,
                            'created_at'=>date('Y-m-d H:i:s'),
                        ]);
                        
                        echo'@ok@'.$request->kategori_ide;
                    }else{
                        $data=ProjectMaterial::UpdateOrcreate([
                            'id'=>$request->id,
                        ],[
                            'biaya'=>ubah_uang($request->biaya),
                            'nama_material'=>$request->nama_material,
                            'qty'=>ubah_uang($request->qty),
                            'biaya_actual'=>ubah_uang($request->biaya),
                            'total'=>(ubah_uang($request->biaya)*ubah_uang($request->qty)),
                            'total_actual'=>(ubah_uang($request->biaya)*ubah_uang($request->qty)),
                            'satuan_material'=>$request->satuan_material,
                        ]);

                        echo'@ok@'.$request->kategori_ide;
                    }
                
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
                    $stat=2;
                    $status_id=3;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $stat=2;
                    $status_id=1;
                    $revisi=1;
                }
            }
            // Kadis Operasional
            if(Auth::user()->role_id==7){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Kadis Operasional';
                    $stat=3;
                    $status_id=4;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $stat=3;
                    $status_id=1;
                    $revisi=1;
                }
            }
            // Manager Operasional
            if(Auth::user()->role_id==3){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Manager Operasional';
                    $status_id=5;
                    $stat=4;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $status_id=1;
                    $stat=4;
                    $revisi=1;
                }
            }
            // Direktur Operasional
            if(Auth::user()->role_id==2){
                if($request->status_id==1){
                    $ket='<b>Disetujui</b><br>Pengajuan telah disetujui oleh Direktur Operasional';
                    $status_id=6;
                    $stat=5;
                    $revisi=0;
                }else{
                    $ket='<b>Revisi</b><br>'.$request->catatan;
                    $status_id=1;
                    $stat=5;
                    $revisi=1;
                }
            }
            
            if($mst->status_id==$stat){
                if(Auth::user()->role_id==4){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_kadis_komersil'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),

                    ]);
                }
                if(Auth::user()->role_id==7){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_kadis_operasional'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),
                    ]);
                }
                if(Auth::user()->role_id==3){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_mgr_operasional'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),
                    ]);
                }
                if(Auth::user()->role_id==2){
                    $data=HeaderProject::where('id',$id)->update([
                        'approve_direktur_operasional'=>date('Y-m-d H:i:s'),
                        'status_id'=>$status_id,
                        'revisi'=>$revisi,
                        'step'=>$status_id,
                        'update'=>date('Y-m-d H:i:s'),
                    ]);
                }
                
                $log=LogPengajuan::create([
                    'project_header_id'=>$id,
                    'deskripsi'=>$ket,
                    'status_id'=>$status_id,
                    'revisi'=>$revisi,
                    'state'=>1,
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
        
        $nst=HeaderProject::where('id',$id)->first();
        $data=ProjectMaterial::where('project_header_id',$id)->where('state',$nst->status_kontrak_id)->delete();
    }
}
