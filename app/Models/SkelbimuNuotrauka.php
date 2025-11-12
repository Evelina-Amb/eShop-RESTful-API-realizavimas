<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkelbimuNuotrauka extends Model
{
    use HasFactory;
    protected $table = 'skelbimu_nuotraukos';

    protected $fillable = ['skelbimas_id', 'failo_url'];

    public function skelbimas()
    {
        return $this->belongsTo(Skelbimas::class);
    }
}
