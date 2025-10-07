<?php

namespace App\Http\Modules\EntidadesCodesumiParametrizacion\Model;

use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmacia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CodesumiEntidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'codesumi_id',
        'entidad_id',
        'requiere_autorizacion',
        'nivel_ordenamiento',
        'abc',
        'estado_normativo',
        'requiere_mipres',
        'created_by',
        'updated_by'
    ];

    protected static function boot()
    {
        parent::boot();

        // Al crear un registro, se asigna el usuario autenticado a created_by
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        // Al actualizar un registro, se asigna el usuario autenticado a updated_by
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function codesumi()
    {
        return $this->belongsTo(Codesumi::class, 'codesumi_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }

    public function programaCodesumi()
    {
        return $this->belongsToMany(ProgramasFarmacia::class, 'codesumi_entidad_programas', 'codesumi_entidad_id', 'programa_farmacia_id')->withTimestamps();
    }
}
