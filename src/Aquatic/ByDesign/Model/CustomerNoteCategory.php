<?php

namespace Aquatic\ByDesign\Model;

class CustomerNoteCategory
{
    public $id;
    public $description;
    public $sort_order;
    public $is_active;
    public $is_cancel_autoship;
    public $is_show_on_extranet;

    public function __construct(int $id, string $description, int $sort_order, bool $is_active, bool $is_cancel_autoship, bool $is_show_on_extranet)
    {
        $this->id = $id;
        $this->description = $description;
        $this->sort_order = $sort_order;
        $this->is_active = $is_active;
        $this->is_cancel_autoship = $is_cancel_autoship;
        $this->is_show_on_extranet = $is_show_on_extranet;
    }
}
