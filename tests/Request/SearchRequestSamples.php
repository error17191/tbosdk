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
                    </hot:HotelSearchRequest>';
    }

    private function xmlSampleSingleRoomMultipleAdults()
    {
        return '
                    <hot:HotelSearchRequest>
                        <hot:CheckInDate>2020-03-17</hot:CheckInDate>
                        <hot:CheckOutDate>2020-03-20</hot:CheckOutDate>
                        <hot:GuestNationality>EG</hot:GuestNationality>
                        <hot:NoOfRooms>1</hot:NoOfRooms>
                        <hot:CountryName>France</hot:CountryName>
                        <hot:CityName>Paris</hot:CityName>
                        <hot:CityId>131408</hot:CityId>
                        <hot:RoomGuests>
                            <hot:RoomGuest AdultCount="3" ChildCount="0"/>
                        </hot:RoomGuests>
                    </hot:HotelSearchRequest>
        ';
    }

    private function xmlSampleWithMultipleRooms()
    {
        return '
                    <hot:HotelSearchRequest>
                        <hot:CheckInDate>2020-03-17</hot:CheckInDate>
                        <hot:CheckOutDate>2020-03-20</hot:CheckOutDate>
                        <hot:GuestNationality>EG</hot:GuestNationality>
                        <hot:NoOfRooms>2</hot:NoOfRooms>
                        <hot:CountryName>France</hot:CountryName>
                        <hot:CityName>Paris</hot:CityName>
                        <hot:CityId>131408</hot:CityId>
                        <hot:RoomGuests>
                            <hot:RoomGuest AdultCount="3" ChildCount="0"/>
                            <hot:RoomGuest AdultCount="4" ChildCount="0"/>
                        </hot:RoomGuests>
                    </hot:HotelSearchRequest>
        ';
    }

}