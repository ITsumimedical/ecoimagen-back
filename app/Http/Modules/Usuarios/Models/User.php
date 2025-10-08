<?php

namespace App\Http\Modules\Usuarios\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\AreaSolicitudes\Models\AreaSolicitudes;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Caracterizacion\Models\Encuesta;
use App\Http\Modules\Chat\Models\mensaje;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Epidemiologia\Models\ObservacionRegistroSivigila;
use App\Http\Modules\TipoUsuarios\Models\TipoUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\LoguinSession\Models\login_session;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Models\CategoriaMesaAyuda;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\SeguimientoEnvioOrden;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\ResponsablePqrsf\Models\ResponsablePqrsf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password',
        'email',
        'tipo_usuario_id',
        'reps_id',
        'firma',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class);
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }

    public function mensaje()
    {
        return $this->hasOne(mensaje::class);
    }

    public function entidad()
    {
        return $this->belongsToMany(Entidad::class, 'entidad_users');
    }

    public function reps()
    {
        return $this->belongsTo(Rep::class);
    }
    /**
     * The especialidades that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class)->withTimestamps();
    }

    public function afiliado()
    {
        return $this->hasOne(Afiliado::class);
    }

    public function operador()
    {
        return $this->hasOne(Operadore::class);
    }

    public function categoriaMesaAyuda()
    {
        return $this->belongsToMany(CategoriaMesaAyuda::class)->withTimestamps();
    }

    public function scopeWhereEmail($query, $email)
    {
        if ($email) {
            return $query->where('email', 'ILIKE', '%' . $email . '%');
        }
    }

    public function scopeWhereOperadorDocumento($query, $cedula)
    {
        if ($cedula) {
            return $query->with([
                'operador' => function ($q) use ($cedula) {
                    $q->where('documento', $cedula);
                }
            ]);
        }
    }

    public function areaSolicitudea()
    {
        return $this->belongsToMany(AreaSolicitudes::class)->withTimestamps();
    }

    public function bodega()
    {
        return $this->belongsToMany(Bodega::class)->withTimestamps();
    }

    public static function usuariosOn()
    {
        return login_session::select('user_id')
            ->where('activo', true)
            ->where('logged_in_at', '>=', Carbon::now())
            ->count();
    }

    public function responsablePqrsfs()
    {
        return $this->hasMany(ResponsablePqrsf::class);
    }

    public function seguimientoEnvioOrden()
    {
        return $this->hasOne(SeguimientoEnvioOrden::class, 'user_id');
    }

    public function observacionRegistroSivigila()
    {
        return $this->hasOne(ObservacionRegistroSivigila::class, 'user_id');
    }

    public function encuestas(): BelongsToMany
    {
        return $this->belongsToMany(Encuesta::class, 'encuesta_user', 'user_id', 'encuesta_id')
            ->withTimestamps();
    }

    public function getNivelesOrdenamiento()
    {
        $niveles = [0];

        $permisosUsuario = $this->permissions->pluck('name')->toArray();
        $permisosPorRoles = $this->roles
            ->flatMap(fn($role) => $role->permissions->pluck('name'))
            ->toArray();

        $todosLosPermisos = array_unique(array_merge($permisosUsuario, $permisosPorRoles));

        foreach ($todosLosPermisos as $permiso) {
            if (str_starts_with($permiso, 'nivel.ordenamiento.')) {
                $arrPosiciones = explode('.', $permiso);
                if (isset($arrPosiciones[2]) && is_numeric($arrPosiciones[2])) {
                    $niveles[] = (int) $arrPosiciones[2];
                }
            }
        }

        return array_unique($niveles);
    }
}
