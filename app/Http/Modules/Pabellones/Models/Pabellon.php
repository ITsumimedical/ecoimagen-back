<?php

namespace App\Http\Modules\Pabellones\Models;

use App\Http\Modules\Camas\Models\Cama;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pabellon extends Model
{
    use HasFactory;

    protected $table = 'pabellones';
    protected $fillable = ['nombre','estado','created_by','updated_by'];

    public function camas()
    {
        return $this->hasMany (Cama::class,'pabellon_id');
    }
}
