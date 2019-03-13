<?php

namespace Aquatic\ByDesign\Model;

class InventoryImage
{
    public $url;
    public $alt_text;
    public $title_text;

    public function __construct(string $url, string $alt_text, string $title_text)
    {
        $this->url = $url;
        $this->alt_text = $alt_text;
        $this->title_text = $title_text;
    }
}
