<?php

namespace Aquatic\ByDesign\Model;

// use InvalidArgumentException;

class InventoryProduct
{
    public $id;
    public $sku;
    public $name;
    public $price;
    public $currency_type_id;
    public $compare;
    public $small_image_url;
    public $large_image_url;
    public $is_featured_item;
    public $category_id;
    public $out_of_stock_message;
    public $low_stock_message;
    public $images;
    public $do_not_allow_add_to_cart_stock;
    public $do_not_allow_add_to_cart_country;
    public $allow_back_order;
    public $group_item_override_stock;
    public $search_field;
    public $is_cart_item;
    public $sort_order;
    public $level;
    public $master_inventory_product_id;
    public $allow_js_cart_purchase;
    public $do_not_allow_add_to_cart_flagged;

    public function __construct(
        int $id,
        string $sku,
        string $name,
        float $price,
        int $currency_type_id,
        float $compare,
        string $small_image_url,
        string $large_image_url,
        bool $is_featured_item,
        int $category_id,
        string $out_of_stock_message,
        string $low_stock_message,
        array $images,
        bool $do_not_allow_add_to_cart_stock,
        bool $do_not_allow_add_to_cart_country,
        bool $allow_back_order,
        bool $group_item_override_stock,
        string $search_field,
        bool $is_cart_item,
        int $sort_order,
        int $level,
        string $master_inventory_product_id,
        bool $allow_js_cart_purchase,
        bool $do_not_allow_add_to_cart_flagged
    ) {

        $_images = [];

        foreach ($images as $image) {
            if (!($image instanceof InventoryImage)) {
                throw new InvalidArgumentException("Images must be of type " . InventoryImage::class);
            }
        }

        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->currency_type_id = $currency_type_id;
        $this->compare = $compare;
        $this->small_image_url = $small_image_url;
        $this->large_image_url = $large_image_url;
        $this->is_featured_item = $is_featured_item;
        $this->category_id = $category_id;
        $this->out_of_stock_message = $out_of_stock_message;
        $this->low_stock_message = $low_stock_message;
        $this->images = $images;
        $this->do_not_allow_add_to_cart_stock = $do_not_allow_add_to_cart_stock;
        $this->do_not_allow_add_to_cart_country = $do_not_allow_add_to_cart_country;
        $this->allow_back_order = $allow_back_order;
        $this->group_item_override_stock = $group_item_override_stock;
        $this->search_field = $search_field;
        $this->is_cart_item = $is_cart_item;
        $this->sort_order = $sort_order;
        $this->level = $level;
        $this->master_inventory_product_id = $master_inventory_product_id;
        $this->allow_js_cart_purchase = $allow_js_cart_purchase;
        $this->do_not_allow_add_to_cart_flagged = $do_not_allow_add_to_cart_flagged;
    }
}
