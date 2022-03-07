<?php

namespace App\Http\Controllers;

use App\Http\Controllers\traits\filterTrait;
use App\Http\Controllers\traits\providerWTrait;
use App\Http\Controllers\traits\providerXTrait;
use App\Http\Controllers\traits\providerYTrait;

class TransactionController extends Controller
{
    use providerWTrait, providerXTrait, providerYTrait, filterTrait;

    /*=========================================================*/
    private $unifiedData = [],
        $filterArray = [],
        $counter = 0,
        $functionToRun = "",
        $availableProvidersMethods = [
        "getAllProviders",
        "getDataProviderW",
        "getDataProviderX",
        "getDataProviderY",
    ];

    /*=========================================================*/
    public function __construct()
    {
        $this->functionToRun = (request()->has("provider") && !empty(request()->provider)) ? "get" . request()->provider : "getAllProviders";
    }

    /*=========================================================*/
    public function transactionAction()
    {
        $functionToRun = $this->functionToRun;

        if (!in_array($functionToRun, $this->availableProvidersMethods)) {
            throw new \Exception("provider does not exists");
        }

        try {
            $this->{$functionToRun}();

            $data = collect($this->unifiedData);

            $this->filterData();

            if (!empty($this->filterArray)) {
                foreach ($this->filterArray as $filter) {
                    $filterData = $data->where($filter["column"], $filter["operator"], $filter["value"]);
                }
            }

            return response()->json($filterData->all(), 200);
        } catch (\Exception $exception) {

        }

    }

    /*=========================================================*/
    public function getAllProviders()
    {
        $this->getDataProviderW();
        $this->getDataProviderY();
        $this->getDataProviderX();
    }

    /*=========================================================*/
    public function unified($unifiedConfig)
    {
        $mappedData = [];
        $mappingKeys = $unifiedConfig["mappingKeys"];
        $statusMapper = $unifiedConfig["statusMapper"];

        foreach ($unifiedConfig["providerData"] as $providerKey => $providerData) {
            $mappedKey = $mappingKeys[$providerKey];

            $mappedData[$mappedKey] = ($mappedKey == "status") ? $statusMapper[$providerData] : $providerData;

            $this->unifiedData[$this->counter] = $mappedData;
        }
    }
    /*=========================================================*/
}
