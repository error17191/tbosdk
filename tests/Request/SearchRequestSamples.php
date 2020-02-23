<?php


namespace Tests\Request;


trait SearchRequestSamples
{
    private function xmlSampleSingleRoomSingleAdult()
    {
        return '<hot:HotelSearchRequest>
                        <hot:CheckInDate>2019-02-14</hot:CheckInDate>
                        <hot:CheckOutDate>2019-02-17</hot:CheckOutDate>
                        <hot:GuestNationality>SA</hot:GuestNationality>
                        <hot:NoOfRooms>1</hot:NoOfRooms>
                        <hot:CountryName>United Arab Emirates</hot:CountryName>
                        <hot:CityName>Dubai</hot:CityName>
                        <hot:CityId>115936</hot:CityId>
                        <hot:RoomGuests>
                            <hot:RoomGuest AdultCount="1" ChildCount="0"/>
                        </hot:RoomGuests>
                        <hot:ResultCount>0</hot:ResultCount>
                        <hot:Filters>
                            <hot:StarRating>All</hot:StarRating>
                        </hot:Filters>
                    </hot:HotelSearchRequest>';
    }

}