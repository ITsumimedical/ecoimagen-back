<?php

namespace App\Http\Modules\Cac\Strategies;

use App\Http\Modules\Cac\Contracts\ArchivoCacStrategyInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArchivoCacErcStrategy implements ArchivoCacStrategyInterface
{
    public function generar(array $historias): array
    {
        $lineas = [];

        // Cabeceras del archivo (Var1 a Var9)
        $lineas[] = implode("\t", [
            'Var1 Primer nombre del usuario',
            'Var2 Segundo nombre del usuario',
            'Var3 Primer apellido del usuario',
            'Var4 Segundo apellido del usuario',
            'Var5 Tipo de Identificación',
            'Var6 NNúmero de Identificación',
            'Var7 Fecha de nacimiento',
            'Var8 Sexo',
            'Var9 Régimen de afiliación AL SGSS',
            'Var10 Código de la EPS o de la entidad territorial',
            'Var11 Código pertenencia étnica',
            'Var12 Grupo poblacional',
            'Var13 Municipio de residencia',
            'Var14 número telefónico del paciente',
            'Var15 Fecha de afiliación a la EPS que registra',
            'Var16 Código de la IPS donde se hace seguimiento al usuario',
            'Var17 Fecha de ingreso al programa de nefroporteccion dentro de la EPS que reporta',
            'Var18 Diagnóstico confirmado de Hipertensión Arterial',
            'Var19 Fecha de diagnostico de la Hipertension Arterial',
            'Var19_1 Costo HTA durante el período de reporte',
            'Var20 Diagnóstico confirmado de Diabetes Mellitus- DM',
            'Var21 Fecha de diagnostico de la Diabetes Mellitus',
            'Var21_1 Costo DM durante el período de reporte',
            'Var22 Etiología de la ERC',
            'Var23 Peso',
            'Var24 Talla',
            'Var25 Tensión arterial sistólica',
            'Var26 Tensión arterial diastólica',
            'Var27 Creatinina',
            'Var27_1 Fecha de última Creatinina',
            'Var28 Hemoglobina Glicosilada',
            'Var28_1 Fecha de última Hemoglobina Glicosilada',
            'Var29 Albuminuria',
            'Var29_1 Fecha de la última Albuminuria',
            'Var30 Creatinuria',
            'Var30_1 Fecha de la última Creatinuria',
            'Var31 Colesterol total',
            'Var31_1 Fecha de la último Colesterol total',
            'Var32 HDL',
            'Var32_1 Fecha de la último HDL',
            'Var33 LDL',
            'Var33_1 Fecha del último LDL',
            'Var34 PTH',
            'Var34_1 Fecha de la última PTH',
            'Var35 Tasa de filtración glomerular',
            'Var36 Recibe Inhibidor de la Enzima convertidora de angiotensina IECA',
            'Var37 Recibe Antagonista de los receptores de angiotensina II ARA II',
            'Var38 Tiene diagnóstico de enfermedad renal crónica en cualquier de sus estadios',
            'Var39 Estadio de ERC',
            'Var40 Fecha de diagnóstico de ERC estadio 5',
            'Var41 Se encuentra en un programa de atención de ERC',
            'Var42 TFGenTRR',
            'Var43 Modo de Inicio de la TRR',
            'Var44 Fecha en que se inicio la TRR',
            'Var45 Fecha de Ingreso a la Unidad Renal Actual',
            'Var46 Hemodiálisis',
            'Var47 Dosis de diálisis Kt_V single pool',
            'Var48 Costo total de la hemodiálisis',
            'Var49 Diálisis peritoneal',
            'Var50 Dosis de diálisis Kt_V dpd',
            'Var51 Numero de horas de dialisis',
            'Var52 Peritonitis',
            'Var53 Costo DP',
            'Var54 Vacuna Hepatitis B',
            'Var55 Fecha de diagnóstico de la infección por Hepatitis B',
            'Var56 Fecha de diagnóstico de la infección por Hepatitis C',
            'Var57 Terapia no Dialítica para ERC estadio 5',
            'Var58 Costo de la terapia ERC estadio 5 con tratamiento médico',
            'Var59 Hemoglobina',
            'Var60 Albúmina Sérica',
            'Var61 Fósforo',
            'Var62 Valoración Clínica inicial por nefrología',
            'Var62_1 Contraindicacion por Cáncer activo en los últimos 12 meses',
            'Var62_2 Contraindicacion por infección crónica o activa no tratada o no controlada',
            'Var62_3 Contraindicacion porque NO ha manifestado su deseo de trasplantarse',
            'Var62_4 Contraindicacion por esperanza de vida menor o igual a 6 meses',
            'Var62_5 Contraindicacion potencial limitacion autocuidado y adherencia al tratamiento posttrasplante',
            'Var62_6 Contraindicacion por enfermedad cardiaca cerebrovascular o vascular periférica',
            'Var62_7 Contraindicacion por infección por el VIH',
            'Var62_8 Contraindicacion por infección por el VHC',
            'Var62_9 Contraindicacion por enfermedad inmunológica activa',
            'Var62_10 Contraindicacion por enfermedad pulmonar crónica',
            'Var62_11 Contraindicacion por otras enfermedades crónicas',
            'Var63 Fecha de Ingreso a lista de espera para la realización del trasplante',
            'Var63_1 IPS donde está en lista de espera',
            'Var64 Ha recibido trasplante renal',
            'Var65 EPS que realizó el trasplante',
            'Var66 IPS o Grupo de trasplante que realizó el trasplante',
            'Var67 Tipo de donante',
            'Var68 Costo del trasplante',
            'Var69 Ha presentado alguna complicación relacionada con el trasplante',
            'Var69_1 Fecha de diagnóstico si ha presentado infección por Citomegalovirus',
            'Var69_2 Fecha de diagnóstico si ha presentado infección por hongos',
            'Var69_3 Fecha de diagnóstico si ha presentado infección por tuberculosis',
            'Var69_4 Fecha de diagnóstico si ha presentado alguna complicación vascular',
            'Var69_5 Fecha de diagnóstico si ha presentado alguna complicación urológica',
            'Var69_6 Fecha de diagnóstico si ha presentado alguna complicación herida quirúrgica',
            'Var69_7 Fecha del primer diagnóstico de cáncer',
            'Var70 Cuantos médicamentos inmunosupresores se formularon',
            'Var70_1 Ha recibido metilprednisolona',
            'Var70_2 Ha recibido azatioprina',
            'Var70_3 Ha recibido ciclosporina',
            'Var70_4 Ha recibido micofenolato',
            'Var70_5 Ha recibido tacrolimus',
            'Var70_6 Ha recibido prednisona',
            'Var70_7 Ha recibido Medicamento NO POS 01',
            'Var70_8 Ha recibido Medicamento NO POS 02',
            'Var70_9 Ha recibido Medicamento NO POS 03',
            'Var71 Cuantos episodios de rechazo agudo ha presentado el usuario',
            'Var72 Fecha del primer rechazo del injerto',
            'Var73 Fecha de retorno a diálisis',
            'Var74 Número de trasplantes renales que ha recibido',
            'Var75 Costo de la terapia postrasplante',
            'Var76 Meses de prestación de servicios',
            'Var77 Costo Total',
            'Var78 EPS de origen',
            'Var79 Novedad con respecto al reporte anterior',
            'Var80 Causa Muerte',
            'Var80_1 Fecha Muerte',
            'Var81_CodigoSerial',
            'Var82_FechaCorte'
        ]);

        foreach ($historias as $historia) {
            $consulta = $historia->consulta;
            $afiliado = $consulta?->afiliado;

            if (!$afiliado) {
                continue;
            }

            foreach ($historias as $historia) {
                $consulta = $historia->consulta;
                $afiliado = $consulta?->afiliado;

                if (!$afiliado) {
                    continue;
                }

                $campos = [];

                $campos[] = $afiliado->primer_nombre ?? 'SinDato'; // Var1
                $campos[] = $afiliado->segundo_nombre ?? 'NONE'; // Var2
                $campos[] = $afiliado->primer_apellido ?? 'SinDato'; // Var3
                $campos[] = $afiliado->segundo_apellido ?? 'NOAP'; // Var4
                $campos[] = $afiliado->tipoDocumento?->sigla ?? 'SinDato'; // Var5
                $campos[] = $afiliado->numero_documento ?? 'SinDato'; // Var6
                $campos[] = optional($afiliado->fecha_nacimiento)->format('Y-m-d') ?? 'SinDato'; // Var7
                $campos[] = $afiliado->sexo ?? 'SinDato'; // Var8
                $campos[] = $this->mapRegimenAfiliacion($afiliado->tipo_afiliacion_id); // Var9
                $campos[] = $afiliado->entidad?->codigo_eapb ?? 'SinDato'; // Var10
                $campos[] = $this->mapPertenenciaEtnica($afiliado->pertenencia_etnica); // Var11
                $campos[] = 'SinDato'; // Var12 grupo poblacional
                $campos[] = $afiliado->municipio_residencia?->codigo_dane ?? 'SinDato'; // Var13
                $campos[] = $afiliado->telefono ?? 'SinDato'; // Var14
                $campos[] = $afiliado->fecha_afiliacion
                    ? Carbon::parse($afiliado->fecha_afiliacion)->format('Y-m-d')
                    : 'SinDato'; // Var15
                $campos[] = $afiliado->ips?->codigo_habilitacion ?? 'SinDato'; // Var16
                $campos[] = 'SinDato'; // Var17 fecha ingreso a programa nefroprotección

                // Var18 - Diagnóstico confirmado de HTA
                $campos[] = $consulta?->cie10Afiliado?->contains(function ($pivot) {
                    return $pivot->cie10?->codigo_cie10 === 'I10X';
                }) ? 1 : 2;

                // Var19 - Fecha de diagnóstico de HTA (I10X) o 1845-01-01
                $diagnosticoHta = $consulta?->cie10Afiliado?->first(function ($pivot) {
                    return $pivot->cie10?->codigo_cie10 === 'I10X';
                });

                $campos[] = $diagnosticoHta
                    ? Carbon::parse($diagnosticoHta->created_at)->format('Y-m-d')
                    : '1845-01-01';

                // TODO: Var19_1 Costo
                $campos[] = '98';

                // Var20 - Diagnóstico confirmado de DM (códigos que comienzan con E11)
                $campos[] = $consulta?->cie10Afiliado?->contains(function ($pivot) {
                    return Str::startsWith($pivot->cie10?->codigo_cie10, 'E11');
                }) ? 1 : 2;

                // Var21 - Fecha de diagnóstico de DM (códigos que comienzan con E11) o 1845-01-01
                $diagnosticoDm = $consulta?->cie10Afiliado?->first(function ($pivot) {
                    return Str::startsWith($pivot->cie10?->codigo_cie10, 'E11');
                });

                $campos[] = $diagnosticoDm
                    ? Carbon::parse($diagnosticoDm->created_at)->format('Y-m-d')
                    : '1845-01-01';

                // TODO: Var21_1 Costo
                $campos[] = '98';

                // TODO: Var22 Etiologia
                $campos[] = 'SinDato';

                // Var23 - Peso
                $campos[] = isset($historia->peso)
                    ? number_format((float) $historia->peso, 1, '.', '')
                    : 'SinDato';

                // Var24 - Talla
                $campos[] = isset($historia->talla)
                    ? (int) round($historia->talla)
                    : 'SinDato';

                // Var25 Tensión Arterial Sistolica
                $campos[] = isset($historia->presion_sistolica)
                    ? (int) round($historia->presion_sistolica)
                    : '999';

                // Var26 Tensión Arterial Diastolica
                $campos[] = isset($historia->presion_diastolica)
                    ? (int) round($historia->presion_diastolica)
                    : '999';

                // TODO: Var27 Creatinina
                $campos[] = '99';

                // TODO: Var27_1 Fecha ultima Creatinina
                $campos[] = '1845-01-01';

                // TODO: Var28 Hemoglobina Glicosilada
                $campos[] = '99';

                // TODO: Var28_1 Fecha ultima Hemoglobina Glicosilada
                $campos[] = '1845-01-01';

                // TODO: Var29 Albuminuria
                $campos[] = '99';

                // TODO: Var29_1 Fecha ultima Albuminuria
                $campos[] = '1845-01-01';

                // TODO: Var30 Creatinuria
                $campos[] = '99';

                // TODO: Var30_1 Fecha ultima Creatinuria
                $campos[] = '1845-01-01';

                // Var31 y Var31_1 - Colesterol Total
                [$valor, $fecha] = $this->obtenerResultadoLaboratorio($consulta, 'COLESTEROL TOTAL', '999');
                $campos[] = $valor;
                $campos[] = $fecha;

                // Var32 y Var32_1 - HDL
                [$valor, $fecha] = $this->obtenerResultadoLaboratorio($consulta, 'COLESTEROL DE ALTA DENSIDAD', '999');
                $campos[] = $valor;
                $campos[] = $fecha;

                // Var33 y Var33_1 - LDL
                [$valor, $fecha] = $this->obtenerResultadoLaboratorio($consulta, 'COLESTEROL DE BAJA DENSIDAD', '999');
                $campos[] = $valor;
                $campos[] = $fecha;

                // Var34 y Var34_1 - PTH
                [$valor, $fecha] = $this->obtenerResultadoLaboratorio($consulta, 'HORMONA PARATIROIDEA', '999');
                $campos[] = $valor;
                $campos[] = $fecha;

                // TODO: Var35 Tasa de filtración glomerular esrtimada (TFGE)
                $campos[] = '2';

                // TODO: Var36 Recibe Inhibidor de la Enzima convertidora de angiotensina IECA
                $campos[] = '99';

                // TODO: Var37 Recibe Antagonista de los receptores de angiotensina II ARA II
                $campos[] = '99';

                // TODO: Var38 Tiene diagnóstico de enfermedad renal crónica en cualquier de sus estadios
                $campos[] = '2';

                // TODO: Var39 Estadio de ERC
                $campos[] = '99';

                // TODO: Var40 Fecha de diagnósitico ERC estadio 5
                $campos[] = '1845-01-01';

                // TODO: Var41 Se encuentra en un programa de atención de ERC
                $campos[] = '99';

                // TODO: Var42 TFGenTRR
                $campos[] = '99';

                // TODO: Var43 Modo de Inicio de la TRR
                $campos[] = '99';

                // TODO: Var44 Fecha en que se inicio la TRR
                $campos[] = '1845-01-01';

                // TODO: Var45 Fecha de Ingreso a la Unidad Renal Actual
                $campos[] = '1845-01-01';

                // TODO: Var46 Hemodialisis
                $campos[] = '98';

                // TODO: Var47 Dosis de diálisis Kt_V single pool
                $campos[] = '98';

                // TODO: Var48 Costo total de la hemodiálisis
                $campos[] = '98';

                // TODO: Var49 Diálisis peritoneal
                $campos[] = '98';

                // TODO: Var50 Dosis de diálisis Kt_V dpd
                $campos[] = '98';

                // TODO: Var51 Numero de horas de dialisis
                $campos[] = '98';

                // TODO: Var52 Peritonitis
                $campos[] = '98';

                // TODO: Var53 Costo DP
                $campos[] = '98';

                // TODO: Var54 Vacuna Hepatitis B
                $campos[] = '99';

                // TODO: Var55 Fecha de diagnóstico de la infección por Hepatitis B
                $campos[] = '1845-01-01';

                // TODO: Var56 Fecha de diagnóstico de la infección por Hepatitis C
                $campos[] = '1845-01-01';

                // TODO: Var57 Terapia no Dialítica para ERC estadio 5
                $campos[] = '99';

                // TODO: Var58 Costo de la terapia ERC estadio 5 con tratamiento médico
                $campos[] = '98';

                // Var59 Hemoglobina
                [$valor, $fecha] = $this->obtenerResultadoLaboratorio($consulta, 'HEMOGLOBINA', '98');
                $campos[] = $valor;

                // TODO: Var60 Albúmina Sérica
                $campos[] = '98';

                // TODO: Var61 Fósforo (P)
                $campos[] = '98';

                // TODO: Var62 Valoración Clínica inicial por nefrología
                $campos[] = '99';

                // TODO: Var62_1 Var62_1 Contraindicacion por Cáncer activo en los últimos 12 meses
                $campos[] = '98';

                // TODO: Var62_2 Contraindicacion por infección crónica o activa no tratada o no controlada
                $campos[] = '98';

                // TODO: Var62_3 Contraindicacion porque NO ha manifestado su deseo de trasplantarse
                $campos[] = '98';

                // TODO: Var62_3 Contraindicacion porque NO ha manifestado su deseo de trasplantarse
                $campos[] = '98';

                // TODO: Var62_4 Contraindicacion por esperanza de vida menor o igual a 6 meses
                $campos[] = '98';

                // TODO: Var62_5 Contraindicacion potencial limitacion autocuidado y adherencia al tratamiento posttrasplante
                $campos[] = '98';

                // TODO: Var62_6 Contraindicacion por enfermedad cardiaca cerebrovascular o vascular periférica
                $campos[] = '98';

                // TODO: Var62_7 Contraindicacion por infección por el VIH
                $campos[] = '98';

                // TODO: Var62_8 Contraindicacion por infección por el VHC
                $campos[] = '98';

                // TODO: Var62_9 Contraindicacion por enfermedad inmunológica activa
                $campos[] = '98';

                // TODO: Var62_10 Contraindicacion por enfermedad pulmonar crónica
                $campos[] = '98';

                // TODO: Var62_11 Contraindicacion por otras enfermedades crónicas
                $campos[] = '98';

                // TODO: Var63 Fecha de Ingreso a lista de espera para la realización del trasplante
                $campos[] = '1845-01-01';

                // TODO: Var63_1 IPS donde está en lista de espera
                $campos[] = '98';

                // TODO: Var64 Ha recibido trasplante renal
                $campos[] = '98';

                // TODO: Var65 EPS que realizó el trasplante
                $campos[] = '98';

                // TODO: Var66 IPS o Grupo de trasplante que realizó el trasplante
                $campos[] = '98';

                // TODO: Var67 Tipo de donante
                $campos[] = '99';

                // TODO: Var68 Var67 Tipo de donante
                $campos[] = '98';

                // TODO: Var69 Ha presentado alguna complicación relacionada con el trasplante
                $campos[] = '98';

                // TODO: Var69_1 Fecha de diagnóstico si ha presentado infección por Citomegalovirus
                $campos[] = '1845-01-01';

                // TODO: Var69_2 Fecha de diagnóstico si ha presentado infección por hongos
                $campos[] = '1845-01-01';

                // TODO: Var69_3 Fecha de diagnóstico si ha presentado infección por tuberculosis
                $campos[] = '1845-01-01';

                // TODO: Var69_4 Fecha de diagnóstico si ha presentado alguna complicación vascular
                $campos[] = '1845-01-01';

                // TODO: Var69_5 Fecha de diagnóstico si ha presentado alguna complicación urológica
                $campos[] = '1845-01-01';

                // TODO: Var69_6 Fecha de diagnóstico si ha presentado alguna complicación herida quirúrgica
                $campos[] = '1845-01-01';

                // TODO: Var69_7 Fecha del primer diagnóstico de cáncer
                $campos[] = '1845-01-01';

                // TODO: Var70 Cuantos médicamentos inmunosupresores se formularon
                $campos[] = '98';

                // TODO: Var70_1 Ha recibido metilprednisolona
                $campos[] = '98';

                // TODO: Var70_2 Ha recibido azatioprina
                $campos[] = '98';

                // TODO: Var70_3 Ha recibido ciclosporina
                $campos[] = '98';

                // TODO: Var70_4 Ha recibido micofenolato
                $campos[] = '98';

                // TODO: Var70_5 Ha recibido tacrolimus
                $campos[] = '98';

                // TODO: Var70_6 Ha recibido prednisona
                $campos[] = '98';

                // TODO: Var70_7 Ha recibido Medicamento NO POS 01
                $campos[] = '98';

                // TODO: Var70_8 Ha recibido Medicamento NO POS 02
                $campos[] = '98';

                // TODO: Var70_9 Ha recibido Medicamento NO POS 03
                $campos[] = '98';

                // TODO: Var71 Cuantos episodios de rechazo agudo ha presentado el usuario
                $campos[] = '98';

                // TODO: Var72 Fecha del primer rechazo del injerto
                $campos[] = '1845-01-01';

                // TODO: Var73 Fecha de retorno a diálisis
                $campos[] = '1845-01-01';

                // TODO: Var74 Número de trasplantes renales que ha recibido
                $campos[] = '98';

                // TODO: Var75 Costo de la terapia postrasplante
                $campos[] = '98';

                // TODO: Var76 Meses de prestación de servicios
                $campos[] = '98';

                // TODO: Var77 Costo Total
                $campos[] = '98';

                // TODO: Var78 EPS de origen
                $campos[] = '98';

                // TODO: Var79 Novedad con respecto al reporte anterior
                $campos[] = '98';

                // TODO: Var80 Causa de muerte
                $campos[] = '99';

                // TODO: Var81 Fecha de muerte
                $campos[] = '1845-01-01';
            }

            $lineas[] = implode("\t", $campos);

        }

        return $lineas;
    }

    private function mapRegimenAfiliacion(int $regimen): string
    {
        return match ($regimen) {
            1 => 'C',
            2 => 'S',
            3 => 'E',
            default => 'SinDato',
        };
    }

    private function mapPertenenciaEtnica(?string $etnia): int
    {
        return match (strtolower($etnia ?? '')) {
            'indígena' => 1,
            'room' => 2,
            'raizal' => 3,
            'palenquero' => 4,
            'mulato',
            'afrocolombiano',
            'afrodescendiente',
            'negro',
            'afro' => 5,
            default => 6, // Otro o no aplica
        };
    }

    private function obtenerResultadoLaboratorio($consulta, string $busqueda, string $valorNoEncontrado): array
    {
        $resultado = $consulta?->resultadoLaboratorios?->first(function ($res) use ($busqueda) {
            return Str::contains(strtoupper($res->laboratorio), strtoupper($busqueda));
        });

        return [
            $resultado?->resultado_lab ?? $valorNoEncontrado,
            $resultado
            ? Carbon::parse($resultado->created_at)->format('Y-m-d')
            : '1845-01-01',
        ];
    }


}
