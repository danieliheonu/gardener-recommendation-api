<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gardener extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'country',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->hasMany(Customer::class);
    }

}
