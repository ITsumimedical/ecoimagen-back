<?php

namespace App\Http\Modules\Agendas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaUser extends Model
{
    use HasFactory;

    protected $table = 'agenda_user';

    protected $guarded = [];
}
