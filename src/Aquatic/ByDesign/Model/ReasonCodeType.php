<?php

namespace Aquatic\ByDesign\Model;

class ReasonCodeType
{
    public $id;
    public $reason_area_type_id;
    public $description;
    public $explanation;
    public $is_active;

    public function __construct(int $id, string $description, string $explanation, bool $is_active, int $reason_area_type_id)
    {
        $this->id = $id;
        $this->description = $description;
        $this->explanation = $explanation;
        $this->is_active = $is_active;
        $this->reason_area_type_id = $reason_area_type_id;
    }
}
