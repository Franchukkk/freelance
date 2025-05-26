<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NovaPostService;

class NovaPostController extends Controller
{
    public $novaPostService;

    public function __construct(NovaPostService $novaPostService)
    {
        $this->novaPostService = $novaPostService;
    }

    public function getSettlements()
    {
        dd($this->novaPostService->getSettlements());
    }

    public function getAreas()
    {
        dd($this->novaPostService->getAreas());
    }

    public function getDistricts()
    {
        dd($this->novaPostService->getDistricts('dcaae4e5-4b33-11e4-ab6d-005056801329'));
    }

    public function getWarehouses()
    {
        dd($this->novaPostService->getWarehouses());
    }

    public function saveCounterparty()
    {
        $counterparty = $this->novaPostService->saveCounterparty();

        $counterparty = $this->novaPostService->getCounterpartyContactPersons($counterparty[0]['Ref']);

        dd($counterparty);
    }
}
