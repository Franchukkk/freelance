<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\NovaPostService;
use App\Models\NovaPostArea;

class GetNovaPostAreas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-nova-post-areas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Nova Post Areas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $novaPostService = new NovaPostService();
        $areas = $novaPostService->getAreas();
        foreach ($areas as $area) {
            NovaPostArea::updateOrCreate(
                ['ref' => $area['Ref']],
                ['name' => $area['Description']]
            );
        }

        $this->info(now() . ': ' . $this->description);
    }

}