<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GooglePlaces extends Model
{
    protected $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function getGooglePlaceId($latitude, $longitude)
    {
        $keyword = 'カフェ';
        
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => "$latitude,$longitude",
            'keyword' => $keyword,
            'key' => $this->api_key,
        ]);

        $data = $response->json();

        if ($data['status'] === 'OK' && !empty($data['results'])) {
            $cafePlaceId = $data['results'][0]['place_id'];
            return $cafePlaceId;
        } else {
            return 'カフェが見つかりませんでした。';
        }
    }
}

