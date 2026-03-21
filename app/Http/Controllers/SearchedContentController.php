<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SearchedContentController extends Controller
{
    public function extractToJson($data)
    {
        $body = $data->body();
        if (substr($body, 0, 2) === "\x1f\x8b") {
            $body = gzdecode($body);
        }
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
        ini_set('memory_limit', '512M');
        $search = strtolower($request->input('q', ''));
        // $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=3&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID'));
        // $data = $this->extractToJson($query);
        // $cities = $data['cities']['city'] ?? [];

        $path = public_path('city.json');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        $json = file_get_contents($path);
        $city = json_decode($json, true);
        $cities = $city['cities']['city'] ?? [];


        if (isset($cities['city_id'])) {
            $cities = [$cities];
        }
        if ($search !== '') {
            $cities = array_values(array_filter($cities, function ($city) use ($search) {
                return str_contains(strtolower($city['city_name'] ?? ''), $search);
            }));
        }
        $cities = array_slice($cities, 0, 20);
        return response()->json($cities);
    }

    public function getCityByIdTest()
    {
        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=3&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID'));
        $data = $this->extractToJson($query);

        return response()->json($data);
    }

    public function getCityById($id)
    {
        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=3&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID'));
        $data = $this->extractToJson($query);

        $city = collect($data['cities']['city'] ?? [])->firstWhere('city_id', $id);
        return $city ?? null;
    }

    public function getHotel($id, $limit = 15)
    {
        ini_set('memory_limit', '512M');

        $query = Http::timeout(120)->get(env('BS_URL').'getfeed?feed_id=5&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID') . '&mcity_id=' . $id);
        $data = $this->extractToJson($query);
        
        if(empty($data['hotels'])) {
            return [];
        }

        $hotels = $data['hotels']['hotel'] ?? [];

        if (isset($hotels['hotel_id'])) {
            $hotels = [$hotels];
        }

        $totalCount = count($hotels);

        $firstBatch = array_slice($hotels, 0, $limit);
        foreach($firstBatch as &$hotel) {
            $hotel['images'] = $this->getHotelImage($hotel['hotel_id']);
        }
        unset($hotel);
        Cache::store('file')->put('hotel_search_' . $id, $hotels, now()->addMinutes(30));

        $data['hotels']['hotel'] = $firstBatch;
        $data['hotels']['total_count'] = $totalCount;
        $data['hotels']['loaded_count'] = count($firstBatch);
        $data['hotels']['has_more'] = $totalCount > $limit;

        return $data;
    }

    public function getHotelsPaginated(Request $request)
    {
        ini_set('memory_limit', '512M');

        $cityId = $request->input('city_id');
        $offset = (int) $request->input('offset', 50);
        $limit = (int) $request->input('limit', 50);

        $hotels = Cache::store('file')->get('hotel_search_' . $cityId);

        if (!$hotels) {
            $query = Http::timeout(120)->get(env('BS_URL').'getfeed?feed_id=5&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID') . '&mcity_id=' . $cityId);
            $data = $this->extractToJson($query);

            if (empty($data['hotels'])) {
                return response()->json(['hotels' => [], 'has_more' => false]);
            }

            $hotels = $data['hotels']['hotel'] ?? [];
            if (isset($hotels['hotel_id'])) {
                $hotels = [$hotels];
            }

            Cache::store('file')->put('hotel_search_' . $cityId, $hotels, now()->addMinutes(30));
        }

        $batch = array_slice($hotels, $offset, $limit);

        foreach($batch as &$hotel) {
            $hotel['images'] = $this->getHotelImage($hotel['hotel_id']);
        }
        unset($hotel);

        return response()->json([
            'hotels' => $batch,
            'has_more' => ($offset + $limit) < count($hotels),
            'total_count' => count($hotels),
            'loaded_count' => $offset + count($batch),
        ]);
    }

    public function getHotelImage($id)
    {
        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=6&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID') . '&mhotel_id=' . ($id ?? 2256959));
        $data = $this->extractToJson($query);

        if (empty($data['roomtypes']['roomtype'])) {
            return null;
        }

        $roomtype = $data['roomtypes']['roomtype'];
        if (isset($roomtype['hotel_room_type_picture'])) {
            return $roomtype['hotel_room_type_picture'];
        }
        $queryFirst = collect($roomtype)->pluck('hotel_room_type_picture')->filter()->first();
        return $queryFirst ?? null;
    }

    public function getHotelById($id)
    {
        ini_set('memory_limit', '512M');
        $query = Http::timeout(60)->get(env('BS_URL').'getfeed?feed_id=7&token=' . env('BS_TOKEN') . '&site_id=' . env('BS_SITE_ID') . '&mhotel_id=' . ($id ?? 13598552));
        return response()->json($this->extractToJson($query));
    }

    public function getHotelFullInfoByHotelId(Request $request, $id)
    {
        ini_set('memory_limit', '512M');

        $checkIn = $request->input('checkin', now()->format('Y-m-d'));
        $checkOut = $request->input('checkout', now()->addDay()->format('Y-m-d'));
        $rooms = (int) $request->input('rooms', 1);
        $adults = (int) $request->input('adults', 2);
        $children = (int) $request->input('children', 0);

        $api = "https://sandbox-affiliateapi.agoda.com/api/v4/property/availability";
        $payload = [
            "waitTime" => 60,
            "criteria" => [
                "propertyIds" => [(int) $id],
                "checkIn" => $checkIn,
                "checkOut" => $checkOut,
                "rooms" => $rooms,
                "adults" => $adults,
                "children" => $children,
                "childrenAges" => [],
                "language" => "en-us",
                "currency" => "USD",
                "userCountry" => "US"
            ],
            "features" => [
                "ratesPerProperty" => 25,
                "extra" => [
                    "content",
                    "surchargeDetail",
                    "CancellationDetail",
                    "BenefitDetail",
                    "dailyRate",
                    "taxDetail",
                    "rateDetail",
                    "promotionDetail"
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => env('AGODA_API_KEY', '1952979:97af8aba-5b21-4a37-ad75-a034c9e46742'),
            'Content-Type' => 'application/json',
        ])->post($api, $payload);

        $data = $response->json();
        $property = $data['properties'][0] ?? null;
        $searchedId = $data['searchId'] ?? null;
        $searchedData = $this->index($id);

        $groupedRooms = [];
        if ($property && isset($property['rooms'])) {
            foreach ($property['rooms'] as $room) {
                $parentName = $room['parentRoomName'] ?? $room['roomName'];
                if (!isset($groupedRooms[$parentName])) {
                    $groupedRooms[$parentName] = [
                        'name' => $parentName,
                        'rooms' => [],
                    ];
                }
                $groupedRooms[$parentName]['rooms'][] = $room;
            }
        }

        $roomTypeCount = count($groupedRooms);
        $totalDeals = $property ? count($property['rooms'] ?? []) : 0;

        $lowestPrice = null;
        if ($property && isset($property['rooms'])) {
            foreach ($property['rooms'] as $room) {
                $price = $room['rate']['inclusive'] ?? null;
                if ($price !== null && ($lowestPrice === null || $price < $lowestPrice)) {
                    $lowestPrice = $price;
                }
            }
        }

        return view('property-detail', [
            'searchedId' => $searchedId,
            'property' => $property,
            'data' => $searchedData,
            'groupedRooms' => $groupedRooms,
            'roomTypeCount' => $roomTypeCount,
            'totalDeals' => $totalDeals,
            'lowestPrice' => $lowestPrice,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'adults' => $adults,
            'children' => $children,
            'rooms' => $rooms,
        ]);
    }
}
    