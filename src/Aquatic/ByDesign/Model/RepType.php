<?php

namespace Aquatic\ByDesign\Model;

class RepType
{
    public $id;
    public $description;
    public $abbreviation;
    public $order_type;
    public $auto_ship_order_type;
    public $is_default;

    public function __construct(
        int $id,
        string $description,
        string $abbreviation,
        string $order_type,
        string $auto_ship_order_type,
        bool $is_default
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->abbreviation = $abbreviation;
        $this->order_type = $order_type;
        $this->auto_ship_order_type = $auto_ship_order_type;
        $this->is_default = $is_default;
    }
}
