<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NovaPostService;
use App\Models\NovaPostDistrict;
use App\Models\NovaPostArea;

class GetNovaPostDistricts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-nova-post-districts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Nova Post Districts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $novaPostService = new NovaPostService();

        $areas = NovaPostArea::all();
        foreach ($areas as $area) {
            $regions = $novaPostService->getDistricts($area->ref);

            foreach ($regions as $region) {
                NovaPostDistrict::updateOrCreate(
                    ['ref' => $region['Ref']],
                    ['name' => $region['Description'], 'area_id' => $area->id]
                );
            }
        }

        $this->info(now() . ': ' . $this->description);
    }
}
