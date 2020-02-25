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
        $guestDataNodes = $this->guestNodes();
        $guestNode = $this->xml->cloneElementById('Guest');
        $guestsNode = $this->xml->getElementById('Guests');
        $guestsNode->removeAttribute('id');
        foreach ($data['Guests'] as $guest) {
            $guestsNode->appendChild($this->fillDataNodes($guest, $guestDataNodes, $guestNode));
        }
        unset($data['Guests']);
        $this->xml->setElementAttributesById(['VoucherBooking' => $data['PaymentInfo']], 'PaymentInfo');
        unset($data['PaymentInfo']);
        $hotelRoomDataNodes = $this->hotelRoomNodes();
        $hotelRoomNode = $this->xml->cloneElementById('hotel_room');
        $hotelRoomsNode = $this->xml->getElementById('hotel_rooms');
        $hotelRoomsNode->removeAttribute('id');
        foreach ($data['HotelRooms'] as $hotel_room) {
            $hotelRoomsNode->appendChild($this->fillDataNodes($hotel_room, $hotelRoomDataNodes, $hotelRoomNode));
        }
        unset($data['HotelRooms']);
        $this->setDataToXML($data);
        $this->removeUnusedKeysInRequest();
    }

    private function guestNodes()
    {
        $Title = $this->xml->cloneElementById('Title');
        $FirstName = $this->xml->cloneElementById('FirstName');
        $LastName = $this->xml->cloneElementById('LastName');
        $Age = $this->xml->cloneElementById('Age');
        return compact('Title', 'FirstName', 'LastName', 'Age');
    }

    private function hotelRoomNodes()
    {
        $room_index = $this->xml->cloneElementById('RoomIndex');
        $room_type_name = $this->xml->cloneElementById('RoomTypeName');
        $room_type_code = $this->xml->cloneElementById('RoomTypeCode');
        $rate_plan_code = $this->xml->cloneElementById('RatePlanCode');
        $room_rate = $this->xml->cloneElementById('RoomRate');
        $supplements = $this->xml->cloneElementById('Supplements');
        return compact('room_index', 'room_type_name', 'room_type_code', 'rate_plan_code', 'room_rate', 'supplements');
    }

    private function fillDataNodes(array $data, array $dataNodes, \DOMElement $parentNode)
    {
        /** @var \DOMElement $newParentNode */
        $newParentNode = $parentNode->cloneNode();
        foreach ($dataNodes as $id => $dataNode) {
            /** @var \DOMElement $newDataNode */
            $newDataNode = $dataNode->cloneNode();
            switch ($id){
                case 'Age':
                    if(!empty($data['Age'])){
                        $newDataNode->textContent = $data[$id];
                        $newParentNode->appendChild($newDataNode);
                    }
                    break;
                case 'Supplements':
                    foreach ($data['Supplements'] as $supplement) {
                        $supplementNode = $this->xml->createElement('SuppInfo');
                        $this->xml->setElementAttributes($supplement, $supplementNode);
                        $newDataNode->appendChild($supplementNode);
                    }
                    $newParentNode->appendChild($newDataNode);
                    break;
                case 'RoomRate':
                    $this->xml->setElementAttributes($data['RoomRate'], $newDataNode);
                    $newParentNode->appendChild($newDataNode);
                    break;
                case 'GuestInRoom':
                case 'GuestType':
                case 'LeadGuest':
                    $newParentNode->setAttribute($id,$data[$id]);
                    break;
                default:
                    $newDataNode->textContent = $data[$id];
                    $newParentNode->appendChild($newDataNode);
                    break;
            }
        }
        return $newParentNode;
    }

    protected function initialXML()
    {
        return '
             <hot:HotelBookRequest>       
                <hot:ClientReferenceNumber id="ClientReferenceNumber"></hot:ClientReferenceNumber>       
                <hot:GuestNationality id="GuestNationality"></hot:GuestNationality>       
                <hot:Guests id="Guests">         
                    <hot:Guest id="Guest" LeadGuest="" GuestType="" GuestInRoom="">           
                        <hot:Title id="Title"></hot:Title>           
                        <hot:FirstName id="FirstName"></hot:FirstName>
                        <hot:LastName id="LastName"></hot:LastName>           
                        <hot:Age id="Age"></hot:Age> 
                    </hot:Guest> 
                </hot:Guests>     
                <hot:PaymentInfo id="PaymentInfo" VoucherBooking="" PaymentModeType="Limit"> 
                </hot:PaymentInfo>       
                <hot:SessionId id="SessionId"></hot:SessionId>
                <hot:NoOfRooms id="NoOfRooms"></hot:NoOfRooms>       
                <hot:ResultIndex id="ResultIndex"></hot:ResultIndex>       
                <hot:HotelCode id="HotelCode"></hot:HotelCode>       
                <hot:HotelName id="HotelName"></hot:HotelName>       
                <hot:HotelRooms id="HotelRooms">         
                    <hot:HotelRoom id="HotelRoom">           
                        <hot:RoomIndex id="RoomIndex"></hot:RoomIndex>           
                        <hot:RoomTypeName id="RoomTypeName"></hot:RoomTypeName>           
                        <hot:RoomTypeCode id="RoomTypeCode"></hot:RoomTypeCode>           
                        <hot:RatePlanCode id="RatePlanCode"></hot:RatePlanCode>           
                        <hot:RoomRate id="RoomRate" RoomFare="" RoomTax="" TotalFare=""/> 
                        <hot:Supplements id="Supplements">
                        </hot:Supplements>
                    </hot:HotelRoom> 
                </hot:HotelRooms> 
            </hot:HotelBookRequest>
        ';
    }
}