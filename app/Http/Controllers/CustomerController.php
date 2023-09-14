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
use App\Models\Customer;
use App\Models\Barang;
use App\Models\ViewCustomer;
use App\Models\User;

class CustomerController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('customer.index',compact('template'));
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
        $query = ViewCustomer::query();
       
        $data = $query->orderBy('customer','Asc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-sm" onclick="pilih_customer(`'.$row->customer_code.'`,`'.$row->customer.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('seleksi_kontrak', function ($row) {
                $btn='<span class="btn btn-success btn-sm" onclick="pilih_customer(`'.$row->customer_code.'`,`'.$row->customer.'`,`'.$row->cost.'`,`'.penomoran_cost_center($row->customer_code).'`)">Pilih</span>';
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
                            
                            if($row->active==1){   
                                $btn.='
                                <li onclick="delete_data('.$row->id.',0)">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Non Active
                                    </a>
                                </li>';
                            }else{
                                $btn.='
                                <li onclick="delete_data('.$row->id.',1)">
                                    <a class="dropdown-item remove-item-btn">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Active
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
            
            ->rawColumns(['action','seleksi','seleksi_kontrak'])
            ->make(true);
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
