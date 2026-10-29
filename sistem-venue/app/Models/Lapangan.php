<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangan';
    protected $primaryKey = 'id_lapangan';
    public $timestamps = false;

    protected $fillable = [
        'nama_lapangan',
        'jenis_permukaan',
        'ukuran',
        'status_lapangan',
    ];
}