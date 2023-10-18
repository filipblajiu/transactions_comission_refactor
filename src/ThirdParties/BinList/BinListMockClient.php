<?php

namespace App\ThirdParties\BinList;

class BinListMockClient
{
    public function getIsoCodeByCardNumber(string $binNumber): string
    {
        $mockData = file_get_contents(__DIR__ . '/mock/getIsoCodeByCardNumberResponse.json');
        $response = json_decode($mockData);
        return $response->{$binNumber}->country->alpha2;
    }
}