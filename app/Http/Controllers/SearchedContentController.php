<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SearchedContentController extends Controller
{
    public function extractToJson($data)
    {
        $xml = simplexml_load_string($data->body());
        $json = json_decode(json_encode($xml), true);
        return $json;
    }

    public function url($feedID, $mHotelID)
    {
        return env('BS_URL') . 'getfeed?feed_id='. $feedID .'&site_id=' . env('BS_SITE_ID') . '&token=' . env('BS_TOKEN') . '&mhotel_id='.$mHotelID;
    }

    public function index($propertyID)
    {
        
        $PropertyRoomImages = Http::get($this->url(6, $propertyID ?? 2256959));
        $PropertyImages = Http::get($this->url(7, $propertyID ?? 2256959));
        $PropertyInformation = Http::get($this->url(31, $propertyID ?? 2256959));
        $PropertyFacilities = Http::get($this->url(9, $propertyID ?? 2256959));

        return [
            'room_images' => $this->extractToJson($PropertyRoomImages),
            'images' => $this->extractToJson($PropertyImages),
            'information' => $this->extractToJson($PropertyInformation),
            'facilities' => $this->extractToJson($PropertyFacilities),
        ];

        return response()->json([
            'room_images' => $this->extractToJson($PropertyRoomImages),
            'images' => $this->extractToJson($PropertyImages),
            'information' => $this->extractToJson($PropertyInformation),
            'facilities' => $this->extractToJson($PropertyFacilities),
        ]);
    }
}
