<?php

namespace App\Http\Modules\Juzgados\Models;

use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Juzgado extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
    [
        'nombre',
        'estado'
    ];

    protected $guarded = [];

    public function tutela(){
        return $this->hasMany(Tutela::class, 'juzgado_id');
    }

}
