<?php

namespace App\Http\Modules\Rips\Models;

use App\Http\Modules\Prestadores\Models\Prestador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjuntorip extends Model
{
    use HasFactory;

    protected $table = 'adjuntorips';

    protected $fillable = [
        'url_json', 'url_xml', 'url_cuv', 'created_by', 'codigo_prestador', 'numero_factura','url_adjunto', 'paquete_rip_id'
    ];

    public function prestador()
     {
        return $this->belongsTo(Prestador::class, 'codigo_prestador', 'nit');
     }
}
