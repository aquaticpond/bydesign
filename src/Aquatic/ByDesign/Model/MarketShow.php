<?php

namespace Aquatic\ByDesign\Model;

class MarketShow
{
    public $id;
    public $market_id;
    public $description;
    public $is_active;
    public $is_allow_in_party_selection;
    public $projected_head_count;
    public $actual_head_count;
    public $sort_order;

    public function __construct(
        int $id,
        int $market_id,
        string $description,
        bool $is_active,
        bool $is_allow_in_party_selection,
        int $projected_head_count,
        int $actual_head_count,
        int $sort_order
    ) {
        $this->id = $id;
        $this->market_id = $market_id;
        $this->description = $description;
        $this->is_active = $is_active;
        $this->is_allow_in_party_selection = $is_allow_in_party_selection;
        $this->projected_head_count = $projected_head_count;
        $this->actual_head_count = $actual_head_count;
        $this->sort_order = $sort_order;
    }
}
