<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Model\Country;
use Aquatic\ByDesign\Model\CustomerType;
use Aquatic\ByDesign\Model\OrderStatus;
use Aquatic\ByDesign\Model\PartyStatus;
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
}
