<?php

namespace Aquatic\ByDesign\Model;

class Address
{
    public $first_name;
    public $last_name;
    public $company;
    public $street;
    public $street2;
    public $city;
    public $state;
    public $post_code;
    public $county;
    public $country;
    public $phone_number;

    public function __construct(array $params = [])
    {
        $props = array_keys(get_object_vars($this));
        $class = static::class;
        foreach ($params as $key => $val) {
            if (!in_array($key, $props)) {
                \trigger_error("{$key} is not a property in {$class} and will be ignored.", E_USER_WARNING);
                continue;
            }

            $this->$key = $val;
        }
    }
}
