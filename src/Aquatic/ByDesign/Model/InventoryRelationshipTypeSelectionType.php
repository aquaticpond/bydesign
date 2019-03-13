<?php

namespace Aquatic\ByDesign\Model;

class InventoryRelationshipTypeSelectionType
{
    public $id;
    public $relationship_type_id;
    public $selection_type_id;

    public function __construct(int $id, int $relationship_type_id, int $selection_type_id)
    {
        $this->id = $id;
        $this->relationship_type_id = $relationship_type_id;
        $this->selection_type_id = $selection_type_id;
    }
}
