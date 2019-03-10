<?php

namespace Aquatic\ByDesign\Model;

class Geocode
{
    public $cities = [];
    public $states = [];
    public $counties = [];

    public function __construct(array $cities, array $states, array $counties)
    {
        $this->cities = $cities;
        $this->states = $states;
        $this->counties = $counties;
    }
}
