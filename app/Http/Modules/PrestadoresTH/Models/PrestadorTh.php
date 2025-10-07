<?php

namespace App\Http\Modules\PrestadoresTH\Models;

use App\Http\Modules\TipoPrestadoresTH\Models\TipoPrestadorTh;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrestadorTh extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'tipo_prestador_id' => 'integer'
    ];

    public function tipoPrestador()
    {
        return $this->belongsTo(TipoPrestadorTh::class);
    }

}
