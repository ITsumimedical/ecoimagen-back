<?php

namespace App\Http\Modules\ResponsableTutela\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\ProcesoTutela\Models\ProcesoTutela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsableTutela extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['proceso_id','user_id','correo','estado'];

    protected $table = 'responsable_tutelas';

    public function proceso(){
        return $this->belongsTo(ProcesoTutela::class, 'proceso_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'');
    }

    public function scopeWhereUser($query, $user_id){
        if($user_id){
            return $query->where('user_id',$user_id);
        }
    }

    public function scopeWhereProceso($query, $proceso_id){
        if($proceso_id){
            return $query->where('proceso_id',$proceso_id);
        }
    }

    public function scopeWhereCorreo($query, $correo){
        if($correo){
            return $query->where('correo','ILIKE','%'.$correo.'%');
        }
    }
}
