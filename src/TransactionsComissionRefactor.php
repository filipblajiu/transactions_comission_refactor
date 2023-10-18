<?php

namespace App;

use App\ThirdParties\BinList\BinList;
use App\ThirdParties\ExchangeRates\ExchangeRates;
use App\Traits\CountryTrait;

class TransactionsComissionRefactor
{
    use CountryTrait;

    const COMISSION_RATE_IN_EU = 0.01;
    const COMISSION_RATE_OUT_EU = 0.02;

    public $data;
    public $exchangeRateService;
    public $binService;

    public $useMock = true;

    function __construct(array $data)
    {
        $this->data = $data;
        $this->binService = new BinList($this->useMock);
        $this->exchangeRateService = new ExchangeRates($this->useMock);
    }

    public function rates(): array
    {
        $rates = [];
        foreach ($this->data as $row){
            if (empty($row)) {
                continue;
            }
            
            $eurAmount = $this->convertToEur($row->currency, (float) $row->amount);

            $isoCode = $this->binService->getIsoCodeByCardNumber($row->bin);
            $comissionRate = $this->getComissionRateByCountry($isoCode);
            $comission = round($eurAmount * $comissionRate, 2);    

            $rates[] = [
                'bin' => $row->bin,
                'binCountry' => $isoCode,
                'inEu' => $this->isCountryInEurope($isoCode),
                'amount' => $row->amount,
                'currency' => $row->currency,
                'eurAmount' => $eurAmount,
                'eurComission' => $comission,
            ]; 
        }
        return $rates;
    }

    private function convertToEur(string $currecy, float $amount): float
    {
        $rate = $this->exchangeRateService->getCurrencyRate($currecy);
        if($currecy == 'EUR' || $rate == 1) {
            return $amount;
        }
        return $amount / $rate;
    }

    public function getComissionRateByCountry(string $isoCode): float
    {
        if($this->isCountryInEurope($isoCode)) {
            return self::COMISSION_RATE_IN_EU;
        }
        return self::COMISSION_RATE_OUT_EU;
    }
}