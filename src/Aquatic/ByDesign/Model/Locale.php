<?php

namespace Aquatic\ByDesign\Model;

class Locale
{
    public $id;
    public $locale_asp;
    public $description;
    public $iso_description;
    public $is_active;
    public $is_default;
    public $is_decimal_used;
    public $is_decimal_net_used; // @todo: dropped
    public $decimal_value;
    public $locale_net; // @todo: dropped

    public function __construct(
        int $id,
        string $description,
        string $iso_description,
        string $locale_asp,
        bool $is_active,
        bool $is_default,
        bool $is_decimal_used,
        int $decimal_value // @todo: this appears to be an int?
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->locale_asp = $locale_asp;
        $this->iso_description = $iso_description;
        $this->is_active = $is_active;
        $this->is_default = $is_default;
        $this->is_decimal_used = $is_decimal_used;
        $this->decimal_value = $decimal_value;
    }
}
