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
use App\Models\ViewPekerjaan;
use App\Models\ViewProjectMaterial;
use App\Models\ProjectRisiko;
use App\Models\ProjectOperasional;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ProjectDetailPekerjaan;
use App\Models\ViewCost;
use App\Models\User;
use PDF;

class PekerjaanController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        $ide=decoder($request->id);
        $cek=ViewHeaderProject::where('nik_pm',Auth::user()->username)->count();
        if($request->act!=""){
            $act=$request->act;
        }else{
            $act=0;
        }
        if($cek>0){
            if($ide>0){
                $mst=ViewHeaderProject::where('id',$ide)->where('nik_pm',Auth::user()->username)->first();
                $id=$mst->id;
                $pekerjaan=$mst->deskripsi_project;
            }else{
                $mst=ViewHeaderProject::where('nik_pm',Auth::user()->username)->orderBy('id','Asc')->firstOrfail();
                $id=$mst->id;
                $pekerjaan=$mst->deskripsi_project;
                // dd($pekerjaan);
            }
            return view('pekerjaan.index',compact('template','ide','id','pekerjaan','act'));
        }else{
            return view('pekerjaan.index_null',compact('template','ide','id','pekerjaan','act'));
        }
        
       
    }

    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        
        $data=ViewPekerjaan::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        if($request->tanggal!=""){
            $tanggal=$request->tanggal;
        }else{
            $tanggal=0;
        }
        return view('pekerjaan.view_data',compact('template','data','disabled','id','tanggal'));
    }
    public function cetak(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        $get=ViewPekerjaan::where('project_header_id',$id)->orderBy('id','Asc')->get();
        // dd($get);
        // dd(url_img().'\logo.png');
        $pdf = PDF::loadView('pekerjaan.cetak', compact('data','id','get'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
    public function modal_aktifitas(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        
        $data=ProjectDetailPekerjaan::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('pekerjaan.modal_aktifitas',compact('template','data','disabled','id'));
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
    public function delete_aktifitas(request $request)
    {
        $id=$request->id;
        
        $data=ProjectDetailPekerjaan::where('id',$id)->delete();
    }

    public function get_data(request $request)
    {
        error_reporting(0);
        $id=decoder($request->id);
        $query=ProjectPekerjaan::query();
        
        $mst=ViewProjectPekerjaan::where('id',$id)->where('nik_pm',Auth::user()->username)->where('status_kontrak_id',2)->first();
                
        
        $success=[];
        $success['project_id']=$mst->id;
        $success['deskripsi_project']=$mst->deskripsi_project;
        $success['customer_code']=$mst->customer_code;
        $success['customer']=$mst->customer;
        $success['total']=$mst->total;
        $success['baru']=$mst->baru;
        $success['progres']=$mst->progres;
        $success['persen']=$mst->persen;
        $success['selesai']=$mst->selesai;
        $outs=0;
            $new=[];
            if($request->act==0){
                $getnew=ViewPekerjaan::where('project_header_id',$mst->id)->whereIn('status',array(1,2,3))->orderBy('urut','Asc')->get();
            }
            if($request->act==1){
                $getnew=ViewPekerjaan::where('project_header_id',$mst->id)->whereIn('status',array(1,2))->orderBy('urut','Asc')->get();
            }
            if($request->act==2){
                $getnew=ViewPekerjaan::where('project_header_id',$mst->id)->whereIn('status',array(3))->orderBy('urut','Asc')->get();
            }
            
            
            foreach($getnew as $no=>$nw){
                if($nw->outstanding>0 && $nw->status!=3){
                    $outs+=1;
                    $sisa_waktu=ubah_uang($nw->sisa_waktu);
                }else{
                    $sisa_waktu=$nw->sisa_waktu;
                    $outs+=0;
                }
                $snew['nomor']='P.NO '.$nw->urut;
                $snew['total_aktivitas']=$nw->total_aktivitas;
                $snew['int_status_project']=$nw->int_status_project;
                $snew['color_status']=$nw->color_status;
                $snew['pekerjaan']=$nw->pekerjaan;
                $snew['mulai']=tgl_example($nw->mulai);
                $snew['update']=facebook_time_ago($nw->updated_at);
                $snew['sampai']=tgl_example($nw->sampai);
                $snew['total_hari']=$nw->total_hari;
                $snew['status']=$nw->status;
                $snew['persen_project']=$nw->persen_project;
                $snew['sisa_waktu']=$sisa_waktu;
                $snew['warna_status']=$nw->warna_status;
                $snew['outstanding']=$nw->outstanding;
                $snew['pekerjaan_id']=$nw->id;
                $new[]=$snew;
            }
        $success['data_new']=$new;
        
        $success['outstanding']=$outs;
        return response()->json($success, 200);
        
        
        
       
    }
    public function close_data(request $request)
    {
        $cek=ViewPekerjaan::where('id',$request->id)->where('total_aktivitas','>',0)->count();
        
        if($cek>0){
            $sv=ProjectPekerjaan::where('id',$request->id)->update(['close_date'=>date('Y-m-d H:i:s'),'status'=>3]);
            echo'@ok';
        }else{
            echo'<div class="nitof"><div class="isi-nitof"> - Setidaknya masukan 1 aktifitas</div></div>';
        }
    }
    public function get_data_detail(request $request)
    {
        error_reporting(0);
        $id=$request->id;
        $query=ViewPekerjaan::query();
        
        $mst=ViewPekerjaan::where('id',$id)->first();
        if($mst->outstanding>0){
            $sisa_waktu=ubah_uang($mst->sisa_waktu);
        }else{
            $sisa_waktu=$mst->sisa_waktu;
        }
        $getnew=ProjectDetailPekerjaan::where('project_pekerjaan_id',$id)->orderBy('tanggal_aktifitas','Desc')->get();;
        $success=[];
        $success['pekerjaan']=$mst->pekerjaan;
        $success['mulai']=$mst->mulai;
        $success['update']=$mst->updated_at;
        $success['sampai']=$mst->sampai;
        $success['total_hari']=$mst->total_hari;
        $success['persen_project']=$mst->persen_project;
        $success['sisa_waktu']=$sisa_waktu;
        $success['warna_status']=$mst->warna_status;
        $success['outstanding']=$mst->outstanding;
        $success['pekerjaan_id']=$mst->id;
            $new=[];
            
            foreach($getnew as $no=>$nw){
                $snew['tanggal']=$nw->tanggal_aktifitas;
                $snew['aktifitas']=$nw->aktifitas;
                $snew['id']=$nw->id;
                $snew['created_at']=$nw->created_at;
                $snew['foto']=$nw->foto;
                $new[]=$snew;
            }
        $success['detail']=$new;   
        
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
    public function store_aktifitas(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['content']= 'required';
        $messages['content.required']= 'Masukan Penjelasan Aktiftas';
        $rules['tanggal']= 'required';
        $messages['tanggal.required']= 'Masukan tanggal Aktiftas';
        
        if($request->file!=""){
            $rules['file']= 'required|mimes:jpg,jpeg,png,gif';
            $messages['file.required']= 'Upload file image (jpg,png,jpeg,gif)';
            $messages['file.mimes']= 'Upload file image (jpg,png,jpeg,gif)';
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
            if($request->id==0){
                    $created=date('Y-m-d H:i:s');
                    $data=ProjectDetailPekerjaan::UpdateOrcreate([
                        'project_pekerjaan_id'=>$request->pekerjaan_id,
                        'created_at'=>$created,
                    ],[
                        'aktifitas'=>$request->content,
                        'tanggal_aktifitas'=>$request->tanggal,
                    ]);
                    $head=ProjectPekerjaan::UpdateOrcreate([
                        'id'=>$request->pekerjaan_id,
                    ],[
                        'status'=>2,
                        'updated_at'=>date('Y-m-d'),
                    ]);
                    if($request->file!=""){
                        $thumbnail = $request->file('file');
                        $thumbnailFileName ='DPK-'.$request->pekerjaan_id.'-'.date('ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                        $filename =$thumbnailFileName;
                        $file = \Storage::disk('public_pekerjaan');
                        
                        if($file->put($filename, file_get_contents($thumbnail))){
                            $data=ProjectDetailPekerjaan::where('id',$data->id)->update([
                                'foto'=>$filename,
                            ]);
                        }
                        echo'@ok';
                    }else{
                        echo'@ok';
                    }
                    
                
            }else{
                $mtr=ProjectDetailPekerjaan::where('id',$data->id)->first();
                $data=ProjectDetailPekerjaan::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'aktifitas'=>$request->content,
                    'tanggal_aktifitas'=>$request->tanggal,
                ]);
                if($request->file!=""){
                    $thumbnail = $request->file('file');
                    $thumbnailFileName ='DPK-'.$mtr->project_pekerjaan_id.'-'.date('ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                    $filename =$thumbnailFileName;
                    $file = \Storage::disk('public_pekerjaan');
                    
                    if($file->put($filename, file_get_contents($thumbnail))){
                        
                        $data=ProjectDetailPekerjaan::where('id',$request->id)->update([
                            'foto'=>$filename,
                        ]);
                    }
                    echo'@ok';
                }else{
                    echo'@ok';
                }
            }
           
        }
    }
}
