<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use App\Models\Service;
use App\Models\SchemaService;

class ServiceController extends Controller
{
    
    public function index(request $request)
    {
       
        return view('service.index');
    }
    
    public function view(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        $data=Service::find($id);
        if($id>0){
            $readonly="readonly";
        }else{
            $readonly="";
        }
        return view('service.view',compact('template','data','disabled','id','readonly'));
    }
    public function tampil_schema(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        $service_id=$request->service_id;
        $data=SchemaService::find($id);
        // create_dbtabel('ucon');
        return view('service.tampil_schema',compact('template','data','disabled','id','service_id'));
    }
   
    public function get_data(request $request)
    {
        error_reporting(0);
        $query = Service::query();
        if($request->tipe=='R' || $request->tipe=='S' ){
            $data=$query->where('service_type',$request->tipe);
        }
        $data = $query->orderBy('id','Asc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn='
                <span class="dtr-data">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li onclick="location.assign(`'.url('service/view').'?id='.encoder($row->id).'`)"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li onclick="delete_data('.$row->id.')">
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
            ->addColumn('log', function ($row) {
                $btn='<span  class="btn btn-success btn-sm btn-icon waves-effect waves-light" titla="Log Response" onclick="location.assign(`'.url('getkey/'.$row->service_name).'`)"><i class="mdi mdi-history"></i></span>';
                return $btn;
            })
            ->addColumn('service_custome', function ($row) {
                $btn='<p style="color: #000;margin-bottom: 0px;"><b>SERVICE_</b>'.strtoupper($row->service_name).'</p>';
                return $btn;
            })
            ->addColumn('database', function ($row) {
                $btn='<p style="color: #8080c3;margin-bottom: 0px;"><b><i class="mdi mdi-database"></i></b>'.strtoupper($row->tcq_target).'</p>';
                return $btn;
            })
            ->addColumn('adapter', function ($row) {
                $btn='<p style="color: #8080c3;margin-bottom: 0px;">'.strtoupper($row->service_adapter).'</p>';
                return $btn;
            })
            ->addColumn('endpoint', function ($row) {
                $btn='<p style="color: #8080c3;margin-bottom: 0px;">'.strtoupper($row->endpoint_method).'</p>';
                return $btn;
            })
            ->addColumn('servicetype', function ($row) {
                $btn='<p style="color: #8080c3;margin-bottom: 0px;">'.strtoupper($row->service_type).'</p>';
                return $btn;
            })
            ->addColumn('statusnya', function ($row) {
                if($row->is_active=='Y'){
                    $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" onclick="switch_data('.$row->id.',1)" checked>
                            </div>';
                }else{
                    $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" onclick="switch_data('.$row->id.',3)" >
                            </div>';
                }
                
                return $btn;
            })
            
            ->rawColumns(['action','statusnya','log','service_custome','database','adapter','endpoint','servicetype'])
            ->make(true);
    }

    public function get_data_dashboard(request $request)
    {
        error_reporting(0);
        $all=Service::count();
        $tiper=Service::where('service_type','R')->count();
        $tipes=Service::where('service_type','S')->count();
        $success=[];
        
            $success=[];
            $success['all']=$all;
            $success['tiper']=$tiper;
            $success['tipes']=$tipes;
            
            
        
        
        return response()->json($success, 200);
    }
    public function get_data_schema(request $request)
    {
        error_reporting(0);
        $data = SchemaService::where('service_id',$request->service_id)->orderBy('id','Asc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn='
                <span class="dtr-data">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li onclick="tambah_schema('.$row->id.')"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li onclick="delete_data('.$row->id.')">
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
            ->addColumn('name_jobs', function ($row) {
                $btn=$row->atribut.' '.$row->jabatan;
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function get_data_user(request $request)
    {
        error_reporting(0);
        $query = ViewUser::query();
        if($request->search!=""){
            $data=$query->where('name','LIKE','%'.$request->search.'%');    
        }
        $data = $query->orderBy('name','Asc')->get();
        $success=[];
        foreach($data as $o){
            $scs=[];
            $scs['id']=$o->id;
            $scs['users_id']=encoder($o->id);
            $scs['ide']=encoder($o->id);
            $scs['name']=$o->name;
            $scs['email']=$o->email;
            $scs['last_name']=$o->last_name;
            $scs['nama_lengkap']=$o->name.' '.substr($o->last_name,0,15);
            $scs['short_name']=$o->short_name;
            $scs['total']=$o->total;
            $scs['performance']=$o->persen;
            $scs['total_project']=$o->total_project;
            $scs['total_proses']=$o->total_proses;
            $scs['total_verify']=$o->total_verify;
            $scs['solved']=$o->total_verify;
            $scs['overdue']=($o->total_solved_overdue+$o->total_progres_overdue);
            if($o->photo!=null || $o->photo!=""){
                $scs['fotoakun']='https://project.dcktrp.id/app/webroot/users/image_thumb/?type=photos&file='.$o->photo.'&sizex=32&sizey=32&quality=100';
            }else{
                $scs['fotoakun']=url_plug().'/img/akun.png';
            }
            
            $success[]=$scs;
        }
        
        return response()->json($success, 200);
    }
    public function get_data_notifikasi(request $request)
    {
        error_reporting(0);
        $query = Notifikasi::query();
        $total = $query->where('users_id',Auth::user()->id)->where('status',0)->count();
        $data = $query->where('users_id',Auth::user()->id)->where('status',0)->orderBy('created_at','Desc')->get();
        $success=[];
        $success['total']=$total;
        $det=[];
        foreach($data as $o){
            if($o->tipe==1){
                $tipe='Task';
            }else{
                $tipe='Project';
            }
            $scs=[];
            $scs['id']=$o->id;
            $scs['users_id']=$o->users_id;
            $scs['tipe']=$tipe;
            $scs['notifikasi']=$o->notifikasi;
            $scs['link']=url('task').'?id='.encoder($o->project_id);
            $scs['created_at']=tanggal_indo_full($o->created_at);
            
            $det[]=$scs;
        }
        $success['data']=$det;
        return response()->json($success, 200);

    }

    public function delete(request $request){
        if($request->act==1){
            $data = Service::where('id',$request->id)->update(['is_active'=>'N']);
        }
        if($request->act==3){
            $data = Service::where('id',$request->id)->update(['is_active'=>'Y']);
        }
        if($request->act==2){
            $data = Service::where('id',$request->id)->delete();
        }
        

    }

   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        if($request->id==0){
            $rules['service_name']= 'required|max:24';
        }
        

        $rules['endpoint']= 'required';
        $rules['service_type']= 'required';
        $rules['service_adapter']= 'required';
        $rules['endpoint_method']= 'required';
        $rules['loop_interval']= 'required';
        if($request->service_type=='S'){
            $rules['tcq_source']= 'required';
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
                $cek=Service::where('service_name',$request->service_name)->count();
                if($cek>0){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Service Name is ready</div></div>';
                }else{
                    if($request->service_type=='R'){
                        $table='tcq_'.$request->service_name.'_r';
                        $table_source=null;
                    }else{
                        $table='tcq_'.$request->service_name.'_s';
                        $table_source=$request->tcq_source;
                    }
                    

                    $data=Service::create([
                        'service_name'=>$request->service_name,
                        'endpoint'=>$request->endpoint,
                        'service_type'=>$request->service_type,
                        'service_adapter'=>$request->service_adapter,
                        'endpoint_method'=>$request->endpoint_method,
                        'loop_interval'=>$request->loop_interval,
                        'tcq_target'=>$table,
                        'set'=>1,
                        'tcq_source'=>$table_source,
                        'created_at'=>date('Y-m-d H:i:s'),
                    ]);
                    create_dbtabel($table);
                    echo'@ok@'.encoder($data['id']);
                }
                    
                
            }else{
                
                    $data=Service::where('id',$request->id)->update([
                        'endpoint'=>$request->endpoint,
                        'service_type'=>$request->service_type,
                        'service_adapter'=>$request->service_adapter,
                        'endpoint_method'=>$request->endpoint_method,
                        'loop_interval'=>$request->loop_interval,
                        'created_at'=>date('Y-m-d H:i:s'),
                    ]);
                    echo'@ok@'.encoder($request->id);
                   
               
            }
        }
    }

    public function store_schema(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['field_name']= 'required';
        $rules['field_type']= 'required';
        $rules['field_length']= 'required';
        if($request->field_type=='date' || $request->field_type=='datetime'){
            $rules['date_format']= 'required';
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
           
            
                $data=SchemaService::UpdateOrcreate([
                    'service_id'=>$request->service_id,
                    'field_name'=>$request->field_name,
                ],[
                    'field_type'=>$request->field_type,
                    'parent_id'=>$request->parent_id,
                    'is_multiple'=>$request->is_multiple,
                    'is_required'=>$request->is_required,
                    'field_length'=>$request->field_length,
                    'date_format'=>$request->date_format,
                ]);

                echo'@ok';
           
                
                
            
        }
    }
    
}
