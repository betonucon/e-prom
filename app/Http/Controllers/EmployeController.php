<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\ViewEmploye;
use App\Models\Viewrole;
use App\Models\Role;
use App\Models\Employe;
use App\Models\Barang;
use App\Models\User;

class EmployeController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('employe.index',compact('template'));
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Employe::find($request->id);
        $id=$request->id;
        
        return view('employe.modal',compact('template','data','disabled','id'));
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewEmploye::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('employe.view_data',compact('template','data','disabled','id'));
    }
   

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewEmploye::query();
        if($request->hide==1){
            $data = $query->where('active',0);
        }else{
            $data = $query->whereIn('active',array(0,1));
        }
        if($request->crt==1){
            $data = $query->whereIn('jabatan_id',array(3,4,5));
        }
        $data = $query->orderBy('nama','Asc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-sm" onclick="pilih_employe(`'.$row->nik.'`,`'.$row->nama.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn='
                <span class="dtr-data">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li onclick="tambah('.$row->id.')"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                            
                            if(Auth::user()->id!=$row->id){
                            $btn.='
                            <li onclick="delete_data(`'.encoder($row->id).'`,3)">
                                <a class="dropdown-item remove-item-btn">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                </a>
                            </li>';
                            }
                            $btn.='
                        </ul>
                    </div>
                </span>
                ';
                return $btn;
            })
            ->addColumn('rolenya', function ($row) {
                if($row->role_id==1){
                    $btn='<div class="d-flex align-items-center fw-medium">
                                <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                <a href="javascript:void(0);" class="currency_name">Admin</a>
                            </div>';
                }else{
                    $btn='<div class="d-flex align-items-center fw-medium">
                                <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                <a href="javascript:void(0);" class="currency_name">User Monitoring</a>
                            </div>';
                }
                
                return $btn;
            })
            ->addColumn('statusnya', function ($row) {
                if($row->active==1){
                    $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" onclick="switch_data(`'.encoder($row->id).'`,1)" checked>
                            </div>';
                }else{
                    $btn='<div class="form-check form-switch form-switch-custom form-switch-danger">
                                <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck13" onclick="switch_data(`'.encoder($row->id).'`,3)" >
                            </div>';
                }
                
                return $btn;
            })
            
            ->rawColumns(['action','rolenya','statusnya','seleksi'])
            ->make(true);
    }
    public function get_data_pm(request $request)
    {
        error_reporting(0);
        $query = ViewEmploye::query();
        if($request->hide==1){
            $data = $query->where('active',0);
        }else{
            $data = $query->where('active',1);
        }
        $data = $query->orderBy('nama','Asc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_employe(`'.$row->nik.'`,`'.$row->nama.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                if($row->active==1){
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;" onclick="location.assign(`'.url('employe/view').'?id='.encoder($row->id).'`)">View</a></li>
                                <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,`0`)">Hidden</a></li>
                            </ul>
                        </div>
                    ';
                }else{
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,1)">Un Hidden</a></li>
                            </ul>
                        </div>
                    ';
                }
                return $btn;
            })
            
            ->rawColumns(['action','seleksi'])
            ->make(true);
    }

    public function delete(request $request){
        $id=decoder($request->id);
        $mst=Employe::where('id',$id)->first();
        if($request->act==1){
            $emp=Employe::where('nik',$mst->nik)->update(['active'=>0]);
            $data = User::where('username',$mst->nik)->update(['active'=>0]);
        }
        if($request->act==3){
            $emp=Employe::where('nik',$mst->nik)->update(['active'=>1]);
            $data = User::where('username',$mst->nik)->update(['active'=>1]);
        }
        if($request->act==2){
            $emp = Employe::where('nik',$mst->nik)->delete();
            $data = User::where('username',$mst->nik)->delete();
        }
        

    }
    public function switch_to(request $request)
    {
        $data=User::where('username',Auth::user()->username)->update(['role_id'=>$request->role_id]);
    }

    public function get_role(request $request)
    {
        error_reporting(0);
        $query = Viewrole::query();
        // if($request->KD_Divisi!=""){
        //     $data = $query->where('kd_divisi',$request->KD_Divisi);
        // }
        $data = $query->whereNotIn('id',array(1,8))->orderBy('id','Asc')->get();
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
            $rules['nik']= 'required';
            $messages['nik.required']= 'Harap lengkapi nik';

            $rules['email']= 'required|email|unique:users';
            $messages['email.required']= 'Harap lengkapi email';
            $messages['email.email']= 'Format email salah';
        }
        

        $rules['nama']= 'required';
        $messages['nama.required']= 'Harap lengkapi nama';

        
        
        $rules['jabatan_id']= 'required';
        $messages['jabatan_id.required']= 'Harap lengkapi jabatan';

        $rules['role_id']= 'required';
        $messages['role_id.required']= 'Harap lengkapi Otorisasi';

        
       
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
                $data=Employe::UpdateOrcreate([
                    'nik'=>$request->nik,
                ],[
                    'nama'=>$request->nama,
                    'jabatan_id'=>$request->jabatan_id,
                    'role_id'=>$request->role_id,
                    'email'=>$request->email,
                    
                    'active'=>1,
                ]);
                $user=User::UpdateOrcreate([
                    'username'=>$request->nik,
                ],[
                    'name'=>$request->nama,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->nik),
                    'role_id'=>$request->role_id,
                    'role_utama'=>$request->role_id,
                    'active'=>1,
                ]);
                echo'@ok';
            }else{
                $data=Employe::UpdateOrcreate([
                    'nik'=>$request->nik,
                ],[
                    'nama'=>$request->nama,
                    'jabatan_id'=>$request->jabatan_id,
                    'role_id'=>$request->role_id,
                ]);

                $user=User::UpdateOrcreate([
                    'username'=>$request->nik,
                ],[
                    'name'=>$request->nama,
                    'role_id'=>$request->role_id,
                    'active'=>1,
                ]);
                echo'@ok';
            }
           
        }
    }
}
