<?php

namespace Aquatic\ByDesign\Model;

class CustomerType
{
    public $id;
    public $description;
    public $abbreviation;
    public $order_type;
    public $auto_ship_order_type;
    public $is_extranet;
    public $is_allow_update_from;
    public $is_allow_update_to;
    public $is_allow_new_profile_from_ext;

    public function __construct(
        int $id,
        string $description,
        string $abbreviation,
        string $order_type,
        string $auto_ship_order_type,
        bool $is_extranet,
        bool $is_allow_update_from,
        bool $is_allow_update_to,
        bool $is_allow_new_profile_from_ext
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->abbreviation = $abbreviation;
        $this->order_type = $order_type;
        $this->auto_ship_order_type = $auto_ship_order_type;
        $this->is_extranet = $is_extranet;
        $this->is_allow_update_from = $is_allow_update_from;
        $this->is_allow_update_to = $is_allow_update_to;
        $this->is_allow_new_profile_from_ext = $is_allow_new_profile_from_ext;
    }
}
