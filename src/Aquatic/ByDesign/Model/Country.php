<?php

namespace Aquatic\ByDesign\Model;

use Aquatic\ByDesign\WebAPI\GetCountryResponseItem;

class Country
{
    public $id;
    public $description = '';
    public $is_default = false;
    public $is_active = false;
    public $abbreviation = '';

    public function __construct(int $id, string $description, bool $is_default, bool $is_active, string $abbreviation)
    {
        $this->id = $id;
        $this->description = $description;
        $this->is_default = $is_default;
        $this->is_active = $is_active;
        $this->abbreviation = $abbreviation;
    }

    public static function fromAPI(GetCountryResponseItem $country)
    {
        return new Country(
            (int) $country->ID,
            (string) $country->Description,
            (bool) $country->IsDefault,
            (bool) $country->IsActive,
            (string) $country->Abbreviation
        );
    }
}
