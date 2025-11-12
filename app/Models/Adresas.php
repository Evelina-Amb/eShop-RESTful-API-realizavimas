<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresas extends Model
{
    use HasFactory;

    protected $fillable = ['gatve', 'namo_nr', 'buto_nr', 'miestas_id'];

    public function miestas()
    {
        return $this->belongsTo(Miestas::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
