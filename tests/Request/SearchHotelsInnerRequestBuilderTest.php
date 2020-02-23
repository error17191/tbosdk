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

}