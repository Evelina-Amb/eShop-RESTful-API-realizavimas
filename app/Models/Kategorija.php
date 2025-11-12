<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    use HasFactory;
    protected $table = 'kategorija';

    protected $fillable = ['pavadinimas', 'aprasymas', 'tipo_zenklas'];

    public function skelbimai()
    {
        return $this->hasMany(Skelbimas::class);
    }
}
