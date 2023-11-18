<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wantgo;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


class WantgoController extends Controller
{
    public function saveShop(Request $request)
    {
    $user_id = Auth::user()->id; // ログインしているユーザーのidを取得
    $place_id = $request->place_id; // お店のid (place_id) を取得

    // すでに保存しているか判定するためにshop_savesテーブルから1件取得
    $already_saved = Wantgo::where('user_id', $user_id)->where('place_id', $place_id)->first();

    if (!$already_saved) {
        $wantgo = new Wantgo; // ShopSaveクラスのインスタンスを作成
        $wantgo->place_id = $place_id;
        $wantgo->user_id = $user_id;
        $wantgo->save();
    } else {
        // 既に保存していたらdelete
        Wantgo::where('place_id', $place_id)->where('user_id', $user_id)->delete();
    }

    return response()->json(['message' => 'お店を保存しました']);
    }

}