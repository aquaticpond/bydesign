<?php

namespace Aquatic\ByDesign\Model;

class InventoryPrice
{
    public $product_sku;

    /**
     * RankPriceTypes are an ENUM that is not accessible through any API or from
     * the ByDesign backend, you must ask support for a RankPriceType export to get the
     * values for this.
     *
     * @var int
     */
    public $rank_price_type_id;
    public $price;

    /**
     * True if the price can be used on Freedom BackOffice (employee area).
     *
     * @var bool
     */
    public $is_backoffice_orderable;

    /**
     * True if the price can be used to make the item available as an Autoship item.
     *
     * @var bool
     */
    public $is_auto_shippable;

    /**
     * True if the price can be used to make the item available as an Autoship item in Extranet.
     *
     * @var bool
     */
    public $is_auto_shippable_in_extranet;

    /**
     * True if the price can be used for Customer Orders.
     *
     * @var bool
     */
    public $is_customer_orderable;

    /**
     * True if the price can be used on Extranet.
     *
     * @var bool
     */
    public $is_extranet_orderable;

    /**
     * True if the price can be used to make the item available as a Party item.
     *
     * @var bool
     */
    public $is_party_orderable;

    /**
     * True if the price can be used on Enrollment Pages.
     *
     * @var bool
     */
    public $is_signup_orderable;

    public $volume;
    public $volume2;
    public $volume3;
    public $volume4;
    public $other_price;
    public $other_price2;
    public $other_price3;
    public $other_price4;

    /**
     * Used to compare item price to full retail price. You can write the difference.
     *
     * @var float
     */
    public $compare;

    public $taxable_amount;

    /**
     * The Shipping Value field is used to calculate shipping charges if shipping is
     * being calculated off the price of the inventory item. This field will be
     * considered the price for shipping calculation purposes. If shipping is computed
     * based on WEIGHT rules, then this field is not used.
     *
     * @var float
     */
    public $shipping_value;

    /**
     * If a value is entered here, any return order created for this inventory
     * item will use this value instead of the original purchase price.
     *
     * @var float
     */
    public $return_price;

    /**
     * Setup the start date when the price start to be applicable.
     *
     * @var datetime
     */
    public $start_date;

    /**
     * Setup the limit date of the price availability.
     *
     * @var datetime
     */
    public $end_date;

    public $multi_unit_price_type;

    /**
     * This is the starting quantity for this price point. I.E. the starting total
     * quantity of items in this type needed to qualify for this price point.
     *
     * @var int
     */
    public $multi_unit_qty_start;

    /**
     * This is the ending quantity for this price point. I.E. the highest quantity
     * of items in this type allowed to qualify for this price point.
     *
     * @var int
     */
    public $multi_unit_qty_end;

    public function __construct(
        string $product_sku,
        int $rank_price_type_id,
        float $price,
        bool $is_backoffice_orderable,
        bool $is_auto_shippable,
        bool $is_auto_shippable_in_extranet,
        bool $is_customer_orderable,
        bool $is_extranet_orderable,
        bool $is_party_orderable,
        bool $is_signup_orderable,
        float $volume,
        float $volume2,
        float $volume3,
        float $volume4,
        float $other_price,
        float $other_price2,
        float $other_price3,
        float $other_price4,
        float $compare,
        float $taxable_amount,
        float $shipping_value,
        float $return_price,
        string $start_date,
        string $end_date,
        int $multi_unit_price_type,
        int $multi_unit_qty_start,
        int $multi_unit_qty_end
    ) {
        $this->product_sku = $product_sku;
        $this->rank_price_type_id = $rank_price_type_id;
        $this->price = $price;
        $this->is_backoffice_orderable = $is_backoffice_orderable;
        $this->is_auto_shippable = $is_auto_shippable;
        $this->is_auto_shippable_in_extranet = $is_auto_shippable_in_extranet;
        $this->is_customer_orderable = $is_customer_orderable;
        $this->is_extranet_orderable = $is_extranet_orderable;
        $this->is_party_orderable = $is_party_orderable;
        $this->is_signup_orderable = $is_signup_orderable;
        $this->volume = $volume;
        $this->volume2 = $volume2;
        $this->volume3 = $volume3;
        $this->volume4 = $volume4;
        $this->other_price = $other_price;
        $this->other_price2 = $other_price2;
        $this->other_price3 = $other_price3;
        $this->other_price4 = $other_price4;
        $this->compare = $compare;
        $this->taxable_amount = $taxable_amount;
        $this->shipping_value = $shipping_value;
        $this->return_price = $return_price;
        $this->start_date = $end_date;
        $this->end_date = $end_date;
        $this->multi_unit_price_type = $multi_unit_price_type;
        $this->multi_unit_qty_start = $multi_unit_qty_start;
        $this->multi_unit_qty_end = $multi_unit_qty_end;
    }
}
