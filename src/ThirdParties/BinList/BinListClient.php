<?php

namespace App\ThirdParties\BinList;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class BinListClient
{
    const BASE_URL = 'https://lookup.binlist.net';

    public function getIsoCodeByCardNumber(string $binNumber): string
    {
        $client = $this->getClient();
        $response = $this->checkResponse($client->get(self::BASE_URL . "/{$binNumber}"));
        return $response->country->alpha2;
    }

    private function getClient(array $extraConfig = []): Client
    {
        $config = array_merge_recursive([
            RequestOptions::HTTP_ERRORS => false,
        ], $extraConfig);

        return new Client($config);
    }

    private function checkResponse($response)
    {
        $responseContent = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();
        switch($statusCode) {
            case 200:
                return json_decode($responseContent);
            default:
                throw new \Exception("[ERROR][{$statusCode}]: {$responseContent}");
        }
    }
}