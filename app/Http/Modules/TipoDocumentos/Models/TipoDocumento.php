<?php

namespace App\Http\Modules\TipoDocumentos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDocumento extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['nombre','sigla'];

}
