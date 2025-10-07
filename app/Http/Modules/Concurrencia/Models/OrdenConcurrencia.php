<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenConcurrencia extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['cup_id', 'user_id', 'costo', 'cantidad', 'ingreso_concurrencia_id'];

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
