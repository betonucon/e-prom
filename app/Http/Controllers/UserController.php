<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    
    public function index(request $request)
    {
       
        return view('user.index');
    }
    
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=User::find($request->id);
        $id=$request->id;
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('user.modal',compact('template','data','disabled','id','disabled'));
    }
    
    public function get_data(request $request)
    {
        error_reporting(0);
        $data = User::orderBy('id','Asc')->get();

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
                            <li onclick="tambah('.$row->id.')"><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>';
                            if(Auth::user()->id==$row->id){
                                $btn.='';
                            }else{
                                if($row->active==1){   
                                    $btn.='
                                    <li onclick="delete_data('.$row->id.',1)">
                                        <a class="dropdown-item remove-item-btn">
                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Non Active
                                        </a>
                                    </li>';
                                }else{
                                    $btn.='
                                    <li onclick="delete_data('.$row->id.',3)">
                                        <a class="dropdown-item remove-item-btn">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Active
                                        </a>
                                    </li>';
                                }
                            }
                            if(Auth::user()->id!=$row->id){
                            $btn.='
                            <li onclick="delete_data('.$row->id.',2)">
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
                                <img src="'.url_plug().'/assets/images/svg/crypto-icons/btc.svg" alt="" class="avatar-xxs me-2">
                                <a href="javascript:void(0);" class="currency_name">Admin</a>
                            </div>';
                }else{
                    $btn='<div class="d-flex align-items-center fw-medium">
                                <img src="'.url_plug().'/assets/images/svg/crypto-icons/btc.svg" alt="" class="avatar-xxs me-2">
                                <a href="javascript:void(0);" class="currency_name">User Monitoring</a>
                            </div>';
                }
                
                return $btn;
            })
            ->addColumn('status', function ($row) {
                if($row->active==1){
                    $btn='<button class="btn btn-sm btn-info">Active</button>';
                }else{
                    $btn='<button class="btn btn-sm btn-danger">Non Active</button>';
                }
                
                return $btn;
            })
            
            ->rawColumns(['action','rolenya','status'])
            ->make(true);
    }
    
    
    public function delete(request $request){
        if($request->act==1){
            $data = User::where('id',$request->id)->update(['active'=>0]);
        }
        if($request->act==3){
            $data = User::where('id',$request->id)->update(['active'=>1]);
        }
        if($request->act==2){
            $data = User::where('id',$request->id)->delete();
        }
        

    }
    
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['name']= 'required';
        $rules['username']= 'required';
        $rules['email']= 'required';
        $rules['role_id']= 'required';
        
        $rules['password']= 'required|min:6';
       
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
                $cek=User::where('email',$request->email)->orWhere('username',$request->username)->count();
                if($cek>0){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Email or Username is ready </div></div>';
                }else{
                    $data=User::create([
                        'username'=>$request->username,
                        'role_id'=>$request->role_id,
                        'email'=>$request->email,
                        'name'=>$request->name,
                        'password'=>Hash::make($request->password),
                        'password_token'=>encoder($request->password),
                        'active'=>1,
                        'created_at'=>date('Y-m-d H:i:s'),
                    ]);

                    echo'@ok';
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
    
}
