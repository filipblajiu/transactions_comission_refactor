<?php

namespace App\ThirdParties\ExchangeRates;

class ExchangeRates
{
    private $client;
    private $useMock;

    function __construct($useMock = false)
    {
        $this->useMock = $useMock;
        $this->client = $this->getClient();
    }

    public function getCurrencyRate(string $currency, string $baseCurrency = 'EUR')
    {
        return $this->client->getCurrencyRate($currency, $baseCurrency);
    }

    public function getClient()
    {
        if($this->useMock) {
            return new ExchangeRatesMockClient;
        }
        return new ExchangeRatesClient;
    }
}