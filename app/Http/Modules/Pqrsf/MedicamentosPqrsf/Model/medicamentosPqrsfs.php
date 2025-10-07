<?php

namespace App\Http\Modules\Pqrsf\MedicamentosPqrsf\Model;

use App\Http\Modules\Medicamentos\Models\Medicamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicamentosPqrsfs extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
