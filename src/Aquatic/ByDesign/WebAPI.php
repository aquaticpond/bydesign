<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Model\Country;
use Aquatic\ByDesign\Model\Customer;
use Aquatic\ByDesign\Model\CustomerType;
use Aquatic\ByDesign\Model\Geocode;
use Aquatic\ByDesign\Model\OrderStatus;
use Aquatic\ByDesign\Model\PartyStatus;
use Aquatic\ByDesign\Model\RepType;
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
     * @return array
     */
    public function getStates(): array
    {
        \trigger_error("WebAPI::getStates is not implemented.", E_USER_WARNING);

        $json = $this->_guzzle
            ->request('GET', '/crunchi/api/order/Address/CountryStates?cartCountry=USA')
            ->getBody()
            ->getContents();

        $results = [];
        foreach (\json_decode($json) as $country) {
            //$results[] = $country;
        }

        return $results;
    }

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
     * @return void
     */
    public function createCustomer(Customer $customer, bool $agreed_to_terms = false, bool $send_autoresponder = true)
    {
        $params = [
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
        ];

        $json = $this->_guzzle
            ->request(
                'POST',
                '/crunchi/api/users/customer',
                ['json' => $params]
            )
            ->getBody()
            ->getContents();

        // @todo: parse response when request 500 is sorted out
        return \json_decode($json);
    }
}
