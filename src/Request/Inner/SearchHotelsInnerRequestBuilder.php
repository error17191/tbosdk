<?php


namespace TBO\Request\Inner;


use TBO\Traits\XMLHelpersTrait;

class SearchHotelsInnerRequestBuilder implements InnerRequestBuilder
{
    use XMLHelpersTrait;


    public function build($data)
    {
        // TODO: Implement build() method.
    }

    public function xml()
    {
        // TODO: Implement xml() method.
    }

    protected function getBasicRequestBody()
    {
        return
            '
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
    }
}