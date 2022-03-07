<?php

namespace App\Http\Controllers\traits;

trait providerYTrait
{
    public function getDataProviderY()
    {
        $data = file_get_contents(public_path("DataProviderY.json"));
        $dataArray = json_decode($data, true);
        /*==================================================================*/

        $mappingKeys = [
            "id" => "id",
            "created_at" => "created_at",
            "status" => "status",
            "phone" => "phone",
            "currency" => "currency",
            "amount" => "amount"
        ];
        /*==================================================================*/
        $statusMapper = [
            "100" => "paid",
            "200" => "pending",
            "300" => "reject"
        ];
        /*==================================================================*/
        $unifiedConfig = [
            'mappingKeys' => $mappingKeys,
            'statusMapper' => $statusMapper
        ];
        /*==================================================================*/
        foreach ($dataArray as $data) {
            $unifiedConfig["providerData"] = $data;
            $this->unified($unifiedConfig);
            $this->counter++;
        }

    }
}
