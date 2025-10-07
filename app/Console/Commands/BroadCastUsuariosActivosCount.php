<?php

namespace App\Console\Commands;

use App\Events\CountUsuariosActivosActualizado;
use App\Http\Modules\Usuarios\Repositories\UsuarioRepository;
use Illuminate\Console\Command;

class BroadCastUsuariosActivosCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:usuarios-activos-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Emite la cantidad de usuarios activos a el frontend';

    /**
     * Execute the console command.
     */
    public function handle(UsuarioRepository $usuarioRepository)
    {
        $count = $usuarioRepository->getUsuariosActivos();
        broadcast(new CountUsuariosActivosActualizado($count));
        $this->info("Envio de usuarios activos: $count");
    }
}
