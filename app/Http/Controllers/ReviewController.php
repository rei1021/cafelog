<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Cloudinary;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\GooglePlaces;
use App\Models\Category;
use App\Providers\AppServiceProvider;
use App\Models\Wantgo;


class ReviewController extends Controller
{
    public function index(Review $review)//インポートしたPostをインスタンス化して$postとして使用。
    {
         return view('reviews.index',)->with(['reviews' => $review->getPeginateByLimit(10)]);//getPaginateByLimit()はPost.phpで定義したメソッドです。こうすることで１ページに表示する量を限定し、
    }
    
    
    public function show(Review $review)
    {
        return view('reviews.show')->with(['review' => $review->getPeginateByLimit(10)]);//ページを作る
    }
    
    public function create(Request $request)
    {
         return view('reviews.create')->with(['shopData' => $request->all()]);
    }
    
    public function relay(Review $review, Category $category)
    {
        return view('reviews.relay')->with([
            'reviews' => $review->getPeginateByLimit(10),
            'categories' => $category,
            
            ]);//ページを作る
    }
    
    
   
    //いいね機能
    public function like(Request $request)
    {
    $user_id = Auth::user()->id; // ログインしているユーザーのidを取得
    $review_id = $request->review_id; // 投稿のidを取得

    // すでにいいねがされているか判定するためにlikesテーブルから1件取得
    $already_liked = Like::where('user_id', $user_id)->where('review_id', $review_id)->first(); 

    if (!$already_liked) { 
        $like = new Like; // Likeクラスのインスタンスを作成
        $like->review_id = $review_id;
        $like->user_id = $user_id;
        $like->save();
    } else {
        // 既にいいねしてたらdelete 
        Like::where('review_id', $review_id)->where('user_id', $user_id)->delete();
    }
    // 投稿のいいね数を取得
    $review_likes_count = Review::withCount('likes')->findOrFail($review_id)->likes_count;
    $param = [
        'review_likes_count' => $review_likes_count,
    ];
    return response()->json($param); // JSONデータをjQueryに返す
    }
    
    
     public function shopShow(Request $request, Review $review)
    {
         return view('reviews.shopShow')->with([
             'reviews' => $review->getPeginateByLimit(10),
             'shopData' => $request->all()
             ]);
    }
    

    public function store(Review $review, ReviewRequest $request)
    {
    // レビュー情報を保存
    $categoryData = $request['categories'];
    $input = $request['review'];
    //dd($request);

    if ($request->file('image')) {
        $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        $input += ['image_url' => $image_url];
    }
    $review->user_id = auth()->id();
    $review->charger = $categoryData['charger'] ;
    $review->morning = $categoryData['morning'] ;
    $review->lunch = $categoryData['lunch'];
    $review->dinner = $categoryData['dinner'];
    $review->night = $categoryData['night'];
    $review->pet = $categoryData['pet'];
    $review->fill($input)->save();
    //dd($review);
    // カテゴリ情報を保存
    

    $category = Category::where('place_id', $categoryData['place_id'])->first();

    if (!$category) {
        // place_idが存在しない場合、新しいレコードを作成
        $category = new Category();
        $category->place_id = $categoryData['place_id'];
    }
    
    // カテゴリー情報の更新
    $category->charger = $categoryData['charger'] == 1 ? 1 : 0;
    $category->morning = $categoryData['morning'] == 1 ? 1 : 0;
    $category->lunch = $categoryData['lunch'] == 1 ? 1 : 0;
    $category->dinner = $categoryData['dinner'] == 1 ? 1 : 0;
    $category->night = $categoryData['night'] == 1 ? 1 : 0;
    $category->pet = $categoryData['pet'] == 1 ? 1 : 0;
    // カテゴリー情報を保存
    $category->save();
        /*$category->charger=$categoryData['charger'];
        $category->morning=$categoryData['morning'];
        $category->lunch=$categoryData['lunch'];
        $category->dinner=$categoryData['dinner'];
        $category->night=$categoryData['night'];
        $category->pet=$categoryData['pet'];
        $category->place_id=$input['place_id'];
        $category->fill($input)->save(); */// レビューとカテゴリを関連付けて保存
        //dd($category);
    return redirect('/')->with('success', '口コミが保存されました');
    }


    public function edit(Review $review)
    {
    return view('reviews.edit')->with(['review' => $review]);
    }
    
    public function update(ReviewRequest $request, Review $review)
    {
    $input_review = $request['review'];
    $review->fill($input_review)->save();

    return redirect('/reviews/' . $review->id);
    }
    
    public function delete(Review $review)
    {
    $review->delete();
    return redirect('/review/relay');
    }

}