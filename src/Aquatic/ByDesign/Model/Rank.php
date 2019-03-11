<?php

namespace Aquatic\ByDesign\Model;

class Rank
{
    public $id;
    public $description;
    public $abbreviation;

    public function __construct(int $id, string $description, string $abbreviation)
    {
        $this->id = $id;
        $this->description = $description;
        $this->abbreviation = $abbreviation;
    }
}
