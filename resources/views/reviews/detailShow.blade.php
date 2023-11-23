<!DOCTYPE HTML>
<x-app-layout>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token,viewport" content="{{ csrf_token() }},width=device-width, initial-scale=1">
        <title>Posts</title>
        <!-- Fonts -->
           <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
           <link rel="stylesheet" href="{{ asset('/css/Wantgo.css') }}" >
@vite(['resources/css/app.css','resources/js/app.js'])
{{-- ※以下は、@vite(['resources/css/app.css', 'resources/js/app.js'])の下に記述 --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    @if ($search === 'charger')
    <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl dark:text-white">
        充電スペースのあるお店
    </h1>
    
    @elseif($search === 'morning')
    <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl dark:text-white">
        朝食メニューのあるお店
    </h1>
    
    @elseif($search === 'lunch')
    <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl dark:text-white">
        ランチメニューのあるお店
    </h1>

    @elseif($search === 'dinner')
    <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl dark:text-white">
        ディナーメニューのあるお店
    </h1>
    
    @elseif($search === 'night')
    <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl dark:text-white">
        深夜営業のあるお店
    </h1>
    
    @elseif($search === 'pet')
    <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl dark:text-white">
        ペット連れ込み可のお店
    </h1>
    @endif
    </head>
    <body>
        
   @foreach ($details as $detail)
   <div class="container mx-auto my-4 px-4 border border-black-500">
    <li> {{--cssでlistの機能を消す--}}
        
        <h2 class="text-center text-3xl font-bold text-gray-900 dark:text-white">{{ $detail['name'] }}</h2>
         
        <p class="text-center text-2xl font-bold text-gray-900 dark:text-white">{{ $detail['formatted_address'] }}</p>
        @if (isset($detail['opening_hours']) && isset($detail['opening_hours']['weekday_text']) && !empty($detail['opening_hours']['weekday_text']))
            <p class="text-center text-2xl font-bold text-gray-900 dark:text-white">営業時間: {{ $detail['opening_hours']['weekday_text'][0] }}</p>
            <ul>
        
        @endif
        <!--いきたいお店を保存-->
        <!-- お店を保存するボタン -->
        
    <!-- Wantgo.phpに作ったisSavedByメソッドをここで使用 -->
                @php
                    $wantgo = auth()->user()->wantgos->contains('place_id', $detail['place_id']);
                @endphp
        
            @if(!$wantgo)
                <span class="save-button">
                    <i class="fas fa-bookmark shops-save" data-place-id="{{$detail['place_id']}}"></i>
                </span>
            @else
                <span class="save-button">
                    <i class="fas fa-bookmark shops-save saved" data-place-id="{{ $detail['place_id']}}"></i>
                </span>
             @endif 
             <!--口コミ投稿機能-->
            <form action="/reviews/create" method = "POST">
                @csrf
                <input type ="hidden" value ="{{ $detail['name'] }}" name ="shopName">
                <input type ="hidden" value ="{{ $detail['place_id'] }}" name ="placeId">
                <button type ="submit" value ="口コミ投稿" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                    口コミ投稿
                </button>
                </form>
                <form action="/reviews/shopShow" method = "POST">
                @csrf
                <input type ="hidden" value ="{{ $detail['name'] }}" name ="shopName">
                <input type ="hidden" value ="{{ $detail['place_id'] }}" name ="placeId">
                <button type ="submit"　 value ="口コミ閲覧" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    口コミ閲覧
                </button>
            </form>
            <div id="image" class="relative w-full" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            @php
                $limit = 3; // 取得する回数の制限
                $counter = 0; // カウンターを初期化
            @endphp
            
            @foreach ($detail['photos'] as $photo)
                @if ($counter >= $limit)
                    @break
                @endif

                @php
                    $api_key = env('GOOGLE_PLACES_API_KEY');
                    $photoReference = $photo['photo_reference'];
                    $maxWidth = 400; // ここで写真の幅を指定します
                    $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photoReference&key=$api_key";
                @endphp
                         <!-- Item 1 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ $photoUrl }}" class="absolute block max-w-screen-xl h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="写真">
                        </div>
                @php
                    $counter++;
                @endphp
            @endforeach
                </div>
                
                               <!-- Slider controls -->
                <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-gray dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-gray dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
            
            
            
            <div id="map-{{ $loop->index }}" class="w-1/2 map p-4 h-auto max-w-lg rounded-lg mx-auto"  data-lat="{{ $detail['geometry']['location']['lat'] }}" data-lng="{{ $detail['geometry']['location']['lng']  }}" style="height: 400px;"></div>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&callback=initMap"></script>
            
        </ul>
        
        
    </li>
    </div>
    @endforeach
    
            
            <script>
            function initMap() {
                var maps = document.querySelectorAll('.map');
                maps.forEach(function(mapElem) {
                    var lat = parseFloat(mapElem.dataset.lat);
                    var lng = parseFloat(mapElem.dataset.lng);
                    var location = { lat: lat, lng: lng };
                    var map = new google.maps.Map(mapElem, {
                        zoom: 14,
                        center: location
                    });
                    var marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });
                });
            }
            </script>
            
           
            <a href="/">← 検索画面へ戻る</a>{{--詳細ページへ飛ぶリンクを作りたい--}}
       
            


<!--<a href='/reviews/create'>口コミ投稿</a>-->
                
                <!--他の詳細情報を表示 -->
                <!--カテゴリテーブルからの詳細な情報も入れたい、コンセントがあるなど-->
            
     
        
    </body>
</html>
</x-app-layout>