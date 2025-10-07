<?php

namespace Database\Seeders;

use App\Http\Modules\Subregion\Models\Subregiones;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class SubregionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $subRegiones = [
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   => 1,
                'municipio_id'      => 1,
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   => 1,
                'municipio_id'      => 2
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 3
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   => 1,
                'municipio_id'      => 4
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 5
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   => 1,
                'municipio_id'      => 6
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 7
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 8
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 9
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   => 1,
                'municipio_id'      => 10
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 11
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 12
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   => 1,
                'municipio_id'      => 13
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   => 1,
                'municipio_id'      => 14
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   => 1,
                'municipio_id'      => 15
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 16
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   => 1,
                'municipio_id'      => 17
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 18
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   => 1,
                'municipio_id'      => 19
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 20
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 21
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 22
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 23
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 24
                ],
                [
                'nombre'            => 'Bajo Cauca',
                'departamento_id'   => 1,
                'municipio_id'      => 25
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 26
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   => 1,
                'municipio_id'      => 27
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 28
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 29
                ],
                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'   => 1,
                'municipio_id'      => 30
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 31
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   => 1,
                'municipio_id'      => 32
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   => 1,
                'municipio_id'      => 33
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 34
                ],
                [
                'nombre'            => 'Bajo Cauca',
                'departamento_id'   => 1,
                'municipio_id'      => 35
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   => 1,
                'municipio_id'      => 36
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   => 1,
                'municipio_id'      => 37
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   => 1,
                'municipio_id'      => 38
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   => 1,
                'municipio_id'      => 39
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   => 1,
                'municipio_id'      => 40
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   => 1,
                'municipio_id'      => 41
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 42
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 43
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   => 1,
                'municipio_id'      => 44
                ],
                [
                'nombre'            => 'Bajo Cauca',
                'departamento_id'   => 1,
                'municipio_id'      => 45
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   => 1,
                'municipio_id'      => 46
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   => 1,
                'municipio_id'      => 47
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	48
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	49
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	50
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   =>  1,
                'municipio_id'      =>	51
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	52
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	53
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	54
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	55
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	56
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	58
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   =>  1,
                'municipio_id'      =>	59
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	60
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	61
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	62
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	63
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   =>  1,
                'municipio_id'      =>	64
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	65
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	66
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	67
                ],
                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'   => 1,
                'municipio_id'      => 68
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	69
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	70
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   =>  1,
                'municipio_id'      =>	71
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   =>  1,
                'municipio_id'      =>	72
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	73
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   =>  1,
                'municipio_id'      =>	74
                ],
                [
                'nombre'            => 'Bajo Cauca',
                'departamento_id'   =>  1,
                'municipio_id'      =>	75
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	76
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	77
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	78
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	79
                ],
                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'   =>  1,
                'municipio_id'      =>	80
                ],
                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'   =>  1,
                'municipio_id'      =>	81
                ],
                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'   =>  1,
                'municipio_id'      =>	82
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	83
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	84
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	85
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	86
                ],
                [
                'nombre'            => 'Valle de Aburra',
                'departamento_id'   =>  1,
                'municipio_id'      =>	87
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	88
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	89
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	90
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	91
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	92
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	93
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   =>  1,
                'municipio_id'      =>	94
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	95
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	96
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   =>  1,
                'municipio_id'      =>	97
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	98
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	99
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	100
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	101
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	102
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	103
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	104
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	105
                ],
                [
                'nombre'            => 'Oriente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	106
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	107
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	108
                ],
                [
                'nombre'            => 'Bajo Cauca',
                'departamento_id'   =>  1,
                'municipio_id'      =>	109
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	110
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	111
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	112
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'   =>  1,
                'municipio_id'      =>	113
                ],
                [
                'nombre'            => 'Occidente',
                'departamento_id'   =>  1,
                'municipio_id'      =>	114
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	115
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'   =>  1,
                'municipio_id'      =>	116
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	117
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'   =>  1,
                'municipio_id'      =>	118
                ],
                [
                'nombre'            => 'Suroeste',
                'departamento_id'    =>  1,
                'municipio_id'      =>	119
                ],
                [
                'nombre'            => 'Uraba',
                'departamento_id'    =>  1,
                'municipio_id'      =>	120
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'    =>  1,
                'municipio_id'      =>	121
                ],
                [
                'nombre'            => 'Norte',
                'departamento_id'    =>  1,
                'municipio_id'      =>	122
                ],
                [
                'nombre'            => 'Nordeste',
                'departamento_id'    =>  1,
                'municipio_id'      =>	123
                ],
                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'    =>  1,
                'municipio_id'      =>	124
                ],
                [
                'nombre'            => 'Bajo Cauca',
                'departamento_id'   =>  1,
                'municipio_id'      =>	125
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	573
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	577
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	578
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	579
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	580
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	581
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	582
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	583
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	584
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	585
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	586
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	587
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	588
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	590
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	591
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	593
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	594
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	595
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	597
                ],
                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	599
                ],

                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	600
                ],

                [
                'nombre'            => 'Choco',
                'departamento_id'   =>	12,
                'municipio_id'      =>	601
                ],

                [
                'nombre'            => 'Magdalena Medio',
                'departamento_id'   =>	21,
                'municipio_id'      =>	850
                ],
            ];
            foreach ($subRegiones as $subRegion) {
                Subregiones::updateOrCreate([
                    'municipio_id' => $subRegion['municipio_id']
                ],[
                    'nombre' => $subRegion['nombre'],
                    'departamento_id' => $subRegion['departamento_id'],
                    'municipio_id' => $subRegion['municipio_id']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder del subregion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
