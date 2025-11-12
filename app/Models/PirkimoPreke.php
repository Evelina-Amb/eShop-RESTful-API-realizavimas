<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirkimoPreke extends Model
{
    use HasFactory;

    protected $fillable = ['pirkimas_id', 'skelbimas_id', 'kaina', 'kiekis'];

    public function pirkimas()
    {
        return $this->belongsTo(Pirkimas::class);
    }

    public function skelbimas()
    {
        return $this->belongsTo(Skelbimas::class);
    }
}
