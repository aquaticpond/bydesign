<?php

namespace Aquatic\ByDesign\Model;

class InventoryCategoryDetail
{
    public $id;
    public $description;
    public $sort_order;

    public function __construct(int $id, string $description, int $sort_order)
    {
        $this->id = $id;
        $this->description = $description;
        $this->sort_order = $sort_order;
    }
}
