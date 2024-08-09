<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'serie',
        'correlative',
        'base',
        'igv',
        'total',
        'user_id'
    ];

    ///Relaciones
    //uno a muchos - inversa
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
