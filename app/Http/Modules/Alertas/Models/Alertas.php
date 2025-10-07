<?php

namespace App\Http\Modules\Alertas\Models;

use App\Http\Modules\Cums\Models\Cum;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alertas extends Model
{
    use HasFactory;

    protected $fillable = ['principal_id', 'codesumi_id', 'usuario_registra_id', 'estado_id', 'principal'];

    public function principal()
    {
        return $this->belongsTo(Cum::class, 'principal_id');
    }

    public function codesumi()
    {
        return $this->belongsTo(Codesumi::class, 'codesumi_id');
    }

    public function usuarioRegistra()
    {
        return $this->belongsTo(User::class, 'usuario_registra_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
