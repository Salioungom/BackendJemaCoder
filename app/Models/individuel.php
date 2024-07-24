<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class individuel extends Model
{
    use HasFactory;
    protected $guarder=[];
    public function hackathon(){
        return $this->belongsTo(hackathon::class,'id');
    }
    public function soumission(){
        return $this->hasMany(Soumissions::class, 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'id');
    }
}
