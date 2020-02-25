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
        $roomsDom = $this->xml->getElementById('RoomGuests');
        foreach ($data['Rooms'] as $room) {
            $roomsDom->appendChild($this->buildRoomDomElement($room));
        }
        $roomsDom->removeAttribute('id');
        unset($data['Rooms']);
        foreach ($data as $key => $value) {
            $this->xml->setById($key,$value);
        }
    }

    protected function buildRoomDomElement($room)
    {
        $roomDom = $this->xml->createElement('RoomGuest');
        $roomDom->setAttribute('AdultCount', $room['AdultCount']);
        $roomDom->setAttribute('ChildCount',
            isset($room['ChildrenAges']) ? count($room['ChildrenAges']) : 0);
        if (!isset($room['ChildrenAges'])) {
            return $roomDom;
        }
        $agesDom = $this->xml->createElement('ChildAge');
        $roomDom->appendChild($agesDom);

        foreach ($room['ChildrenAges'] as $age) {
            $agesDom->appendChild($this->xml->createElement('int', $age));
        }
        return $roomDom;
    }

    protected function initialXML()
    {
        return '
              <hot:HotelSearchRequest>
                        <hot:CheckInDate id="CheckInDate">today</hot:CheckInDate>
                        <hot:CheckOutDate id="CheckOutDate">tomorrow</hot:CheckOutDate>
                        <hot:GuestNationality id="GuestNationality">EG</hot:GuestNationality>
                        <hot:NoOfRooms id="NoOfRooms">1</hot:NoOfRooms>
                        <hot:CountryName id="CountryName">Afghanistan</hot:CountryName>
                        <hot:CityName id="CityName"></hot:CityName>
                        <hot:CityId id="CityId">148838</hot:CityId>
                        <hot:RoomGuests id="RoomGuests">
                        </hot:RoomGuests>
                        <hot:ResultCount>0</hot:ResultCount>                                  
                    </hot:HotelSearchRequest>
        ';
    }
}