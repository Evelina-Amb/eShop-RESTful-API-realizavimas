<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krepselis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'skelbimas_id', 'kiekis'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skelbimas()
    {
        return $this->belongsTo(Skelbimas::class);
    }
}
