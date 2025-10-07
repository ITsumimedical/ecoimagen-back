<?php

namespace App\Http\Modules\Certificados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = ['numero_documento','tipo_documento', 'primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','estado','tipo_afiliado','ips'];
}
