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

    /**
     * Create internal Note **THERE IS CURRENTLY NO API TO GET THESE BACK ONCE THEY ARE CREATED***
     *
     * @param integer $order_id
     * @param integer $category_id
     * @param integer $correspondence_type_id
     * @param string $message
     * @param string $subject
     * @return Object ByDesign response
     */
    public function createInternalNote(int $order_id, int $category_id, int $correspondence_type_id, string $message, string $subject)
    {
        return $this->send('CreateInternalNote', [
            'OrderID' => $order_id,
            'CategoryID' => $category_id,
            'CorrespondanceTypeID' => $correspondence_type_id,
            'Message1' => $message,
            'Subject' => $subject,
            'Unresolved' => false,
            'Critical' => false
        ]);
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

    public function getPayments($order_id)
    {
        return $this->send('GetPayments', ['OrderID' => $order_id]);
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

    /**
     * Void an order
     *
     * @param integer $order_id
     * @param string $reason
     * @return Object ByDesign SetStatusVoidResult
     */
    public function setStatusVoid(int $order_id, string $reason = '')
    {
        // @todo: map result?
        return $this->send('SetStatusVoid', [
            'OrderID' => $order_id,
            'InvoiceNotes' => $reason
        ]);
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
