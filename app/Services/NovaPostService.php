<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NovaPostService
{
    private $novaPostApiKey;

    public function __construct()
    {
        $this->novaPostApiKey = env('NOVA_POSHTA_API_KEY');
    }

    public function createTTN()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey"=> $this->novaPostApiKey,
            "modelName"=> "InternetDocumentGeneral",
            "calledMethod"=> "save",
            "methodProperties" => [
                "PayerType" => "Sender",
                "PaymentMethod" => "Cash",
                "DateTime" => now(),
                "CargoType" => "Parsel",
                "VolumeGeneral" => "0.45",
                "Weight" => "0.5",
                "ServiceType" => "DoorsWarehouse",
                "SeatsAmount" => "2",
                "Description" => "Додатковий опис відправлення",
                "Cost" => "15000",
                "CitySender" => "00000000-0000-0000-0000-000000000000",
                "Sender" => "00000000-0000-0000-0000-000000000000",
                "SenderAddress" => "00000000-0000-0000-0000-000000000000",
                "ContactSender" => "00000000-0000-0000-0000-000000000000",
                "SendersPhone" => "380660000000",
                "CityRecipient" => "00000000-0000-0000-0000-000000000000",
                "Recipient" => "00000000-0000-0000-0000-000000000000",
                "RecipientAddress" => "00000000-0000-0000-0000-000000000000",
                "ContactRecipient" => "00000000-0000-0000-0000-000000000000",
                "RecipientsPhone" => "380660000000"
            ]
        ]);
    }

    public function getSettlements()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey"=> $this->novaPostApiKey,
            "modelName"=> "Address",
            "calledMethod"=> "getCities",
            "methodProperties" => [
                "FindByString" => "Хмельницький",
                "Limit" => "150",
                "Page" => "1"
            ]
        ]);
        $result = [];

        if ($response->successful()) {
            $result = $response->json()['data'];
        }

        return $result;
    }

    public function getAreas()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey"=> $this->novaPostApiKey,
            "modelName"=> "Address",
            "calledMethod"=> "getSettlementAreas",
            "methodProperties" => [
                "Page" => "1",
                "Limit" => "150"
            ]
        ]);
        
        $result = [];

        if ($response->successful()) {
            $result = $response->json()['data'];
        }

        return $result;
    }

    public function getDistricts($regionRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey"=> $this->novaPostApiKey,
            "modelName"=> "Address",
            "calledMethod"=> "getSettlementCountryRegion",
            "methodProperties" => [
                "AreaRef" => $regionRef
            ]
        ]);
        $result = [];

        if ($response->successful()) {
            $result = $response->json()['data'];
        }
    
        return $result;
    }

    public function getWarehouses()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey"=> $this->novaPostApiKey,
            "modelName"=> "AddressGeneral",
            "calledMethod"=> "getWarehouses",
            "methodProperties" => [
                "CityName" => "Хмельницький",
            ]
        ]);
        $result = [];

        if ($response->successful()) {
            $result = $response->json()['data'];
        }
        return $result;

    }

    public function saveCounterparty()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => $this->novaPostApiKey,
            "modelName" => "CounterpartyGeneral",
            "calledMethod" => "save",
            "methodProperties" => [
                "FirstName" => "Іван",
                "MiddleName" => "Іванович",
                "LastName" => "Іванов",
                "Phone" => "380997979789",
                "Email" => "test@i.com",
                "CounterpartyType" => "PrivatePerson",
                "CounterpartyProperty" => "Recipient"
            ]
        ]);

        $result = [];

        if ($response->successful()) {
            $result = $response->json()['data'];
        }
        return $result;

    }

    public function getCounterpartyContactPersons($ref)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => $this->novaPostApiKey,
            "modelName" => "CounterpartyGeneral",
            "calledMethod" => "getCounterpartyContactPersons",
            "methodProperties" => [
                "Ref" => $ref
            ]
        ]);
        $result = [];
        if ($response->successful()) {
            $result = $response->json()['data'];
        }
        return $result;
    }


}