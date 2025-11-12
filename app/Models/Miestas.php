<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miestas extends Model
{
    use HasFactory;

    protected $fillable = ['pavadinimas', 'salis_id'];

    public function salis()
    {
        return $this->belongsTo(Salis::class);
    }

    public function adresai()
    {
        return $this->hasMany(Adresas::class);
    }
}
