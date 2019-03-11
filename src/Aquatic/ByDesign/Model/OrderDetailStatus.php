<?php

namespace Aquatic\ByDesign\Model;

class OrderDetailStatus
{
    public $id;
    public $description;
    public $is_od_official;
    public $is_official_not_yet_shipped;

    public function __construct(int $id, string $description, bool $is_od_official, bool $is_official_not_yet_shipped)
    {
        $this->id = $id;
        $this->description = $description;
        $this->is_od_official = $is_od_official;
        $this->is_official_not_yet_shipped = $is_official_not_yet_shipped;
    }
}
