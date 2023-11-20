<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GooglePlaces;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\GooglePlaceRequest;
use App\Models\Category;

class GooglePlaceController extends Controller
{

    public function search(GooglePlaceRequest $request)
    {
        $apiKey = env('GOOGLE_PLACES_API_KEY');//if文
        $address = $request['location']; // 検索したい地名
        
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        //dd($data);
        
        $api_key = env('GOOGLE_PLACES_API_KEY');
        $lat = $data['results'][0]['geometry']['location']['lat'];//緯度　//地名を入力されたときは＄dataから
        $lon = $data['results'][0]['geometry']['location']['lng'];//軽度
        //dd($lat);
        //$name = $request['name'];
        //$location = $request['location'];
        //$lat = 35.730132;
        //$lon = 139.703802;
        $search = 'カフェ' . $request['search']; // 検索キーワード
        //dd($request);
        //dd($lat);
        // Google Places APIのURLを構築
        $url = sprintf(
            "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=%s,%s&radius=1500&type=restaurant&keyword=%s&language=ja&key=%s",
            $lat,
            $lon,
            //$name,
            //$location,
            urlencode($search),
            $api_key,
            
            
        );
        // cURLを使用してAPIリクエストを送信
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // JSONレスポンスを配列にデコード
        $places = json_decode($response, true)['results'];
        // dd($places
        
        
        
        $details = [];
        foreach($places as $place)//place_idを使って場所を逆算している
        {
            $placeId = $place['place_id'];  // 特定の場所のplace_idを設定
            // Google Places APIのURLを構築
            $url = sprintf(
                "https://maps.googleapis.com/maps/api/place/details/json?place_id=%s&language=ja&key=%s",
                 //"https://maps.googleapis.com/maps/api/place/details/json?place_id=%25s&fields=geometry/location&key=%25s", //座標
                $placeId,
                $api_key
            );
            // cURLを使用してAPIリクエストを送信
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // JSONレスポンスを配列にデコード
            $detail = json_decode($response, true)['result'];
            //dd($detail);
            $details[] = $detail;
            
            //return view('reviews.show', ['photoUrl' => $photoUrl]);
            //return redirect()->route('create')->with(['details' => $details]);
            
        }
            return view('reviews.show',[
                'details' => $details,
                'address' => $address,
                'place_id' => $placeId
                ]);
     }
     
     //categoryテーブルの中身がnull値になってしまっているので正しいかわからない
    public function detailsearch(Category $category, Request $request)
    {
            $search = $request['detailsearch'];
            //dd($search);
            $placeIds = Category::where($search, 1)->pluck('place_id')->toArray();
            //dd($placeIds);
            $api_key = env('GOOGLE_PLACES_API_KEY');
            foreach($placeIds as $placeId)//place_idを使って場所を逆算している
            {
            // Google Places APIのURLを構築
            $url = sprintf(
                "https://maps.googleapis.com/maps/api/place/details/json?place_id=%s&language=ja&key=%s",
                 //"https://maps.googleapis.com/maps/api/place/details/json?place_id=%25s&fields=geometry/location&key=%25s", //座標
                $placeId,
                $api_key
            );
            // cURLを使用してAPIリクエストを送信
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // JSONレスポンスを配列にデコード
            $detail = json_decode($response, true)['result'];
            //dd($detail);
            $details[] = $detail;
            //dd($details);
            }
            return view('reviews.detailShow', [
                'details' => $details,
                'search' => $search,
                'place_id' => $placeId
                ]);
        
    }
    
    
}
