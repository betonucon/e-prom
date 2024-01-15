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
use App\Models\ViewProjectPekerjaan;
use App\Models\ViewProjectMaterial;
use App\Models\ProjectRisiko;
use App\Models\ProjectOperasional;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ViewCost;
use App\Models\User;
use PDF;

class PekerjaanController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
            return view('pekerjaan.index',compact('template'));
        
       
    }

    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=Customer::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('customer.view_data',compact('template','data','disabled','id'));
    }
   
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Customer::find($request->id);
        $id=$request->id;
        
        return view('customer.modal',compact('template','data','disabled','id'));
    }
    public function delete(request $request)
    {
        $id=$request->id;
        
        $data=Customer::where('id',$id)->update(['active'=>$request->act]);
    }

    public function get_data(request $request)
    {
        error_reporting(0);
        $id=decoder($request->id);
        $query=ProjectPekerjaan::query();
        $cek=ViewProjectPekerjaan::where('id',$id)->where('nik_pm',Auth::user()->username)->where('status_kontrak_id',2)->count();
        if($id>0){
            $mst=ViewProjectPekerjaan::where('id',$id)->where('nik_pm',Auth::user()->username)->where('status_kontrak_id',2)->first();
                
        }else{
            $mst=ViewProjectPekerjaan::where('nik_pm',Auth::user()->username)->where('status_kontrak_id',2)->orderBy('id','Asc')->firstOrfail();
        }
        $success=[];
        $success['project_id']=$mst->id;
        $success['deskripsi_project']=$mst->deskripsi_project;
        $success['customer_code']=$mst->customer_code;
        $success['customer']=$mst->customer;
        $success['total']=$mst->total;
        $success['baru']=$mst->baru;
        $success['progres']=$mst->progres;
        $success['selesai']=$mst->selesai;
            $new=[];
            $getnew=ProjectPekerjaan::where('project_header_id',$mst->id)->where('status',1)->orderBy('id','Asc')->get();;
            foreach($getnew as $no=>$nw){
                $snew['pekerjaan']=$nw->pekerjaan;
                $snew['mulai']=$nw->mulai;
                $snew['sampai']=$nw->sampai;
                $new[]=$snew;
            }
        $success['data_new']=$new;
            $progres=[];
            $getprogres=ProjectPekerjaan::where('project_header_id',$mst->id)->where('status',2)->orderBy('id','Asc')->get();;
            foreach($getprogres as $no=>$nw){
                $snew['pekerjaan']=$nw->pekerjaan;
                $snew['mulai']=$nw->mulai;
                $snew['sampai']=$nw->sampai;
                $progres[]=$snew;
            }
        $success['data_progres']=$progres;
            $selesai=[];
            $getselesai=ProjectPekerjaan::where('project_header_id',$mst->id)->where('status',3)->orderBy('id','Asc')->get();;
            foreach($getselesai as $no=>$nw){
                $snew['pekerjaan']=$nw->pekerjaan;
                $snew['mulai']=$nw->mulai;
                $snew['sampai']=$nw->sampai;
                $selesai[]=$snew;
            }
        $success['data_selesai']=$selesai;
        return response()->json($success, 200);
        
        
        
       
    }

    public function get_role(request $request)
    {
        error_reporting(0);
        $query = Viewrole::query();
        // if($request->KD_Divisi!=""){
        //     $data = $query->where('kd_divisi',$request->KD_Divisi);
        // }
        $data = $query->where('id','!=',1)->orderBy('id','Asc')->get();
        $success=[];
        foreach($data as $o){
            $btn='
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box" style="margin-bottom: 5px; min-height: 50px;">
                        <span class="info-box-iconic bg-'.$o->color.'" style="margin-bottom: 1px; min-height: 50px;"><i class="fa fa-users"></i></span>
        
                        <div class="info-box-content" style="padding: 5px 10px; margin-left: 50px;">
                            <span class="info-box-text">'.$o->role.'</span>
                            <span class="info-box-number">'.$o->total.'<small>"</small></span>
                        </div>
                    </div>
                </div>
            ';
            $scs=[];
            $scs['id']=$o->id;
            $scs['action']=$btn;
            $success[]=$scs;
        }
        return response()->json($success, 200);
    }
    
    
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        if($request->id=='0'){
            $rules['customer_code']= 'required';
            $messages['customer_code.required']= 'Masukan customer code';
        }
        $rules['customer']= 'required';
        $messages['customer.required']= 'Masukan customer';
        
        $rules['alamat']= 'required';
        $messages['alamat.required']= 'Masukan area / lokasi project';

       
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
                
                    $data=Customer::create([
                        'customer_code'=>penomoran_customer(),
                        'alamat'=>$request->alamat,
                        'active'=>1,
                        'customer'=>$request->customer,
                    ]);
                    echo'@ok';
                
            }else{
                $data=Customer::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'alamat'=>$request->alamat,
                    'customer'=>$request->customer,
                    'singkatan'=>$request->singkatan,
                ]);
                echo'@ok';
            }
           
        }
    }
}
