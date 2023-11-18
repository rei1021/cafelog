<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;//論理削除になる


class Review extends Model
{
    use HasFactory;
    use SoftDeletes;//論理削除になる

    protected $table = 'reviews';
    protected $fillable = [
    'title',
    'body',
    'image_url',
    'deleted_at',
    'rating',
    'user_id',
    'place_id',
    'shopName'
    
];

    public function getPeginateBylimit(int $limit_count = 10)
    {
        return $this->withCount('likes')->orderby('updated_at','DESC')->paginate($limit_count);
    }
    
    public function likes()
    {
    return $this->hasMany('App\Models\Like');
    }
    
    // showで使う、いいねされているかを判定するメソッド。
    public function isLikedBy($user): bool {
    return Like::where('user_id', $user->id)->where('review_id', $this->id)->first() !==null;
    }
    
    public function categories()
    {
        return $this->hasMany(Category::class, 'place_id', 'place_id')->withTrashed();
    }
}