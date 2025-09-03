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
}
