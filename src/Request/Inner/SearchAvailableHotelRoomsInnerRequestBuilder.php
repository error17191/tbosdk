<?php


namespace TBO\Request\Inner;

use TBO\Support\XML;

/**
 * Class SearchAvailableHotelRoomsInnerRequestBuilder
 * @package TBO\Request\Inner
 *
 * @property XML $xml
 */
class SearchAvailableHotelRoomsInnerRequestBuilder extends InnerRequestBuilder
{
    protected function build($data)
    {
        $this->setDataToXML($data);
        $this->removeUnusedKeysInRequest();
    }

    protected function initialXML()
    {
        return '
            <hot:HotelRoomAvailabilityRequest>
                <hot:SessionId id="SessionId"></hot:SessionId>
                <hot:ResultIndex id="ResultIndex"></hot:ResultIndex>
                <hot:HotelCode id="HotelCode"></hot:HotelCode>
                <hot:ResponseTime id="ResponseTime"></hot:ResponseTime>
                <hot:IsCancellationPolicyRequired>true</hot:IsCancellationPolicyRequired>
            </hot:HotelRoomAvailabilityRequest>
        ';
    }
}