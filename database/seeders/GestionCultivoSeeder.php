<?php

namespace Database\Seeders;

use App\Models\Parcela;
use App\Models\Cultivo;
use App\Models\SistemaRiego;
use App\Models\InsumoAgricola;
use App\Models\PlanCultivo;
use App\Models\EtapaFenologica;
use App\Models\LaborAgricola;
use App\Models\PlanFertilizacion;
use App\Models\ControlPlagasEnfermedades;
use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GestionCultivoSeeder extends Seeder
{
    /**
     * Seed del módulo Gestión de Cultivo con datos realistas colombianos.
     */
    public function run(): void
    {
        // ====================================================================
        // 1. PARCELAS — Fincas colombianas con nombres típicos
        // ====================================================================
        $parcelas = [
            [
                'nombre' => 'La Esperanza',
                'area' => 45.5,
                'historial_uso' => 'Cultivo rotativo de hortalizas y frutales durante los últimos 10 años. Anteriormente maíz y frijol.',
                'analisis_suelo' => 'pH 6.2, materia orgánica 3.5%, textura franco-arcillosa, buen drenaje.',
                'potencial_productivo' => 'Alto',
            ],
            [
                'nombre' => 'El Porvenir',
                'area' => 32.0,
                'historial_uso' => 'Cultivo de tomate y pimentón en rotación. Suelo descansado 2 años.',
                'analisis_suelo' => 'pH 5.8, materia orgánica 2.8%, textura franca, requiere enmienda calcárea.',
                'potencial_productivo' => 'Medio',
            ],
            [
                'nombre' => 'Buenavista',
                'area' => 28.7,
                'historial_uso' => 'Producción de fresas y moras. Cultivo intensivo con acolchado plástico.',
                'analisis_suelo' => 'pH 6.5, materia orgánica 4.2%, textura franco-arenosa, excelente drenaje.',
                'potencial_productivo' => 'Alto',
            ],
            [
                'nombre' => 'San Isidro Labrador',
                'area' => 52.3,
                'historial_uso' => 'Cultivo de cítricos y aguacate. Huerta mixta con sombrío.',
                'analisis_suelo' => 'pH 6.0, materia orgánica 3.0%, textura arcillosa, drenaje moderado.',
                'potencial_productivo' => 'Alto',
            ],
            [
                'nombre' => 'Los Arrayanes',
                'area' => 18.2,
                'historial_uso' => 'Producción orgánica de lechugas y verduras de hoja. Certificación orgánica vigente.',
                'analisis_suelo' => 'pH 6.8, materia orgánica 5.0%, textura franca, rica en nutrientes.',
                'potencial_productivo' => 'Medio',
            ],
            [
                'nombre' => 'El Manantial',
                'area' => 22.0,
                'historial_uso' => 'Cultivo de gulupa y granadilla. Sistema de espaldera con riego por goteo.',
                'analisis_suelo' => 'pH 6.3, materia orgánica 3.8%, textura franco-arenosa, buen drenaje.',
                'potencial_productivo' => 'Alto',
            ],
            [
                'nombre' => 'Santa Bárbara',
                'area' => 35.8,
                'historial_uso' => 'Cultivo de cebolla de ramas y aromáticas. Sistema de surcos elevados.',
                'analisis_suelo' => 'pH 5.9, materia orgánica 2.5%, textura franco-arcillosa, drenaje regular.',
                'potencial_productivo' => 'Medio',
            ],
            [
                'nombre' => 'La Pradera',
                'area' => 15.0,
                'historial_uso' => 'Semillero y almácigos. Producción de plántulas para trasplante.',
                'analisis_suelo' => 'pH 6.6, materia orgánica 4.5%, textura franca, sustrato enriquecido.',
                'potencial_productivo' => 'Alto',
            ],
        ];

        foreach ($parcelas as $data) {
            Parcela::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $this->command->info('Parcelas creadas: ' . Parcela::count());

        // ====================================================================
        // 2. CULTIVOS — Especies agrícolas sembradas en Colombia
        // ====================================================================
        $cultivosData = [
            ['nombre' => 'Tomate Chonto',           'variedad' => 'Híbrida',        'requerimientos' => 'Riego diario, pH 6.0-6.5, temperatura 18-28°C, tutoreo obligatorio.',              'parcela_id' => 1],
            ['nombre' => 'Cebolla de Ramas',         'variedad' => 'Tradicional',    'requerimientos' => 'Riego cada 3 días, pH 5.5-6.5, temperatura 15-25°C, suelo suelto.',               'parcela_id' => 7],
            ['nombre' => 'Uva Isabella',             'variedad' => 'Criolla',        'requerimientos' => 'Riego por goteo, pH 5.5-6.0, temperatura 22-30°C, poda de formación.',            'parcela_id' => 5],
            ['nombre' => 'Mora de Castilla',          'variedad' => 'Orgánica',       'requerimientos' => 'Riego cada 2 días, pH 5.5-6.5, temperatura 15-25°C, sistema de espaldera.',       'parcela_id' => 3],
            ['nombre' => 'Fresa Albión',             'variedad' => 'Híbrida',        'requerimientos' => 'Riego por goteo, pH 5.5-6.0, temperatura 18-25°C, acolchado plástico.',            'parcela_id' => 3],
            ['nombre' => 'Lechuga Crespa',           'variedad' => 'Orgánica',       'requerimientos' => 'Riego diario, pH 6.0-7.0, temperatura 15-22°C, suelo rico en nitrógeno.',          'parcela_id' => 5],
            ['nombre' => 'Pimentón Rojo',            'variedad' => 'Híbrida',        'requerimientos' => 'Riego cada 2 días, pH 6.0-6.5, temperatura 20-28°C, tutorados.',                    'parcela_id' => 2],
            ['nombre' => 'Pepino Coquito',           'variedad' => 'Híbrida',        'requerimientos' => 'Riego diario, pH 6.0-7.0, temperatura 22-30°C, espaldera para guía.',              'parcela_id' => 2],
            ['nombre' => 'Gulupa',                   'variedad' => 'Tradicional',    'requerimientos' => 'Riego por goteo, pH 5.5-6.5, temperatura 15-25°C, espaldera alta de 2.5m.',         'parcela_id' => 6],
            ['nombre' => 'Granadilla',               'variedad' => 'Criolla',        'requerimientos' => 'Riego moderado, pH 5.5-6.0, temperatura 18-28°C, poda de mantenimiento.',          'parcela_id' => 6],
            ['nombre' => 'Aguacate Hass',            'variedad' => 'Injertada',      'requerimientos' => 'Riego moderado, pH 5.5-6.5, temperatura 18-25°C, suelo profundo bien drenado.',    'parcela_id' => 4],
            ['nombre' => 'Cilantro',                 'variedad' => 'Tradicional',    'requerimientos' => 'Riego diario, pH 6.0-7.0, temperatura 15-25°C, cosecha a los 45 días.',             'parcela_id' => 8],
        ];

        foreach ($cultivosData as $data) {
            Cultivo::firstOrCreate(
                ['nombre' => $data['nombre'], 'parcela_id' => $data['parcela_id']],
                $data
            );
        }

        $this->command->info('Cultivos creados: ' . Cultivo::count());

        // ====================================================================
        // 3. SISTEMAS DE RIEGO
        // ====================================================================
        $sistemasRiego = [
            ['tipo' => 'Goteo',         'fuente' => 'Pozo profundo — 45m de profundidad, caudal 5L/s'],
            ['tipo' => 'Aspersión',     'fuente' => 'Río cercano — sistema de bombeo con filtro de arena'],
            ['tipo' => 'Microaspersión','fuente' => 'Embalse — capacidad 5000m³, gravedad asistida'],
            ['tipo' => 'Gravedad',      'fuente' => 'Aguas lluvias — canalización desde tejados 200m²'],
            ['tipo' => 'Exudación',     'fuente' => 'Acueducto veredal — con tanque de almacenamiento 10000L'],
            ['tipo' => 'Goteo automatizado', 'fuente' => 'Pozo artesiano + panel solar 300W para bombeo'],
        ];

        foreach ($sistemasRiego as $data) {
            SistemaRiego::firstOrCreate(
                ['tipo' => $data['tipo']],
                $data
            );
        }

        $this->command->info('Sistemas de riego creados: ' . SistemaRiego::count());

        // ====================================================================
        // 4. INSUMOS AGRÍCOLAS (Fertilizantes)
        // ====================================================================
        $insumos = [
            ['nombre' => 'NPK 15-15-15',        'tipo' => 'Granulado',       'descripcion' => 'Fertilizante balanceado para cultivos de hortalizas. Aplicación al suelo cada 30 días.'],
            ['nombre' => 'Urea Agrícola',       'tipo' => 'Granulado',       'descripcion' => 'Fertilizante nitrogenado 46% N. Ideal para crecimiento vegetativo.'],
            ['nombre' => 'Fertilizante Líquido 10-20-10', 'tipo' => 'Líquido', 'descripcion' => 'Fertilizante líquido de rápida absorción. Aplicación foliar.'],
            ['nombre' => 'Cal Dolomítica',      'tipo' => 'Enmienda',        'descripcion' => 'Enmienda para corrección de pH y aporte de calcio y magnesio.'],
            ['nombre' => 'Compost Orgánico',    'tipo' => 'Orgánico',        'descripcion' => 'Abono orgánico producido en finca a partir de residuos de cosecha y estiércol.'],
            ['nombre' => 'Triple 18',           'tipo' => 'Granulado',       'descripcion' => 'Fertilizante NPK 18-18-18 para aplicación base en cultivos de alta demanda.'],
            ['nombre' => 'Sulfato de Potasio',  'tipo' => 'Soluble',         'descripcion' => 'Fuente de potasio 52% K2O para fertirriego. Mejora calidad de frutos.'],
            ['nombre' => 'Fosfito de Potasio',  'tipo' => 'Líquido',         'descripcion' => 'Bioestimulante y fungicida sistémico. Aplicación foliar preventiva.'],
        ];

        foreach ($insumos as $data) {
            InsumoAgricola::firstOrCreate(
                ['nombre' => $data['nombre']],
                $data
            );
        }

        $this->command->info('Insumos agrícolas creados: ' . InsumoAgricola::count());

        // ====================================================================
        // 5. ASIGNAR SISTEMAS DE RIEGO A CULTIVOS (N:M)
        // ====================================================================
        $cultivo1 = Cultivo::find(1); // Tomate Chonto
        $cultivo2 = Cultivo::find(3); // Uva Isabella
        $cultivo3 = Cultivo::find(5); // Fresa Albión

        if ($cultivo1 && SistemaRiego::find(1)) {
            $cultivo1->sistemasRiego()->syncWithoutDetaching([1]); // Goteo
        }
        if ($cultivo2 && SistemaRiego::find(1)) {
            $cultivo2->sistemasRiego()->syncWithoutDetaching([1]); // Goteo
        }
        if ($cultivo3 && SistemaRiego::find(1)) {
            $cultivo3->sistemasRiego()->syncWithoutDetaching([1]); // Goteo
        }
        if ($cultivo1 && SistemaRiego::find(2)) {
            $cultivo1->sistemasRiego()->syncWithoutDetaching([2]); // Aspersión (para semillero)
        }
        if (Cultivo::find(6) && SistemaRiego::find(3)) {
            Cultivo::find(6)->sistemasRiego()->syncWithoutDetaching([3]); // Microaspersión para lechuga
        }

        // ====================================================================
        // 6. ASIGNAR INSUMOS A CULTIVOS (N:M)
        // ====================================================================
        if ($cultivo1 && InsumoAgricola::find(1)) {
            $cultivo1->insumosAgricolas()->syncWithoutDetaching([1, 3]); // NPK + Líquido para tomate
        }
        if (Cultivo::find(4) && InsumoAgricola::find(5)) {
            Cultivo::find(4)->insumosAgricolas()->syncWithoutDetaching([5, 8]); // Compost + Fosfito para mora
        }
        if (Cultivo::find(6) && InsumoAgricola::find(5)) {
            Cultivo::find(6)->insumosAgricolas()->syncWithoutDetaching([5, 2]); // Compost + Urea para lechuga
        }

        // ====================================================================
        // 7. PLANES DE CULTIVO
        // ====================================================================
        PlanCultivo::create([
            'cultivo_id' => 1,
            'fecha_inicio' => Carbon::parse('2026-01-15'),
            'fecha_fin_prevista' => Carbon::parse('2026-04-30'),
            'objetivo_produccion' => 8500.00,
        ]);
        PlanCultivo::create([
            'cultivo_id' => 3,
            'fecha_inicio' => Carbon::parse('2026-02-01'),
            'fecha_fin_prevista' => Carbon::parse('2026-07-31'),
            'objetivo_produccion' => 3200.00,
        ]);
        PlanCultivo::create([
            'cultivo_id' => 4,
            'fecha_inicio' => Carbon::parse('2025-08-15'),
            'fecha_fin_prevista' => Carbon::parse('2026-06-30'),
            'objetivo_produccion' => 5000.00,
        ]);
        PlanCultivo::create([
            'cultivo_id' => 6,
            'fecha_inicio' => Carbon::parse('2026-03-01'),
            'fecha_fin_prevista' => Carbon::parse('2026-05-15'),
            'objetivo_produccion' => 12000.00,
        ]);
        PlanCultivo::create([
            'cultivo_id' => 9,
            'fecha_inicio' => Carbon::parse('2025-12-01'),
            'fecha_fin_prevista' => Carbon::parse('2026-08-31'),
            'objetivo_produccion' => 4000.00,
        ]);

        $this->command->info('Planes de cultivo creados: ' . PlanCultivo::count());

        // ====================================================================
        // 8. ETAPAS FENOLÓGICAS
        // ====================================================================
        EtapaFenologica::create(['cultivo_id' => 1, 'nombre' => 'Germinación',             'fecha_inicio' => '2026-01-15', 'requerimientos_especificos' => 'Riego diario, temperatura 22-26°C, humedad 80%']);
        EtapaFenologica::create(['cultivo_id' => 1, 'nombre' => 'Crecimiento vegetativo',   'fecha_inicio' => '2026-02-05', 'requerimientos_especificos' => 'Fertilización NPK, riego cada 2 días, control de malezas']);
        EtapaFenologica::create(['cultivo_id' => 1, 'nombre' => 'Floración',               'fecha_inicio' => '2026-03-01', 'requerimientos_especificos' => 'Aplicación de boro, manejo de polinizadores, riego moderado']);
        EtapaFenologica::create(['cultivo_id' => 1, 'nombre' => 'Fructificación',          'fecha_inicio' => '2026-03-15', 'requerimientos_especificos' => 'Riego constante, potasio, tutoreo de ramas productivas']);
        EtapaFenologica::create(['cultivo_id' => 1, 'nombre' => 'Cosecha',                 'fecha_inicio' => '2026-04-15', 'requerimientos_especificos' => 'Recolección manual en horas frescas, selección por madurez']);

        EtapaFenologica::create(['cultivo_id' => 4, 'nombre' => 'Poda de producción',      'fecha_inicio' => '2026-01-10', 'requerimientos_especificos' => 'Poda de ramas productivas, desinfección de herramientas']);
        EtapaFenologica::create(['cultivo_id' => 4, 'nombre' => 'Floración',               'fecha_inicio' => '2026-02-01', 'requerimientos_especificos' => 'Polinización manual, riego moderado, fertilización potásica']);
        EtapaFenologica::create(['cultivo_id' => 4, 'nombre' => 'Cosecha',                 'fecha_inicio' => '2026-03-15', 'requerimientos_especificos' => 'Cosecha semanal, frutos con coloración característica, manejo poscosecha']);

        EtapaFenologica::create(['cultivo_id' => 6, 'nombre' => 'Germinación',             'fecha_inicio' => '2026-03-01', 'requerimientos_especificos' => 'Sustrato húmedo, temperatura 18-22°C, semillero protegido']);
        EtapaFenologica::create(['cultivo_id' => 6, 'nombre' => 'Trasplante',              'fecha_inicio' => '2026-03-25', 'requerimientos_especificos' => 'Suelo preparado con compost, marco de siembra 30x30cm']);
        EtapaFenologica::create(['cultivo_id' => 6, 'nombre' => 'Crecimiento',             'fecha_inicio' => '2026-04-05', 'requerimientos_especificos' => 'Fertilización nitrogenada, riego por microaspersión']);
        EtapaFenologica::create(['cultivo_id' => 6, 'nombre' => 'Cosecha',                 'fecha_inicio' => '2026-05-01', 'requerimientos_especificos' => 'Corte a ras del suelo, lavado y desinfección, empaque en bolsas']);

        $this->command->info('Etapas fenológicas creadas: ' . EtapaFenologica::count());

        // ====================================================================
        // 9. LABORES AGRÍCOLAS — Necesitan Personal (crear algunos si no existen)
        // ====================================================================
        // Creamos personal básico para labores si no existe aún
        $empleados = [
            ['nombre' => 'Carlos Arturo Martínez', 'habilidades' => 'Siembra y cosecha de hortalizas, manejo de invernadero', 'contrato' => '2025-01-15'],
            ['nombre' => 'María Fernanda Gómez',   'habilidades' => 'Manejo de sistemas de riego y fertirriego', 'contrato' => '2025-03-01'],
            ['nombre' => 'Diego Alejandro Muñoz',  'habilidades' => 'Fertilización, control de plagas y enfermedades', 'contrato' => '2025-06-10'],
            ['nombre' => 'Ana Lucía Restrepo',     'habilidades' => 'Poda, cosecha y manejo poscosecha de frutales', 'contrato' => '2025-02-20'],
        ];

        foreach ($empleados as $data) {
            Personal::firstOrCreate(['nombre' => $data['nombre']], $data);
        }

        $labores = [
            ['cultivo_id' => 1, 'empleado_id' => 1, 'tipo' => 'Preparación del suelo',        'fecha' => '2026-01-10', 'costo' => 350000.00],
            ['cultivo_id' => 1, 'empleado_id' => 1, 'tipo' => 'Siembra',                      'fecha' => '2026-01-15', 'costo' => 280000.00],
            ['cultivo_id' => 1, 'empleado_id' => 2, 'tipo' => 'Instalación de riego por goteo','fecha' => '2026-01-15', 'costo' => 450000.00],
            ['cultivo_id' => 1, 'empleado_id' => 3, 'tipo' => 'Fertilización NPK',            'fecha' => '2026-02-10', 'costo' => 220000.00],
            ['cultivo_id' => 1, 'empleado_id' => 3, 'tipo' => 'Control de plagas',            'fecha' => '2026-03-05', 'costo' => 180000.00],
            ['cultivo_id' => 1, 'empleado_id' => 4, 'tipo' => 'Cosecha',                      'fecha' => '2026-04-18', 'costo' => 520000.00],

            ['cultivo_id' => 4, 'empleado_id' => 4, 'tipo' => 'Poda de producción',           'fecha' => '2026-01-10', 'costo' => 200000.00],
            ['cultivo_id' => 4, 'empleado_id' => 2, 'tipo' => 'Riego',                        'fecha' => '2026-02-01', 'costo' => 100000.00],
            ['cultivo_id' => 4, 'empleado_id' => 4, 'tipo' => 'Cosecha de mora',              'fecha' => '2026-03-20', 'costo' => 380000.00],

            ['cultivo_id' => 6, 'empleado_id' => 1, 'tipo' => 'Siembra en semillero',         'fecha' => '2026-03-01', 'costo' => 150000.00],
            ['cultivo_id' => 6, 'empleado_id' => 1, 'tipo' => 'Trasplante',                   'fecha' => '2026-03-25', 'costo' => 250000.00],
            ['cultivo_id' => 6, 'empleado_id' => 2, 'tipo' => 'Riego por microaspersión',     'fecha' => '2026-04-01', 'costo' => 120000.00],
            ['cultivo_id' => 6, 'empleado_id' => 3, 'tipo' => 'Fertilización foliar',         'fecha' => '2026-04-10', 'costo' => 95000.00],
            ['cultivo_id' => 6, 'empleado_id' => 4, 'tipo' => 'Cosecha de lechuga',           'fecha' => '2026-05-02', 'costo' => 420000.00],
        ];

        foreach ($labores as $data) {
            try {
                LaborAgricola::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados si el seeder se ejecuta múltiples veces
            }
        }

        $this->command->info('Labores agrícolas creadas: ' . LaborAgricola::count());

        // ====================================================================
        // 10. PLANES DE FERTILIZACIÓN
        // ====================================================================
        $planesFert = [
            ['cultivo_id' => 1, 'insumo_agricola_id' => 1, 'dosis' => 150.00, 'metodo' => 'Al voleo'],
            ['cultivo_id' => 1, 'insumo_agricola_id' => 3, 'dosis' => 3.50,  'metodo' => 'Foliar'],
            ['cultivo_id' => 1, 'insumo_agricola_id' => 7, 'dosis' => 80.00, 'metodo' => 'Fertirriego'],
            ['cultivo_id' => 4, 'insumo_agricola_id' => 5, 'dosis' => 500.00,'metodo' => 'Incorporación al suelo'],
            ['cultivo_id' => 4, 'insumo_agricola_id' => 8, 'dosis' => 2.00,  'metodo' => 'Foliar'],
            ['cultivo_id' => 6, 'insumo_agricola_id' => 5, 'dosis' => 300.00,'metodo' => 'Incorporación al suelo'],
            ['cultivo_id' => 6, 'insumo_agricola_id' => 2, 'dosis' => 50.00, 'metodo' => 'Al voleo'],
            ['cultivo_id' => 5, 'insumo_agricola_id' => 7, 'dosis' => 60.00, 'metodo' => 'Fertirriego'],
        ];

        foreach ($planesFert as $data) {
            try {
                PlanFertilizacion::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Planes de fertilización creados: ' . PlanFertilizacion::count());

        // ====================================================================
        // 11. CONTROL DE PLAGAS Y ENFERMEDADES
        // ====================================================================
        $plagas = [
            ['cultivo_id' => 1, 'tipo' => 'Plaga',      'nombre' => 'Pasador del fruto (Neoleucinodes elegantalis)', 'fecha_deteccion' => '2026-02-20', 'tratamiento_aplicado' => 'Aplicación de Bacillus thuringiensis + trampas de feromonas. Control biológico exitoso.'],
            ['cultivo_id' => 1, 'tipo' => 'Enfermedad',  'nombre' => 'Tizón tardío (Phytophthora infestans)',         'fecha_deteccion' => '2026-03-10', 'tratamiento_aplicado' => 'Aplicación de fungicida sistémico Metalaxil-M + Mancozeb. Podar hojas afectadas.'],
            ['cultivo_id' => 4, 'tipo' => 'Plaga',       'nombre' => 'Ácaros (Tetranychus urticae)',                  'fecha_deteccion' => '2026-02-05', 'tratamiento_aplicado' => 'Liberación de ácaros depredadores Phytoseiulus persimilis. Aplicación de azufre micronizado.'],
            ['cultivo_id' => 4, 'tipo' => 'Enfermedad',  'nombre' => 'Mildeo polvoso (Oidium sp.)',                   'fecha_deteccion' => '2026-03-01', 'tratamiento_aplicado' => 'Fungicida a base de bicarbonato de potasio. Mejorar ventilación del cultivo.'],
            ['cultivo_id' => 6, 'tipo' => 'Plaga',       'nombre' => 'Pulgones (Aphididae)',                          'fecha_deteccion' => '2026-04-05', 'tratamiento_aplicado' => 'Jabón potásico + aceite de neem. Lavado de hojas con agua a presión.'],
            ['cultivo_id' => 3, 'tipo' => 'Enfermedad',  'nombre' => 'Mildiu velloso (Plasmopara viticola)',          'fecha_deteccion' => '2026-03-20', 'tratamiento_aplicado' => 'Aplicación de caldo bordelés. Eliminar hojas infectadas.'],
        ];

        foreach ($plagas as $data) {
            try {
                ControlPlagasEnfermedades::create($data);
            } catch (\Exception $e) {
                // Ignorar duplicados
            }
        }

        $this->command->info('Controles de plagas creados: ' . ControlPlagasEnfermedades::count());
    }
}
