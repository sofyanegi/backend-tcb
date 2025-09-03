<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sparepart',
        'minimal_stok',
        'stok',
    ];

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'id_sparepart');
    }
}
