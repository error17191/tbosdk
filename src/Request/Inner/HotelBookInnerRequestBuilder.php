<?php

namespace TBO\Request\Inner;

use TBO\Support\XML;

/**
 * Class HotelBookInnerRequestBuilder
 * @package TBO\Request\Inner
 *
 * @property XML $xml
 */
class HotelBookInnerRequestBuilder extends InnerRequestBuilder
{
    protected function build($data)
    {
        $this->xml->setById('client_reference_number',$data['client_reference_number']);
        $this->xml->setById('guest_nationality',$data['guest_nationality']);
        $guestDataNodes = $this->guestNodes();
        $guestNode = $this->xml->cloneElementById('guest');
        $guestsNode = $this->xml->getElementById('guests');
        $guestsNode->removeAttribute('id');
        foreach ($data['guests'] as $guest) {
            $guestsNode->appendChild($this->fillDataNodes($guest, $guestDataNodes, $guestNode));
        }
        $this->xml->setElementAttributesById(['VoucherBooking' => $data['voucher_booking']], 'payment_info');
        $this->xml->setById('session_id', $data['session_id']);
        $this->xml->setById('no_of_rooms', $data['no_of_rooms']);
        $this->xml->setById('result_index', $data['result_index']);
        $this->xml->setById('hotel_code', $data['hotel_code']);
        $this->xml->setById('hotel_name', $data['hotel_name']);
        $hotelRoomDataNodes = $this->hotelRoomNodes();
        $hotelRoomNode = $this->xml->cloneElementById('hotel_room');
        $hotelRoomsNode = $this->xml->getElementById('hotel_rooms');
        $hotelRoomsNode->removeAttribute('id');
        foreach ($data['hotel_rooms'] as $hotel_room) {
            $hotelRoomsNode->appendChild($this->fillDataNodes($hotel_room, $hotelRoomDataNodes, $hotelRoomNode));
        }
    }

    private function guestNodes()
    {
        $title = $this->xml->cloneElementById('title');
        $first_name = $this->xml->cloneElementById('first_name');
        $last_name = $this->xml->cloneElementById('last_name');
        $age = $this->xml->cloneElementById('age');
        return compact('title', 'first_name', 'last_name', 'age');
    }

    private function hotelRoomNodes()
    {
        $room_index = $this->xml->cloneElementById('room_index');
        $room_type_name = $this->xml->cloneElementById('room_type_name');
        $room_type_code = $this->xml->cloneElementById('room_type_code');
        $rate_plan_code = $this->xml->cloneElementById('rate_plan_code');
        $room_rate = $this->xml->cloneElementById('room_rate');
        $supplements = $this->xml->cloneElementById('supplements');
        return compact('room_index', 'room_type_name', 'room_type_code', 'rate_plan_code', 'room_rate', 'supplements');
    }

    private function fillDataNodes(array $data, array $dataNodes, \DOMElement $parentNode)
    {
        /** @var \DOMElement $newParentNode */
        $newParentNode = $parentNode->cloneNode();
        if (!empty($data['attributes'])) {
            $this->xml->setElementAttributes($data['attributes'], $newParentNode);
        }
        foreach ($dataNodes as $id => $dataNode) {
            if (($id === 'age' && empty($data['age'])) || ($id === 'supplements' && empty($data['supplements']))) {
                continue;
            }
            /** @var \DOMElement $newDataNode */
            $newDataNode = $dataNode->cloneNode();
            if ($id === 'supplements') {
                foreach ($data['supplements'] as $supplement) {
                    $supplementNode = $this->xml->createElement('SuppInfo');
                    $this->xml->setElementAttributes($supplement, $supplementNode);
                    $newDataNode->appendChild($supplementNode);
                }
                $newParentNode->appendChild($newDataNode);
                continue;
            }
            if ($id === 'room_rate') {
                $this->xml->setElementAttributes($data['room_rate'], $newDataNode);
                $newParentNode->appendChild($newDataNode);
                continue;
            }
            $newDataNode->textContent = $data[$id];
            $newParentNode->appendChild($newDataNode);
        }
        return $newParentNode;
    }

    protected function initialXML()
    {
        return '
             <hot:HotelBookRequest>       
                <hot:ClientReferenceNumber id="client_reference_number"></hot:ClientReferenceNumber>       
                <hot:GuestNationality id="guest_nationality"></hot:GuestNationality>       
                <hot:Guests id="guests">         
                    <hot:Guest id="guest" LeadGuest="" GuestType="" GuestInRoom="">           
                        <hot:Title id="title"></hot:Title>           
                        <hot:FirstName id="first_name"></hot:FirstName>
                        <hot:LastName id="last_name"></hot:LastName>           
                        <hot:Age id="age"></hot:Age> 
                    </hot:Guest> 
                </hot:Guests>     
                <hot:PaymentInfo id="payment_info" VoucherBooking="" PaymentModeType="Limit"> 
                </hot:PaymentInfo>       
                <hot:SessionId id="session_id"></hot:SessionId>
                <hot:NoOfRooms id="no_of_rooms"></hot:NoOfRooms>       
                <hot:ResultIndex id="result_index"></hot:ResultIndex>       
                <hot:HotelCode id="hotel_code"></hot:HotelCode>       
                <hot:HotelName id="hotel_name"></hot:HotelName>       
                <hot:HotelRooms id="hotel_rooms">         
                    <hot:HotelRoom id="hotel_room">           
                        <hot:RoomIndex id="room_index"></hot:RoomIndex>           
                        <hot:RoomTypeName id="room_type_name"></hot:RoomTypeName>           
                        <hot:RoomTypeCode id="room_type_code"></hot:RoomTypeCode>           
                        <hot:RatePlanCode id="rate_plan_code"></hot:RatePlanCode>           
                        <hot:RoomRate id="room_rate" RoomFare="" RoomTax="" TotalFare=""/> 
                        <hot:Supplements id="supplements">
                        </hot:Supplements>
                    </hot:HotelRoom> 
                </hot:HotelRooms> 
            </hot:HotelBookRequest>
        ';
    }
}