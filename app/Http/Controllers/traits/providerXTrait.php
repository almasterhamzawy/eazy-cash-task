<?php

namespace App\Http\Controllers\traits;

trait providerXTrait
{
    public function getDataProviderX()
    {
        $data = file_get_contents(public_path("DataProviderX.json"));
        $dataArray = json_decode($data, true);
        /*==================================================================*/

        $mappingKeys = [
            "transactionIdentification" => "id",
            "transactionDate" => "created_at",
            "transactionStatus" => "status",
            "senderPhone" => "phone",
            "Currency" => "currency",
            "transactionAmount" => "amount"
        ];
        /*==================================================================*/
        $statusMapper = [
            "1" => "paid",
            "2" => "pending",
            "3" => "reject"
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
