<?php


namespace TBO\Request\Inner;



use TBO\Support\XML;

class SearchHotelsInnerRequestBuilder implements InnerRequestBuilder
{
    protected $template = '
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
                            <hot:HotelCodeList id="hotel_code_list"></hot:HotelCodeList>
                            <hot:StarRating id="star_rating"></hot:StarRating>
                        </hot:Filters>
                    </hot:HotelSearchRequest>
                ';
    /**
     * @var \TBO\Support\XML
     */
    protected $xml;

    public function build($data)
    {
        $this->xml = new XML($this->template);
        $this->xml->setById('checkin',$data['checkin']);
        $this->xml->setById('checkout',$data['checkout']);
        $this->xml->setById('nationality',$data['nationality']);
        $this->xml->setById('no_rooms',$data['no_rooms']);
        $this->xml->setById('country_name',$data['country_name']);
        $this->xml->setById('city_name',$data['city_name']);
        $this->xml->setById('city_id',$data['city_id']);
        $roomsDom = $this->xml->getElementById('room_guests');
        foreach ($data['rooms'] as $room) {
            $roomsDom->appendChild($this->buildRoomDomElement($room));
        }
        $roomsDom->removeAttribute('id');
        !empty($data['hotel_code_list']) ?
            $this->xml->setById('hotel_code_list', $data['hotel_code_list']) :
            $this->xml->removeElementById('hotel_code_list');
        !empty($data['star_rating']) ?
            $this->xml->setById('star_rating',$this->mapStarRating($data['star_rating'])) :
            $this->xml->setById('star_rating','All');
    }

    public function xml()
    {
        return $this->xml->getXML();
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

    protected function toStarsInteger($rating)
    {
        $replacements = [
            'Star' => '',
            'One' => 1,
            'Two' => 2,
            'Three' => 3,
            'Four' => 4,
            'Five' => 5,
            'Zero' => 0,
            'No' => 0
        ];
        return (int)(str_replace(array_keys($replacements), array_values($replacements), $rating));
    }
}