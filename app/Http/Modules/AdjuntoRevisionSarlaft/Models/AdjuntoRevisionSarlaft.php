<?php

namespace App\Http\Modules\AdjuntoRevisionSarlaft\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoRevisionSarlaft extends Model
{
    use HasFactory;

    protected $fillable = ['ruta','nombre','revision_sarlaft_id'];
}
