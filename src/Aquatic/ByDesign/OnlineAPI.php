<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Exceptions\MethodDeprecated;
use Aquatic\ByDesign\SOAP\API;
use \BadMethodCallException;

class OnlineAPI extends API
{
    /**
     * Adds/Deletes a PaymentCredit to a customer or rep
     *
     * @param integer $id Customer or Rep ID
     * @param float $amount
     * @param int $type Credit type (see: OnlineAPI::getCreditTypes())
     * @param string $description (optional)
     * @param boolean $is_rep Are we mutating a representative? (optional: default false)
     * @return Object Response
     */
    public function addCredit(int $id, float $amount, int $type, string $description = '', bool $is_rep = false)
    {
        $response = $this->send('AddCredit', [
            'creditInput' => [
                'RepNumber' => $is_rep ? $id : null,
                'CustomerNumber' => $is_rep ? null : $id,
                'CreditType' => $type,
                'Amount' => $amount,
                'Description' => $description,
            ],
        ]);

        return $response->AddCreditResult;
    }

    public function addPersonalization()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function addRelationshipOrderDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function associateOrderToMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Associate an order to a party
     *
     * @param integer $order_id
     * @param integer $party_id
     * @return bool Success?
     */
    public function associateOrderToParty(int $order_id, int $party_id): bool
    {
        $result = $this->send('AssociateOrderToParty', [
            'OrderID' => $order_id,
            'PartyID' => $party_id,
        ]);

        return (bool) $result->AssociateOrderToPartyResult->Success;
    }

    /**
     * Check if the E-Mail is already being used
     *
     * @param string $email
     * @param integer $type Type customer or rep; 0=reps; 1=customers; 2=both (optional, default: 2)
     * @return boolean
     */
    public function checkEmail(string $email, int $type = 2): bool
    {
        $response = $this->send('CheckEmail', [
            'Email' => $email,
            'Type' => $type,
        ]);

        return (bool) $response->CheckEmailResult;
    }

    /**
     * Check if a representative exists with this Social Security Number
     *
     * @param string $ssn
     * @param int $exclude Exclude a representative by ID (optional)
     * @return boolean Does the Social Security Number already exist
     */
    public function checkRepSSN(string $ssn, int $exclude = null): bool
    {
        $result = $this->send('CheckRepSSN', [
            'SSN' => $ssn,
            'ExcludeRepNumber' => $exclude,
        ]);

        return (bool) $result->CheckRepSSNResult;
    }

    /**
     * Check if a representative exists with this URL
     *
     * @param string $url
     * @param int $exclude Exclude a representative by ID (optional)
     * @return boolean Does the URL already exist
     */
    public function checkRepURL(string $url, int $exclude = null): bool
    {
        $result = $this->send('CheckRepURL', [
            'URL' => $url,
            'ExcludeRepNumber' => $exclude,
        ]);

        return (bool) $result->CheckRepURLResult;
    }

    public function createBackOfficeProfileNote()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createCustomer()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createCustomerPasswordResetKey()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createManualPayoutAdjustment()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createMasterOrder()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createOnlineCustomer()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createOnlineOrder()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createOnlineSignup()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createOrder()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createRep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function generateAR()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Get credits available on users account
     *
     * @param integer $id Customer or Rep Id
     * @param boolean $is_rep Is user customer or rep?
     * @return float Amount of credit available
     */
    public function getAvailableCredits(int $id, bool $is_rep = false)
    {
        $response = $this->send('GetAvailableCredits', [
            'RepNumber' => $is_rep ? $id : null,
            'CustomerNumber' => $is_rep ? null : $id,
        ]);

        return (float) $response->GetAvailableCreditsResult->Credits;
    }

    /**
     * Deprecated. Please see REST API: ~/api/Admin/Country
     *
     * @throws MethodDeprecated
     */
    public function getCountries()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/Admin/Country");
    }

    /**
     * Deprecated. Please see REST API: ~/api/order/Address/CountryStates
     *
     * @throws MethodDeprecated
     */
    public function getCountryStates()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/order/Address/CountryStates");
    }

    /**
     * Get credit types
     *
     * @return []CreditTypes
     */
    public function getCreditTypes()
    {
        $response = $this->send('GetCreditTypes');
        return $response->GetCreditTypesResult->creditTypes->CreditType;
    }

    public function getCurrencyTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCustomPayoutDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCustomerByGUID()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Get customer by ID
     *
     * @param integer $id
     * @return Customer the customer
     */
    public function getCustomer(int $id)
    {
        $result = $this->send('GetCustomerInfo_v4', [
            'CustomerID' => $id,
        ]);

        return $result->GetCustomerInfo_v4Result;
    }

    public function getCustomerInfoWithShipping()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCustomerLookup(string $email)
    {
        // @todo: Response is some XML nonsense
        throw new BadMethodCallException("lookup has not been implemented yet.");
        // $response = $this->send('GetCustomerLookup', [
        //     'customerInput' => [
        //         'Email' => $email,
        //     ],
        // ]);

        // return $response;
    }

    public function getCustomerStatusTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/Admin/CustomerType
     *
     * @throws MethodDeprecated
     */
    public function getCustomerTypes()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/Admin/CustomerType");
    }

    public function getGiftCardAccounts()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getGiftCardFields()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getInventoryByCategory()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/inventory/InventoryShopping
     *
     * @throws MethodDeprecated
     */
    public function getInventoryProductSearch()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/inventory/InventoryShopping");
    }

    /**
     * Deprecated. See REST API: ~/api/inventory/InventoryShopping
     *
     * @throws MethodDeprecated
     */
    public function getInventoryShopping()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/inventory/InventoryShopping");
    }

    public function getInventorySignup()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/inventory/InventoryShopping
     *
     * @throws MethodDeprecated
     */
    public function getInventorySingleItem()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/inventory/InventoryShopping");
    }

    /**
     * Deprecated. See REST API: ~/api/Admin/Locale
     *
     * @throws MethodDeprecated
     */
    public function getLocales()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/Admin/Locale");
    }

    public function getLocalesByShipCountry()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getMiscFieldValue()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getMiscFields()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPayOutAdjustmentTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPayoutMethods()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPersonalizations()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/admin/rankType
     *
     * @throws MethodDeprecated
     */
    public function getRankTypes()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/admin/rankType");
    }

    public function getRelationshipDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepByGUID()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepCodedUplineInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepCustomers()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/user/rep
     *
     * @throws MethodDeprecated
     */
    public function getRepInfo()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/user/rep");
    }

    public function getRepPassword()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepPayoutMethod()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepPrefPlacement()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/admin/repType
     *
     * @throws MethodDeprecated
     */
    public function getRepTypes()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/admin/repType");
    }

    public function getRepUpline()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Authenticate customer or rep
     *
     * @param string $username
     * @param string $password
     * @param boolean $is_rep
     * @return int Authenticated Customer ID or 0 if login failed
     */
    public function login(string $username, string $password, bool $is_rep = false): int
    {
        $method = $is_rep === true ? 'LoginCheck_Rep' : 'LoginCheck_Customer';
        $result = $is_rep === true ? 'LoginCheck_RepResult' : 'LoginCheck_CustomerResult';
        $response = $this->send($method, [
            'Username' => $username,
            'Password' => $password,
        ]);

        $result = $response->{$result};
        return $result->Success ? $result->CustomerNumber : 0;
    }

    public function moveCustomerToNewRep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderAddItem()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderAddItemByPriceType()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderAddMultipleItems()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderAutoshipAddItem()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderAutoshipClearItem()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/order/OnlineOrder/Clear
     *
     * @throws MethodDeprecated
     */
    public function onlineOrderAutoshipClearItems()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/order/OnlineOrder/Clear");
    }

    public function onlineOrderAutoshipGetItems()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderAutoshipSetDate()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderClearItem()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderClearItems()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderDeleteDraftOrder()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetDraftOrdersMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetItems()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetShipMethods()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetSubOrdersMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetTotals()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetTotalsMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderGetWeight()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderSetShippingOverride()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderSubmitOrderMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderUpdateCreditAmount()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderUpdateCreditAmountMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderUpdateCustomerID()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderUpdateItem()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderUpdateShipMethod()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function onlineOrderUpdateShipMethodGetTotals()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function partySearchCompletionGetPartyDescriptions()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function partySearchCompletionGetPartyGuests()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function partySearchCompletionGetPartyHostess()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function partySearchCompletionGetPartyIds()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentACH()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentACHInternational()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentBankDeposit()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentCash()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentCheckDraft()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentCreditCard()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentCreditCardTransactionInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentCreditCardMaster()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentCustom()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentDebitCard()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentRealtimeECheck()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenized()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenizedRequestAdyen()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenizedRequestCybersource()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenizedStore()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenizedVerifyResponseAdyen()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenizedVerifyResponseCybersource()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function paymentTokenizedDeclined()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function processGiftCard()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function seamlessExtranetLoginCustome()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function seamlessExtranetLoginRep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/users/customer/sendPasswordReset
     *
     * @throws MethodDeprecated
     */
    public function sendCustomerPasswordReset()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/users/customer/sendPasswordReset");
    }

    public function setCoApplicant()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setCustomerType()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setMiscFieldValue()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setSignupPlacement()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function transcardSignup()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateAttributes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateCustomPayoutMethodDetailsForRep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateCustomerInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateCustomerInfoWithShipping()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/users/customer/createPassword
     *
     * @throws MethodDeprecated
     */
    public function updateCustomerPassword()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/users/customer/createPassword");
    }

    public function updateOnlineCustomer()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateOnlineOrderAddress()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateOnlineOrderAddressByProfile()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateOnlineSignup()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updatePassword()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateRepInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateRepPayoutMethodInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateRepPrefPlacement()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function upgradeCustomer()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Validate a credit card number
     *
     * @param integer $cc_number
     * @return bool Is valid?
     */
    public function validateCCNumber(int $cc_number): bool
    {
        $result = $this->send('ValidateCCNumber', [
            'CreditCardNumber' => $cc_number,
        ]);

        return (bool) $result->ValidateCCNumberResult;
    }

    /**
     * Validate an email address
     *
     * @param string $email
     * @return bool Is Valid?
     */
    public function validateEmail(string $email): bool
    {
        $result = $this->send('ValidateEmail', [
            'Email' => $email,
        ]);

        return (bool) $result->ValidateEmailResult;
    }

    /**
     * Validate party ID
     *
     * @param integer $party_id
     * @return bool Is Valid?
     */
    public function validatePartyID(int $party_id): bool
    {
        $result = $this->send('ValidatePartyID', [
            'PartyID' => $party_id,
        ]);

        return (bool) $result->ValidatePartyIDResult;
    }

    public function validateRoutingNumber()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function verifyCustomerNumber()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function verifyRepNumber()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Get API Version
     *
     * @return string
     */
    public function version(): string
    {
        $result = $this->send('Version');

        return (string) $result->VersionResult->Message;
    }

    /**
     * Get City and State for Zip Code
     *
     * @param string $zip_code
     * @param string $country (optional: default US)
     * @return []Object Collection of addresses with City and State
     */
    public function zipLookup(string $zip_code, string $country = 'USA'): array
    {
        $result = $this->send('ZipLookup_v3', [
            'ZipCode' => $zip_code,
            'Country' => $country,
        ]);

        return @$result->ZipLookup_v3Result->ZipBlock_v2 ?: [];
    }
}
