<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Iuran extends Model {
    use HasFactory;

    protected $table = 'iurans';

    protected $fillable = [
        'id_warga', 'bulan', 'jumlah_iuran', 'status'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}
