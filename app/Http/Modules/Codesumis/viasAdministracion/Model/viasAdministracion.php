<?php

namespace App\Http\Modules\Codesumis\viasAdministracion\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class viasAdministracion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vias_administracion';

    protected $guarded = [];
}
