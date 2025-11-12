<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skelbimas extends Model
{
    use HasFactory;

    protected $table = 'skelbimai';

    protected $fillable = [
        'pavadinimas', 'aprasymas', 'kaina', 'tipas',
        'user_id', 'kategorija_id', 'statusas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function kategorija()
   {
    return $this->belongsTo(Kategorija::class, 'kategorija_id');
   }

    public function nuotraukos()
    {
        return $this->hasMany(SkelbimuNuotrauka::class);
    }

    public function atsiliepimai()
    {
        return $this->hasMany(Atsiliepimas::class);
    }
}
