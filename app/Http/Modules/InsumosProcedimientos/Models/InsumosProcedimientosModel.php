<?php

namespace App\Http\Modules\InsumosProcedimientos\Models;

use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumosProcedimientosModel extends Model
{
    use HasFactory;

    protected $table = 'insumos_procedimientos';

    protected $fillable = ['consulta_id', 'codesumi_id', 'cantidad'];

    public function codesumi()
    {
        return $this->belongsTo(Codesumi::class, 'codesumi_id');
    }
}
