<?php

namespace App\Exceptions;

use Exception;

class NoDetallesFueraDeCapitaException extends Exception
{
    protected array $datos;

    public function __construct(array $datos, $message = "No se pueden enviar detalles dentro de capita o PGP.", $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->datos = $datos;
    }

    public function getDatos(): array
    {
        return $this->datos;
    }
}
