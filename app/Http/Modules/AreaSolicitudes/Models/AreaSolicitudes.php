<?php

namespace App\Http\Modules\AreaSolicitudes\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaSolicitudes extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','activo'];

    public function user()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
