<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Exceptions\MethodDeprecated;
use Aquatic\ByDesign\Model\Customer;
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

    /**
     * For a given order detail ID, this method will add a personalization text to the detail item.
     *
     * @param integer $id Item ID
     * @param string $text Personalization text
     * @param boolean $is_online Is the order an OnlineOrder or a placed Order
     * @param integer $order Order in which to display personalization
     * @return Object Response
     */
    public function addPersonalization(int $id, string $text, bool $is_online = true, int $order = 0)
    {
        $result = $this->send('AddPersonalization', [
            'DetailID' => $id,
            'Classification' => $is_online ? 'OnlineOrder' : 'Order',
            'Personalization' => $text,
            'Sequence' => $order,
        ]);

        return $result->AddPersonalizationResult;
    }

    public function addRelationshipOrderDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * When using master orders, this will allow tying an online order id to the parent master order id.
     *
     * @param integer $master_order_id
     * @param integer $online_order_id
     * @param boolean $add_or_remove FALSE = Remove association, TRUE = Add association (default: TRUE)
     * @return bool Success or failure
     */
    public function associateOrderToMaster(int $master_order_id, int $online_order_id, bool $add_or_remove = true)
    {
        $result = $this->send('AssociateOnlineOrderToMaster', [
            'MasterOrderID' => $master_order_id,
            'OnlineOrderID' => $online_order_id,
            'AssociationType' => $add_or_remove ? 'Add' : 'Remove',
        ]);

        return (bool) $result->AssociateOnlineOrderToMasterResult;
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

    /**
     * Post a static, non-critical note without any category
     * or type selections in the Freedom Back office profile page of a rep or customer
     *
     * @param integer $customer_id
     * @param string $subject
     * @param string $message
     * @param boolean $is_rep Are they a rep or a normal customer
     * @param array $options Array containing optional 'correspondence_type_id', 'category_id', 'order_id'
     * @return Object Response
     */
    public function createBackOfficeProfileNote(int $customer_id, string $subject, string $message, bool $is_rep = false, array $options = [])
    {

        $result = $this->send('CreateBackOfficeProfileNote', [
            'ProfileNote' => [
                'RepOrCustomer' => $is_rep ? 0 : 1,
                'IDNumber' => $customer_id,
                'Subject' => $subject,
                'Message' => $message,

                /**
                 * Correspondence Types are utilized as a way of identifying the method of correspondence
                 * used to generate a note within the system. This is displayed as Type on note creation/edit
                 * on all user generated and populated notes in the Freedom Back Office
                 *
                 * https://backoffice.bydesign.com/crunchi/Admin/CorrespondenceType
                 */
                'CorrespondenceTypeID' => @$options['correspondence_type_id'],
                'CategoryID' => @$options['category_id'],
                'OrderID' => @$options['order_id'],
            ],
        ]);

        return $result->CreateBackOfficeProfileNoteResult;
    }

    /**
     * Once all items related to custom creation are completed,
     * one can use this method to finalized the customer creation
     * process. Note: For most of our clients, one can call this
     * immediately after calling CreateOnlineCustomer.
     *
     * @param integer $id OnlineCustomer ID
     * @param integer $referrer DID of referring customer, not referring rep (optional)
     * @return integer ID of created customer
     */
    public function createCustomer(int $id, int $referrer = null)
    {
        $result = $this->send('CreateCustomer', [
            'OnlineCustomerID' => $id,
            'ReferCustomerDID' => $referrer,
        ]);

        return (int) $result->CreateCustomerResult;
    }

    /**
     * Use this API for generating a new password reset key for
     * a given customer. This can be used in case the client
     * uses their own AutoResponder system.
     *
     * @param mixed $id_or_email Customer ID or Email Address
     * @return Object Result
     */
    public function createCustomerPasswordResetKey($id_or_email)
    {
        $result = $this->send('CreateCustomerPasswordResetKey', [
            'Request' => [
                'EmailAddressOrCustomerDID' => $id_or_email,
            ],
        ]);

        return $result->CreateCustomerPasswordResetKeyResult;
    }

    /**
     * Allows the uploading of PayOut Adjustments through API.
     *
     * @param integer $rep_id
     * @param integer $adjustment_type Type ID corresponding to types fount from OnlineApi::getPayoutAdjustmentTypes()
     * @param float $amount
     * @param string $datetime Datetime of adjustment
     * @param string $reason Note for adjustment
     * @return Object
     */
    public function createManualPayoutAdjustment(int $rep_id, int $adjustment_type, float $amount, string $datetime, string $reason = '')
    {
        $result = $this->send('CreateManualPayoutAdjustment', [
            'Request' => [
                'RepDID' => $rep_id,
                'AdjustmentTypeID' => $adjustment_type,
                'Amount' => $amount,
                'Reason' => $reason,
                'AdjustmentDate' => $datetime,
            ],
        ]);

        return $result->CreateManualPayoutAdjustmentResult;
    }

    /**
     * A master order is an order which holds other orders.
     * This is like creating a party order without actually
     * holding a party. Once a master order is created, one
     * can assign other orders into the master order.
     *
     * For further information on Master Orders,
     * it is suggested to contact ByDesign.
     *
     * @return int Master Order ID
     */
    public function createMasterOrder()
    {
        $result = $this->send('CreateMasterOrder');
        return (int) $result->CreateMasterOrderResult;
    }

    /**
     * This method allows one to create a temporary customer. In most instances,
     * the returned Online Customer ID can be instantly used to create a permanent
     * customer (see CreateCustomer). However, for some companies, a beginning order
     * is sometimes created upon the customer creation. This can be done much like
     * a rep signup process with an initial order creation.
     *
     * @param Customer $customer
     * @param string $password
     * @param integer $referrer Customer referrer, not rep referrer (optional)
     * @return int OnlineCustomer ID
     */
    public function createOnlineCustomer(Customer $customer, string $password, int $referrer = null)
    {
        $result = $this->send('CreateOnlineCustomer', [
            /**
             * ReferCustomerDID and RepNumber are not the same thing.
             * Either a customer does the referral (ReferCustomerDID)
             * or a rep does the referral (OnlineCustomerRecord.RepNumber) upon enrollment.
             * The customer referral is currently disabled.
             *
             * https://admin.bydesign.com/{your_company}/admin/SettingsWizard.asp?SearchTerm=X2_NEWCUSTOMER_SHOW_REFERCUST
             *
             * DID = Display ID -> not to be confused with actual Identification Digit.
             * They are separate ID tables one allows numeric values , the other alphanumeric.
             * Sometimes used to have multiple entities for one REP or Customer. Some clients
             * prefer to have a numeric value, others may want to use alpha. Ex, Rep 1 or Rep US1
             *
             */
            'ReferCustomerDID' => $referrer,

            'OnlineCustomerRecord' => [
                'RepNumber' => $customer->rep_number,
                'Firstname' => $customer->first_name,
                'Lastname' => $customer->last_name,
                'Email' => $customer->email_address,
                'Company' => $customer->company,
                'BillStreet1' => $customer->billing_address->street,
                'BillStreet2' => $customer->billing_address->street2,
                'BillCity' => $customer->billing_address->city,
                'BillState' => $customer->billing_address->state,
                'BillPostalCode' => $customer->billing_address->post_code,
                'BillCounty' => $customer->billing_address->county,
                'BillCountry' => $customer->billing_address->country,
                'ShipStreet1' => $customer->shipping_address->street,
                'ShipStreet2' => $customer->shipping_address->street2,
                'ShipCity' => $customer->shipping_address->city,
                'ShipState' => $customer->shipping_address->state,
                'ShipPostalCode' => $customer->shipping_address->post_code,
                'ShipCounty' => $customer->shipping_address->county,
                'ShipCountry' => $customer->shipping_address->country,
                'TaxID' => $customer->tax_id,
                'Phone1' => $customer->phone_number,
                'Phone2' => '',
                'Phone3' => '',
                'Phone4' => '',
                'Phone5' => '',
                'Phone6' => '',
                'Password' => $password,
                'CustomerTypeID' => $customer->type_id,
                'StatusTypeID' => $customer->status_type_id,
                'IPAddress' => $customer->ip_address,
                'PreferredCulture' => $customer->preferred_culture,

                // Unique to customer type
                'BCNumber' => $customer->bc_number,
                'ReferralMarketTypeInput' => $customer->referral_market_type_input,
                'ReferralMarketTypeID' => $customer->referral_market_type_id,
            ],
        ]);

        return (int) $result->CreateOnlineCustomerResult;
    }

    /**
     * Undocumented function
     *
     * @param array $params
     * @param [Customer] $customer
     * @return integer Online Order ID
     */
    public function createOnlineOrder(array $params, Customer $customer): int
    {
        $result = $this->send('CreateOnlineOrder_V2', [
            'RepNumber' => '',

        ]);
    }

    /**
     * This method is step #1 in creating a representative. Essentially, an online
     * signup is a temporary record that holds a potential representatives information.
     * One can enter the below information for a potential representative and create a
     * signup order to go alone with it. There are other methods that one can use in
     * order to finish creating a representative such as CreateRep, but it is strongly
     * suggested to look through most methods in this webservice prior to attempting to
     *  create a representative.
     *
     * @return int ID of representative
     */
    public function createOnlineSignup(Customer $customer, string $password): int
    {
        $result = $this->send('CreateOnlineSignup_v2', [
            'OnlineSignupRecordv2' => [
                'SponsorRepNumber' => $customer->rep_number,

                'Firstname' => $customer->first_name,
                'Lastname' => $customer->last_name,
                'Email' => $customer->email_address,
                'Company' => $customer->company,
                'BillStreet1' => $customer->billing_address->street,
                'BillStreet2' => $customer->billing_address->street2,
                'BillCity' => $customer->billing_address->city,
                'BillState' => $customer->billing_address->state,
                'BillPostalCode' => $customer->billing_address->post_code,
                'BillCounty' => $customer->billing_address->county,
                'BillCountry' => $customer->billing_address->country,
                'ShipStreet1' => $customer->shipping_address->street,
                'ShipStreet2' => $customer->shipping_address->street2,
                'ShipCity' => $customer->shipping_address->city,
                'ShipState' => $customer->shipping_address->state,
                'ShipPostalCode' => $customer->shipping_address->post_code,
                'ShipCounty' => $customer->shipping_address->county,
                'ShipCountry' => $customer->shipping_address->country,
                'TaxID' => $customer->tax_id,
                'TaxID2' => $customer->tax_id2,
                'Phone1' => $customer->phone_number,
                'Phone2' => '',
                'Phone3' => '',
                'Phone4' => '',
                'Password' => $password,
                'RepTypeID' => $customer->type_id,
                'IPAddress' => $customer->ip_address,
                'PreferredCulture' => $customer->preferred_culture,

                // Unique to rep type
                'ReplicatedURL' => $customer->replicated_url,
                'ReplicatedText' => $customer->replicated_text,
                'DateOfBirth' => $customer->date_of_birth,
                'PayoutMethodID' => $customer->payout_method_id,
            ],
        ]);

        return $result->CreateOnlineSignup_v2Result;
    }

    public function createOrder()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Once a online signup is created and all items related to the signup are completed,
     * one can submit the online signup id to this method in order to create the finalized
     * representative. This method will return -1 for an invalid creation, or the actual
     * RepDID of the finalized representative.
     *
     * The purpose of the new version of this API is to provide the ability to provide
     * the user with a success/fail message and to install more useful and consumable
     * error handling.
     *
     * @param integer $online_signup_id
     * @return integer
     */
    public function createRep(int $online_signup_id)
    {
        $result = $this->send('CreateRep_V2', [
            'OnlineSignupID' => $online_signup_id,
        ]);

        return $result->CreateRep_V2Result;
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

    /**
     * Returns a data set of the PayOut Adjustment types by Description.
     *
     * @return []PayoutAdjustmentType
     */
    public function getPayOutAdjustmentTypes()
    {
        $result = $this->send('GetPayOutAdjustmentTypes');

        return $result->GetPayOutAdjustmentTypesResult;
    }

    public function getPayoutMethods()
    {
        $result = $this->send('GetPayoutMethods');

        return $result->GetPayoutMethodsResult;
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
