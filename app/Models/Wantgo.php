<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wantgo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'place_id'
        ];
        
        
    public function isSavedBy($user): bool {
    return Like::where('user_id', $user->id)->where('place_id', $this->id)->first() !==null;
    }
    
        public function post()
    {
        return $this->belongsTo(Wantgo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
