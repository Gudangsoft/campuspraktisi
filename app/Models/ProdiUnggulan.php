<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdiUnggulan extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'link',
    ];
}
