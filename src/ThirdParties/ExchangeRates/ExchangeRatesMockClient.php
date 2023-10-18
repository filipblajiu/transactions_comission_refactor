<?php

namespace App\ThirdParties\ExchangeRates;

class ExchangeRatesMockClient
{
    public function getCurrencyRate(string $currency, string $baseCurrency = 'EUR'): string
    {
        $mockData = file_get_contents(__DIR__ . '/mock/getCurrencyRateResponse.json');
        $response = json_decode($mockData);
        return $response->rates->{$currency};
    }
}