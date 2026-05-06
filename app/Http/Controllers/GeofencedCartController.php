<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeofencedCartController extends Controller
{
    public function nearby(Request $request)
    {
        $userLatitude = (float) $request->input('latitude', 23.8103);
        $userLongitude = (float) $request->input('longitude', 90.4125);

        $nearbyCarts = DB::table('group_carts')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($cart) use ($userLatitude, $userLongitude) {
                $cart->distance = $this->calculateDistance(
                    $userLatitude,
                    $userLongitude,
                    (float) $cart->latitude,
                    (float) $cart->longitude
                );

                return $cart;
            })
            ->filter(function ($cart) {
                return $cart->distance <= 1;
            })
            ->sortBy('distance')
            ->values();

        return view('cart.nearby', compact(
            'nearbyCarts',
            'userLatitude',
            'userLongitude'
        ));
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $latDifference = deg2rad($lat2 - $lat1);
        $lonDifference = deg2rad($lon2 - $lon1);

        $a = sin($latDifference / 2) * sin($latDifference / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($lonDifference / 2) * sin($lonDifference / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}