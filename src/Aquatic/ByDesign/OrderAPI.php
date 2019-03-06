<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Exceptions\MethodDeprecated;
use Aquatic\ByDesign\SOAP\API;
use BadMethodCallException;

class OrderAPI extends API
{
    public function checkOrderedItemForCustomerWithinDate()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function checkOrderedItemForRepWithinDate()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createInternalNote()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createReturnOrder()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCorrespondanceTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: `/Admin/CustomerNoteCategory
     *
     * @throws MethodDeprecated
     */
    public function getCustomerNoteCategoryTypes()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/Admin/CustomerNoteCategory");
    }

    public function getNoteCategoryTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/order/Order/{order}/LineItemDetails
     *
     * @throws MethodDeprecated
     */
    public function getOrderDetailsInfo()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/order/Order/{order}/LineItemDetails");
    }

    /**
     * Deprecated. See REST API: ~/api/order/Order/{order}
     *
     * @throws MethodDeprecated
     */
    public function getOrderInfo()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/order/Order/{order}");
    }

    public function getOrderListRange()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getOrderListRecent()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/Shipping/Order/OrderTracking
     *
     * @throws MethodDeprecated
     */
    public function getOrderTracking()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/Shipping/Order/OrderTracking");
    }

    public function getPackslip()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPayments()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getReasonCodeTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getShippingMethods()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getTotals()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setStatusEntered()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setStatusPosted()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setStatusShipped()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setStatusVoid()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateBillingAddress()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateInvoiceNote()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateMultipleTrackingNumbers()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateOrderDetailTrackingNumber()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateOrderDetailTrackingNuberQuantity()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateShippingAddress()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateShippingMethod()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateTrackingNumber()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function version(): string
    {
        $result = $this->send('Version');
        return (string) $result->VersionResult->Message;
    }
}
