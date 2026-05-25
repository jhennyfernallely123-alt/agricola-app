<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cultivo;
use App\Models\Parcela;
use App\Models\Personal;
use App\Models\LaborAgricola;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DebugUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_update()
    {
        $parcela = Parcela::factory()->create();
        $cultivo = Cultivo::factory()->for($parcela)->create();
        $personal = Personal::factory()->create();
        $labor = LaborAgricola::create([
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Riego',
            'fecha' => '2026-01-15',
        ]);

        $log = function($msg) use ($labor) {
            file_put_contents('D:\temp\debug_output.txt', $msg . PHP_EOL, FILE_APPEND);
        };

        $log('Before: tipo=' . $labor->tipo . ' id=' . $labor->id);
        $log('Route URL: ' . route('labores-agricolas.update', $labor));

        // Manually check the model is in DB
        $fromDb = LaborAgricola::find($labor->id);
        $log('DB check: tipo=' . $fromDb->tipo . ' exists=' . ($fromDb ? 'yes' : 'no'));

        // Try a manual update first to confirm DB works
        $fromDb->update(['tipo' => 'Manual Test']);
        $log('After manual update: tipo=' . $labor->fresh()->tipo);

        // Now try the HTTP PUT
        $response = $this->put(route('labores-agricolas.update', $labor), [
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Fertilización',
            'fecha' => '2026-01-15',
        ]);

        $log('Status: ' . $response->getStatusCode());
        $log('Location: ' . $response->headers->get('Location'));
        $log('After HTTP update: tipo=' . $labor->fresh()->tipo);
        $log('Session errors: ' . ($response->getSession()->has('errors') ? 'yes' : 'no'));

        if ($response->getSession()->has('errors')) {
            $log('Errors: ' . json_encode($response->getSession()->get('errors')->toArray()));
        }

        // Check what the controller would see
        $routes = app('router')->getRoutes();
        $route = $routes->match(request()->create(route('labores-agricolas.update', $labor), 'PUT', [
            'cultivo_id' => $cultivo->id,
            'empleado_id' => $personal->id,
            'tipo' => 'Fertilización',
            'fecha' => '2026-01-15',
        ]));
        $log('Matched route: ' . $route->uri());
        $log('Action: ' . $route->getActionName());

        $this->assertTrue(true);
    }
}
