<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;//論理削除になる


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;//論理削除になる

    protected $table = 'categories';
    protected $fillable = [
    'charger',
    'morning',
    'lunch',
    'dinner',
    'night',
    'pet'
    
    ];

}
