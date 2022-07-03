<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    // protected $fillable = [
    //     'barang_id', 'quantity', 'jmlh_bayar',
    // ];

    use SoftDeletes;

    protected $table = "pembelians";
    protected $dates = ['deleted_at'];
}
