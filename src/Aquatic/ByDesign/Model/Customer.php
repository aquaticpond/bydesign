<?php

namespace Aquatic\ByDesign\Model;

use Aquatic\ByDesign\Model\Address;

class Customer
{
    public $id;

    /**
     * ID of representative. If Customer is a rep, is is the ID of their parent rep
     *
     * @var int
     */
    public $rep_number;

    public $first_name;
    public $last_name;
    public $company;
    public $billing_address;
    public $shipping_address;

    /**
     * TAX IDs are SSN, EIN, etc.
     */
    public $tax_id;
    public $tax_id2;

    /**
     * Primary phone number;
     * Customers have 6 slots in API
     * Reps have 4 slots in API
     *
     * @todo: Verify no customer actually has more than one phone or implement multiple phone numbers
     *
     * @var string
     */
    public $phone_number;

    // Rep specific properties
    public $replicated_url;
    public $replicated_text;
    public $date_of_birth;
    public $payout_method_id;
    // end rep specific properties

    public $password;
    public $email_address;
    public $type_id;
    public $status_type_id;
    public $ip_address;
    public $join_date;

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
     * Online Signup ID and Online Customer ID are for when creating an online customer
     * that hasnt been finalized yet. Should probably always just finalize the customer
     * before trying to do anything else?
     *
     * @var int
     */
    public $online_signup_id;
    public $online_customer_id;

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
