<?php


namespace Tests\Request;


use PHPUnit\Framework\TestCase;
use TBO\Request\Inner\SearchInnerRequestBuilder;

class SearchInnerRequestBuilderTest extends TestCase
{
    use SearchRequestSamples;

    public function testCanBuildRequestForSingleRoomSingleAdult()
    {
        $builder = new SearchInnerRequestBuilder();
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