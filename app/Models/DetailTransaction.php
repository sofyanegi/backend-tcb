<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $fillable = [
        'id_transaksi',
        'id_sparepart',
        'jumlah'
    ];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaksi');
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'id_sparepart');
    }
}
