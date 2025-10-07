<?php

namespace App\Traits;

trait PdfTrait
{
    /*

     GENERAR EL PDF DESDE EL FRONTEND

    */
    public function generarPDF($method)
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->body();
        return $this->Output($method);
    }

    /*

        SE PUEDE UETILIZAR PARA DESCARGAR EL PDF TEMPORALMENTE Y DESPUES ELIMINARLO,
        ADEMAS SE LE PUEDE MANDAR UN NOMBRE POR SI SE REQUIERE QUE TENGA UN NOMBRE EN
        LA  NOMENCLATURA DEL PDF

    */
    public function descargarPdfTemp($method = 'F', $nombreArchivo = null)
    {
        $this->AliasNbPages();
        $this->AddPage();
        if ($nombreArchivo) {
            $outputPath = storage_path('\\app\\temp') . $nombreArchivo . uniqid() . '.pdf';
            $this->Output($method, $outputPath);
        } else {
            $outputPath = storage_path('\\app\\temp') . uniqid() . '.pdf';
            $this->Output($method, $outputPath);
        }
        return $outputPath;
    }

    /*
        FUNCION PARA CONVERTIR EL PDF EN STR Y PARA PASARLO A BASE64
    */

    public function convertirPdfenBase64()
    {
        return base64_encode($this->generarPDF('S'));
    }

}
