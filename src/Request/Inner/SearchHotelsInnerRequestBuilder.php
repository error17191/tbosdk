<?php


namespace TBO\Request\Inner;

use TBO\Support\XML;

/**
 * Class SearchHotelsInnerRequestBuilder
 * @package TBO\Request\Inner
 *
 * @property XML $xml
 */
class SearchHotelsInnerRequestBuilder extends InnerRequestBuilder
{
    public function build($data)
    {
        $this->xml->setById('checkin', $data['checkin']);
        $this->xml->setById('checkout', $data['checkout']);
        $this->xml->setById('nationality', $data['nationality']);
        $this->xml->setById('no_rooms', $data['no_rooms']);
        $this->xml->setById('country_name', $data['country_name']);
        $this->xml->setById('city_name', $data['city_name']);
        $this->xml->setById('city_id', $data['city_id']);
        $roomsDom = $this->xml->getElementById('room_guests');
        foreach ($data['rooms'] as $room) {
            $roomsDom->appendChild($this->buildRoomDomElement($room));
        }
        $roomsDom->removeAttribute('id');
    }

    protected function buildRoomDomElement($room)
    {
        $roomDom = $this->xml->createElement('RoomGuest');
        $roomDom->setAttribute('AdultCount', $room['adults']);
        $roomDom->setAttribute('ChildCount',
            isset($room['children_ages']) ? count($room['children_ages']) : 0);
        if (!isset($room['children_ages'])) {
            return $roomDom;
        }
        $agesDom = $this->xml->createElement('ChildAge');
        $roomDom->appendChild($agesDom);

        foreach ($room['children_ages'] as $age) {
            $agesDom->appendChild($this->xml->createElement('int', $age));
        }
        return $roomDom;
    }

    protected function initialXML()
    {
        return '
              <hot:HotelSearchRequest>
                        <hot:CheckInDate id="checkin">today</hot:CheckInDate>
                        <hot:CheckOutDate id="checkout">tomorrow</hot:CheckOutDate>
                        <hot:GuestNationality id="nationality">EG</hot:GuestNationality>
                        <hot:NoOfRooms id="no_rooms">1</hot:NoOfRooms>
                        <hot:CountryName id="country_name">Afghanistan</hot:CountryName>
                        <hot:CityName id="city_name">Bost</hot:CityName>
                        <hot:CityId id="city_id">148838</hot:CityId>
                        <hot:RoomGuests id="room_guests">
                        </hot:RoomGuests>
                        <hot:ResultCount>0</hot:ResultCount>
                        <hot:Filters>
                            <hot:StarRating>All</hot:StarRating>
                        </hot:Filters>                 
                    </hot:HotelSearchRequest>
        ';
    }
}