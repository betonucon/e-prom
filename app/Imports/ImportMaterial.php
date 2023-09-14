<?php

namespace App\Imports;
use App\Models\ProjectMaterial;
use App\Models\HeaderProject;
use App\Models\ProjectPekerjaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
class ImportMaterial implements ToModel, WithStartRow,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $id;
    protected $tipe_project_id;
    public function __construct(int $id, int $tipe_project_id)
    {
        $this->id = $id; 
        $this->tipe_project_id = $tipe_project_id; 
    }
    
    public function model(array $row)
    {
        
            $mst=HeaderProject::where('id',$this->id)->first();
            $header=HeaderProject::where('id',$this->id)->update(['tab'=>$tab]);
            if($mst->tab>2){
                $tab=$mst->tab;
            }else{
                $tab=4;
            }
            if($mst->status_id>6){
                $state=2;
            }else{
                $state=1;
            }
            if($this->tipe_project_id==1){

            }else{

            }
            if($state==1){
                if(in_array($row[3],array('HP','CM'))){
                    if($row[3]=='HP'){
                        $mstsv=HeaderProject::where('id',$this->id)->update([
                            'nilai_project'=>ubah_uang($row[6]),
                            'deskripsi_project'=>$row[1],
                        ]);
                    }
                    if($row[3]=='CM'){
                        $ex=str_replace('%','',$row[4]);
                        $mstsv=HeaderProject::where('id',$this->id)->update(['persen_cost'=>$ex,'hari_cost'=>$row[5]]);
                    }
                }
            }
            if(in_array($row[3],array('B1','B2','B3','B4','B5','B6','B7'))){
                $save=ProjectMaterial::UpdateOrcreate([
                    'project_header_id'=>$this->id,
                    'nama_material'=>$row[1],
                    'status'=>1,
                    'kategori_ide'=>1,
                    'state'=>$state,
                ],[
                    'biaya'=>ubah_uang($row[6]),
                    'kode_material'=>0,
                    
                    'kode_biaya'=>$row[3],
                    'satuan_material'=>$row[5],
                    'biaya_actual'=>ubah_uang($row[6]),
                    'qty'=>ubah_uang($row[4]),
                    'status_pengadaan'=>1,
                    'total'=>(ubah_uang($row[6])*ubah_uang($row[4])),
                    'total_decimal_3'=>(ubah_uang($row[6])*ubah_uang($row[4])),
                    'total_actual'=>(ubah_uang($row[6])*ubah_uang($row[4])),
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
            }
            
            return $save;
        
        
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 4;
    }
}
