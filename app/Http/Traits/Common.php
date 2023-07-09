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
            "Gypsum Board" => 'GB',
            "Baja Ringan & Hollow" => "B",
            "Sealant & Baut" => "SB",
            "Kebutuhan Bangunan" => "KB",
            "Profil Gypsum" => "PG",
            "PVC" => "PVC",
            "Atap" => "AT",
            "Lisplang" => "L"
        ];
    }

    public function warrantiesType(){
        return [
            "process" => "Segera Dihubungi",
            "finish" => "Selesai",
        ];
    }
}
