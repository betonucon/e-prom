<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('login');
    }
    public function forget_password()
    {
        return view('auth.forget');
    }
    public function store_reset(request $request)
    {
        error_reporting(0);
        $rules = [];
        $messages = [];
        $rules['email']= 'required|email';
        $messages['email.required']= 'Email field is required';

        $rules['no_hp']= 'required|numeric';
        $messages['no_hp.required']= 'No Whatsapp field is required';
        $messages['no_hp.numeric']= 'No Whatsapp must numeric';

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
            $cek=User::where('email',$request->email)->where('no_handphone',$request->no_hp)->count();
            if($cek>0){
                $otp=date('His');
                $token=Hash::make(date('His'));
                $save=Otp::UpdateOrcreate([
                    'email'=>$request->email,
                    'no_handphone'=>$request->no_hp,
                ],[
                    'otp'=>$otp,
                    'token'=>$token,
                    'sts'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                $link=url('verify').'?token='.
                $text='Hay kode OTP anda adalah :<b>'.$otp.'</b><br> atau gunakan link verifikasi '.$link;
                send_wa($request->no_hp,$text,'Reset Password');
                echo'@ok@'.$token;
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Email atau no whatsapp tidak terdaftar</div></div>';
            }
        }
    }
}