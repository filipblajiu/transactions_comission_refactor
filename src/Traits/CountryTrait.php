<?php

namespace App\Traits;

trait CountryTrait
{
    private $eu_iso_codes = ['AT','BE','BG','CY','CZ','DE','DK','EE','ES','FI','FR','GR','HR','HU','IE','IT','LT','LU','LV','MT','NL','PO','PT','RO','SE','SI','SK'];

    private function isCountryInEurope(string $isoCode): bool
    {
        if(!in_array($isoCode, $this->eu_iso_codes)) {
            return false;
        }
        return true;
    }
}