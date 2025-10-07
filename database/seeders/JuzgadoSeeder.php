<?php

namespace Database\Seeders;

use App\Http\Modules\Juzgados\Models\Juzgado;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class JuzgadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       try {
        $juzgados = [
            [
                'nombre' =>'D.S.A.J. AREA ADMINISTRATIVA'
             ],

             [
                'nombre' =>'D.S.A.J. AREA ADMINISTRATIVA-GRUPO DE ALMACEN'
             ],

             [
                'nombre' =>'D.S.A.J. AREA ADMINISTRATIVA-GRUPO DE SERVICIOS ADMINISTRATIVOS'
             ],

             [
                'nombre' =>'D.S.A.J. AREA ADMINISTRATIVA-GRUPO MANTENIMIENTO Y SOPORTE TECNOLOGICO'
             ],

             [
                'nombre' =>'D.S.A.J. AREA DE TALENTO HUMANO'
             ],

             [
                'nombre' =>'D.S.A.J. AREA DE TALENTO HUMANO - GRUPO BIENESTAR Y SALUD OCUPACIONAL'
             ],

             [
                'nombre' =>'D.S.A.J. AREA DE TALENTO HUMANO - GRUPO DE ASUNTOS LABORALES'
             ],

             [
                'nombre' =>'D.S.A.J. AREA FINANCIERA'
             ],

             [
                'nombre' =>'D.S.A.J. AREA FINANCIERA-GRUPO DE CONTABILIDAD'
             ],

             [
                'nombre' =>'D.S.A.J. AREA FINANCIERA-GRUPO DE EJECUCIÓN PRESUPUESTAL'
             ],

             [
                'nombre' =>'D.S.A.J. AREA FINANCIERA-GRUPO DE PAGADURIA'
             ],

             [
                'nombre' =>'D.S.A.J. AREA JURIDICA'
             ],

             [
                'nombre' =>'D.S.A.J. AREA JURIDICA- GRUPO DE APOYO LEGAL'
             ],


             [
                'nombre' =>'D.S.A.J. AREA JURIDICA- GRUPO DE COBRO COACTIVO'
             ],

             [
                'nombre' =>'DESPACHO 001 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA CIVIL FAMILIA DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA DE FAMILIA DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA PENAL DE JUSTICIA Y PAZ DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 001 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA CIVIL ESPECIALIZADA EN RESTITUCIÓN DE TIERRAS DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA CIVIL FAMILIA DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA DE FAMILIA DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA PENAL DE JUSTICIA Y PAZ DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 002 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA CIVIL ESPECIALIZADA EN RESTITUCIÓN DE TIERRAS DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA CIVIL FAMILIA DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA DE FAMILIA DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA PENAL DE JUSTICIA Y PAZ DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 003 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA CIVIL ESPECIALIZADA EN RESTITUCIÓN DE TIERRAS DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA CIVIL FAMILIA DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA DE FAMILIA DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA PENAL DE JUSTICIA Y PAZ DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 004 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 005 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 005 DE LA SALA DE FAMILIA DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 005 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 005 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 005 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 006 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 006 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 006 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO 006 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 007 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 007 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 007 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 008 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 008 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 008 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 009 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 009 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 009 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 010 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 010 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 010 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 011 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 011 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 011 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 012 DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 012 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 012 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 013 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 013 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 014 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 014 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 015 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 015 DE LA SALA PENAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 016 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 017 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO 018 DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO DE LA SALA CIVIL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DESPACHO DE LA SALA CIVIL ESPECIALIZADA EN RESTITUCIÓN DE TIERRAS DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO DE LA SALA CIVIL FAMILIA DEL TRIBUNAL SUPERIOR DE ANTIOQUIA'
             ],


             [
                'nombre' =>'DESPACHO DE LA SALA LABORAL DEL TRIBUNAL SUPERIOR DE MEDELLÍN'
             ],


             [
                'nombre' =>'DIRECCIÓN SECCIONAL DE LA RAMA JUDICIAL CENTRO DE SERVICIOS ADMINISTRATIVOS'
             ],


             [
                'nombre' =>'JUZGADO 001  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLÍN'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE BELLO'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE CALDAS'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE ENVIGADO'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE GIRARDOTA'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE ITAGÜÍ'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO ESPECIALIZADO  EN RESTITUCIÓN DE TIERRAS DE ANTIOQUIA'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE BELLO'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE ENVIGADO'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE GIRARDOTA'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE ITAGÜÍ'
             ],


             [
                'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE MEDELLÍN'
             ],


             [
                'nombre' =>'JUZGADO 001 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE ANTIOQUIA'
             ],


             [
                'nombre' =>'JUZGADO 001 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],


             [
                'nombre' =>'JUZGADO 001 DE FAMILIA  DE BELLO'
             ],


             [
                'nombre' =>'JUZGADO 001 DE FAMILIA  DE ENVIGADO'
             ],


             [
                'nombre' =>'JUZGADO 001 DE FAMILIA  DE GIRARDOTA'
             ],


             [
                'nombre' =>'JUZGADO 001 DE FAMILIA  DE ITAGÜÍ'
             ],


             [
                'nombre' =>'JUZGADO 001 DE FAMILIA  DE MEDELLÍN'
             ],


             [
                'nombre' =>'JUZGADO 001 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE BELLO'
             ],


             [
                'nombre' =>'JUZGADO 001 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE ENVIGADO'
             ],


             [
                'nombre' =>'JUZGADO 001 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 001 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 LABORAL  DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 001 LABORAL  DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 001 LABORAL  DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 001 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DE CIRCUITO ESPECIALIZADO DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DE CIRCUITO ESPECIALIZADO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE GIRARDOTA'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO DE CALDAS'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO ESPECIALIZADO  EN EXTINCIÓN DE DOMINIO DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE GIRARDOTA'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 001 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE ANGELÓPOLIS'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE ARMENIA'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE BARBOSA'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CALDAS'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE COPACABANA'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE HELICONIA'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE LA ESTRELLA'
             ],

             [
                'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE SABANETA'
             ],

             [
                'nombre' =>'JUZGADO 002  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO ESPECIALIZADO  EN RESTITUCIÓN DE TIERRAS DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 002 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 DE FAMILIA  DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 002 DE FAMILIA  DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 002 DE FAMILIA  DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 002 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 002 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 LABORAL  DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 002 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DE CIRCUITO ESPECIALIZADO DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DE CIRCUITO ESPECIALIZADO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO ESPECIALIZADO  EN EXTINCIÓN DE DOMINIO DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE GIRARDOTA'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 002 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE BARBOSA'
             ],

             [
                'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE CALDAS'
             ],

             [
                'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE COPACABANA'
             ],

             [
                'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE LA ESTRELLA'
             ],

             [
                'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE SABANETA'
             ],

             [
                'nombre' =>'JUZGADO 003  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL DEL CIRCUITO DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL DEL CIRCUITO DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL MUNICIPAL DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL MUNICIPAL DE ENVIGADO'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL MUNICIPAL DE ITAGÜÍ'
             ],

             [
                'nombre' =>'JUZGADO 003 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 003 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL DE CIRCUITO ESPECIALIZADO DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL DE CIRCUITO ESPECIALIZADO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL MUNICIPAL DE BELLO'
             ],

             [
                'nombre' =>'JUZGADO 003 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 003 PROMISCUO MUNICIPAL DE SABANETA'
             ],

             [
                'nombre' =>'JUZGADO 004  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 004 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 PENAL DE CIRCUITO ESPECIALIZADO DE ANTIOQUIA'
             ],

             [
                'nombre' =>'JUZGADO 004 PENAL DE CIRCUITO ESPECIALIZADO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 004 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 PENAL DE CIRCUITO ESPECIALIZADO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 PENAL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 005 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 006 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 007 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 008 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 PENAL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 009 PENAL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 010 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 DE PEQUEÑAS CAUSAS  Y COMPETENCIA MÚLTIPLE DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 011 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 012 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 012 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 012 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 012 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 012 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 012 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 013 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 013 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 013 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 013 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 013 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 013 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 014 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 014 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 014 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 014 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 014 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 014 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 015 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 015 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 015 DE FAMILIA  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 015 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 015 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 015 PENAL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 016 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 016 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 016 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 016 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 016 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 016 PENAL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 017 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 017 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 017 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 017 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 018 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 018 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 018 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 018 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 018 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 019 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 019 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 019 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 019 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 019 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 020 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 020 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 020 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 020 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 020 PENAL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 021 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 021 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 021 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 021 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 021 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 022 CIVIL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 022 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 022 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 022 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 022 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 023 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 023 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 023 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 023 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 024 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 024 LABORAL  DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 024 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 024 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 025 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 025 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 025 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                'nombre' =>'JUZGADO 025 PENAL MUNICIPAL DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 026 CIVIL MUNICIPAL DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 026 PENAL DEL CIRCUITO DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 026 PENAL MUNICIPAL DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 027 CIVIL MUNICIPAL DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 027 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 027 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 028 CIVIL MUNICIPAL DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 028 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'],

             [
                'nombre' =>'JUZGADO 028 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'],

             [
                 'nombre' =>'JUZGADO 028 PENAL MUNICIPAL DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 029 CIVIL MUNICIPAL DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 029 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 029 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 030 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 030 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 031 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 032 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 033 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 034 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 034 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 035 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 036 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 037 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 038 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 039 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 040 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 041 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 042 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 043 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 044 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 045 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 046 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 047 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 101 CIVIL DEL CIRCUITO ESPECIALIZADO  EN RESTITUCIÓN DE TIERRAS DE ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 101 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 102 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 103 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 104 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 701 CIVIL DEL CIRCUITO DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 701 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 702 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 707 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO CIVIL DEL CIRCUITO DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE MEDELLÍN'
             ],

             [
                 'nombre' =>'SECRETARÍA GENERAL  DEL TRIBUNAL SUPERIOR DE ANTIOQUIA - SECRETARÍA'
             ],

             [
                 'nombre' =>'CENTRO DE SERVICIOS ADMINISTRATIVOS 000 CENTRO DE SERVICIOS JUDICIALES PENALES ADOLESCENTES DE QUIBDÓ'
             ],

             [
                 'nombre' =>'CENTRO DE SERVICIOS ADMINISTRATIVOS 000 PENAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'CONSEJO SECCIONAL DE LA JUDICATURA SIN ESPECIALIDAD DE QUIBDÓ-CHOCÓ 251'
             ],

             [
                 'nombre' =>'DESPACHO 001  DEL TRIBUNAL ADMINISTRATIVO DE  CHOCÓ'
             ],

             [
                 'nombre' =>'DESPACHO 001 DE LA SALA JURISDICCIONAL DISCIPLINARIA DEL CONSEJO SECCIONAL DE  CHOCÓ'
             ],

             [
                 'nombre' =>'DESPACHO 001 DE LA SALA ÚNICA DEL TRIBUNAL SUPERIOR DE QUIBDÓ'
             ],

             [
                 'nombre' =>'DESPACHO 002  DEL TRIBUNAL ADMINISTRATIVO DE  CHOCÓ'
             ],

             [
                 'nombre' =>'DESPACHO 002 DE LA SALA JURISDICCIONAL DISCIPLINARIA DEL CONSEJO SECCIONAL DE  CHOCÓ'
             ],

             [
                 'nombre' =>'DESPACHO 002 DE LA SALA ÚNICA DEL TRIBUNAL SUPERIOR DE QUIBDÓ'
             ],

             [
                 'nombre' =>'DESPACHO 003  DEL TRIBUNAL ADMINISTRATIVO DE  CHOCÓ'
             ],

             [
                 'nombre' =>'DESPACHO 003 DE LA SALA ÚNICA DEL TRIBUNAL SUPERIOR DE QUIBDÓ'
             ],

             [
                 'nombre' =>'DIRECCIÓN SECCIONAL DE LA RAMA JUDICIAL 000 OFICINA DE COORDINACIÓN ADMINISTRATIVA DE QUIBDÓ'
             ],

             [
                 'nombre' =>'DIRECCIÓN SECCIONAL DE LA RAMA JUDICIAL 000 OFICINA JUDICIAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001  MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 ADMINISTRATIVO  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE ISTMINA'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO ESPECIALIZADO  EN RESTITUCIÓN DE TIERRAS DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 LABORAL  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DE CIRCUITO ESPECIALIZADO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DE CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO DE ISTMINA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA DEL CIRCUITO DE BAHÍA SOLANO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA DEL CIRCUITO DE ISTMINA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA DEL CIRCUITO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA DEL CIRCUITO DE RIOSUCIO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DEL CIRCUITO DE BAHÍA SOLANO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DEL CIRCUITO DE RIOSUCIO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE ACANDÍ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE ALTO BAUDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE ATRATO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE BAGADÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE BAHÍA SOLANO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE BAJO BAUDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE BELÉN DE BAJIRÁ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE BOJAYÁ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CANTÓN DE SAN PABLO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CARMEN DEL DARIÉN'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CERTEGUI'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CONDOTO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE EL CARMEN DE ATRATO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE ISTMINA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE JURADÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE LITORAL DE SAN JUAN'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE LLORÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE MEDIO ATRATO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE MEDIO BAUDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE MEDIO SAN JUAN'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE NÓVITA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE NUQUÍ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE RÍO IRÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE RÍO QUITO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE RIOSUCIO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE SIPÍ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE TADÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE UNGUÍA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE UNIÓN PANAMERICANA'
             ],

             [
                 'nombre' =>'JUZGADO 002 ADMINISTRATIVO  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 CIVIL DEL CIRCUITO DE ISTMINA'
             ],

             [
                 'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 LABORAL  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO DE FAMILIA DEL CIRCUITO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE BAHÍA SOLANO'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE ISTMINA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE RIOSUCIO'
             ],

             [
                 'nombre' =>'JUZGADO 003 ADMINISTRATIVO  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL MUNICIPAL DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 004 ADMINISTRATIVO  DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 101 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 102 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 401 PENAL DE CIRCUITO ESPECIALIZADO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 402 PENAL DE CIRCUITO ESPECIALIZADO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'SECRETARÍA GENERAL  DEL TRIBUNAL ADMINISTRATIVO DE  QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE YALI'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE LA CEJA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE FRONTINO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE NECOCLI'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE CISNEROS'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE CONCORDIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS CONCORDIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE LA CEJA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO CIVIL MUNICIPAL DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL SAN VICENTE ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL EL SANTUARIO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE YARUMAL'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE BAHIA SOLANO CHOCO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE URRAO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE NARIÑO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DEL PEÑOL'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE TURBO'
             ],

             [
                 'nombre' =>'JUZGADO PENAL DEL CIRCUITO DE MARINILLA'
             ],

             [
                 'nombre' =>'JUZGADO VIGESIMO PRIMERO PENAL MUNICIPAL CON FUNCIONES DE CONOCIMIENTO'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE MARINILLA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE VEGACHI'
             ],

             [
                 'nombre' =>'JUZGADO 003 PROMISCUO MUNICIPAL DE TURBO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE MARINILLA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE EBEJICO'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL MUNICIPAL DE MONTERIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE ARBOLETES'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DEL CARMEN DE VIBORAL'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SAN PEDRO DE URABA'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PROMISCUO MUNICIPAL DE YARUMAL'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE YARUMAL'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE BAGRE'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE ABEJORRAL'
             ],

             [
                 'nombre' =>'JUZGADO DE EJECUCION DE PENAS Y MEDIDAS DE SEGURIDAD DE QUIBDO'
             ],

             [
                 'nombre' =>'JUZGADO 014 ADMINISTRATIVO ORAL DEL CIRCUITO DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO LABORAL DEL CIRCUITO DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO 004 DE EJECUCIÓN CIVIL MUNICIPAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DEL CARMEN DE VIBORAL'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE JERICO'
             ],

             [
                 'nombre' =>'JUZGADO 003 DE EJECUCION CIVIL MUNICIPAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE GUARNE'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL MUNICIPAL DE CONTROL DE GARANTÍAS DE QUIBDO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE PUERTO NARE'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PROMISCUO  MUNICIPAL DE APARTADO'
             ],

             [
                 'nombre' =>'JUZGADO 002 DE EJECUCIÓN CIVIL MUNICIPAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO DEL CIRCUITO DE YOLOMBÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CAUCASIA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE CONOCIMIENTO DE QUIBDO'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO CON FUNCIONES DE CONOCIMIENTO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO DE FAMILIA DE YOLOMBO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE SONSON'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE GOMEZ PLATA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SANTA BARBARA'
             ],

             [
                 'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE YOLOMBÓ'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL ABRIAQUÍ'
             ],

             [
                 'nombre' =>'JUZGADO 007 ADMINISTRATIVO DEL CIRCUITO DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SANTA ROSA DE OSOS'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL FREDONIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE HISPANIA ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DEL BAJO BAUDO - PIZARRO CON FUNCION DE CONTROL DE GARANTIAS'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE CIUDAD BOLIVAR'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO DE SAN FRANCISCO'
             ],

             [
                 'nombre' =>'SUPERSALUD'],

             [
                 'nombre' =>'JUZGADO PRIMERO PROMISCUO MUNICIPAL DE CHIGORODÓ'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE TADO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE ENTRERRIOS'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO DE EJECUCIÓN CIVIL MUNICIPAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 016 ADMINISTRATIVO ORAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 002 MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE AMALFI'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE SONSON'
             ],

             [
                 'nombre' =>'JUZGADO 004 PROMISCUO MUNICIPAL DE APARTADÓ'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DEL CARMEN DE VIBORAL'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PROMISCUO MUNICIPAL DE AMAGÁ'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE MURINDO'
             ],

             [
                 'nombre' =>'JUZGADO 028 ADMINISTRATIVO ORAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 001  PROMISCUO MUNICIPAL DE APARTADO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE DABEIBA'
             ],

             [
                 'nombre' =>'JUZGADO 006 ADMINISTRATIVO ORAL DEL CIRCUITO DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE COCORNA'
             ],

             [
                 'nombre' =>'JUZGADO PENAL DEL CIRCUITO DE CAUCASIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE LA LLANADA – NARIÑO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SAN JERÓNIMO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE CAÑASGORDAS'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE TAMESIS'
             ],

             [
                 'nombre' =>'JUZGADO 002  PROMISCUO MUNICIPAL CIUDAD BOLIVAR'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUEZ PROMISCUO MUNICIPAL DE SAN BERNARDO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE CAREPA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO DE FAMILIA DE RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO 023 ADMINISTRATIVO ORAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 001 DE EJECUCIÓN CIVIL MUNICIPAL DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO CIVIL LABORAL DEL CIRCUITO DE MARINILLA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE JARDIN'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SANTA FE DE ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SAN ROQUE'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE BELMIRA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE TURBO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE PUERTO TRIUNFO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO DEL CIRCUITO DE ABEJORRAL'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO DE EJECUCION CIVIL MUNICIPAL DE MANIZALES'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE GRANADA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SEGOVIA'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL MUNICIPAL BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE PUERTO BERRIO'
             ],

             [
                 'nombre' =>'JUZGADO 001  PROMISCUO MUNICIPAL DE SAN CARLOS'
             ],

             [
                 'nombre' =>'JUZGADO 015 ADMINISTRATIVO ORAL DEL CIRCUITO DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE GIRALDO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DEL RETIRO'
             ],

             [
                 'nombre' =>'JUZGADO PENAL DEL CIRCUITO DE ANDES'
             ],

             [
                 'nombre' =>'JUZGADO 004 PENAL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 010 CIVIL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO DE FAMILIA AGUACHICA CESAR'
             ],

             [
                 'nombre' =>'JUZGADO 008 DE FAMILIA DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PROMISCUO MUNICIPAL DE ORALIDAD Y CONTROL DE GARANTIAS DE SABANETA (ANTIOQUIA)'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL MUNICIPAL CON FUNCIONES DE CONOCIMIENTO MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO SEXTO LABORAL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PENAL DEL CIRCUITO  CON FUNCIONES DE CONOCIMIENTO MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO CIVIL MUNICIPAL DE BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 012 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 020 CIVIL MUNICIPAL DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE TAMALAMEQUE - CESAR'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL MUNICIPAL CON FUNCIONES MIXTAS DE GIRÓN'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL MUNICIPAL DE CONTROL DE GARANTIAS DE QUIBDO'
             ],

             [
                 'nombre' =>'JUZGADO NOVENO CIVIL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PROMISCUO MUNICIPAL DE ITSMINA'
             ],

             [
                 'nombre' =>'JUZGADO 021 CIVIL CIRCUITO DE ORALIDAD DE MEDELLÍN'
             ],

             [
                 'nombre' =>'JUZGADO 005 PENAL DEL CIRCUITO CON FUNCIONES DE CONOCIMIENTO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO CUARTO LABORAL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCION DE CONTROL DE GARANTÍAS DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO PARA LA RESPONSABILIDAD PENAL DE ADOLESCENTES DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 012 CIVIL MUNICIPAL DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 015 CIVIL MUNICIPAL DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PROMISCUO MUNICIPAL DE AGUACHICA'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PENAL DEL CIRCUITO ESPECIALIZADO CON FUNCIONES DE CONOCIMIENTO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 003 CIVIL MUNICIPAL DE ORALIDAD DE BELLO'
             ],

             [
                 'nombre' =>'"JUZGADO LABORAL DEL CIRCUITO, BELLO, ANTIOQUIA"'
             ],

             [
                 'nombre' =>'JUZGADO CUARTO PENAL MUNICIPAL BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO DE PEQUEÑAS CAUSAS Y COMPETENCIA MÚLTIPLE BARRIO PARIS'
             ],

             [
                 'nombre' =>'"JUZGADO PROMISCUO MUNICIPAL DE YONDÓ, ANTIOQUIA"'
             ],

             [
                 'nombre' =>'JUZGADO DIECINUEVE PENAL MUNICIPAL CON FUNCIONES DE CONOCIMIENTO'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PROMISCUO MUNICIPAL GUARNE-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO TERCERO PENAL DEL CIRCUITO BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO SEXTO CIVIL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO TERCERO ADMINISTRATIVO ORAL DEL CIRCUITO JUDICIAL DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO NOVENO PENAL DEL CIRCUITO CON FUNCION DE CONOCIMIENTO BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO SEGUNDO PROMISCUO MUNICIPAL DE AGUACHICA-CESAR'
             ],

             [
                 'nombre' =>'Juzgado Promiscuo Municipal CAICEDO ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO DÉCIMO ADMINISTRATIVO ORAL DEL CIRCUITO JUDICIAL DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO PENAL DEL CIRCUITO Bello - Antioquia'
             ],

             [
                 'nombre' =>'JUZGADO 004 CIVIL MUNICIPAL BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 001 LABORAL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL GIRARDOTA - ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE MEDELLIN'
             ],

             [
                 'nombre' =>'JUZGADO 017 CIVIL MUNICIPAL BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 005 DE FAMILIA BUCARAMANGA'
             ],

             [
                 'nombre' =>'"JUZGADO 002 PENAL DEL CIRCUITO AGUACHICA, CESAR"'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO DOSQUEBRADAS-RISARALDA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL ITUANGO'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO CON FUNCIONES DE CONOCIMIENTO RIONEGRO'
             ],

             [
                 'nombre' =>'JUZGADO 002 ADMINISTRATIVO ORAL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 002 ADMINISTRATIVO ORAL DEL CIRCUITO JUDICIAL DE BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO ESPECIALIZADO DE QUIBDÓ'
             ],

             [
                 'nombre' =>'JUZGADO 014 PENAL MUNICIPAL CON FUNCIONES DE CONTROL DE GARANTIAS BUCARAMANGA – SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE PASTO CON FUNCIÓN DE CONTROL DE GARANTÍAS PARA ADOLESCENTES'
             ],

             [
                 'nombre' =>'JUZGADO 013 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO DE FAMILIA BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 002 ADMINISTRATIVO ORAL DEL CIRCUITO DE QUIBDO'
             ],

             [
                 'nombre' =>'JUZGADO 001 DE FAMILIA BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL DE CONTROL DE GARANTÍAS DE QUIBDO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL LA UNIÓN (LA UNION)'
             ],

             [
                 'nombre' =>'JUZGADO 004 PENAL MUNICIPAL CON FUNCIONES DE CONTROL DE GARANTÍAS DE BUCARAMANGA DESCENTRALIZADO EN GIRÓN'
             ],

             [
                 'nombre' =>'JUZGADO 029 CIVIL MUNICIPAL DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL PUERTO LÓPEZ – META'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL DEL CIRCUITO DE BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL SAN PEDRO DE LOS MILAGROS ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL ARGELIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL BETULIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO ESPECIALIZADO EN RESTITUCIÓN DE TIERRAS DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 006 DE PEQUEÑAS CAUSAS Y COMPETENCIA MÚLTIPLE DE FLORIDABLANCA - SANTANDER.'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL ALEJANDRIA ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO AGUACHICA – CESAR'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL ANDES ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA JERICÓ-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 003 CIVIL DEL CIRCUITO DE BUCARAMANGA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PROMISCUO MUNICIPAL DE SAN GIL-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 002 CIVIL MUNICIPAL CARTAGO-VALLE'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE AGUACHICA-CESAR'
             ],

             [
                 'nombre' =>'JUZGADO OO2 PROMISCUO MUNICIPAL DE CHIGORODÓ'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL ANDES-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO PUERTO BERRIO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 LABORAL DEL CIRCUITO DE BARRANCABERMEJA'
             ],

             [
                 'nombre' =>'JUZGADO 007 ADMINISTRATIVO ORAL DEL CIRCUITO JUDICIAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE EL PLAYON-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL DEL CIRCUITO DE RIONEGRO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE CAROLINA DEL PRINCIPE-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PENAL MUNICIPAL DE MONTERÍA - CÓRDOBA'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL CON FUNCIONES DE CONTROL DE GARANTIAS DE SANTIAGO DE CALI- VALLE DEL CAUCA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL CON FUNCIONES MIXTAS DE FLORIDABLANCA-SANTANDER'
             ],

             [
                 'nombre' =>'DEFENSORIA DEL PUEBLO'],

             [
                 'nombre' =>'JUZGADO 003 ADMINISTRATIVO ORAL DEL CIRCUITO JUDICIAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE PIEDECUESTA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO PRIMERO [MUNICIPAL] DE EJECUCIÓN CIVIL MUNICIPAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 003 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL MUNICIPAL DE CONOCIMIENTO DE QUIBDO-CHOCO'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE MORALES BOLÍVAR-BOLIVAR'
             ],

             [
                 'nombre' =>'JUZGADO 001 DE PEQUEÑAS CAUSAS Y COMPETENCIAS MÚLTIPLES DE FLORIDABLANCA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE GAMARRA-CESAR'
             ],

             [
                 'nombre' =>'JUZGADO 005 PENAL MUNICIPAL CON FUNCIONES DE CONOCIMIENTO SPA DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SAN LUIS-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO PARA ADOLESCENTES CON FUNCIÓN DE CONOCIMIENTO DE QUIBDÓ-CHOCÓ'
             ],

             [
                 'nombre' =>'JUZGADO 013 CIVIL MUNICIPAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO AGUACHICA-CESAR'
             ],

             [
                 'nombre' =>'JUZGADO 006 DE EJECUCIÓN DE PENAS Y MEDIDAS DE SEGURIDAD DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 005 CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE BURAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 013 ADMINISTRATIVO DEL CIRCUITO JUDICIAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 LABORA DEL CIRCUITO DE PUERTO BERRIO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE MUTATA-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO CIVIL-LABORAL DEL CIRCUITO DE YARUMAL-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 006 PENAL DEL CIRCUITO CON FUNCIÓN DE CONOCIMIENTO DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL PARA ADOLESCENTES CON FUNCIÓN DE CONTROL DE GARANTÍAS DE SAN GIL-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SOPETRAN – ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE SABANA DE TORRES-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 PENAL DEL CIRCUITO DE DOSQUEBRADAS-RISARALDA'
             ],

             [
                 'nombre' =>'JUZGADO 025 CIVIL MUNICIPAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 005 PENAL MUNICIPAL CON FUNCIONES MIXTAS DE BARRANCABERMEJA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL PARA ADOLESCENTES-GARANTÍAS DE BUCARAMANGA–SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE CARACOLI-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 009 PENAL MUNICIPAL CON FUNCIÓN DE CONOCIMIENTO DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 006 DE FAMILIA DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 033 ADMINISTRATIVO DE ORALIDAD DEL CIRCUITO DE MEDELLÍN-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 003 PROMISCUO MUNICIPAL LA DORADA-CALDAS'
             ],

             [
                 'nombre' =>'JUZGADO 004 PENAL DEL CIRCUITO DE CONOCIMIENTO ARMENIA - QUINDÍO'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO MUNICIPAL DE NOVITA – CHOCO'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL MUNICIPAL DE ORALIDAD DE BELLO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 003 MUNICIPAL DE PEQUEÑAS CAUSAS LABORALES DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 PROMISCUO DE FAMILIA DE RIONEGRO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DE RIONEGRO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 011 CIVIL MUNICIPAL DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 002 PENAL MUNICIPAL CON FUNCIONES DE CONOCIMIENTO DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 006 PENAL MUNICIPAL CON FUNCIONES DE CONOCIMIENTO DE BUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 001 CIVIL DEL CIRCUITO DEBUCARAMANGA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 002 PROMISCUO MUNICIPAL DE PUERTO BERRIO-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 004 PENAL MUNICIPAL CON FUNCIÓN DE CONTROL DE GARANTÍAS DE VALLEDUPAR-CESAR'
             ],

             [
                 'nombre' =>'JUZGADO PROMISCUO MUNICIPAL DE ANORI-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO TERCERO PROMISCUO MUNICIPAL DE PUERTO BOYACA-BOYACA'
             ],

             [
                 'nombre' =>'JUZGADO 004 PROMISCUO MUNICIPAL DE APARTADÓ-ANTIOQUIA'
             ],

             [
                 'nombre' =>'JUZGADO 004 CIVIL MUNICIPAL BARRANCABERMEJA-SANTANDER'
             ],

             [
                 'nombre' =>'JUZGADO 013 DE EJECUCIÓN CIVIL MUNICIPAL DE EJECUCIÓN DE SENTENCIAS DE BOGOTÁ D.C.-CUNDINAMARCA'
             ],

             [
                 'nombre' =>'JUZGADO 021 PENAL MUNICIPAL CONFUNCIONES DE CONTROL DE GARANTÍAS DE BUCARAMANGA-SANTANDER'
             ],
        ];
        foreach ($juzgados as $juzgado) {
            juzgado::updateOrCreate([
                'nombre' => $juzgado['nombre']
            ],[
                'nombre' => $juzgado['nombre']
            ]);
        };

       } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de juzgado'
            ], Response::HTTP_BAD_REQUEST);
       }
    }
}
