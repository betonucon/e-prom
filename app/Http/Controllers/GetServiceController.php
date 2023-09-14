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

class GetServiceController extends Controller
{
    
    public function index(request $request,$id)
    {
        $data=Service::where('service_name',$id)->first();
        return view('getservice.index',compact('data'));
    }
    public function request(request $request,$id)
    {
        $mst=Service::where('service_name',$id)->first();
        $data = DB::table($mst->tcq_target)->where('id',$request->id)->first();
        if($data->status==1){
            $btn='<span class="badge badge-soft-danger">Pendding</span>';
        }
        if($data->status==2){
            $btn='<span class="badge badge-soft-success">Success</span>';
        }
        if($data->status==3){
            $btn='<span class="badge badge-soft-dark">Close</span>';
        }
        $show='
        <div class="table-responsive mt-3">
                <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                    <tbody class="border-0">
                        <tr>
                            <td width="20%">
                                <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Service Name</h4>
                            </td>
                            <td>
                                <p class="text-muted mb-0"><b>:</b> '.$mst->service_name.'</p>
                            </td>
                           
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>EndPoint</h4>
                            </td>
                            <td>
                                <p class="text-muted mb-0"><b>:</b> '.$mst->endpoint_method.' => '.$mst->endpoint.'</p>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Status</h4>
                            </td>
                            <td>
                                <p class="text-muted mb-0"><b>:</b> '.$btn.'</p>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Status</h4>
                            </td>
                            <td>
                                <p class="text-muted mb-0"><b>:</b> '.$data->receive_at.'</p>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
            <pre  style="padding: 2%; background: #fafafd; height: 300px;width:100%;overflow-y:scroll">'.json_encode(json_decode($data->payload), JSON_PRETTY_PRINT).'</pre>
        ';
        return $show;
    }
    
    public function view(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        $data=Service::find($id);
        // create_dbtabel('ucon');
        return view('service.view',compact('template','data','disabled','id'));
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
   
    public function get_data(request $request,$id)
    {
        error_reporting(0);
        $mst=Service::where('service_name',$id)->first();
        $exp=explode(' to ',$request->tanggal_cari);
        if($request->tanggal_cari!=""){
            $data = DB::table($mst->tcq_target)->whereBetween('receive_at',[$exp[0],$exp[1]])->get();
        }else{
            $data = DB::table($mst->tcq_target)->get();
        }
        
        // $data = Service::orderBy('id','Asc')->get();

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
            ->addColumn('statusnya', function ($row) {
                if($row->status==1){
                    $btn='<span class="badge badge-soft-danger">Waiting</span>';
                }
                if($row->status==2){
                    $btn='<span class="badge badge-soft-success">Success</span>';
                }
                if($row->status==3){
                    $btn='<span class="badge badge-soft-dark">Close</span>';
                }
                return $btn;
            })
            ->addColumn('aksi', function ($row) {
                if($row->status==1){
                    $btn='<span class="btn btn-sm btn-default" title="Waiting"><i class="mdi mdi-timer-sand-complete"></i></span>';
                }
                if($row->status==2){
                    $btn='<span class="btn btn-sm btn-info" title="Back to process" onclick="kembali_diproses('.$row->id.',1)"><i class="mdi mdi-reload"></i></span>';
                }
                if($row->status==3){
                    $btn='<span class="btn btn-sm btn-info" title="Back to process" onclick="kembali_diproses('.$row->id.',1)"><i class="mdi mdi-reload"></i></span>';
                }
                return $btn;
            })
            ->addColumn('payload_short', function ($row) {
                $btn='<a href="#" onclick="show_request('.$row->id.')">'.substr($row->payload,0,98).'</a>';
                return $btn;
            })
            
            ->rawColumns(['action','statusnya','payload_short','aksi'])
            ->make(true);
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
    
    public function get_data_dashboard(request $request,$id)
    {
        error_reporting(0);
        $mst=Service::where('service_name',$id)->first();
        $all = DB::table($mst->tcq_target)->count();
        $error = DB::table($mst->tcq_target)->where('status',1)->count();
        $successall = DB::table($mst->tcq_target)->where('status',2)->count();
        $cancel = DB::table($mst->tcq_target)->where('status',3)->count();
        $success=[];
        
            $success=[];
            $success['all']=$all;
            $success['error']=$error;
            $success['success']=$successall;
            $success['close']=$cancel;
            
            
        
        
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
        $data = User::where('id',$request->id)->update(['active'=>0]);
    }
    public function kembali_diproses(request $request,$id){
        $mst=Service::where('service_name',$id)->first();
        
        if($request->act==1){
            $data = DB::table($mst->tcq_target)->where('id',$request->id)->limit(1)->update(['status'=>1]);
        }
        if($request->act==2){
            $data = DB::table($mst->tcq_target)->where('id',$request->id)->limit(1)->update(['status'=>3]);
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
                $cek=User::where('email',$request->email)->orWhere('no_handphone',$request->no_handphone)->count();
                if($cek>1){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Email atau No Handphone sudah terdaftar</div></div>';
                }else{
                    $mst=User::where('id',$request->id)->first();
                    if($request->password==$mst->password){
                        $password=$request->password;
                    }else{
                        $password=Hash::make(md5($request->password));
                    }
                    
                    $data=User::where('id',$request->id)->update([
                        'no_handphone'=>$request->no_handphone,
                        'email'=>$request->email,
                        'name'=>$request->name,
                        'role_id'=>$role_id,
                        'last_name'=>$request->last_name,
                        'short_name'=>$request->short_name,
                        'atribut_id'=>$request->atribut_id,
                        'kategori_ta_id'=>$request->kategori_ta_id,
                        'posisi_id'=>$request->posisi_id,
                        'jabatan_id'=>$request->jabatan_id,
                        'password'=>$password,
                        'photo'=>$request->photo,
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);

                    echo'@ok';
                }
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
