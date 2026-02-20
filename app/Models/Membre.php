<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'ville',
        'competences',
        'statut',
        'date_naissance',
        'adresse',
    ];

    protected $casts = [
        'statut' => 'boolean',
        'date_naissance' => 'date',
    ];
}
