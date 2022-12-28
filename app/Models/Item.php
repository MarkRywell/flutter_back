<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsToMany(User::class);
    }

    protected $fillable = [
        'name',
        'details',
        'price',
        'userId',
        'sold',
        'picture',
        'soldTo'
    ];

    protected $primaryKey = 'id';
}
