<?php

namespace App\Http\Modules\Oncologia\Organos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','estado'];
}
