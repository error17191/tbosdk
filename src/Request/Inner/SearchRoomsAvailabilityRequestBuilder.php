<?php


namespace TBO\Request\Inner;

use TBO\Support\XML;

/**
 * Class SearchRoomsAvailabilityRequestBuilder
 * @package TBO\Request\Inner
 *
 * @property XML $xml
 */
class SearchRoomsAvailabilityRequestBuilder extends InnerRequestBuilder
{

    protected function build($data)
    {
        $this->xml->setById('session_id',$data['session_id']);
        $this->xml->setById('result_index',$data['result_index']);
        $this->xml->setById('hotel_code',$data['hotel_code']);
        $this->xml->setById('response_time',$data['response_time']);
    }

    protected function initialXML()
    {
        return '
            <hot:HotelRoomAvailabilityRequest>
                <hot:SessionId id="session_id"></hot:SessionId>
                <hot:ResultIndex id="result_index"></hot:ResultIndex>
                <hot:HotelCode id="hotel_code"></hot:HotelCode>
                <hot:ResponseTime id="response_time"></hot:ResponseTime>
                <hot:IsCancellationPolicyRequired>true</hot:IsCancellationPolicyRequired>
            </hot:HotelRoomAvailabilityRequest>
        ';
    }
}