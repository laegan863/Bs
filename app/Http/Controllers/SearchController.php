<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SearchedContentController;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $propertyId = $request->input('property', 2256959);
        $checkIn = $request->input('checkin', now()->format('Y-m-d'));
        $checkOut = $request->input('checkout', now()->addDay()->format('Y-m-d'));
        $rooms = $request->input('rooms', 1);
        $adults = $request->input('adults', 2);
        $children = $request->input('children', 0);

        $api = "https://sandbox-affiliateapi.agoda.com/api/v4/property/availability";
        $payload = [
            "waitTime" => 60,
            "criteria" => [
                "propertyIds" => [(int) $propertyId],
                "checkIn" => $checkIn,
                "checkOut" => $checkOut,
                "rooms" => (int) $rooms,
                "adults" => (int) $adults,
                "children" => (int) $children,
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
            'Authorization' => '1952979:97af8aba-5b21-4a37-ad75-a034c9e46742',
            'Content-Type' => 'application/json',
        ])->post($api, $payload);

        $searchedContentController = new SearchedContentController();
        $searchedData = $searchedContentController->index(2256959);

        $data = $response->json();
        $property = $data['properties'][0] ?? null;

        // Group rooms by parentRoomName
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

        // Count unique room types and total deals
        $roomTypeCount = count($groupedRooms);
        $totalDeals = $property ? count($property['rooms'] ?? []) : 0;

        // Find lowest price
        $lowestPrice = null;
        if ($property && isset($property['rooms'])) {
            foreach ($property['rooms'] as $room) {
                $price = $room['rate']['inclusive'] ?? null;
                if ($price !== null && ($lowestPrice === null || $price < $lowestPrice)) {
                    $lowestPrice = $price;
                }
            }
        }

        // return response()->json([
        //     'property' => $property,
        //     'data' => $searchedData,
        //     'groupedRooms' => $groupedRooms,
        //     'roomTypeCount' => $roomTypeCount,
        //     'totalDeals' => $totalDeals,
        //     'lowestPrice' => $lowestPrice,
        //     'checkIn' => $checkIn,
        //     'checkOut' => $checkOut,
        //     'adults' => $adults,
        //     'children' => $children,
        //     'rooms' => $rooms,
        // ]);

        return view('property-detail', [
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
