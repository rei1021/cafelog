<!DOCTYPE html>
<x-app-layout>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('口コミ') }}
        </h2>
    </x-slot>    
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token,viewport" content="{{ csrf_token() }},width=device-width, initial-scale=1">
        <title>Blog</title>
        <!-- Fonts -->
        <!--元のフォント
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <link rel="stylesheet" href="{{ asset('/css/Like.css') }}" >
        
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBq6t-gvbsKpIoY-zy-KvG7qIZTG3QCdoY&libraries=places"></script>
 
{{-- ※以下は、@vite(['resources/css/app.css', 'resources/js/app.js'])の下に記述 --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>
   
    
    <!--口コミ-->
    <body>
<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
    <div class="reviews">
        <div class="grid gap-8 lg:grid-cols-2">
                @foreach ($reviews as $review)
                    @if ($review->place_id === $shopData['placeId'])
                      <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                          <div class="flex justify-between items-center mb-5 text-gray-500">
                              <span class="text-sm">作成日: {{ $review->created_at->format('Y/m/d') }}</span>
                          </div>
                            <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $review->title }}
                            </h2>
                            <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                            {{ $review->body }}
                            </p>
                            <div class="flex justify-between items-center">
                              <div class="flex items-center space-x-4 top-0 right-0 h-16 w-16">
                                  <span class="top-0 right-0 h-16 w-16font-medium dark:text-white">
                                    店舗評価{{ $review->rating }}/5
                                  </span>
                              </div>
                              @if($review->image_url)
                              <img class="h-auto max-w-xs" src="{{ $review->image_url }}" alt="写真">
                              @endif
                            </div>
                            
                            @if ($review->charger == 1)
                                    <p class="text-xs tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                                        コンセントあり
                                    </p>
                                    @endif 
                                    @if($review->morning == 1)
                                    <p class="text-xs tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                                        朝食メニューあり
                                    </p>
                                    @endif
                                    @if($review->lunch == 1)
                                    <p class="text-xs tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                                        ランチメニューあり
                                    </p>
                                    @endif    
                                    @if($review->dinner == 1)
                                    <p class="text-xs tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                                        ディナーメニューあり
                                    </p>
                                    @endif    
                                    @if($review->night == 1)
                                    <p class="text-xs tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                                        深夜営業あり
                                    </p>
                                    @endif    
                                    @if($review->pet == 1)
                                    <p class="text-xs tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                                        ペット連れ込み可
                                    </p>
                                    @endif
            
                                    <!--写真がない場合は写真という文字も消したい-->
                                @auth
                                <!-- Post.phpに作ったisLikedByメソッドをここで使用 -->
                                @if (!$review->isLikedBy(Auth::user()))
                                  <span class="likes">
                                  <i class="fas fa-heart like-toggle" data-review-id="{{ $review->id }}"></i>
                                  <span class="like-counter">{{$review->likes_count}}</span>
                                  </span><!-- /.likes -->
                                @else
                                  <span class="likes">
                                  <i class="fas fa-heart heart like-toggle liked" data-review-id="{{ $review->id }}"></i>
                                  <span class="like-counter">{{$review->likes_count}}</span>
                                  </span><!-- /.likes -->
                                 @endif
                                 @endauth
                                       
                                   <form action="/reviews/{{ $review->id }}" id="form_{{ $review->id }}" method="post">
                                   @csrf
                                   @method('DELETE')
                                   <button type="button" onclick="deletePost({{ $review->id }})">削除</button> 
                                   </form>
                                     @endif
                                    </article>
                               @endforeach 
                               </div>           
                            </div>
                            </div>
                        </section>
           <script>
       　　　　function deletePost(id) {
           　　　'use strict'
   
           　　　if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
               　　document.getElementById(`form_${id}`).submit();
           　　　}
       　　　　　}
   　　　　</script>
   　　　　</div>
   　　</section>
    </body>
</html>
</x-app-layout>