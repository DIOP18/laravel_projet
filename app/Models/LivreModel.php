<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivreModel extends Model
{
    use HasFactory;
    protected $table = 'livre_models'; // Définir le bon nom de table

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'livre_id');
    }
}
