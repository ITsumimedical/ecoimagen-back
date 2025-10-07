<?php

namespace App\Http\Modules\CupTarifas\Models;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupTarifa extends Model
{
    use HasFactory;

    protected $table = "cup_tarifas";

    protected $fillable= [
        'tarifa_id',
        'cup_id',
        'valor',
        'user_id'
    ];

    public function cup(){
        return $this->belongsTo(Cup::class, 'cup_id');
    }

}
