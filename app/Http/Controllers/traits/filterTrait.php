<?php

namespace App\Http\Controllers\traits;

trait filterTrait
{
    private $filterFunctions = [
        "statusCode" => "filterByStatus",
        "currency" => "filterByCurrency",
        "amounteMin" => "filterByMinAmount",
        "amounteMax" => "filterByMaxAmount",
    ];

    /*==================================================================*/
    public function filterData()
    {
        $filterData = request()->all();
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                if (isset($this->filterFunctions[$key])) {
                    $runFilterFunction = $this->filterFunctions[$key];
                    array_push($this->filterArray, $this->{$runFilterFunction}($value));
                }
            }
        }
        return true;
    }

    /*==================================================================*/
    private function filterByStatus($status)
    {
        return ["column" => "status", "operator" => "=", "value" => $status];
    }

    /*==================================================================*/
    private function filterByCurrency($currency)
    {
        return ["column" => "currency", "operator" => "=", "value" => $currency];
    }

    /*==================================================================*/
    private function filterByMinAmount($amount)
    {
        return ["column" => "amount", "operator" => ">=", "value" => $amount];
    }

    /*==================================================================*/
    private function filterByMaxAmount($amount)
    {
        return ["column" => "amount", "operator" => "<=", "value" => $amount];
    }
    /*==================================================================*/
}
