$(function () {
    let saveShopButtons = $('.shops-save'); // save-shopクラスを持つボタンを取得し代入。
    let saveShopPlaceId; // 変数を宣言

    saveShopButtons.on('click', function () {
        let $this = $(this); // クリックされたボタンを代入
        saveShopPlaceId = $this.data('place-id'); // ボタンに仕込んだdata-place-idの値を取得

        // Ajax処理スタート
            $.ajax({
            headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
              'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
            url: '/shops/save', //通信先アドレスで、このURLをあとでルートで設定します
            method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
            data: { //サーバーに送信するデータ
              'place_id': saveShopPlaceId //いいねされた投稿のidを送る
            },
          })
        // 通信成功した時の処理
        .done(function (data) {
            console.log('success');
            $this.toggleClass('saved'); // savedクラスのON/OFF切り替え
            // 適切な方法で保存したお店の件数を更新する処理を追加
        })
        // 通信失敗した時の処理
        .fail(function () {
            console.log('fail');
        });
    });
});