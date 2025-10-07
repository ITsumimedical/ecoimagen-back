<?php

namespace Database\Seeders;

use App\Http\Modules\Epidemiologia\Models\OpcionesCampoSivigila;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class OpcionesCampoSivigilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $opcionesCampoSivigilas = [
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 1,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 1,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 1,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 1,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 1,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 5,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 5,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 5,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 5,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 5,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 6,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 6,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 8,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 8,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 8,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 12,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 12,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 12,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 12,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 12,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 12,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 12,
                ],

                [
                    'nombre_opcion' => 'Recreación',
                    'campo_id' => 16,
                ],
                [
                    'nombre_opcion' => 'Actividad agrícola',
                    'campo_id' => 16,
                ],
                [
                    'nombre_opcion' => 'Oficios domésticos',
                    'campo_id' => 16,
                ],
                [
                    'nombre_opcion' => 'Recolección de desechos',
                    'campo_id' => 16,
                ],
                [
                    'nombre_opcion' => 'Actividad acuática',
                    'campo_id' => 16,
                ],
                [
                    'nombre_opcion' => 'Caminar por senderos abiertos o trocha',
                    'campo_id' => 16,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 16,
                ],

                [
                    'nombre_opcion' => 'Incisión',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Punción',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Sangría',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Torniquete',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Inmovilización del enfermo',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Inmovilización del miembro',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Succión mecánica',
                    'campo_id' => 18,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 18,
                ],

                [
                    'nombre_opcion' => 'Pócimas',
                    'campo_id' => 20,
                ],
                [
                    'nombre_opcion' => 'Rezos',
                    'campo_id' => 20,
                ],
                [
                    'nombre_opcion' => 'Emplastos de hierbas',
                    'campo_id' => 20,
                ],
                [
                    'nombre_opcion' => 'Succión bucal',
                    'campo_id' => 20,
                ],
                [
                    'nombre_opcion' => 'Ninguno',
                    'campo_id' => 20,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 20,
                ],

                [
                    'nombre_opcion' => 'Cabeza (cara)',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Miembros superiores',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Miembros inferiores',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Tórax anterior',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Abdomen',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Espalda',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Cuello',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Genitales',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Glúteos',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Dedos de pie y de mano',
                    'campo_id' => 22,
                ],
                [
                    'nombre_opcion' => 'Dedos de mano',
                    'campo_id' => 22,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 23,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 23,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 24,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 24,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 25,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 25,
                ],

                [
                    'nombre_opcion' => 'Bothrops',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Crotalus',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Micrurus',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Lachesis',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Pelamis (serpiente de mar)',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Colubrido',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Sin identificar',
                    'campo_id' => 26,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 26,
                ],

                [
                    'nombre_opcion' => 'Mapaná',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Equis',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Cuatro narices',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Cabeza de candado',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Rabo de chucha',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Verrugosa o rieca',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Víbora de pestaña',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Rabo de ají',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Veintricuatro',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Jergón',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Jararacá',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Cascabel',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Coral',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Boca dorada',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Patoco/patoquilla',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 28,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 28,
                ],

                [
                    'nombre_opcion' => 'Edema',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Dolor',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Eritema',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Flictenas',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Parestesias/hipoestesias',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Equimosis',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Hematomas',
                    'campo_id' => 30,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 30,
                ],

                [
                    'nombre_opcion' => 'Náusea',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Hipotensión',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Debilidad muscular',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Hematemesis',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Dificultad para hablar',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Vómito',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Dolor abdominal',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Oliguria',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Hematuria',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Disfagia',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Sialorrea',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Fascies neurotóxica',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Cianosis',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Hematoquexia',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Diarrea',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Alteraciones de la visión',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Epistaxis',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Vértigo',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Bradicardia',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Alteración sensorial',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Gingivorragia',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Ptosis palpebral',
                    'campo_id' => 32,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 32,
                ],

                [
                    'nombre_opcion' => 'Celulitis',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Absceso',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Necrosis',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Mionecrosis',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Fasceitis',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Alteraciones en la circulación/perfusión',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Síndrome compartimental',
                    'campo_id' => 34,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 34,
                ],

                [
                    'nombre_opcion' => 'Anemia aguda severa',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Edema cerebral',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Shock hipovolémico',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Falla ventilatoria',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Shock séptico',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Coma',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'IRA',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'CID',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Hemorragia intracraneana',
                    'campo_id' => 36,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 36,
                ],

                [
                    'nombre_opcion' => 'Leve',
                    'campo_id' => 38,
                ],
                [
                    'nombre_opcion' => 'Moderado',
                    'campo_id' => 38,
                ],
                [
                    'nombre_opcion' => 'Grave',
                    'campo_id' => 38,
                ],
                [
                    'nombre_opcion' => 'No envenenamiento',
                    'campo_id' => 38,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 39,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 39,
                ],

                [
                    'nombre_opcion' => 'Antiviperido (Bothrops, Lachesis, Crotálus)',
                    'campo_id' => 42,
                ],
                [
                    'nombre_opcion' => 'Anti-elapidídico (Micrurus sp: coral verdadera)',
                    'campo_id' => 42,
                ],

                [
                    'nombre_opcion' => 'Probiol',
                    'campo_id' => 43,
                ],
                [
                    'nombre_opcion' => 'Bioclon',
                    'campo_id' => 43,
                ],
                [
                    'nombre_opcion' => 'INS (Instituto Nacional de salud)',
                    'campo_id' => 43,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 43,
                ],

                [
                    'nombre_opcion' => 'Ninguna',
                    'campo_id' => 46,
                ],
                [
                    'nombre_opcion' => 'Localizada',
                    'campo_id' => 46,
                ],
                [
                    'nombre_opcion' => 'Generalizada',
                    'campo_id' => 46,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 49,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 49,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 50,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 50,
                ],

                [
                    'nombre_opcion' => 'Drenaje de absceso',
                    'campo_id' => 51,
                ],
                [
                    'nombre_opcion' => 'Limpieza quirúrgica',
                    'campo_id' => 51,
                ],
                [
                    'nombre_opcion' => 'Desbridamiento',
                    'campo_id' => 51,
                ],
                [
                    'nombre_opcion' => 'Fasciotomia',
                    'campo_id' => 51,
                ],
                [
                    'nombre_opcion' => 'Injerto de piel',
                    'campo_id' => 51,
                ],
                [
                    'nombre_opcion' => 'Amputación',
                    'campo_id' => 51,
                ],

                // AGRECIONES APTR
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 52,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 52,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 52,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 52,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 52,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 56,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 56,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 56,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 56,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 56,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 57,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 57,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 59,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 59,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 59,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 63,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 63,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 63,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 63,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 63,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 63,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 63,
                ],

                [
                    'nombre_opcion' => 'Mordedura',
                    'campo_id' => 65,
                ],
                [
                    'nombre_opcion' => 'Arañazo o rasguño',
                    'campo_id' => 65,
                ],
                [
                    'nombre_opcion' => 'Contacto de mucosa o piel lesionada con saliva infectada con virus rábico',
                    'campo_id' => 65,
                ],
                [
                    'nombre_opcion' => 'Contacto de mucosa o piel lesionada, con tejido nervioso, material biológico o secreciones infectadas con virus rábico',
                    'campo_id' => 65,
                ],
                [
                    'nombre_opcion' => 'Inhalación en ambientes cargados o virus rábico (aerosoles)',
                    'campo_id' => 65,
                ],
                [
                    'nombre_opcion' => 'Trasplante de órganos o tejidos infectados con virus rábico',
                    'campo_id' => 65,
                ],

                [
                    'nombre_opcion' => 'En área cubierta del cuerpo',
                    'campo_id' => 66,
                ],
                [
                    'nombre_opcion' => 'En área descubierta del cuerpo',
                    'campo_id' => 66,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 67,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 67,
                ],

                [
                    'nombre_opcion' => 'Única',
                    'campo_id' => 68,
                ],
                [
                    'nombre_opcion' => 'Múltiple',
                    'campo_id' => 68,
                ],

                [
                    'nombre_opcion' => 'Superficial',
                    'campo_id' => 69,
                ],
                [
                    'nombre_opcion' => 'Profunda',
                    'campo_id' => 69,
                ],

                [
                    'nombre_opcion' => 'Cabeza - cara - cuello',
                    'campo_id' => 70,
                ],
                [
                    'nombre_opcion' => 'Manos - dedos',
                    'campo_id' => 70,
                ],
                [
                    'nombre_opcion' => 'Tronco',
                    'campo_id' => 70,
                ],
                [
                    'nombre_opcion' => 'Miembros superiores',
                    'campo_id' => 70,
                ],
                [
                    'nombre_opcion' => 'Miembros inferiores',
                    'campo_id' => 70,
                ],
                [
                    'nombre_opcion' => 'Pies - dedos',
                    'campo_id' => 70,
                ],
                [
                    'nombre_opcion' => 'Genitales externos',
                    'campo_id' => 70,
                ],

                [
                    'nombre_opcion' => 'Perro',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Gato',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Bovino-Bufalino',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Equidos',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Porcino (cerdo)',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Murciélago',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Zorro',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Mico',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Humano',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Otros silvestres',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Ovino-Caprino',
                    'campo_id' => 72,
                ],
                [
                    'nombre_opcion' => 'Grandes roedores',
                    'campo_id' => 72,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 73,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 73,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 73,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 74,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 74,
                ],

                [
                    'nombre_opcion' => 'Con signos de rabia',
                    'campo_id' => 79,
                ],
                [
                    'nombre_opcion' => 'Sin signos de rabia',
                    'campo_id' => 79,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 79,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 80,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 80,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 80,
                ],

                [
                    'nombre_opcion' => 'Observable',
                    'campo_id' => 81,
                ],
                [
                    'nombre_opcion' => 'Perdido',
                    'campo_id' => 81,
                ],

                [
                    'nombre_opcion' => 'No exposición',
                    'campo_id' => 82,
                ],
                [
                    'nombre_opcion' => 'Exposición leve',
                    'campo_id' => 82,
                ],
                [
                    'nombre_opcion' => 'Exposición grave',
                    'campo_id' => 82,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 83,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 83,
                ],
                [
                    'nombre_opcion' => 'No sabe',
                    'campo_id' => 83,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 85,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 85,
                ],
                [
                    'nombre_opcion' => 'No sabe',
                    'campo_id' => 85,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 88,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 88,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 89,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 89,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 90,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 90,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 91,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 91,
                ],

                // CÁNCER DE CUELLO UTERINO
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 92,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 92,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 92,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 92,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 92,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 96,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 96,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 96,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 96,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 96,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 97,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 97,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 99,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 99,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 99,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 103,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 103,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 103,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 103,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 103,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 103,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 103,
                ],

                [
                    'nombre_opcion' => 'CA Mama',
                    'campo_id' => 105,
                ],
                [
                    'nombre_opcion' => 'CA Cuello uterino',
                    'campo_id' => 105,
                ],
                [
                    'nombre_opcion' => 'Ambos',
                    'campo_id' => 105,
                ],

                [
                    'nombre_opcion' => 'Carcinoma ductal',
                    'campo_id' => 108,
                ],
                [
                    'nombre_opcion' => 'Carcinoma lobulillar',
                    'campo_id' => 108,
                ],

                [
                    'nombre_opcion' => 'In-situ',
                    'campo_id' => 109,
                ],
                [
                    'nombre_opcion' => 'Infiltrante',
                    'campo_id' => 109,
                ],
                [
                    'nombre_opcion' => 'No indicado',
                    'campo_id' => 109,
                ],

                [
                    'nombre_opcion' => 'LEI AG NCIII / In situ',
                    'campo_id' => 112,
                ],
                [
                    'nombre_opcion' => 'Carcinoma escamocelular',
                    'campo_id' => 112,
                ],
                [
                    'nombre_opcion' => 'Adenocarcinoma o mixtos',
                    'campo_id' => 112,
                ],

                [
                    'nombre_opcion' => 'In-situ',
                    'campo_id' => 113,
                ],
                [
                    'nombre_opcion' => 'Invasor /Infiltrante (Figo IA o IB2)',
                    'campo_id' => 113,
                ],
                [
                    'nombre_opcion' => 'Invasor /Infiltrante (Figo >= IB3)',
                    'campo_id' => 113,
                ],
                [
                    'nombre_opcion' => 'No indicado',
                    'campo_id' => 113,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 114,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 114,
                ],

                // CÁNCER DE MAMA
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 116,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 116,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 116,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 116,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 116,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 120,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 120,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 120,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 120,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 120,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 121,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 121,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 123,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 123,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 123,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 127,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 127,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 127,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 127,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 127,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 127,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 127,
                ],

                [
                    'nombre_opcion' => 'CA Mama',
                    'campo_id' => 129,
                ],
                [
                    'nombre_opcion' => 'CA Cuello uterino',
                    'campo_id' => 129,
                ],
                [
                    'nombre_opcion' => 'Ambos',
                    'campo_id' => 129,
                ],

                [
                    'nombre_opcion' => 'Carcinoma ductal',
                    'campo_id' => 132,
                ],
                [
                    'nombre_opcion' => 'Carcinoma lobulillar',
                    'campo_id' => 132,
                ],

                [
                    'nombre_opcion' => 'In-situ',
                    'campo_id' => 133,
                ],
                [
                    'nombre_opcion' => 'Infiltrante',
                    'campo_id' => 133,
                ],
                [
                    'nombre_opcion' => 'No indicado',
                    'campo_id' => 133,
                ],

                [
                    'nombre_opcion' => 'LEI AG NCIII / In situ',
                    'campo_id' => 136,
                ],
                [
                    'nombre_opcion' => 'Carcinoma escamocelular',
                    'campo_id' => 136,
                ],
                [
                    'nombre_opcion' => 'Adenocarcinoma o mixtos',
                    'campo_id' => 136,
                ],

                [
                    'nombre_opcion' => 'In-situ',
                    'campo_id' => 137,
                ],
                [
                    'nombre_opcion' => 'Invasor /Infiltrante (Figo IA o IB2)',
                    'campo_id' => 137,
                ],
                [
                    'nombre_opcion' => 'Invasor /Infiltrante (Figo >= IB3)',
                    'campo_id' => 137,
                ],
                [
                    'nombre_opcion' => 'No indicado',
                    'campo_id' => 137,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 138,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 138,
                ],

                // Cancer en menores de 18
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 140,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 140,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 140,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 140,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 140,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 144,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 144,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 144,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 144,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 144,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 145,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 145,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 147,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 147,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 147,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 151,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 151,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 151,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 151,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 151,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 151,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 151,
                ],

                [
                    'nombre_opcion' => 'Leucemia linfoide aguda',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Leucemia mieloide aguda',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Otras leucemias',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Linfomas y neoplasias reticuloendoteliales',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Tumores del sistema nervioso central',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Neuroblastoma y otros tumores de células nerviosas periféricas',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Retinoblastoma',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Tumores renales',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Tumores hepáticos',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Tumores óseos malignos',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Sarcomas de tejidos blandos y extra óseos',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Tumores germinales trofoblásticos y otros gonadales',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Tumores epiteliales malignos y melanoma',
                    'campo_id' => 153,
                ],
                [
                    'nombre_opcion' => 'Otras neoplasias malignas no especificadas',
                    'campo_id' => 153,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 155,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 155,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 156,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 156,
                ],

                [
                    'nombre_opcion' => 'Extendido de sangre periférica',
                    'campo_id' => 158,
                ],
                [
                    'nombre_opcion' => 'Radiología diagnóstica',
                    'campo_id' => 158,
                ],
                [
                    'nombre_opcion' => 'Gammagrafía',
                    'campo_id' => 158,
                ],
                [
                    'nombre_opcion' => 'Marcadores tumorales',
                    'campo_id' => 158,
                ],
                [
                    'nombre_opcion' => 'Clínica sin otra ayuda diagnóstica',
                    'campo_id' => 158,
                ],

                [
                    'nombre_opcion' => 'Mielograma',
                    'campo_id' => 161,
                ],
                [
                    'nombre_opcion' => 'Histopatología o citología de fluido corporal',
                    'campo_id' => 161,
                ],
                [
                    'nombre_opcion' => 'Inmunotipificación',
                    'campo_id' => 161,
                ],
                [
                    'nombre_opcion' => 'Criterio médico especializado',
                    'campo_id' => 161,
                ],
                [
                    'nombre_opcion' => 'Certificado de defunción',
                    'campo_id' => 161,
                ],
                [
                    'nombre_opcion' => 'Citogenética',
                    'campo_id' => 161,
                ],
                [
                    'nombre_opcion' => 'Radiología diagnóstica',
                    'campo_id' => 161,
                ],

                // DEFECTOS CONGÉNITOS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 164,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 164,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 164,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 164,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 164,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 168,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 168,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 168,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 168,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 168,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 169,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 169,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 171,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 171,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 171,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 175,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 175,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 175,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 175,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 175,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 175,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 175,
                ],

                [
                    'nombre_opcion' => 'RC',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'TI',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'CC',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'CE',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'PA',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'MS',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'AS',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'PE',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'CN',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'CD',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'SC',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'DE',
                    'campo_id' => 178,
                ],
                [
                    'nombre_opcion' => 'PT',
                    'campo_id' => 178,
                ],

                [
                    'nombre_opcion' => 'RC',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'TI',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'CC',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'CE',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'PA',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'MS',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'AS',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'PE',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'CN',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'CD',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'SC',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'DE',
                    'campo_id' => 181,
                ],
                [
                    'nombre_opcion' => 'PT',
                    'campo_id' => 181,
                ],

                [
                    'nombre_opcion' => 'Prenatal',
                    'campo_id' => 187,
                ],
                [
                    'nombre_opcion' => 'Postnatal',
                    'campo_id' => 187,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 189,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 189,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 191,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 191,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 192,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 192,
                ],
                [
                    'nombre_opcion' => 'No ha nacido',
                    'campo_id' => 192,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 204,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 204,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 205,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 205,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 207,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 207,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 209,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 209,
                ],

                [
                    'nombre_opcion' => 'Alto',
                    'campo_id' => 206,
                ],
                [
                    'nombre_opcion' => 'Normal',
                    'campo_id' => 206,
                ],

                [
                    'nombre_opcion' => 'Bajo',
                    'campo_id' => 208,
                ],
                [
                    'nombre_opcion' => 'Normal',
                    'campo_id' => 208,
                ],

                [
                    'nombre_opcion' => 'Bajo',
                    'campo_id' => 210,
                ],
                [
                    'nombre_opcion' => 'Normal',
                    'campo_id' => 210,
                ],

                // DENGUE
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 211,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 211,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 211,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 211,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 211,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 215,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 215,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 215,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 215,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 215,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 216,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 216,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 218,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 218,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 218,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 222,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 222,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 222,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 222,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 222,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 222,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 222,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 224,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 224,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 228,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 228,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 228,
                ],

                [
                    'nombre_opcion' => 'Fiebre',
                    'campo_id' => 230,
                ],
                [
                    'nombre_opcion' => 'Cefalea',
                    'campo_id' => 230,
                ],
                [
                    'nombre_opcion' => 'Dolor retroocular',
                    'campo_id' => 230,
                ],
                [
                    'nombre_opcion' => 'Mialgias',
                    'campo_id' => 230,
                ],
                [
                    'nombre_opcion' => 'Artralgias',
                    'campo_id' => 230,
                ],
                [
                    'nombre_opcion' => 'Erupción o rash',
                    'campo_id' => 230,
                ],

                [
                    'nombre_opcion' => 'Dolor abdominal intenso y continuo',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Vómito persistente',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Diarrea',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Somnolencia o irritabilidad',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Hipotensión',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Hepatomegalia',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Hemorragias importantes en mucosas',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Hipotermia',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Aumento del hematocrito',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Caída de plaquetas (<100.000)',
                    'campo_id' => 231,
                ],
                [
                    'nombre_opcion' => 'Acumulación de líquidos',
                    'campo_id' => 231,
                ],

                [
                    'nombre_opcion' => 'Extravasación severa de plasma',
                    'campo_id' => 232,
                ],
                [
                    'nombre_opcion' => 'Hemorragia con compromiso hemodinámico',
                    'campo_id' => 232,
                ],
                [
                    'nombre_opcion' => 'Shock por dengue',
                    'campo_id' => 232,
                ],
                [
                    'nombre_opcion' => 'Daño grave de órganos',
                    'campo_id' => 232,
                ],


                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 233,
                ],
                [
                    'nombre_opcion' => 'Dengue sin signos de alarma',
                    'campo_id' => 233,
                ],
                [
                    'nombre_opcion' => 'Dengue con signos de alarma',
                    'campo_id' => 233,
                ],
                [
                    'nombre_opcion' => 'Dengue grave',
                    'campo_id' => 233,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 234,
                ],
                [
                    'nombre_opcion' => 'Ambulatoria',
                    'campo_id' => 234,
                ],
                [
                    'nombre_opcion' => 'Hospitalización piso',
                    'campo_id' => 234,
                ],
                [
                    'nombre_opcion' => 'Unidad de cuidados intensivos',
                    'campo_id' => 234,
                ],
                [
                    'nombre_opcion' => 'Observación',
                    'campo_id' => 234,
                ],
                [
                    'nombre_opcion' => 'Remisión para hospitalización',
                    'campo_id' => 234,
                ],

                [
                    'nombre_opcion' => 'Tejido',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Hígado',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Cerebro',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Bazo',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Pulmón',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Miocardio',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Médula',
                    'campo_id' => 235,
                ],
                [
                    'nombre_opcion' => 'Riñón',
                    'campo_id' => 235,
                ],

                [
                    'nombre_opcion' => 'Tejido',
                    'campo_id' => 238,
                ],
                [
                    'nombre_opcion' => 'Suero',
                    'campo_id' => 238,
                ],

                [
                    'nombre_opcion' => 'PCR',
                    'campo_id' => 239,
                ],
                [
                    'nombre_opcion' => 'E0 Elisa NS1',
                    'campo_id' => 239,
                ],
                [
                    'nombre_opcion' => 'igM',
                    'campo_id' => 239,
                ],
                [
                    'nombre_opcion' => 'igG',
                    'campo_id' => 239,
                ],
                [
                    'nombre_opcion' => 'Aislamiento viral',
                    'campo_id' => 239,
                ],

                [
                    'nombre_opcion' => 'Dengue',
                    'campo_id' => 240,
                ],

                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 241,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 241,
                ],
                [
                    'nombre_opcion' => 'No procesado',
                    'campo_id' => 241,
                ],
                [
                    'nombre_opcion' => 'Inadecuado',
                    'campo_id' => 241,
                ],
                [
                    'nombre_opcion' => 'Valor registrado',
                    'campo_id' => 241,
                ],

                // DESNUTRICIÓN MENORES DE 5 AÑOS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 244,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 244,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 244,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 244,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 244,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 248,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 248,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 248,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 248,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 248,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 249,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 249,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 251,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 251,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 251,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 255,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 255,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 255,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 255,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 255,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 255,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 255,
                ],

                [
                    'nombre_opcion' => 'RC',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'TI',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'CC',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'CE',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'PA',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'MS',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'AS',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'PE',
                    'campo_id' => 261,
                ],
                [
                    'nombre_opcion' => 'PT',
                    'campo_id' => 261,
                ],

                [
                    'nombre_opcion' => 'Primaria',
                    'campo_id' => 263,
                ],
                [
                    'nombre_opcion' => 'Secundaría',
                    'campo_id' => 263,
                ],
                [
                    'nombre_opcion' => 'Técnica',
                    'campo_id' => 263,
                ],
                [
                    'nombre_opcion' => 'Universitaria',
                    'campo_id' => 263,
                ],
                [
                    'nombre_opcion' => 'Ninguno',
                    'campo_id' => 263,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 270,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 270,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 271,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 271,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 271,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 272,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 272,
                ],

                [
                    'nombre_opcion' => 'Positiva',
                    'campo_id' => 276,
                ],
                [
                    'nombre_opcion' => 'Negativa',
                    'campo_id' => 276,
                ],
                [
                    'nombre_opcion' => 'No se realizó',
                    'campo_id' => 276,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 277,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 277,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 278,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 278,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 279,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 279,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 280,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 280,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 281,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 281,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 282,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 282,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 283,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 283,
                ],

                [
                    'nombre_opcion' => 'Intrahospitalaria',
                    'campo_id' => 284,
                ],
                [
                    'nombre_opcion' => 'Comunitaria',
                    'campo_id' => 284,
                ],

                // ENFERMEDADES RARAS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 286,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 286,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 286,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 286,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 286,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 290,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 290,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 290,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 290,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 290,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 291,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 291,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 293,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 293,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 293,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 297,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 297,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 297,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 297,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 297,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 297,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 297,
                ],

                [
                    'nombre_opcion' => 'Preescolar',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Básica Primaria',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Básica Secundaria',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Media Académica o Clásica',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Media Técnica (Bachillerato Técnico)',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Normalista',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Técnica Profesional',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Tecnológica',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Profesional',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Especialización',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Maestría',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Doctorado',
                    'campo_id' => 299,
                ],
                [
                    'nombre_opcion' => 'Ninguno',
                    'campo_id' => 299,
                ],

                [
                    'nombre_opcion' => 'Trabajador urbano',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Trabajador rural',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Jóvenes vulnerables rurales',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Jóvenes vulnerables urbanos',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - el sistema nervioso',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - los ojos',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - los oídos',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - los demás órganos de los sentidos (olfato - tacto y gusto)',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - la voz y el habla',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - el sistema cardiorrespiratorio y las defensas',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - la digestión - el metabolismo - las hormonas',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - el sistema genital y reproductivo',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - el movimiento del cuerpo - manos - brazos - piernas',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - la piel',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'Discapacitado - otro',
                    'campo_id' => 300
                ],
                [
                    'nombre_opcion' => 'ND = no definido',
                    'campo_id' => 300
                ],

                // ENERMEDADES TRANSMITIDAS POR ALIMENTOS O AGUA
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 304,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 304,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 304,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 304,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 304,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 308,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 308,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 308,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 308,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 308,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 309,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 309,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 311,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 311,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 311,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 315,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 315,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 315,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 315,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 315,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 315,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 315,
                ],

                [
                    'nombre_opcion' => 'Naúseas',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Vómito',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Diarrea',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Fiebre',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Calambres abdominales',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Cefalea',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Deshidratación',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Cianosis',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Mialgias',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Artralgias',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Mareo',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Lesiones maculopapulares',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Escalofrio',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Parestesias',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Sialorrea',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Espasmos musculares',
                    'campo_id' => 317,
                ],
                [
                    'nombre_opcion' => 'Otros',
                    'campo_id' => 317,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 349,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 349,
                ],

                [
                    'nombre_opcion' => 'UPGD',
                    'campo_id' => 350,
                ],
                [
                    'nombre_opcion' => 'Búsqueda',
                    'campo_id' => 350,
                ],

                [
                    'nombre_opcion' => 'Comensal',
                    'campo_id' => 351,
                ],
                [
                    'nombre_opcion' => 'Manipulador',
                    'campo_id' => 351,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 352,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 352,
                ],

                [
                    'nombre_opcion' => 'Heces',
                    'campo_id' => 353,
                ],
                [
                    'nombre_opcion' => 'Vómito',
                    'campo_id' => 353,
                ],
                [
                    'nombre_opcion' => 'Sangre',
                    'campo_id' => 353,
                ],
                [
                    'nombre_opcion' => 'Otra',
                    'campo_id' => 353,
                ],

                [
                    'nombre_opcion' => '77. Otro',
                    'campo_id' => 355,
                ],
                [
                    'nombre_opcion' => '78. Pendiente',
                    'campo_id' => 355,
                ],
                [
                    'nombre_opcion' => '79. No detectado',
                    'campo_id' => 355,
                ],

                [
                    'nombre_opcion' => '77. Otro',
                    'campo_id' => 356,
                ],
                [
                    'nombre_opcion' => '78. Pendiente',
                    'campo_id' => 356,
                ],
                [
                    'nombre_opcion' => '79. No detectado',
                    'campo_id' => 356,
                ],

                [
                    'nombre_opcion' => '77. Otro',
                    'campo_id' => 357,
                ],
                [
                    'nombre_opcion' => '78. Pendiente',
                    'campo_id' => 357,
                ],
                [
                    'nombre_opcion' => '79. No detectado',
                    'campo_id' => 357,
                ],

                [
                    'nombre_opcion' => '77. Otro',
                    'campo_id' => 358,
                ],
                [
                    'nombre_opcion' => '78. Pendiente',
                    'campo_id' => 358,
                ],
                [
                    'nombre_opcion' => '79. No detectado',
                    'campo_id' => 358,
                ],

                // HEPATITIS A
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 360,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 360,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 360,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 360,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 360,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 290,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 364,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 364,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 364,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 364,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 365,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 365,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 367,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 367,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 367,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 371,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 371,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 371,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 371,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 371,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 371,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 371,
                ],

                // HEPATITIS B
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 373,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 373,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 373,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 373,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 373,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 377,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 377,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 377,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 377,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 377,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 378,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 378,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 380,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 380,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 380,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 384,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 384,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 384,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 384,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 384,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 384,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 384,
                ],

                [
                    'nombre_opcion' => 'Paciente con resultado positivo para HBsAg a clasificar',
                    'campo_id' => 386,
                ],
                [
                    'nombre_opcion' => 'Hepatitis B aguda',
                    'campo_id' => 386,
                ],
                [
                    'nombre_opcion' => 'Hepatitis B crónica',
                    'campo_id' => 386,
                ],
                [
                    'nombre_opcion' => 'Hepatitis B por transmisión materno infantil',
                    'campo_id' => 386,
                ],
                [
                    'nombre_opcion' => 'Hepatitis Coinfección B-D',
                    'campo_id' => 386,
                ],
                [
                    'nombre_opcion' => 'Hepatitis C',
                    'campo_id' => 386,
                ],

                [
                    'nombre_opcion' => 'Hijo de madre con HBsAg (+) o diagnóstico de hepatitis C',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Más de un compañero sexual',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Hombres que tienen sexo con hombres (HSH)',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Bisexual',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Antecedentes de transfusión de hemoderivados',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Usuarios de hemodiálisis',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Trabajador de la salud',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Accidente laboral',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Trasplante de órganos',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Personas que se inyectan drogas',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Convive con persona con HBsAg (+)',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Contacto sexual con persona con diagnóstico de hepatitis B o C',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Recibió tratamiento de acupuntura',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Antecedente de procedimiento estético',
                    'campo_id' => 387,
                ],
                [
                    'nombre_opcion' => 'Antecedente de piercing/tatuaje',
                    'campo_id' => 387,
                ],


                [
                    'nombre_opcion' => 'Materno infantil',
                    'campo_id' => 388,
                ],
                [
                    'nombre_opcion' => 'Horizontal',
                    'campo_id' => 388,
                ],
                [
                    'nombre_opcion' => 'Parental/Percutánea',
                    'campo_id' => 388,
                ],
                [
                    'nombre_opcion' => 'Sexual',
                    'campo_id' => 388,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 389,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 389,
                ],

                [
                    'nombre_opcion' => 'Previo a la gestación/consulta preconcepcional',
                    'campo_id' => 390,
                ],
                [
                    'nombre_opcion' => 'Durante la gestación',
                    'campo_id' => 390,
                ],
                [
                    'nombre_opcion' => 'En el momento del parto',
                    'campo_id' => 390,
                ],
                [
                    'nombre_opcion' => 'Posterior al parto',
                    'campo_id' => 390,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 392,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 392,
                ],

                [
                    'nombre_opcion' => 'Carné o PAI web',
                    'campo_id' => 395,
                ],
                [
                    'nombre_opcion' => 'Verbal',
                    'campo_id' => 395,
                ],
                [
                    'nombre_opcion' => 'Sin dato',
                    'campo_id' => 395,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 396,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 396,
                ],

                [
                    'nombre_opcion' => 'Falla hepática fulminante',
                    'campo_id' => 397,
                ],
                [
                    'nombre_opcion' => 'Cirrosis hepática',
                    'campo_id' => 397,
                ],
                [
                    'nombre_opcion' => 'Carcinoma hepático',
                    'campo_id' => 397,
                ],
                [
                    'nombre_opcion' => 'Síndrome febril ictérico',
                    'campo_id' => 397,
                ],
                [
                    'nombre_opcion' => 'Ninguna',
                    'campo_id' => 397,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 398,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 398,
                ],

                [
                    'nombre_opcion' => 'RC',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'TI',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'CC',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'CE',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'PA',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'MS',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'AS',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'PE',
                    'campo_id' => 400,
                ],
                [
                    'nombre_opcion' => 'PT',
                    'campo_id' => 400,
                ],

                [
                    'nombre_opcion' => 'Primeras 12 horas',
                    'campo_id' => 402,
                ],
                [
                    'nombre_opcion' => '13 a 24 h',
                    'campo_id' => 402,
                ],
                [
                    'nombre_opcion' => 'Más de 24 h',
                    'campo_id' => 402,
                ],
                [
                    'nombre_opcion' => 'Sin dato',
                    'campo_id' => 402,
                ],
                [
                    'nombre_opcion' => 'No aplicación',
                    'campo_id' => 402,
                ],

                [
                    'nombre_opcion' => 'Primeras 12 horas',
                    'campo_id' => 403,
                ],
                [
                    'nombre_opcion' => '13 a 24 h',
                    'campo_id' => 403,
                ],
                [
                    'nombre_opcion' => 'Más de 24 h',
                    'campo_id' => 403,
                ],
                [
                    'nombre_opcion' => 'Sin dato',
                    'campo_id' => 403,
                ],
                [
                    'nombre_opcion' => 'No aplicación',
                    'campo_id' => 403,
                ],

                [
                    'nombre_opcion' => 'Sangre total',
                    'campo_id' => 406,
                ],
                [
                    'nombre_opcion' => 'Tejido',
                    'campo_id' => 406,
                ],
                [
                    'nombre_opcion' => 'Suero',
                    'campo_id' => 406,
                ],

                [
                    'nombre_opcion' => 'HBsAg',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Patología',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'AntiVHD',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Anti-HBc IgM',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Anti-HBc Totales',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Anti VHC',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Carga viral',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Pruebas genotípicas',
                    'campo_id' => 407,
                ],
                [
                    'nombre_opcion' => 'Inmunoensayo',
                    'campo_id' => 407,
                ],

                [
                    'nombre_opcion' => 'Hepatitis B',
                    'campo_id' => 408,
                ],
                [
                    'nombre_opcion' => 'Hepatitis delta',
                    'campo_id' => 408,
                ],
                [
                    'nombre_opcion' => 'Hepatitis C',
                    'campo_id' => 408,
                ],

                [
                    'nombre_opcion' => 'Compatible',
                    'campo_id' => 409,
                ],
                [
                    'nombre_opcion' => 'Reactivo',
                    'campo_id' => 409,
                ],
                [
                    'nombre_opcion' => 'No reactivo',
                    'campo_id' => 409,
                ],



                // HEPATITIS C
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 412,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 412,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 412,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 412,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 412,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 416,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 416,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 416,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 416,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 416,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 417,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 417,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 419,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 419,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 419,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 423,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 423,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 423,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 423,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 423,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 423,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 423,
                ],


                [
                    'nombre_opcion' => 'Paciente con resultado positivo para HBsAg a clasificar',
                    'campo_id' => 425,
                ],
                [
                    'nombre_opcion' => 'Hepatitis B aguda',
                    'campo_id' => 425,
                ],
                [
                    'nombre_opcion' => 'Hepatitis B crónica',
                    'campo_id' => 425,
                ],
                [
                    'nombre_opcion' => 'Hepatitis B por transmisión materno infantil',
                    'campo_id' => 425,
                ],
                [
                    'nombre_opcion' => 'Hepatitis Coinfección B-D',
                    'campo_id' => 425,
                ],
                [
                    'nombre_opcion' => 'Hepatitis C',
                    'campo_id' => 425,
                ],

                [
                    'nombre_opcion' => 'Hijo de madre con HBsAg (+) o diagnóstico de hepatitis C',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Más de un compañero sexual',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Hombres que tienen sexo con hombres (HSH)',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Bisexual',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Antecedentes de transfusión de hemoderivados',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Usuarios de hemodiálisis',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Trabajador de la salud',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Accidente laboral',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Trasplante de órganos',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Personas que se inyectan drogas',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Convive con persona con HBsAg (+)',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Contacto sexual con persona con diagnóstico de hepatitis B o C',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Recibió tratamiento de acupuntura',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Antecedente de procedimiento estético',
                    'campo_id' => 426,
                ],
                [
                    'nombre_opcion' => 'Antecedente de piercing/tatuaje',
                    'campo_id' => 426,
                ],


                [
                    'nombre_opcion' => 'Materno infantil',
                    'campo_id' => 427,
                ],
                [
                    'nombre_opcion' => 'Horizontal',
                    'campo_id' => 427,
                ],
                [
                    'nombre_opcion' => 'Parental/Percutánea',
                    'campo_id' => 427,
                ],
                [
                    'nombre_opcion' => 'Sexual',
                    'campo_id' => 427,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 428,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 428,
                ],

                [
                    'nombre_opcion' => 'Previo a la gestación/consulta preconcepcional',
                    'campo_id' => 429,
                ],
                [
                    'nombre_opcion' => 'Durante la gestación',
                    'campo_id' => 429,
                ],
                [
                    'nombre_opcion' => 'En el momento del parto',
                    'campo_id' => 429,
                ],
                [
                    'nombre_opcion' => 'Posterior al parto',
                    'campo_id' => 429,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 431,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 431,
                ],

                [
                    'nombre_opcion' => 'Carné o PAI web',
                    'campo_id' => 434,
                ],
                [
                    'nombre_opcion' => 'Verbal',
                    'campo_id' => 434,
                ],
                [
                    'nombre_opcion' => 'Sin dato',
                    'campo_id' => 434,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 435,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 435,
                ],

                [
                    'nombre_opcion' => 'Falla hepática fulminante',
                    'campo_id' => 436,
                ],
                [
                    'nombre_opcion' => 'Cirrosis hepática',
                    'campo_id' => 436,
                ],
                [
                    'nombre_opcion' => 'Carcinoma hepático',
                    'campo_id' => 436,
                ],
                [
                    'nombre_opcion' => 'Síndrome febril ictérico',
                    'campo_id' => 436,
                ],
                [
                    'nombre_opcion' => 'Ninguna',
                    'campo_id' => 436,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 437,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 437,
                ],

                [
                    'nombre_opcion' => 'RC',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'TI',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'CC',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'CE',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'PA',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'MS',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'AS',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'PE',
                    'campo_id' => 439,
                ],
                [
                    'nombre_opcion' => 'PT',
                    'campo_id' => 439,
                ],

                [
                    'nombre_opcion' => 'Primeras 12 horas',
                    'campo_id' => 441,
                ],
                [
                    'nombre_opcion' => '13 a 24 h',
                    'campo_id' => 441,
                ],
                [
                    'nombre_opcion' => 'Más de 24 h',
                    'campo_id' => 441,
                ],
                [
                    'nombre_opcion' => 'Sin dato',
                    'campo_id' => 441,
                ],
                [
                    'nombre_opcion' => 'No aplicación',
                    'campo_id' => 441,
                ],

                [
                    'nombre_opcion' => 'Primeras 12 horas',
                    'campo_id' => 442,
                ],
                [
                    'nombre_opcion' => '13 a 24 h',
                    'campo_id' => 442,
                ],
                [
                    'nombre_opcion' => 'Más de 24 h',
                    'campo_id' => 442,
                ],
                [
                    'nombre_opcion' => 'Sin dato',
                    'campo_id' => 442,
                ],
                [
                    'nombre_opcion' => 'No aplicación',
                    'campo_id' => 442,
                ],

                [
                    'nombre_opcion' => 'Sangre total',
                    'campo_id' => 445,
                ],
                [
                    'nombre_opcion' => 'Tejido',
                    'campo_id' => 445,
                ],
                [
                    'nombre_opcion' => 'Suero',
                    'campo_id' => 445,
                ],

                [
                    'nombre_opcion' => 'HBsAg',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Patología',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'AntiVHD',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Anti-HBc IgM',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Anti-HBc Totales',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Anti VHC',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Carga viral',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Pruebas genotípicas',
                    'campo_id' => 446,
                ],
                [
                    'nombre_opcion' => 'Inmunoensayo',
                    'campo_id' => 446,
                ],

                [
                    'nombre_opcion' => 'Hepatitis B',
                    'campo_id' => 447,
                ],
                [
                    'nombre_opcion' => 'Hepatitis delta',
                    'campo_id' => 447,
                ],
                [
                    'nombre_opcion' => 'Hepatitis C',
                    'campo_id' => 447,
                ],

                [
                    'nombre_opcion' => 'Compatible',
                    'campo_id' => 448,
                ],
                [
                    'nombre_opcion' => 'Reactivo',
                    'campo_id' => 448,
                ],
                [
                    'nombre_opcion' => 'No reactivo',
                    'campo_id' => 448,
                ],

                // INTOXICACIONES POR SUSTANCIAS QUIMICAS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 451,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 451,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 451,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 451,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 451,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 455,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 455,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 455,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 455,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 455,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 456,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 456,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 458,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 458,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 458,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 462,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 462,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 462,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 462,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 462,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 462,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 462,
                ],

                [
                    'nombre_opcion' => 'Medicamentos',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Plaguicidas',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Metanol',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Metales',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Solventes',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Otras sustancias químicas',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Gases',
                    'campo_id' => 464,
                ],
                [
                    'nombre_opcion' => 'Sustancias psicoactivas',
                    'campo_id' => 464,
                ],

                [
                    'nombre_opcion' => 'Ocupacional',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Accidental',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Suicidio consumado',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Posible acto homicida',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Posible acto delictivo',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Desconocida',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Intencional psicoactiva / adicción',
                    'campo_id' => 466,
                ],
                [
                    'nombre_opcion' => 'Automedicación / autoprescripción',
                    'campo_id' => 466,
                ],

                [
                    'nombre_opcion' => 'Hogar',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Establecimiento educativo',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Establecimiento militar',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Establecimiento comercial',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Establecimiento penitenciario',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Lugar de trabajo',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Via pública /parque',
                    'campo_id' => 467,
                ],
                [
                    'nombre_opcion' => 'Bares/Tabernas/Discotecas.',
                    'campo_id' => 467,
                ],

                [
                    'nombre_opcion' => 'Respiratoria',
                    'campo_id' => 470,
                ],
                [
                    'nombre_opcion' => 'Oral',
                    'campo_id' => 470,
                ],
                [
                    'nombre_opcion' => 'Dérmica/mucosa',
                    'campo_id' => 470,
                ],
                [
                    'nombre_opcion' => 'Ocular',
                    'campo_id' => 470,
                ],
                [
                    'nombre_opcion' => 'Desconocida',
                    'campo_id' => 470,
                ],
                [
                    'nombre_opcion' => 'Parenteral (intramuscular, intravenosa, subcutánea, intraperitoneal)',
                    'campo_id' => 470,
                ],
                [
                    'nombre_opcion' => 'Transplacentaria',
                    'campo_id' => 470,
                ],

                [
                    'nombre_opcion' => 'Preescolar',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Básica primaria',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Básica secundaria',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Media académica o clásica',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Media técnica',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Normalista',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Técnica profesional',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Tecnológica',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Profesional',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Especialización',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Maestría',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Doctorado',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Ninguno',
                    'campo_id' => 471,
                ],
                [
                    'nombre_opcion' => 'Sin información',
                    'campo_id' => 471,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 472,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 472,
                ],

                [
                    'nombre_opcion' => 'Soltero',
                    'campo_id' => 475,
                ],
                [
                    'nombre_opcion' => 'Casado',
                    'campo_id' => 475,
                ],
                [
                    'nombre_opcion' => 'Unión libre',
                    'campo_id' => 475,
                ],
                [
                    'nombre_opcion' => 'Viudo',
                    'campo_id' => 475,
                ],
                [
                    'nombre_opcion' => 'Divorciado',
                    'campo_id' => 475,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 476,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 476,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 479,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 479,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 480,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 480,
                ],

                [
                    'nombre_opcion' => 'Sangre total',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Orina',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Tejido',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Suero',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Agua',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Cabello',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Empaque / envase',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Uñas',
                    'campo_id' => 481,
                ],
                [
                    'nombre_opcion' => 'Otros',
                    'campo_id' => 481,
                ],

                // LEPTOPIROSIS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 484,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 484,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 484,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 484,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 484,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 488,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 488,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 488,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 488,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 488,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 489,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 489,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 491,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 491,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 491,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 495,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 495,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 495,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 495,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 495,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 495,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 495,
                ],

                [
                    'nombre_opcion' => 'Fiebre',
                    'campo_id' => 497,
                ],
                [
                    'nombre_opcion' => 'Mialgias',
                    'campo_id' => 497,
                ],
                [
                    'nombre_opcion' => 'Cefalea',
                    'campo_id' => 497,
                ],
                [
                    'nombre_opcion' => 'Hepatomegalia',
                    'campo_id' => 497,
                ],
                [
                    'nombre_opcion' => 'Ictericia',
                    'campo_id' => 497,
                ],

                [
                    'nombre_opcion' => 'Perros',
                    'campo_id' => 498,
                ],
                [
                    'nombre_opcion' => 'Gatos',
                    'campo_id' => 498,
                ],
                [
                    'nombre_opcion' => 'Bovinos',
                    'campo_id' => 498,
                ],
                [
                    'nombre_opcion' => 'Equinos',
                    'campo_id' => 498,
                ],
                [
                    'nombre_opcion' => 'Porcinos',
                    'campo_id' => 498,
                ],
                [
                    'nombre_opcion' => 'Ninguno',
                    'campo_id' => 498,
                ],
                [
                    'nombre_opcion' => 'Otros',
                    'campo_id' => 498,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 500,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 500,
                ],

                [
                    'nombre_opcion' => 'Acueducto',
                    'campo_id' => 501,
                ],
                [
                    'nombre_opcion' => 'Pozo comunitario',
                    'campo_id' => 501,
                ],
                [
                    'nombre_opcion' => 'Río',
                    'campo_id' => 501,
                ],
                [
                    'nombre_opcion' => 'Tanque de almacenamiento',
                    'campo_id' => 501,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 502,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 502,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 503,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 503,
                ],

                [
                    'nombre_opcion' => 'Represa',
                    'campo_id' => 504,
                ],
                [
                    'nombre_opcion' => 'Río',
                    'campo_id' => 504,
                ],
                [
                    'nombre_opcion' => 'Arroyo',
                    'campo_id' => 504,
                ],
                [
                    'nombre_opcion' => 'Lago/laguna',
                    'campo_id' => 504,
                ],
                [
                    'nombre_opcion' => 'Sin antecedente',
                    'campo_id' => 504,
                ],


                [
                    'nombre_opcion' => 'Recolección',
                    'campo_id' => 505,
                ],
                [
                    'nombre_opcion' => 'Disposición peridomiciliaria',
                    'campo_id' => 505,
                ],

                // MALARIA
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 506,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 506,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 506,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 506,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 506,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 510,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 510,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 510,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 510,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 510,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 511,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 511,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 513,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 513,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 513,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 517,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 517,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 518,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 518,
                ],

                [
                    'nombre_opcion' => 'Autóctono',
                    'campo_id' => 519,
                ],
                [
                    'nombre_opcion' => 'Importado',
                    'campo_id' => 519,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 520,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 520,
                ],

                [
                    'nombre_opcion' => 'Primer trimestre',
                    'campo_id' => 521,
                ],
                [
                    'nombre_opcion' => 'Segundo trimestre',
                    'campo_id' => 521,
                ],
                [
                    'nombre_opcion' => 'Tercer trimestre',
                    'campo_id' => 521,
                ],

                [
                    'nombre_opcion' => 'GG',
                    'campo_id' => 522,
                ],
                [
                    'nombre_opcion' => 'PCD',
                    'campo_id' => 522,
                ],
                [
                    'nombre_opcion' => 'PDR',
                    'campo_id' => 522,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 524,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 524,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 525,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 525,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 529,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 529,
                ],

                [
                    'nombre_opcion' => 'Cerebral',
                    'campo_id' => 530,
                ],
                [
                    'nombre_opcion' => 'Renal',
                    'campo_id' => 530,
                ],
                [
                    'nombre_opcion' => 'Hepática',
                    'campo_id' => 530,
                ],
                [
                    'nombre_opcion' => 'Pulmonar',
                    'campo_id' => 530,
                ],
                [
                    'nombre_opcion' => 'Hematológica',
                    'campo_id' => 530,
                ],
                [
                    'nombre_opcion' => 'Otras',
                    'campo_id' => 530,
                ],

                [
                    'nombre_opcion' => 'Cloroquina+primaquina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Cloroquina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina oral',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina intravenosa',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Artesunato intravenoso',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Artesunato rectal',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina oral + Clindamicina + Primaquina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina oral + Doxiciclina + Primaquina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Arthemeter + Lumefantrine + Primaquina (14 días)',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina intravenoso + Clindamicina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina intravenoso + Doxiciclina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Quinina oral + Clindamicina',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Sin tratamiento',
                    'campo_id' => 531,
                ],
                [
                    'nombre_opcion' => 'Arthemeter + Lumefantrine + Primaquina (dosis única)',
                    'campo_id' => 531,
                ],

                [
                    'nombre_opcion' => 'P. vivax',
                    'campo_id' => 533,
                ],
                [
                    'nombre_opcion' => 'P. falciparum',
                    'campo_id' => 533,
                ],
                [
                    'nombre_opcion' => 'P. malariae',
                    'campo_id' => 533,
                ],
                [
                    'nombre_opcion' => 'Infección mixta',
                    'campo_id' => 533,
                ],

                [
                    'nombre_opcion' => 'GG',
                    'campo_id' => 537,
                ],
                [
                    'nombre_opcion' => 'PCD',
                    'campo_id' => 537,
                ],
                [
                    'nombre_opcion' => 'PDR',
                    'campo_id' => 537,
                ],

                [
                    'nombre_opcion' => 'P. vivax',
                    'campo_id' => 538,
                ],
                [
                    'nombre_opcion' => 'P. falciparum',
                    'campo_id' => 538,
                ],
                [
                    'nombre_opcion' => 'P. malariae',
                    'campo_id' => 538,
                ],
                [
                    'nombre_opcion' => 'Infección mixta',
                    'campo_id' => 538,
                ],

                // MORTALIDAD MATERNAL
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 542,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 542,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 542,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 542,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 542,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 546,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 546,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 546,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 546,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 546,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 547,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 547,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 549,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 549,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 549,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 553,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 553,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 553,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 553,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 553,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 553,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 553,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 555,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 555,
                ],

                [
                    'nombre_opcion' => 'Aborto',
                    'campo_id' => 570,
                ],
                [
                    'nombre_opcion' => 'Parto',
                    'campo_id' => 570,
                ],
                [
                    'nombre_opcion' => 'Parto instrumentado',
                    'campo_id' => 570,
                ],
                [
                    'nombre_opcion' => 'Cesárea',
                    'campo_id' => 570,
                ],
                [
                    'nombre_opcion' => 'Continúa embarazada',
                    'campo_id' => 570,
                ],

                [
                    'nombre_opcion' => 'Antes',
                    'campo_id' => 571
                ],
                [
                    'nombre_opcion' => 'Durante',
                    'campo_id' => 571
                ],
                [
                    'nombre_opcion' => 'Después',
                    'campo_id' => 571
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 572,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 572,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 573,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 573,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 574,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 574,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 575,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 575,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 576,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 576,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 577,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 577,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 578,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 578,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 579,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 579,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 580,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 580,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 581,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 581,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 582,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 582,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 583,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 583,
                ],

                [
                    'nombre_opcion' => 'Histerectomia',
                    'campo_id' => 584
                ],
                [
                    'nombre_opcion' => 'Laparatomia',
                    'campo_id' => 584
                ],
                [
                    'nombre_opcion' => 'Legrado',
                    'campo_id' => 584
                ],
                [
                    'nombre_opcion' => 'Otra',
                    'campo_id' => 584
                ],

                [
                    'nombre_opcion' => 'Histerectomia',
                    'campo_id' => 586
                ],
                [
                    'nombre_opcion' => 'Laparatomia',
                    'campo_id' => 586
                ],
                [
                    'nombre_opcion' => 'Legrado',
                    'campo_id' => 586
                ],
                [
                    'nombre_opcion' => 'Otra',
                    'campo_id' => 586
                ],

                [
                    'nombre_opcion' => 'Sale para la casa',
                    'campo_id' => 589
                ],
                [
                    'nombre_opcion' => 'Sale remitida',
                    'campo_id' => 589
                ],

                [
                    'nombre_opcion' => 'Trastornos hipertensivos',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Complicaciones hemorrágicas',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Complicaciones de aborto',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Sepsis de origen obstétrico',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Sepsis de origen no obstétrico',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Sepsis de origen pulmonar',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Enfermedad preexistente que se complica',
                    'campo_id' => 590
                ],
                [
                    'nombre_opcion' => 'Otra causa',
                    'campo_id' => 590
                ],

                // TUBERCULOSIS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 594,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 594,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 594,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 594,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 594,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 598,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 598,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 598,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 598,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 598,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 599,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 599,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 601,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 601,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 601,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 605,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 605,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 605,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 605,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 605,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 605,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 605,
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 607,
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 607,
                ],

                [
                    'nombre_opcion' => 'Pulmonar',
                    'campo_id' => 608,
                ],
                [
                    'nombre_opcion' => 'Extrapulmonar',
                    'campo_id' => 608,
                ],

                [
                    'nombre_opcion' => 'Pleural',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Meníngea',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Peritoneal',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Ganglionar',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Renal',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Intestinal',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Osteoarticular',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Genitourinaria',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Pericárdica',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Cutánea',
                    'campo_id' => 609
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 609
                ],

                [
                    'nombre_opcion' => 'Nuevo',
                    'campo_id' => 610
                ],
                [
                    'nombre_opcion' => 'Previamente tratado',
                    'campo_id' => 610
                ],

                [
                    'nombre_opcion' => 'Reingreso tras recaída',
                    'campo_id' => 611
                ],
                [
                    'nombre_opcion' => 'Reingreso tras fracaso',
                    'campo_id' => 611
                ],
                [
                    'nombre_opcion' => 'Recuperado tras pérdida al seguimiento',
                    'campo_id' => 611
                ],
                [
                    'nombre_opcion' => 'Otros casos previamente tratados',
                    'campo_id' => 611
                ],
                [
                    'nombre_opcion' => 'Personas tratadas con tuberculosis sensible a los medicamentos',
                    'campo_id' => 611
                ],
                [
                    'nombre_opcion' => 'Personas tratadas para tuberculosis con medicamentos de 2da línea (MDR, RR, XDR)',
                    'campo_id' => 611
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 612,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 612,
                ],

                [
                    'nombre_opcion' => 'Persona con tuberculosis y VIH',
                    'campo_id' => 614,
                ],
                [
                    'nombre_opcion' => 'Persona con tuberculosis y sin VIH',
                    'campo_id' => 614,
                ],
                [
                    'nombre_opcion' => 'Persona con tuberculosis y estado de VIH desconocido',
                    'campo_id' => 614,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 618,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 618,
                ],

                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 619,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 619,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 620,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 620,
                ],

                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 621,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 621,
                ],
                [
                    'nombre_opcion' => 'En proceso',
                    'campo_id' => 621,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 622,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 622,
                ],

                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 623,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 623,
                ],

                [
                    'nombre_opcion' => 'Mycobacterium tuberculosis',
                    'campo_id' => 624
                ],
                [
                    'nombre_opcion' => 'Mycobacterium bovis',
                    'campo_id' => 624
                ],
                [
                    'nombre_opcion' => 'Mycobacterium africanum',
                    'campo_id' => 624
                ],
                [
                    'nombre_opcion' => 'Mycobacterium microti',
                    'campo_id' => 624
                ],
                [
                    'nombre_opcion' => 'Mycobacterium canettii',
                    'campo_id' => 624
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 625,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 625,
                ],

                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 626,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 626,
                ],

                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 627,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 627,
                ],
                [
                    'nombre_opcion' => 'No se realizó',
                    'campo_id' => 627,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 628,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 628,
                ],
                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 629,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 629,
                ],
                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 630,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 630,
                ],
                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 631,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 631,
                ],
                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 632,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 632,
                ],

                [
                    'nombre_opcion' => 'Diabetes',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'Silicosis',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'Enfermedad renal',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'EPOC',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'Enfermedad hepática',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'Cáncer',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'Artritis reumatoide',
                    'campo_id' => 739
                ],
                [
                    'nombre_opcion' => 'Desnutrición',
                    'campo_id' => 739
                ],

                [
                    'nombre_opcion' => 'Monoresistencia',
                    'campo_id' => 634
                ],
                [
                    'nombre_opcion' => 'MDR',
                    'campo_id' => 634
                ],
                [
                    'nombre_opcion' => 'Poliresistente',
                    'campo_id' => 634
                ],
                [
                    'nombre_opcion' => 'XDR (Extensivamente resistente)',
                    'campo_id' => 634
                ],
                [
                    'nombre_opcion' => 'RR (Resistencia a rifampicina)',
                    'campo_id' => 634
                ],
                [
                    'nombre_opcion' => 'Resistencia a pre XDR',
                    'campo_id' => 634
                ],
                [
                    'nombre_opcion' => 'Resistencia a otros medicamentos',
                    'campo_id' => 634
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 635
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 635
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 635
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 636
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 636
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 636
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 637
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 637
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 637
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 638
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 638
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 638
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 639
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 639
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 639
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 640
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 640
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 640
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 641
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 641
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 641
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 642
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 642
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 642
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 643
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 643
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 643
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 644
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 644
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 644
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 645
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 645
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 645
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 646
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 646
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 646
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 647
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 647
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 647
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 648
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 648
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 648
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 649
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 649
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 649
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 650
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 650
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 650
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 651
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 651
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 651
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 652
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 652
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 652
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 653
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 653
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 653
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 654
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 654
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 654
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 655
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 655
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 655
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 656
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 656
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 656
                ],

                [
                    'nombre_opcion' => 'Sensible',
                    'campo_id' => 657
                ],
                [
                    'nombre_opcion' => 'Resistente',
                    'campo_id' => 657
                ],
                [
                    'nombre_opcion' => 'No realizado',
                    'campo_id' => 657
                ],

                // VARICELA
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 658,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 658,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 658,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 658,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 658,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 662,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 662,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 662,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 662,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 662,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 663,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 663,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 665,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 665,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 665,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 669,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 669,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 669,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 669,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 669,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 669,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 669,
                ],

                // VIH - SIDA
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 671,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 671,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 671,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 671,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 671,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 675,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 675,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 675,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 675,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 675,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 676,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 676,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 678,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 678,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 678,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 682,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 682,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 682,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 682,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 682,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 682,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 682,
                ],

                [
                    'nombre_opcion' => 'Heterosexual',
                    'campo_id' => 684
                ],
                [
                    'nombre_opcion' => 'Homosexual',
                    'campo_id' => 684
                ],
                [
                    'nombre_opcion' => 'Bisexual',
                    'campo_id' => 684
                ],
                [
                    'nombre_opcion' => 'Materno infantil',
                    'campo_id' => 684
                ],

                [
                    'nombre_opcion' => 'Transfusión sanguínea',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Usuarios drogas IV',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Accidente de trabajo',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Transplante de órganos',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Piercing',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Hemodiálisis',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Tatuajes',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Centro estético',
                    'campo_id' => 685
                ],
                [
                    'nombre_opcion' => 'Acupuntura',
                    'campo_id' => 685
                ],

                [
                    'nombre_opcion' => 'Masculino',
                    'campo_id' => 689
                ],
                [
                    'nombre_opcion' => 'Femenino',
                    'campo_id' => 689
                ],
                [
                    'nombre_opcion' => 'Transgénero',
                    'campo_id' => 689
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 690,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 690,
                ],

                [
                    'nombre_opcion' => 'Western Blot',
                    'campo_id' => 691
                ],
                [
                    'nombre_opcion' => 'Carga viral',
                    'campo_id' => 691
                ],
                [
                    'nombre_opcion' => 'Prueba rápida',
                    'campo_id' => 691
                ],
                [
                    'nombre_opcion' => 'Elisa',
                    'campo_id' => 691
                ],

                [
                    'nombre_opcion' => 'VIH',
                    'campo_id' => 694
                ],
                [
                    'nombre_opcion' => 'SIDA',
                    'campo_id' => 694
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 694
                ],

                [
                    'nombre_opcion' => 'Candidiasis esofágica',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Candidiasis de las vías aéreas',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Tuberculosis pulmonar',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Cáncer cervical invasivo',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Tuberculosis extrapulmonar',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Coccidiodomicosis',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Citomegalovirosis',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Retinitis por citomegalovirus',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Encefalopatía por VIH',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Otras micobacterias',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Histoplasmosis extrapulmonar',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Isosporidiasis crónica',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Herpes zoster en múltiples dermatomas',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Histoplasmosis diseminada',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Linfoma de Burkitt',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Neumonía por pneumocystis',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Neumonía recurrente (más de 2 episodios en un año)',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Linfoma inmunoblástico',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Criptosporidiasis crónica',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Criptococosis extrapulmonar',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Sarcoma de Kaposi',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Síndrome de emaciación',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Leucoencefalopatía multifocal',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Septicemia recurrente por Salmonella',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Toxoplasmosis cerebral',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Hepatitis B',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Hepatitis C',
                    'campo_id' => 695
                ],
                [
                    'nombre_opcion' => 'Meningitis',
                    'campo_id' => 695
                ],

                // VIOLENCIA DE GENERO
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 696,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 696,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 696,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 696,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 696,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 700,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 700,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 700,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 700,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 700,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 701,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 701,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 703,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 703,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 703,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 707,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 707,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 707,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 707,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 707,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 707,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 707,
                ],

                [
                    'nombre_opcion' => 'Física',
                    'campo_id' => 709
                ],
                [
                    'nombre_opcion' => 'Psicológica',
                    'campo_id' => 709
                ],
                [
                    'nombre_opcion' => 'Negligencia y abandono',
                    'campo_id' => 709
                ],

                [
                    'nombre_opcion' => 'Acoso sexual',
                    'campo_id' => 710
                ],
                [
                    'nombre_opcion' => 'Acceso carnal',
                    'campo_id' => 710
                ],
                [
                    'nombre_opcion' => 'Explotación sexual',
                    'campo_id' => 710
                ],
                [
                    'nombre_opcion' => 'Trata de personas',
                    'campo_id' => 710
                ],
                [
                    'nombre_opcion' => 'Actos sexuales',
                    'campo_id' => 710
                ],
                [
                    'nombre_opcion' => 'Otras violencias sexuales',
                    'campo_id' => 710
                ],
                [
                    'nombre_opcion' => 'Mutilación genital',
                    'campo_id' => 710
                ],

                [
                    'nombre_opcion' => 'Líderes(as) cívicos',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Estudiante',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Trabajador(a) doméstico(a)',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Persona en situación de prostitución',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Campesino/a',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Persona dedicada al cuidado del hogar',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Persona que cuida a otras',
                    'campo_id' => 711
                ],
                [
                    'nombre_opcion' => 'Ninguna',
                    'campo_id' => 711
                ],

                [
                    'nombre_opcion' => 'Homosexual',
                    'campo_id' => 712
                ],
                [
                    'nombre_opcion' => 'Bisexual',
                    'campo_id' => 712
                ],
                [
                    'nombre_opcion' => 'Heterosexual',
                    'campo_id' => 712
                ],
                [
                    'nombre_opcion' => 'Asexual',
                    'campo_id' => 712
                ],

                [
                    'nombre_opcion' => 'Masculino',
                    'campo_id' => 713
                ],
                [
                    'nombre_opcion' => 'Femenino',
                    'campo_id' => 713
                ],
                [
                    'nombre_opcion' => 'Transgénero',
                    'campo_id' => 713
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 714,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 714,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 715,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 715,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 716,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 716,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 717,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 717,
                ],

                [
                    'nombre_opcion' => 'Masculino',
                    'campo_id' => 718
                ],
                [
                    'nombre_opcion' => 'Femenino',
                    'campo_id' => 718
                ],
                [
                    'nombre_opcion' => 'Intersexual',
                    'campo_id' => 718
                ],
                [
                    'nombre_opcion' => 'Sin Dato',
                    'campo_id' => 718
                ],

                [
                    'nombre_opcion' => 'Padre',
                    'campo_id' => 719
                ],
                [
                    'nombre_opcion' => 'Madre',
                    'campo_id' => 719
                ],
                [
                    'nombre_opcion' => 'Pareja',
                    'campo_id' => 719
                ],
                [
                    'nombre_opcion' => 'Ex-Pareja',
                    'campo_id' => 719
                ],
                [
                    'nombre_opcion' => 'Familiar',
                    'campo_id' => 719
                ],
                [
                    'nombre_opcion' => 'Ninguno',
                    'campo_id' => 719
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 720,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 720,
                ],

                [
                    'nombre_opcion' => 'Profesor(a)',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Amigo(a)',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Compañero(a) de trabajo',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Compañero(a) de estudio',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Desconocido(a)',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Vecino(a)',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Conocido(a) sin ningún trato',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Sin información',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Jefe',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Sacerdote / pastor',
                    'campo_id' => 721
                ],
                [
                    'nombre_opcion' => 'Servidor(a) público',
                    'campo_id' => 721
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 722,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 722,
                ],

                [
                    'nombre_opcion' => 'Ahorcamiento / estrangulamiento / sofocación',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Caídas',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Contundente / cortocondundente',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Cortante / cortopunzante / Punzante',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Proyectil arma fuego',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Quemadura por fuego o llama',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Quemadura por ácido, álcalis, o sustancias corrosivas',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Quemadura con líquido hirviente',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Otros mecanismos',
                    'campo_id' => 723
                ],
                [
                    'nombre_opcion' => 'Sustancias de uso doméstico que causan irritación',
                    'campo_id' => 723
                ],

                [
                    'nombre_opcion' => 'Cara',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Cuello',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Mano',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Pies',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Pliegues',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Genitales',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Tronco',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Miembro superior',
                    'campo_id' => 724
                ],
                [
                    'nombre_opcion' => 'Miembro inferior',
                    'campo_id' => 724
                ],

                [
                    'nombre_opcion' => 'Primer grado',
                    'campo_id' => 725
                ],
                [
                    'nombre_opcion' => 'Segundo grado',
                    'campo_id' => 725
                ],
                [
                    'nombre_opcion' => 'Tercer grado',
                    'campo_id' => 725
                ],

                [
                    'nombre_opcion' => 'Menor o igual al 5%',
                    'campo_id' => 726
                ],
                [
                    'nombre_opcion' => 'Del 6% al 14%',
                    'campo_id' => 726
                ],
                [
                    'nombre_opcion' => 'Mayor o igual al 15%',
                    'campo_id' => 726
                ],

                [
                    'nombre_opcion' => 'Vía pública',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Vivienda',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Establecimiento educativo',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Lugar de trabajo',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Comercio y áreas de servicios (Tienda, centro comercial, etc)',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Otros espacios abiertos (bosques, potreros, etc)',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Lugares de esparcimiento con expendido de alcohol',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Institución de salud',
                    'campo_id' => 728
                ],
                [
                    'nombre_opcion' => 'Área deportiva y recreativa',
                    'campo_id' => 728
                ],

                [
                    'nombre_opcion' => 'Escolar',
                    'campo_id' => 729
                ],
                [
                    'nombre_opcion' => 'Laboral',
                    'campo_id' => 729
                ],
                [
                    'nombre_opcion' => 'Institucional',
                    'campo_id' => 729
                ],
                [
                    'nombre_opcion' => 'Virtual',
                    'campo_id' => 729
                ],
                [
                    'nombre_opcion' => 'Comunitario',
                    'campo_id' => 729
                ],
                [
                    'nombre_opcion' => 'Hogar',
                    'campo_id' => 729
                ],
                [
                    'nombre_opcion' => 'Otros ámbitos',
                    'campo_id' => 729
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 730,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 730,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 731,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 731,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 732,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 732,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 733,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 733,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 734,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 734,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 735,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 735,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 736,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 736,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 737,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 737,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 738,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 738,
                ],

                // Opciones faltantes Tipo de ID* vih - sida
                [
                    'nombre_opcion' => 'RC',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'TI',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'CC',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'CE',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'PA',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'MS',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'AS',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'PE',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'CN',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'CD',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'SC',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'DE',
                    'campo_id' => 687,
                ],
                [
                    'nombre_opcion' => 'PT',
                    'campo_id' => 687,
                ],
                // LEISHMANIASIS
                [
                    'nombre_opcion' => 'Notificación rutinaria',
                    'campo_id' => 740,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa Inst.',
                    'campo_id' => 740,
                ],
                [
                    'nombre_opcion' => 'Vigilancia Intensificada',
                    'campo_id' => 740,
                ],
                [
                    'nombre_opcion' => 'Búsqueda activa com.',
                    'campo_id' => 740,
                ],
                [
                    'nombre_opcion' => 'Investigaciones',
                    'campo_id' => 740,
                ],

                [
                    'nombre_opcion' => 'Sospechoso',
                    'campo_id' => 744,
                ],
                [
                    'nombre_opcion' => 'Probable',
                    'campo_id' => 744,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 744,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 744,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 744,
                ],

                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 745,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 745,
                ],

                [
                    'nombre_opcion' => 'Vivo',
                    'campo_id' => 747,
                ],
                [
                    'nombre_opcion' => 'Muerto',
                    'campo_id' => 747,
                ],
                [
                    'nombre_opcion' => 'No sabe, no responde',
                    'campo_id' => 747,
                ],

                [
                    'nombre_opcion' => 'No aplica',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Conf. por laboratorio',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Conf. Clínica',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Conf. nexo epidemiológico',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Descartado',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Otra actualización',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Descartado por error de digitación',
                    'campo_id' => 751,
                ],
                [
                    'nombre_opcion' => 'Cara',
                    'campo_id' => 753
                ],
                [
                    'nombre_opcion' => 'Tronco',
                    'campo_id' => 753
                ],
                [
                    'nombre_opcion' => 'Miembros superiores',
                    'campo_id' => 753
                ],
                [
                    'nombre_opcion' => 'Miembros inferiores',
                    'campo_id' => 753
                ],
                [
                    'nombre_opcion' => 'Nasal',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Cavidad oral',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Labios',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Faringe',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Laringe',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Párpados',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Genitales',
                    'campo_id' => 754
                ],
                [
                    'nombre_opcion' => 'Rinorrea',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Epistaxis',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Obstrucción nasal',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Disfonía',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Disfagia',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Hiperemia mucosa',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Ulceración mucosa',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Perforación tabique',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Destrucción tabique',
                    'campo_id' => 755
                ],
                [
                    'nombre_opcion' => 'Fiebre',
                    'campo_id' => 756,
                ],
                [
                    'nombre_opcion' => 'Hepatomegalia',
                    'campo_id' => 756,
                ],
                [
                    'nombre_opcion' => 'Esplenomegalia',
                    'campo_id' => 756,
                ],
                [
                    'nombre_opcion' => 'Anemia',
                    'campo_id' => 756,
                ],
                [
                    'nombre_opcion' => 'Leucocitos por debajo de 5.000 mm3',
                    'campo_id' => 756,
                ],
                [
                    'nombre_opcion' => 'Plaquetas por debajo de 150.000 mm3',
                    'campo_id' => 756,
                ],
                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 757,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 757,
                ],
                [
                    'nombre_opcion' => 'Desconocido',
                    'campo_id' => 757,
                ],
                [
                    'nombre_opcion' => 'Si',
                    'campo_id' => 758,
                ],
                [
                    'nombre_opcion' => 'No',
                    'campo_id' => 758,
                ],
                [
                    'nombre_opcion' => 'Crioterapia',
                    'campo_id' => 759,
                ],
                [
                    'nombre_opcion' => 'Termoterapia',
                    'campo_id' => 759,
                ],
                [
                    'nombre_opcion' => 'N-metil glucamina (Glucantime)',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Estibogluconato de sodio',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Isotionato de pentamidina',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Anfotericina B',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Otro',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Miltefosina',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Pentamidina',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Sin tratamiento',
                    'campo_id' => 761
                ],
                [
                    'nombre_opcion' => 'Sangre total',
                    'campo_id' => 768,
                ],
                [
                    'nombre_opcion' => 'Tejido',
                    'campo_id' => 768,
                ],
                [
                    'nombre_opcion' => 'Linfa',
                    'campo_id' => 768,
                ],
                // CUTÁNEA
                [
                    'nombre_opcion' => 'CUTÁNEA - Estudio directo',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'CUTÁNEA - Aspirado bazo',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'CUTÁNEA - Aspirado médula',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'CUTÁNEA - Prueba Montenegro',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'CUTÁNEA - Biopsia',
                    'campo_id' => 769
                ],
                // MUCOSA
                [
                    'nombre_opcion' => 'MUCOSA - Estudio directo',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'MUCOSA - Título IFI',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'MUCOSA - Aspirado bazo',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'MUCOSA - Aspirado médula',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'MUCOSA - Prueba Montenegro',
                    'campo_id' => 769
                ],
                // VISCERAL
                [
                    'nombre_opcion' => 'VISCERAL - Hematócrito',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Hemoglobina',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Plaquetas',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Estudio directo',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Título IFI',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Aspirado bazo',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Aspirado médula',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Pruebas Montenegro',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'VISCERAL - Albúmina',
                    'campo_id' => 769
                ],
                [
                    'nombre_opcion' => 'Leishmania',
                    'campo_id' => 770,
                ],
                [
                    'nombre_opcion' => 'Positivo',
                    'campo_id' => 771,
                ],
                [
                    'nombre_opcion' => 'Negativo',
                    'campo_id' => 771,
                ],
                [
                    'nombre_opcion' => 'Compatible',
                    'campo_id' => 771,
                ],
                [
                    'nombre_opcion' => 'No compatible',
                    'campo_id' => 771,
                ],

            ];
            foreach ($opcionesCampoSivigilas as $opcionesCampoSivigila) {
                OpcionesCampoSivigila::updateOrCreate([
                    'nombre_opcion' =>  $opcionesCampoSivigila['nombre_opcion'],
                    'campo_id' => $opcionesCampoSivigila['campo_id'],
                ], [
                    'nombre_opcion' =>  $opcionesCampoSivigila['nombre_opcion'],
                    'campo_id' => $opcionesCampoSivigila['campo_id'],
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error en OpcionesCampoSivigila: ' . $th->getMessage());
        }
    }
}
