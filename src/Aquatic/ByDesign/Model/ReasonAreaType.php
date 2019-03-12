<?php

namespace Aquatic\ByDesign\Model;

class ReasonAreaType
{
    public $id;
    public $description;
    public $explanation;

    public function __construct(int $id, string $description, string $explanation)
    {
        $this->id = $id;
        $this->description = $description;
        $this->explanation = $explanation;
    }
}
