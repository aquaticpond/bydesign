<?php

namespace Aquatic\ByDesign\Model;

class InventoryImageType
{
    public $id;
    public $image_key;

    public function __construct(int $id, string $image_key)
    {
        $this->id = $id;
        $this->image_key = $image_key;
    }
}
