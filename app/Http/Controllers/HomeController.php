<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViewPekerjaan;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {
        $id=5;
        $get=ViewPekerjaan::where('project_header_id',$id)->orderBy('id','Asc')->get();
        return view('home',compact('get','id'));
    }
    public function get_data(request $request)
    {
        $success=[];
        $kontrak=[];
        foreach(get_kontrak_dashboard() as $o){
            $get=ViewPekerjaan::where('project_header_id',$o->id)->orderBy('mulai','Asc')->get();
            $subkontrak['project']=$o->deskripsi_project;
            $subkontrak['start_date']=$o->start_date;
            $subkontrak['end_date']=$o->end_date;
            $pekerjaan=[];
            foreach($get as $p){
                $subpekerjaan['pekerjaan']=$p->pekerjaan;
                $subpekerjaan['mulai']=$p->mulai;
                $subpekerjaan['sampai']=$p->sampai;
                $subpekerjaan['total_hari']=$p->total_hari;
                $subpekerjaan['sisa_waktu']=(int) $p->sisa_waktu;
                $pekerjaan[]=$subpekerjaan;
            }
            $subkontrak['data']=$pekerjaan;
            $kontrak[]=$subkontrak;
        }
        $success=$kontrak;
        


        return response()->json($success, 200);
    }
    public function get_data_one(request $request)
    {
        $success=[];
       
            $get=ViewPekerjaan::where('project_header_id',$request->id)->orderBy('urut','Asc')->get();
            $pekerjaan=[];
            foreach($get as $p){
                $subpekerjaan['pekerjaan']=$p->pekerjaan;
                $subpekerjaan['urut']='PR'.$p->urut;
                $subpekerjaan['mulai']=$p->mulai;
                $subpekerjaan['sampai']=$p->sampai;
                $subpekerjaan['total_hari']=$p->total_hari;
                $subpekerjaan['sisa_waktu']=(int) $p->sisa_waktu;
                $pekerjaan[]=$subpekerjaan;
            }
            
        
        $success=$pekerjaan;
        


        return response()->json($success, 200);
    }
}
