<?php

namespace App\Http\Modules\Ambitos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ambito extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre'];

}
