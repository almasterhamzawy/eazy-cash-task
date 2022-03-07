<?php

namespace App\Http\Controllers\traits;

trait providerWTrait
{
    public function getDataProviderW()
    {
        $data = file_get_contents(public_path("DataProviderW.json"));
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
            "done" => "paid",
            "wait" => "pending",
            "nope" => "reject"
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
        /*==================================================================*/
    }
}
