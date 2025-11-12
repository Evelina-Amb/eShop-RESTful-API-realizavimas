<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salis extends Model
{
    use HasFactory;

    protected $fillable = ['pavadinimas'];

    public function miestai()
    {
        return $this->hasMany(Miestas::class);
    }
}
