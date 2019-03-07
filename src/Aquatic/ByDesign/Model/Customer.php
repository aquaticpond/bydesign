<?php

namespace Aquatic\ByDesign\Model;

use Aquatic\ByDesign\Model\Address;

class Customer
{
    public $rep_number;
    public $first_name;
    public $last_name;
    public $company;
    public $billing_address;
    public $shipping_address;
    public $tax_id;
    public $phone_number;
    public $password;
    public $email_address;
    public $type_id;
    public $status_type_id;
    public $ip_address;

    /**
     * PreferredCulture = Stands for the User Locale or Language.
     * I beleive you are only using English, therefore this would always be 1
     *
     * The language section is a Bydesign Only section as this require
     * additional licensing, but there is only one in use. English = 1
     */
    public $preferred_culture = 1;

    /**
     * Business Center - Typically only one is in use for most clients,
     * but some customizations may use multiple business centers, this
     * would allow you to specify which to use.
     *
     * The BC number points out to Business Center Tables, in your case
     * only one business center is in use, BC = 1
     */
    public $bc_number = 1;

    /**
     * ReferralMarketType = Referral Market Types are used to indicate where or how a rep heard about us.
     * These types are used when the REP_REFERRAL_MARKET setting is enabled.
     * If the setting is on, Referral Market Types are available on the
     * Reps' Edit Page and the Online Enrollment for selection.
     *
     * https://backoffice.bydesign.com/{your_company}/Admin/ReferralMarketType
     *
     */
    public $referral_market_type_input;
    public $referral_market_type_id;

    /**
     * Do not auto-fill these vars
     *
     * @var array
     */
    protected $_immutable = [
        'preferred_culture',
        'bc_number',
    ];

    public function __construct(array $params = [], Address $billing_address = null, Address $shipping_address = null)
    {
        $props = array_keys(get_object_vars($this));
        $class = static::class;
        foreach ($params as $key => $val) {
            if (in_array($key, $this->_immutable)) {
                \trigger_error("{$key} is immutable in {$class} and will be ignored.", E_USER_WARNING);
                continue;
            }

            if (!in_array($key, $props)) {
                \trigger_error("{$key} is not a property in {$class} and will be ignored.", E_USER_WARNING);
                continue;
            }

            $this->$key = $val;
        }

        $this->billing_address = $billing_address ?: new Address();
        $this->shipping_address = $shipping_address ?: new Address();
    }
}
