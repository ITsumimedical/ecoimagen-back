<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha de Notificación Individual</title>
    <style>

        .page-break {
            page-break-after: always;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2px 0;
        }

        table,
        th,
        td {
            border: 0.5px solid #000;
        }

        th,
        td {
            vertical-align: top;
        }

        .Encabezado {
            text-align: center;
            margin: 0;
            font-size: 10px;
        }

        .imgEncabezado {
            width: 80%;
        }

        .titulos {
            background-color: #d3d3d3;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        .titulo-campo {
            background-color: #d3d3d3;
            font-weight: bold;
            font-size: 7px;
            text-align: left;
        }

        .sub-titulo {
            font-size: 7px;
            font-weight: bold;
        }

        .info-campos {
            background-color: #d3d3d3;
            font-size: 7px;
            padding: 2px;
            text-align: left;
        }

        .texto-pequeno {
            font-size: 6px;
            text-align: center;
        }

        .respuesta {
            font-size: 6px;
            text-align: center;
            margin: 0;
            padding: 1px;
        }

        .contenedor {
            margin: 2px;
        }

        .contenedor-cuadros {
            display: inline-block;
            text-align: center;
            margin-right: 2px;
        }

        .cuadritos {
            display: inline-table;
            border-collapse: collapse;
            margin-top: 5px;
            padding: 2px;
        }

        .cuadritos td {
            width: 6px;
            height: 6px;
            border: 0.4px solid black;
            text-align: center;
            vertical-align: middle;
            padding: 1px;
        }

        .etiqueta {
            text-align: center;
            font-size: 5px;
            padding-bottom: 0;
            padding-right: 0.5px;
            padding-left: 0.5px;
            margin: 0;
        }

        .contenedor-opciones {
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
        }

        .opcion {
            display: inline-table;
            border-collapse: collapse;
        }

        .custom-radio {
            display: inline-flex;
            align-items: center;
        }

        input[type="radio"] {
            transform: scale(0.5);
            margin-right: 2px;
        }

        input[type="checkbox"] {
            transform: scale(0.5);
            margin: 0;
            top: -8px;
        }

        .radio-label {
            font-size: 5px;
            margin: 0;
            padding: 0;
            position: relative;
            top: -8px;
        }

        .info-campo {
            font-size: 6px;
            text-align: center;
            font-weight: bold;
            margin: 0;
        }

        .indicaciones {
            font-size: 6px;
            margin-left: 3px;
        }
    </style>
</head>

<body>
    <div class="Encabezado">
        <img class="imgEncabezado" src="{{ public_path('images/encabezadoFichaEpidemiologia.png') }}" alt="">
        <p>SISTEMA NACIONAL DE VIGILANCIA EN SALUD PÚBLICA - Subsistema de información Sivigila</p>
        <p>Ficha de notificación individual</p>
        @php
            $nombre_evento = $data['evento_sivigila']['nombre_evento'];
            $nombre_evento_codificado = '';
            switch ($nombre_evento) {
                case 'MALARIA':
                    $nombre_evento_codificado = 'Cod INS 456. Malaria';
                    break;

                default:
                    $nombre_evento_codificado = 'Datos básicos';
                    break;
            }
        @endphp
        <p><strong>{{ $nombre_evento_codificado }}</strong></p>
        <p>FOR-R02.0000-001 V:12 2024-03-01</p>
    </div>
    <p class="texto-pequeno">La ficha de notificación es para fines de vigilancia en salud pública y todas las entidades
        que participen en el proceso deben garantizarla confidencialidad de la información <strong>LEY 1273/09 y
            1266/09</strong> </p>
    <table>
        <tr>
            <th class="titulos">1. INFORMACIÓN GENERAL</th>
        </tr>
    </table>
    <table>
        <tr rowspan="3">
            <td colspan="1">
                <div class="sub-titulo">
                    <p>1.1 Código de la UPGD *</p>
                </div>
                @if ($data['consulta']['cita_no_programada'] == true)
                    @php
                        $codigo_habilitacion = (str_split($data['consulta']['rep']['codigo_habilitacion'], 1));
                        $numero_sede = $data['consulta']['rep']['numero_sede'] ?? '';
                        $departamento = $codigo_habilitacion[0] . $codigo_habilitacion[1];
                        $municipio = $codigo_habilitacion[2] . $codigo_habilitacion[3] . $codigo_habilitacion[4];
                        $codigo = $codigo_habilitacion[5] . $codigo_habilitacion[6] . $codigo_habilitacion[7] . $codigo_habilitacion[8] . $codigo_habilitacion[9];
                        $subindice = $numero_sede;

                    @endphp
                @else
                    @php
                        $numero_sede = $data['consulta']['rep']['numero_sede'] ?? '';
                        $departamento = $codigo_habilitacion[0] . $codigo_habilitacion[1];
                        $municipio = $codigo_habilitacion[2] . $codigo_habilitacion[3] . $codigo_habilitacion[4];
                        $codigo = $codigo_habilitacion[5] . $codigo_habilitacion[6] . $codigo_habilitacion[7] . $codigo_habilitacion[8] . $codigo_habilitacion[9];
                        $subindice = $numero_sede;
                    @endphp
                @endif
                <div class="contenedor">
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Departamento</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($departamento ?? ' ') as $depart)
                                    <td class="respuesta">{{ $depart }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Municipio</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($municipio ?? ' ') as $munici)
                                    <td class="respuesta">{{ $munici }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Código</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($codigo ?? ' ') as $codg)
                                    <td class="respuesta">{{ $codg }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Sub-Índice</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($subindice ?? ' ') as $subI)
                                <td class="respuesta">{{ $subI }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>Razón social de la unidad primaria generadora del dato *</p>
                </div>
                @if ($data['consulta']['cita_no_programada'] == true)
                    @php
                        $sede = $data['consulta']['rep']['nombre'] ?? ' ';
                    @endphp
                @else
                    @php
                        $sede = $data['consulta']['agenda']['consultorio']['rep']['nombre'] ?? ' ';
                    @endphp
                @endif
                <p class="respuesta">{{ $sede }}</p>
            </td>
        </tr>
        <tr rowspan="3">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>1.2 Nombre del evento *</p>
                </div>
                <div class="contenedor">
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Código del evento</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($data['cie10']['codigo_cie10']) as $letra)
                                    <td class="respuesta">{{ $letra }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>1.3 Fecha de la notificación *</p>
                </div>
                <div class="contenedor">
                    <div class="contenedor-cuadros">
                        @php
                            use Carbon\Carbon;
                            $fecha_notificacion = Carbon::parse($data['created_at']);
                            $fecha_formateada = $fecha_notificacion->format('d/m/Y');
                        @endphp
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($fecha_formateada) as $fecha)
                                    <td class="respuesta">{{ $fecha }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>

    </table>
    <table>
        <tr>
            <th class="titulos">2. IDENTIFICACIÓN DEL PACIENTE</th>
        </tr>
    </table>
    <table>
        <tr rowspan="8">
            <td colspan="5">
                <div class="sub-titulo">
                    <p>2.1 Tipo de documento *</p>
                </div>
                @php
                    $tipo_documento_id = $data['consulta']['afiliado']['tipo_documento'] ?? ' ';
                    $tipo_documentos = []; // Crear un array vacío por defecto

                    switch ($tipo_documento_id) {
                        case 1:
                            $tipo_documentos[] = 'CC'; // Cédula de ciudadanía
                            break;
                        case 2:
                            $tipo_documentos[] = 'TI'; // Tarjeta de identidad
                            break;
                        case 3:
                            $tipo_documentos[] = 'RC'; // Registro civil de nacimiento
                            break;
                        case 4:
                            $tipo_documentos[] = 'CE'; // Tarjeta de extranjería
                            break;
                        case 5:
                            $tipo_documentos[] = 'CE'; // Cédula de extranjería
                            break;
                        case 6:
                            $tipo_documentos[] = 'NIT'; // NIT
                            break;
                        case 7:
                            $tipo_documentos[] = 'PA'; // Pasaporte
                            break;
                        case 8:
                            $tipo_documentos[] = 'PE'; // Tipo documento extranjero
                            break;
                        case 9:
                            $tipo_documentos[] = 'PE'; // Permiso especial de permanencia
                            break;
                        case 10:
                            $tipo_documentos[] = 'PT'; // Permiso protección temporal
                            break;
                        case 11:
                            $tipo_documentos[] = 'SC'; // SalvoConducto
                            break;
                        case 12:
                            $tipo_documentos[] = 'CN'; // Certificado de Nacido Vivo
                            break;
                        case 13:
                            $tipo_documentos[] = 'AS'; // Adulto sin Identificación
                            break;
                        case 14:
                            $tipo_documentos[] = 'MS'; // Menor sin Identificar
                            break;
                        default:
                            $tipo_documentos[] = '';
                            break;
                    }
                @endphp

                <div class="contenedor-opciones">
                    @foreach (['RC', 'TI', 'CC', 'CE', 'PA', 'MS', 'AS', 'PE', 'CN', 'CD', 'SC', 'DE', 'PT'] as $tipo)
                        <label class="custom-radio">
                            <input class="opcion" type="radio" name="opcion" value="{{ $tipo }}"
                                @if (in_array($tipo, $tipo_documentos)) checked @endif />
                            <span class="radio-label">{{ $tipo }}</span>
                        </label>
                    @endforeach
                </div>
            </td>
            <td colspan="3">
                <div class="sub-titulo">
                    <p>2.2 Número de identificación *</p>
                </div>
                @php
                    $numero_documento = $data['consulta']['afiliado']['numero_documento'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $numero_documento }}</p>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="8">
                <p class="info-campo">*RC : REGISTRO CIVIL | TI : TARJETA IDENTIDAD | CC : CÉDULA CIUDADANÍA | CE :
                    CÉDULA EXTRANJERÍA |- PA : PASAPORTE | MS : MENOR SIN ID | AS
                    : ADULTO SIN ID | PE : PERMISO ESPECIAL DE PERMANENCIA | : CERTIFICADO DE NACIDO VIVO | CD: CARNÉ
                    DIPLOM£TICO | SC : SALVOCONDUCTO | DE :
                    DOCUMENTO EXTRANJERO | PT : PERMISO POR PROTECCION TEMPORAL
                </p>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="4">
                <div class="sub-titulo">
                    <p>2.3 Nombres y apellidos del paciente *</p>
                </div>
                @php
                    $nombre_completo = $data['consulta']['afiliado']['nombre_completo'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $nombre_completo }}</p>
            </td>
            <td colspan="4">
                <div class="sub-titulo">
                    <p>2.4 Teléfono *</p>
                </div>
                @php
                    $telefono = $data['consulta']['afiliado']['telefono'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $telefono }}</p>
            </td>
        </tr>

        <tr rowspan="8">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.5 Fecha de nacimiento (dd/mm/aaaa)*</p>
                </div>
                <div class="contenedor">
                    <div class="contenedor-cuadros">
                        @php
                            $fecha_nacimiento = Carbon::parse($data['consulta']['afiliado']['fecha_nacimiento']) ?? ' ';
                            $fecha_formateada = $fecha_nacimiento->format('d/m/Y');
                        @endphp
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($fecha_formateada) as $fecha)
                                    <td class="respuesta">{{ $fecha }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>2.6 Edad *</p>
                </div>
                @php
                    $edad_cumplida = $data['consulta']['afiliado']['edad_cumplida'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $edad_cumplida }}</p>
            </td>
            <td colspan="4">
                <div class="sub-titulo">
                    <p>2.7 Unidad de medida de la edad *</p>
                </div>
                @php
                    $unidadEdad = 'Años'
                @endphp

                <div class="contenedor-opciones">
                    @foreach (['Años' => '1. Años', '2. Meses', '3. Días', '4. Horas', '5. Minutos', '0. No aplica'] as $tipo => $descripcion)
                        <label class="custom-radio">
                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                @if ($unidadEdad === $tipo) checked @endif />
                            <span class="radio-label">{{ $descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>2.8 Nacionalidad *</p>
                </div>
                <div class="contenedor">
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Pais</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($data['consulta']['afiliado']['pais_afiliado']['codigo_dane'] ?? ' ') as $pais)
                                    <td class="respuesta">{{ $pais }}</td>
                                @endforeach
                            </tr>
                        </table>
                        <div class="etiqueta">Código</div>
                    </div>
                </div>
            </td>
        </tr>

        <tr rowspan="8">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.9 Sexo *</p>
                </div>
                @php
                    $sexo = $data['consulta']['afiliado']['sexo'] ?? ' ';
                @endphp

                <div class="contenedor-opciones">
                    @foreach (['M' => 'M.Hombre', 'F' => 'F.Mujer', 'I' => 'I.Indeterminado'] as $tipo => $descripcion)
                        <label class="custom-radio">
                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                @if ($sexo === $tipo) checked @endif />
                            <span class="radio-label">{{ $descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            </td>
            <td colspan="3">
                <div class="sub-titulo">
                    <p>2.10 Identidad de género</p>
                </div>
                @php
                    $identidad_genero = $data['consulta']['afiliado']['identidad_genero'] ?? ' ';
                @endphp

                <div class="contenedor-opciones">
                    @foreach (['Hombre' => '1. Hombre', 'Mujer' => '2. Mujer', 'Hombre trans' => '3. Hombre trans', 'Mujer trans' => '4. Mujer trans', 'Otra' => '5. Otra'] as $tipo => $descripcion)
                        <label class="custom-radio">
                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                @if ($identidad_genero === $tipo) checked @endif />
                            <span class="radio-label">{{ $descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            </td>
            <td colspan="3">
                <div class="sub-titulo">
                    <p>2.11 Orientación sexual</p>
                </div>
                @php
                    $orientacion_sexual = $data['consulta']['afiliado']['orientacion_sexual'] ?? ' ';
                @endphp

                <div class="contenedor-opciones">
                    @foreach (['Heterosexual' => 'Heterosexual', 'Gay/Lesbiana' => 'Gay/Lesbiana', 'Bisexual' => 'Bisexual', 'Otra' => 'Otra'] as $tipo => $descripcion)
                        <label class="custom-radio">
                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                @if ($orientacion_sexual === $tipo) checked @endif />
                            <span class="radio-label">{{ $descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="3">
                <div class="sub-titulo">
                    <p>2.12 País de procedencia/ocurrencia del caso *</p>
                </div>
                <p class="respuesta">Colombia / 169</p>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.13 Departamento y municipio de procedencia/ocurrencia del caso *</p>
                </div>
                @if ($data['consulta']['cita_no_programada'] == true)
                    @php
                        $municipio = $data['consulta']['rep']['municipio']['nombre'] ?? ' ';
                        $departamento = $data['consulta']['rep']['municipio']['departamento']['nombre'] ?? ' ';
                        $daneMunicipio = $data['consulta']['rep']['municipio']['codigo_dane'] ?? ' ';
                        $daneDepartamento = $data['consulta']['rep']['municipio']['departamento']['codigo_dane'] ?? ' ';
                    @endphp
                @else
                    @php
                        $municipio = $data['consulta']['agenda']['consultorio']['rep']['municipio']['nombre'] ?? ' ';
                        $departamento = $data['consulta']['agenda']['consultorio']['rep']['municipio']['departamento']['nombre']  ?? ' ';
                        $daneMunicipio = $data['consulta']['agenda']['consultorio']['rep']['municipio']['codigo_dane'] ?? ' ';
                        $daneDepartamento = $data['consulta']['agenda']['consultorio']['rep']['municipio']['departamento']['codigo_dane']  ?? ' ';
                    @endphp
                @endif
                <p class="respuesta">{{$departamento}} - {{$daneDepartamento}} / {{$municipio}} - {{$daneMunicipio}}</p>
            </td>
            <td colspan="3">
                <div class="sub-titulo">
                    <p>2.14 Área de procedencia/ocurrencia del caso *</p>
                </div>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.15 Localidad de procedencia/ocurrencia del caso</p>
                </div>
                @if ($data['consulta']['cita_no_programada'] == true)
                    @php
                        $localidad = $data['consulta']['rep']['direccion'] ?? ' ';
                    @endphp
                @else
                    @php
                        $localidad = $data['consulta']['agenda']['consultorio']['rep']['direccion'] ?? ' ';
                    @endphp
                @endif
                <p class="respuesta">{{ $localidad}}</p>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.16 Barrio de procedencia/ocurrencia del caso</p>
                </div>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.17 Centro poblado procedencia/ocurrencia del caso</p>
                </div>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.18 Vereda/zona procedencia/ocurrencia</p>
                </div>
                @if ($data['consulta']['cita_no_programada'] == true)
                    @php
                        $tipo_zona = $data['consulta']['rep']['tipo_zona'] ?? ' ';
                    @endphp
                @else
                    @php
                        $tipo_zona = $data['consulta']['agenda']['consultorio']['rep']['tipo_zona'] ?? ' ';
                    @endphp
                @endif
                <p class="respuesta">{{ $tipo_zona}}</p>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="1">
                <div class="sub-titulo">
                    <p>2.19 Ocupación del paciente *</p>
                </div>
                @php
                    $ocupacion = $data['consulta']['afiliado']['ocupacion'] ?? ' ';
                    $codigoOcupacion = $data['codigo_ciuo']
                @endphp
                <p class="respuesta">{{ $ocupacion }} / {{ $codigoOcupacion }}</p>
            </td>
            <td colspan="5">
                <div class="sub-titulo">
                    <p>2.20 Tipo de régimen en salud *</p>
                </div>
                @php
                    $entidad_id = $data['consulta']['afiliado']['entidad_id'] ?? ' ';
                @endphp

                <div class="contenedor-opciones">
                    @foreach ([1 => 'P. Excepción', 3 => 'C. Contributivo', 'N. No Asegurado', 'E. Especial', 'S. Subsidiado', 'I. Indeterminado/ pendiente'] as $tipo => $descripcion)
                        <label class="custom-radio">
                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                @if ($entidad_id === $tipo) checked @endif />
                            <span class="radio-label">{{ $descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.21 Nombre de la administradora de Planes de beneficios *</p>
                </div>
                @php
                    $entidad = $data['consulta']['afiliado']['entidad']['nombre'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $entidad }}</p>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="6">
                <div class="sub-titulo">
                    <p>2.22 Pertenencia étnica *</p>
                </div>
                @php
                    $etnia = $data['consulta']['afiliado']['etnia'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $etnia }}</p>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>2.23 Estrato</p>
                </div>
                @php
                    $estrato = $data['consulta']['afiliado']['estrato'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $estrato }}</p>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="8">
                <div class="sub-titulo">
                    <p>2.24 Grupos poblacionales a los que pertenece el paciente *</p>
                </div>
                @php
                    $discapacidad = $data['consulta']['afiliado']['discapacidad'] ?? ' ';
                    $grado_discapacidad = $data['consulta']['afiliado']['grado_discapacidad'] ?? ' ';
                @endphp
                <p class="respuesta">Discapacidad: {{ $discapacidad }} / {{ $grado_discapacidad }}</p>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <th class="titulos">NOTIFICACIÓN</th>
        </tr>
    </table>
    <table>
        <tr rowspan="8">
            <td colspan="5">
                <div class="sub-titulo">
                    <p>3.1 Fuente</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            1,
                            52,
                            92,
                            116,
                            140,
                            164,
                            211,
                            244,
                            286,
                            304,
                            360,
                            373,
                            412,
                            451,
                            484,
                            506,
                            658,
                            671,
                            696,
                            542,
                            594,
                            740,
                        ]))
                        <div class="contenedor-opciones">
                            @foreach (['Notificación rutinaria' => '1. Notificacin rutinaria', 'Búsqueda activa Inst.' => '2. Búsqueda activa Inst.', 'Vigilancia Intensificada' => '3. Vigilancia Intensificada', 'Búsqueda activa com.' => '4. Búsqueda activa com.', 'Investigaciones' => '5. Investigaciones'] as $tipo => $descripcion)
                                <label class="custom-radio">
                                    <input class="opcion" type="radio" value="{{ $tipo }}"
                                        @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                    <span class="radio-label">{{ $descripcion }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </td>
            <td colspan="3">
                <div class="sub-titulo">
                    <p>3.2 País, departamento y municipio de residencia del paciente *</p>
                </div>
                <div class="contenedor">
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Pais</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($data['consulta']['afiliado']['pais_afiliado']['codigo_dane'] ?? ' ') as $pais)
                                    <td class="respuesta">{{ $pais }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Departamento</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($data['consulta']['afiliado']['departamento_afiliacion']['codigo_dane']) as $departamento)
                                    <td class="respuesta">{{ $departamento }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-cuadros">
                        <div class="etiqueta">Municipio</div>
                        <table class="cuadritos">
                            <tr>
                                @foreach (str_split($data['consulta']['afiliado']['municipio_afiliacion']['codigo_dane']) as $municipio)
                                    <td class="respuesta">{{ $municipio }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="8">
                <div class="sub-titulo">
                    <p>3.3 Dirección de residencia *</p>
                </div>
                @php
                    $direcionResidencia = $data['consulta']['afiliado']['direccion'] ?? ' ';
                @endphp
                <p class="respuesta">{{ $direcionResidencia }}</p>
                {{--@foreach ($data['respuesta_sivigila'] as $respuesta)
                        @if (in_array($respuesta['campo_id'], [
                            2,
                            53,
                            93,
                            117,
                            141,
                            165,
                            212,
                            245,
                            287,
                            305,
                            361,
                            374,
                            413,
                            452,
                            485,
                            507,
                            659,
                            672,
                            697,
                            543,
                            595,
                        ]))
                        <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                    @endif
                @endforeach --}}
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>3.4 Fecha de consulta (dd/mm/aaaa)</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            3,
                            54,
                            94,
                            118,
                            142,
                            166,
                            213,
                            246,
                            288,
                            306,
                            362,
                            375,
                            414,
                            453,
                            486,
                            508,
                            660,
                            673,
                            698,
                            544,
                            596,
                            742,
                        ]))
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                @php
                                    $fecha_formateada = '';
                                    if (!empty($respuesta['respuesta_campo'])) {
                                        try {
                                            $fecha_consulta = Carbon::parse($respuesta['respuesta_campo']);
                                            $fecha_formateada = $fecha_consulta->format('d/m/Y');
                                        } catch (Exception $e) {
                                            $fecha_formateada = '';
                                        }
                                    }
                                @endphp
                                <table class="cuadritos">
                                    <tr>
                                        @if ($fecha_formateada)
                                            @foreach (str_split($fecha_formateada) as $fecha)
                                                <td class="respuesta">{{ $fecha }}</td>
                                            @endforeach
                                        @else
                                            @for ($i = 0; $i < 10; $i++)
                                                <td class="respuesta"></td>
                                            @endfor
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>3.5 Fecha de inicio de síntomas (dd/mm/aaaa)</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            4,
                            55,
                            95,
                            119,
                            143,
                            167,
                            214,
                            247,
                            289,
                            307,
                            363,
                            376,
                            415,
                            454,
                            487,
                            509,
                            661,
                            674,
                            699,
                            545,
                            597,
                            743,
                        ]))
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                @php
                                    $fecha_formateada = '';
                                    if (!empty($respuesta['respuesta_campo'])) {
                                        try {
                                            $fecha_sintomas = Carbon::parse($respuesta['respuesta_campo']);
                                            $fecha_formateada = $fecha_sintomas->format('d/m/Y');
                                        } catch (Exception $e) {
                                            $fecha_formateada = '';
                                        }
                                    }
                                @endphp
                                <table class="cuadritos">
                                    <tr>
                                        @if ($fecha_formateada)
                                            @foreach (str_split($fecha_formateada) as $fecha)
                                                <td class="respuesta">{{ $fecha }}</td>
                                            @endforeach
                                        @else
                                            @for ($i = 0; $i < 10; $i++)
                                                <td class="respuesta"></td>
                                            @endfor
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            </td>
            <td colspan="4">
                <div class="sub-titulo">
                    <p>3.6 Clasificación inicial de caso *</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            5,
                            56,
                            96,
                            120,
                            144,
                            168,
                            215,
                            248,
                            290,
                            308,
                            364,
                            377,
                            416,
                            455,
                            488,
                            510,
                            662,
                            675,
                            700,
                            546,
                            598,
                            744,
                        ]))
                        <div class="contenedor-opciones">
                            @foreach (['Sospechoso' => 'Sospechoso', 'Probable' => 'Probable', 'Conf. por laboratorio' => 'Conf. por laboratorio', 'Conf. Clínica' => 'Conf. Clínica', 'Conf. nexo epidemiológico' => 'Conf. nexo epidemiológico'] as $tipo => $descripcion)
                                <label class="custom-radio">
                                    <input class="opcion" type="radio" value="{{ $tipo }}"
                                        @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                    <span class="radio-label">{{ $descripcion }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>3.7 Hospitalizado *</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            6,
                            57,
                            97,
                            121,
                            145,
                            169,
                            216,
                            249,
                            291,
                            309,
                            365,
                            378,
                            417,
                            456,
                            489,
                            511,
                            663,
                            676,
                            701,
                            547,
                            599,
                            745,
                        ]))
                        <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                    @endif
                @endforeach
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>3.8 Fecha de hospitalización (dd/mm/aaaa)</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            7,
                            58,
                            98,
                            122,
                            146,
                            170,
                            217,
                            250,
                            292,
                            310,
                            366,
                            379,
                            418,
                            457,
                            490,
                            512,
                            664,
                            677,
                            702,
                            548,
                            600,
                            746,
                        ]))
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                @php
                                    $fecha_formateada = '';
                                    if (!empty($respuesta['respuesta_campo'])) {
                                        try {
                                            $fecha_hospitalizacion = Carbon::parse($respuesta['respuesta_campo']);
                                            $fecha_formateada = $fecha_hospitalizacion->format('d/m/Y');
                                        } catch (Exception $e) {
                                            $fecha_formateada = '';
                                        }
                                    }
                                @endphp
                                <table class="cuadritos">
                                    <tr>
                                        @if ($fecha_formateada)
                                            @foreach (str_split($fecha_formateada) as $fecha)
                                                <td class="respuesta">{{ $fecha }}</td>
                                            @endforeach
                                        @else
                                            @for ($i = 0; $i < 10; $i++)
                                                <td class="respuesta"></td>
                                            @endfor
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif

                @endforeach
            </td>
            <td colspan="4">
                <div class="sub-titulo">
                    <p>3.9 Condición final *</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            8,
                            59,
                            99,
                            123,
                            147,
                            171,
                            218,
                            251,
                            293,
                            311,
                            367,
                            380,
                            419,
                            458,
                            491,
                            513,
                            665,
                            678,
                            703,
                            549,
                            601,
                            747,
                        ]))
                        <div class="contenedor-opciones">
                            @foreach (['Vivo' => '1. Vivo', 'Muerto' => '2. Muerto', 'No sabe, no responde' => '3. No sabe, no responde'] as $tipo => $descripcion)
                                <label class="custom-radio">
                                    <input class="opcion" type="radio" value="{{ $tipo }}"
                                        @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                    <span class="radio-label">{{ $descripcion }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>3.10 Fecha de defunción (dd/mm/aaaa)</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            9,
                            60,
                            100,
                            124,
                            148,
                            172,
                            219,
                            252,
                            294,
                            312,
                            368,
                            381,
                            420,
                            459,
                            492,
                            514,
                            666,
                            679,
                            704,
                            550,
                            602,
                            748,
                        ]))
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                @php
                                    $fecha_formateada = '';
                                    if (!empty($respuesta['respuesta_campo'])) {
                                        try {
                                            $fecha_defuncion = Carbon::parse($respuesta['respuesta_campo']);
                                            $fecha_formateada = $fecha_defuncion->format('d/m/Y');
                                        } catch (Exception $e) {
                                            $fecha_formateada = '';
                                        }
                                    }
                                @endphp
                                <table class="cuadritos">
                                    <tr>
                                        @if ($fecha_formateada)
                                            @foreach (str_split($fecha_formateada) as $fecha)
                                                <td class="respuesta">{{ $fecha }}</td>
                                            @endforeach
                                        @else
                                            @for ($i = 0; $i < 10; $i++)
                                                <td class="respuesta"></td>
                                            @endfor
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            </td>
            <td colspan="1">
                <div class="sub-titulo">
                    <p>3.11 Número certificado de defunción</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            10,
                            61,
                            101,
                            125,
                            149,
                            173,
                            220,
                            253,
                            295,
                            313,
                            369,
                            382,
                            421,
                            460,
                            493,
                            515,
                            667,
                            680,
                            705,
                            551,
                            603,
                            749,
                        ]))
                        <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                    @endif
                @endforeach
            </td>
        </tr>
        <tr rowspan="8">
            <td colspan="2">
                <div class="sub-titulo">
                    <p>3.12 Causa básica de muerte</p>
                </div>
                @foreach ($data['respuesta_sivigila'] as $respuesta)
                    @if (in_array($respuesta['campo_id'], [
                            11,
                            62,
                            102,
                            126,
                            150,
                            174,
                            221,
                            254,
                            296,
                            314,
                            370,
                            383,
                            422,
                            461,
                            494,
                            516,
                            668,
                            681,
                            706,
                            552,
                            604,
                            750,
                        ]))
                        <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                    @endif
                @endforeach
            </td>
            <td colspan="4">
                <div class="sub-titulo">
                    <p>3.13 Nombre del profesional que diligenció la ficha *</p>
                </div>
                @php
                    $nombre_medico = $data['consulta']['medico_ordena']['operador']['nombre_completo'];
                @endphp
                <p class="respuesta">{{ $nombre_medico }}</p>
            </td>
            <td colspan="2">
                <div class="sub-titulo">
                    <p>3.14 Teléfono del profesional *</p>
                </div>
                @php
                    $telefono_meidco = $data['consulta']['medico_ordena']['operador']['telefono_recuperacion'];
                @endphp
                <p class="respuesta">{{ $telefono_meidco }}</p>
            </td>
        </tr>
    </table>
    @if ($data['evento_sivigila']['nombre_evento'] !== 'MALARIA')
        <table>
            <tr>
                <th class="titulos">ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES</th>
            </tr>
        </table>
        <table>
            <tr rowspan="3">
                <td colspan="2">
                    <div class="sub-titulo">
                        <p>4.1 Seguimiento y clasificación final del caso</p>
                    </div>
                    @foreach ($data['respuesta_sivigila'] as $respuesta)
                        @if (in_array($respuesta['campo_id'], [
                                12,
                                63,
                                103,
                                127,
                                151,
                                222,
                                255,
                                297,
                                315,
                                371,
                                384,
                                423,
                                462,
                                495,
                                669,
                                682,
                                707,
                                553,
                                605,
                                751,
                            ]))
                            <div class="contenedor-opciones">
                                @foreach (['No aplica' => '0. No aplica', 'Conf. por laboratorio' => '3. Conf. por laboratorio', 'Conf. Clínica' => '4. Conf. Clínica', 'Conf. nexo epidemiológico' => '5. Conf. nexo epidemiológico', 'Descartado' => '6. Descartado', 'Otra actualización' => '7. Otra actualización', 'Descartado por error de digitación' => 'D. Descartado por error de digitación'] as $tipo => $descripcion)
                                    <label class="custom-radio">
                                        <input class="opcion" type="radio" value="{{ $tipo }}"
                                            @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                        <span class="radio-label">{{ $descripcion }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </td>
                <td colspan="1">
                    <div class="sub-titulo">
                        <p>4.2 Fecha de ajuste (dd/mm/aaaa)</p>
                    </div>
                    @foreach ($data['respuesta_sivigila'] as $respuesta)
                        @if (in_array($respuesta['campo_id'], [
                                13,
                                64,
                                104,
                                128,
                                152,
                                223,
                                256,
                                298,
                                316,
                                372,
                                385,
                                424,
                                463,
                                496,
                                670,
                                683,
                                708,
                                554,
                                606,
                                752,
                            ]))
                            <div class="contenedor">
                                <div class="contenedor-cuadros">
                                    @php
                                        $fecha_formateada = '';
                                        if (!empty($respuesta['respuesta_campo'])) {
                                            try {
                                                $fecha_ajuste = Carbon::parse($respuesta['respuesta_campo']);
                                                $fecha_formateada = $fecha_ajuste->format('d/m/Y');
                                            } catch (Exception $e) {
                                                $fecha_formateada = '';
                                            }
                                        }
                                    @endphp
                                    <table class="cuadritos">
                                        <tr>
                                            @if ($fecha_formateada)
                                                @foreach (str_split($fecha_formateada) as $fecha)
                                                    <td class="respuesta">{{ $fecha }}</td>
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < 10; $i++)
                                                    <td class="respuesta"></td>
                                                @endfor
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </td>
            </tr>
        </table>
    @endif
    <div class="page-break"></div>
    @if (
        $data['evento_sivigila']['nombre_evento'] !== 'MALARIA' &&
            $data['evento_sivigila']['nombre_evento'] !== 'HEPATITIS A' &&
            $data['evento_sivigila']['nombre_evento'] !== 'VARICELA')

        <div class="Encabezado">
            <img class="imgEncabezado" src="{{ public_path('images/encabezadoFichaEpidemiologia.png') }}"
                alt="">
            <p>SISTEMA NACIONAL DE VIGILANCIA EN SALUD PÚBLICA - Subsistema de información Sivigila</p>
            <p>Ficha de notificación individual - Datos complementarios</p>
            @php
                $nombre_evento = $data['evento_sivigila']['nombre_evento'];
                $nombre_evento_codificado = '';

                switch ($nombre_evento) {
                    case 'ACCIDENTE OFIDICO':
                        $nombre_evento_codificado = 'Cod INS 100. Accidente ofidico';
                        break;
                    case 'AGRESIONES POR ANIMALES POTENCIALMENTE TRANSMISORES DE RABIA':
                        $nombre_evento_codificado =
                            'Cod INS 300. Agresiones por animales potencialmente transmisores de rabia';
                        break;
                    case 'CÁNCER DE CUELLO UTERINO':
                    case 'CÁNCER DE MAMA':
                        $nombre_evento_codificado = 'Cod INS 155. Cáncer de la mama y cuello uterino';
                        break;
                    case 'CÁNCER EN MENORES DE 18 AÑOS':
                        $nombre_evento_codificado = 'Cod INS 155. Cáncer en menores de 18 años';
                        break;
                    case 'DEFECTOS CONGENITOS':
                        $nombre_evento_codificado = 'Cod INS 215. Defectos congénitos';
                        break;
                    case 'DENGUE':
                        $nombre_evento_codificado =
                            'Cod INS 210. Dengue | Cod INS 200. Dengue grave | Cod INS 580. Mortalidad por dengue';
                        break;
                    case 'DESNUTRICION EN MENORES DE 5 AÑOS':
                        $nombre_evento_codificado = 'Cod INS 113. Desnutrición aguda en menores de 5 años';
                        break;
                    case 'ENFERMEDADES HUERFANAS - RARAS':
                        $nombre_evento_codificado = 'Cod INS 342. Enfermedades huérfanas - raras';
                        break;
                    case 'ENFERMEDADES TRANSMITIDAS POR ALIMENTOS':
                        $nombre_evento_codificado = 'Cod INS 355. Enfermedad transmitida por alimentos o agua (ETA)';
                        break;
                    case 'HEPATITIS B':
                    case 'HEPATITIS C':
                        $nombre_evento_codificado = 'Cod INS 340. Hepatitis B, C y coinfección hepatitis B y Delta';
                        break;
                    case 'INTOXICACIONES POR SUSTANCIAS QUIMICAS':
                        $nombre_evento_codificado = 'Cod INS 365. Intoxicaciones por sustancias químicas';
                        break;
                    case 'LEPTOSPIROSIS':
                        $nombre_evento_codificado = 'Cod INS 455. Leptospirosis';
                        break;
                    case 'MORBILIDAD MATERNA EXTREMA':
                        $nombre_evento_codificado = 'Cod INS 549. Morbilidad materna extrema';
                        break;
                    case 'TUBERCULOSIS':
                        $nombre_evento_codificado = 'Cod INS 813. Tuberculosis';
                        break;
                    case 'VIH - SIDA':
                        $nombre_evento_codificado = 'Cod INS 850. VIH/SIDA/Mortalidad por SIDA';
                        break;
                    case 'VIOLENCIAS DE GENERO':
                        $nombre_evento_codificado =
                            'Cod INS 875. Vigilancia en salud pública de la violencia de género e intrafamiliar';
                        break;
                    case 'LEISHMANIASIS':
                        $nombre_evento_codificado =
                            'Cod INS 420. Leishmaniasis cutánea | Cod INS 430. Leishmaniasis mucosa | Cod INS 440. Leishmaniasis visceral';
                        break;
                    default:
                        $nombre_evento_codificado = ' ';
                        break;
                }
            @endphp
            <p><strong>{{ $nombre_evento_codificado }}</strong></p>
            <p>FOR-R02.0000-075 V:03 2024-03-01</p>
        </div>

        <p class="texto-pequeno">La ficha de notificación es para fines de vigilancia en salud pública y todas las
            entidades que participen en el proceso deben garantizarla confidencialidad de la información <strong>LEY
                1273/09 y 1266/09</strong>
        </p>
        <table>
            <tr>
                <th class="titulos">RELACIÓN CON LOS DATOS BÁSICOS</th>
            </tr>
        </table>
        <table>
            <tr rowspan="5">
                <td colspan="2">
                    @php
                        $nombre_completo = $data['consulta']['afiliado']['nombre_completo'];
                    @endphp
                    <div class="sub-titulo">
                        <p>A. Nombres y apellidos del paciente:   {{ $nombre_completo }}</p>
                    </div>
                </td>
                <td colspan="1">
                    @php
                        $tipo_documento_id = $data['consulta']['afiliado']['tipo_documento'];
                        $tipo_documento_actual = '';

                        switch ($tipo_documento_id) {
                            case 1:
                                $tipo_documento_actual = 'CC'; // Cédula de ciudadanía
                                break;
                            case 2:
                                $tipo_documento_actual = 'TI'; // Tarjeta de identidad
                                break;
                            case 3:
                                $tipo_documento_actual = 'RC'; // Registro civil de nacimiento
                                break;
                            case 4:
                                $tipo_documento_actual = 'CE'; // Tarjeta de extranjería
                                break;
                            case 5:
                                $tipo_documento_actual = 'CE'; // Cédula de extranjería
                                break;
                            case 6:
                                $tipo_documento_actual = 'NIT'; // NIT
                                break;
                            case 7:
                                $tipo_documento_actual = 'PA'; // Pasaporte
                                break;
                            case 8:
                                $tipo_documento_actual = 'PE'; // Tipo documento extranjero
                                break;
                            case 9:
                                $tipo_documento_actual = 'PE'; // Permiso especial de permanencia
                                break;
                            case 10:
                                $tipo_documento_actual = 'PT'; // Permiso protección temporal
                                break;
                            case 11:
                                $tipo_documento_actual = 'SC'; // SalvoConducto
                                break;
                            case 12:
                                $tipo_documento_actual = 'CN'; // Certificado de Nacido Vivo
                                break;
                            case 13:
                                $tipo_documento_actual = 'AS'; // Adulto sin Identificación
                                break;
                            case 14:
                                $tipo_documento_actual = 'MS'; // Menor sin Identificar
                                break;
                            default:
                                $tipo_documento_actual = 'Desconocido'; // Tipo desconocido
                                break;
                        }
                    @endphp

                    <div class="sub-titulo">
                        <p>B. Tipo de ID:   {{ $tipo_documento_actual }}</p>
                    </div>
                </td>

                <td colspan="2">
                    @php
                        $numero_documento = $data['consulta']['afiliado']['numero_documento'];
                    @endphp
                    <div class="sub-titulo">
                        <p>C. Número de documento:   {{ $numero_documento }}</p>
                    </div>
                </td>
            </tr>
        </table>
    @endif

    @switch($data['evento_sivigila']['nombre_evento'])
        @case('ACCIDENTE OFIDICO')
            <table>
                <tr rowspan="6">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>5.1 Fecha del accidente (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [14]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_accidente = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_accidente->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 Dirección del lugar donde ocurrió el accidente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [15]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.3 Actividad que realizaba al momento del accidente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [16]))
                                <div class="contenedor-opciones">
                                    @foreach (['Recreación' => '1. Recreación', 'Actividad agrícola' => '2. Actividad agrícola', 'Oficios domésticos' => '3. Oficios domésticos', 'Recolección de desechos' => '5. Recolección de desechos', 'Actividad acuática' => '6. Actividad acuática', 'Otro' => '7. Otro', 'Caminar por senderos abiertos o trocha' => '8. Caminar por senderos abiertos o trocha'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [17]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.4 Tipo de atención inicial</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [18]))
                                <div class="contenedor-opciones">
                                    @foreach (['Incisión' => '1. Incisión', 'Punción' => '2. Punción', 'Sangría' => '3. Sangría', 'Torniquete' => '4. Torniquete', 'Inmovilización del enfermo' => '5. Inmovilización del enfermo', 'Inmovilización del miembro' => '6. Inmovilización del miembro', 'Succión mecánica' => '7. Succión mecánica', 'Otro' => '9. Otro'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [19]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.5 ¿La persona fue sometida a prácticas no médicas?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [20]))
                                <div class="contenedor-opciones">
                                    @foreach (['Pócimas' => '1. Pócimas', 'Rezos' => '2. Rezos', 'Emplastos de hierbas' => '3. Emplastos de hierbas', 'Succión bucal' => '6. Succión bucal', 'Ninguno' => '4. Ninguno', 'Otro' => '6. Otro'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [21]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.6 Localización de la mordedura</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [22]))
                                <div class="contenedor-opciones">
                                    @foreach (['Cabeza (cara)' => '1. Cabeza (cara)', 'Miembros superiores' => '2. Miembros superiores', 'Miembros inferiores' => '3. Miembros inferiores', 'Tórax anterior' => '4. Tórax anterior', 'Abdomen' => '5. Abdomen', 'Espalda' => '6. Espalda', 'Cuello' => '7. Cuello', 'Genitales' => '9. Genitales', 'Glúteos' => '10. Glúteos', 'Dedos de pie y de mano' => '11. Dedos de pie y de mano', 'Dedos de mano' => '12. Dedos de mano'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.7 ¿Hay evidencia de huellas de colmillos?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [23]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.8 ¿La persona vió la serpiente que la mordió?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [24]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.9 ¿Se capturó la serpiente?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [25]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.10 Agente agresor, identificación género</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [26]))
                                <div class="contenedor-opciones">
                                    @foreach (['Bothrops' => '1. Bothrops', 'Crotalus' => '2. Crotalus', 'Micrurus' => '3. Micrurus', 'Lachesis' => '4. Lachesis', 'Pelamis (serpiente de mar)' => '7. Pelamis (serpiente de mar)', 'Colubrido' => '8. Colubrido', 'Sin identificar' => '9. Sin identificar', 'Otro' => '6. Otro'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [27]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.11 Agente agresor, nombre común</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [28]))
                                <div class="contenedor-opciones">
                                    @foreach (['Mapaná' => '1. Mapaná', 'Equis' => '2. Equis', 'Cuatro narices' => '3. Cuatro narices', 'Cabeza de candado' => '4. Cabeza de candado', 'Rabo de chucha' => '5. Rabo de chucha', 'Verrugosa o rieca' => '6. Verrugosa o rieca', 'Víbora de pestaña' => '7. Víbora de pestaña', 'Rabo de ají' => '8. Rabo de ají', 'Veintricuatro' => '9. Veintricuatro', 'Jergón' => '10. Jergón', 'Jararacá' => '11. Jararacá', 'Cascabel' => '12. Cascabel', 'Coral' => '13. Coral', 'Boca dorada' => '14. Boca dorada', 'Patoco/patoquilla' => '16. Patoco/patoquilla', 'Desconocido' => '16. Desconocido', 'Otro' => '15. Otro'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [29]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">CUADRO CLÍNICO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.1 Manifestaciones locales (marque con una X las que se presenten)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [30]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Edema', 'Dolor', 'Eritema', 'Flictenas', 'Parestesias/hipoestesias', 'Equimosis', 'Hematomas', 'Otro'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [31]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.2 Manifestaciones sistémicas (marque con una X las que se presenten)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [32]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Náusea', 'Hipotensión', 'Debilidad muscular', 'Hematemesis', 'Dificultad para hablar', 'Vómito', 'Dolor abdominal', 'Oliguria', 'Hematuria', 'Disfagia', 'Sialorrea', 'Fascies neurotóxica', 'Cianosis', 'Hematoquexia', 'Diarrea', 'Alteraciones de la visión', 'Epistaxis', 'Vértigo', 'Bradicardia', 'Alteración sensorial', 'Gingivorragia', 'Ptosis palpebral', 'Otro'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [33]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.3 Complicaciones locales (marque con una X las que se presenten)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [34]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Celulitis', 'Absceso', 'Necrosis', 'Mionecrosis', 'Fasceitis', 'Alteraciones en la circulación/perfusión', 'Síndrome compartimental', 'Otro'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [35]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.4 Complicaciones sistémicas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [36]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Anemia aguda severa', 'Edema cerebral', 'Shock hipovolémico', 'Falla ventilatoria', 'Shock séptico', ',Coma', 'IRA', 'CID', 'Hemorragia intracraneana', 'Otro'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [37]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.5 Gravedad del accidente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [38]))
                                <div class="contenedor-opciones">
                                    @foreach (['Leve' => '1. Leve', 'Moderado' => '2. Moderado', 'Grave' => '3. Grave', 'No envenenamiento' => '4. No envenenamiento'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">ATENCIÓN HOSPITALARIA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">A. Tratamiento específico (suero antiofídico)</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.1 ¿Empleó Suero?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [39]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.2 Tiempo transcurrido</p>
                        </div>
                        <p class="indicaciones">Registre el número de días u horas
                            transcurridas entre la mordedura y la
                            administración del suero
                        </p>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [40]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">Días</div>
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [41]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">Horas</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.3 Tipo de suero antiofídico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [42]))
                                <div class="contenedor-opciones">
                                    @foreach (['Antiviperido (Bothrops, Lachesis, Crotálus)' => '1. Antiviperido (Bothrops, Lachesis, Crotálus)', 'Anti-elapidídico (Micrurus sp: coral verdadera)' => '2. Anti-elapidídico (Micrurus sp: coral verdadera)'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.4 Fabricante</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [43]))
                                <div class="contenedor-opciones">
                                    @foreach (['Probiol' => '1. Probiol', 'Bioclon' => '2. Bioclon', 'INS (Instituto Nacional de salud)' => '3. INS (Instituto Nacional de salud)', 'Otro' => '4. Otro'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.4.1 ¿Cuál?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [44]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.4.2 Lote</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [45]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.5 Reacciones a la aplicación del suero</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [46]))
                                <div class="contenedor-opciones">
                                    @foreach (['Ninguna' => '1. Ninguna', 'Localizada' => '2. Localizada', 'Generalizada' => '3. Generalizada'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.6 Dosis de suero (ampollas)</p>
                        </div>
                        <p class="indicaciones">Registre el número de ampollas
                            suministradas al paciente en el espacio señalado
                        </p>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [47]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.7 Tiempo de administración de suero</p>
                        </div>
                        <p class="indicaciones">Registre el número de horas o minutos que
                            demoró la administración de suero antiofídico
                        </p>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [48]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">Horas</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.8 ¿Remitido a otra institución?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [49]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <th colspan="1" class="titulo-campo">B. Otros tratamientos médicos</th>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.9 Tratamiento quirúgico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [50]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.10 Tipo de tratamiento quirúgico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [51]))
                                <div class="contenedor-opciones">
                                    @foreach (['Drenaje de absceso' => '1. Drenaje de absceso', 'Limpieza quirúrgica' => '2. Limpieza quirúrgica', 'Desbridamiento' => '3. Desbridamiento', 'Fasciotomia' => '4. Fasciotomia', 'Injerto de piel' => '5. Injerto de piel', 'Amputación' => '6. Amputación'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('AGRESIONES POR ANIMALES POTENCIALMENTE TRANSMISORES DE RABIA')
            <table>
                <tr>
                    <th class="titulos">DATOS DE LA AGRESIÓN O CONTACTO, DE LA ESPECIE AGRESORA Y DE LA CLASIFICACIÓN DE LA
                        EXPOSICIÓN</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>5.1 Tipo de agresión o contacto</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [65]))
                                <div class="contenedor-opciones">
                                    @foreach (['Mordedura' => '1. Mordedura', 'Arañazo o rasguño' => '2. Arañazo o rasguño', 'Contacto de mucosa o piel lesionada con saliva infectada con virus rábico' => '3. Contacto de mucosa o piel lesionada con saliva infectada con virus rábico', 'Contacto de mucosa o piel lesionada, con tejido nervioso, material biológico o secreciones infectadas con virus rábico' => '6. Contacto de mucosa o piel lesionada, con tejido nervioso, material biológico o secreciones infectadas con virus rábico', 'Inhalación en ambientes cargados o virus rábico (aerosoles)' => '7. Inhalación en ambientes cargados o virus rábico (aerosoles)', 'Trasplante de órganos o tejidos infectados con virus rábico' => '8. Trasplante de órganos o tejidos infectados con virus rábico'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Si marco 1, mordedura, seleccione área</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [66]))
                                <div class="contenedor-opciones">
                                    @foreach (['Drenaje de absceso', 'Amputación'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 ¿Agresión provocada?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [67]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.3. Tipo de lesión</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [68]))
                                <div class="contenedor-opciones">
                                    @foreach (['Única' => '1. Única', 'Múltiple' => '2. Múltiple'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.4 Profundidad</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [69]))
                                <div class="contenedor-opciones">
                                    @foreach (['Superficial' => '1. Superficial', 'Profunda' => '2. Profunda'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>55.5. Localización anatómica de la lesión (señale m·s de una en caso necesario)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [70]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Cabeza - cara - cuello', 'Manos - dedos', 'Tronco', 'Miembros superiores', 'Miembros inferiores', 'Pies - dedos', 'Genitales externos'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>55.6 Fecha de la agresión o contacto (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [71]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_agresion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_agresion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.7 Especie agresora</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [72]))
                                <div class="contenedor-opciones">
                                    @foreach (['Perro' => '1. Perro', 'Gato' => '2. Gato', 'Bovino-Bufalino' => '3. Bovino-Bufalino', 'Equidos' => '4. Equidos', 'Porcino (cerdo)' => '5. Porcino (cerdo)', 'Murciélago' => '7. Murciélago', 'Zorro' => '8. Zorro', 'Mico' => '9. Mico', 'Humano' => '10. Humano', 'Otros silvestres' => '12. Otros silvestres', 'Ovino-Caprino' => '13. Ovino-Caprino', 'Grandes roedores' => '14. Grandes roedores'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.8 Animal vacunado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [73]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No', 'Desconocido' => '3. Desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.9 ¿Presentó carné de vacunación antirrábica?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [74]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.10 Fecha de vacunación (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [75]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_agresion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_agresion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.11 Nombre del propietario o responsable del agresor:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [76]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>5.12 Dirección del propietario o responsable del agresor:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [77]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.13 Teléfono del propietario</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [78]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.14 Estado del animal al momento de la agresión o contacto</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [79]))
                                <div class="contenedor-opciones">
                                    @foreach (['Con signos de rabia' => '1. Con signos de rabia', 'Sin signos de rabia' => '2. Sin signos de rabia', 'Desconocido' => '3. Desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.15 Estado del animal al momento de la consulta</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [80]))
                                <div class="contenedor-opciones">
                                    @foreach (['Vivo' => '1. Vivo', 'Muerto' => '2. Muerto', 'Desconocido' => '3. Desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.16 Ubicación del animal agreso</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [81]))
                                <div class="contenedor-opciones">
                                    @foreach (['Observable' => '1. Observable', 'Perdido' => '2. Perdido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.17 Tipo de exposición</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [82]))
                                <div class="contenedor-opciones">
                                    @foreach (['No exposición' => '1. No exposición', 'Exposición leve' => '2. Exposición leve', 'Exposición grave' => '3. Exposición grave'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">ANTECEDENTES DE INMUNIZACIÓN DEL PACIENTE</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>Antes de La consulta actual el paciente había recibido:</p>
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.1 Suero antirrábico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [83]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.2 Fecha de aplicación (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [84]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_aplicacion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_aplicacion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.3 Vacuna antirrábica</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [85]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No', 'No sabe' => 'No sabe'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.4 Número de dosis</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [86]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.5 Fecha de ̇última dosis (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [87]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_ultima_dosis = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_ultima_dosis->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DEL TRATAMIENTO ORDENADO EN LA ACTUALIDAD</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.1 ¿Lavado de herida con agua y jabón?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [88]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.2 ¿Sutura de la herida?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [89]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.3 ¿Ordenó suero antirrábico?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [90]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.4 ¿Ordenó aplicación vacuna?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [91]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('CÁNCER DE CUELLO UTERINO')
        @case('CÁNCER DE MAMA')
            <table>
                <tr>
                    <th class="titulos">DATOS ESPECÍFICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">5 Tipo de cáncer</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.1. Tipo:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [105, 129]))
                                <div class="contenedor-opciones">
                                    @foreach (['CA Mama' => '1. CA Mama', 'CA Cuello uterino' => '2. CA Cuello uterino', 'Ambos' => '3. Ambos'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.2.1 Fecha de procedimiento (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [106, 130]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_procedimiento = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_ultima_dosis->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.2.2 Fecha resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [107, 131]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.2.3. Resultado biopsia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [108, 132]))
                                <div class="contenedor-opciones">
                                    @foreach (['Carcinoma ductal' => '1. Carcinoma ductal', 'Carcinoma lobulillar' => '2. Carcinoma lobulillar'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.2.3.1 Grado histopatológico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [109, 133]))
                                <div class="contenedor-opciones">
                                    @foreach (['In-situ' => '1. In-situ', 'Infiltrante' => '2. Infiltrante', 'No indicado' => '3. No indicado'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">5.3. Examen de confirmación diagnóstica de cáncer de cuello
                        uterino</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3.1 Fecha de toma de muestra (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [110, 134]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_toma_muestra = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_toma_muestra->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3.2. Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [111, 135]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3.3 Resultado de la biopsia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [112, 136]))
                                <div class="contenedor-opciones">
                                    @foreach (['LEI AG NCIII / In situ' => '1. LEI AG NCIII / In situ', 'Carcinoma escamocelular' => '2. Carcinoma escamocelular', 'Adenocarcinoma o mixtos' => '3. Adenocarcinoma o mixtos'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3.4 Grado histopatológico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [113, 137]))
                                <div class="contenedor-opciones">
                                    @foreach (['In-situ' => '1. In-situ', 'Invasor /Infiltrante (Figo IA o IB2)' => '2. Invasor /Infiltrante (Figo IA o IB2)', 'Invasor /Infiltrante (Figo >= IB3)' => '3. Invasor /Infiltrante (Figo >= IB3)', 'No indicado' => '4. No indicado'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.4 Tratamiento</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [114, 138]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.4.1 Fecha de inicio del tratamiento (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [115, 139]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_inicio_tratamiento = Carbon::parse(
                                                        $respuesta['respuesta_campo'],
                                                    );
                                                    $fecha_formateada = $fecha_inicio_tratamiento->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('CÁNCER EN MENORES DE 18 AÑOS')
            <table>
                <tr>
                    <th class="titulos">TIPO DE CÁNCER</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.1. Tipo de cáncer</p>
                        </div>
                        <p class="indicaciones">(marque con una X el grupo que corresponda según la presunción diagnóstica)</p>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [153]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Leucemia linfoide aguda', 'Leucemia mieloide aguda', 'Otras leucemias', 'Linfomas y neoplasias reticuloendoteliales', 'Tumores del sistema nervioso central', 'Neuroblastoma y otros tumores de células nerviosas periféricas', 'Retinoblastoma', 'Tumores renales', 'Tumores hepáticos', 'Tumores óseos malignos', 'Sarcomas de tejidos blandos y extra óseos', 'Tumores germinales trofoblásticos y otros gonadales', 'Tumores epiteliales malignos y melanoma', 'Otras neoplasias malignas no especificadas'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 Fecha de inicio de tratamiento(dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [154]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_inicio_tratamiento = Carbon::parse(
                                                        $respuesta['respuesta_campo'],
                                                    );
                                                    $fecha_formateada = $fecha_inicio_tratamiento->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.3 ¿Consulta actual por segunda neoplasia?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [155]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.4 ¿Consulta actual por recaída?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [156]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.5 Fecha de diagnóstico Inicial (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [157]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_diagnostico_inicial = Carbon::parse(
                                                        $respuesta['respuesta_campo'],
                                                    );
                                                    $fecha_formateada = $fecha_diagnostico_inicial->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LABORATORIO - MÉTODOS DIAGNÓSTICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.1 Criterio de diagnóstico probable</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [158]))
                                <div class="contenedor-opciones">
                                    @foreach (['Extendido de sangre periférica' => '1. Extendido de sangre periférica', 'Radiología diagnóstica' => '2. Radiología diagnóstica', 'Gammagrafía' => '3. Gammagrafía', 'Marcadores tumorales' => '5. Marcadores tumorales', 'Clínica sin otra ayuda diagnóstica' => '5. Clínica sin otra ayuda diagnóstica'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.1.1 Fecha de toma (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [159]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_toma = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_toma->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.1.2 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [160]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.2 Criterio de confirmación del diagnóstico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [161]))
                                <div class="contenedor-opciones">
                                    @foreach (['Mielograma' => '1. Mielograma', 'Histopatología o citología de fluido corporal' => '2. Histopatología o citología de fluido corporal', 'Inmunotipificación' => '3. Inmunotipificación', 'Criterio médico especializado' => '4. Criterio médico especializado', 'Certificado de defunción' => '5. Certificado de defunción', 'Citogenética' => '7. Citogenética', 'Radiología diagnóstica' => '8. Radiología diagnóstica'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.2.1 Fecha de toma (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [162]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_toma = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_toma->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.2.2 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [163]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('DEFECTOS CONGENITOS')
            <table>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>A. Nombres y apellidos del paciente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [177]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>B. Tipo de ID*</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [178]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>C. Número de identificación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [179]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>D. Nombres y apellidos de la madre</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [180]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>E. Tipo de ID*</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [181]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>F. Número de identificación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [541]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>G. Edad</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [182]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">INFORMACÓN MATERNA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.1 Número de embarazos totales</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [183]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.2 Nacidos vivos</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [184]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.3 Abortos (<22 sem)</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [185]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.4 Mortinatos (>=22)</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [186]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.5 Diagnóstico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [187]))
                                <div class="contenedor-opciones">
                                    @foreach (['Prenatal' => '1. Prenatal', 'Postnatal' => '2. Postnatal'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.5.1 Edad gestacional al diagnóstico</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [188]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.6 Patología crónica adicional o complicaciones durante el embarazo:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [189]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuáles?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [190]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">INFORMACIÓN COMPLEMENTARIA DEL NIÑO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.1 Embarazo múltiple</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [191]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.2 Nativivo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [192]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No', 'No ha nacido' => '3. No ha nacido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.3 Edad Gestacional al momento del nacimiento</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [193]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.4 Peso (Gramos) al nacer</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [194]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.5 Perímetro cefálico</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [195]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">cm</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DEFECTOS CONGÉNITOS</th>
                </tr>
            </table>
            <p class="texto-pequeno">Registre los defectos congénitos de acuerdo a la priorización del anexo 2 del
                protocolo de vigilancia</p>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">7.1 Defectos metabólicos (incluye el hipotiroidismo congénito)
                    </th>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.1.1 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [196]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">7.2. Defectos sensoriales</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.2.1 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [197]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.2.2 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [198]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">7.3 Malformaciones congénitas (Reporte las malformaciones en
                        orden de gravedad)</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.3.1 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [199]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.3.2 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [200]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.3.3 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [201]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.3.4 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [202]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.3.5 Descripción</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [203]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LABORATORIO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>8.1 STORCH en recién nacido</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [204]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">8.2 Hipotiroidismo exámenes de tamizaje y confirmación</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2.1 TSH</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [205]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2.2 T4 Total suero</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [207]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2.3 T4 libre suero</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [209]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">8.3 Resultado</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3.1 TSH</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [206]))
                                <div class="contenedor-opciones">
                                    @foreach (['Alto' => '1. Alto', 'Normal' => '2. Normal'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3.2 T4 Total Suero</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [208]))
                                <div class="contenedor-opciones">
                                    @foreach (['Bajo' => '1. Bajo', 'Normal' => '2. Normal'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3.3 T4 Libre Suero</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [2010]))
                                <div class="contenedor-opciones">
                                    @foreach (['Bajo' => '1. Bajo', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('DENGUE')
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="info-campos">
                            <p>Los casos probables y confirmados de dengue deben notificarse semanalmente de acuerdo con
                                la estructura y contenidos mínimos
                                establecidos, en el subsistema de informacióin para la vigilancia de los eventos de
                                interés en salud pública. La notificación de los casos de
                                dengue grave y mortalidad por dengue se exige desde su clasificación como probables, y
                                en el nivel local es inmediata.</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS ESPECÍFICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.1 ¿Desplazamiento en los últimos 15 días?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [224]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>5.1.1 País/Municipio/departamento al que se desplazó</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [225]))
                                    <div class="contenedor-cuadros">
                                        <div class="etiqueta">País</div>
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [227]))
                                    <div class="contenedor-cuadros">
                                        <div class="etiqueta">Departamento</div>
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [226]))
                                    <div class="contenedor-cuadros">
                                        <div class="etiqueta">Municipio</div>
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.2. ¿Algún familiar o conviviente ha tenido sintomatología de dengue en los últimos 15 días?
                            </p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [228]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No', 'Desconocido' => '3. Desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.3 Nombre del establecimiento donde estudia o trabaja:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [229]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS PARA CLASIFICACIÓN DEL DENGUE</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>Marque con X los que se presenten</p>
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Dengue sin signos de alarma</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [230]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Fiebre', 'Cefalea', 'Dolor retroocular', 'Mialgias', 'Artralgias', 'Erupción o rash'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Dengue con signos de alarma</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [231]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Dolor abdominal intenso y continuo', 'Vómito persistente', 'Diarrea', 'Somnolencia o irritabilidad', 'Hipotensión', 'Hepatomegalia', 'Hemorragias importantes en mucosas', 'Hipotermia', 'Aumento del hematocrito', 'Caída de plaquetas (<100.000)', 'Acumulación de líquidos'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Dengue grave</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [232]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Extravasación severa de plasma', 'Hemorragia con compromiso hemodinámico', 'Shock por dengue', 'Daño grave de órganos'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">CLASIFICACIÓN FINAL Y ATENCION DEL CASO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.1 Clasificación final:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [233]))
                                <div class="contenedor-opciones">
                                    @foreach (['No aplica' => '0. No aplica', 'Dengue sin signos de alarma' => '1. Dengue sin signos de alarma', 'Dengue con signos de alarma' => '2. Dengue con signos de alarma', 'Dengue grave' => '3. Dengue grave'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.2 Conducta</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [234]))
                                <div class="contenedor-opciones">
                                    @foreach (['No aplica' => '0. No aplica', 'Ambulatoria' => '1. Ambulatoria', 'Hospitalización piso' => '2. Hospitalización piso', 'Unidad de cuidados intensivos' => '3. Unidad de cuidados intensivos', 'Observación' => '4. Observación', 'Remisión para hospitalización' => '5. Remisión para hospitalización'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">EN CASO DE MORTALIDAD POR DENGUE</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>8.1 Muestras</p>
                            <p class="indicaciones">Marque con una X las muestras tomadas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [235]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Tejido', 'Hígado', 'Cerebro', 'Bazo', 'Pulmón', 'Miocardio', 'Médula', 'Riñón'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LABORATORIO</th>
                </tr>
            </table>
            <p class="texto-pequeno"><strong>La información relacionada con laboratorios debe ingresarse a través del
                    modulo de laboratorios del aplicativo sivigila</strong> </p>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.1 Fecha toma de examen (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [236]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_toma_examen = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_toma_examen->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.2 Fecha de recepción(dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [237]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_recepcion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_recepcion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.3 Muestra</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [238]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (['Tejido' => '4', 'Suero' => '13'] as $tipo => $descripcion)
                                                    @if ($respuesta['respuesta_campo'] === $tipo)
                                                        <td class="respuesta">{{ $descripcion }}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.4 Prueba</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [239]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['PCR' => '4', 'E0 Elisa NS1' => 'E0', 'igM' => '2', 'igG' => '3', 'Aislamiento viral' => '5'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.5 Agente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [240]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['Dengue' => '3'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.6 Resultado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [241]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['Positivo' => '1', 'Negativo' => '2', 'No procesado' => '3', 'Inadecuado' => '4', 'Valor registrado' => '6'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.7 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [242]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.8 Valor</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [243]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
        @break

        @case('DESNUTRICION EN MENORES DE 5 AÑOS')
            <table>
                <tr>
                    <th class="titulos">DATOS DE LA MADRE O CUIDADOR</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.1 Primer nombre</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [257]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 Segundo nombre</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [258]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.3 Primer apellido</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [259]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.4 Segundo apellido</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [260]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.5 Tipo de ID*</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [261]))
                                <div class="contenedor-opciones">
                                    @foreach (['RC', 'TI', 'CC', 'CE', 'PA', 'MS', 'AS', 'PE', 'PT'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $descripcion }}"
                                                @if ($respuesta['respuesta_campo'] === $descripcion) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.6 Número de identificación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [262]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="8">
                        <p class="info-campo">*RC : REGISTRO CIVIL | TI : TARJETA IDENTIDAD | CC : CÉDULA CIUDADANÍA | CE :
                            CÉDULA EXTRANJERÍA |- PA : PASAPORTE | MS : MENOR SIN ID | AS
                            : ADULTO SIN ID | PE : PERMISO ESPECIAL DE PERMANENCIA | : CERTIFICADO DE NACIDO VIVO | CD:
                            CARNÉ DIPLOM£TICO | SC : SALVOCONDUCTO | DE :
                            DOCUMENTO EXTRANJERO | PT : PERMISO POR PROTECCION TEMPORAL
                        </p>
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.7 Nivel educativo de la madre o cuidador*</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [263]))
                                <div class="contenedor-opciones">
                                    @foreach (['Primaria' => '1. Primaria', 'Secundaría' => '2. Secundaría', 'Técnica' => '3. Técnica', 'Universitaria' => '4. Universitaria', 'Ninguno' => 'Ninguno'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.8 Número hijos < 5 añosos</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [264]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">IDENTIFICACIÓN DE FACTORES</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.1 Peso al nacer</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [265]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">g</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.2 Talla al nacer</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [266]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">cm</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.3 Edad gestacional al nacer</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [267]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">semanas</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.4 Tiempo que recibió leche materna</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [268]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">meses</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.5 Edad inicio alimentación complementaria</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [269]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">g</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.6 Inscrito a crecimiento y desarrollo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [270]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.7 ¿Esquema de vacunación completo a la edad?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [271]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No', 'Desconocido' => '3. Desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.7.1 Referido por carné de vacunación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [272]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.8 Peso actual</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [273]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">Kg</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.9 Talla actual</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [274]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">CM</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.10 Circunferencia media del brazo ( ≥ 6cm y ≤ 30cm)</p>
                        </div>
                        <p class="indicaciones">Mayores de 6 meses hasta 59 meses</p>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [275]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">cm</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.11 Resultado de la prueba de apetito</p>
                        </div>
                        <p class="indicaciones">Mayores de 6 meses</p>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [276]))
                                <div class="contenedor-opciones">
                                    @foreach (['Positiva' => '1. Positiva', 'Negativa' => '2. Negativa', 'No se realizó' => '3. No se realizó'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">SIGNOS CLÍNICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.1 ¿Edema?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [277]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.2 ¿Desnutrición emaciación o delgadez visible?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [278]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.3 ¿Piel reseca o áspera?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [279]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.4 ¿Hipo o hiperpigmentación de la piel?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [280]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.5 ¿Cambios en el cabello?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [281]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.6 ¿Anemia detectada por palidez palmar o de mucosas?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [282]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">RUTA DE ATENCIÓN</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>8.1 Activación ruta de atención</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [283]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>8.2 Tipo de atención suministrada</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [284]))
                                <div class="contenedor-opciones">
                                    @foreach (['Intrahospitalaria' => '1. Intrahospitalaria', 'Comunitaria' => '2. Comunitaria'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="8">
                        <div class="sub-titulo">
                            <p>8.3 Diagnóstico médico</p>
                        </div>
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach (str_split($data['cie10']['codigo_cie10']) as $letra)
                                            <td class="respuesta">{{ $letra }}</td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [285]))
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        @break

        @case('ENFERMEDADES HUERFANAS - RARAS')
            <table>
                <tr>
                    <th class="titulos">DATOS COMPLEMENTARIOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="5">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.1 Nivel educativo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [299]))
                                <div class="contenedor-opciones">
                                    @foreach (['Preescolar' => '1. Preescolar', 'Básica Primaria' => '2. Básica Primaria', 'Básica Secundaria' => '3. Básica Secundaria', 'Media Académica o Clásica' => '4. Media Académica o Clásica', 'Media Técnica (Bachillerato Técnico)' => '5. Media Técnica (Bachillerato Técnico)', 'Normalista' => '6. Normalista', 'Técnica Profesional' => '7. Técnica Profesional', 'Tecnológica' => '8. Tecnológica', 'Profesional' => '9. Profesional', 'Especialización' => '10. Especialización', 'Maestría' => '11. Maestría', 'Doctorado' => '12. Doctorado', 'Ninguno' => '13. Ninguno'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="5">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.2 Otros grupos poblacionales</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [300]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Trabajador urbano', 'Trabajador rural', 'Jóvenes vulnerables rurales', 'Jóvenes vulnerables urbanos', 'Discapacitado - el sistema nervioso', 'Discapacitado - los ojos', 'Discapacitado - los oídos', 'Discapacitado - los demás órganos de los sentidos (olfato - tacto y gusto)', 'Discapacitado - la voz y el habla', 'Discapacitado - el sistema cardiorrespiratorio y las defensas', 'Discapacitado - la digestión - el metabolismo - las hormonas', 'Discapacitado - el sistema genital y reproductivo', 'Discapacitado - el movimiento del cuerpo - manos - brazos - piernas', 'Discapacitado - la piel', 'Discapacitado - otro', 'ND = no definido'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="5">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.3 Fecha de diagnóstico de la enfermedad (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [301]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_diagnostico_enfermedad = Carbon::parse(
                                                        $respuesta['respuesta_campo'],
                                                    );
                                                    $fecha_formateada = $fecha_diagnostico_enfermedad->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3.1 ¿Cuál prueba confirmatoria?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [302]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="5">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>5.4 Nombre de la enfermedad</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [303]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('ENFERMEDADES TRANSMITIDAS POR ALIMENTOS')
            <table>
                <tr>
                    <th class="titulos">DATOS CLÍNICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.1 Signos y síntomas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [317]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Naúseas', 'Vómito', 'Diarrea', 'Fiebre', 'Calambres abdominales', 'Cefalea', 'Deshidratación', 'Cianosis', 'Mialgias', 'Artralgias', 'Mareo', 'Lesiones maculopapulares', 'Escalofrio', 'Parestesias', 'Sialorrea', 'Espasmos musculares', 'Otros'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.2 Sí marcó otros. registre cuál</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [318]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3 Hora de inicio de los síntomas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [319]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                    <div class="etiqueta">Hora</div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LA EXPOSICIÓN</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.1 Alimentos ingeridos el día de los síntomas</p>
                        </div>
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [320]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [321]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [322]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [323]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [324]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [325]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [326]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [327]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [328]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.2 Alimentos ingeridos el día anterior</p>
                        </div>
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [329]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [330]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [331]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [332]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [333]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [334]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [335]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [336]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [337]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.3 Alimentos ingeridos dos días antes</p>
                        </div>
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [338]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [339]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [340]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [341]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [342]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [343]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div class="contenedor-cuadros">
                                <table class="cuadritos">
                                    <tr>
                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [344]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Nombre del alimento</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [345]))
                                                <table class="cuadritos">
                                                    <tr>
                                                        @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                            <td class="respuesta">{{ $letra }}</td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                                <div class="etiqueta">Hora</div>
                                            @endif
                                        @endforeach

                                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                                            @if (in_array($respuesta['campo_id'], [346]))
                                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                                                <div class="etiqueta">Lugar del consumo</div>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LABORATORIO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.1 Nombre del lugar de consumo implicado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [347]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.2 Dirección</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [348]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">ASOCIACIÓN CON BROTE</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.1 ¿Caso asociado a un brote?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [349]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2 ¿Caso captado por</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [350]))
                                <div class="contenedor-opciones">
                                    @foreach (['UPGD' => '1. UPGD', 'Búsqueda' => '2. Búsqueda'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3 Relación con la exposición</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [351]))
                                <div class="contenedor-opciones">
                                    @foreach (['Comensal' => '1. Comensal', 'Manipulador' => '2. Manipulador'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">LABORATORIO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.1 ¿Se recolectó muestra biológica?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [352]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>9.2 Tipo de muestra</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [353]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Heces', 'Vómito', 'Sangre', 'Otra'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.2.1 ¿Cuál?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [354]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.3 Agente identificado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [355]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['77. Otro' => '77', '78. Pendiente' => '78', '79. No detectado' => '79'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                    <div class="etiqueta">Codigo 1</div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.4 Agente identificado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [356]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['77. Otro' => '77', '78. Pendiente' => '78', '79. No detectado' => '79'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                    <div class="etiqueta">Codigo 2</div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.5 Agente identificado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [357]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['77. Otro' => '77', '78. Pendiente' => '78', '79. No detectado' => '79'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                    <div class="etiqueta">Codigo 2</div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.6 Agente identificado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [358]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['77. Otro' => '77', '78. Pendiente' => '78', '79. No detectado' => '79'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                    <div class="etiqueta">Codigo 1</div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Si marco 77 Otro: Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [359]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('HEPATITIS B')
        @case('HEPATITIS C')
            <table>
                <tr>
                    <th class="titulos">CLASIFICACIÓN DEL CASO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.1 Con base en las definiciones de caso vigentes en el protocolo de vigilancia, este caso se
                                clasifica como:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [386, 425]))
                                <div class="contenedor-opciones">
                                    @foreach (['Paciente con resultado positivo para HBsAg a clasificar' => '1. Paciente con resultado positivo para HBsAg a clasificar', 'Hepatitis B aguda' => '2. Hepatitis B aguda', 'Hepatitis B crónica' => '3. Hepatitis B crónica', 'Hepatitis B por transmisión materno infantil' => '4. Hepatitis B por transmisión materno infantil', 'Hepatitis Coinfección B-D' => '5. Hepatitis Coinfección B-D', 'Hepatitis C' => '6. Hepatitis C'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">INFORMACIÓN EPIDEMIOLÓGICA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="9">
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.1 Poblaciones y factores de riesgo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [387, 426]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Hijo de madre con HBsAg (+) o diagnóstico de hepatitis C', 'Más de un compañero sexual', 'Hombres que tienen sexo con hombres (HSH)', 'Bisexual', 'Antecedentes de transfusión de hemoderivados', 'Usuarios de hemodiálisis', 'Trabajador de la salud', 'Accidente laboral', 'Trasplante de órganos', 'Personas que se inyectan drogas', 'Convive con persona con HBsAg (+)', 'Contacto sexual con persona con diagnóstico de hepatitis B o C', 'Recibió tratamiento de acupuntura', 'Antecedente de procedimiento estético', 'Antecedente de piercing/tatuaje'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>6.2 Modo de transmisión más probable</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [388, 427]))
                                <div class="contenedor-opciones">
                                    @foreach (['Materno infantil' => '1. Materno infantil', 'Horizontal' => '2. Horizontal', 'Parental/Percutánea' => '3. Parental/Percutánea', 'Sexual' => '4. Sexual'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="9">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.3 Donante de sangre</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [389, 428]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="8">
                        <div class="sub-titulo">
                            <p>6.4 Momento en el que fue diagnosticada con HB:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [390, 429]))
                                <div class="contenedor-opciones">
                                    @foreach (['Previo a la gestación/consulta preconcepcional' => '1. Previo a la gestación/consulta preconcepcional', 'Durante la gestación' => '2. Durante la gestación', 'En el momento del parto' => '3. En el momento del parto', 'Posterior al parto' => '4. Posterior al parto'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="9">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.5 Semanas de gestación</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [391, 430]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.6 Vacunación previa con Hepatitis B?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [392, 431]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.7 Número de dosis</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [393, 432]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.8 Fecha ̇ultima dosis (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [394, 433]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_diagnostico_enfermedad = Carbon::parse(
                                                        $respuesta['respuesta_campo'],
                                                    );
                                                    $fecha_formateada = $fecha_diagnostico_enfermedad->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.9 Fuente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [395, 434]))
                                <div class="contenedor-opciones">
                                    @foreach (['Carné o PAI web' => '1. Carné o PAI web', 'Verbal' => '2. Verbal', 'Sin dato' => '3. Sin dato'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS CLÍNICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.1. Signos y síntomas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [396, 435]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.2 ¿Presenta alguna de las siguientes complicaciones?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [397, 436]))
                                <div class="contenedor-opciones">
                                    @foreach (['Falla hepática fulminante' => '1. Falla hepática fulminante', 'Cirrosis hepática' => '2. Cirrosis hepática', 'Carcinoma hepático' => '3. Carcinoma hepático', 'Síndrome febril ictérico' => '4. Síndrome febril ictérico', 'Ninguna' => '5. Ninguna'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.3 Coinfección VIH</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [398, 437]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DIAGNÓSTICO DE TRANSMISION MATERNO INFANTIL</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.1 Nombres y apellidos de la madre (aplica solo para transmisión materno infantil)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [399, 438]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2. Tipo de ID*</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [400, 439]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3. Número de identificación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [401, 440]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <p class="info-campo">*RC : REGISTRO CIVIL | TI : TARJETA IDENTIDAD | CC : CÉDULA CIUDADANÍA | CE
                            : CÉDULA EXTRANJERÍA | PA : PASAPORTE | MS : MENOR SIN ID | AS : ADULTO SIN ID | PE : PERMISO
                            ESPECIAL DE PERMANENCIA | PT: PERMISO POR PROTECCION TEMPORAL</p>
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.4 Aplicación de la vacuna contra la hepatitis B al recién nacido</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [402, 441]))
                                <div class="contenedor-opciones">
                                    @foreach (['Primeras 12 horas' => '1. Primeras 12 horas', '13 a 24 h' => '2. 13 a 24 h', 'Más de 24 h' => '3. Más de 24 h', 'Sin dato' => '4. Sin dato', 'No aplicación' => '5. No aplicación'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>8.5 Aplicación de gamaglobulina/inmunoglobulina contra la hepatitis B al recién nacido</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [403, 442]))
                                <div class="contenedor-opciones">
                                    @foreach (['Primeras 12 horas' => '1. Primeras 12 horas', '13 a 24 h' => '2. 13 a 24 h', 'Más de 24 h' => '3. Más de 24 h', 'Sin dato' => '4. Sin dato', 'No aplicación' => '5. No aplicación'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LABORATORIO</th>
                </tr>
            </table>
            <p class="texto-pequeno"><strong>La información relacionada con laboratorios debe ingresarse a través del
                    modulo de laboratorios del aplicativo sivigila</strong> </p>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.1 Fecha toma de examen (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [404, 443]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_fecha_examen = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_fecha_examen->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.2 Fecha de recepción(dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [405, 444]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_recepcion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_recepcion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.3 Muestra</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [406, 445]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['Sangre total' => '1', 'Tejido' => '4', 'Suero' => '13'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.4 Prueba</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [407, 446]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['HBsAg' => '26', 'Patología' => '30', 'AntiVHD' => '50', 'Anti-HBc IgM' => '51', 'Anti-HBc Totales' => '93', 'Anti VHC' => '95', 'Carga viral' => 'A4', 'Pruebas genotípicas' => 'B5', 'Inmunoensayo' => 'D0'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.5 Agente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [408, 447]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['Hepatitis B' => '12', 'Hepatitis delta' => '45', 'Hepatitis C' => '46'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.6 Resultado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [409, 448]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (['Compatible' => '7', 'Reactivo' => '10', 'No reactivo' => '11'] as $tipo => $descripcion)
                                                @if ($respuesta['respuesta_campo'] === $tipo)
                                                    <td class="respuesta">{{ $descripcion }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.7 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [410, 449]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.8 Valor</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [411, 450]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
        @break

        @case('INTOXICACIONES POR SUSTANCIAS QUIMICAS')
            <table>
                <tr>
                    <th class="titulos">DATOS DE LA EXPOSICIÓN</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.1 Grupo de sustancias</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [464]))
                                <div class="contenedor-opciones">
                                    @foreach (['Medicamentos' => '1. Medicamentos', 'Plaguicidas' => '2. Plaguicidas', 'Metanol' => '3. Metanol', 'Metales' => '4. Metales', 'Solventes' => '5. Solventes', 'Otras sustancias químicas' => '6. Otras sustancias químicas', 'Gases' => '7. Gases', 'Sustancias psicoactivas' => '8. Sustancias psicoactivas'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.2 Código y nombre del producto:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [465]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.3 Tipo de exposición</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [466]))
                                <div class="contenedor-opciones">
                                    @foreach (['Ocupacional' => '1. Ocupacional', 'Accidental' => '2. Accidental', 'Suicidio consumado' => '11. Suicidio consumado', 'Posible acto homicida' => '4. Posible acto homicida', 'Posible acto delictivo' => '6. Posible acto delictivo', 'Desconocida' => '8. Desconocida', 'Intencional psicoactiva / adicción' => '9. Intencional psicoactiva / adicción', 'Automedicación / autoprescripción' => '10. Automedicación / autoprescripción'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.4 Lugar donde se produjo la intoxicación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [467]))
                                <div class="contenedor-opciones">
                                    @foreach (['Hogar' => '1. Hogar', 'Establecimiento educativo' => '2. Establecimiento educativo', 'Establecimiento militar' => '3. Establecimiento militar', 'Establecimiento comercial' => '4. Establecimiento comercial', 'Establecimiento penitenciario' => '5. Establecimiento penitenciario', 'Lugar de trabajo' => '6. Lugar de trabajo', 'Via pública /parque' => '7. Via pública /parque', 'Bares/Tabernas/Discotecas.' => '8. Bares/Tabernas/Discotecas.'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.5 Fecha de exposición (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [468]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_exposicion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_exposicion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.5.1 Hora (0 a 24)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [469]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>5.6 Vía de exposición</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [470]))
                                <div class="contenedor-opciones">
                                    @foreach (['Respiratoria' => '1. Respiratoria', 'Oral' => '2. Oral', 'Dérmica/mucosa' => '3. Dérmica/mucosa', 'Ocular' => '4. Ocular', 'Desconocida' => '5. Desconocida', 'Parenteral (intramuscular, intravenosa, subcutánea, intraperitoneal)' => '6. Parenteral (intramuscular, intravenosa, subcutánea, intraperitoneal)', 'Transplacentaria' => '7. Transplacentaria'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">OTROS DATOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.1 Escolaridad</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [471]))
                                <div class="contenedor-opciones">
                                    @foreach (['Preescolar' => '1. Preescolar', 'Básica primaria' => '2. Básica primaria', 'Básica secundaria' => '3. Básica secundaria', 'Media académica o clásica' => '4. Media académica o clásica', 'Media técnica' => '5. Media técnica', 'Normalista' => '6. Normalista', 'Técnica profesional' => '7. Técnica profesional', 'Tecnológica' => '8. Tecnológica', 'Profesional' => '9. Profesional', 'Especialización' => '10. Especialización', 'Maestría' => '11. Maestría', 'Doctorado' => '12. Doctorado', 'Ninguno' => '13. Ninguno', 'Sin información' => '14. Sin información'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.2 ¿Afiliado a A.R.L.?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [472]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>6.2.1 Código y nombre de la A.R.L:</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [473]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [474]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.3 Estado civil</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [475]))
                                <div class="contenedor-opciones">
                                    @foreach (['Soltero' => '1. Soltero', 'Casado' => '2. Casado', 'Unión libre' => '3. Unión libre', 'Viudo' => '4. Viudo', 'Divorciado' => '5. Divorciado'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">SEGUIMIENTO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1 ¿El caso hace parte de un brote?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [476]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan=1"">
                        <div class="sub-titulo">
                            <p>7.2 Número de casos en este brote</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [477]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.3 Fecha de investigacion epidemiologia brote (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [478]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_exposicion = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_exposicion->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.4. Situación de alerta</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [479]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS DE LABORATORIO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.1 Se tomaron muestras de toxicología</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [480]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>8.2 Tipo de muestras solicitada</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [481]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sangre total' => '1. Sangre total', 'Orina' => '2. Orina', 'Tejido' => '4. Tejido', 'Suero' => '13. Suero', 'Agua' => '17. Agua', 'Cabello' => '23. Cabello', 'Empaque / envase' => '29. Empaque / envase', 'Uñas' => '32. Uñas', 'Otros' => '30. Otros'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>8.3 Nombre de la prueba toxicológica</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [482]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.4 Diligencie Valor resultado /unidades</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [483]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('LEPTOSPIROSIS')
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="info-campos">
                            <p> <strong>Descripción del evento:</strong> la leptospirosis es una zoonosis de
                                distribución mundial más frecuente en países tropicales, la cual inicia como un cuadro
                                febril
                                inespecÌfico, acompañado principalmente de cefalea y mialgias, solamente el 10% de los
                                casos cursan con ictericia. Se puede presentar insuficiencia renal,
                                hepática y hemorragia pulmonar aguda, complicaciones que son responsables de los casos
                                de muerte. El diagnóstico presuntivo se establece con los síntomas
                                más un antecedente epidemiológico de riesgo, la prueba de ELISA apoya el inicio del
                                manejo médico, sin embargo la confirmación se realiza con micro
                                aglutinación en muestras pareadas.</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">DATOS CLÍNICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>5.1. Signos y síntomas (marque con X los que se presenten)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [497]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Fiebre', 'Mialgias', 'Cefalea', 'Hepatomegalia', 'Ictericia'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">ANTECEDENTES EPIDEMIOLÓGICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>6.1 ¿Hay animales en la casa? (Marque con una X los que tenga)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [498]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Perros', 'Gatos', 'Bovinos', 'Equinos', 'Porcinos', 'Ninguno', 'Otros'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.1.1 ¿Cuál otro?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [499]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.2 Ha visto ratas dentro o alrededor de su domicilio o lugar de trabajo?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [500]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.3 Abastecimiento de agua</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [501]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Acueducto', 'Pozo comunitario', 'Río', 'Tanque de almacenamiento'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.4 ¿Cuenta con sistema de alcantarillado?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [502]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.5 ¿Contacto con aguas estancadas durante los últimos 30 días</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [503]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.6 Actividades recreativas en represa, lago o laguna a en los últimos 30 días antes del
                                comienzo de los síntoma</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [504]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Represa', 'Río', 'Arroyo', 'Lago/laguna', 'Sin antecedente'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>6.7 Disposición de residuos sólidos</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [505]))
                                <div class="contenedor-opciones">
                                    @foreach (['Recolección' => '1. Recolección', 'Disposición peridomiciliaria' => '2. Disposición peridomiciliaria'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('MALARIA')
            <table>
                <tr>
                    <th class="titulos">DATOS COMPLEMENTARIOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.1 Vigilancia activa</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [517]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.2 Sintomático</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [518]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.3 Clasificación según origen</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [519]))
                                <div class="contenedor-opciones">
                                    @foreach (['Autóctono' => '1. Autóctono', 'Importado' => '2. Importado'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.4 Recurrencia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [520]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.5 Trimestre de gestación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [521]))
                                <div class="contenedor-opciones">
                                    @foreach (['Primer trimestre' => '1. Primer trimestre', 'Segundo trimestre' => '2. Segundo trimestre', 'Tercer trimestre' => '3. Tercer trimestre'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.6 Tipo de examen</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [522]))
                                <div class="contenedor-opciones">
                                    @foreach (['GG', 'PCD', 'PDR'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $descripcion }}"
                                                @if ($respuesta['respuesta_campo'] === $descripcion) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.7 Recuento parasitario (Valor mínimo 16 parásitos)</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [523]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>4.8 Gametocitos</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [524]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>4.9 ¿Desplazamiento en los últimos 15 días?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [525]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>País/Departamento/Municipio de desplazamiento</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [526]))
                                    <div class="contenedor-cuadros">
                                        <div class="etiqueta">País</div>
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [527]))
                                    <div class="contenedor-cuadros">
                                        <div class="etiqueta">Departamento</div>
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [528]))
                                    <div class="contenedor-cuadros">
                                        <div class="etiqueta">Municipio</div>
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="2">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>4.11 Complicaciones</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [529]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>¿Cuáles?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [530]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Cerebral', 'Renal', 'Hepática', 'Pulmonar', 'Hematológica', 'Otras'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>4.12 Tratamiento</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [531]))
                                <div class="contenedor-opciones">
                                    @foreach (['Cloroquina+primaquina' => '3. Cloroquina+primaquina', 'Cloroquina' => '3. Cloroquina', 'Quinina oral' => '5. Quinina oral', 'Quinina intravenosa' => '6. Quinina intravenosa', 'Artesunato intravenoso' => '7. Artesunato intravenoso', 'Otro' => '8. Otro', 'Artesunato rectal' => '9. Artesunato rectal', 'Quinina oral + Clindamicina + Primaquina' => '10. Quinina oral + Clindamicina + Primaquina', 'Quinina oral + Doxiciclina + Primaquina' => '11. Quinina oral + Doxiciclina + Primaquina', 'Arthemeter + Lumefantrine + Primaquina (14 días)' => '12. Arthemeter + Lumefantrine + Primaquina (14 días)', 'Quinina intravenoso + Clindamicina' => '13. Quinina intravenoso + Clindamicina', 'Quinina intravenoso + Doxiciclina' => '14. Quinina intravenoso + Doxiciclina', 'Quinina oral + Clindamicina' => '15. Quinina oral + Clindamicina', 'Sin tratamiento' => '16. Sin tratamiento', 'Arthemeter + Lumefantrine + Primaquina (dosis única)' => '17. Arthemeter + Lumefantrine + Primaquina (dosis única)'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>4.13 Fecha de inicio de tratamiento (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [532]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_inicio_tratamiento = Carbon::parse(
                                                        $respuesta['respuesta_campo'],
                                                    );
                                                    $fecha_formateada = $fecha_inicio_tratamiento->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>4.14 Especie infectante</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [533]))
                                <div class="contenedor-opciones">
                                    @foreach (['P. vivax' => '1. P. vivax', 'P. falciparum' => '2. P. falciparum', 'P. malariae' => '3. P. malariae', 'Infección mixta' => '4. Infección mixta'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>4.15 Responsable de diagnóstico</p>
                        </div>
                        @php
                            $nombre_medico = $data['consulta']['medico_ordena']['operador']['nombre_completo'];
                        @endphp
                        <p class="respuesta">{{ $nombre_medico }}</p>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>4.16 Fecha del resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [534]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">REGISTRO INDIVIDUAL DE MALARIA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Nombres del paciente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [535]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Apellidos del paciente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [536]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Tipo de examen</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [537]))
                                <div class="contenedor-opciones">
                                    @foreach (['GG', 'PCD', 'PDR'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $descripcion }}"
                                                @if ($respuesta['respuesta_campo'] === $descripcion) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Especie infectante</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [538]))
                                <div class="contenedor-opciones">
                                    @foreach (['P. vivax' => '1. P. vivax', 'P. falciparum' => '2. P. falciparum', 'P. malariae' => '3. P. malariae', 'Infección mixta' => '4. Infección mixta'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>3.7 Recuento parasitario (Valor mínimo 16 parásitos)</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [539]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>3.16 Fecha del resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [540]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Responsable del diagnóstico</p>
                        </div>
                        @php
                            $nombre_medico = $data['consulta']['medico_ordena']['operador']['nombre_completo'];
                        @endphp
                        <p class="respuesta">{{ $nombre_medico }}</p>
                    </td>
                </tr>
            </table>
        @break

        @case('MORBILIDAD MATERNA EXTREMA')
            <table>
                <tr>
                    <th class="titulos">5. SISTEMA DE REFERENCIA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="7">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.1 ¿La paciente ingresa remitida
                                de otra institución?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [555]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 Institución de referencia 1</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [556]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 Institución de referencia 2</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [557]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>5.4 Tiempo del tramite de remision</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [558]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                    <div class="etiqueta">Hora</div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">6. CARACTERÍSTICAS MATERNAS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="7">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.1 Número de gestaciones</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [559]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>

                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.2 Partos vaginales</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [560]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.3 Cesáreas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [561]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.4 Abortos</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [562]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.5 Molas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [563]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.6 Ectópicos</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [564]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.7 Muertos</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [565]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="7">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.8 Vivos</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [566]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.9 Fecha de terminación de la última gestación (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [567]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <th colspan="1" class="titulo-campo">Incluya el embarazo actual o el que terminÛ en los 41 días
                        anteriores</th>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.11. Número de controles prenatales</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [568]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.12 Semanas al inicio CPN</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [569]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="7">
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>6.13 Terminación de la gestación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [570]))
                                <div class="contenedor-opciones">
                                    @foreach (['Aborto' => '1. Aborto', 'Parto' => '2. Parto', 'Parto instrumentado' => '3. Parto instrumentado', 'Cesárea' => '4. Cesárea', 'Continúa embarazada' => '5. Continúa embarazada'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.15 Momento de ocurrencia con relación a terminación de gestación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [571]))
                                <div class="contenedor-opciones">
                                    @foreach (['Antes' => '1. Antes', 'Durante' => '2. Durante', 'Después' => '3. Después'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">7. CRITERIOS DE INCLUSIÓN</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">7.1. Relacionados con disfunción de órgano</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1.1 Cardiovascular</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [572]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1.2 Renal</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [573]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1.3 Hepática</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [574]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1.4 Cerebral</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [575]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1.5 Respiratoria</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [576]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.1.6 Coagulación/Hematológica</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [577]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">7.2. Relacionados con enfermedad específica</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.2.1 Eclampsia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [578]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.2.2 Preeclamsia severa</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [579]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.2.3 Sepsis o infección sistemica severa</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [580]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.2.4 Hemorragia obstetrica severa</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [581]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.2.5 Ruptura uterina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [582]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">7.3. Relacionados con el manejo</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.3.1. Cirugía adicional</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [583]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">8. DATOS RELACIONADOS CON EL MANEJO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">8.1. Si en el numeral 7.3.1 marcá SI, indique que cirugía</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>CIRUGIA 1</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [584]))
                                <div class="contenedor-opciones">
                                    @foreach (['Histerectomia' => '1. Histerectomia', 'Laparatomia' => '2. Laparatomia', 'Legrado' => '3. Legrado', 'Otra' => '4. Otra'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [585]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>CIRUGIA 2</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [586]))
                                <div class="contenedor-opciones">
                                    @foreach (['Histerectomia' => '1. Histerectomia', 'Laparatomia' => '2. Laparatomia', 'Legrado' => '3. Legrado', 'Otra' => '4. Otra'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>¿Cuál?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [587]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2 Fecha de egreso (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [588]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_egreso = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_egreso->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3 Dias de estancia hospitalaria</p>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.4 Egreso</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [589]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sale para la casa' => '1. Sale para la casa', 'Sale remitida' => '2. Sale remitida'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">9. CAUSAS DE MORBILIDAD</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>9.1 Causa principal (CIE 10):</p>
                        </div>
                        <div class="contenedor">
                            <div class="contenedor-cuadros">
                                <div class="etiqueta">Código</div>
                                <table class="cuadritos">
                                    <tr>
                                        @foreach (str_split($data['cie10']['codigo_cie10']) as $letra)
                                            <td class="respuesta">{{ $letra }}</td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">Causas asociadas</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>9.1.1 Causa principal agrupada</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [590]))
                                <div class="contenedor-opciones">
                                    @foreach (['Trastornos hipertensivos' => '1. Trastornos hipertensivos', 'Complicaciones hemorrágicas' => '2. Complicaciones hemorrágicas', 'Complicaciones de aborto' => '3. Complicaciones de aborto', 'Sepsis de origen obstétrico' => '4. Sepsis de origen obstétrico', 'Sepsis de origen no obstétrico' => '5. Sepsis de origen no obstétrico', 'Sepsis de origen pulmonar' => '6. Sepsis de origen pulmonar', 'Enfermedad preexistente que se complica' => '7. Enfermedad preexistente que se complica', 'Otra causa' => '8. Otra causa'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>9.2 Causa asociada 1 (CIE 10):</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [591]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>9.3 Causa asociada 2 (CIE 10):</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [592]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>9.4 Causa asociada 3 (CIE 10):</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [593]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('TUBERCULOSIS')
            <table>
                <tr>
                    <th class="titulos">5. CLASIFICACióN DE LA TUBERCULOSIS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.1. Condición</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [607]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1. Sensible', 'Resistente' => '2. Resistente'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.2 Tipo de tuberculosis</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [608]))
                                <div class="contenedor-opciones">
                                    @foreach (['Pulmonar' => '1. Pulmonar', 'Extrapulmonar' => '2. Extrapulmonar'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.3 Localización de la tuberculosis extrapulmonar</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [609]))
                                <div class="contenedor-opciones">
                                    @foreach (['Pleural' => '1. Pleural', 'Meníngea' => '2. Meníngea', 'Peritoneal' => '3. Peritoneal', 'Ganglionar' => '4. Ganglionar', 'Renal' => '5. Renal', 'Intestinal' => '7. Intestinal', 'Osteoarticular' => '8. Osteoarticular', 'Genitourinaria' => '9. Genitourinaria', 'Pericárdica' => '10. Pericárdica', 'Cutánea' => '11. Cutánea', 'Otro' => '12. Otro'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">6. CLASIFICACIÓN DE CASO BASADA EN LA HISTORIA DE TRATAMIENTO PREVIO DE LA
                        TUBERCULOSIS Y BASADA EN EL RESULTADO DEL TRATAMIENTO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.1. Según antecedente de tratamiento</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [610]))
                                <div class="contenedor-opciones">
                                    @foreach (['Nuevo' => '1. Nuevo', 'Previamente tratado' => '2. Previamente tratado'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.2 Previamente tratado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [611]))
                                <div class="contenedor-opciones">
                                    @foreach (['Reingreso tras recaída' => '2. Reingreso tras recaída', 'Reingreso tras fracaso' => '3. Reingreso tras fracaso', 'Recuperado tras pérdida al seguimiento' => '4. Recuperado tras pérdida al seguimiento', 'Otros casos previamente tratados' => '5. Otros casos previamente tratados', 'Personas tratadas con tuberculosis sensible a los medicamentos' => '6. Personas tratadas con tuberculosis sensible a los medicamentos', 'Personas tratadas para tuberculosis con medicamentos de 2da línea (MDR, RR, XDR)' => '7. Personas tratadas para tuberculosis con medicamentos de 2da línea (MDR, RR, XDR)'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">7. INFORMACIÓN ADICIONAL</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>7.1. El paciente es trabajador de la salud?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [612]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>7.1.1 Ocupación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [613]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>7.2 Clasifiación basada en el estado de la prueba para VIH?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [614]))
                                <div class="contenedor-opciones">
                                    @foreach (['Persona con tuberculosis y VIH' => '1. Persona con tuberculosis y VIH', 'Persona con tuberculosis y sin VIH' => '2. Persona con tuberculosis y sin VIH', 'Persona con tuberculosis y estado de VIH desconocido' => '3. Persona con tuberculosis y estado de VIH desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.3 Peso actual Kg</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [615]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.4 Talla actual Mts</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [616]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>7.5 IMC (Índice masa corporal)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [617]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                <td class="respuesta">{{ $letra }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">8. CONFIGURACIÓN DE CASO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">8.1.Datos de laboratorio</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Baciloscopia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [618]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Resultado baciloscopia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [619]))
                                <div class="contenedor-opciones">
                                    @foreach (['Positivo' => '1. Positivo', 'Negativo' => '2. Negativo'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Cultivo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [620]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Resultado cultivo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [621]))
                                <div class="contenedor-opciones">
                                    @foreach (['Positivo' => '1. Positivo', 'Negativo' => '2. Negativo', 'En proceso' => '3. En proceso'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Prueba Molecular</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [622]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Resultado prueba molecular para la confirmación del caso</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [623]))
                                <div class="contenedor-opciones">
                                    @foreach (['Positivo' => '1. Positivo', 'Negativo' => '2. Negativo'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>Nombre de la especie identificada</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [624]))
                                <div class="contenedor-opciones">
                                    @foreach (['Mycobacterium tuberculosis' => '1. Mycobacterium tuberculosis', 'Mycobacterium bovis' => '2. Mycobacterium bovis', 'Mycobacterium africanum' => '3. Mycobacterium africanum', 'Mycobacterium microti' => '4. Mycobacterium microti', 'Mycobacterium canettii' => '5. Mycobacterium canettii'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Histopatologia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [625]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Resultado histopatología</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [626]))
                                <div class="contenedor-opciones">
                                    @foreach (['Positivo' => '1. Positivo', 'Negativo' => '2. Negativo'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Resultado prueba de sensibilidad a fármacos (PSF)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [627]))
                                <div class="contenedor-opciones">
                                    @foreach (['Positivo' => '1. Positivo', 'Negativo' => '2. Negativo', 'No se realizó' => '3. No se realizó'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">8.2 Ayudas diagnósticas utilizadas para la configuración de caso
                    </th>
                </tr>
                <tr rowspan="6">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Cuadro clínico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [628]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Nexo epidemiológico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [629]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Radiológico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [630]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>ADA</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [631]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Tuberculina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [632]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>8.3 Coomorbilidades - condiciones especiales para el manejo</p>
                        </div>
                        <p class="indicaciones">Marque con una X las enfermedades oportunistas y/o coinfecciones que presente
                            el paciente con estadio SIDA</p>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [739]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Diabetes', 'Silicosis', 'Enfermedad renal', 'EPOC', 'Enfermedad hepática', 'Cáncer', 'Artritis reumatoide', 'Desnutrición'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr rowspan="10">
                    <th colspan="10" class="titulo-campo">58.5 Clasificación de caso según tipo de resistencia Registre en
                        el círculo contiguo al medicamento según corresponda 1:Sensible - 2:Resistente - 3. No realizado</th>
                </tr>
                <tr rowspan="10">
                    <td colspan="10">
                        <div class="sub-titulo">
                            <p>6.1.1 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [633]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [634]))
                                    <div class="contenedor-opciones">
                                        @foreach (['Monoresistencia' => '1. Monoresistencia'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                                <p class="indicaciones">* Resistencia a un solo
                                                    medicamento de primera línea
                                                </p>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>H: Isoniazida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [635]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>E: Etambutol</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [636]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Z: Pirazinamida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [637]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [638]))
                                    <div class="contenedor-opciones">
                                        @foreach (['MDR' => '1. MDR'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                                <p class="indicaciones">* Resistencia de forma
                                                    simultánea a H y R
                                                </p>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>H: Isoniazida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [639]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>R: Rifampicina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [636]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [634]))
                                    <div class="contenedor-opciones">
                                        @foreach (['Poliresistente' => '1. Poliresistente'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                                <p class="indicaciones">* Resistencia a más de un
                                                    medicamento de primera línea que no
                                                    sea H y R simultáneamente
                                                </p>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>H: Isoniazida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [640]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>E: Etambutol</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [641]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Z: Pirazinamida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [642]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [634]))
                                    <div class="contenedor-opciones">
                                        @foreach (['XDR (Extensivamente resistente)' => '1. XDR (Extensivamente resistente)'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                                <p class="indicaciones">* Caso que cumple con definición de MDR y
                                                    también es resistente a alguna Quinolona y al
                                                    menos a uno de los medicamentos
                                                    adicionales del grupo A
                                                </p>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>H: Isoniazida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [643]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>R: Rifampicina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [644]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Lfx: Levofloxacina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [645]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Mfx: Moxifloxacina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [646]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Bdq: Bedaquilina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [647]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Lzd: Linezolid</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [648]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [649]))
                                    <div class="contenedor-opciones">
                                        @foreach (['RR (Resistencia a rifampicina)' => '1. RR (Resistencia a rifampicina)'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                                <p class="indicaciones">* Esta condición se cumple
                                                    cuando paciente es resistente a
                                                    Rifampicina
                                                </p>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="7">
                        <div class="sub-titulo">
                            <p>R: Rifampicina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [649]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [634]))
                                    <div class="contenedor-opciones">
                                        @foreach (['Resistencia a pre XDR' => '1. Resistencia a pre XDR'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                                <p class="indicaciones">* Caso con multidrogorresistencia, que es
                                                    resistente a una fluoroquinolona o al menos a
                                                    uno de los medicamentos inyectables de
                                                    segunda línea. Esta definición operar· en el
                                                    Programa hasta que la OMS lo defina, dada la
                                                    supresión de los medicamentos inyectables
                                                    del esquema de manejo
                                                </p>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>H: Isoniazida</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [650]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>R: Rifampicina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [651]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Lfx: Levofloxacina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [652]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Mfx: Moxifloxacina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [653]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Bdq: Bedaquilina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [654]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Lzd: Linezolid</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [655]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="3">
                        <div class="sub-titulo">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [634]))
                                    <div class="contenedor-opciones">
                                        @foreach (['Resistencia a otros medicamentos' => '1. Resistencia a otros medicamentos'] as $tipo => $descripcion)
                                            <label class="custom-radio">
                                                <input class="opcion" type="radio" value="{{ $tipo }}"
                                                    @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                                <span class="radio-label">{{ $descripcion }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>Cfx: Clofazimina</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [656]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>Dlm: Delamanid</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [657]))
                                <div class="contenedor-opciones">
                                    @foreach (['Sensible' => '1', 'Resistente' => '2', 'No realizado' => '3'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('VIH - SIDA')
            <table>
                <tr>
                    <th class="titulos">5. ANTECEDENTES EPIDEMIOLÓGICOS</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">5.1 Mecanismo probable de transmisión</th>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>Sexual</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [684]))
                                <div class="contenedor-opciones">
                                    @foreach (['Heterosexual' => '1. Heterosexual', 'Homosexual' => '2. Homosexual', 'Bisexual' => '3. Bisexual', 'Materno infantil' => '4. Materno infantil'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>Parenteral</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [685]))
                                <div class="contenedor-opciones">
                                    @foreach (['Transfusión sanguínea' => '5. Transfusión sanguínea', 'Usuarios drogas IV' => '6. Usuarios drogas IV', 'Accidente de trabajo' => '7. Accidente de trabajo', 'Transplante de órganos' => '9. Transplante de órganos', 'Piercing' => '10. Piercing', 'Hemodiálisis' => '11. Hemodiálisis', 'Tatuajes' => '12. Tatuajes', 'Centro estético' => '13. Centro estético', 'Acupuntura' => '14. Acupuntura'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <th colspan="6" class="titulo-campo">5.2 Ante todo caso de transmisión materno infantil diligenciar
                    </th>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Nombre de la madre</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [686]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Tipo de ID*</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [687]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>Número de identificación</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [688]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.3 Identidad de género</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [689]))
                                <div class="contenedor-opciones">
                                    @foreach (['Masculino' => 'M. Masculino', 'Femenino' => 'F. Femenino', 'Transgénero' => 'T. Transgénero'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>5.4 ¿Donó sangre en los 12 meses anteriores a esta notificación?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [690]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <th class="titulos">6. DIAGNÓSTICO DE LABORATORIO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.1 Tipo de prueba con la cual se confirmá el diagnóstico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [691]))
                                <div class="contenedor-opciones">
                                    @foreach (['Western Blot' => '1. Western Blot', 'Carga viral' => '2. Carga viral', 'Prueba rápida' => '3. Prueba rápida', 'Elisa' => '4. Elisa'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.1.1 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [692]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_resultado = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_resultado->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.1.2 Valor de la carga viral (N° de copias)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [693]))
                                <div class="contenedor-cuadros">
                                    <table class="cuadritos">
                                        <tr>
                                            <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">7. INFORMACIÓN CLÍNICA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.1 Estadio clínico</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [694]))
                                <div class="contenedor-opciones">
                                    @foreach (['VIH' => '1. VIH', 'SIDA' => '2. SIDA', 'Muerto' => '3. Muerto'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">8. INFORMACIÓN CLÍNICA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>8.1 Enfermedades asociadas</p>
                        </div>
                        <p class="indicaciones">Marque con una X las enfermedades oportunistas y/o coinfecciones que presente
                            el paciente con estadio SIDA</p>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [695]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Histoplasmosis diseminada', 'Linfoma de Burkitt', 'Neumonía por pneumocystis', 'Neumonía recurrente (más de 2 episodios en un año)', 'Linfoma inmunoblástico', 'Criptosporidiasis crónica', 'Criptococosis extrapulmonar', 'Sarcoma de Kaposi', 'Síndrome de emaciación', 'Leucoencefalopatía multifocal', 'Septicemia recurrente por Salmonella', 'Toxoplasmosis cerebral', 'Hepatitis B', 'Hepatitis C', 'Meningitis'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break

        @case('VIOLENCIAS DE GENERO')
            <p class="texto-pequeno">Al sistema nacional de vigilancia en salud pública Sivigila, se notifican casos
                sospechosos de violencia de género e intrafamiliar, no es competencia del sector salud la confirmación de los
                casos.</p>
            <table>
                <tr>
                    <th class="titulos">5. MODALIDAD DE LA VIOLENCIA (Notifique el tipo de violencia que cause mayor
                        afectación la víctima)</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>5.1 Violencia no sexual</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [709]))
                                <div class="contenedor-opciones">
                                    @foreach (['Física' => '1. Física', 'Psicológica' => '2. Psicológica', 'Negligencia y abandono' => '3. Negligencia y abandono'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>5.2. Violencia sexual</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [710]))
                                <div class="contenedor-opciones">
                                    @foreach (['Acoso sexual' => '5. Acoso sexual', 'Acceso carnal' => '6. Acceso carnal', 'Explotación sexual' => '7. Explotación sexual', 'Trata de personas' => '10. Trata de personas', 'Actos sexuales' => '12. Actos sexuales', 'Otras violencias sexuales' => '14. Otras violencias sexuales', 'Mutilación genital' => '15. Mutilación genital'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">6. DATOS DE LA VÍCTIMA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="10">
                    <td colspan="10">
                        <div class="sub-titulo">
                            <p>6.1 Actividad</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [711]))
                                <div class="contenedor-opciones">
                                    @foreach (['Líderes(as) cívicos' => '13. Líderes(as) cívicos', 'Estudiante' => '24. Estudiante', 'Otro' => '26. Otro', 'Trabajador(a) doméstico(a)' => '28. Trabajador(a) doméstico(a)', 'Persona en situación de prostitución' => '29. Persona en situación de prostitución', 'Campesino/a' => '30. Campesino/a', 'Persona dedicada al cuidado del hogar' => '31. Persona dedicada al cuidado del hogar', 'Persona que cuida a otras' => '32. Persona que cuida a otras', 'Ninguna' => '33. Ninguna'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="10">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.2 Orientación sexual</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [712]))
                                <div class="contenedor-opciones">
                                    @foreach (['Homosexual' => '1. Homosexual', 'Bisexual' => '2. Bisexual', 'Heterosexual' => '5. Heterosexual', 'Asexual' => '6. Asexual'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.2.1 Identidad de género</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [713]))
                                <div class="contenedor-opciones">
                                    @foreach (['Masculino' => '1. Masculino', 'Femenino' => '2. Femenino', 'Transgénero' => '3. Transgénero'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.3 Persona consumidora de SPA</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [714]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.4 Persona con jefatura de hogar</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [715]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>6.5 Antecedente de violencia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [716]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>6.6 Alcohol víctima</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [717]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">7. DATOS DEL AGRESOR</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>7.1 Sexo</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [718]))
                                <div class="contenedor-opciones">
                                    @foreach (['Masculino' => 'M. Masculino', 'Femenino' => 'F. Femenino', 'Intersexual' => 'I. Intersexual', 'Sin Dato' => 'Sin Dato'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>7.2 Parentesco con la víctima</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [719]))
                                <div class="contenedor-opciones">
                                    @foreach (['Padre' => '9. Padre', 'Madre' => '10. Madre', 'Pareja' => '22. Pareja', 'Ex-Pareja' => '23. Ex-Pareja', 'Familiar' => '24. Familiar', 'Ninguno' => '25. Ninguno'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>7.3 Convive con el agresor(a)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [720]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>7.4 Agresor no familiar</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [721]))
                                <div class="contenedor-opciones">
                                    @foreach (['Profesor(a)' => '1. Profesor(a)', 'Amigo(a)' => '2. Amigo(a)', 'Compañero(a) de trabajo' => '3. Compañero(a) de trabajo', 'Compañero(a) de estudio' => '4. Compañero(a) de estudio', 'Desconocido(a)' => '6. Desconocido(a)', 'Vecino(a)' => '7. Vecino(a)', 'Conocido(a) sin ningún trato' => '8. Conocido(a) sin ningún trato', 'Sin información' => '9. Sin información', 'Otro' => '10. Otro', 'Jefe' => '11. Jefe', 'Sacerdote / pastor' => '12. Sacerdote / pastor', 'Servidor(a) público' => '13. Servidor(a) público'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>7.5 ¿Hecho violento ocurrido en el marco del conflicto armado?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [722]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">8. DATOS DEL HECHO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>8.1 Mecanismo utlizado para la agresión</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [723]))
                                <div class="contenedor-opciones">
                                    @foreach (['Ahorcamiento / estrangulamiento / sofocación' => '1. Ahorcamiento / estrangulamiento / sofocación', 'Caídas' => '2. Caídas', 'Contundente / cortocondundente' => '3. Contundente / cortocondundente', 'Cortante / cortopunzante / Punzante' => '4. Cortante / cortopunzante / Punzante', 'Proyectil arma fuego' => '11. Proyectil arma fuego', 'Quemadura por fuego o llama' => '12. Quemadura por fuego o llama', 'Quemadura por ácido, álcalis, o sustancias corrosivas' => '13. Quemadura por ácido, álcalis, o sustancias corrosivas', 'Quemadura con líquido hirviente' => '14. Quemadura con líquido hirviente', 'Otros mecanismos' => '15. Otros mecanismos', 'Sustancias de uso doméstico que causan irritación' => '16. Sustancias de uso doméstico que causan irritación'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>8.2 Sitio Anatómico comprometido con la quemadura</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [724]))
                                <div class="contenedor-opciones">
                                    @foreach (['Cara', 'Cuello', 'Mano', 'Pies', 'Pliegues', 'Genitales', 'Tronco', 'Miembro superior', 'Miembro inferior'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $descripcion }}"
                                                @if ($respuesta['respuesta_campo'] === $descripcion) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>8.3 Grado</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [725]))
                                <div class="contenedor-opciones">
                                    @foreach (['Primer grado' => '1. Primer grado', 'Segundo grado' => '2. Segundo grado', 'Tercer grado' => '3. Tercer grado'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.4 Extensión</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [726]))
                                <div class="contenedor-opciones">
                                    @foreach (['Menor o igual al 5%' => '1. Menor o igual al 5%', 'Del 6% al 14%' => '2. Del 6% al 14%', 'Mayor o igual al 15%' => '3. Mayor o igual al 15%'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.5 Fecha del hecho (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [727]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_hecho = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_hecho->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>8.6 Escenario</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [728]))
                                <div class="contenedor-opciones">
                                    @foreach (['Área deportiva y recreativa' => '12. Área deportiva y recreativa', 'Comercio y áreas de servicios (Tienda, centro comercial, etc)' => '8. Comercio y áreas de servicios (Tienda, centro comercial, etc)', 'Institución de salud' => '11. Institución de salud', 'Lugar de trabajo' => '4. Lugar de trabajo', 'Establecimiento educativo' => '3. Establecimiento educativo', 'Vía pública' => '1. Vía pública', 'Lugares de esparcimiento con expendido de alcohol' => '10. Lugares de esparcimiento con expendido de alcohol', 'Otro' => '7. Otro', 'Vivienda' => '2. Vivienda', 'Otros espacios abiertos (bosques, potreros, etc)' => '9. Otros espacios abiertos (bosques, potreros, etc)'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="6">
                    <td colspan="6">
                        <div class="sub-titulo">
                            <p>8.7. Ámbito de la violencia según lugar de ocurrencia</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [729]))
                                <div class="contenedor-opciones">
                                    @foreach (['Escolar' => '1. Escolar', 'Laboral' => '2. Laboral', 'Institucional' => '3. Institucional', 'Virtual' => '4. Virtual', 'Comunitario' => '5. Comunitario', 'Hogar' => '6. Hogar', 'Otros ámbitos' => '7. Otros ámbitos'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">9. ATENCIÓN INTEGRAL EN SALUD</th>
                </tr>
            </table>
            <table>
                <tr rowspan="9">
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Profilaxis VIH.</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Profilaxis Hep B.</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Otras profilaxis</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Anticoncepción de emergencia</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Orientación IVE</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Salud Mental</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Remisión a protección</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Informe a autoridades / denuncia a policía judicíal (URI, CTI), fiscalía , policia nacional</p>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>Recolección de evidencia médico legal</p>
                        </div>
                    </td>
                </tr>
                <tr rowspan="9">
                    <td colspan="1">
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [730]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [731]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [732]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <br>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [733]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [734]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [735]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [736]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <br>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [737]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <br>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [738]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @break
        @case('LEISHMANIASIS')
            <table>
                <tr rowspan="8">
                    <td colspan="8">
                        <div class="info-campos">
                            <p><b>Caso confirmado de leishmaniasis cutánea:</b> Paciente con lesiones cutáneas procedente de áreas endémicas que cumpla con tres o más de los siguientes criterios: sin historia de trauma,
                                evolución mayor de dos semanas, úlcera redonda u ovalada con bordes levantados, lesiones nodulares, lesiones satélites, adenopatía localizada, en quien se demuestran por métodos parasitológicos,
                                histopatológicos o genéticos, parásitos del género Leishmania. <br>
                                <b>Caso confirmado de leishmaniasis mucosa:</b> Paciente residente o procedente de área endémica con lesiones en mucosa de nariz u orofaringe y cicatrices o lesiones cutáneas compatibles con leishmaniasis,
                                signos concordantes con los de la descripción clínica y reacción de Montenegro positiva, histología con resultado positivo o prueba de inmunofluorescencia con títulos mayores o iguales a 1:16. <br>
                                <b>Caso probable de leishmaniasis visceral:</b> Paciente residente o procedente de área endémica con cuadro de hepatoesplenomegalia, anemia y pérdida de peso con síntomas como fiebre, malestar general, palidez y hemorragias.<br>
                                <b>Caso confirmado de leishmaniasis visceral:</b> Caso probable que se confirma parasitológicamente a partir de aspirado de médula ósea o bazo, o prueba de inmunofluorescencia mayor o igual a 1:32.</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">5. CUTÁNEA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="8">
                        <div class="sub-titulo">
                            <p>5.1 Localización de la (s) lesión (es)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [753]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Cara', 'Tronco', 'Miembros superiores', 'Miembros inferiores'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">6. MUCOSA</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>6.1 Mucosa afectada</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [754]))
                                <div class="contenedor-opciones">
                                    @foreach (['Nasal' => '1. Nasal', 'Cavidad oral' => '2. Cavidad oral', 'Labios' => '3. Labios', 'Faringe' => '4. Faringe', 'Laringe' => '5. Laringe', 'Párpados' => '6. Párpados', 'Genitales' => '7. Genitales'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>6.2 Signos y síntomas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [755]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Rinorrea', 'Epistaxis', 'Obstrucción nasal', 'Disfonía', 'Disfagia', 'Hiperemia mucosa', 'Ulceración mucosa', 'Perforación tabique', 'Destrucción tabique'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">7. VISCERAL</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>7.1 Signos y síntomas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [756]))
                                @php
                                    $respuestasArray = explode(',', $respuesta['respuesta_campo']);
                                    $respuesta = array_map('trim', $respuestasArray);
                                @endphp
                                <div class="contenedor-opciones">
                                    @foreach (['Fiebre', 'Hepatomegalia', 'Esplenomegalia', 'Anemia', 'Leucocitos por debajo de 5.000 mm3', 'Plaquetas por debajo de 150.000 mm3'] as $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="checkbox" value="{{ $descripcion }}"
                                                @if (in_array($descripcion, $respuesta)) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="5">
                        <div class="sub-titulo">
                            <p>7.2 ¿Tiene Diagnóstico VIH confirmado?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [757]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No', 'Desconocido' => '3. Desconocido'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">8. TRATAMIENTO</th>
                </tr>
            </table>
            <table>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.1 ¿Recibió tratamiento anterior?</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [758]))
                                <div class="contenedor-opciones">
                                    @foreach (['Si' => '1. Si', 'No' => '2. No'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.2 Tratamiento local</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [759]))
                                <div class="contenedor-opciones">
                                    @foreach (['Crioterapia' => '1. Crioterapia', 'Crioterapia' => '2. Crioterapia'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.3 Peso actual del paciente</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [760]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                @foreach (str_split($respuesta['respuesta_campo']) as $letra)
                                                    <td class="respuesta">{{ $letra }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                        <div class="etiqueta">Kgm</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>8.4 Medicamento formulado actualmente</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [761]))
                                <div class="contenedor-opciones">
                                    @foreach (['N- metil glucamina (Glucantime)' => '1. N- metil glucamina (Glucantime)', 'Estibogluconato de sodio' => '2. Estibogluconato de sodio', 'Isotianato de pentamidina' => '3. Isotianato de pentamidina', 'Anfotericina B' => '4. Anfotericina B', 'Otro' => '5. Otro', 'Miltefosina' => '6. Miltefosina', 'Pentamidina' => '7. Pentamidina', 'Sin tratamiento' => '8. Sin tratamiento'] as $tipo => $descripcion)
                                        <label class="custom-radio">
                                            <input class="opcion" type="radio" value="{{ $tipo }}"
                                                @if ($respuesta['respuesta_campo'] === $tipo) checked @endif />
                                            <span class="radio-label">{{ $descripcion }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="8">
                        <div class="sub-titulo">
                            <p>8.4.1 Otro cuál</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [762]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>8.4.2 Número de cápsulas o volumen diario a aplicar</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [763]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="3">
                        <div class="sub-titulo">
                            <p>8.4.3 Días de tratamiento</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [764]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p> 8.4.4 Total de cápsulas ó ampollas</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [765]))
                                <p class="respuesta">{{ $respuesta['respuesta_campo'] }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th class="titulos">9. DATOS DE LABORATORIO</th>
                </tr>
            </table>
            <p class="texto-pequeno"><strong>La información relacionada con laboratorios debe ingresarse a través del
                modulo de laboratorios del aplicativo sivigila</strong>
            </p>
            <table>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.1 Fecha toma de examen (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [766]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_hecho = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_hecho->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.2 Fecha de recepción(dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                            @if (in_array($respuesta['campo_id'], [767]))
                                <div class="contenedor">
                                    <div class="contenedor-cuadros">
                                        @php
                                            $fecha_formateada = '';
                                            if (!empty($respuesta['respuesta_campo'])) {
                                                try {
                                                    $fecha_hecho = Carbon::parse($respuesta['respuesta_campo']);
                                                    $fecha_formateada = $fecha_hecho->format('d/m/Y');
                                                } catch (Exception $e) {
                                                    $fecha_formateada = '';
                                                }
                                            }
                                        @endphp
                                        <table class="cuadritos">
                                            <tr>
                                                @if ($fecha_formateada)
                                                    @foreach (str_split($fecha_formateada) as $fecha)
                                                        <td class="respuesta">{{ $fecha }}</td>
                                                    @endforeach
                                                @else
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <td class="respuesta"></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.3 Muestra</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [768]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.4 Prueba</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [769]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="sub-titulo">
                            <p>9.5 Agente</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [770]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr rowspan="8">
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.6 Resultado</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [771]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="sub-titulo">
                            <p>9.7 Fecha de resultado (dd/mm/aaaa)</p>
                        </div>
                        @foreach ($data['respuesta_sivigila'] as $respuesta)
                        @if (in_array($respuesta['campo_id'], [772]))
                            <div class="contenedor">
                                <div class="contenedor-cuadros">
                                    @php
                                        $fecha_formateada = '';
                                        if (!empty($respuesta['respuesta_campo'])) {
                                            try {
                                                $fecha_hecho = Carbon::parse($respuesta['respuesta_campo']);
                                                $fecha_formateada = $fecha_hecho->format('d/m/Y');
                                            } catch (Exception $e) {
                                                $fecha_formateada = '';
                                            }
                                        }
                                    @endphp
                                    <table class="cuadritos">
                                        <tr>
                                            @if ($fecha_formateada)
                                                @foreach (str_split($fecha_formateada) as $fecha)
                                                    <td class="respuesta">{{ $fecha }}</td>
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < 10; $i++)
                                                    <td class="respuesta"></td>
                                                @endfor
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    </td>
                    <td colspan="4">
                        <div class="sub-titulo">
                            <p>9.8 Valor</p>
                        </div>
                        <div class="contenedor">
                            @foreach ($data['respuesta_sivigila'] as $respuesta)
                                @if (in_array($respuesta['campo_id'], [773]))
                                    <div class="contenedor-cuadros">
                                        <table class="cuadritos">
                                            <tr>
                                                <td class="respuesta">{{ $respuesta['respuesta_campo'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
        @break
        @default
    @endswitch
