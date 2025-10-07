<?php

namespace App\Http\Modules\OdontologiaProcedimientos\Model;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class odontologiaProcedimientos extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id', 'cup_id', 'cantidad'];

    public function cup()
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }
}
