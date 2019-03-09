<?php

namespace Aquatic\ByDesign\Model;

class PartyStatus
{
    public $id;
    public $description;
    public $is_official;

    public function __construct(int $id, string $description, bool $is_official)
    {
        $this->id = $id;
        $this->description = $description;
        $this->is_official = $is_official;
    }
}
