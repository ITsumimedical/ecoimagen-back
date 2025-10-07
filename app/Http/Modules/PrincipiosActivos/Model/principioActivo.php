<?php

namespace App\Http\Modules\PrincipiosActivos\Model;

use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class principioActivo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function codesumi() {
        return $this->belongsToMany(Codesumi::class, 'codesumi_principio_activo')->withTimestamps();
    }
}
