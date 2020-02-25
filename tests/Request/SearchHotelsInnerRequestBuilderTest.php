<?php


namespace Tests\Request;


use PHPUnit\Framework\TestCase;
use TBO\Request\Inner\SearchHotelsInnerRequestBuilder;

class SearchHotelsInnerRequestBuilderTest extends TestCase
{
    use SearchRequestSamples;

    public function testCanBuildRequestForSingleRoomSingleAdult()
    {
        $builder = new SearchHotelsInnerRequestBuilder();
        $builder->build([
            'CheckInDate' => '2019-02-14',
            'CheckOutDate' => '2019-02-17',
            'CityName' => 'Dubai',
            'CityId' => '115936',
            'CountryName' => 'United Arab Emirates',
            'GuestNationality' => 'SA',
            'Rooms' => [
                [
                    "AdultCount" => 1
                ]
            ],
            'Filters' => [
                "StarRating" => 'All'
            ],

        ]);

        $this->assertXmlStringEqualsXmlString($this->xmlSampleSingleRoomSingleAdult(), $builder->xml());

    }

    public function testCanBuildRequestSingleRoomMultipleAdults()
    {
        $builder = new SearchInnerRequestBuilder();
        $builder->build([
            'CheckInDate' => '2020-03-17',
            'CheckOutDate' => '2020-03-20',
            'CityName' => 'Paris',
            'CityId' => '131408',
            'CountryName' => 'France',
            'GuestNationality' => 'EG',
            'Rooms' => [
                [
                    "AdultCount" => 3
                ]
            ],
            'Filters' => [
                "StarRating" => 'All'
            ],

        ]);

        $this->assertXmlStringEqualsXmlString($this->xmlSampleSingleRoomMultipleAdults(), $builder->xml());
    }

    public function testCanBuildRequestWithMultipleRooms()
    {
        $builder = new SearchInnerRequestBuilder();
        $builder->build([
            'CheckInDate' => '2020-03-17',
            'CheckOutDate' => '2020-03-20',
            'CityName' => 'Paris',
            'CityId' => '131408',
            'CountryName' => 'France',
            'GuestNationality' => 'EG',
            'Rooms' => [
                [
                    "AdultCount" => 3
                ],
                [
                    "AdultCount" => 4
                ],
            ],
            'Filters' => [
                "StarRating" => 'All'
            ],

        ]);

    }

    public function testCanBuildRequestWithChildren()
    {
        $builder = new SearchInnerRequestBuilder();
        $builder->build([
            'CheckInDate' => '2020-03-17',
            'CheckOutDate' => '2020-03-20',
            'CityName' => 'Paris',
            'CityId' => '131408',
            'CountryName' => 'France',
            'GuestNationality' => 'EG',
            'Rooms' => [
                [
                    "AdultCount" => 3
                ],
                [
                    "AdultCount" => 4
                ],
            ],
            'Filters' => [
                "StarRating" => 'All'
            ],

        ]);

    }
}