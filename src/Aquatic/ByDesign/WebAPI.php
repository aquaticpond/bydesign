<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Model\Country;
use Aquatic\ByDesign\Model\Customer;
use Aquatic\ByDesign\Model\CustomerNoteCategory;
use Aquatic\ByDesign\Model\CustomerType;
use Aquatic\ByDesign\Model\Geocode;
use Aquatic\ByDesign\Model\InventoryCategoryDetail;
use Aquatic\ByDesign\Model\InventoryImage;
use Aquatic\ByDesign\Model\InventoryImageType;
use Aquatic\ByDesign\Model\InventoryPrice;
use Aquatic\ByDesign\Model\InventoryProduct;
use Aquatic\ByDesign\Model\InventoryRelationshipTypeSelectionType;
use Aquatic\ByDesign\Model\Locale;
use Aquatic\ByDesign\Model\MarketShow;
use Aquatic\ByDesign\Model\OrderDetailStatus;
use Aquatic\ByDesign\Model\OrderStatus;
use Aquatic\ByDesign\Model\PartyStatus;
use Aquatic\ByDesign\Model\Rank;
use Aquatic\ByDesign\Model\ReasonAreaType;
use Aquatic\ByDesign\Model\ReasonCodeType;
use Aquatic\ByDesign\Model\RepType;
use Aquatic\ByDesign\Model\USPSServiceType;
use GuzzleHttp\Client as GuzzleClient;

class WebAPI
{
    protected $_user;
    protected $_password;
    protected $_api_domain;
    protected $_guzzle;

    public function __construct(string $user, string $password, string $api_domain)
    {
        $this->_user = $user;
        $this->_password = $password;
        $this->_guzzle = new GuzzleClient([
            'base_uri' => $api_domain,
            'auth' => [$user, $password],
            'force_ip_resolve' => 'v4',
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get list of available countries from ByDesign
     *
     * @return []Country
     */
    public function getCountries(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/Country')
            ->getBody()
            ->getContents();

        $results = [];
        foreach (\json_decode($json) as $country) {
            if (!$country->IsActive) {
                continue;
            }

            $results[] = new Country(
                (int) $country->ID,
                (string) $country->Description,
                (bool) $country->IsDefault,
                (bool) $country->IsActive,
                (string) $country->Abbreviation
            );
        }

        return $results;
    }

    /**
     * States needs to be configured in
     * https://staging-backoffice.bydesign.com/crunchi/Admin/CountryState
     *
     * @return Object Result object
     */
    public function getStates(): array
    {
        \trigger_error("WebAPI::getStates is not implemented.", E_USER_WARNING);

        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/order/Address/CountryStates?cartCountry=USA')
            ->getBody()
            ->getContents();

        return \json_decode($json);

        $results = [];
        foreach (\json_decode($json) as $country) {
            //$results[] = $country;
        }

        return $results;
    }

    /**
     * Get valid customer types
     *
     * @return []CustomerType
     */
    public function getCustomerTypes(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/CustomerType')
            ->getBody()
            ->getContents();

        $results = [];
        foreach (\json_decode($json) as $type) {
            $results[] = new CustomerType(
                $type->ID,
                $type->Description,
                $type->Abbreviation,
                $type->OrderType,
                $type->AutoShipOrderType,
                $type->IsExtranet,
                $type->IsAllowUpdateFrom,
                $type->IsAllowUpdateTo,
                $type->IsAllowNewProfileFromExt
            );
        }

        return $results;
    }

    // @todo: this
    public function getPartiesByRep(): array
    {
        $results = [];
        return $results;
    }

    /**
     * Get valid statuses for parties
     *
     * @return []PartyStatus
     */
    public function getPartyStatuses(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/PartyStatus')
            ->getBody()
            ->getContents();

        $results = [];
        foreach (\json_decode($json) as $status) {
            $results[] = new PartyStatus(
                $status->ID,
                $status->Description,
                $status->IsOfficial
            );
        }

        return $results;
    }

    /**
     * Get valid statuses for orders
     *
     * @return []OrderStatus
     */
    public function getOrderStatuses(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/OrderStatus')
            ->getBody()
            ->getContents();

        $results = [];
        foreach (\json_decode($json) as $status) {
            $results[] = new OrderStatus(
                $status->ID,
                $status->Description,
                $status->Abbreviation,
                $status->IsOfficial,
                $status->IsUnofficialVoid,
                $status->IsUnofficialRetryPayment,
                $status->IsOfficialNotYetShipped,
                $status->IsOfficialShipped,
                $status->IsOfficialEntered,
                $status->OrderDetailStatusID,
            );
        }

        return $results;
    }

    /**
     * Get available order detail statuses
     *
     * @return []OrderDetailStatus
     */
    public function getOrderDetailStatuses(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/OrderDetailStatus')
            ->getBody()
            ->getContents();

        $statuses = [];
        foreach (\json_decode($json) as $status) {
            $statuses[] = new OrderDetailStatus(
                $status->ID,
                $status->Description,
                $status->IsODOfficial,
                $status->IsOfficial_NotYetShipped,
            );
        }

        return $statuses;
    }

    /**
     * Get valid rep types
     *
     * @return []RepType
     */
    public function getRepTypes(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/admin/repType')
            ->getBody()
            ->getContents();

        $results = [];
        foreach (\json_decode($json) as $type) {
            $results[] = new RepType(
                $type->ID,
                $type->Description,
                $type->Abbreviation,
                $type->OrderType,
                $type->AutoShipOrderType,
                $type->IsDefault
            );
        }

        return $results;
    }

    /**
     * Lists valid cities, states and counties for a given zip code
     *
     * @param string $post_code
     * @return []Geocode
     */
    public function geocode(string $post_code)
    {
        $json = $this->_guzzle
            ->request(
                'GET',
                '/crunchi/api/order/Address/GeocodeAddress',
                ['query' => ['postalCode' => $post_code]]
            )
            ->getBody()
            ->getContents();

        $geocode = \json_decode($json);

        return new Geocode($geocode->Cities, $geocode->States, $geocode->Counties);
    }

    /**
     * Create new customer
     *
     * @param Customer $customer
     * @param boolean $agreed_to_terms
     * @param boolean $send_autoresponder Send the customer a ByDesign "Welcome New Customer" email
     * @return Object Result object
     */
    public function createCustomer(Customer $customer, bool $agreed_to_terms = false, bool $send_autoresponder = true)
    {
        $query_string = \http_build_query([
            'FirstName' => $customer->first_name,
            'LastName' => $customer->last_name,
            'Email' => $customer->email_address,
            'Password' => $customer->password,
            'RepDID' => $customer->rep_number,
            'Company' => $customer->company,
            'Phone1' => $customer->phone_number,
            'Phone2' => '',
            'Phone3' => '',
            'Phone4' => '',
            'ShippingStreet1' => $customer->shipping_address->street,
            'ShippingStreet2' => $customer->shipping_address->street2,
            'ShippingCountry' => $customer->shipping_address->country,
            'ShippingPostalCode' => $customer->shipping_address->post_code,
            'ShippingCity' => $customer->shipping_address->city,
            'ShippingState' => $customer->shipping_address->state,
            'ShippingCounty' => $customer->shipping_address->county,
            'BillingStreet1' => $customer->billing_address->street,
            'BillingStreet2' => $customer->billing_address->street2,
            'BillingCountry' => $customer->billing_address->country,
            'BillingPostalCode' => $customer->billing_address->post_code,
            'BillingCity' => $customer->billing_address->city,
            'BillingState' => $customer->billing_address->state,
            'BillingCounty' => $customer->billing_address->county,
            'AgreedToTerms' => $agreed_to_terms,
            'ReferralMarketType' => $customer->referral_market_type_id,
            'ReferralMarketTypeInput' => $customer->referral_market_type_input,
            'ReferCustomerID' => $customer->rep_number,
            'TaxID' => $customer->tax_id,
            'TaxID2' => $customer->tax_id2,
            'ReplicatedSiteUrl' => $customer->replicated_url,
            'CustomerType' => $customer->type_id,
            'SendAutoresponders' => $send_autoresponder,
            'DateOfBirth' => $customer->date_of_birth,
        ]);

        $json = $this->_guzzle
            ->request('POST', "/crunchi/api/users/customer?{$query_string}")
            ->getBody()
            ->getContents();

        // @todo: parse response when request 500 is sorted out
        return \json_decode($json);
    }

    /**
     * Send customer a password reset email
     * @todo: test email actually gets sent because staging ARs are disabled
     *
     * @param integer $customer_id
     * @param string $language (optional: default en-us)
     * @return Object Result Object
     */
    public function sendCustomerPasswordReset(int $customer_id, string $language = 'en-us')
    {
        $query_string = \http_build_query([
            'customerDID' => $customer_id,
            'langKey' => $language,
        ]);

        $json = $this->_guzzle
            ->request('POST', "/crunchi/api/users/customer/sendPasswordReset?{$query_string}")
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Send rep/advocate a password reset email
     * @todo: test email actually gets sent because staging ARs are disabled
     *
     * @param integer $customer_id
     * @param string $language (optional: default en-us)
     * @param bool $use_revolution_link (optional: default false)
     * @return Object Result Object
     */
    public function sendRepPasswordReset(int $rep_id, string $language = 'en-us', bool $use_revolution_link = false)
    {
        $query_string = \http_build_query([
            'repDID' => $rep_id,
            'langKey' => $language,
            'useRevolutionLink' => $use_revolution_link ? 'true' : 'false', //API expects stringly true...
        ]);

        $json = $this->_guzzle
            ->request('POST', "/crunchi/api/rep/sendPasswordReset?{$query_string}")
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Check that customer password reset key is still valid
     *
     * @param integer $customer_id
     * @param string $password_reset_key
     * @return Object Result Object
     */
    public function validateCustomerPasswordResetKey(int $customer_id, string $password_reset_key)
    {
        $data = [
            'CustomerDID' => $customer_id,
            'PasswordResetKey' => $password_reset_key,
        ];

        $json = $this->_guzzle
            ->request('POST', '/crunchi/api/users/customer/validatePasswordResetKey', ['json' => $data])
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Update customer password
     *
     * @param integer $customer_id
     * @param string $password
     * @param string $password_reset_key
     * @return Object Result object
     */
    public function createCustomerPassword(int $customer_id, string $password, string $password_reset_key)
    {
        $data = [
            'CustomerDID' => $customer_id,
            'PasswordResetKey' => $password_reset_key,
            'NewPassword' => $password,
        ];

        $json = $this->_guzzle
            ->request('POST', '/crunchi/api/users/customer/createPassword', ['json' => $data])
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Advocate/Representative password resetting with a reset token has not been implemented yet. There was no OnlineAPI::createCustomerPasswordResetKey equivilent for Reps.
     * @todo: implement get password reset key for rep
     *
     * @param integer $rep_id
     * @param string $password_reset_key
     * @return Object Result object
     */
    public function validateRepPasswordResetKey(int $rep_id, string $password_reset_key)
    {
        \trigger_error("Advocate/Representative password resetting with a reset token has not been implemented yet. There was no OnlineAPI::createCustomerPasswordResetKey equivilent for Reps.", E_USER_WARNING);

        $data = [
            'RepDID' => $rep_id,
            'PasswordResetKey' => $password_reset_key,
        ];

        $json = $this->_guzzle
            ->request('POST', '/crunchi/api/rep/validatePasswordResetKey', ['json' => $data])
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Advocate/Representative password resetting with a reset token has not been implemented yet. There was no OnlineAPI::createCustomerPasswordResetKey equivilent for Reps.
     * @todo: implement get password reset key for rep
     *
     * @param integer $rep_id
     * @param string $password
     * @param string $password_reset_key
     * @return Object Result object
     */
    public function createRepPassword(int $rep_id, string $password, string $password_reset_key)
    {
        \trigger_error("Advocate/Representative password resetting with a reset token has not been implemented yet. There was no OnlineAPI::createCustomerPasswordResetKey equivilent for Reps.", E_USER_WARNING);

        $data = [
            'RepDID' => $rep_id,
            'PasswordResetKey' => $password_reset_key,
            'NewPassword' => $password,
        ];

        $json = $this->_guzzle
            ->request('POST', '/crunchi/api/rep/createPassword', ['json' => $data])
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Allows you to get a list of Locales for a specific Rep or Customer.
     *
     * @param integer $id Customer or Rep ID
     * @param boolean $is_rep Is it a Rep (default: false)
     * @return []Locale
     */
    public function getLocales(int $id, bool $is_rep = false): array
    {
        $key = $is_rep ? 'RepDID' : 'CustomerDID';
        $json = $this->_guzzle
            ->request('GET', "/crunchi/api/Admin/Locale?{$key}={$id}")
            ->getBody()
            ->getContents();

        $locales = [];
        foreach (\json_decode($json) as $locale) {
            $locales[] = new Locale(
                $locale->ID,
                $locale->Description,
                $locale->ISODescription,
                $locale->LocaleASP,
                $locale->Active,
                $locale->IsDefault,
                $locale->IsDecimalUsed,
                $locale->DecimalValue
            );
        }

        return $locales;
    }

    /**
     * Returns all rank types. Accessible to BackOffice Users and Representatives.
     *
     * @return []Rank
     */
    public function getRankTypes(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/admin/rankType')
            ->getBody()
            ->getContents();

        $ranks = [];
        foreach (\json_decode($json) as $rank) {
            $ranks[] = new Rank($rank->ID, $rank->Description, $rank->Abbreviation);
        }

        return $ranks;
    }

    /**
     * Get Rep/Advocate Info
     * @todo: Testing in staging is buggy, use preexisting reps not test rep? (id: 1122, 33 seem to work in staging)
     *
     * @param mixed $rep_id_or_url ID or URL for rep
     * @return void
     */
    public function getRepInfo($rep_id_or_url)
    {
        $json = $this->_guzzle
            ->request('GET', "/crunchi/api/user/rep/{$rep_id_or_url}/info")
            ->getBody()
            ->getContents();

        // @todo: define rep model
        return \json_decode($json);
    }

    /**
     * Returns a list of Customer Note Categories
     *
     * @return []CustomerNoteCategory
     */
    public function getCustomerNoteCategories(): array
    {
        $json = $this->_guzzle
            ->request('GET', 'crunchi/api/Admin/CustomerNoteCategory')
            ->getBody()
            ->getContents();

        $categories = [];
        foreach (\json_decode($json) as $category) {
            $categories[] = new CustomerNoteCategory(
                $category->ID,
                $category->Description,
                $category->SortOrder,
                $category->IsActive,
                $category->IsCancelAutoship,
                $category->ShowOnExtranet
            );
        }

        return $categories;
    }

    /**
     * Not really sure what this is returning
     * @todo: WTF does this return?
     *
     * @return []OrderTracking
     */
    public function getOrderTracking()
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Shipping/Order/OrderTracking')
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Reason Code Types are used when creating Return Orders as well
     * as other Administrative actions in order to give a base reason
     * as to why something is being done.
     *
     * @return []ReasonCodeType
     */
    public function getReasonCodeTypes()
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/ReasonCodeType')
            ->getBody()
            ->getContents();

        $types = [];
        foreach (\json_decode($json) as $type) {
            $types[] = new ReasonCodeType(
                $type->ID,
                $type->Description,
                $type->Explanation ?: '',
                $type->IsActive,
                $type->ReasonAreaTypeID
            );
        }

        return $types;
    }

    /**
     * Reason Area Types are used categorize Reason Code Types in areas of Freedom
     *
     * @return []ReasonAreaType
     */
    public function getReasonAreaTypes()
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/ReasonAreaType')
            ->getBody()
            ->getContents();

        $types = [];
        foreach (\json_decode($json) as $type) {
            $types[] = new ReasonAreaType(
                $type->ID,
                $type->Description,
                $type->Explanation
            );
        }

        return $types;
    }

    /**
     * Referral Market Types are used to indicate from where new
     * rep heard about us. Referral Market Types are dependent of
     * REP_REFERRAL_MARKET setting. If setting is on,
     * Referral Market Types are available on Reps Edit Page for selection.
     *
     * @return Object Result Object
     */
    public function getReferralMarketTypes()
    {
        \trigger_error("WebAPI::getReferralMarketTypes is not properly tested.", E_USER_WARNING);

        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/ReferralMarketType')
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Allows you to get a list of Tokenized Payment Accounts
     *
     * @return Object Result Object
     */
    public function getTokenizedPaymentAccounts()
    {
        \trigger_error("WebAPI::getTokenizedPaymentAccounts is not properly tested.", E_USER_WARNING);

        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/TokenizedPaymentAccount')
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Get available USPS Service Types
     *
     * @return []USPSServiceType
     */
    public function getUSPSServiceTypes(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Shipping/USPSServiceType')
            ->getBody()
            ->getContents();

        $types = [];
        foreach (\json_decode($json) as $type) {
            $types[] = new USPSServiceType(
                $type->ID,
                $type->RealtimeTypeID,
                $type->ServiceType,
                $type->PackageSize,
                $type->ContainerType,
                $type->Machinable
            );
        }

        return $types;
    }

    /**
     * Get market shows
     *
     * @return []MarketShow
     */
    public function getMarketShows(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/MarketShow')
            ->getBody()
            ->getContents();

        $shows = [];
        foreach (\json_decode($json) as $show) {
            $shows[] = new MarketShow(
                $show->ID,
                $show->MarketID,
                $show->Description,
                $show->IsActive,
                $show->IsAllowInPartySelection,
                $show->ProjectedHeadCount,
                $show->ActualHeadCount,
                $show->SortOrder
            );
        }

        return $shows;
    }

    /**
     * @todo: this
     *
     * @param [type] $rep
     * @param [type] $customer
     * @param [type] $language
     * @param [type] $country
     * @return void
     */
    public function getInventoryCategories($rep, $customer, $language, $country)
    {
        \trigger_error("getInventoryCategories not implemented yet...", E_USER_WARNING);
        $params = [
            'repDID' => $rep,
            'customerDID' => $customer,
            'langKey' => $language,
            'country' => $country,
        ];

        $query_string = \http_build_query($params);

        $json = $this->_guzzle
            ->request('GET', "/crunchi/api/inventory/InventoryCategory?{$query_string}")
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Get inventory categories?
     *
     * @return []InventoryCategoryDetail
     */
    public function getInventoryCategoryDetails(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Inventory/InventoryCategoryDetail')
            ->getBody()
            ->getContents();

        $details = [];
        foreach (\json_decode($json) as $detail) {
            $details[] = new InventoryCategoryDetail(
                $detail->ID,
                $detail->Description,
                $detail->SortOrder
            );
        }

        return $details;
    }

    /**
     * Get a list of shoppable products for a given customer/rep, category configuration
     *
     * @param integer $customer_id
     * @param boolean $is_rep true == rep; false == customer; default: true
     * @param integer $category (default: 0, show all categories)
     * @return []Product
     */
    public function getInventoryShopping(int $customer_id, bool $is_rep = false, int $category = 2): array
    {

        $data = [
            'repDID' => $is_rep ? $customer_id : null,
            'customerDID' => $is_rep ? null : $customer_id,
            'categoryId' => $category,
            'langKey' => 'en-us',
            'country' => 'USA',
            'includeChildItems' => 'false',
        ];

        $query_string = \http_build_query($data);

        $json = $this->_guzzle
            ->request('GET', "/crunchi/api/inventory/InventoryShopping?{$query_string}")
            ->getBody()
            ->getContents();

        $products = [];

        foreach (\json_decode($json) as $product) {
            $images = [];
            foreach ($product->Images as $image) {
                $images[] = new InventoryImage(
                    $image->Url,
                    $image->AltText,
                    $image->TitleText
                );
            }

            $products[] = new InventoryProduct(
                $product->InventoryID,
                $product->ProductID,
                $product->DisplayName,
                $product->Price,
                $product->CurrencyTypeID,
                $product->Compare,
                $product->SmallImageURL,
                $product->LargeImageURL,
                $product->IsFeaturedItem,
                $product->CategoryID,
                $product->OutOfStockMessage,
                $product->LowStockMessage,
                $images,
                $product->DoNotAllowAddToCartStock,
                $product->DoNotAllowAddToCartCountry,
                $product->AllowBackOrder,
                $product->GroupItemOverrideStock,
                $product->SearchField,
                $product->IsCartItem,
                $product->SortOrder,
                $product->Level,
                $product->MasterInventoryProductID,
                $product->AllowJSCartPurchase,
                $product->DoNotAllowAddToCartFlagged
            );
        }

        return $products;
    }

    /**
     * Get list of inventory relationship selection types
     *
     * @return []InventoryRelationshipTypeSelectionType
     */
    public function getInventoryRelationshipTypeSelectionTypes(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Inventory/InventoryRelationshipTypeSelectionType')
            ->getBody()
            ->getContents();

        $selection_types = [];
        foreach (\json_decode($json) as $type) {
            $selection_types[] = new InventoryRelationshipTypeSelectionType(
                $type->ID,
                $type->RelationshipTypeID,
                $type->SelectionTypeID
            );
        }

        return $selection_types;
    }

    /**
     * Get list of inventory image types
     *
     * @return []InventoryImageType
     */
    public function getInventoryImageTypes(): array
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Admin/InventoryImageType')
            ->getBody()
            ->getContents();

        $image_types = [];
        foreach (\json_decode($json) as $type) {
            $image_types[] = new InventoryImageType(
                $type->ID,
                $type->ImageKey
            );
        }

        return $image_types;
    }

    /**
     * Get all available Inventory Detail Tabs
     *
     * @return Object Result Object;
     */
    public function getInventoryDetailTabs()
    {
        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/Inventory/InventoryDetailTab')
            ->getBody()
            ->getContents();

        $tabs = [];

        \trigger_error("InventoryDetailTabs have not been mapped", E_USER_ERROR);
        return \json_decode($json);

        foreach (\json_decode($json) as $tab) {
            $tabs[] = $tab;
        }

        return $tabs;
    }

    /**
     * Get product prices for ranks
     *
     * @param string $product_sku
     * @param integer $rank_id
     * @return InventoryPrice[]
     */
    public function getInventoryPrice(string $product_sku, int $rank_id = 0): array
    {
        $query_string = \http_build_query([
            'productID' => $product_sku,
            'rankPriceTypeID' => $rank_id,
        ]);

        $json = $this->_guzzle
            ->request('GET', "/crunchi/api/inventory/InventoryPrice?{$query_string}")
            ->getBody()
            ->getContents();

        $data = \json_decode($json);

        $prices = [];
        foreach ($data as $price) {
            $prices[] = new InventoryPrice(
                $price->ProductID,
                $price->RankPriceTypeID,
                $price->Price,
                $price->CustomerService,
                $price->AutoShip,
                $price->AutoshipExt,
                $price->Customers,
                $price->Web,
                $price->Party,
                $price->Signup,
                $price->Volume,
                $price->Volume2,
                $price->Volume3,
                $price->Volume4,
                $price->OtherPrice,
                $price->OtherPrice2,
                $price->OtherPrice3,
                $price->OtherPrice4,
                $price->Compare,
                $price->TaxableAmount,
                $price->ShippingValue,
                $price->ReturnPrice,
                $price->StartDate,
                $price->EndDate,
                $price->MultiUnitPriceType,
                $price->MultiUnitQtyStart,
                $price->MultiUnitQtyEnd
            );
        }

        return $prices;
    }

    public function onlineOrderClearItems(int $order_id)
    {
        $query_string = \http_build_query([
            'onlineOrderId' => $order_id,
        ]);

        $json = $this->_guzzle
            ->request('POST', "/crunchi/api/order/OnlineOrder/Clear?{$query_string}")
            ->getBody()
            ->getContents();

        return \json_decode($json);
    }

    /**
     * Get order information
     *
     * @param integer $order_id
     * @return Object Order Information
     */
    public function getOrder(int $order_id)
    {
        $json = $this->_guzzle
            ->request('GET', "/crunchi/api/order/Order/{$order_id}")
            ->getBody()
            ->getContents();

        // @todo: map order information
        return \json_decode($json);
    }
}
