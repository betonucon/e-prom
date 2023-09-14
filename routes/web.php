<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RProjectController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\RKontrakController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Auth\LogoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/optimize-clear', function() {
    $exitCode = Artisan::call('optimize:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
}); 
Route::group(['prefix' => 'employe','middleware'    => 'auth'],function(){
    Route::get('/',[EmployeController::class, 'index']);
    Route::get('/view',[EmployeController::class, 'view_data']);
    Route::get('/getdata',[EmployeController::class, 'get_data']);
    Route::get('/getdatapm',[EmployeController::class, 'get_data_pm']);
    Route::get('/getrole',[EmployeController::class, 'get_role']);
    Route::get('/delete',[EmployeController::class, 'delete']);
    Route::get('/switch_to',[EmployeController::class, 'switch_to']);
    Route::get('/create',[EmployeController::class, 'create']);
    Route::get('/modal',[EmployeController::class, 'modal']);
    Route::post('/',[EmployeController::class, 'store']);
});

Route::group(['prefix' => 'cost','middleware'    => 'auth'],function(){
    Route::get('/',[CostController::class, 'index']);
    Route::get('/view',[CostController::class, 'view_data']);
    Route::get('/getdata',[CostController::class, 'get_data']);
    Route::get('/create',[CostController::class, 'create']);
    Route::get('/delete',[CostController::class, 'delete']);
    Route::get('/modal',[CostController::class, 'modal']);
    Route::post('/',[CostController::class, 'store']);
});
Route::group(['prefix' => 'setting','middleware'    => 'auth'],function(){
    Route::get('/',[SettingController::class, 'index']);
    Route::get('/view',[SettingController::class, 'view_data']);
    Route::get('/getdata',[SettingController::class, 'get_data']);
    Route::get('/create',[SettingController::class, 'create']);
    Route::get('/delete',[SettingController::class, 'delete']);
    Route::get('/modal',[SettingController::class, 'modal']);
    Route::post('/',[SettingController::class, 'store']);
});

Route::group(['prefix' => 'customer','middleware'    => 'auth'],function(){
    Route::get('/',[CustomerController::class, 'index']);
    Route::get('/view',[CustomerController::class, 'view_data']);
    Route::get('/getdata',[CustomerController::class, 'get_data']);
    Route::get('/create',[CustomerController::class, 'create']);
    Route::get('/delete',[CustomerController::class, 'delete']);
    Route::get('/modal',[CustomerController::class, 'modal']);
    Route::post('/',[CustomerController::class, 'store']);
});
Route::group(['prefix' => 'material','middleware'    => 'auth'],function(){
    Route::get('/',[MaterialController::class, 'index']);
    Route::get('/masuk',[MaterialController::class, 'index_masuk']);
    Route::get('/keluar',[MaterialController::class, 'index_keluar']);
    Route::get('/view',[MaterialController::class, 'view_data']);
    Route::get('/getdata',[MaterialController::class, 'get_data']);
    Route::get('/get_material',[MaterialController::class, 'get_material']);
    Route::get('/get_data_stok',[MaterialController::class, 'get_data_stok']);
    Route::get('/getdataevent',[MaterialController::class, 'get_data_event']);
    Route::get('/create_stok',[MaterialController::class, 'create_stok']);
    Route::get('/delete',[MaterialController::class, 'delete']);
    Route::get('/delete_stok',[MaterialController::class, 'delete_stok']);
    Route::get('/modal',[MaterialController::class, 'modal']);
    Route::post('/',[MaterialController::class, 'store']);
    Route::post('/store_stok',[MaterialController::class, 'store_stok']);
});




Route::group(['prefix' => 'project','middleware'    => 'auth'],function(){
    Route::get('/',[RProjectController::class, 'index']);
    Route::get('/view',[RProjectController::class, 'view_data']);
    Route::get('/form_send',[RProjectController::class, 'form_send']);
    Route::get('/timeline',[RProjectController::class, 'timeline']);
    Route::get('/getdata',[RProjectController::class, 'get_data']);
    Route::get('/getbiaya',[RProjectController::class, 'get_biaya']);
    Route::get('/getrekap',[RProjectController::class, 'get_data_rekap']);
    Route::get('/getdatalog',[RProjectController::class, 'get_data_log']);
    Route::get('/publish_data',[RProjectController::class, 'publish_data']);
    Route::get('/getdatadetail',[RProjectController::class, 'get_data_detail']);
    Route::get('/getdatapekerjaan',[RProjectController::class, 'get_data_pekerjaan']);
    Route::get('/get_status_data',[RProjectController::class, 'get_status_data']);
    Route::get('/getdatamaterial',[RProjectController::class, 'getdatamaterial']);
    Route::get('/create',[RProjectController::class, 'create']);
    Route::get('/total_item',[RProjectController::class, 'total_item']);
    Route::get('/total_qty',[RProjectController::class, 'total_qty']);
    Route::get('/delete',[RProjectController::class, 'delete']);
    Route::get('/delete_biaya',[RProjectController::class, 'delete_biaya']);
    Route::get('/tampil_risiko',[RProjectController::class, 'tampil_risiko']);
    Route::get('/tampil_risiko_view',[RProjectController::class, 'tampil_risiko_view']);
    Route::get('/delete_detail',[RProjectController::class, 'delete_detail']);
    Route::get('/delete_risiko',[RProjectController::class, 'delete_risiko']);
    Route::get('/delete_material',[RProjectController::class, 'delete_material']);
    Route::get('/delete_operasional',[RProjectController::class, 'delete_operasional']);
    
    Route::get('/modal_detail',[RProjectController::class, 'modal_detail']);
    Route::get('/modal',[RProjectController::class, 'modal']);
    Route::get('/reset_material',[RProjectController::class, 'reset_material']);
    Route::get('/reset_operasional',[RProjectController::class, 'reset_operasional']);
    Route::get('/reset_jasa',[RProjectController::class, 'reset_jasa']);
    Route::post('/',[RProjectController::class, 'store']);
    Route::post('/store_import_material',[RProjectController::class, 'store_import_material']);
    Route::get('/kirim_kadis_komersil',[RProjectController::class, 'kirim_kadis_komersil']);
    Route::post('/kembali_komersil',[RProjectController::class, 'kembali_komersil']);
    Route::post('/store_procurement',[RProjectController::class, 'store_procurement']);
    Route::post('/approve_data',[RProjectController::class, 'approve_data']);
    Route::post('/verifikasi_material',[RProjectController::class, 'verifikasi_material']);
   
    Route::get('/kirim_procurement',[RProjectController::class, 'kirim_procurement']);
    Route::get('/tampil_material',[RProjectController::class, 'tampil_material']);
    Route::get('/tampil_jasa',[RProjectController::class, 'tampil_jasa']);
    Route::get('/tampil_material_in',[RProjectController::class, 'tampil_material_in']);
    Route::get('/tampil_material_proc',[RProjectController::class, 'tampil_material_proc']);
    Route::get('/form_material',[RProjectController::class, 'form_material']);
    Route::get('/cetak',[RProjectController::class, 'cetak']);
    Route::get('/tampil_operasional',[RProjectController::class, 'tampil_operasional']);
    Route::post('/store_material',[RProjectController::class, 'store_material']);
    Route::post('/store_operasional',[RProjectController::class, 'store_operasional']);
    Route::get('/delete_jasa',[RProjectController::class, 'delete_jasa']);
    Route::post('/store_jasa',[RProjectController::class, 'store_jasa']);
    Route::post('/store_detail',[RProjectController::class, 'store_detail']);
    Route::post('/store_risiko',[RProjectController::class, 'store_risiko']);
    Route::post('/store_bidding',[RProjectController::class, 'store_bidding']);
    Route::post('/store_verifikasi',[RProjectController::class, 'store_verifikasi']);
    Route::post('/publish',[RProjectController::class, 'publish']);
    Route::post('/store_negosiasi',[RProjectController::class, 'store_negosiasi']);
});
Route::group(['prefix' => 'projectcontrol','middleware'    => 'auth'],function(){
    Route::get('/',[RKontrakController::class, 'index_control']);
    Route::get('/task',[RKontrakController::class, 'task']);
    Route::get('/form_material',[RKontrakController::class, 'form_material']);
    Route::get('/modal_task',[RKontrakController::class, 'modal_task']);
    Route::get('/modal_progres',[RKontrakController::class, 'modal_progres']);
    Route::get('/getdata',[RKontrakController::class, 'get_data_control']);
    Route::get('/getdatatask',[RKontrakController::class, 'get_data_task']);
    Route::post('/store_task',[RKontrakController::class, 'store_task']);
    Route::post('/store_progres',[RKontrakController::class, 'store_progres']);
});
Route::group(['prefix' => 'pengadaan','middleware'    => 'auth'],function(){
    Route::get('/',[PengadaanController::class, 'index']);
    Route::get('/getdata',[PengadaanController::class, 'get_data']);
    Route::get('/getdatamaterial',[PengadaanController::class, 'get_data_material']);
    Route::get('/getdatapengadaan',[PengadaanController::class, 'get_data_pengadaan']);
    Route::get('/view',[PengadaanController::class, 'view']);
    Route::get('/delete',[PengadaanController::class, 'delete']);
    Route::get('/dashboard_task',[PengadaanController::class, 'dashboard_task']);
    Route::get('/tampil_material',[PengadaanController::class, 'tampil_material']);
    Route::post('/store_material',[PengadaanController::class, 'store_material']);
    Route::post('/store_material_pm',[PengadaanController::class, 'store_material_pm']);
    Route::post('/store_pengadaan',[PengadaanController::class, 'store_pengadaan']);
    Route::post('/store_ready',[PengadaanController::class, 'store_ready']);
    Route::get('/modal_verifikasi',[PengadaanController::class, 'modal_verifikasi']);
});
Route::group(['prefix' => 'kontrak','middleware'    => 'auth'],function(){
    Route::get('/',[RKontrakController::class, 'index']);
    Route::get('/pekerjaan',[RKontrakController::class, 'index_pekerjaan']);
    Route::get('/form_kontrak',[RKontrakController::class, 'form_kontrak']);
    Route::get('/view',[RKontrakController::class, 'view_data']);
    Route::get('/cetak',[RKontrakController::class, 'cetak']);
    Route::get('/delete_detail',[RKontrakController::class, 'delete_detail']);
    Route::get('/timeline',[RKontrakController::class, 'timeline']);
    Route::get('/getdata',[RKontrakController::class, 'get_data']);
    Route::get('/modal_detail',[RKontrakController::class, 'modal_detail']);
    Route::get('/modal_material',[RKontrakController::class, 'modal_material']);
    Route::get('/getdatadetail',[RKontrakController::class, 'get_data_detail']);
    Route::get('/getdatapekerjaan',[RKontrakController::class, 'get_data_pekerjaan']);
    Route::get('/get_status_data',[RKontrakController::class, 'get_status_data']);
    Route::get('/getdatamaterial',[RKontrakController::class, 'getdatamaterial']);
    Route::get('/create',[RKontrakController::class, 'create']);
    Route::get('/total_item',[RKontrakController::class, 'total_item']);
    Route::get('/tampil_personal_periode',[RKontrakController::class, 'tampil_personal_periode']);
    Route::get('/tampil_operasional_periode',[RKontrakController::class, 'tampil_operasional_periode']);
    Route::get('/tampil_material',[RKontrakController::class, 'tampil_material']);
    Route::get('/tampil_jasa',[RKontrakController::class, 'tampil_jasa']);
    Route::get('/tampil_material_kontrak',[RKontrakController::class, 'tampil_material_kontrak']);
    Route::get('/total_qty',[RKontrakController::class, 'total_qty']);
    Route::post('/store_detail',[RKontrakController::class, 'store_detail']);
    Route::get('/delete',[RKontrakController::class, 'delete']);
    Route::get('/tampil_periode',[RKontrakController::class, 'tampil_periode']);
    Route::get('/tampil_personal',[RKontrakController::class, 'tampil_personal']);
    Route::get('/tampil_operasional',[RKontrakController::class, 'tampil_operasional']);
    Route::get('/tampil_pengeluaran',[RKontrakController::class, 'tampil_pengeluaran']);
    Route::get('/tampil_risiko_view',[RKontrakController::class, 'tampil_risiko_view']);
    Route::get('/delete_personal',[RKontrakController::class, 'delete_personal']);
    Route::get('/delete_operasional',[RKontrakController::class, 'delete_operasional']);
    Route::get('/delete_material',[RKontrakController::class, 'delete_material']);
    Route::get('/reset_material',[RKontrakController::class, 'reset_material']);
    Route::get('/reset_operasional',[RKontrakController::class, 'reset_operasional']);
    Route::get('/reset_jasa',[RKontrakController::class, 'reset_jasa']);
    Route::get('/modal',[RKontrakController::class, 'modal']);
    Route::post('/store_import_material',[RKontrakController::class, 'store_import_material']);
    Route::post('/',[RKontrakController::class, 'store']);
    Route::post('/publish',[RKontrakController::class, 'store_publish']);
    Route::get('/kirim_kadis_komersil',[RKontrakController::class, 'kirim_kadis_komersil']);
    Route::post('/kembali_komersil',[RKontrakController::class, 'kembali_komersil']);
    Route::post('/approve_kadis_komersil',[RKontrakController::class, 'approve_kadis_komersil']);
    Route::post('/approve_kadis_operasional',[RKontrakController::class, 'approve_kadis_operasional']);
    Route::post('/approve_mgr_operasional',[RKontrakController::class, 'approve_mgr_operasional']);
    Route::post('/approve_direktur_operasional',[RKontrakController::class, 'approve_direktur_operasional']);
    Route::get('/kirim_procurement',[RKontrakController::class, 'kirim_procurement']);
    Route::post('/store_material',[RKontrakController::class, 'store_material']);
    Route::post('/store_material_kontrak',[RKontrakController::class, 'store_material_kontrak']);
    Route::post('/store_kontrak',[RKontrakController::class, 'store_kontrak']);
    Route::post('/store_personal',[RKontrakController::class, 'store_personal']);
    Route::post('/store_operasional',[RKontrakController::class, 'store_operasional']);
    Route::post('/store_pengadaan',[RKontrakController::class, 'store_pengadaan']);
    Route::post('/approve_data',[RKontrakController::class, 'approve_data']);
    
    Route::get('/delete_detail',[RKontrakController::class, 'delete_detail']);
    Route::post('/store_jasa',[RKontrakController::class, 'store_jasa']);
    Route::post('/store_periode_personal',[RKontrakController::class, 'store_periode_personal']);
    Route::post('/store_periode_operasional',[RKontrakController::class, 'store_periode_operasional']);
    Route::post('/store_negosiasi',[RKontrakController::class, 'store_negosiasi']);
    
});

Route::group(['middleware' => 'auth'], function() {
    /**
    * Logout Route
    */
    Route::get('/logout-perform', [LogoutController::class, 'perform'])->name('logout.perform');
 });

Route::group(['prefix' => 'user'],function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create', [UserController::class, 'create']);
    Route::get('/get_data', [UserController::class, 'get_data']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/get_data', [App\Http\Controllers\HomeController::class, 'get_data']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
