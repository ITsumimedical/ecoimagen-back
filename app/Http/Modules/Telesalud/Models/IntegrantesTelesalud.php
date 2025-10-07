<?php

namespace App\Http\Modules\Telesalud\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrantesTelesalud extends Model
{
    use HasFactory;

    protected $table = 'integrantes_telesaluds';

    protected $fillable = [
        'user_id',
        'telesalud_id',
    ];

    public function telesalud()
    {
        return $this->belongsToMany(Telesalud::class, 'integrantes_telesaluds', 'user_id', 'telesalud_id');
    }
}
