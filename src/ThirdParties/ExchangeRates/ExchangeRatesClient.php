<?php

namespace App\ThirdParties\ExchangeRates;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class ExchangeRatesClient
{
    const BASE_URL = 'http://api.exchangeratesapi.io';
    const LATEST = '/latest';

    const ACCESS_KEY = '3f4bdd67ad4635eb6644e8e18b503135';

    public function getCurrencyRate(string $currency, string $baseCurrency = 'EUR'): string
    {
        $client = $this->getClient([
            RequestOptions::QUERY => [
                'base' => $baseCurrency
            ], 
        ]);
        $response = $this->checkResponse($client->get(self::BASE_URL . self::LATEST));
        return $response->rates->{$currency};
    }

    private function getClient(array $extraConfig = []): Client
    {
        $config = array_merge_recursive([
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::QUERY => [
                'access_key' => self::ACCESS_KEY
            ]
        ], $extraConfig);

        return new Client($config);
    }

    private function checkResponse($response)
    {
        $responseContent = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();
        switch($statusCode) {
            case 200:
                $response = json_decode($responseContent);
                if($response->success) {
                    return $response;
                }
            default:
                throw new \Exception("[ERROR][{$statusCode}]: {$responseContent}");
        }
    }
}