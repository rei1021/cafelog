    <!DOCTYPE HTML>
<x-app-layout>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <title>Blog</title>
    </head>
    <body>
        <li>
  <div class="container mx-auto my-4 px-4 border border-black-500">           
@vite(['resources/css/app.css','resources/js/app.js'])        
        <!--入力フォーム-->
        <h2 class="text-center text-3xl font-bold text-gray-900 dark:text-white">
            {{$shopData['shopName']}}
        </h2>
            
        <form action="/reviews/" method="POST" enctype="multipart/form-data"> <!-- show.blade に飛ぶ -->
            @csrf
            <div class="title">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    タイトル
                    </label>
                <input type="text" id="title" name="review[title]" placeholder="タイトルを入れてください" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <!--上と同じような書き方でカテゴリーテーブルのものも書く-->
            <div class="body">
                <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    口コミ本文
                </label>
                <input type="text" id="body" name="review[body]" placeholder="口コミ本文を入れてください (4000文字まで)" class="block w-full p-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <!-- 以下の文で写真投稿 -->
            <div class="rating">
                <h5>5段階評価</h5>
                <select name="review[rating]">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
    <!--<input type="submit" value="評価する"/>-->
                
                <div class="flex items-center justify-center w-full">
                    <label for="file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">クリックしてアップロードするか</span> ファイルをドラッグしてください</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input type="file" name="image" id="file" class="hidden">
                    </label>
                </div>

                
                <input type="hidden" name="review[place_id]" value="{{$shopData['placeId']}}">
                <!--ユーザーidを取得したい<input type="hidden" name="review[user_id]" value="user_id">-->
                <input type="hidden" name="review[shopName]" value="{{$shopData['shopName']}}">
                
                <!--以下カテゴリーテーブルに保存-->
                
                <div class="charger">
                 <input type="hidden" name="categories[charger]" value="0">
                 <input type="checkbox" name="categories[charger]" value="1" {{ old('categories.charger') == '1' ? 'checked' : '' }}>
                 <label for="categories[charger]">コンセントあり</label>
                </div>
                <div class="morning">
                 <input type="hidden" name="categories[morning]" value="0">
                 <input type="checkbox" name="categories[morning]" value="1" {{ old('categories.morning') == '1' ? 'checked' : '' }}>
                 <label for="categories[morning]">モーニングメニュー</label>
                </div>
                <div class="lunch">
                 <input type="hidden" name="categories[lunch]" value="0">
                 <input type="checkbox" name="categories[lunch]" value="1" {{ old('categories.lunch') == '1' ? 'checked' : '' }}>
                 <label for="categories[lunch]">ランチメニュー</label>
                </div>
                <div class="dinner">
                 <input type="hidden" name="categories[dinner]" value="0">
                 <input type="checkbox" name="categories[dinner]" value="1" {{ old('categories.dinner') == '1' ? 'checked' : '' }}>
                 <label for="categories[dinner]">ディナーメニュー</label>
                </div>
                <div class="night">
                 <input type="hidden" name="categories[night]" value="0">
                 <input type="checkbox" name="categories[night]" value="1" {{ old('categories.night') == '1' ? 'checked' : '' }}>
                 <label for="categories[night]">深夜営業</label>
                </div>
                <div class="pet">
                 <input type="hidden" name="categories[pet]" value="0">
                 <input type="checkbox" name="categories[pet]" value="1" {{ old('categories.pet') == '1' ? 'checked' : '' }}>
                 <label for="categories[pet]">ペット連れ込み可</label>
                </div>
                <input type="hidden" name="categories[place_id]" value="{{$shopData['placeId']}}">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    投稿
                </button>
            </div>
        </form>
        
        
            
            
        <div class="footer">
            <a href="/">←検索画面へ戻る</a>{{--詳細ページへ飛ぶリンクを作りたい--}}
        </div>
            <!--以下categoriesてえーブルに保存-->
            
        
        <li>
    </body>
    </div>
</html>
</x-app-layout>