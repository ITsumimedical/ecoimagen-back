<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un servicio';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
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
        fwrite($archivo, 'class ' . $nombreArchivo . ' {');
        fwrite($archivo, "\n");
        fwrite($archivo, "\n");
        fwrite($archivo, "}");
        fclose($archivo);

        $this->info('El servicio se creo correctamente.');
    }
}
