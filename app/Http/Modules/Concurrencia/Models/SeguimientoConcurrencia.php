<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoConcurrencia extends Model
{
    use HasFactory;

    protected $fillable =[
        'notas',
        'nota_dss',
        'nota_aac',
        'nota_lc',
        'concurrencia_id',
        'user_id',
        'user_notadss_id',
        'user_notaaac_id',
        'user_notalc_id',
        'nota_ingreso'
    ];

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuarioDss()
    {
        return $this->belongsTo(User::class, 'user_notadss_id');
    }

    public function usuarioAac()
    {
        return $this->belongsTo(User::class, 'user_notaaac_id');
    }

    public function usuarioLc()
    {
        return $this->belongsTo(User::class, 'user_notalc_id');
    }

    public function concurrencia()
    {
        return $this->belongsTo(Concurrencia::class, 'concurrencia_id');
    }
}
