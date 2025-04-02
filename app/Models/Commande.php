<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'livre_id',
        'quantite',
        'email',
        'total',
        'statut',


    ];
    public function livre()
    {
        return $this->belongsTo(LivreModel::class, 'livre_id');
    }


}
