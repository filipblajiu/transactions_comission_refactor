<?php

namespace App\ThirdParties\BinList;

class BinList
{
    private $client;
    private $useMock;

    function __construct($useMock = false)
    {
        $this->useMock = $useMock;
        $this->client = $this->getClient();
    }

    public function getIsoCodeByCardNumber(string $binNumber)
    {
        return $this->client->getIsoCodeByCardNumber($binNumber);
    }

    public function getClient()
    {
        if($this->useMock) {
            return new BinListMockClient;
        }
        return new BinListClient;
    }
}