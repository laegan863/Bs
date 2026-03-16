<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SearchedContentController extends Controller
{
    public function extractToJson($data)
    {
        $body = $data->body();

        // Handle gzip-compressed responses
        if (substr($body, 0, 2) === "\x1f\x8b") {
            $body = gzdecode($body);
        }

        // Handle HTML-encoded XML (e.g. &lt; instead of <)
        if (strpos($body, '&lt;') !== false && strpos($body, '<') === false) {
            $body = html_entity_decode($body);
        }

        $xml = simplexml_load_string($body);
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
    }

    public function getCities(Request $request)
    {
        $search = $request->query('q', '');
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=3&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID'));
        $data = $this->extractToJson($query);

        $cities = $data['cities']['city'] ?? [];
        $filtered = array_filter($cities, function ($city) use ($search) {
            return stripos($city['city_name'], $search) !== false;
        });

        $results = array_slice(array_values($filtered), 0, 15);

        return response()->json($results);
    }

    public function getHotel($id)
    {
        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=5&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID') . '&mcity_id=' . $id);
        return response()->json($this->extractToJson($query));
    }

    public function getHotelById($id)
    {
        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=7&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID') . '&mhotel_id=' . ($id ?? 13598552));
        return response()->json($this->extractToJson($query));
    }
}
    