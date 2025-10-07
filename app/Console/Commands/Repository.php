<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Repository extends Command
{
    /**
     * The name and signature of the console command. CR7
     *
     * @var string
     */
    protected $signature = 'make:repository {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un repositorio';

    /**
     * Create a new command instance. CR7
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command. CR7
     *
     * @return int
     */
    public function handle()
    {
        $paramUrl = $this->argument('url');
        $url_explode = explode("/", $paramUrl);
        $nombreArchivo = array_pop($url_explode);
        $namespace = implode("\\", $url_explode);

        /** Creamos el archivo */
        $archivo = fopen($paramUrl . '.php', 'w');
        fwrite($archivo, '<?php');
        fwrite($archivo, "\n");
        fwrite($archivo, "\n");
        fwrite($archivo, 'namespace '. $namespace . ';');
        fwrite($archivo, "\n");
        fwrite($archivo, "\n");
        fwrite($archivo, 'use App\Http\Modules\Bases\RepositoryBase;');
        fwrite($archivo, "\n");
        fwrite($archivo, "\n");
        fwrite($archivo, 'class ' . $nombreArchivo . ' extends RepositoryBase {');
        fwrite($archivo, "\n");
        fwrite($archivo, "\n");
        fwrite($archivo, "}");
        fclose($archivo);

        $this->info('El repositorio se creo correctamente.');
    }
}
