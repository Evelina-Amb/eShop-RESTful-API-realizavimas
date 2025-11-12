<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{
    use HasFactory;

    protected $fillable = [
        'vardas', 'pavarde', 'el_pastas', 'slaptazodis',
        'telefonas', 'adresas_id', 'role'
    ];

    public function adresas()
    {
        return $this->belongsTo(Adresas::class);
    }

    public function skelbimai()
    {
        return $this->hasMany(Skelbimas::class);
    }

    public function atsiliepimai()
    {
        return $this->hasMany(Atsiliepimas::class);
    }

    public function krepselis()
    {
        return $this->hasMany(Krepselis::class);
    }

    public function isiminti()
    {
        return $this->hasMany(Isiminti::class);
    }

    public function pirkimai()
    {
        return $this->hasMany(Pirkimas::class);
    }
}
