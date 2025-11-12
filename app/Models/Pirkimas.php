<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pirkimas extends Model
{
    use HasFactory;
protected $table = 'pirkimai';

    protected $fillable = ['user_id', 'pirkimo_data', 'bendra_suma', 'statusas'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prekes()
    {
        return $this->hasMany(PirkimoPreke::class);
    }
}
