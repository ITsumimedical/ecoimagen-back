<?php

namespace App\Http\Modules\NotaAclaratoria\Models;

use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaAclaratoria extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion', 'user_id'];

    public function historiaClinica()
    {
        return $this->belongsToMany(HistoriaClinica::class)->withTimestamps();
    }
    public function operador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }  
}
