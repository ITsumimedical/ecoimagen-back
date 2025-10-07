<?php

namespace App\Http\Modules\Agendas\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultorios\Models\Consultorio;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Agenda extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();
        // este metodo lo que hace es agregar el usuario que creo la agenda, cada que se creee un nuevo registro
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function medicos(){
        return $this->belongsToMany(User::class);
    }

    public function consultorio(){
        return $this->belongsTo(Consultorio::class);
    }

    /**
     * The afiliados that belong to the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function afiliados()
    {
        return $this->belongsToMany(Afiliado::class);
    }

    /**
     * The users that belong to the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the cita that owns the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    /**
     * Get the consultas that owns the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultas()
    {
        return $this->hasMany(Consulta::class);

    }

    /**
     * estado relación a estado, estado_id
     *
     * @return void
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
