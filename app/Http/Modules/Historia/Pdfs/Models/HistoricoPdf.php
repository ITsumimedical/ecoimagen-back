<?php

namespace App\Http\Modules\Historia\Pdfs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPdf extends Model
{
    // Indicamos los campos asignables
    protected $fillable = ['nombre', 'url', 'fecha_creacion'];

    // No usaremos timestamps ni una tabla real
    public $timestamps = false;
    protected $table = null;

    use HasFactory;
}
