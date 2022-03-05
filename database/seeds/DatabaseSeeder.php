<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeedParaRoles::class);
        $this->call(SeedParaUsuarios::class);
        $this->call(SeedParaParametricas::class);
        $this->call(SeedParaTipoMp::class);
        $this->call(SeedParaActuacion::class);
        $this->call(SeedParaClaseDiligencia::class);
        $this->call(SeedParaEstadoAudiencia::class);
        $this->call(SeedParaClasePolicivo::class);
        $this->call(SeedParaCriterioCreacion::class);
        $this->call(SeedParaCriterioIntervencion::class);
        $this->call(SeedParaDelegada::class);
        $this->call(SeedParaDelito::class);
        $this->call(SeedParaDespacho::class);
        $this->call(SeedParaAutoridadAdmin::class);
        $this->call(SeedParaTipoVictima::class);
        $this->call(SeedParaUnidad::class);
        $this->call(SeedParaFestivos::class);
        $this->call(SeedParaDespachoJ::class);
    }
}
