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
        'user_id',
        'created_at'
    ];
    //Query Scopes
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['serie'] ?? null, function ($query, $serie) {
            $query->where('serie', 'like', '%' . $serie . '%');
        });
        $query->when($filters['fromNumber'] ?? null, function ($query, $fromNumber) {
            $query->where('correlative', '>=', $fromNumber);
        });
        $query->when($filters['toNumber'] ?? null, function ($query, $toNumber) {
            $query->where('correlative', '<=', $toNumber);
        });
        $query->when($filters['fromDate'] ?? null, function ($query, $fromDate) {
            $query->where('created_at', '>=', $fromDate);
        });
        $query->when($filters['toDate'] ?? null, function ($query, $toDate) {
            $query->where('created_at', '<=', $toDate);
        });
    }

    //Relaciones
    //uno a muchos - inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
