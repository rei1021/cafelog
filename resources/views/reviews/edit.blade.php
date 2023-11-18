<head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title></title>
        <!-- Fonts -->
        <!--元のフォント
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

{{-- ※以下は、@vite(['resources/css/app.css', 'resources/js/app.js'])の下に記述 --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>
<!-- body内だけを表示しています。 -->
<body>
    <h1 class="title">編集画面</h1>
    <div class="content">
        <form action="/reviews/{{ $review->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class='content__title'>
                <h2>タイトル</h2>
                <input type='text' name='review[title]' value="{{ $review->title }}">
            </div>
            <div class='content__body'>
                <h2>口コミ本文</h2>
                <input type='text' name='review[body]' value="{{ $review->body }}">
            </div>
            <input type="submit" value="保存">
        </form>
    </div>
</body>