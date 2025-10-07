<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use App\Events\EstadoRips;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Modules\Rips\Models\RipErrore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;

class ValidacionEstructuraRips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id;
    private $CT = [];
    private $US = [];
    private $AF = [];
    private $AC = [];
    private $AP = [];
    private $AM = [];
    private $AT = [];
    private $AU = [];
    private $AH = [];
    private $AN = [];
    private $item = [];
    private $errorMessages = [];


    private function setCT($CT)
    {
        $this->CT = $CT;
    }

    private function setUS($US)
    {
        $this->US = $US;
    }

    private function setAF($AF)
    {
        $this->AF = $AF;
    }

    private function setAC($AC)
    {
        $this->AC = $AC;
    }

    private function setAP($AP)
    {
        $this->AP = $AP;
    }

    private function setAM($AM)
    {
        $this->AM = $AM;
    }

    private function setAT($AT)
    {
        $this->AT = $AT;
    }

    private function setAU($AU)
    {
        $this->AU = $AU;
    }

    private function setAH($AH)
    {
        $this->AH = $AH;
    }

    private function setAN($AN)
    {
        $this->AN = $AN;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $paqueteRip = PaqueteRip::find($this->id);
        $path = storage_path("app/public/temporalesrips/".$paqueteRip->id);
        $files = File::allFiles($path);
        $this->fillFileNames($files);
        $this->checkCTFileStructire();
//        $this->checkUSFileStructure();
        $this->checkACFileStructure();
        $this->checkAPFileStructure();
        $this->checkAMFileStructure();
        $this->checkATFileStructure();
        $this->checkAUFileStructure();
        $this->checkAHFileStructure();
        $this->checkANFileStructure();
        $this->checkAFFileStructure();

        if(count($this->errorMessages) > 0){
            $errores = [];
            foreach ($this->errorMessages as $archivo => $mensajes){
                foreach ($mensajes as $mensaje => $lineas){
                    $errores[] = ['archivo' => $archivo, 'mensaje' => $mensaje, 'lineas' => implode(",",$lineas), 'paquete_rip_id' => $paqueteRip->id];
                }
            }
            RipErrore::insert($errores);
            $paqueteRip->estado_id = 25;
            $paqueteRip->save();
            broadcast(new EstadoRips());
        }else{
            $paqueteRip->estado_id = 26;
            $paqueteRip->save();
            broadcast(new EstadoRips());
            ValidacionContenidoRips::dispatch($paqueteRip->id)->onQueue('validacioncontenidorips');
        }
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $paqueteRip = PaqueteRip::find($this->id);
        $paqueteRip->estado_id = 28;
        $paqueteRip->save();
        broadcast(new EstadoRips());
    }


    private function fillFileNames($files)
    {
        $currentFile = [];
        foreach ($files as $file) {
            list($fileName, $ext) = explode('.', $file->getFilename());
            $open_file = fopen($file, 'r');
            $content = fread($open_file, filesize($file));
            $rows = preg_split('/\r\n/', $content);
            $i = 0;
            foreach ($rows as $row) {
                $newCols = [];
                if ($row) {
                    $cols = explode(',', $row);
                    foreach ($cols as $keyCol => $col) {
                        $newCols[$keyCol] = utf8_encode(trim($col));
                    }
                    $this->item[$fileName][$i] = $newCols;
                    $i++;
                }
                $currentFile['content'] = $this->item[$fileName];
                $currentFile['fileName'] = $fileName;
                $currentFile['size'] = $file->getSize();
                $currentFile['success'] = [];
                if (preg_match('/CT/i', $fileName)) $this->setCT($currentFile);
                if (preg_match('/US/i', $fileName)) $this->setUS($currentFile);
                if (preg_match('/AF/i', $fileName)) $this->setAF($currentFile);
                if (preg_match('/AC/i', $fileName)) $this->setAC($currentFile);
                if (preg_match('/AP/i', $fileName)) $this->setAP($currentFile);
                if (preg_match('/AM/i', $fileName)) $this->setAM($currentFile);
                if (preg_match('/AT/i', $fileName)) $this->setAT($currentFile);
                if (preg_match('/AU/i', $fileName)) $this->setAU($currentFile);
                if (preg_match('/AH/i', $fileName)) $this->setAH($currentFile);
                if (preg_match('/AN/i', $fileName)) $this->setAN($currentFile);
            }
        }
    }

    private function checkCTFileStructire()
    {
        $line = 1;
        if (isset($this->CT['content'])) {
            foreach ($this->CT['content'] as $row) {
                if (count($row) != 4) {
                    $this->pushInconsistencyMessage('El archivo CT no cumple con las condiciones especificadas de tipo de archivo plano.', $this->CT['fileName'], $line, 'Error A8');
                }
                $line++;
            }
        }
    }

    private function checkUSFileStructure()
    {
        $line = 1;
        if (isset($this->US['content'])) {
            foreach ($this->US['content'] as $row) {
                if (count($row) != 14) {
                    $this->pushInconsistencyMessage('no tiene la estructura valida', $this->US['fileName'], $line, 'Error A');
                }
                $line++;
            }
        }
    }

    private function checkACFileStructure()
    {
        $line = 1;
        if (isset($this->AC['content'])) {
            foreach ($this->AC['content'] as $row) {
                if (count($row) != 17) {
                    $this->pushInconsistencyMessage('El archivo AC no cumple con las condiciones especificadas de tipo de archivo plano.', $this->AC['fileName'], $line, 'Error A1');
                }
                $line++;
            }
        }
    }

    private function checkAPFileStructure()
    {
        $line = 1;
        if (isset($this->AP['content'])) {
            foreach ($this->AP['content'] as $row) {
                if (count($row) != 15) {
                    $this->pushInconsistencyMessage('El archivo AP no cumple con las condiciones especificadas de tipo de archivo plano.', $this->AP['fileName'], $line, 'Error A2');
                }
                $line++;
            }
        }
    }

    private function checkAMFileStructure()
    {
        $line = 1;
        if (isset($this->AM['content'])) {
            foreach ($this->AM['content'] as $row) {
                if (count($row) != 14) {
                    $this->pushInconsistencyMessage('El archivo AM no cumple con las condiciones especificadas de tipo de archivo plano.', $this->AM['fileName'], $line, 'Error A3');
                }
                $line++;
            }
        }
    }

    private function checkATFileStructure()
    {
        $line = 1;
        if (isset($this->AT['content'])) {
            foreach ($this->AT['content'] as $row) {
                if (count($row) != 11) {
                    $this->pushInconsistencyMessage('El archivo AT no cumple con las condiciones especificadas de tipo de archivo plano.', $this->AT['fileName'], $line, 'Error A4');
                }
                $line++;
            }
        }
    }

    private function checkAUFileStructure()
    {
        $line = 1;
        if (isset($this->AU['content'])) {
            foreach ($this->AU['content'] as $row) {
                if (count($row) != 17) {
                    $this->pushInconsistencyMessage('El archivo AU no cumple con las condiciones especificadas de tipo de archivo plano. ', $this->AU['fileName'], $line, 'Error A5');
                }
                $line++;
            }
        }
    }

    private function checkAHFileStructure()
    {
        $line = 1;
        if (isset($this->AH['content'])) {
            foreach ($this->AH['content'] as $row) {
                if (count($row) != 19) {
                    $this->pushInconsistencyMessage('El archivo AH no cumple con las condiciones especificadas de tipo de archivo plano.', $this->AH['fileName'], $line, 'Error A6');
                }
                $line++;
            }
        }
    }

    private function checkANFileStructure()
    {
        $line = 1;
        if (isset($this->AN['content'])) {
            foreach ($this->AN['content'] as $row) {
                if (count($row) != 14) {
                    $this->pushInconsistencyMessage('El archivo AN no cumple con las condiciones especificadas de tipo de archivo plano.', $this->AN['fileName'], $line, 'Error A7');
                }
                $line++;
            }
        }
    }

    private function checkAFFileStructure()
    {
        $line = 1;
        if (isset($this->AF['content'])) {
            foreach ($this->AF['content'] as $row) {
                if (count($row) != 17) {
                    $this->pushInconsistencyMessage('no tiene la estructura valida', $this->AF['fileName'], $line, 'Error C');
                }
                $line++;
            }
        }
    }

    private function pushInconsistencyMessage($mensaje,$archivo,$line,$codigo = ''){
        if(!isset($this->errorMessages[$archivo][$mensaje])){
            $this->errorMessages[$archivo][$mensaje][] = $line;
        }else{
            if(count($this->errorMessages[$archivo][$mensaje]) < 500){
                $this->errorMessages[$archivo][$mensaje][] = $line;
            }
        }
    }
}
