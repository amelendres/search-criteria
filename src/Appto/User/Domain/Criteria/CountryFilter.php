<?php

namespace Appto\User\Domain\Criteria;

use Appto\Common\Domain\Locale\CountryCode;

class CountryFilter implements Filter
{
    private $countries;

    public function __construct(array $countries)
    {
        $this->countries = array_map(function (string $countryCode){
            return new CountryCode($countryCode);
        }, $countries);
    }

    /**
     * @return CountryCode[]
     */
    public function countries() : array
    {
        return $this->countries;
    }

    public function name() : string
    {
        return 'country';
    }

    public function value()
    {
        return array_map(function (CountryCode $countryCode){
            return $countryCode->value();
        }, $this->countries);
    }
}
