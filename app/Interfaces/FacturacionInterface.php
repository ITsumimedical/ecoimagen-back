<?php

namespace App\Interfaces;

interface FacturacionInterface {
    public function emitirFactura(array $data);
}