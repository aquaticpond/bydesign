<?php

namespace Aquatic\ByDesign;

use Aquatic\ByDesign\Exceptions\MethodDeprecated;
use Aquatic\ByDesign\SOAP\API;

class ExtranetAPI extends API
{
    public function bindGenealogyTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function bindRanks()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createShippingProfile()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function createTroubleTickets()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function customerToRep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCoApplicantInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCommissionDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCommissionDetailsBC()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCommissionSubtotals()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCommissionSubtotalsBC()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCommissions()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCommissionsBC()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getCustomerOrders()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getDownlineReturnOrders()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getEarnings()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getGenealogyReport()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getGenealogyReportExtended()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getHoldingTank()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getHoldingTankSettings()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getOrders()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getOrdersByCustomer()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPaidAdjustmentDetail()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPersSponByLeg()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getPreferredPlacement()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRecentGrowthStatistics()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepSocialNetworks()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getRepsByEmail()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getShippingProfiles()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getTroubleTicket()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getTroubleTickets()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getTroubleTicketsStatusTypes()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/commissions/volumeReport
     *
     * @throws MethodDeprecated
     */
    public function getVolumeReport()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/commissions/volumeReport");
    }

    public function getVolumeReportByLevelDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getVolumeReportByLevelDetailsSummary()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API: ~/api/commissions/volumeReport/{repDID}/detailByLeg/{volumeTypeId}
     *
     * @throws MethodDeprecated
     */
    public function getVolumeReportDetailByLeg()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/commissions/volumeReport/{repDID}/detailByLeg/{volumeTypeID}");
    }

    public function getVolumeReportDetailByLeg2()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getVolumeReportDetailByLeg2Summary()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    /**
     * Deprecated. See REST API:/ ~/api/commissions/volumeReport/{repDID}/details/{volumeTypeID}/{columnName}?bcDID
     *
     * @throws MethodDeprecated
     */
    public function getVolumeReportDetails()
    {
        throw new MethodDeprecated(__METHOD__ . " has been deprecated. Please see REST API: ~/api/commissions/volumeReport/{repDID}/details/{volumeTypeID}/{columnName}?bcDID");
    }

    public function getVolumeReportDetailsSummary()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getVolumeReportSPersonalDetails()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getVolumeTotalsByLevel()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function getVolumeTotalsByRep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function locateARep()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function locateRepsInRange()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function setPreferredPlacement()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateCoApplicantInfo()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateHoldingTank()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateShippingProfile()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }

    public function updateTroubleTickets()
    {
        throw new BadMethodCallException(__METHOD__ . " has not been implemented yet.");
    }
}
