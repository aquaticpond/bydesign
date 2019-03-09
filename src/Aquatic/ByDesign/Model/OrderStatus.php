<?php

namespace Aquatic\ByDesign\Model;

class OrderStatus
{
    public $id;
    public $description;
    public $abbreviation;
    public $is_official;
    public $is_unofficial_void;
    public $is_unofficial_retry_payment;
    public $is_official_not_yet_shipped;
    public $is_official_shipped;
    public $is_official_entered;
    public $order_detail_status_id;

    public function __construct(
        int $id,
        string $description,
        string $abbreviation,
        bool $is_official,
        bool $is_unofficial_void,
        bool $is_unofficial_retry_payment,
        bool $is_official_not_yet_shipped,
        bool $is_official_shipped,
        bool $is_official_entered,
        int $order_detail_status_id
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->abbreviation = $abbreviation;
        $this->is_official = $is_official;
        $this->is_unofficial_void = $is_unofficial_void;
        $this->is_unofficial_retry_payment = $is_unofficial_retry_payment;
        $this->is_official_not_yet_shipped = $is_official_not_yet_shipped;
        $this->is_official_shipped = $is_official_shipped;
        $this->is_official_entered = $is_official_entered;
        $this->order_detail_status_id = $order_detail_status_id;
    }
}
