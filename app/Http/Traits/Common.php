<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Log;

trait Common {

    public function errorLog($message) {
        Log::error([
            'tanggal' => now(),
            'error' => $message
        ]);
    }

    public function typeList(){
        return [
            "Gypsum Board" => 'G',
            "Baja Ringan & Hollow" => "B",
            "Sealant & Baut" => "S",
            "Kebutuhan Bangunan" => "K",
            "Profil Gypsum" => "P",
            "PVC" => "V",
            "Atap" => "A",
            "Lisplang" => "L"
        ];
    }

    public function warrantiesType(){
        return [
            "process" => "Segera Dihubungi",
            "finish" => "Selesai",
        ];
    }

    public function messageTemplate($message, $table){
        return 'Data '.$table.' '.$message;
    }
}
