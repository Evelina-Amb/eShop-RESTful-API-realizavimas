<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atsiliepimas extends Model
{
    use HasFactory;
    protected $table = 'atsiliepimai';

    protected $fillable = ['ivertinimas', 'komentaras', 'skelbimas_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skelbimas()
    {
        return $this->belongsTo(Skelbimas::class);
    }
}
