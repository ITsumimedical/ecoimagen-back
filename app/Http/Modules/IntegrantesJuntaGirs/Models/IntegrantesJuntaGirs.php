<?php

namespace App\Http\Modules\IntegrantesJuntaGirs\Models;

use App\Http\Modules\Teleapoyo\Models\Teleapoyo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntegrantesJuntaGirs extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teleapoyo()
    {
        return $this->belongsTo(Teleapoyo::class);
    }
}
